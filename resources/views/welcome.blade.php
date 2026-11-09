<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Contaduría SaaS • Plataforma Contable & Servicios Fiscales</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-slate-950 text-slate-100 min-h-screen flex flex-col justify-between selection:bg-emerald-500 selection:text-white">

    <!-- Navegación Principal -->
    <nav class="border-b border-slate-800 bg-slate-900/80 backdrop-blur-md sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 rounded-xl bg-emerald-500/10 border border-emerald-500/30 flex items-center justify-center text-emerald-400 font-extrabold text-xl shadow-lg">
                    C
                </div>
                <div>
                    <span class="font-bold text-lg text-white tracking-wider block leading-none">CONTADURÍA</span>
                    <span class="text-[10px] text-emerald-400 font-semibold tracking-widest uppercase">SaaS & Servicios Fiscales</span>
                </div>
            </div>

            <div class="hidden md:flex items-center space-x-8 text-xs font-medium text-slate-300">
                <a href="#servicios" class="hover:text-emerald-400 transition">Lo que Ofrecemos</a>
                <a href="#seguridad" class="hover:text-emerald-400 transition">Privacidad & Seguridad</a>
                <a href="#precios" class="hover:text-emerald-400 transition">Planes & Membresías</a>
            </div>

            <div class="flex items-center space-x-4">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ route('dashboard') }}" class="text-xs font-semibold text-emerald-400 border border-emerald-500/30 bg-emerald-500/10 px-4 py-2.5 rounded-xl hover:bg-emerald-500/20 transition">Ir a mi Panel</a>
                    @else
                        <a href="{{ route('login') }}" class="text-xs font-medium text-slate-300 hover:text-white px-3 py-2 transition">Iniciar Sesión</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="text-xs font-semibold text-white bg-emerald-600 hover:bg-emerald-500 px-5 py-2.5 rounded-xl shadow-lg shadow-emerald-950 transition">Registrarse</a>
                        @endif
                    @endauth
                @endif
            </div>
        </div>
    </nav>

    <!-- HERO SECTION -->
    <header class="relative py-20 lg:py-28 overflow-hidden">
        <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top,_var(--tw-gradient-stops))] from-emerald-900/20 via-slate-950 to-slate-950 pointer-events-none"></div>
        
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-8 relative z-10">
            <span class="inline-flex items-center gap-2 text-xs font-semibold uppercase tracking-widest text-emerald-400 bg-emerald-950/80 border border-emerald-800/80 px-4 py-1.5 rounded-full shadow-inner">
                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                Plataforma Contable Institucional & Empresarial
            </span>
            
            <h1 class="text-4xl sm:text-6xl lg:text-7xl font-extrabold text-white tracking-tight leading-tight max-w-4xl mx-auto">
                Tu Contabilidad Integral, Impuestos y Declaraciones en un Solo Lugar
            </h1>

            <p class="text-slate-400 text-base sm:text-lg max-w-3xl mx-auto leading-relaxed">
                Automatiza tu registro de Estados Financieros, declaraciones tributarias con respaldo físico directo en tu puerta y garantía total de confidencialidad de tus datos.
            </p>

            <div class="flex flex-col sm:flex-row items-center justify-center gap-4 pt-4">
                @auth
                    <a href="{{ route('dashboard') }}" class="w-full sm:w-auto bg-emerald-600 hover:bg-emerald-500 text-white font-semibold text-sm px-8 py-4 rounded-xl shadow-xl shadow-emerald-950 transition">
                        Acceder a mi Empresa de Práctica
                    </a>
                @else
                    <a href="{{ route('register') }}" class="w-full sm:w-auto bg-emerald-600 hover:bg-emerald-500 text-white font-semibold text-sm px-8 py-4 rounded-xl shadow-xl shadow-emerald-950 transition">
                        Comenzar Ahora • Crear Cuenta
                    </a>
                    <a href="#precios" class="w-full sm:w-auto bg-slate-900 hover:bg-slate-800 border border-slate-700 text-slate-200 font-semibold text-sm px-8 py-4 rounded-xl transition">
                        Ver Planes y Tarifas
                    </a>
                @endauth
            </div>
        </div>
    </header>

    <!-- SECCIÓN: LO QUE OFRECEMOS -->
    <section id="servicios" class="py-20 border-t border-slate-800/80 bg-slate-900/30">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">
            <div class="text-center max-w-3xl mx-auto space-y-3">
                <h2 class="text-xs font-semibold text-emerald-400 uppercase tracking-widest">Servicios Incluidos</h2>
                <h3 class="text-3xl font-extrabold text-white">Todo lo que necesitas para tu gestión contable y fiscal</h3>
                <p class="text-slate-400 text-sm">Diseñado para brindar exactitud matemática, respaldo legal y simplicidad operativa.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Servicio 1 -->
                <div class="bg-slate-900 border border-slate-800 p-8 rounded-2xl space-y-4 hover:border-emerald-500/40 transition">
                    <div class="w-12 h-12 rounded-xl bg-emerald-500/10 border border-emerald-500/20 flex items-center justify-center text-emerald-400 text-2xl">
                        📊
                    </div>
                    <h4 class="text-lg font-bold text-white">Estados Financieros Completos</h4>
                    <p class="text-xs text-slate-400 leading-relaxed">
                        Generación y registro automatizado del Balance General, Estado de Resultados, Sumas y Saldos, Libro Diario y Hoja de Trabajo de 10 columnas sin margen de error.
                    </p>
                </div>

                <!-- Servicio 2 -->
                <div class="bg-slate-900 border border-slate-800 p-8 rounded-2xl space-y-4 hover:border-emerald-500/40 transition">
                    <div class="w-12 h-12 rounded-xl bg-indigo-500/10 border border-indigo-500/20 flex items-center justify-center text-indigo-400 text-2xl">
                        🏛️
                    </div>
                    <h4 class="text-lg font-bold text-white">Declaraciones a Impuestos</h4>
                    <p class="text-xs text-slate-400 leading-relaxed">
                        Elaboración y liquidación oportuna de tus obligaciones tributarias (Formularios IVA, IT, IUE y Retenciones) según normativa vigente.
                    </p>
                </div>

                <!-- Servicio 3 -->
                <div class="bg-slate-900 border border-slate-800 p-8 rounded-2xl space-y-4 hover:border-emerald-500/40 transition">
                    <div class="w-12 h-12 rounded-xl bg-amber-500/10 border border-amber-500/20 flex items-center justify-center text-amber-400 text-2xl">
                        📦
                    </div>
                    <h4 class="text-lg font-bold text-white">Documentación en Físico a Puerta</h4>
                    <p class="text-xs text-slate-400 leading-relaxed">
                        Entregamos tus libros contables, balances firmados y comprobantes impresos organizados directamente en la puerta de tu domicilio o institución.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- SECCIÓN: SEGURIDAD Y PRIVACIDAD DE DATOS -->
    <section id="seguridad" class="py-20 border-t border-slate-800/80 bg-slate-950">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-gradient-to-br from-slate-900 to-slate-900/90 border border-emerald-500/30 rounded-3xl p-8 sm:p-12 space-y-8 shadow-2xl relative overflow-hidden">
                <div class="absolute -right-10 -bottom-10 w-64 h-64 bg-emerald-500/5 rounded-full blur-3xl pointer-events-none"></div>

                <div class="flex items-center gap-3">
                    <span class="w-10 h-10 rounded-xl bg-emerald-500/10 border border-emerald-500/30 flex items-center justify-center text-emerald-400 text-xl font-bold">
                        🔒
                    </span>
                    <span class="text-xs font-semibold uppercase tracking-widest text-emerald-400">Privacidad & Blindaje Contable</span>
                </div>

                <div class="space-y-4">
                    <h3 class="text-2xl sm:text-4xl font-extrabold text-white">
                        Tus Estados Financieros son 100% Privados
                    </h3>
                    <p class="text-slate-300 text-sm sm:text-base leading-relaxed">
                        Garantizamos una **estricta restricción en el uso de tus datos**. Nadie más que tú como usuario/estudiante tiene visibilidad sobre tus números, montos o balances financieros. Aplicamos políticas de no filtración y aislamiento absoluto por empresa registrada.
                    </p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-4 border-t border-slate-800">
                    <div class="flex items-start gap-3">
                        <span class="text-emerald-400 font-bold">✓</span>
                        <p class="text-xs text-slate-400"><strong class="text-white">Cero filtraciones:</strong> Protocolos de encriptación de extremo a extremo.</p>
                    </div>
                    <div class="flex items-start gap-3">
                        <span class="text-emerald-400 font-bold">✓</span>
                        <p class="text-xs text-slate-400"><strong class="text-white">Aislamiento total:</strong> Tu empresa opera en una sandbox aislada e independiente.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- SECCIÓN: PRECIOS Y MEMBRESÍAS -->
    <section id="precios" class="py-20 border-t border-slate-800/80 bg-slate-900/40">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">
            <div class="text-center max-w-2xl mx-auto space-y-3">
                <h2 class="text-xs font-semibold text-emerald-400 uppercase tracking-widest">Planes Transparentes</h2>
                <h3 class="text-3xl font-extrabold text-white">Elige la suscripción ideal para ti</h3>
                <p class="text-slate-400 text-sm">Sin cobros ocultos. Acceso completo a todos los módulos y entregables en físico.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-4xl mx-auto">
                
                <!-- Plan Mensual -->
                <div class="bg-slate-900 border border-slate-800 rounded-3xl p-8 space-y-6 flex flex-col justify-between hover:border-slate-700 transition">
                    <div class="space-y-4">
                        <span class="text-xs font-semibold uppercase tracking-wider text-slate-400 bg-slate-800 px-3 py-1 rounded-full">Suscripción Mensual</span>
                        <div class="flex items-baseline space-x-2">
                            <span class="text-4xl font-extrabold text-white">Bs. 500</span>
                            <span class="text-slate-400 text-sm">/ mes</span>
                        </div>
                        <p class="text-xs text-slate-400 leading-relaxed">Ideal para prácticas de corta duración o seguimiento mes a mes.</p>

                        <ul class="space-y-3 text-xs text-slate-300 pt-4 border-t border-slate-800">
                            <li class="flex items-center gap-2">
                                <span class="text-emerald-400 font-bold">✓</span> Acceso al sistema SaaS 24/7.
                            </li>
                            <li class="flex items-center gap-2">
                                <span class="text-emerald-400 font-bold">✓</span> Registro de compras/ventas con captura de facturas.
                            </li>
                            <li class="flex items-center gap-2">
                                <span class="text-emerald-400 font-bold">✓</span> Libro Diario y Hoja de Trabajo automáticos.
                            </li>
                            <li class="flex items-center gap-2">
                                <span class="text-emerald-400 font-bold">✓</span> Resguardo estricto de privacidad.
                            </li>
                        </ul>
                    </div>

                    <a href="{{ route('register') }}" class="w-full text-center bg-slate-800 hover:bg-slate-700 text-slate-200 text-xs font-semibold py-3.5 rounded-xl transition border border-slate-700 block">
                        Contratar Plan Mensual
                    </a>
                </div>

                <!-- Plan Anual (Destacado) -->
                <div class="bg-slate-900 border-2 border-emerald-500 rounded-3xl p-8 space-y-6 flex flex-col justify-between shadow-2xl shadow-emerald-950/50 relative overflow-hidden">
                    <span class="absolute top-0 right-0 bg-emerald-500 text-slate-950 text-[10px] font-extrabold uppercase tracking-widest px-4 py-1.5 rounded-bl-xl">
                        Ahorra 2 Meses
                    </span>

                    <div class="space-y-4">
                        <span class="text-xs font-semibold uppercase tracking-wider text-emerald-400 bg-emerald-950/80 border border-emerald-800 px-3 py-1 rounded-full">Suscripción Anual</span>
                        <div class="flex items-baseline space-x-2">
                            <span class="text-4xl font-extrabold text-white">Bs. 5.000</span>
                            <span class="text-slate-400 text-sm">/ año</span>
                        </div>
                        <p class="text-xs text-slate-400 leading-relaxed">El paquete completo para toda la gestión académica e institucional.</p>

                        <ul class="space-y-3 text-xs text-slate-300 pt-4 border-t border-slate-800">
                            <li class="flex items-center gap-2">
                                <span class="text-emerald-400 font-bold">✓</span> Todo lo incluido en el Plan Mensual.
                            </li>
                            <li class="flex items-center gap-2">
                                <span class="text-emerald-400 font-bold">✓</span> <strong>Declaraciones de impuestos completas.</strong>
                            </li>
                            <li class="flex items-center gap-2">
                                <span class="text-emerald-400 font-bold">✓</span> <strong>Entrega de documentos físicos en puerta.</strong>
                            </li>
                            <li class="flex items-center gap-2">
                                <span class="text-emerald-400 font-bold">✓</span> Respaldos ilimitados e informes descargables.
                            </li>
                        </ul>
                    </div>

                    <a href="{{ route('register') }}" class="w-full text-center bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-semibold py-3.5 rounded-xl shadow-lg transition block">
                        Contratar Plan Anual (Bs. 5.000)
                    </a>
                </div>

            </div>
        </div>
    </section>

    <!-- Pie de Página -->
    <footer class="border-t border-slate-800 bg-slate-950 py-8 text-center text-xs text-slate-500 space-y-2">
        <p>© {{ date('Y') }} Contaduría SaaS. Todos los derechos reservados.</p>
        <p class="text-[11px] text-slate-600">Garantía estricta de protección de datos personales e información fiscal.</p>
    </footer>

</body>
</html>