<nav x-data="{ open: false }" class="bg-slate-900 border-b border-slate-800 text-slate-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="font-bold text-emerald-400 tracking-wider text-lg">
                        CONTADURÍA
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    @if(auth()->check() && auth()->user()->is_admin)
                        <x-nav-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.index')" class="text-slate-300 hover:text-emerald-400">
                            {{ __('Gestión de Usuarios') }}
                        </x-nav-link>
                    @else
                        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-slate-300 hover:text-emerald-400">
                            {{ __('Panel Principal') }}
                        </x-nav-link>
                    @endif
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ml-6 space-x-4">
                <!-- Botón directo de Cerrar Sesión para mayor comodidad -->
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="bg-red-950/60 hover:bg-red-900 border border-red-800 text-red-300 text-xs px-3 py-1.5 rounded-lg transition font-medium">
                        Cerrar Sesión
                    </button>
                </form>

                <div class="text-sm font-medium text-slate-300 bg-slate-800/80 border border-slate-700 px-3 py-1.5 rounded-lg">
                    {{ Auth::user()->name }}
                </div>
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-slate-400 hover:text-slate-500 hover:bg-slate-800 focus:outline-none transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-slate-900 border-t border-slate-800">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-slate-300">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-slate-800">
            <div class="px-4">
                <div class="font-medium text-base text-slate-200">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-slate-400">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1 px-4 pb-3">
                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left bg-red-950/60 hover:bg-red-900 border border-red-800 text-red-300 text-xs px-3 py-2 rounded-lg transition font-medium">
                        Cerrar Sesión
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>