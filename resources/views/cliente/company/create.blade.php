<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-white tracking-tight">Registro de mi Empresa</h2>
        <p class="text-xs text-slate-400 mt-1">Completa los datos legales, tributarios y de identificación de la empresa.</p>
    </x-slot>

    <div class="py-10 bg-slate-950 min-h-[calc(100vh-8rem)] text-slate-100">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-slate-900 border border-slate-800 shadow-2xl rounded-2xl p-6 sm:p-8">
                @if ($errors->any())
                    <div class="mb-6 bg-red-950/80 border border-red-800 text-red-300 p-4 rounded-xl text-sm">
                        <p class="font-semibold mb-2">Revisa los siguientes campos:</p>
                        <ul class="list-disc pl-5 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('company.store') }}" method="POST" class="space-y-5">
                    @csrf

                    <div>
                        <label for="name" class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-2">Razón social / Nombre de la empresa *</label>
                        <input id="name" name="name" value="{{ old('name') }}" required maxlength="255" class="w-full bg-slate-950 border border-slate-700 rounded-lg px-4 py-3 text-slate-100 text-sm focus:outline-none focus:border-emerald-500" placeholder="Ej. Comercial del Valle S.R.L.">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label for="nit" class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-2">NIT *</label>
                            <input id="nit" name="nit" value="{{ old('nit') }}" required maxlength="50" class="w-full bg-slate-950 border border-slate-700 rounded-lg px-4 py-3 text-slate-100 text-sm focus:outline-none focus:border-emerald-500" placeholder="Número de identificación tributaria">
                        </div>
                        <div>
                            <label for="society_type" class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-2">Tipo de sociedad *</label>
                            <select id="society_type" name="society_type" required class="w-full bg-slate-950 border border-slate-700 rounded-lg px-4 py-3 text-slate-100 text-sm focus:outline-none focus:border-emerald-500">
                                <option value="">Selecciona el tipo</option>
                                @foreach ([
                                    'Empresa Unipersonal',
                                    'Sociedad de Responsabilidad Limitada (S.R.L.)',
                                    'Sociedad Anónima (S.A.)',
                                    'Sociedad Colectiva',
                                    'Sociedad en Comandita Simple',
                                    'Sociedad en Comandita por Acciones',
                                    'Asociación Accidental o de Cuentas en Participación',
                                    'Otro'
                                ] as $type)
                                    <option value="{{ $type }}" {{ old('society_type') === $type ? 'selected' : '' }}>{{ $type }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div>
                        <label for="economic_activity" class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-2">Actividad económica principal *</label>
                        <input id="economic_activity" name="economic_activity" value="{{ old('economic_activity') }}" required maxlength="255" class="w-full bg-slate-950 border border-slate-700 rounded-lg px-4 py-3 text-slate-100 text-sm focus:outline-none focus:border-emerald-500" placeholder="Ej. Comercialización de productos alimenticios">
                    </div>

                    <div>
                        <label for="fiscal_address" class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-2">Dirección fiscal *</label>
                        <input id="fiscal_address" name="fiscal_address" value="{{ old('fiscal_address') }}" required maxlength="500" class="w-full bg-slate-950 border border-slate-700 rounded-lg px-4 py-3 text-slate-100 text-sm focus:outline-none focus:border-emerald-500" placeholder="Dirección registrada para fines tributarios">
                    </div>

                    <div>
                        <label for="legal_representative" class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-2">Representante legal *</label>
                        <input id="legal_representative" name="legal_representative" value="{{ old('legal_representative') }}" required maxlength="255" class="w-full bg-slate-950 border border-slate-700 rounded-lg px-4 py-3 text-slate-100 text-sm focus:outline-none focus:border-emerald-500" placeholder="Nombre completo del representante legal">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label for="currency" class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-2">Moneda de trabajo *</label>
                            <select id="currency" name="currency" required class="w-full bg-slate-950 border border-slate-700 rounded-lg px-4 py-3 text-slate-100 text-sm focus:outline-none focus:border-emerald-500">
                                <option value="BOB" {{ old('currency', 'BOB') === 'BOB' ? 'selected' : '' }}>BOB - Bolivianos</option>
                                <option value="USD" {{ old('currency') === 'USD' ? 'selected' : '' }}>USD - Dólares</option>
                            </select>
                        </div>
                        <div>
                            <label for="fiscal_period" class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-2">Gestión / Periodo fiscal *</label>
                            <input id="fiscal_period" type="number" name="fiscal_period" value="{{ old('fiscal_period', date('Y')) }}" min="2000" max="2100" required class="w-full bg-slate-950 border border-slate-700 rounded-lg px-4 py-3 text-slate-100 text-sm focus:outline-none focus:border-emerald-500">
                        </div>
                    </div>

                    <div class="pt-3 flex flex-col sm:flex-row gap-3">
                        <a href="{{ route('dashboard') }}" class="sm:w-1/3 text-center bg-slate-800 hover:bg-slate-700 text-slate-200 font-medium py-3 px-4 rounded-lg text-sm">Cancelar</a>
                        <button type="submit" class="sm:flex-1 bg-emerald-600 hover:bg-emerald-500 text-white font-semibold py-3 px-4 rounded-lg text-sm shadow-lg">Guardar datos de mi empresa</button>
                    </div>
                    <p class="text-[11px] text-slate-500">* Todos los campos son obligatorios. Una cuenta de usuario puede registrar una sola empresa.</p>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
