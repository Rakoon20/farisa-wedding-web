<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invoice - {{ $order->order_number }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            line-height: 1.6;
            color: #333;
        }
        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 30px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
            font-size: 16px;
        }
        .invoice-box table {
            width: 100%;
            line-height: inherit;
            text-align: left;
            border-collapse: collapse;
        }
        .invoice-box table td {
            padding: 5px;
            vertical-align: top;
        }
        .invoice-box table tr td:nth-child(2) {
            text-align: right;
        }
        .invoice-box table tr.top table td {
            padding-bottom: 20px;
        }
        .invoice-box table tr.top table td.title {
            font-size: 45px;
            line-height: 45px;
            color: #333;
        }
        .invoice-box table tr.information table td {
            padding-bottom: 40px;
        }
        .invoice-box table tr.heading td {
            background: #eee;
            border-bottom: 1px solid #ddd;
            font-weight: bold;
        }
        .invoice-box table tr.details td {
            padding-bottom: 20px;
        }
        .invoice-box table tr.item td {
            border-bottom: 1px solid #eee;
        }
        .invoice-box table tr.item.last td {
            border-bottom: none;
        }
        .invoice-box table tr.total td:nth-child(2) {
            border-top: 2px solid #eee;
            font-weight: bold;
        }
        @media only screen and (max-width: 600px) {
            .invoice-box table tr.top table td {
                width: 100%;
                display: block;
                text-align: center;
            }
            .invoice-box table tr.information table td {
                width: 100%;
                display: block;
                text-align: center;
            }
        }
        .text-right {
            text-align: right;
        }
        .mt-4 {
            margin-top: 1rem;
        }
        .font-bold {
            font-weight: bold;
        }
        hr {
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="invoice-box">
        <table cellpadding="0" cellspacing="0">
            <tr class="top">
                <td colspan="2">
                    <table>
                        <tr>
                            <td class="title">
                                <h2>Farisa Wedding & Decoration</h2>
                            </td>
                            <td class="text-right">
                                Invoice #: {{ $order->order_number }}<br>
                                Tanggal: {{ now()->format('d/m/Y') }}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr class="information">
                <td colspan="2">
                    <table>
                        <tr>
                            <td>
                                <strong>Informasi Pelanggan</strong><br>
                                Nama: {{ $order->customer_name }}<br>
                                Telepon: {{ $order->customer_phone }}<br>
                                Alamat Acara: {{ $order->customer_address ?? '-' }}
                            </td>
                            <td class="text-right">
                                <strong>Detail Acara</strong><br>
                                Tanggal Acara: {{ \Carbon\Carbon::parse($order->event_date)->format('d F Y') }}<br>
                                Paket: {{ $order->package->name ?? $order->package_code }}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr class="heading">
                <td>Deskripsi</td>
                <td class="text-right">Jumlah</td>
            </tr>

            <!-- Harga Paket -->
            <tr class="item">
                <td>{{ $order->package->name ?? $order->package_code }} (Paket)</td>
                <td class="text-right">Rp {{ number_format($order->package_price, 0, ',', '.') }}</td>
            </tr>

            <!-- Adjustment Items (jika ada) -->
            @foreach($order->orderItems as $item)
            <tr class="item">
                <td>{{ $item->item_name }} (x{{ $item->quantity }})</td>
                <td class="text-right">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
            </tr>
            @endforeach

            <!-- Biaya Tambahan (jika ada) -->
            @if($order->additional_charge > 0)
            <tr class="item">
                <td>{{ $order->charge_description ?? 'Biaya Tambahan' }}</td>
                <td class="text-right">Rp {{ number_format($order->additional_charge, 0, ',', '.') }}</td>
            </tr>
            @endif

            <!-- Total Harga -->
            <tr class="total">
                <td class="text-right font-bold">Total:</td>
                <td class="text-right font-bold">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
            </tr>
        </table>

        <!-- Riwayat Pembayaran -->
        <hr>
        <h3>Riwayat Pembayaran</h3>
        <table cellpadding="0" cellspacing="0">
            <tr class="heading">
                <td>Tipe</td>
                <td>Tanggal</td>
                <td class="text-right">Jumlah</td>
            </tr>
            @foreach($payments as $payment)
            <tr class="item">
                <td>{{ $payment->type == 'dp' ? 'DP Booking' : ($payment->type == 'final' ? 'Pelunasan' : 'Cicilan') }}</td>
                <td>{{ \Carbon\Carbon::parse($payment->payment_date)->format('d/m/Y') }}</td>
                <td class="text-right">Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
            </tr>
            @endforeach
            <tr class="total">
                <td colspan="2" class="text-right font-bold">Total Dibayar:</td>
                <td class="text-right font-bold">Rp {{ number_format($payments->sum('amount'), 0, ',', '.') }}</td>
            </tr>
        </table>

        <hr>
        <p class="text-center" style="font-size: 12px; color: #777;">Terima kasih telah mempercayakan acara spesial Anda kepada Farisa Wedding Organizer.</p>
    </div>
</body>
</html>