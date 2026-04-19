<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Admin</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        body {
            background: #f4f6f9;
        }
        .card {
            border-radius: 12px;
        }
    </style>
</head>

<body>

<div class="container mt-4">

    <h2 class="mb-4">Dashboard Admin Angkringan 👋</h2>

    <!-- 🔥 CARD STATISTIK -->
    <div class="row">

        <div class="col-md-3">
            <div class="card bg-primary text-white p-3">
                <h6>Total Pesanan</h6>
                <h3>{{ $totalPesanan }}</h3>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card bg-success text-white p-3">
                <h6>Pendapatan</h6>
                <h3>Rp {{ number_format($totalPendapatan) }}</h3>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card bg-warning text-white p-3">
                <h6>Jumlah Menu</h6>
                <h3>{{ $jumlahMenu }}</h3>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card bg-danger text-white p-3">
                <h6>Pending</h6>
                <h3>{{ $pesananPending }}</h3>
            </div>
        </div>

    </div>

    <!-- 📊 GRAFIK -->
    <div class="card mt-4">
        <div class="card-header">
            Grafik Penjualan
        </div>
        <div class="card-body">
            <canvas id="chartPenjualan"></canvas>
        </div>
    </div>

    <!-- 📋 TABEL PESANAN -->
    <div class="card mt-4">
        <div class="card-header">
            Pesanan Terbaru
        </div>

        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Total</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($pesananTerbaru as $p)
                    <tr>
                        <td>{{ $p->nama ?? '-' }}</td>
                        <td>Rp {{ number_format($p->total) }}</td>
                        <td>
                            @if($p->status == 'pending')
                                <span class="badge bg-warning">Pending</span>
                            @elseif($p->status == 'selesai')
                                <span class="badge bg-success">Selesai</span>
                            @else
                                <span class="badge bg-secondary">{{ $p->status }}</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>

            </table>
        </div>
    </div>

</div>

<!-- SCRIPT CHART -->
<script>
    const ctx = document.getElementById('chartPenjualan');

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'],
            datasets: [{
                label: 'Penjualan',
                data: [12, 19, 8, 15, 10],
                backgroundColor: 'orange'
            }]
        }
    });
</script>

</body>
</html>