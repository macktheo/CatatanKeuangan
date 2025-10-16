<!DOCTYPE html>
<html>
<head>
    <title>Laporan Rincian Transaksi Harian</title>
    <style>
        body { font-family: sans-serif; font-size: 10px; margin: 0; padding: 0; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h3 { margin: 0; color: #34495e; }
        .header p { margin-top: 5px; color: #7f8c8d; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2ff; font-weight: bold; }
        .footer { font-weight: bold; background-color: #ccf; }
        .text-success { color: #2ecc71; }
        .text-danger { color: #e74c3c; }
        .text-end { text-align: right; }
    </style>
</head>
<body>

    <div class="header">
        <h3>LAPORAN RINCIAN TRANSAKSI HARIAN</h3>
        <p>Periode: {{ \Carbon\Carbon::parse($tanggalMulai)->format('d/m/Y') }} s/d {{ \Carbon\Carbon::parse($tanggalSelesai)->format('d/m/Y') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 15%;">Tanggal</th>
                <th style="width: 15%;">Jenis</th>
                <th style="width: 45%;">Deskripsi</th>
                <th style="width: 25%;" class="text-end">Jumlah (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transaksi as $item)
                @php
                    $color = $item->type === 'Pemasukan' ? 'text-success' : 'text-danger';
                @endphp
                <tr>
                    <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}</td>
                    <td class="{{ $color }}">{{ $item->type }}</td>
                    <td>{{ $item->deskripsi }}</td>
                    <td class="text-end {{ $color }}">{{ number_format($item->jumlah, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="footer">
                <td colspan="3" class="text-end">TOTAL PEMASUKAN</td>
                <td class="text-end text-success">{{ number_format($totalPemasukan, 0, ',', '.') }}</td>
            </tr>
            <tr class="footer">
                <td colspan="3" class="text-end">TOTAL PENGELUARAN</td>
                <td class="text-end text-danger">{{ number_format($totalPengeluaran, 0, ',', '.') }}</td>
            </tr>
            <tr class="footer">
                <td colspan="3" class="text-end">SISA SALDO PERIODE</td>
                <td class="text-end">{{ number_format($saldoPeriode, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>
</body>
</html>