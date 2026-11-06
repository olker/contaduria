<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-slate-100 leading-tight">
                {{ __('Panel de Administración • Gestión de Membresías') }}
            </h2>
            <span class="text-xs bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 px-3 py-1 rounded-full">
                Modo Administrador
            </span>
        </div>
    </x-slot>

    <div class="py-12 bg-slate-950 min-h-screen text-slate-100">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-slate-900 border border-slate-800 shadow-xl overflow-hidden sm:rounded-2xl p-6 lg:p-8">
                
                @if(session('success'))
                    <div class="mb-6 bg-emerald-950 border border-emerald-800 text-emerald-300 px-4 py-3 rounded-xl text-sm flex items-center justify-between">
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-6 bg-red-950 border border-red-800 text-red-300 px-4 py-3 rounded-xl text-sm flex items-center justify-between">
                        <span>{{ session('error') }}</span>
                    </div>
                @endif

                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-medium text-white">Usuarios Registrados en el Sistema</h3>
                    <span class="text-xs text-slate-400">Total: {{ $users->count() }} usuarios</span>
                </div>

                <div class="overflow-x-auto border border-slate-800 rounded-xl">
                    <table class="min-w-full divide-y divide-slate-800 text-left text-sm">
                        <thead class="bg-slate-950/70 text-slate-400 uppercase tracking-wider text-xs">
                            <tr>
                                <th class="px-6 py-4 font-semibold">Usuario</th>
                                <th class="px-6 py-4 font-semibold">Correo Electrónico</th>
                                <th class="px-6 py-4 font-semibold">Estado de Membresía</th>
                                <th class="px-6 py-4 font-semibold">Expira el</th>
                                <th class="px-6 py-4 font-semibold text-right">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-800 bg-slate-900/40">
                            @foreach($users as $u)
                                <tr class="hover:bg-slate-800/50 transition">
                                    <td class="px-6 py-4 whitespace-nowrap font-medium text-white">
                                        {{ $u->name }} 
                                        @if($u->is_admin) 
                                            <span class="ml-2 text-[10px] bg-purple-950 text-purple-300 border border-purple-800 px-2 py-0.5 rounded-full font-semibold">Admin</span> 
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-slate-400">{{ $u->email }}</td>
                                    
                                    <!-- Formulario para modificar membresía en línea -->
                                    <form action="{{ route('admin.users.updateMembership', $u->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <select name="membership_status" class="bg-slate-950 border border-slate-700 text-slate-200 text-xs rounded-lg px-3 py-2 focus:ring-emerald-500 focus:border-emerald-500">
                                                <option value="active" {{ $u->membership_status == 'active' ? 'selected' : '' }}>Activa</option>
                                                <option value="inactive" {{ $u->membership_status == 'inactive' ? 'selected' : '' }}>Inactiva</option>
                                                <option value="expired" {{ $u->membership_status == 'expired' ? 'selected' : '' }}>Expirada</option>
                                            </select>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <input type="date" name="membership_expires_at" value="{{ $u->membership_expires_at ? \Carbon\Carbon::parse($u->membership_expires_at)->format('Y-m-d') : '' }}" class="bg-slate-950 border border-slate-700 text-slate-200 text-xs rounded-lg px-3 py-2 focus:ring-emerald-500 focus:border-emerald-500">
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right space-x-2">
                                            <button type="submit" class="bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-medium px-3 py-2 rounded-lg transition shadow">
                                                Guardar
                                            </button>
                                    </form>
                                            @if(!$u->is_admin)
                                                <form action="{{ route('admin.users.destroy', $u->id) }}" method="POST" class="inline-block" onsubmit="return confirm('¿Seguro que deseas eliminar este usuario?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="bg-red-900/40 hover:bg-red-900 border border-red-700 text-red-300 text-xs font-medium px-3 py-2 rounded-lg transition">
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