<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <p class="text-xs uppercase tracking-[.22em] text-emerald-400 font-semibold">Configuración inicial</p>
                <h2 class="font-bold text-2xl text-white tracking-tight mt-1">Registra tu empresa</h2>
                <p class="text-sm text-slate-400 mt-1">Personalizaremos las herramientas contables según tu actividad y tus operaciones.</p>
            </div>
            <span class="inline-flex items-center gap-2 rounded-full border border-emerald-500/20 bg-emerald-500/10 px-3 py-2 text-xs font-semibold text-emerald-300">
                <span class="h-2 w-2 rounded-full bg-emerald-400"></span> Asistente de configuración
            </span>
        </div>
    </x-slot>

    @php
        $input = 'mt-2 w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-sm text-slate-100 placeholder-slate-600 outline-none transition focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/10';
        $label = 'block text-xs font-semibold uppercase tracking-wider text-slate-300';
        $check = 'h-4 w-4 rounded border-slate-600 bg-slate-950 text-emerald-500 focus:ring-emerald-500';
        $oldOperations = old('business_operations', []);
        $oldObligations = old('tax_obligations', []);
    @endphp

    <div class="min-h-[calc(100vh-8rem)] bg-slate-950 px-4 py-9 text-slate-100">
        <div class="mx-auto max-w-5xl">
            <div class="mb-7 grid grid-cols-1 sm:grid-cols-3 gap-3">
                <div class="rounded-2xl border border-emerald-500/30 bg-emerald-500/10 p-4">
                    <p class="text-[11px] font-semibold uppercase tracking-wider text-emerald-300">01 · Identificación</p>
                    <p class="mt-1 text-sm font-semibold text-white">Datos legales</p>
                </div>
                <div class="rounded-2xl border border-slate-800 bg-slate-900 p-4">
                    <p class="text-[11px] font-semibold uppercase tracking-wider text-slate-400">02 · Actividad</p>
                    <p class="mt-1 text-sm font-semibold text-white">Operaciones comerciales</p>
                </div>
                <div class="rounded-2xl border border-slate-800 bg-slate-900 p-4">
                    <p class="text-[11px] font-semibold uppercase tracking-wider text-slate-400">03 · Impuestos</p>
                    <p class="mt-1 text-sm font-semibold text-white">Perfil tributario</p>
                </div>
            </div>

            @if ($errors->any())
                <div class="mb-6 rounded-2xl border border-red-500/30 bg-red-950/40 p-5 text-sm text-red-200">
                    <p class="font-semibold mb-2">Hay información que debes revisar:</p>
                    <ul class="list-disc pl-5 space-y-1">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                </div>
            @endif

            <form action="{{ route('company.store') }}" method="POST" class="space-y-6">
                @csrf

                <section class="overflow-hidden rounded-3xl border border-slate-800 bg-slate-900 shadow-xl">
                    <div class="border-b border-slate-800 px-6 py-5 sm:px-8">
                        <p class="text-xs font-semibold uppercase tracking-wider text-emerald-400">Paso 1</p>
                        <h3 class="mt-1 text-lg font-bold text-white">Identificación de la empresa</h3>
                        <p class="mt-1 text-sm text-slate-400">Información que aparecerá en los libros y reportes contables.</p>
                    </div>
                    <div class="grid grid-cols-1 gap-5 p-6 sm:grid-cols-2 sm:p-8">
                        <div class="sm:col-span-2">
                            <label for="name" class="{{ $label }}">Razón social / nombre comercial *</label>
                            <input id="name" name="name" value="{{ old('name') }}" required maxlength="255" class="{{ $input }}" placeholder="Ej. Automotores del Valle S.R.L.">
                            @error('name')<p class="mt-1 text-xs text-red-400">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label for="nit" class="{{ $label }}">NIT *</label>
                            <input id="nit" name="nit" value="{{ old('nit') }}" required maxlength="50" class="{{ $input }}" placeholder="Número de identificación tributaria">
                        </div>
                        <div>
                            <label for="society_type" class="{{ $label }}">Tipo de organización jurídica *</label>
                            <select id="society_type" name="society_type" required class="{{ $input }}">
                                <option value="">Selecciona una opción</option>
                                @foreach (['Empresa Unipersonal','Sociedad de Responsabilidad Limitada (S.R.L.)','Sociedad Anónima (S.A.)','Sociedad Colectiva','Sociedad en Comandita Simple','Sociedad en Comandita por Acciones','Asociación Accidental o de Cuentas en Participación','Otro'] as $type)
                                    <option value="{{ $type }}" {{ old('society_type') === $type ? 'selected' : '' }}>{{ $type }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="sm:col-span-2">
                            <label for="legal_representative" class="{{ $label }}">Representante legal *</label>
                            <input id="legal_representative" name="legal_representative" value="{{ old('legal_representative') }}" required maxlength="255" class="{{ $input }}" placeholder="Nombre completo">
                        </div>
                        <div class="sm:col-span-2">
                            <label for="fiscal_address" class="{{ $label }}">Dirección fiscal *</label>
                            <input id="fiscal_address" name="fiscal_address" value="{{ old('fiscal_address') }}" required maxlength="500" class="{{ $input }}" placeholder="Dirección registrada ante el SIN">
                        </div>
                        <div>
                            <label for="currency" class="{{ $label }}">Moneda de trabajo *</label>
                            <select id="currency" name="currency" required class="{{ $input }}">
                                <option value="BOB" {{ old('currency','BOB') === 'BOB' ? 'selected' : '' }}>BOB · Bolivianos</option>
                                <option value="USD" {{ old('currency') === 'USD' ? 'selected' : '' }}>USD · Dólares estadounidenses</option>
                            </select>
                        </div>
                        <div>
                            <label for="fiscal_period" class="{{ $label }}">Gestión fiscal *</label>
                            <input id="fiscal_period" type="number" name="fiscal_period" value="{{ old('fiscal_period', date('Y')) }}" min="2000" max="2100" required class="{{ $input }}">
                        </div>
                    </div>
                </section>

                <section class="overflow-hidden rounded-3xl border border-slate-800 bg-slate-900 shadow-xl">
                    <div class="border-b border-slate-800 px-6 py-5 sm:px-8">
                        <p class="text-xs font-semibold uppercase tracking-wider text-emerald-400">Paso 2</p>
                        <h3 class="mt-1 text-lg font-bold text-white">Actividad y operaciones</h3>
                        <p class="mt-1 text-sm text-slate-400">Esto permite habilitar inventario, compras, ventas, costos y otros módulos pertinentes.</p>
                    </div>
                    <div class="space-y-6 p-6 sm:p-8">
                        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                            <div>
                                <label for="activity_category" class="{{ $label }}">Sector económico *</label>
                                <select id="activity_category" name="activity_category" required class="{{ $input }}">
                                    <option value="">Selecciona el sector</option>
                                    @foreach (['comercio'=>'Comercio','servicios'=>'Servicios','industria'=>'Industria / Manufactura','construccion'=>'Construcción','transporte'=>'Transporte','profesional'=>'Servicios profesionales','agropecuaria'=>'Agropecuaria','otra'=>'Otra actividad'] as $value=>$caption)
                                        <option value="{{ $value }}" {{ old('activity_category') === $value ? 'selected' : '' }}>{{ $caption }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="economic_activity" class="{{ $label }}">Actividad económica principal *</label>
                                <input id="economic_activity" name="economic_activity" value="{{ old('economic_activity') }}" required maxlength="255" class="{{ $input }}" placeholder="Ej. Compra y venta de vehículos">
                            </div>
                        </div>

                        <div>
                            <p class="{{ $label }}">¿Qué operaciones realiza la empresa?</p>
                            <p class="mt-1 text-xs text-slate-500">Puedes seleccionar varias opciones.</p>
                            <div class="mt-3 grid grid-cols-1 gap-3 sm:grid-cols-2 lg:grid-cols-3">
                                @foreach (['compra_venta'=>'Compra y venta de mercaderías','importaciones'=>'Importación de productos','exportaciones'=>'Exportación de productos','ventas_credito'=>'Ventas a crédito','ventas_contado'=>'Ventas al contado','inventario'=>'Manejo de inventario','servicios_adicionales'=>'Servicios adicionales','recibe_parte_pago'=>'Recibe bienes como parte de pago','fabricacion'=>'Fabricación o producción','contratos'=>'Trabaja mediante contratos'] as $value=>$caption)
                                    <label class="flex items-start gap-3 rounded-xl border border-slate-800 bg-slate-950/70 p-3 text-sm text-slate-300 hover:border-slate-600">
                                        <input type="checkbox" name="business_operations[]" value="{{ $value }}" class="{{ $check }} mt-0.5" {{ in_array($value, $oldOperations) ? 'checked' : '' }}>
                                        <span>{{ $caption }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <div class="max-w-md">
                            <label for="has_employees" class="{{ $label }}">¿Tiene trabajadores dependientes? *</label>
                            <select id="has_employees" name="has_employees" required class="{{ $input }}">
                                <option value="0" {{ old('has_employees','0') === '0' ? 'selected' : '' }}>No</option>
                                <option value="1" {{ old('has_employees') === '1' ? 'selected' : '' }}>Sí</option>
                            </select>
                        </div>
                    </div>
                </section>

                <section class="overflow-hidden rounded-3xl border border-slate-800 bg-slate-900 shadow-xl">
                    <div class="border-b border-slate-800 px-6 py-5 sm:px-8">
                        <p class="text-xs font-semibold uppercase tracking-wider text-emerald-400">Paso 3</p>
                        <h3 class="mt-1 text-lg font-bold text-white">Configuración tributaria</h3>
                        <p class="mt-1 text-sm text-slate-400">El perfil ayuda a preparar formularios y recordatorios. La obligación definitiva debe contrastarse con el RNC del SIN.</p>
                    </div>
                    <div class="space-y-6 p-6 sm:p-8">
                        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                            <div>
                                <label for="tax_regime" class="{{ $label }}">Régimen tributario *</label>
                                <select id="tax_regime" name="tax_regime" required class="{{ $input }}">
                                    <option value="">Selecciona una opción</option>
                                    @foreach (['general'=>'Régimen General','simplificado'=>'Régimen Simplificado','integrado'=>'Sistema Tributario Integrado','agropecuario'=>'Régimen Agropecuario Unificado','otro'=>'Otro','no_sabe'=>'No lo sé / Necesito ayuda'] as $value=>$caption)
                                        <option value="{{ $value }}" {{ old('tax_regime') === $value ? 'selected' : '' }}>{{ $caption }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="sin_registration_verified" class="{{ $label }}">¿Verificaste las obligaciones en tu RNC? *</label>
                                <select id="sin_registration_verified" name="sin_registration_verified" required class="{{ $input }}">
                                    <option value="0" {{ old('sin_registration_verified','0') === '0' ? 'selected' : '' }}>No / Necesito orientación</option>
                                    <option value="1" {{ old('sin_registration_verified') === '1' ? 'selected' : '' }}>Sí, ya las verifiqué</option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <p class="{{ $label }}">Formularios u obligaciones que identificas en tu RNC</p>
                            <p class="mt-1 text-xs text-slate-500">Marca solo los que correspondan. No se activarán declaraciones automáticamente sin revisión.</p>
                            <div class="mt-3 grid grid-cols-1 gap-3 sm:grid-cols-2 lg:grid-cols-3">
                                @foreach (['iva_200'=>'Formulario 200 · IVA','it_400'=>'Formulario 400 · IT','iue_500'=>'Formulario 500 · IUE','it_retenciones_410'=>'Formulario 410 · Retenciones IT','iue_retenciones_570'=>'Formulario 570 · Retenciones IUE','rciva_retenciones_604'=>'Formulario 604 · Retenciones RC-IVA','no_sabe'=>'No estoy seguro / Necesito orientación'] as $value=>$caption)
                                    <label class="flex items-start gap-3 rounded-xl border border-slate-800 bg-slate-950/70 p-3 text-sm text-slate-300 hover:border-slate-600">
                                        <input type="checkbox" name="tax_obligations[]" value="{{ $value }}" class="{{ $check }} mt-0.5" {{ in_array($value, $oldObligations) ? 'checked' : '' }}>
                                        <span>{{ $caption }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <div class="rounded-2xl border border-amber-500/20 bg-amber-500/5 p-4">
                            <p class="text-sm font-semibold text-amber-200">Importante antes de continuar</p>
                            <p class="mt-1 text-xs leading-5 text-slate-400">El sistema usará esta información para personalizar módulos y guías. No reemplaza la verificación del Registro Nacional de Contribuyentes ni determina por sí sola qué impuestos debes declarar.</p>
                        </div>
                    </div>
                </section>

                <div class="flex flex-col-reverse gap-3 sm:flex-row sm:justify-between">
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center justify-center rounded-xl border border-slate-700 bg-slate-900 px-6 py-3 text-sm font-semibold text-slate-300 hover:bg-slate-800">Cancelar</a>
                    <button type="submit" class="inline-flex items-center justify-center rounded-xl bg-emerald-600 px-7 py-3 text-sm font-bold text-white shadow-lg shadow-emerald-950/40 transition hover:bg-emerald-500">
                        Guardar empresa y configurar mi espacio
                        <svg class="ml-2 h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14m-6-6 6 6-6 6" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </button>
                </div>
                <p class="text-center text-[11px] text-slate-500">Los datos podrán ampliarse o actualizarse posteriormente desde la configuración de la empresa.</p>
            </form>
        </div>
    </div>
</x-app-layout>
