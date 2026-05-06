<?php

namespace App\Http\Controllers;

use App\Models\mahasiswa;

class ReportController extends Controller
{
    public function index() {
        $dataMahasiswaProdi = mahasiswa::selectRaw('prodi, COUNT(*) as total_mahasiswa')
            ->groupBy('prodi')
            ->orderBy('prodi')
            ->get();

        $dataMahasiswaAngkatan = mahasiswa::selectRaw('angkatan, COUNT(*) as total')
            ->groupBy('angkatan')
            ->orderBy('angkatan')
            ->get();

        $dataMahasiswaPerGender = mahasiswa::selectRaw('jenis_kelamin, COUNT(*) as jumlah_mahasiswa')
            ->groupBy('jenis_kelamin')
            ->get();

        $dataAvgIPKPerProdi = mahasiswa::selectRaw('prodi, AVG(ipk) as avg_ipk')
            ->groupBy('prodi')
            ->orderBy('avg_ipk')
            ->get();

        return view('report.index', compact(
            'dataMahasiswaProdi',
            'dataMahasiswaAngkatan',
            'dataMahasiswaPerGender',
            'dataAvgIPKPerProdi'
            ));
    }
}
