<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Pendapatan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        h2 {
            text-align: center;
            color: #333;
        }
        .periode {
            text-align: center;
            margin-bottom: 20px;
            font-size: 14px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .total-row {
            font-weight: bold;
            background-color: #f9f9f9;
        }
        .text-right {
            text-align: right;
        }
        .footer {
            margin-top: 20px;
            font-size: 12px;
            text-align: right;
            color: #666;
        }
    </style>
</head>
<body>
    <h2>Laporan Pendapatan Wedding Organizer</h2>
    <div class="periode">
        Periode: {{ $start->format('d M Y') }} - {{ $end->format('d M Y') }}
    </div>

    <table>
        <thead>
            <tr>
                <th>No. Order</th>
                <th>Tipe Pembayaran</th>
                <th class="text-right">Jumlah (Rp)</th>
                <th>Metode</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($payments as $payment)
            <tr>
                <td>{{ $payment->order->order_number ?? '-' }}</td>
                <td>
                    @switch($payment->type)
                        @case('dp') DP Booking @break
                        @case('installment') Cicilan @break
                        @case('final') Pelunasan @break
                        @default {{ $payment->type }}
                    @endswitch
                </td>
                <td class="text-right">{{ number_format($payment->amount, 0, ',', '.') }}</td>
                <td>{{ strtoupper($payment->method) }}</td>
                <td>{{ $payment->payment_date?->format('d-m-Y') ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="total-row">
                <td colspan="2" class="text-right"><strong>Total Pendapatan:</strong></td>
                <td class="text-right"><strong>Rp {{ number_format($total, 0, ',', '.') }}</strong></td>
                <td colspan="2"></td>
            </tr>
        </tfoot>
    </table>

    <div class="footer">
        Dicetak pada: {{ now()->format('d M Y H:i') }}
    </div>
</body>
</html>