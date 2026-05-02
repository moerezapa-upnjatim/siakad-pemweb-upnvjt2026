<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\mahasiswa;

class MahasiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
        [
            'nim' => '202402001', 
            'nama' => 'Pradita', 
            'email' =>'202402001.if@student.ac.id',
            'jenis_kelamin' => 'L', 
            'tanggal_lahir' => '2005-03-15',
            'alamat' => 'Jl. Merdeka No. 10, Surabaya', 
            'no_hp' => '081234567001',
            'prodi' => 'Informatika', 'angkatan' => 2024, 'ipk' => 3.75,
            'status' => 'aktif',
        ],
        [
            'nim' => '202401001', 'nama' => 'Hafidz', 'email' => '202401001.si@student.ac.id',
            'jenis_kelamin' => 'P', 'tanggal_lahir' => '2005-07-22',
            'alamat' => 'Jl. Cihampelas No. 25, Mojokerto', 'no_hp' => '081234567002',
            'prodi' => 'Sistem Informasi', 'angkatan' => 2024, 'ipk' => 3.85, 'status' => 'aktif',
        ],
        [
            'nim' => '202301002', 'nama' => 'Musa Al', 'email' => '202401002.si@student.ac.id',
            'jenis_kelamin' => 'L', 'tanggal_lahir' => '2004-11-08',
            'alamat' => 'Jl. Asia Afrika No. 100, Surabaya', 'no_hp' => '081234567003',
            'prodi' => 'Sistem Informasi', 'angkatan' => 2023, 'ipk' => 3.50, 'status' => 'aktif',
        ],
        [
            'nim' => '202303001', 'nama' => 'Maryam', 'email' => '202303001.sd@student.ac.id',
            'jenis_kelamin' => 'P', 'tanggal_lahir' => '2005-01-30',
            'alamat' => 'Jl. Sudirman No. 50, Sidoarjo', 'no_hp' => '081234567004',
            'prodi' => 'Sains Data', 'angkatan' => 2023, 'ipk' => 3.92,
            'status' => 'aktif',
        ],
        [
            'nim' => '202304001', 'nama' => 'M. Raffasya', 'email' => '202204001.bd@student.ac.id',
            'jenis_kelamin' => 'L', 'tanggal_lahir' => '2003-09-12',
            'alamat' => 'Jl. Dipatiukur No. 15, Lamongan', 'no_hp' =>
            '081234567005',
            'prodi' => 'Bisnis Digital', 'angkatan' => 2022, 'ipk' => 3.40, 'status' => 'cuti',
        ],
        ];
        
        foreach ($data as $row) {
            mahasiswa::create($row);
        }
    }
    
}
