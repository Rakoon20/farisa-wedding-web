<?php

namespace App\Exports;

use App\Models\Payment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class RevenueExport implements FromCollection, WithHeadings, WithMapping, WithEvents
{
    protected $startDate;
    protected $endDate;
    protected $total;

    public function __construct($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function collection()
    {
        $payments = Payment::with('order')
            ->where('is_confirmed', true)
            ->whereBetween('payment_date', [$this->startDate, $this->endDate])
            ->orderBy('payment_date', 'asc')
            ->get();
        $this->total = $payments->sum('amount');
        return $payments;
    }

    public function headings(): array
    {
        return [
            'No. Order',
            'Tipe Pembayaran',
            'Jumlah (Rp)',
            'Metode',
            'Tanggal Pembayaran',
        ];
    }

    public function map($payment): array
    {
        return [
            $payment->order->order_number ?? '-',
            match ($payment->type) {
                'dp' => 'DP Booking',
                'installment' => 'Cicilan',
                'final' => 'Pelunasan',
                default => $payment->type,
            },
            (int) $payment->amount, // integer
            $payment->method,
            $payment->payment_date?->format('d-m-Y') ?? '-',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet;
                $lastRow = $sheet->getHighestRow();

                // Format kolom jumlah (C) menjadi angka ribuan
                $sheet->getStyle("C2:C{$lastRow}")->getNumberFormat()->setFormatCode('#,##0');
                // Tambah baris total
                $rowTotal = $lastRow + 1;
                $sheet->setCellValue("C{$rowTotal}", $this->total);
                $sheet->setCellValue("A{$rowTotal}", "Total");
                $sheet->mergeCells("A{$rowTotal}:B{$rowTotal}");
                $sheet->getStyle("C{$rowTotal}")->getNumberFormat()->setFormatCode('#,##0');
                $sheet->getStyle("A{$rowTotal}:C{$rowTotal}")->getFont()->setBold(true);
                $sheet->getStyle("C{$rowTotal}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
            },
        ];
    }
}
