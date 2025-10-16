<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Carbon\Carbon;

class LaporanExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    protected $transaksi;

    public function __construct(Collection $transaksi)
    {
        $this->transaksi = $transaksi;
    }

    public function collection()
    {
        // Memproses data Collection sebelum diekspor
        return $this->transaksi->map(function ($item, $key) {
            return [
                'No' => $key + 1,
                'Tanggal' => Carbon::parse($item->tanggal)->format('d-m-Y'),
                'Jenis' => $item->type,
                'Deskripsi' => $item->deskripsi,
                'Jumlah' => $item->jumlah,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'No',
            'Tanggal',
            'Jenis',
            'Deskripsi',
            'Jumlah (Rp)',
        ];
    }
}