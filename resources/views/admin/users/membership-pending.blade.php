<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-white tracking-tight">
            Estado de Membresía • Acceso Restringido
        </h2>
        <p class="text-xs text-slate-400 mt-1">Tu cuenta se encuentra registrada exitosamente en el sistema contable.</p>
    </x-slot>

    <div class="py-12 bg-slate-950 min-h-[calc(100vh-8rem)] text-slate-100 flex items-center justify-center">
        <div class="max-w-2xl w-full mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-slate-900 border border-slate-800 shadow-2xl rounded-2xl p-8 space-y-6 text-center">
                
                <div class="w-16 h-16 bg-amber-500/10 border border-amber-500/20 text-amber-400 rounded-2xl flex items-center justify-center mx-auto text-2xl font-bold shadow-lg">
                    ⚠️
                </div>

                <div>
                    <h3 class="text-xl font-bold text-white">Membresía Pendiente de Activación</h3>
                    <p class="text-xs text-slate-400 mt-2 max-w-md mx-auto leading-relaxed">
                        Hola <span class="text-white font-semibold">{{ auth()->user()->name }}</span>. Para operar tu empresa de práctica y registrar transacciones fiscales, tu cuenta requiere una membresía activa autorizada por el administrador.
                    </p>
                </div>

                <!-- Resumen de lo que incluye el sistema -->
                <div class="bg-slate-950 border border-slate-800 rounded-xl p-5 text-left space-y-3">
                    <h4 class="text-xs font-semibold uppercase tracking-wider text-emerald-400">¿Qué podrás hacer al activar tu cuenta?</h4>
                    <ul class="text-xs text-slate-300 space-y-2">
                        <li class="flex items-center gap-2">
                            <span class="text-emerald-400 font-bold">✓</span> Configurar y gestionar los datos fiscales de tu propia empresa.
                        </li>
                        <li class="flex items-center gap-2">
                            <span class="text-emerald-400 font-bold">✓</span> Registrar compras y ventas con captura de facturas y recibos.
                        </li>
                        <li class="flex items-center gap-2">
                            <span class="text-emerald-400 font-bold">✓</span> Generación automatizada del Libro Diario y Hoja de Trabajo.
                        </li>
                    </ul>
                </div>

                <!-- Acciones claras para el usuario -->
                <div class="flex flex-col sm:flex-row items-center justify-center gap-3 pt-2">
                    <form method="POST" action="{{ route('logout') }}" class="w-full sm:w-auto">
                        @csrf
                        <button type="submit" class="w-full bg-slate-800 hover:bg-slate-700 text-slate-200 text-xs font-medium px-5 py-3 rounded-xl transition border border-slate-700">
                            Regresar al Login / Cerrar Sesión
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>