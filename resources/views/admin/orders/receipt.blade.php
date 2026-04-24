<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Pesanan #{{ $order->id }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 24px;
            color: #111827;
        }
        .receipt {
            max-width: 420px;
            margin: 0 auto;
            border: 1px dashed #9ca3af;
            padding: 20px;
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
            padding: 6px 0;
            font-size: 13px;
            text-align: left;
            border-bottom: 1px dashed #d1d5db;
        }
        th:last-child, td:last-child {
            text-align: right;
        }
        .total {
            font-weight: bold;
            font-size: 15px;
        }
        .meta {
            font-size: 13px;
            margin-top: 10px;
            line-height: 1.6;
        }
        .actions {
            text-align: center;
            margin-top: 18px;
        }
        button {
            padding: 10px 16px;
            border: none;
            background: #111827;
            color: white;
            cursor: pointer;
        }
        @media print {
            .actions {
                display: none;
            }
            body {
                margin: 0;
            }
            .receipt {
                border: none;
            }
        }
    </style>
</head>
<body>
    <div class="receipt">
        <div class="title">
            <h2>Struk Pesanan</h2>
            <div>Angkringan</div>
        </div>

        <div class="meta">
            <div><strong>No Pesanan:</strong> #{{ $order->id }}</div>
            <div><strong>Nama:</strong> {{ $order->customer_name ?? '-' }}</div>
            <div><strong>Meja:</strong> {{ $order->table_number ?? '-' }}</div>
            <div><strong>Tanggal:</strong> {{ $order->created_at?->format('d-m-Y H:i') }}</div>
            <div><strong>Pembayaran:</strong> {{ $order->payment_status === 'paid' ? 'Dibayar' : 'Belum Dibayar' }}</div>
            <div><strong>Status:</strong> {{ $order->status === 'done' ? 'Selesai' : 'Pending' }}</div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Menu</th>
                    <th>Qty</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->items as $item)
                    <tr>
                        <td>{{ $item->product?->name ?? 'Menu terhapus' }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="2" class="total">Total</td>
                    <td class="total">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>

        <p class="center" style="margin-top: 18px;">Terima kasih</p>

        <div class="actions">
            <button onclick="window.print()">Cetak Struk</button>
        </div>
    </div>
</body>
</html>
