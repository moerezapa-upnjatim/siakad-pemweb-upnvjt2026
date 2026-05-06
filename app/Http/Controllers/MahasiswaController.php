<?php

namespace App\Http\Controllers;

use App\Models\DBLogActivities;
use Illuminate\Http\Request;
use App\Models\mahasiswa;
use Illuminate\Support\Facades\DB;
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
        
        // validasi apakah ada foto yang di upload
        $profilePhotoPath = null;
        if ($request->hasFile('foto')) {
            $profilePhotoPath = $request->file('foto')->store('mahasiswa', 'public');
            $validated['foto'] = $profilePhotoPath;
        }

        // 1. BEFORE - Simpan ke database
        // Mahasiswa::create($validated);

        // 1. AFTER - transaction only for db operations
        DB::transaction(function() use($validated){
            // insert data mahasiswa temporary
            mahasiswa::create($validated);
            // insert log activity
            DB::table(DBLogActivities::TABLE_NAME)->insert([
                DBLogActivities::ACTION_COLUMN => DBLogActivities::CREATE,
                DBLogActivities::DESC_COLUMN => 'Tambah Mahasiswa: ' . $validated['nama'],
                'created_at' => now()
            ]);
        });

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
            // 'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'prodi' => 'required|string|max:50',
            'angkatan' => 'required|integer|min:2000|max:' . date('Y'),
            'ipk' => 'nullable|numeric|min:0|max:4',
            'status' => 'required|in:aktif,cuti,lulus,do',
        ]);

        // 2. Validate file separately (optional but recommended)
        $request->validate([
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // 1. BEFORE - SEBELUM MENERAPKAN TRANSACTION
        // Upload foto baru (jika ada)
        // if ($request->hasFile('foto')) {
        // // Hapus foto lama
        // if ($mahasiswa->foto) {
        //     Storage::disk('public')->delete($mahasiswa->foto);
        // }
        //     $path = $request->file('foto')->store('mahasiswa', 'public');
        //     $validated['foto'] = $path;
        // }
        // $mahasiswa->update($validated);

        
        // 2. AFTER - SETELAH MENERAPKAN TRANSACTION
        // 2.1. UPLOAD FOTO --> SEMENTARA SIMPAN PATH NYA

        $oldPhoto = $mahasiswa->foto;
        $newPhoto = null;

        if ($request->hasFile('foto')) {
            $newPhoto = $request->file('foto')->store('mahasiswa', 'public');
            $validated['foto'] = $newPhoto;
        }

        // 2.2. Transaction (DB only)
        DB::transaction(function () use ($validated, $mahasiswa) {
            $oldNama = $mahasiswa->nama;

            $mahasiswa->update($validated);

            DBLogActivities::create([
                DBLogActivities::ACTION_COLUMN => DBLogActivities::UPDATE,
                DBLogActivities::DESC_COLUMN => "Update mahasiswa: {$oldNama} menjadi {$validated['nama']}",
            ]);
        });

        // 4. Cleanup file lama (SETELAH sukses)
        if ($newPhoto && $newPhoto) {
            Storage::disk('public')->delete($oldPhoto);
        }

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
        // 1. BEFORE - SEBELUM MENGGUNAKAN TRANSACTION
        // Hapus foto dari storage (jika ada)
        // if ($mahasiswa->foto) {
        //     Storage::disk('public')->delete($mahasiswa->foto);
        // }
        // $mahasiswa->delete();

        // 2. AFTER - SETELAH MENGGUNAKAN TRANSACTION
        $fotoPath = $mahasiswa->foto;
        $nama = $mahasiswa->nama;

        DB::transaction(function () use ($mahasiswa, $nama) {
            $mahasiswa -> delete();
            
            DBLogActivities::create([
                DBLogActivities::ACTION_COLUMN => DBLogActivities::DELETE,
                DBLogActivities::DESC_COLUMN => "Hapus mahasiswa: {$nama}"
            ]);
        });

        if($fotoPath) {
            Storage::disk('public')->delete($fotoPath);
        }

        return redirect()
            ->route('mahasiswa.index')
            ->with('success', 'Data mahasiswa berhasil dihapus.');
    }
}