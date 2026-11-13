<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-bold text-2xl text-white tracking-tight">Estado de membresía</h2>
            <p class="text-sm text-slate-400 mt-1">Consulta el estado de acceso a tu espacio contable.</p>
        </div>
    </x-slot>

    <div class="min-h-[70vh] bg-slate-950 text-slate-100 flex items-center justify-center px-4 py-12">
        <div class="max-w-xl w-full bg-slate-900 border border-slate-800 rounded-3xl p-8 sm:p-10 shadow-2xl text-center">
            <div class="mx-auto mb-6 w-16 h-16 rounded-2xl flex items-center justify-center text-amber-300 bg-amber-400/10 border border-amber-400/20">
                <svg class="w-8 h-8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><path d="M12 8v4m0 4h.01M10.3 3.9 2.7 17a2 2 0 0 0 1.7 3h15.2a2 2 0 0 0 1.7-3L13.7 3.9a2 2 0 0 0-3.4 0Z" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </div>
            <p class="text-xs uppercase tracking-[.2em] text-amber-300 font-semibold mb-3">
                {{ $expired ? 'Membresía vencida' : 'Acceso pendiente' }}
            </p>
            <h3 class="text-2xl font-bold text-white mb-3">
                {{ $expired ? 'Tu periodo de acceso ha finalizado' : 'Tu cuenta aún no está habilitada' }}
            </h3>
            <p class="text-sm text-slate-400 leading-6 max-w-md mx-auto">
                @if($expired)
                    La fecha de vigencia registrada fue {{ $userDate = auth()->user()->membership_expires_at ? \Carbon\Carbon::parse(auth()->user()->membership_expires_at)->format('d/m/Y') : 'no especificada' }}.
                    Para continuar utilizando las herramientas contables, solicita la renovación de tu membresía.
                @else
                    Tu usuario está registrado, pero todavía no cuenta con una membresía activa. Comunícate con administración para habilitar el servicio.
                @endif
            </p>
            <div class="mt-7 rounded-2xl bg-slate-950 border border-slate-800 p-5 text-left">
                <p class="text-[11px] uppercase tracking-wider text-slate-500 font-semibold mb-2">Asistencia de membresías</p>
                <p class="text-lg font-semibold text-white">Contacta con administración</p>
                <p class="text-sm text-slate-400 mt-1">Solicita la revisión de tu fecha de vigencia y la activación correspondiente.</p>
            </div>
            <form method="POST" action="{{ route('logout') }}" class="mt-7">
                @csrf
                <button type="submit" class="inline-flex justify-center rounded-xl px-6 py-3 text-sm font-semibold bg-slate-800 hover:bg-slate-700 border border-slate-700 text-slate-200 transition">Cerrar sesión</button>
            </form>
        </div>
    </div>
</x-app-layout>
