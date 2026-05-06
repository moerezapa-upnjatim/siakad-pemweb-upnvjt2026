@extends('layouts.app')

@section('title', 'Rekap Mahasiswa')

@section('content')
    <div class="bg-white rounded-lg shadow-sm p-6">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Rekap Mahasiswa</h1>
            </div>
            
        </div>

        <div class="grid grid-cols-3 gap-4 mb-6">
            <div class="bg-blue-100 p-4 rounded">
                <p class="text-sm">Total Mahasiswa</p>
                <p class="text-xl font-bold"> {{ $dataMahasiswaProdi->sum('total_mahasiswa') }} </p>
            </div>
        </div>

        {{-- CHART --}}
        <div class="mb-8">
            <h2 class="text-sm font-semibold mb-2">Jumlah Mahasiswa tiap Program Studi</h2>
            <canvas id="chartProdi"></canvas>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <!-- Chart 2: Angkatan -->
            <div class="bg-gray-50 p-4 rounded-lg h-64">
                <h2 class="text-sm font-semibold mb-2">Mahasiswa per Angkatan</h2>
                <canvas id="chartAngkatan"></canvas>
            </div>

            <!-- Chart 3: Gender -->
            <div class="bg-gray-50 p-4 rounded-lg h-64">
                <h2 class="text-sm font-semibold mb-2">Distribusi Gender</h2>
                <canvas id="chartGender"></canvas>
            </div>

        </div>

    </div>
@endsection

@push('scripts')
    <script>
        // =====================
        // DATA
        // =====================
        const dataProdi = @json($dataMahasiswaProdi);
        const dataAngkatan = @json($dataMahasiswaAngkatan);
        const dataGender = @json($dataMahasiswaPerGender);
        const dataAvgIPK = @json($dataAvgIPKPerProdi);
        
        // =====================
        // CHART INSTANCES
        // =====================
        const chartProdi = new Chart(document.getElementById('chartProdi'), {
            type: 'bar',
            data: {
                labels: dataProdi.map(i => i.prodi),
                datasets: [{
                    label: 'Mahasiswa per Prodi',
                    data: dataProdi.map(mhs => mhs.total_mahasiswa)
                }]
            },
            options: {
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });

        const chartAngkatan = new Chart(document.getElementById('chartAngkatan'), {
            type: 'line',
            data: {
                labels: dataAngkatan.map(i => i.angkatan),
                datasets: [{
                    label: 'Mahasiswa per Angkatan',
                    data: dataAngkatan.map(i => i.total),
                    tension: 0.3
                }]
            },
            options: {
                plugins: {
                    legend: {
                        display: false
                    }
                }
            } 
        });

        const chartGender = new Chart(document.getElementById('chartGender'), {
            type: 'bar',
            data: {
                labels: dataGender.map(mhs => mhs.jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan'),
                datasets: [{
                    data: dataGender.map(gender => gender.jumlah_mahasiswa)
                }]
            },
            options: {
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
    </script>
@endpush