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

{{-- NIM & Nama --}}
<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">NIM
        <span class="text-red-500">*</span></label>
        <input type="text" name="nim" value="{{ old('nim', $mahasiswa->nim ??
        '') }}" required maxlength="10" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-green-500 focus:outline-none">
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Nama
        Lengkap <span class="text-red-500">*</span></label>
        <input type="text" name="nama" value="{{ old('nama', $mahasiswa->nama ?? '') }}" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-green-500 focus:outline-none">
    </div>
</div>

{{-- Email & No HP --}}
<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Email
            <span class="text-red-500">*</span>
        </label>
        <input type="email" name="email" value="{{ old('email', $mahasiswa->email ?? '' )}}" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-green-500 focus:outline-none">
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">No HP</label>
        <input type="text" name="no_hp" value="{{ old('no_hp', $mahasiswa->no_hp ?? '') }}" maxlength="15"class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-green-500 focus:outline-none">
    </div>
</div>

{{-- Jenis Kelamin & Tanggal Lahir --}}
<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Kelamin <span class="text-red-500">*</span></label>
        <select name="jenis_kelamin" required class="w-full px-3 py-2 border border-gray-300 roundedmd focus:ring-2 focus:ring-green-500 focus:outline-none">
            <option value="">-- Pilih --</option>
            <option value="L" {{ old('jenis_kelamin', $mahasiswa->jenis_kelamin ?? '') == 'L' ? 'selected' : '' }}>Laki-laki</option>
            <option value="P" {{ old('jenis_kelamin', $mahasiswa->jenis_kelamin ?? '') == 'P' ? 'selected' : '' }}>Perempuan</option>
        </select>
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Lahir</label>
        <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', isset($mahasiswa->tanggal_lahir) ? $mahasiswa->tanggal_lahir->format('Y-m-d') : '') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-green-500 focus:outline-none">
    </div>
</div>

{{-- Prodi & Angkatan --}}
<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Program Studi <span class="text-red-500">*</span></label>
        <select name="prodi" required class="w-full px-3 py-2 border border-gray-300 roundedmd focus:ring-2 focus:ring-green-500 focus:outline-none">
        <option value="">-- Pilih Prodi --</option>
            <option value="Teknik Informatika" {{ old('prodi', $mahasiswa->prodi ?? '') == 'Teknik Informatika' ? 'selected' : '' }}>Informatika</option>
            <option value="Sistem Informasi" {{ old('prodi', $mahasiswa->prodi ?? '') == 'Sistem Informasi' ? 'selected' : '' }}>Sistem Informasi</option>
            <option value="Sains Data" {{ old('prodi', $mahasiswa->prodi ??'') == 'Sains Data' ? 'selected' : '' }}>Sains Data</option>
            <option value="Bisnis Digital" {{ old('prodi', $mahasiswa->prodi ?? '') == 'Bisnis Digital' ? 'selected' : '' }}>Bisnis Digital</option>
        </select>
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Angkatan
        <span class="text-red-500">*</span></label>
        <input type="number" name="angkatan" value="{{ old('angkatan', $mahasiswa->angkatan ?? date('Y')) }}" min="2000" max="{{ date('Y') }}" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-green-500 focus:outline-none">
    </div>
</div>

{{-- IPK & Status --}}
<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">IPK</label>
        <input type="number" name="ipk" value="{{ old('ipk', $mahasiswa->ipk ?? '0.00') }}" min="0" max="4" step="0.01" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-green-500 focus:outline-none">
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Status
        <span class="text-red-500">*</span></label>
        <select name="status" required class="w-full px-3 py-2 border border-gray-300 roundedmd focus:ring-2 focus:ring-green-500 focus:outline-none">
            <option value="aktif" {{ old('status', $mahasiswa->status ?? 'aktif') == 'aktif' ? 'selected' : '' }}>Aktif</option>
            <option value="cuti" {{ old('status', $mahasiswa->status ?? '')== 'cuti' ? 'selected' : '' }}>Cuti</option>
            <option value="lulus" {{ old('status', $mahasiswa->status ?? '') == 'lulus' ? 'selected' : '' }}>Lulus</option>
            <option value="do" {{ old('status', $mahasiswa->status ?? '') == 'do' ? 'selected' : '' }}>Drop Out</option>
        </select>
    </div>
</div>

{{-- Alamat --}}
<div>
    <label class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
    <textarea name="alamat" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-green-500 focus:outline-none">{{ old('alamat', $mahasiswa->alamat ?? '')}}</textarea>
</div>

{{-- Foto --}}
<div>
    <label class="block text-sm font-medium text-gray-700 mb-1">Foto</label>
    {{-- Tampilkan preview foto lama jika ada (saat proses edit) --}}
    @if(isset($mahasiswa) && $mahasiswa->foto)
        <div class="mb-3">
            <img src="{{ $mahasiswa->foto_url }}" alt="Preview" class="w-20 h-20 rounded-md object-cover border">
        </div>
    @endif
    <input type="file" name="foto" accept="image/jpeg,image/png,image/jpg" class="w-full px-3 py-2 border border-gray-300 rounded-md">
    <p class="text-xs text-gray-500 mt-1">Format: JPG/PNG · Maksimal 2 MB</p>
</div>