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

            {{-- NIM & Nama --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">NIM <span class="text-red-500">*</span></label>
                    <input type="text" name="nim" value="{{ old('nim') }}" required maxlength="10" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-green-500 focus:outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
                    <input type="text" name="nama" value="{{ old('nama') }}" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-green-500 focus:outline-none">
                </div>
            </div>

            {{-- Email & No HP --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email <span class="text-red-500">*</span></label>
                    <input type="email" name="email" value="{{ old('email') }}" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-green-500 focus:outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">No HP</label>
                    <input type="text" name="no_hp" value="{{ old('no_hp') }}" maxlength="15" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-green-500 focus:outline-none">
                </div>
            </div>

            {{-- Jenis Kelamin & Tanggal Lahir --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Kelamin <span class="text-red-500">*</span></label>
                    <select name="jenis_kelamin" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-green-500 focus:outline-none">
                        <option value="">-- Pilih --</option>
                        <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" value="{{old('tanggal_lahir') }}"class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-green-500 focus:outline-none">
                </div>
            </div>

            {{-- Prodi & Angkatan --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Program Studi <span class="text-red-500">*</span></label>
                    <select name="prodi" requiredclass="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-green-500 focus:outline-none">
                        <option value="">-- Pilih Prodi --</option>
                        <option value="Teknik Informatika" {{ old('prodi') == 'Informatika' ? 'selected' : '' }}>Informatika</option>
                        <option value="Sistem Informasi" {{ old('prodi') == 'Sistem Informasi' ? 'selected' : '' }}>Sistem Informasi</option>
                        <option value="Manajemen" {{ old('prodi') == 'Sains Data' ? 'selected' : '' }}>Sains Data</option>
                        <option value="Akuntansi" {{ old('prodi') == 'Bisnis Digital'? 'selected' : '' }}>Bisnis Digital</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Angkatan <span class="text-red-500">*</span></label>
                    <input type="number" name="angkatan" value="{{ old('angkatan', date('Y')) }}" min="2000" max="{{ date('Y') }}" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-green-500 focus:outline-none">
                </div>
            </div>

            {{-- IPK & Status --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>

                <label class="block text-sm font-medium text-gray-700 mb-
                1">IPK</label>

                <input type="number" name="ipk" value="{{ old('ipk', '0.00') }}"
                min="0" max="4" step="0.01"
                class="w-full px-3 py-2 border border-gray-300 rounded-md
                focus:ring-2 focus:ring-green-500 focus:outline-none">
                </div>
                <div>

                <label class="block text-sm font-medium text-gray-700 mb-
                1">Status <span class="text-red-500">*</span></label>
                <select name="status" required

                class="w-full px-3 py-2 border border-gray-300 rounded-
                md focus:ring-2 focus:ring-green-500 focus:outline-none">

                <option value="aktif" {{ old('status', 'aktif') == 'aktif' ?
                'selected' : '' }}>Aktif</option>
                <option value="cuti" {{ old('status') == 'cuti' ? 'selected'
                : '' }}>Cuti</option>
                <option value="lulus" {{ old('status') == 'lulus' ?
                'selected' : '' }}>Lulus</option>
                <option value="do" {{ old('status') == 'do' ? 'selected' : ''
                }}>Drop Out</option>
                </select>
                </div>
            </div>

            {{-- Alamat --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
                <textarea name="alamat" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-green-500 focus:outline-none">{{ old('alamat') }}</textarea>
            </div>

            {{-- Foto --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Foto</label>
                <input type="file" name="foto" accept="image/jpeg,image/png,image/jpg" class="w-full px-3 py-2 border border-gray-300 rounded-md">
                <p class="text-xs text-gray-500 mt-1">Format: JPG/PNG · Maksimal 2 MB</p>
            </div>

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