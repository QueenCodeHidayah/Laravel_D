<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-2xl text-indigo-900 leading-tight">
                👥 Manajemen Pengguna
            </h2>
            
            <a href="{{ route('admin.users.create') }}" class="bg-indigo-600 text-white px-5 py-2.5 rounded-2xl font-bold text-sm shadow-lg shadow-indigo-100 hover:bg-indigo-700 transition duration-200 flex items-center space-x-2">
                <span>➕ Tambah Akun Baru</span>
            </a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-4 p-4 bg-emerald-50 text-emerald-600 font-bold rounded-2xl text-sm border border-emerald-100">
                    ✅ {{ session('success') }}
                </div>
            @endif

            <div class="bg-white shadow-xl rounded-[40px] overflow-hidden border border-gray-100">
                <table class="w-full text-left">
                    <thead class="bg-indigo-50/50">
                        <tr>
                            <th class="p-6 text-xs font-black text-indigo-900 uppercase tracking-widest">Nama & Email</th>
                            <th class="p-6 text-xs font-black text-indigo-900 uppercase tracking-widest text-center">Role</th>
                            <th class="p-6 text-xs font-black text-indigo-900 uppercase tracking-widest text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($users as $user)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="p-6">
                                <div class="flex items-center space-x-4">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=random" class="w-10 h-10 rounded-full">
                                    <div>
                                        <div class="font-bold text-gray-800">{{ $user->name }}</div>
                                        <div class="text-xs text-gray-400">{{ $user->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="p-6 text-center">
                                <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase {{ $user->role == 'admin' ? 'bg-purple-100 text-purple-600' : 'bg-blue-100 text-blue-600' }}">
                                    {{ $user->role }}
                                </span>
                            </td>
                            <td class="p-6 text-center flex items-center justify-center space-x-3">
                                <a href="{{ route('admin.users.edit', $user->id) }}" class="bg-amber-100 text-amber-600 px-3 py-2 rounded-xl hover:bg-amber-200 transition font-bold text-xs flex items-center">
                                    ✏️ Edit
                                </a>
                                
                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus user ini?')" class="inline">
                                    @csrf @method('DELETE')
                                    <button class="bg-red-50 text-red-500 hover:bg-red-100 px-3 py-2 rounded-xl font-bold text-xs transition">
                                        🗑️ Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>