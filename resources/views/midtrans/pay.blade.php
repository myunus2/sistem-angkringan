<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pembayaran Midtrans</title>

    <script src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f7f7f7;
            color: #1f2937;
        }

        .navbar {
            background: white;
            padding: 20px 60px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            font-size: 22px;
            font-weight: bold;
            color: #ea580c;
        }

        .container {
            max-width: 650px;
            margin: 70px auto;
            background: white;
            border-radius: 18px;
            padding: 35px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.08);
            text-align: center;
        }

        .icon {
            width: 80px;
            height: 80px;
            background: #22c55e;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 34px;
        }

        h1 {
            margin-bottom: 10px;
            font-size: 28px;
        }

        .subtitle {
            color: #6b7280;
            margin-bottom: 30px;
        }

        .card {
            text-align: left;
            border: 1px solid #e5e7eb;
            border-radius: 14px;
            padding: 25px;
            margin-bottom: 25px;
        }

        .row {
            display: flex;
            justify-content: space-between;
            margin: 15px 0;
            font-size: 16px;
        }

        .total {
            border-top: 1px solid #e5e7eb;
            padding-top: 20px;
            margin-top: 20px;
            font-size: 22px;
            font-weight: bold;
        }

        .price {
            color: #ea580c;
            font-size: 30px;
            font-weight: bold;
        }

        button {
            width: 100%;
            padding: 16px;
            border: none;
            border-radius: 10px;
            background: #ea580c;
            color: white;
            font-size: 18px;
            font-weight: bold;
            cursor: pointer;
        }

        button:hover {
            background: #c2410c;
        }

        .safe {
            margin-top: 15px;
            color: #6b7280;
            font-size: 14px;
        }
    </style>
</head>
<body>

    <div class="navbar">
        Angkringan Cakra Digital
    </div>

    <div class="container">
        <div class="icon">✓</div>

        <h1>Pembayaran Pesanan</h1>
        <p class="subtitle">Selesaikan pembayaran untuk melanjutkan pesanan Anda</p>

        <div class="card">
            <h3>Ringkasan Pesanan</h3>

            <div class="row">
                <span>Order ID</span>
                <strong>#{{ $order->id }}</strong>
            </div>

            <div class="row">
                <span>Nama</span>
                <strong>{{ $order->customer_name ?? 'Pelanggan' }}</strong>
            </div>

            <div class="row">
                <span>Nomor Meja</span>
                <strong>{{ $order->table_number ?? '-' }}</strong>
            </div>

            <div class="row total">
                <span>Total Pembayaran</span>
                <span class="price">Rp{{ number_format($order->total_price, 0, ',', '.') }}</span>
            </div>

            <button id="pay-button">
                Bayar Sekarang
            </button>

            <p class="safe">🔒 Pembayaran aman melalui Midtrans</p>
        </div>
    </div>

    <script>
        document.getElementById('pay-button').onclick = function () {
            snap.pay('{{ $snapToken }}');
        };
    </script>

</body>
</html>