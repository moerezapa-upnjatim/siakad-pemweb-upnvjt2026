<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\mahasiswa;
use Illuminate\Support\Facades\Storage;

class MahasiswaController extends Controller
{
    /**
    * READ — Tampilkan daftar mahasiswa
    * Route: GET /mahasiswa
    */
    public function index(Request $request)
    {
        $query = mahasiswa::query();
        // Pencarian berdasarkan NIM atau nama
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nim', 'like', "%{$search}%")
                ->orWhere('nama', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filter berdasarkan prodi
        if ($request->filled('prodi')) {
            $query->where('prodi', $request->prodi);
        }
        // Filter berdasarkan status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        $mahasiswa = $query->latest()->paginate(10)->withQueryString();
        return view('mahasiswa.index', compact('mahasiswa'));
    }

    /**
    * CREATE — Tampilkan form tambah mahasiswa
    * Route: GET /mahasiswa/create
    */
    public function create()
    {
        return view('mahasiswa.create');
    }
    /**
    * CREATE — Simpan data mahasiswa baru
    * Route: POST /mahasiswa
    */
    public function store(Request $request)
    {
        // Validasi data
        $validated = $request->validate([
            'nim' => 'required|string|max:10|unique:mahasiswa,nim',
            'nama' => 'required|string|max:100',
            'email' => 'required|email|unique:mahasiswa,email',
            'jenis_kelamin' => 'required|in:L,P',
            'tanggal_lahir' => 'nullable|date',
            'alamat' => 'nullable|string',
            'no_hp' => 'nullable|string|max:15',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'prodi' => 'required|string|max:50',
            'angkatan' => 'required|integer|min:2000|max:' . date('Y'),
            'ipk' => 'nullable|numeric|min:0|max:4',
            'status' => 'required|in:aktif,cuti,lulus,do',
        ], [
        'nim.required' => 'NIM wajib diisi.',
        'nim.unique' => 'NIM sudah terdaftar.',
        'email.email' => 'Format email tidak valid.',
        'foto.image' => 'File harus berupa gambar.',
        'foto.max' => 'Ukuran foto maksimal 2 MB.',
        ]);
        // Upload foto (jika ada)
        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('mahasiswa', 'public');
            $validated['foto'] = $path;
        }
        // Simpan ke database
        Mahasiswa::create($validated);
        return redirect()
            ->route('mahasiswa.index')
            ->with('success', 'Data mahasiswa berhasil ditambahkan.');
    }

    /**
    * READ — Tampilkan detail mahasiswa
    * Route: GET /mahasiswa/{id}
    */
    public function show(Mahasiswa $mahasiswa)
    {
        return view('mahasiswa.show', compact('mahasiswa'));
    }

    /**
    * UPDATE — Tampilkan form edit
    * Route: GET /mahasiswa/{id}/edit
    */
    public function edit(Mahasiswa $mahasiswa)
    {
        return view('mahasiswa.edit', compact('mahasiswa'));
    }
    /**
    * UPDATE — Update data mahasiswa
    * Route: PUT/PATCH /mahasiswa/{id}
    */
    public function update(Request $request, Mahasiswa $mahasiswa)
    {
        $validated = $request->validate([
            'nim' => 'required|string|max:10|unique:mahasiswa,nim,' .
                        $mahasiswa->id,
            'nama' => 'required|string|max:100',
            'email' => 'required|email|unique:mahasiswa,email,' .
                        $mahasiswa->id,
            'jenis_kelamin' => 'required|in:L,P',
            'tanggal_lahir' => 'nullable|date',
            'alamat' => 'nullable|string',
            'no_hp' => 'nullable|string|max:15',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'prodi' => 'required|string|max:50',
            'angkatan' => 'required|integer|min:2000|max:' . date('Y'),
            'ipk' => 'nullable|numeric|min:0|max:4',
            'status' => 'required|in:aktif,cuti,lulus,do',
        ]);

        // Upload foto baru (jika ada)
        if ($request->hasFile('foto')) {
        // Hapus foto lama
        if ($mahasiswa->foto) {
            Storage::disk('public')->delete($mahasiswa->foto);
        }
            $path = $request->file('foto')->store('mahasiswa', 'public');
            $validated['foto'] = $path;
        }
        $mahasiswa->update($validated);
        return redirect()
            ->route('mahasiswa.index')
            ->with('success', 'Data mahasiswa berhasil diperbarui.');
    }

    /**
    * DELETE — Hapus mahasiswa
    * Route: DELETE /mahasiswa/{id}
    */
    public function destroy(Mahasiswa $mahasiswa)
    {
    // Hapus foto dari storage (jika ada)
    if ($mahasiswa->foto) {
        Storage::disk('public')->delete($mahasiswa->foto);
    }
    $mahasiswa->delete();
    return redirect()
        ->route('mahasiswa.index')
        ->with('success', 'Data mahasiswa berhasil dihapus.');
    }
}
