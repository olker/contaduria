<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h2 class="font-bold text-2xl text-white">Libro Diario</h2>
                <p class="text-xs text-slate-400 mt-1">{{ $company->name }} · Gestión {{ $company->fiscal_period }}</p>
            </div>
            <a href="{{ route('dashboard') }}" class="text-sm text-slate-300 hover:text-white">← Volver al panel</a>
        </div>
    </x-slot>
    <div class="py-8 bg-slate-950 min-h-screen text-slate-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            @if(session('success'))
                <div class="bg-emerald-950 border border-emerald-800 text-emerald-300 rounded-xl p-4 text-sm">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="bg-amber-950 border border-amber-800 text-amber-300 rounded-xl p-4 text-sm">{{ session('error') }}</div>
            @endif

            <div class="bg-slate-900 border border-slate-800 rounded-2xl p-5 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <p class="text-xs uppercase tracking-wider text-emerald-400 font-semibold">Partida doble</p>
                    <h3 class="text-lg font-bold mt-1">Registro cronológico de asientos</h3>
                    <p class="text-sm text-slate-400 mt-1">El asiento de apertura se conserva como AD1. Los nuevos asientos continúan con AD2, AD3...</p>
                </div>
                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('journal.print') }}" target="_blank" class="px-4 py-2.5 rounded-lg border border-slate-700 text-sm hover:bg-slate-800">Imprimir libro</a>
                    <a href="{{ route('journal.create') }}" class="px-4 py-2.5 rounded-lg bg-indigo-600 hover:bg-indigo-500 text-sm font-semibold">+ Nuevo asiento</a>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="bg-slate-900 rounded-xl p-5 border border-slate-800">
                    <p class="text-xs text-slate-400">Total Debe acumulado</p>
                    <p class="text-2xl font-bold mt-1">{{ $company->currency }} {{ number_format($totalDebit,2,',','.') }}</p>
                </div>
                <div class="bg-slate-900 rounded-xl p-5 border border-slate-800">
                    <p class="text-xs text-slate-400">Total Haber acumulado</p>
                    <p class="text-2xl font-bold mt-1">{{ $company->currency }} {{ number_format($totalCredit,2,',','.') }}</p>
                </div>
            </div>

            <div class="bg-slate-900 border border-slate-800 rounded-2xl overflow-hidden">
                <div class="p-5 border-b border-slate-800">
                    <h3 class="font-bold">Asientos registrados</h3>
                    <p class="text-xs text-slate-400 mt-1">Cada código identifica un asiento y sus líneas contables.</p>
                </div>
                @foreach($entries as $entry)
                    @php
                        $debit = $entry->lines->sum(fn($line) => (float)$line->debit);
                        $credit = $entry->lines->sum(fn($line) => (float)$line->credit);
                    @endphp
                    <a href="{{ route('journal.show', $entry->id) }}" class="block p-5 border-b border-slate-800 last:border-0 hover:bg-slate-800/50">
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
                            <div>
                                <div class="flex items-center gap-2 flex-wrap">
                                    <span class="font-bold text-emerald-300">{{ $entry->entry_code ?: 'AD—' }}</span>
                                    @if($entry->type === 'apertura')
                                        <span class="text-[10px] rounded-full px-2 py-1 bg-emerald-500/10 text-emerald-300">APERTURA</span>
                                    @else
                                        <span class="text-[10px] rounded-full px-2 py-1 bg-indigo-500/10 text-indigo-300">DIARIO</span>
                                    @endif
                                </div>
                                <p class="font-semibold mt-1">{{ $entry->description }}</p>
                                <p class="text-xs text-slate-400 mt-1">{{ $entry->date->format('d/m/Y') }} · {{ $entry->lines->count() }} líneas</p>
                            </div>
                            <div class="grid grid-cols-2 gap-5 text-right text-sm">
                                <div><span class="block text-xs text-slate-500">Debe</span><strong>{{ number_format($debit,2,',','.') }}</strong></div>
                                <div><span class="block text-xs text-slate-500">Haber</span><strong>{{ number_format($credit,2,',','.') }}</strong></div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
