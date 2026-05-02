@extends('layouts.app')

@section('title', 'Daftar Mahasiswa')

@section('content')
    <div class="bg-white rounded-lg shadow-sm p-6">
        {{-- Header --}}
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Daftar Mahasiswa</h1>
                <p class="text-sm text-gray-500 mt-1">Total: {{ $mahasiswa->total() }} mahasiswa</p>
            </div>
            <a href="{{ route('mahasiswa.create') }}" class="bg-green-600 hover:bg-green-700 text-white font-medium px-4 py-2 rounded-md transition flex items-center gap-2">
                <span>+</span>
                <span>Tambah Mahasiswa</span>
            </a>
        </div>

        {{-- Search & Filter --}}
        <form method="GET" action="{{ route('mahasiswa.index') }}" class="mb-6 grid grid-cols-1 md:grid-cols-4 gap-3">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari NIM, nama, atau email..." class="md:col-span-2 px-3 py-2 border border-gray-300 rounded-md
            focus:ring-2 focus:ring-green-500 focus:outline-none">

            <select name="prodi" class="px-3 py-2 border border-gray-300 rounded-md">
                <option value="">Semua Prodi</option>
                <option value="Teknik Informatika" {{ request('prodi') == 'Teknik Informatika' ? 'selected' : '' }}>Teknik Informatika</option>
                <option value="Sistem Informasi" {{ request('prodi') == 'Sistem Informasi' ? 'selected' : '' }}>Sistem Informasi</option>
                <option value="Manajemen" {{ request('prodi') == 'Manajemen' ?'selected' : '' }}>Manajemen</option>
                <option value="Akuntansi" {{ request('prodi') == 'Akuntansi' ? 'selected' : '' }}>Akuntansi</option>
            </select>

            <div class="flex gap-2">
                <button type="submit" class="flex-1 bg-green-300 hover:bg-gray-300text-black px-4 py-2 rounded-md">
                    Cari
                </button>
                @if(request()->hasAny(['search', 'prodi', 'status']))
                    <a href="{{ route('mahasiswa.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-md">
                        Reset
                    </a>
                @endif
            </div>
        </form>

        {{-- Tabel --}}
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50 border-b">
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">No</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Foto</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">NIM</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Nama</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Prodi</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Angkatan</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">IPK</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Status</th>
                        <th class="px-4 py-3 text-center text-xs font-semibold text-gray-600 uppercase">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100">
                    @forelse ($mahasiswa as $index => $mhs)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 text-sm text-gray-600">
                            {{ $mahasiswa->firstItem() + $index }}
                        </td>
                        <td class="px-4 py-3">
                            <img src="{{ $mhs->foto_url }}" alt="{{ $mhs->nama }}" class="w-10 h-10 rounded-full object-cover">
                        </td>

                        <td class="px-4 py-3 text-sm font-medium text-gray-800">{{ $mhs->nim }}</td>

                        <td class="px-4 py-3 text-sm text-gray-800">{{ $mhs->nama }}</td>
                        <td class="px-4 py-3 text-sm text-gray-600">{{ $mhs->prodi }}</td>
                        <td class="px-4 py-3 text-sm text-gray-600">{{ $mhs->angkatan }}</td>
                        <td class="px-4 py-3 text-sm font-semibold text-gray-800">{{ number_format($mhs->ipk, 2) }}</td>

                        <td class="px-4 py-3">

                            @php
                                $statusColor = [
                                'aktif' => 'bg-green-100 text-green-700',
                                'cuti' => 'bg-yellow-100 text-yellow-700',
                                'lulus' => 'bg-green-100 text-green-700',
                                'do' => 'bg-red-100 text-red-700',
                                ][$mhs->status] ?? 'bg-gray-100 text-gray-700';
                            @endphp

                            <span class="px-2 py-1 text-xs font-medium rounded-full {{ $statusColor }}">
                                {{ ucfirst($mhs->status) }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-center">

                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('mahasiswa.show', $mhs) }}" class="text-green-600 hover:text-green-800 text-sm font-medium">Detail</a>
                                <a href="{{ route('mahasiswa.edit', $mhs) }}" class="text-yellow-600 hover:text-yellow-800 text-sm font-medium">Edit</a>
                                <form 
                                    action="{{ route('mahasiswa.destroy',$mhs) }}" 
                                    method="POST" 
                                    onsubmit="return confirm('Yakin ingin menghapus data {{ $mhs->nama }}?')" class="inline">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-medium"> Hapus </button>
                                </form>
                            </div>

                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="px-4 py-8 text-center text-gray-500">
                            <div class="flex flex-col items-center gap-2">
                                <span class="text-4xl">📭</span>
                                <p>Belum ada data mahasiswa.</p>
                                <a href="{{ route('mahasiswa.create') }}" class="text-green-600 hover:underline text-sm"> Tambah mahasiswa pertama </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="mt-4">
            {{ $mahasiswa->links() }}
        </div>
    </div>
@endsection