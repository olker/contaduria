<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-white tracking-tight">
            Configuración Inicial • Empresa de Práctica
        </h2>
        <p class="text-xs text-slate-400 mt-1">Registra los datos fiscales de la empresa sobre la cual realizarás tus asientos contables.</p>
    </x-slot>

    <div class="py-12 bg-slate-950 min-h-[calc(100vh-8rem)] text-slate-100 flex items-center justify-center">
        <div class="max-w-xl w-full mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-slate-900 border border-slate-800 shadow-2xl rounded-2xl p-8">
                
                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-white">Datos de la Empresa</h3>
                    <p class="text-xs text-slate-400 mt-1">Esta información aparecerá en los encabezados de tus reportes y hojas de trabajo.</p>
                </div>

                @if ($errors->any())
                    <div class="mb-4 bg-red-950/80 border border-red-800 text-red-300 p-3 rounded-xl text-xs">
                        <ul class="list-disc pl-4 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('company.store') }}" method="POST" class="space-y-5">
                    @csrf

                    <div>
                        <label class="block text-xs font-medium uppercase tracking-wider text-slate-300 mb-2">Razón Social / Nombre de la Empresa</label>
                        <input type="text" name="name" value="{{ old('name') }}" required class="w-full bg-slate-950 border border-slate-700 rounded-lg px-4 py-3 text-slate-100 placeholder-slate-500 focus:outline-none focus:border-emerald-500 text-sm" placeholder="Ej. Comercial Yugos S.R.L." />
                    </div>

                    <div>
                        <label class="block text-xs font-medium uppercase tracking-wider text-slate-300 mb-2">NIT (Número de Identificación Tributaria)</label>
                        <input type="text" name="nit" value="{{ old('nit') }}" required class="w-full bg-slate-950 border border-slate-700 rounded-lg px-4 py-3 text-slate-100 placeholder-slate-500 focus:outline-none focus:border-emerald-500 text-sm" placeholder="Ej. 1029384019" />
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-medium uppercase tracking-wider text-slate-300 mb-2">Moneda</label>
                            <select name="currency" class="w-full bg-slate-950 border border-slate-700 rounded-lg px-4 py-3 text-slate-100 text-sm focus:outline-none focus:border-emerald-500">
                                <option value="BOB">BOB (Bolivianos)</option>
                                <option value="USD">USD (Dólares)</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-medium uppercase tracking-wider text-slate-300 mb-2">Gestión / Periodo Fiscal</label>
                            <input type="number" name="fiscal_period" value="{{ date('Y') }}" required class="w-full bg-slate-950 border border-slate-700 rounded-lg px-4 py-3 text-slate-100 text-sm focus:outline-none focus:border-emerald-500" />
                        </div>
                    </div>

                    <div class="pt-4">
                        <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-500 text-white font-medium py-3 px-4 rounded-lg transition shadow-lg text-sm tracking-wide">
                            Guardar y Comenzar Práctica Contable
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>