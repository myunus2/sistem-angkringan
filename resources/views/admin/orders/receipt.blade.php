<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Struk #{{ $order->id }}</title>

<style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        color: #111827;
        background: #f3f4f6;
    }

    .receipt {
        width: 58mm;
        box-sizing: border-box;
        margin: 24px auto;
        border: 1px dashed #9ca3af;
        padding: 4mm;
        background: white;
    }

    .title, .center {
        text-align: center;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 12px;
    }

    th, td {
        padding: 4px 0;
        font-size: 11px;
        border-bottom: 1px dashed #d1d5db;
    }

    th:last-child, td:last-child {
        text-align: right;
    }

    .total {
        font-weight: bold;
        font-size: 12px;
    }

    .meta {
        font-size: 11px;
        margin-top: 10px;
        line-height: 1.6;
    }

    .line {
        border-top: 1px dashed #999;
        margin: 10px 0;
    }

    button {
        padding: 10px 16px;
        border: none;
        background: #111827;
        color: white;
        cursor: pointer;
        margin-top: 15px;
    }

    @page {
        size: 58mm auto;
        margin: 0;
    }

    @media print {
        button { display: none; }
        body {
            width: 58mm;
            margin: 0;
            background: white;
        }
        .receipt {
            width: 58mm;
            margin: 0;
            border: none;
            padding: 4mm;
        }
    }
</style>
</head>

<body>

<div class="receipt">

    <div class="title">
        <h2>ANGKRINGAN POS</h2>
        <div>STRUK PEMBAYARAN</div>
    </div>

    <div class="line"></div>

    <!-- META -->
    <div class="meta">
        <div><strong>No:</strong> {{ $order->id }}</div>
        <div><strong>Nama:</strong> {{ $order->customer_name ?? '-' }}</div>
        <div><strong>Meja:</strong> {{ $order->table_number ?? '-' }}</div>
        <div><strong>Tanggal:</strong> {{ $order->created_at->format('d-m-Y H:i') }}</div>

        <!-- 💰 UANG BAYAR -->
        <div><strong>Uang Bayar:</strong> Rp {{ number_format($order->cash ?? 0, 0, ',', '.') }}</div>
    </div>

    <div class="line"></div>

    <!-- ITEM -->
    <table>
        <thead>
            <tr>
                <th>Menu</th>
                <th>Qty</th>
                <th>Subtotal</th>
            </tr>
        </thead>

        <tbody>
            @php $total = 0; @endphp

            @foreach ($order->items as $item)
                @php
                    $subtotal = $item->price * $item->quantity;
                    $total += $subtotal;
                @endphp

                <tr>
                    <td>{{ $item->product?->name }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                </tr>
            @endforeach

            <!-- TOTAL -->
            <tr>
                <td colspan="2" class="total">TOTAL</td>
                <td class="total">Rp {{ number_format($total, 0, ',', '.') }}</td>
            </tr>

            <!-- 🔁 KEMBALIAN -->
            <tr>
                <td colspan="2">Kembalian</td>
                <td>
                    Rp {{ number_format(max(($order->cash ?? 0) - $total, 0), 0, ',', '.') }}
                </td>
            </tr>

        </tbody>
    </table>

    <div class="line"></div>

    <div class="center">
        <b>Terima kasih 🙏</b><br>
        Selamat datang kembali
    </div>

    <div class="center">
        <button onclick="window.print()">Cetak Struk</button>
    </div>

</div>

</body>
</html>
