@extends('layouts.app')

@section('title', 'Tambah Mahasiswa')

@section('content')
    <div class="bg-white rounded-lg shadow-sm p-6 max-w-3xl mx-auto">
        <div class="mb-6">
            <a href="{{ route('mahasiswa.index') }}" class="text-green-600 hover:underline text-sm"> ← Kembali ke daftar </a>
            <h1 class="text-2xl font-bold text-gray-800 mt-2">Tambah Mahasiswa</h1>
            <p class="text-sm text-gray-500 mt-1">Lengkapi formulir di bawah untuk menambahkan data mahasiswa baru.</p>
        </div>

        {{-- Tampilkan error validasi --}}
        @if ($errors->any())
            <div class="mb-4 bg-red-50 border-l-4 border-red-500 p-4 rounded">
                <p class="font-semibold text-red-700 mb-2">Terdapat kesalahan:</p>
                <ul class="list-disc list-inside text-sm text-red-700 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('mahasiswa.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf

            {{-- Memanggil Partial Form --}}
            @include('mahasiswa.form')

            {{-- Tombol Submit --}}
            <div class="flex items-center gap-3 pt-4 border-t">
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-medium px-6 py-2 rounded-md transition">
                    Simpan Data
                </button>
                <a href="{{ route('mahasiswa.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium px-6 py-2 rounded-md transition">
                    Batal
                </a>
            </div>
        </form>
    </div>
@endsection