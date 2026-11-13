<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center gap-3">
            <div><h2 class="font-bold text-2xl text-white">Detalle del asiento {{ $entry->entry_code }}</h2>
            <p class="text-xs text-slate-400 mt-1">{{ $company->name }}</p></div>
            <a href="{{ route('journal.index') }}" class="text-sm text-slate-300">← Libro Diario</a>
        </div>
    </x-slot>
    <div class="py-8 bg-slate-950 min-h-screen text-slate-100">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-slate-900 border border-slate-800 rounded-2xl p-6 space-y-5">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div><p class="text-xs text-slate-500">Código de asiento</p><p class="text-xl font-bold text-emerald-300">{{ $entry->entry_code }}</p></div>
                    <div><p class="text-xs text-slate-500">Fecha</p><p class="font-semibold">{{ $entry->date->format('d/m/Y') }}</p></div>
                    <div><p class="text-xs text-slate-500">Tipo</p><p class="font-semibold">{{ $entry->type === 'apertura' ? 'Asiento de apertura' : 'Asiento diario' }}</p></div>
                </div>
                <div><p class="text-xs text-slate-500">Glosa</p><p class="font-semibold">{{ $entry->description }}</p></div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="text-xs uppercase text-slate-500 border-b border-slate-700">
                            <tr><th class="text-left py-3">Fecha</th><th class="text-left">Detalle</th><th class="text-left">Folio</th><th class="text-right">Debe</th><th class="text-right">Haber</th></tr>
                        </thead>
                        <tbody class="divide-y divide-slate-800">
                            @foreach($entry->lines as $line)
                                <tr>
                                    <td class="py-3">{{ $entry->date->format('d/m/Y') }}</td>
                                    <td>{{ $line->account->name }}@if($line->description)<div class="text-xs text-slate-500">{{ $line->description }}</div>@endif</td>
                                    <td class="text-emerald-300">{{ $line->account->code }}</td>
                                    <td class="text-right">{{ number_format((float)$line->debit,2,',','.') }}</td>
                                    <td class="text-right">{{ number_format((float)$line->credit,2,',','.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="border-t border-slate-700 font-bold">
                            <tr><td colspan="3" class="py-3 text-right">TOTALES</td>
                            <td class="text-right">{{ number_format($entry->lines->sum(fn($l)=>(float)$l->debit),2,',','.') }}</td>
                            <td class="text-right">{{ number_format($entry->lines->sum(fn($l)=>(float)$l->credit),2,',','.') }}</td></tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
