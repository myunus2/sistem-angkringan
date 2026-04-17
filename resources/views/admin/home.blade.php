@extends('layouts.app')

@section('content')
<div class="container">

    <h2 class="mb-4">Dashboard Admin Angkringan 👋</h2>

    <div class="row">

        <!-- Total Pesanan -->
        <div class="col-md-4">
            <div class="card text-white bg-primary mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total Pesanan</h5>
                    <h3>25</h3>
                </div>
            </div>
        </div>

        <!-- Pendapatan -->
        <div class="col-md-4">
            <div class="card text-white bg-success mb-3">
                <div class="card-body">
                    <h5 class="card-title">Pendapatan</h5>
                    <h3>Rp 500.000</h3>
                </div>
            </div>
        </div>

        <!-- Menu -->
        <div class="col-md-4">
            <div class="card text-white bg-warning mb-3">
                <div class="card-body">
                    <h5 class="card-title">Jumlah Menu</h5>
                    <h3>15</h3>
                </div>
            </div>
        </div>

    </div>

    <!-- Tabel Pesanan -->
    <div class="card mt-4">
        <div class="card-header">
            Pesanan Terbaru
        </div>
        <div class="card-body">
            <table class="table">
                <tr>
                    <th>Nama</th>
                    <th>Menu</th>
                    <th>Status</th>
                </tr>
                <tr>
                    <td>Anis</td>
                    <td>Nasi Kucing</td>
                    <td><span class="badge bg-success">Selesai</span></td>
                </tr>
            </table>
        </div>
    </div>

</div>
@endsection