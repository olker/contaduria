<x-app-layout>
    @php
        $openingAccountOptions = [];
        foreach ($accountGroups as $typeLabel => $sections) {
            foreach ($sections as $sectionLabel => $sectionAccounts) {
                foreach ($sectionAccounts as $account) {
                    $openingAccountOptions[] = [
                        'id' => $account->id,
                        'label' => $account->code . ' — ' . trim($account->name),
                        'name' => trim($account->name),
                        'group_type' => $account->group_type,
                        'section_label' => $typeLabel . ' — ' . $sectionLabel,
                    ];
                }
            }
        }
        $openingAccountCatalog = $openingAccountOptions;
    @endphp
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
            <div>
                <h2 class="font-bold text-2xl text-white tracking-tight">Registrar Libro de Apertura</h2>
                <p class="text-xs text-slate-400 mt-1">{{ $company->name }} · Gestión {{ $company->fiscal_period }}</p>
            </div>
            <a href="{{ route('opening.index') }}" class="text-sm text-slate-300 hover:text-white">← Volver al Libro de Apertura</a>
        </div>
    </x-slot>

    <div class="py-10 bg-slate-950 min-h-[calc(100vh-8rem)] text-slate-100">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <form method="POST" action="{{ route('opening.store') }}" id="opening-form" class="space-y-6">
                @csrf

                @if ($errors->any())
                    <div class="bg-red-950/80 border border-red-800 text-red-300 p-4 rounded-xl text-sm">
                        <p class="font-semibold mb-2">No se pudo registrar el asiento:</p>
                        <ul class="list-disc pl-5 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif


                <div class="bg-slate-900 border border-indigo-800/60 rounded-2xl p-6 space-y-4">
                    <div>
                        <h3 class="text-lg font-bold text-white">Llenar formulario desde una fotografía</h3>
                        <p class="text-xs text-slate-400 mt-1">
                            Sube una imagen del balance. El reconocimiento solo llenará el formulario; no guardará ningún dato.
                            Revisa y corrige las cuentas e importes antes de guardar.
                        </p>
                    </div>
                    <div class="flex flex-col sm:flex-row gap-3 sm:items-end">
                        <div class="flex-1">
                            <label for="opening-image" class="block text-xs font-semibold text-slate-300 mb-2">Fotografía del balance (JPG o PNG)</label>
                            <input type="file" id="opening-image" accept="image/jpeg,image/png,image/webp"
                                   class="block w-full text-sm text-slate-300 file:mr-3 file:rounded-lg file:border-0 file:bg-slate-700 file:px-4 file:py-2 file:text-slate-100 hover:file:bg-slate-600">
                        </div>
                        <button type="button" id="recognize-image"
                                class="bg-indigo-600 hover:bg-indigo-500 disabled:opacity-50 text-white font-semibold text-sm px-5 py-3 rounded-lg">
                            Reconocer fotografía
                        </button>
                    </div>
                    <div id="ocr-progress" class="hidden text-sm text-indigo-200"></div>
                    <div id="ocr-error" class="hidden text-sm text-amber-300"></div>
                    <div id="ocr-preview-wrap" class="hidden">
                        <p class="text-xs text-slate-400 mb-2">Imagen seleccionada (solo vista previa)</p>
                        <img id="ocr-preview" alt="Vista previa del balance" class="max-h-80 max-w-full rounded-lg border border-slate-700 object-contain">
                    </div>
                    <p class="text-[11px] text-slate-500">
                        El reconocimiento se realiza en tu navegador mediante OCR. Necesitas conexión a Internet la primera vez para cargar el motor y el idioma español.
                    </p>
                </div>

                <div class="bg-slate-900 border border-slate-800 rounded-2xl p-6 grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label for="date" class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-2">Fecha del asiento *</label>
                        <input type="date" id="date" name="date" value="{{ old('date', $company->fiscal_period . '-01-01') }}" required
                               class="w-full bg-slate-950 border border-slate-700 rounded-lg px-4 py-3 text-slate-100 text-sm focus:outline-none focus:border-indigo-500">
                        <p class="text-[11px] text-slate-500 mt-1">Debe corresponder a la gestión {{ $company->fiscal_period }}.</p>
                    </div>
                    <div>
                        <label for="description" class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-2">Glosa / Descripción *</label>
                        <input type="text" id="description" name="description" value="{{ old('description', 'Asiento de apertura de la gestión ' . $company->fiscal_period) }}" maxlength="255" required
                               class="w-full bg-slate-950 border border-slate-700 rounded-lg px-4 py-3 text-slate-100 text-sm focus:outline-none focus:border-indigo-500">
                    </div>
                </div>

                <div class="bg-slate-900 border border-slate-800 rounded-2xl p-6 space-y-5">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                        <div>
                            <h3 class="text-lg font-bold text-white">Detalle de saldos iniciales</h3>
                            <p class="text-xs text-slate-400 mt-1">Selecciona cuentas auxiliares del Activo, Pasivo o Patrimonio.</p>
                        </div>
                        <button type="button" id="add-line" class="bg-slate-800 hover:bg-slate-700 border border-slate-700 text-slate-200 text-xs font-semibold px-4 py-2.5 rounded-lg">
                            + Agregar cuenta
                        </button>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full min-w-[760px] text-sm">
                            <thead class="text-[11px] uppercase tracking-wider text-slate-500 border-b border-slate-800">
                                <tr>
                                    <th class="text-left py-3 pr-3 w-[42%]">Cuenta contable</th>
                                    <th class="text-left py-3 px-2">Detalle (opcional)</th>
                                    <th class="text-right py-3 px-2 w-36">Debe</th>
                                    <th class="text-right py-3 px-2 w-36">Haber</th>
                                    <th class="py-3 pl-2 w-12"></th>
                                </tr>
                            </thead>
                            <tbody id="opening-lines" class="divide-y divide-slate-800">
                                @for ($i = 0; $i < 2; $i++)
                                    <tr class="opening-line">
                                        <td class="py-3 pr-3">
                                            <select name="lines[{{ $i }}][account_id]" required class="account-select w-full bg-slate-950 border border-slate-700 rounded-lg px-3 py-2.5 text-slate-100 text-xs focus:outline-none focus:border-indigo-500">
                                                <option value="">Selecciona una cuenta</option>
                                                @foreach ($accountGroups as $typeLabel => $sections)
                                                    @foreach ($sections as $sectionLabel => $sectionAccounts)
                                                        <optgroup label="{{ $typeLabel }} — {{ $sectionLabel }}">
                                                            @foreach ($sectionAccounts as $account)
                                                                <option value="{{ $account->id }}" data-group="{{ $account->group_type }}" {{ old('lines.' . $i . '.account_id') == $account->id ? 'selected' : '' }}>
                                                                    {{ $account->code }} — {{ trim($account->name) }}
                                                                </option>
                                                            @endforeach
                                                        </optgroup>
                                                    @endforeach
                                                @endforeach
                                            </select>
                                        </td>
                                        <td class="py-3 px-2">
                                            <input type="text" name="lines[{{ $i }}][description]" value="{{ old('lines.' . $i . '.description') }}" maxlength="500" placeholder="Ej. saldo según inventario"
                                                   class="w-full bg-slate-950 border border-slate-700 rounded-lg px-3 py-2.5 text-slate-100 text-xs focus:outline-none focus:border-indigo-500">
                                        </td>
                                        <td class="py-3 px-2">
                                            <input type="number" name="lines[{{ $i }}][debit]" value="{{ old('lines.' . $i . '.debit', '0.00') }}" min="0" step="0.01" required
                                                   class="amount-input w-full bg-slate-950 border border-slate-700 rounded-lg px-3 py-2.5 text-right text-slate-100 text-xs focus:outline-none focus:border-indigo-500">
                                        </td>
                                        <td class="py-3 px-2">
                                            <input type="number" name="lines[{{ $i }}][credit]" value="{{ old('lines.' . $i . '.credit', '0.00') }}" min="0" step="0.01" required
                                                   class="amount-input w-full bg-slate-950 border border-slate-700 rounded-lg px-3 py-2.5 text-right text-slate-100 text-xs focus:outline-none focus:border-indigo-500">
                                        </td>
                                        <td class="py-3 pl-2 text-center">
                                            <button type="button" class="remove-line text-slate-500 hover:text-red-400" title="Quitar línea" disabled>✕</button>
                                        </td>
                                    </tr>
                                @endfor
                            </tbody>
                        </table>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="bg-slate-950 rounded-xl p-4">
                            <p class="text-xs text-slate-500">Total Debe</p>
                            <p id="total-debit" class="text-xl font-bold text-white mt-1">{{ $company->currency }} 0,00</p>
                        </div>
                        <div class="bg-slate-950 rounded-xl p-4">
                            <p class="text-xs text-slate-500">Total Haber</p>
                            <p id="total-credit" class="text-xl font-bold text-white mt-1">{{ $company->currency }} 0,00</p>
                        </div>
                    </div>
                    <p id="balance-status" class="text-xs text-amber-300">Ingresa los importes para comprobar el equilibrio del asiento.</p>
                </div>

                <div class="bg-indigo-950/40 border border-indigo-900/70 rounded-xl p-4 text-xs text-indigo-200">
                    <strong>Importante:</strong> el total del Debe debe ser exactamente igual al total del Haber. El sistema no permitirá guardar un asiento descuadrado.
                    Los importes deben reflejar los saldos reales de la empresa; no registres capital como diferencia sin verificar primero los activos y pasivos.
                </div>

                <div class="flex flex-col sm:flex-row gap-3">
                    <a href="{{ route('opening.index') }}" class="sm:w-1/3 text-center bg-slate-800 hover:bg-slate-700 text-slate-200 font-medium py-3 px-4 rounded-lg text-sm">Cancelar</a>
                    <button type="submit" id="save-opening" disabled
                            class="sm:flex-1 bg-slate-700 text-slate-400 font-semibold py-3 px-4 rounded-lg text-sm shadow-lg cursor-not-allowed">
                        Guardar Libro de Apertura
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        (function () {
            const tbody = document.getElementById('opening-lines');
            const addButton = document.getElementById('add-line');
            const totalDebit = document.getElementById('total-debit');
            const totalCredit = document.getElementById('total-credit');
            const status = document.getElementById('balance-status');
            const submitButton = document.getElementById('save-opening');
            const currency = @json($company->currency);
            const accountOptions = @json($openingAccountOptions);

            let nextIndex = 2;

            function applyAccountSide(row) {
                const select = row.querySelector('.account-select');
                const inputs = row.querySelectorAll('.amount-input');
                const debitInput = inputs[0];
                const creditInput = inputs[1];
                const selected = select.options[select.selectedIndex];
                const group = selected ? (selected.dataset.group || '') : '';

                // Sin cuenta seleccionada, ambos campos quedan bloqueados.
                const isAsset = group === 'activo';
                const isCreditGroup = group === 'pasivo' || group === 'patrimonio';

                debitInput.readOnly = !(isAsset);
                creditInput.readOnly = !(isCreditGroup);

                debitInput.classList.toggle('opacity-40', !isAsset);
                debitInput.classList.toggle('cursor-not-allowed', !isAsset);
                creditInput.classList.toggle('opacity-40', !isCreditGroup);
                creditInput.classList.toggle('cursor-not-allowed', !isCreditGroup);

                debitInput.title = isAsset
                    ? 'Las cuentas de Activo se registran en el Debe.'
                    : 'Solo las cuentas de Activo permiten registrar importes en Debe.';
                creditInput.title = isCreditGroup
                    ? 'Las cuentas de Pasivo y Patrimonio se registran en el Haber.'
                    : 'Solo las cuentas de Pasivo y Patrimonio permiten registrar importes en Haber.';

                if (row.dataset.pendingAmount && (isAsset || isCreditGroup)) {
                    const pending = Number(row.dataset.pendingAmount);
                    if (isAsset) debitInput.value = pending.toFixed(2);
                    if (isCreditGroup) creditInput.value = pending.toFixed(2);
                    delete row.dataset.pendingAmount;
                }

                if (!isAsset) debitInput.value = '0.00';
                if (!isCreditGroup) creditInput.value = '0.00';
            }

            // Compartir la función con el módulo OCR, que está en otro bloque script.
            window.applyOpeningAccountSide = applyAccountSide;

            function numberValue(input) {
                const value = parseFloat(input.value);
                return Number.isFinite(value) && value > 0 ? Math.round(value * 100) : 0;
            }

            function updateTotals() {
                let debit = 0;
                let credit = 0;

                tbody.querySelectorAll('tr').forEach((row) => {
                    const inputs = row.querySelectorAll('.amount-input');
                    debit += numberValue(inputs[0]);
                    credit += numberValue(inputs[1]);
                });

                totalDebit.textContent = currency + ' ' + (debit / 100).toLocaleString('es-BO', { minimumFractionDigits: 2 });
                totalCredit.textContent = currency + ' ' + (credit / 100).toLocaleString('es-BO', { minimumFractionDigits: 2 });

                const balanced = debit > 0 && debit === credit;
                submitButton.disabled = !balanced;

                if (balanced) {
                    status.textContent = '✓ El asiento está cuadrado. Puedes guardar el Libro de Apertura.';
                    status.className = 'text-xs text-emerald-300';
                    submitButton.className = 'sm:flex-1 bg-indigo-600 hover:bg-indigo-500 text-white font-semibold py-3 px-4 rounded-lg text-sm shadow-lg';
                } else {
                    status.textContent = 'No puedes guardar: el total del Debe y el Haber deben ser iguales y mayores que cero.';
                    status.className = 'text-xs text-amber-300';
                    submitButton.className = 'sm:flex-1 bg-slate-700 text-slate-400 font-semibold py-3 px-4 rounded-lg text-sm shadow-lg cursor-not-allowed';
                }
            }

            function updateRemoveButtons() {
                const rows = tbody.querySelectorAll('tr');
                rows.forEach((row) => {
                    row.querySelector('.remove-line').disabled = rows.length <= 2;
                });
            }

            function addRow() {
                const row = document.createElement('tr');
                row.className = 'opening-line';
                const groupedOptions = {};
                accountOptions.forEach((account) => {
                    const groupLabel = account.section_label || account.group_type.toUpperCase();
                    if (!groupedOptions[groupLabel]) groupedOptions[groupLabel] = [];
                    groupedOptions[groupLabel].push(
                        '<option value="' + account.id + '" data-group="' + escapeHtml(account.group_type) + '">' +
                        escapeHtml(account.label) + '</option>'
                    );
                });
                const options = Object.entries(groupedOptions).map(([label, items]) =>
                    '<optgroup label="' + escapeHtml(label) + '">' + items.join('') + '</optgroup>'
                ).join('');

                row.innerHTML = `
                    <td class="py-3 pr-3">
                        <select name="lines[${nextIndex}][account_id]" required class="account-select w-full bg-slate-950 border border-slate-700 rounded-lg px-3 py-2.5 text-slate-100 text-xs focus:outline-none focus:border-indigo-500">
                            <option value="">Selecciona una cuenta</option>${options}
                        </select>
                    </td>
                    <td class="py-3 px-2">
                        <input type="text" name="lines[${nextIndex}][description]" maxlength="500" placeholder="Ej. saldo según inventario" class="w-full bg-slate-950 border border-slate-700 rounded-lg px-3 py-2.5 text-slate-100 text-xs focus:outline-none focus:border-indigo-500">
                    </td>
                    <td class="py-3 px-2">
                        <input type="number" name="lines[${nextIndex}][debit]" value="0.00" min="0" step="0.01" required class="amount-input w-full bg-slate-950 border border-slate-700 rounded-lg px-3 py-2.5 text-right text-slate-100 text-xs focus:outline-none focus:border-indigo-500">
                    </td>
                    <td class="py-3 px-2">
                        <input type="number" name="lines[${nextIndex}][credit]" value="0.00" min="0" step="0.01" required class="amount-input w-full bg-slate-950 border border-slate-700 rounded-lg px-3 py-2.5 text-right text-slate-100 text-xs focus:outline-none focus:border-indigo-500">
                    </td>
                    <td class="py-3 pl-2 text-center">
                        <button type="button" class="remove-line text-slate-500 hover:text-red-400" title="Quitar línea">✕</button>
                    </td>`;
                tbody.appendChild(row);
                applyAccountSide(row);
                nextIndex++;
                updateRemoveButtons();
            }

            function escapeHtml(value) {
                return String(value).replace(/[&<>"']/g, (character) => ({
                    '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;'
                }[character]));
            }

            addButton.addEventListener('click', addRow);

            tbody.addEventListener('change', (event) => {
                if (event.target.classList.contains('account-select')) {
                    applyAccountSide(event.target.closest('tr'));
                    updateTotals();
                }
            });

            tbody.querySelectorAll('tr').forEach((row) => applyAccountSide(row));

            tbody.addEventListener('input', updateTotals);
            tbody.addEventListener('change', updateTotals);
            tbody.addEventListener('click', (event) => {
                const button = event.target.closest('.remove-line');
                if (!button || button.disabled) return;
                button.closest('tr').remove();
                updateRemoveButtons();
                updateTotals();
            });

            updateRemoveButtons();
            updateTotals();
        })();
    </script>

    <script src="https://cdn.jsdelivr.net/npm/tesseract.js@5/dist/tesseract.min.js"></script>
    <script>
        (function () {
            const fileInput = document.getElementById('opening-image');
            const recognizeButton = document.getElementById('recognize-image');
            const progress = document.getElementById('ocr-progress');
            const errorBox = document.getElementById('ocr-error');
            const previewWrap = document.getElementById('ocr-preview-wrap');
            const preview = document.getElementById('ocr-preview');
            const tbody = document.getElementById('opening-lines');
            const addButton = document.getElementById('add-line');

            if (!fileInput || !recognizeButton || !tbody || !addButton) return;

            let selectedImage = null;

            fileInput.addEventListener('change', function () {
                const file = fileInput.files && fileInput.files[0];
                selectedImage = file || null;
                errorBox.classList.add('hidden');
                if (!file) {
                    previewWrap.classList.add('hidden');
                    return;
                }
                if (!['image/jpeg', 'image/png', 'image/webp'].includes(file.type)) {
                    selectedImage = null;
                    fileInput.value = '';
                    showError('Selecciona una imagen JPG, PNG o WEBP.');
                    return;
                }
                preview.src = URL.createObjectURL(file);
                previewWrap.classList.remove('hidden');
            });

            function showError(message) {
                errorBox.textContent = message;
                errorBox.classList.remove('hidden');
            }

            function normalize(text) {
                return String(text || '')
                    .normalize('NFD').replace(/[\u0300-\u036f]/g, '')
                    .toLowerCase()
                    .replace(/[^a-z0-9 ]/g, ' ')
                    .replace(/\s+/g, ' ')
                    .trim();
            }

            function parseAmount(value) {
                let s = String(value || '').replace(/[^\d.,]/g, '');
                if (!s) return null;

                // Balances bolivianos del ejemplo: 85.000.- / 800.- / 2.000,50
                if (s.includes(',') && /,\d{1,2}$/.test(s)) {
                    s = s.replace(/\./g, '').replace(',', '.');
                } else {
                    s = s.replace(/[.,]/g, '');
                }

                const n = Number(s);
                return Number.isFinite(n) && n > 0 && n <= 999999999999 ? n : null;
            }

            function extractRows(text) {
                const rows = [];
                const lines = String(text || '').split(/\r?\n/);
                const ignoredWords = [
                    'fecha', 'realizado', 'nit', 'balance de apertura', 'expresado',
                    'bolivianos', 'cochabamba', 'total activo', 'total pasivo',
                    'total debe', 'total haber', 'capital y reserva', 'gestion',
                    'año', 'ano', 'direccion', 'avenida'
                ];

                for (const rawLine of lines) {
                    const line = rawLine.replace(/\s+/g, ' ').trim();
                    if (!line) continue;

                    const normalizedLine = normalize(line);
                    if (ignoredWords.some(word => normalizedLine.includes(normalize(word)))) continue;
                    if (/\b(19|20)\d{2}\b/.test(line)) continue;
                    if (/^\s*\d{5,}\s*$/.test(line)) continue;

                    const match = line.match(/(?:^|\s)(\d{1,3}(?:[.,]\d{3})+(?:,\d{1,2})?|\d+(?:,\d{1,2})?)(?:\s*[-–—.]*)\s*$/);
                    if (!match) continue;

                    const amount = parseAmount(match[1]);
                    const accountText = line.slice(0, match.index).replace(/[\s:|]+$/g, '').trim();
                    const normalizedAccount = normalize(accountText);
                    const letterCount = (accountText.match(/[A-Za-zÁÉÍÓÚáéíóúÑñ]/g) || []).length;

                    if (!amount || letterCount < 4 || normalizedAccount.length < 4) continue;
                    if (/\d{4,}/.test(accountText)) continue;
                    if (/^\d+$/.test(normalizedAccount)) continue;
                    if (/^(total|sumas|activo|pasivo|capital|circulante|disponible|exigible|realizable|fijo)$/.test(normalizedAccount)) continue;

                    rows.push({ text: accountText, amount: amount });
                }
                return rows;
            }

            function matchAccount(text, accounts, side) {
                const wanted = normalize(text);
                if (!wanted) return null;

                let best = null;
                let bestScore = 0;
                for (const account of accounts) {
                    if (side === 'left' && account.group_type !== 'activo') continue;
                    if (side === 'right' && account.group_type === 'activo') continue;
                    const name = normalize(account.name);
                    if (!name) continue;

                    let score = 0;
                    if (wanted === name) score = 100;
                    else if (wanted.includes(name) || name.includes(wanted)) score = 85;
                    else {
                        const words = name.split(' ').filter(w => w.length > 2);
                        const matched = words.filter(w => wanted.includes(w)).length;
                        score = words.length ? (matched / words.length) * 70 : 0;
                    }

                    // Pequeñas equivalencias habituales en balances manuscritos/impresos.
                    const aliases = {
                        'caja moneda nacional': ['caja m n', 'caja nacional'],
                        'inventario inicial de mercaderias': ['inventario inicial mercaderias', 'mercaderias'],
                        'muebles y enseres': ['muebles', 'mobiliario'],
                        'documentos por pagar': ['documentos pagar', 'letras por pagar'],
                        'capital social': ['capital']
                    };
                    for (const [canonical, variants] of Object.entries(aliases)) {
                        if (name === canonical && variants.some(v => wanted.includes(normalize(v)))) {
                            score = Math.max(score, 82);
                        }
                    }

                    if (score > bestScore) {
                        bestScore = score;
                        best = account;
                    }
                }
                return bestScore >= 55 ? best : null;
            }

            async function recognizeColumn(canvas, label) {
                progress.textContent = 'Reconociendo columna ' + label + '…';
                const result = await Tesseract.recognize(canvas, 'spa+eng', {
                    logger: function (message) {
                        if (message.status === 'recognizing text') {
                            progress.textContent = 'Leyendo columna ' + label + ': ' + Math.round((message.progress || 0) * 100) + '%';
                        }
                    }
                });
                return result.data.text || '';
            }

            function cropColumn(image, side) {
                const sourceWidth = image.naturalWidth || image.width;
                const sourceHeight = image.naturalHeight || image.height;
                const canvas = document.createElement('canvas');
                const half = Math.floor(sourceWidth / 2);
                const x = side === 'left' ? 0 : half;
                const width = side === 'left' ? half : sourceWidth - half;

                // Escala moderada para mejorar lectura sin consumir demasiada memoria.
                const scale = Math.min(2, 2400 / Math.max(width, sourceHeight));
                canvas.width = Math.max(1, Math.round(width * scale));
                canvas.height = Math.max(1, Math.round(sourceHeight * scale));
                const ctx = canvas.getContext('2d');
                ctx.fillStyle = '#ffffff';
                ctx.fillRect(0, 0, canvas.width, canvas.height);
                ctx.drawImage(image, x, 0, width, sourceHeight, 0, 0, canvas.width, canvas.height);
                return canvas;
            }

            function addRecognizedLines(rows, side, accounts) {
                const usable = rows.filter(row => row.amount > 0);
                for (const item of usable) {
                    addButton.click();
                    const row = tbody.querySelector('tr:last-child');
                    const select = row.querySelector('.account-select');
                    const description = row.querySelector('input[name$="[description]"]');
                    const amountInputs = row.querySelectorAll('.amount-input');

                    const account = matchAccount(item.text, accounts, side);
                    if (account) {
                        select.value = String(account.id);
                        // El grupo de la cuenta determina el lado contable, no solo la posición en la foto.
                        const isAsset = account.group_type === 'activo';
                        amountInputs[0].value = isAsset ? item.amount.toFixed(2) : '0.00';
                        amountInputs[1].value = isAsset ? '0.00' : item.amount.toFixed(2);
                        window.applyOpeningAccountSide(row);
                    } else {
                        select.value = '';
                        select.title = 'Cuenta no reconocida: selecciona manualmente la cuenta correcta.';
                        amountInputs[0].value = '0.00';
                        amountInputs[1].value = '0.00';
                        row.dataset.pendingAmount = item.amount.toFixed(2);
                        window.applyOpeningAccountSide(row);
                        description.value = 'Pendiente de identificar: ' + item.text;
                    }

                    if (account) description.value = item.text;
                }
                tbody.dispatchEvent(new Event('input', { bubbles: true }));
                tbody.dispatchEvent(new Event('change', { bubbles: true }));
            }

            recognizeButton.addEventListener('click', async function () {
                errorBox.classList.add('hidden');
                if (!selectedImage) {
                    showError('Primero selecciona la fotografía del balance.');
                    return;
                }
                if (!window.Tesseract) {
                    showError('No se pudo cargar el motor OCR. Comprueba tu conexión a Internet y vuelve a intentarlo.');
                    return;
                }

                recognizeButton.disabled = true;
                progress.classList.remove('hidden');
                progress.textContent = 'Preparando imagen…';

                try {
                    const image = new Image();
                    image.src = URL.createObjectURL(selectedImage);
                    await new Promise((resolve, reject) => {
                        image.onload = resolve;
                        image.onerror = () => reject(new Error('No se pudo abrir la imagen.'));
                    });

                    const leftCanvas = cropColumn(image, 'left');
                    const rightCanvas = cropColumn(image, 'right');

                    const [leftText, rightText] = await Promise.all([
                        recognizeColumn(leftCanvas, 'izquierda (Activo)'),
                        recognizeColumn(rightCanvas, 'derecha (Pasivo y Capital)')
                    ]);

                    const leftRows = extractRows(leftText);
                    const rightRows = extractRows(rightText);
                    if (!leftRows.length && !rightRows.length) {
                        throw new Error('No se detectaron cuentas con importes. Prueba con una foto más nítida, recta y bien iluminada.');
                    }

                    // La lista de cuentas se obtiene de los selects existentes en el formulario.
                    const accounts = @json($openingAccountCatalog);

                    // Quita las filas vacías iniciales; no realiza ninguna petición al servidor.
                    tbody.innerHTML = '';
                    addRecognizedLines(leftRows, 'left', accounts);
                    addRecognizedLines(rightRows, 'right', accounts);

                    if (!tbody.querySelector('tr')) addButton.click();

                    progress.textContent = 'Reconocimiento terminado. Revisa todas las cuentas e importes; todavía NO se ha guardado nada.';
                    progress.className = 'text-sm text-emerald-300';
                } catch (error) {
                    showError(error.message || 'Ocurrió un error durante el reconocimiento.');
                    progress.textContent = '';
                } finally {
                    recognizeButton.disabled = false;
                }
            });
        })();
    </script>

</x-app-layout>
