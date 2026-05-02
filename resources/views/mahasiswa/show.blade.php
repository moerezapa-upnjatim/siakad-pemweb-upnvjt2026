@extends('layouts.app')

@section('title', 'Detail ' . $mahasiswa->nama)

@section('content')
    <div class="bg-white rounded-lg shadow-sm p-6 max-w-3xl mx-auto">
        <div class="mb-6">
            <a href="{{ route('mahasiswa.index') }}" class="text-green-600 hover:underline text-sm">← Kembali ke daftar </a>
        </div>

        {{-- Header dengan foto --}}
        <div class="flex items-start gap-6 pb-6 border-b">
            <img src="{{ $mahasiswa->foto_url }}" alt="{{ $mahasiswa->nama }}" class="w-24 h-24 rounded-full object-cover ring-4 ring-green-500">
            <div class="flex-1">
                <h1 class="text-2xl font-bold text-gray-800">{{ $mahasiswa->nama }}</h1>
                <p class="text-gray-600 mt-1">NIM: <span class="font-mono">{{$mahasiswa->nim }}</span></p>
                <p class="text-gray-600">{{ $mahasiswa->prodi }} · Angkatan {{$mahasiswa->angkatan }}</p>
                <div class="mt-2">
                @php
                    $statusColor = [
                        'aktif' => 'bg-green-100 text-green-700',
                        'cuti' => 'bg-yellow-100 text-yellow-700',
                        'lulus' => 'bg-green-100 text-green-700',
                        'do' => 'bg-red-100 text-red-700',
                    ][$mahasiswa->status] ?? 'bg-gray-100 text-gray-700';
                @endphp
                <span class="px-3 py-1 text-xs font-medium rounded-full {{ $statusColor }}">
                    {{ ucfirst($mahasiswa->status) }}
                </span>
                </div>
            </div>
        </div>

        {{-- Detail data --}}
        <dl class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <dt class="text-sm text-gray-500">Email</dt>
                <dd class="font-medium text-gray-800">{{ $mahasiswa->email }}</dd>
            </div>
            <div>
                <dt class="text-sm text-gray-500">No HP</dt>
                <dd class="font-medium text-gray-800">{{ $mahasiswa->no_hp ?? '-' }}</dd>
            </div>
            <div>
                <dt class="text-sm text-gray-500">Jenis Kelamin</dt>
                <dd class="font-medium text-gray-800">{{ $mahasiswa->jenis_kelamin_label }}</dd>
            </div>
            <div>
                <dt class="text-sm text-gray-500">Tanggal Lahir</dt>
                <dd class="font-medium text-gray-800">
                    {{ $mahasiswa->tanggal_lahir ? $mahasiswa->tanggal_lahir->format('d F Y') : '-' }}
                </dd>
            </div>
            <div>
                <dt class="text-sm text-gray-500">IPK</dt>
                <dd class="font-medium text-gray-800 text-lg">{{number_format($mahasiswa->ipk, 2) }}</dd>
            </div>
            <div>
                <dt class="text-sm text-gray-500">Terdaftar Sejak</dt>
                <dd class="font-medium text-gray-800">{{ $mahasiswa->created_at->format('d F Y') }}</dd>
            </div>
            <div class="md:col-span-2">
                <dt class="text-sm text-gray-500">Alamat</dt>
                <dd class="font-medium text-gray-800">{{ $mahasiswa->alamat ?? '-' }}</dd>
            </div>
        </dl>

        {{-- Tombol aksi --}}
        <div class="mt-8 pt-4 border-t flex items-center gap-3">
            <a href="{{ route('mahasiswa.edit', $mahasiswa) }}"class="bg-yellow-500 hover:bg-yellow-600 text-white font-medium px-5 py-2 rounded-md transition">
                Edit Data
            </a>

            <form action="{{ route('mahasiswa.destroy', $mahasiswa) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data {{ $mahasiswa->nama }}?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-medium px-5 py-2 rounded-md transition">
                    Hapus Data
                </button>
            </form>
            <a href="{{ route('mahasiswa.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium px-5 py-2 rounded-md transition">
                Kembali
            </a>
        </div>
    </div>
@endsection