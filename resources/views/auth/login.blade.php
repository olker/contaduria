<x-guest-layout>
    <div class="min-h-screen w-full flex items-center justify-center bg-slate-950 text-slate-100 p-4">
        <div class="w-full max-w-5xl bg-slate-900 border border-slate-800 shadow-2xl rounded-2xl overflow-hidden grid grid-cols-1 lg:grid-cols-12">
            
            <!-- Panel Izquierdo: Identidad / Información Institucional -->
            <div class="lg:col-span-5 bg-gradient-to-br from-slate-900 via-slate-800 to-emerald-950 p-8 lg:p-12 flex flex-col justify-between border-b lg:border-b-0 lg:border-r border-slate-800">
                <div>
                    <div class="inline-flex items-center space-x-2 bg-emerald-500/10 border border-emerald-500/20 px-3 py-1 rounded-full text-emerald-400 text-xs font-semibold uppercase tracking-wider mb-6">
                        <span>Módulo Contable</span>
                    </div>
                    <h2 class="text-2xl lg:text-3xl font-bold tracking-tight text-white mb-3">Contaduría Práctica</h2>
                    <p class="text-slate-400 text-sm leading-relaxed">
                        Sistema integral para el registro de transacciones, gestión de libros diarios, hojas de trabajo y control tributario automatizado.
                    </p>
                </div>
                <div class="mt-8 pt-6 border-t border-slate-800/80 text-xs text-slate-500 flex justify-between items-center">
                    <span>CEA Maria olivia</span>
                    <span class="text-emerald-400 font-medium">PHP 8.0 • Laravel</span>
                </div>
            </div>

            <!-- Panel Derecho: Formulario de Acceso -->
            <div class="lg:col-span-7 p-8 lg:p-12 flex flex-col justify-center bg-slate-900/50">
                <div class="mb-8">
                    <h3 class="text-xl font-semibold text-white">Iniciar Sesión</h3>
                    <p class="text-sm text-slate-400 mt-1">Ingrese sus credenciales institucionales para acceder.</p>
                </div>

                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="space-y-5">
                    @csrf

                    <!-- Email Address -->
                    <div>
                        <label for="email" class="block text-xs font-medium uppercase tracking-wider text-slate-300 mb-2">Correo Electrónico</label>
                        <input id="email" class="w-full bg-slate-950 border border-slate-700 rounded-lg px-4 py-3 text-slate-100 placeholder-slate-500 focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition text-sm" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="usuario@contaduria.com" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2 text-xs text-red-400" />
                    </div>

                    <!-- Password -->
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <label for="password" class="block text-xs font-medium uppercase tracking-wider text-slate-300">Contraseña</label>
                            @if (Route::has('password.request'))
                                <a class="text-xs text-emerald-400 hover:underline" href="{{ route('password.request') }}">
                                    ¿Olvidó su contraseña?
                                </a>
                            @endif
                        </div>
                        <input id="password" class="w-full bg-slate-950 border border-slate-700 rounded-lg px-4 py-3 text-slate-100 placeholder-slate-500 focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition text-sm" type="password" name="password" required autocomplete="current-password" placeholder="••••••••" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2 text-xs text-red-400" />
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center">
                        <label for="remember_me" class="inline-flex items-center cursor-pointer">
                            <input id="remember_me" type="checkbox" class="rounded bg-slate-950 border-slate-700 text-emerald-600 focus:ring-emerald-500 w-4 h-4" name="remember">
                            <span class="ml-2 text-xs text-slate-400">Recordar sesión en este equipo</span>
                        </label>
                    </div>

                    <div class="pt-2">
                        <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-500 active:bg-emerald-700 text-white font-medium py-3 px-4 rounded-lg transition shadow-lg shadow-emerald-900/20 text-sm tracking-wide">
                            Acceder al Sistema
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-guest-layout>