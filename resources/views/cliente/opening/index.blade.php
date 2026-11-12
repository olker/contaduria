<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
            <div>
                <h2 class="font-bold text-2xl text-white tracking-tight">Libro de Apertura</h2>
                <p class="text-xs text-slate-400 mt-1">{{ $company->name }} · Gestión {{ $company->fiscal_period }}</p>
            </div>
            <a href="{{ route('dashboard') }}" class="text-sm text-slate-300 hover:text-white">← Volver al panel</a>
        </div>
    </x-slot>

    <div class="py-10 bg-slate-950 min-h-[calc(100vh-8rem)] text-slate-100">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            @if (session('success'))
                <div class="bg-emerald-950/80 border border-emerald-800 text-emerald-300 px-4 py-3 rounded-xl text-sm">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="bg-amber-950/80 border border-amber-800 text-amber-300 px-4 py-3 rounded-xl text-sm">{{ session('error') }}</div>
            @endif

            <div class="bg-slate-900 border border-slate-800 rounded-2xl p-6">
                <h3 class="text-lg font-bold text-white">Balance inicial de la empresa</h3>
                <p class="text-sm text-slate-400 mt-2">
                    En este libro registraremos los saldos con los que la empresa inicia la gestión: bienes y derechos (Activo),
                    obligaciones (Pasivo) y aportes o patrimonio. El sistema comprobará que el Debe y el Haber sean iguales.
                </p>
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mt-3">
                    <p class="text-xs text-slate-500">
                        El catálogo utilizado respeta los códigos y nombres del Plan de Cuentas PDF. Solo se habilitan cuentas auxiliares de Activo, Pasivo y Patrimonio.
                    </p>
                    <a href="{{ route('opening.observations') }}" class="text-xs text-indigo-300 hover:text-indigo-200 whitespace-nowrap">Consultar inconsistencias detectadas →</a>
                </div>
            </div>

            @if ($openingEntry)
                @php
                    $totalDebit = $openingEntry->lines->sum(fn ($line) => (float) $line->debit);
                    $totalCredit = $openingEntry->lines->sum(fn ($line) => (float) $line->credit);
                @endphp
                <div class="bg-slate-900 border border-emerald-800/60 rounded-2xl p-6 space-y-5">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                        <div>
                            <span class="text-xs uppercase tracking-wider text-emerald-400 font-semibold">Libro de Apertura registrado</span>
                            <h3 class="text-xl font-bold text-white mt-1">{{ $openingEntry->description }}</h3>
                            <p class="text-sm text-slate-400 mt-1">Fecha: {{ $openingEntry->date->format('d/m/Y') }}</p>
                        </div>
                        <span class="px-3 py-1 rounded-full text-xs font-semibold bg-emerald-500/10 border border-emerald-500/20 text-emerald-300">Asiento cuadrado</span>
                    </div>

                    <div class="flex justify-end">
                        <a href="{{ route('opening.print') }}" target="_blank"
                           class="inline-flex items-center bg-indigo-600 hover:bg-indigo-500 text-white font-semibold text-sm px-5 py-3 rounded-xl">
                            Imprimir Libro de Apertura
                        </a>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="bg-slate-950 rounded-xl p-4">
                            <p class="text-xs text-slate-500">Total Debe</p>
                            <p class="text-2xl font-bold text-white mt-1">{{ $company->currency }} {{ number_format($totalDebit, 2, ',', '.') }}</p>
                        </div>
                        <div class="bg-slate-950 rounded-xl p-4">
                            <p class="text-xs text-slate-500">Total Haber</p>
                            <p class="text-2xl font-bold text-white mt-1">{{ $company->currency }} {{ number_format($totalCredit, 2, ',', '.') }}</p>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead class="text-xs uppercase text-slate-500 border-b border-slate-800">
                                <tr>
                                    <th class="text-left py-3 pr-3">Código</th>
                                    <th class="text-left py-3 pr-3">Cuenta</th>
                                    <th class="text-right py-3 px-3">Debe</th>
                                    <th class="text-right py-3 pl-3">Haber</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-800">
                                @foreach ($openingEntry->lines as $line)
                                    <tr>
                                        <td class="py-3 pr-3 text-emerald-300 whitespace-nowrap">{{ $line->account->code }}</td>
                                        <td class="py-3 pr-3 text-slate-200">{{ trim($line->account->name) }}</td>
                                        <td class="py-3 px-3 text-right whitespace-nowrap">{{ number_format((float) $line->debit, 2, ',', '.') }}</td>
                                        <td class="py-3 pl-3 text-right whitespace-nowrap">{{ number_format((float) $line->credit, 2, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @else
                <div class="bg-slate-900 border border-slate-800 rounded-2xl p-8 text-center">
                    <div class="w-14 h-14 rounded-2xl bg-indigo-500/10 text-indigo-300 flex items-center justify-center mx-auto text-2xl">📘</div>
                    <h3 class="text-xl font-bold text-white mt-4">Aún no existe un asiento de apertura</h3>
                    <p class="text-sm text-slate-400 max-w-xl mx-auto mt-2">
                        Registra los saldos iniciales de las cuentas de balance. Puedes incluir efectivo, bancos, mercaderías,
                        bienes, deudas y capital, según la situación real de la empresa.
                    </p>
                    <a href="{{ route('opening.create') }}" class="inline-flex mt-6 items-center justify-center bg-indigo-600 hover:bg-indigo-500 text-white font-semibold text-sm px-6 py-3 rounded-xl transition">
                        Registrar balance inicial
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
