<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
            <div>
                <h2 class="font-bold text-2xl text-white tracking-tight">Observaciones del Plan de Cuentas</h2>
                <p class="text-xs text-slate-400 mt-1">Documento de referencia · Gestión {{ $company->fiscal_period }}</p>
            </div>
            <a href="{{ route('opening.index') }}" class="text-sm text-slate-300 hover:text-white">← Volver al Libro de Apertura</a>
        </div>
    </x-slot>

    <div class="py-10 bg-slate-950 min-h-[calc(100vh-8rem)] text-slate-100">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-5">
            <div class="bg-amber-950/30 border border-amber-900/70 rounded-xl p-5 text-sm text-amber-100">
                Estas observaciones identifican diferencias de numeración, códigos o nombres que aparecen en el PDF original.
                <strong>No se corrigió ni se sustituyó ningún código o nombre.</strong>
            </div>

            @foreach ($observations as $observation)
                <article class="bg-slate-900 border border-slate-800 rounded-xl p-5">
                    <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-2">
                        <div>
                            <span class="text-[10px] uppercase tracking-wider text-indigo-300 font-semibold">{{ str_replace('_', ' ', $observation->issue_type) }}</span>
                            @if ($observation->account)
                                <h3 class="text-sm font-semibold text-white mt-1">{{ $observation->account->code }} — {{ trim($observation->account->name) }}</h3>
                            @endif
                        </div>
                        <span class="text-[11px] text-slate-500 whitespace-nowrap">Página {{ $observation->source_page ?? '—' }}</span>
                    </div>
                    <p class="text-sm text-slate-300 mt-3">{{ $observation->description }}</p>
                    @if ($observation->source_excerpt)
                        <p class="text-xs text-slate-500 mt-3 border-l-2 border-slate-700 pl-3">{{ $observation->source_excerpt }}</p>
                    @endif
                </article>
            @endforeach
        </div>
    </div>
</x-app-layout>
