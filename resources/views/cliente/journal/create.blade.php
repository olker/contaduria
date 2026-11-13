<x-app-layout>
    @php
        $journalAccountGroupsJson = [];
        foreach ($accountGroups as $typeLabel => $sections) {
            foreach ($sections as $sectionLabel => $sectionAccounts) {
                $groupItems = [];
                foreach ($sectionAccounts as $account) {
                    $groupItems[] = [
                        'id' => $account->id,
                        'code' => $account->code,
                        'name' => trim($account->name),
                    ];
                }
                $journalAccountGroupsJson[] = [
                    'label' => $typeLabel . ' — ' . $sectionLabel,
                    'accounts' => $groupItems,
                ];
            }
        }
    @endphp
    <x-slot name="header">
        <div class="flex justify-between items-center gap-3">
            <div><h2 class="font-bold text-2xl text-white">Nuevo asiento del Libro Diario</h2>
            <p class="text-xs text-slate-400 mt-1">{{ $company->name }} · Gestión {{ $company->fiscal_period }}</p></div>
            <a href="{{ route('journal.index') }}" class="text-sm text-slate-300">← Volver</a>
        </div>
    </x-slot>
    <div class="py-8 bg-slate-950 min-h-screen text-slate-100">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <form method="POST" action="{{ route('journal.store') }}" id="journal-form" class="space-y-6">
                @csrf
                @if($errors->any())
                    <div class="bg-red-950 border border-red-800 text-red-300 p-4 rounded-xl text-sm">
                        <strong>Corrige los siguientes errores:</strong>
                        <ul class="list-disc pl-5 mt-2">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                    </div>
                @endif
                <div class="bg-slate-900 border border-slate-800 rounded-2xl p-5 grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs text-slate-400 mb-2">Fecha del asiento</label>
                        <input type="date" name="date" value="{{ old('date', $company->fiscal_period . '-01-01') }}" required
                               class="w-full rounded-lg bg-slate-950 border-slate-700 text-white">
                    </div>
                    <div>
                        <label class="block text-xs text-slate-400 mb-2">Glosa / Concepto del asiento</label>
                        <input type="text" name="description" value="{{ old('description') }}" maxlength="255" required
                               placeholder="Ej. Compra de mercaderías al contado"
                               class="w-full rounded-lg bg-slate-950 border-slate-700 text-white">
                    </div>
                </div>

                <div class="bg-slate-900 border border-slate-800 rounded-2xl p-5 space-y-4">
                    <div class="flex justify-between items-center gap-3">
                        <div><h3 class="font-bold">Detalle contable</h3><p class="text-xs text-slate-400">Selecciona las cuentas y registra Debe o Haber. En el Libro Diario una cuenta puede utilizar cualquiera de los dos lados.</p></div>
                        <button type="button" id="add-journal-line" class="px-3 py-2 rounded-lg bg-indigo-600 text-sm font-semibold">+ Agregar línea</button>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full min-w-[850px] text-sm">
                            <thead class="text-xs uppercase text-slate-500 border-b border-slate-700">
                                <tr><th class="text-left py-3 pr-2">Cuenta contable</th><th class="text-left px-2">Detalle</th><th class="text-right px-2">Debe</th><th class="text-right px-2">Haber</th><th></th></tr>
                            </thead>
                            <tbody id="journal-lines" class="divide-y divide-slate-800">
                                @for($i=0;$i<2;$i++)
                                    <tr>
                                        <td class="py-3 pr-2">
                                            <select name="lines[{{ $i }}][account_id]" required class="journal-account w-full bg-slate-950 border-slate-700 rounded-lg text-xs text-white">
                                                <option value="">Selecciona una cuenta</option>
                                                @foreach($accountGroups as $typeLabel => $sections)
                                                    @foreach($sections as $sectionLabel => $sectionAccounts)
                                                        <optgroup label="{{ $typeLabel }} — {{ $sectionLabel }}">
                                                            @foreach($sectionAccounts as $account)
                                                                <option value="{{ $account->id }}" {{ old('lines.'.$i.'.account_id') == $account->id ? 'selected' : '' }}>{{ $account->code }} — {{ trim($account->name) }}</option>
                                                            @endforeach
                                                        </optgroup>
                                                    @endforeach
                                                @endforeach
                                            </select>
                                        </td>
                                        <td class="px-2 py-3"><input name="lines[{{ $i }}][description]" value="{{ old('lines.'.$i.'.description') }}" class="w-full bg-slate-950 border-slate-700 rounded-lg text-xs text-white" placeholder="Detalle (opcional)"></td>
                                        <td class="px-2 py-3"><input type="number" name="lines[{{ $i }}][debit]" value="{{ old('lines.'.$i.'.debit', '0.00') }}" min="0" step="0.01" required class="journal-money debit w-32 bg-slate-950 border-slate-700 rounded-lg text-right text-white"></td>
                                        <td class="px-2 py-3"><input type="number" name="lines[{{ $i }}][credit]" value="{{ old('lines.'.$i.'.credit', '0.00') }}" min="0" step="0.01" required class="journal-money credit w-32 bg-slate-950 border-slate-700 rounded-lg text-right text-white"></td>
                                        <td class="px-2 py-3"><button type="button" class="remove-line text-red-400">Eliminar</button></td>
                                    </tr>
                                @endfor
                            </tbody>
                        </table>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                        <div class="bg-slate-950 rounded-xl p-4"><span class="text-xs text-slate-400">Total Debe</span><strong id="journal-debit-total" class="block text-xl mt-1">0,00</strong></div>
                        <div class="bg-slate-950 rounded-xl p-4"><span class="text-xs text-slate-400">Total Haber</span><strong id="journal-credit-total" class="block text-xl mt-1">0,00</strong></div>
                        <div class="bg-slate-950 rounded-xl p-4"><span class="text-xs text-slate-400">Diferencia</span><strong id="journal-difference" class="block text-xl mt-1 text-amber-300">0,00</strong></div>
                    </div>
                    <p id="journal-balance-message" class="text-sm text-amber-300">Completa las líneas para comprobar el asiento.</p>
                </div>
                <div class="flex justify-end gap-3">
                    <a href="{{ route('journal.index') }}" class="px-5 py-3 rounded-lg bg-slate-800 text-sm">Cancelar</a>
                    <button id="save-journal" type="submit" disabled class="px-6 py-3 rounded-lg bg-indigo-600 disabled:opacity-40 disabled:cursor-not-allowed text-sm font-bold">Guardar asiento</button>
                </div>
            </form>
        </div>
    </div>

    <script>
    (function(){
        const tbody=document.getElementById('journal-lines');
        const add=document.getElementById('add-journal-line');
        const save=document.getElementById('save-journal');
        let nextIndex=2;
        const groups = @json($journalAccountGroupsJson);
        function money(v){return Number(v||0);}
        function fmt(v){return v.toLocaleString('es-BO',{minimumFractionDigits:2,maximumFractionDigits:2});}
        function update(){
            let d=0,c=0,valid=true;
            tbody.querySelectorAll('tr').forEach(row=>{
                const debit=money(row.querySelector('.debit').value);
                const credit=money(row.querySelector('.credit').value);
                if(debit>0&&credit>0) valid=false;
                if(debit===0&&credit===0) valid=false;
                d+=debit;c+=credit;
            });
            const diff=Math.round((d-c)*100)/100;
            document.getElementById('journal-debit-total').textContent=fmt(d);
            document.getElementById('journal-credit-total').textContent=fmt(c);
            document.getElementById('journal-difference').textContent=fmt(Math.abs(diff));
            const balanced=Math.abs(diff)<0.005 && d>0 && valid;
            document.getElementById('journal-balance-message').textContent=balanced?'Asiento cuadrado. Puedes guardar.':'El asiento debe tener importes en un solo lado por línea y Debe igual a Haber.';
            document.getElementById('journal-balance-message').className=balanced?'text-sm text-emerald-300':'text-sm text-amber-300';
            save.disabled=!balanced;
        }
        function addRow(){
            const tr=document.createElement('tr');
            let options='<option value="">Selecciona una cuenta</option>';
            groups.forEach(group=>{
                options+='<optgroup label="'+group.label.replace(/"/g,'&quot;')+'">';
                group.accounts.forEach(a=>{options+='<option value="'+a.id+'">'+a.code+' — '+a.name.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/"/g,'&quot;')+'</option>';});
                options+='</optgroup>';
            });
            tr.innerHTML='<td class="py-3 pr-2"><select name="lines['+nextIndex+'][account_id]" required class="journal-account w-full bg-slate-950 border-slate-700 rounded-lg text-xs text-white">'+options+'</select></td>'+
                '<td class="px-2 py-3"><input name="lines['+nextIndex+'][description]" class="w-full bg-slate-950 border-slate-700 rounded-lg text-xs text-white" placeholder="Detalle (opcional)"></td>'+
                '<td class="px-2 py-3"><input type="number" name="lines['+nextIndex+'][debit]" value="0.00" min="0" step="0.01" required class="journal-money debit w-32 bg-slate-950 border-slate-700 rounded-lg text-right text-white"></td>'+
                '<td class="px-2 py-3"><input type="number" name="lines['+nextIndex+'][credit]" value="0.00" min="0" step="0.01" required class="journal-money credit w-32 bg-slate-950 border-slate-700 rounded-lg text-right text-white"></td>'+
                '<td class="px-2 py-3"><button type="button" class="remove-line text-red-400">Eliminar</button></td>';
            tbody.appendChild(tr);nextIndex++;update();
        }
        add.addEventListener('click',addRow);
        tbody.addEventListener('input',update);
        tbody.addEventListener('click',e=>{
            if(e.target.classList.contains('remove-line')){
                if(tbody.querySelectorAll('tr').length>2){e.target.closest('tr').remove();update();}
            }
        });
        update();
    })();
    </script>
</x-app-layout>
