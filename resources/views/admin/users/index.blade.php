<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h2 class="font-bold text-2xl text-white tracking-tight">
                    Gestión General de Membresías
                </h2>
                <p class="text-xs text-slate-400 mt-1">Control de acceso y suscripciones para alumnos de prácticas contables.</p>
            </div>
            <span class="inline-flex items-center gap-1.5 bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 px-3 py-1 rounded-full text-xs font-medium self-start md:self-auto">
                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                Panel Administrativo
            </span>
        </div>
    </x-slot>

    <div class="py-8 bg-slate-950 min-h-[calc(100vh-8rem)] text-slate-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            
            <!-- Mensajes de Estado -->
            @if(session('success'))
                <div class="bg-emerald-950/80 border border-emerald-800/80 text-emerald-300 px-4 py-3 rounded-xl text-sm flex items-center justify-between shadow-lg">
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-950/80 border border-red-800/80 text-red-300 px-4 py-3 rounded-xl text-sm flex items-center justify-between shadow-lg">
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            <!-- Tarjetas de Métricas -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="bg-slate-900 border border-slate-800 p-5 rounded-2xl shadow-xl">
                    <div class="text-slate-400 text-xs uppercase tracking-wider font-semibold">Total Registrados</div>
                    <div class="text-3xl font-extrabold text-white mt-2">{{ $users->count() }}</div>
                    <div class="text-[11px] text-slate-500 mt-1">Alumnos y administradores</div>
                </div>
                <div class="bg-slate-900 border border-slate-800 p-5 rounded-2xl shadow-xl">
                    <div class="text-emerald-400 text-xs uppercase tracking-wider font-semibold">Membresías Activas</div>
                    <div class="text-3xl font-extrabold text-emerald-400 mt-2">
                        {{ $users->filter(fn($item) => $item->hasActiveMembership() && !$item->is_admin)->count() }}
                    </div>
                    <div class="text-[11px] text-slate-500 mt-1">Con acceso al sistema contable</div>
                </div>
                <div class="bg-slate-900 border border-slate-800 p-5 rounded-2xl shadow-xl">
                    <div class="text-amber-400 text-xs uppercase tracking-wider font-semibold">Inactivas / Pendientes</div>
                    <div class="text-3xl font-extrabold text-amber-400 mt-2">
                        {{ $users->filter(fn($item) => !$item->hasActiveMembership() && !$item->is_admin)->count() }}
                    </div>
                    <div class="text-[11px] text-slate-500 mt-1">Requieren habilitación manual</div>
                </div>
            </div>

            <!-- Tabla de Usuarios -->
            <div class="bg-slate-900 border border-slate-800 shadow-2xl rounded-2xl overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-800 flex justify-between items-center bg-slate-900/80">
                    <h3 class="font-semibold text-white text-base">Listado de Usuarios</h3>
                    <span class="text-xs text-slate-400 bg-slate-800 px-3 py-1 rounded-lg">Mostrando {{ $users->count() }} registros</span>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-800 text-left text-sm">
                        <thead class="bg-slate-950 text-slate-400 uppercase tracking-wider text-[11px]">
                            <tr>
                                <th class="px-6 py-4 font-semibold">Usuario / Estudiante</th>
                                <th class="px-6 py-4 font-semibold">Correo Electrónico</th>
                                <th class="px-6 py-4 font-semibold">Estado Membresía</th>
                                <th class="px-6 py-4 font-semibold">Vigente Hasta</th>
                                <th class="px-6 py-4 font-semibold text-right">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-800/60 bg-slate-900">
                            @foreach($users as $u)
                                <tr class="hover:bg-slate-800/40 transition">
                                    <td class="px-6 py-4 whitespace-nowrap font-medium text-white flex items-center space-x-3">
                                        <div class="w-8 h-8 rounded-full bg-slate-800 border border-slate-700 flex items-center justify-center font-bold text-xs text-emerald-400 uppercase">
                                            {{ substr($u->name, 0, 2) }}
                                        </div>
                                        <div>
                                            <span>{{ $u->name }}</span>
                                            @if($u->is_admin) 
                                                <span class="ml-2 text-[10px] bg-purple-950 text-purple-300 border border-purple-800/80 px-2 py-0.5 rounded-full font-medium">Admin</span> 
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-slate-400">{{ $u->email }}</td>
                                    
                                    <form action="{{ route('admin.users.updateMembership', $u->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <select name="membership_status" class="bg-slate-950 border border-slate-700 text-slate-200 text-xs rounded-lg px-3 py-1.5 focus:ring-emerald-500 focus:border-emerald-500">
                                                <option value="active" {{ $u->hasActiveMembership() ? 'selected' : '' }}>Activa</option>
                                                <option value="inactive" {{ $u->membership_status == 'inactive' ? 'selected' : '' }}>Inactiva</option>
                                                <option value="expired" {{ ($u->membership_status === 'expired' || $u->membershipIsExpired()) ? 'selected' : '' }}>Expirada</option>
                                            </select>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <input type="date" name="membership_expires_at" value="{{ $u->membership_expires_at ? \Carbon\Carbon::parse($u->membership_expires_at)->format('Y-m-d') : '' }}" class="bg-slate-950 border border-slate-700 text-slate-200 text-xs rounded-lg px-3 py-1.5 focus:ring-emerald-500 focus:border-emerald-500">
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right space-x-2">
                                            <button type="submit" class="bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-medium px-3.5 py-1.5 rounded-lg transition shadow-md shadow-emerald-900/20">
                                                Guardar
                                            </button>
                                    </form>
                                            @if(!$u->is_admin)
                                                <form action="{{ route('admin.users.destroy', $u->id) }}" method="POST" class="inline-block" onsubmit="return confirm('¿Seguro que deseas eliminar a {{ $u->name }}?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="bg-red-950/40 hover:bg-red-900/80 border border-red-800/80 text-red-300 text-xs font-medium px-3.5 py-1.5 rounded-lg transition">
                                                        Eliminar
                                                    </button>
                                                </form>
                                            @endif
                                        </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>