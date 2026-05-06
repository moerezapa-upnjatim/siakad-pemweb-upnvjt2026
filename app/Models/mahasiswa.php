<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;;

class mahasiswa extends Model
{
    use HasFactory;

    /**
    * Nama tabel di database
    */
    protected $table = 'mahasiswa';

    /**
    * Kolom yang boleh diisi mass-assignment
    */

    protected $fillable = [
        'nim',
        'nama',
        'email',
        'jenis_kelamin',
        'tanggal_lahir',
        'alamat',
        'no_hp',
        'foto',
        'prodi',
        'angkatan',
        'ipk',
        'status',
    ];
    /**
    * Casting tipe data
    */
    protected $casts = [
        'tanggal_lahir' => 'date',
        'ipk' => 'decimal:2',
    ];
    /**
    * Accessor untuk label jenis kelamin
    */
    public function getJenisKelaminLabelAttribute()
    {
        return $this->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan';
    }
    /**
    * Accessor untuk URL foto
    */
    public function getFotoUrlAttribute()
    {
        if ($this->foto) {
            return asset('storage/' . $this->foto);
        }
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->nama) .'&background=2563eb&color=fff';
    }
}
