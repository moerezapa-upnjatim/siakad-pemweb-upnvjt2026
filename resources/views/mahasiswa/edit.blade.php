@extends('layouts.app')

@section('title', 'Edit Mahasiswa')

@section('content')
    <div class="bg-white rounded-lg shadow-sm p-6 max-w-3xl mx-auto">
        <div class="mb-6">
            <a href="{{ route('mahasiswa.index') }}" class="text-green-600 hover:underline text-sm">← Kembali ke daftar</a>
            <h1 class="text-2xl font-bold text-gray-800 mt-2">Edit Mahasiswa</h1>
        </div>

        <form action="{{ route('mahasiswa.update', $mahasiswa->id) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf
            @method('PUT') {{-- Method Spoofing untuk Update --}}
            
            {{-- Memanggil Partial Form yang sama --}}
            @include('mahasiswa.form')
            
            <div class="flex items-center gap-3 pt-4 border-t">
                <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-white font-medium px-6 py-2 rounded-md"> Perbarui Data </button>
                <a href="{{ route('mahasiswa.index') }}" class="bg-gray-200 text-gray-700 px-6 py-2 rounded-md">Batal</a>
            </div>
        </form>
    </div>
@endsection