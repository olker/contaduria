<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-bold text-2xl text-white tracking-tight">
                    @if(auth()->user()->membership_status === 'active' && isset($company) && $company)
                        {{ $company->name }}
                    @else
                        Panel de Usuario • Estado de Suscripción
                    @endif
                </h2>
                <p class="text-xs text-slate-400 mt-1">
                    @if(auth()->user()->membership_status === 'active' && isset($company) && $company)
                        NIT: {{ $company->nit }} • Gestión: {{ $company->fiscal_period }}
                    @else
                        Gestión Contable y Prácticas Fiscales
                    @endif
                </p>
            </div>
            
            <span class="px-3 py-1 rounded-full text-xs font-semibold {{ auth()->user()->membership_status === 'active' ? 'bg-emerald-500/10 border border-emerald-500/20 text-emerald-400' : 'bg-amber-500/10 border border-amber-500/20 text-amber-400' }}">
                {{ auth()->user()->membership_status === 'active' ? 'Membresía Activa' : 'Pago Pendiente' }}
            </span>
        </div>
    </x-slot>

    <div class="py-10 bg-slate-950 min-h-[calc(100vh-8rem)] text-slate-100 flex items-center justify-center">
        <div class="max-w-4xl w-full mx-auto px-4 sm:px-6 lg:px-8">
            
            @if(auth()->user()->membership_status !== 'active')
                <!-- BLOQUEO POR PAGO PENDIENTE -->
                <div class="bg-slate-900 border border-amber-500/30 shadow-2xl rounded-2xl p-8 sm:p-10 text-center space-y-6">
                    
                    <div class="w-16 h-16 bg-amber-500/10 border border-amber-500/20 text-amber-400 rounded-2xl flex items-center justify-center mx-auto text-2xl font-bold shadow-lg">
                        ⚠️
                    </div>

                    <div class="space-y-2">
                        <h3 class="text-2xl font-bold text-white">Acceso Restringido: Paquete Requerido</h3>
                        <p class="text-xs sm:text-sm text-slate-300 max-w-lg mx-auto leading-relaxed">
                            Hola <span class="text-white font-semibold">{{ auth()->user()->name }}</span>. Has ingresado a tu cuenta, pero **no puedes realizar operaciones, registrar facturas ni generar estados financieros** hasta adquirir o renovar tu suscripción.
                        </p>
                    </div>

                    <!-- CAJA DE CONTACTO PARA PAGO -->
                    <div class="bg-slate-950 border border-slate-800 rounded-2xl p-6 max-w-md mx-auto space-y-3 shadow-inner">
                        <span class="text-[11px] font-semibold uppercase tracking-wider text-slate-400 block">Comunícate para pagar o renovar tu contrato</span>
                        <div class="text-2xl sm:text-3xl font-extrabold text-emerald-400 tracking-wider">
                            📞 60385703
                        </div>
                        <p class="text-[11px] text-slate-400 leading-normal">
                            Llámanos o escríbenos por WhatsApp para activar tu plan Mensual (500 BOB) o Anual (5.000 BOB) y habilitar tu acceso inmediatamente.
                        </p>
                    </div>

                    <div class="pt-2 flex justify-center">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="bg-slate-800 hover:bg-slate-700 border border-slate-700 text-slate-300 text-xs font-medium px-6 py-2.5 rounded-xl transition">
                                Cerrar Sesión
                            </button>
                        </form>
                    </div>

                </div>

            @elseif(!isset($company) || !$company)
                <!-- SI TIENE PAGO ACTIVO PERO AÚN NO REGISTRÓ SU EMPRESA -->
                <div class="bg-slate-900 border border-slate-800 rounded-2xl p-8 text-center space-y-6">
                    <h3 class="text-xl font-bold text-white">¡Bienvenido! Configura tu Empresa de Práctica</h3>
                    <p class="text-xs text-slate-400 max-w-md mx-auto">Para comenzar a registrar tu contabilidad, primero debes ingresar los datos fiscales de la empresa con la que trabajarás.</p>
                    <a href="{{ route('company.create') }}" class="inline-block bg-emerald-600 hover:bg-emerald-500 text-white font-semibold text-xs px-6 py-3 rounded-xl transition shadow-lg">
                        Registrar mi Empresa Ahora
                    </a>
                </div>

            @else
                <!-- PANEL NORMAL DE OPERACIÓN CONTABLE -->
                <div class="space-y-6">
                    @if(session('success'))
                        <div class="bg-emerald-950/80 border border-emerald-800 text-emerald-300 px-4 py-3 rounded-xl text-sm">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="bg-slate-900 border border-slate-800 p-6 rounded-2xl shadow-xl hover:border-emerald-500/40 transition">
                            <h3 class="text-lg font-semibold text-white mb-2">Transacciones (Compras/Ventas)</h3>
                            <p class="text-xs text-slate-400 mb-4">Registro con captura de facturas y recibos vía cámara o archivo.</p>
                            <span class="text-xs text-emerald-400 font-semibold">Listo para operar</span>
                        </div>
                        <div class="bg-slate-900 border border-slate-800 p-6 rounded-2xl shadow-xl hover:border-indigo-500/40 transition">
                            <h3 class="text-lg font-semibold text-white mb-2">Libro Diario</h3>
                            <p class="text-xs text-slate-400 mb-4">Generación automática de asientos bajo el principio de partida doble.</p>
                            <span class="text-xs text-indigo-400 font-semibold">Módulo activo</span>
                        </div>
                        <div class="bg-slate-900 border border-slate-800 p-6 rounded-2xl shadow-xl hover:border-purple-500/40 transition">
                            <h3 class="text-lg font-semibold text-white mb-2">Hoja de Trabajo</h3>
                            <p class="text-xs text-slate-400 mb-4">Balance de comprobación de 10 columnas y estados finales.</p>
                            <span class="text-xs text-purple-400 font-semibold">Módulo activo</span>
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>