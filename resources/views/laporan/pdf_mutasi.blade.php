<!DOCTYPE html>
<html>
<head>
    <title>Laporan Mutasi Keuangan</title>
    <style>
        body { font-family: sans-serif; font-size: 10px; margin: 0; padding: 0; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h3 { margin: 0; color: #34495e; }
        .header p { margin-top: 5px; color: #7f8c8d; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: right; }
        th { background-color: #f2f2ff; font-weight: bold; text-align: center; }
        .footer { font-weight: bold; background-color: #ddf; }
        .total-summary { width: 40%; margin-left: auto; margin-right: 0; }
        .text-success { color: #2ecc71; }
        .text-danger { color: #e74c3c; }
    </style>
</head>
<body>

    <div class="header">
        <h3>LAPORAN MUTASI BULANAN</h3>
        <p>Periode: {{ \Carbon\Carbon::parse($tanggalMulai)->format('d/m/Y') }} s/d {{ \Carbon\Carbon::parse($tanggalSelesai)->format('d/m/Y') }}</p>
        <p>Dicetak pada: {{ \Carbon\Carbon::now()->format('d/m/Y') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 25%; text-align: left;">Bulan</th>
                <th>Pemasukan (Rp)</th>
                <th>Pengeluaran (Rp)</th>
                <th>Selisih (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($monthlyData as $data)
                <tr>
                    <td style="text-align: left;">{{ $data['bulan'] }}</td>
                    <td class="text-success">{{ number_format($data['pemasukan'], 0, ',', '.') }}</td>
                    <td class="text-danger">{{ number_format($data['pengeluaran'], 0, ',', '.') }}</td>
                    <td>{{ number_format($data['selisih'], 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="footer">
                <td style="text-align: left;">TOTAL KESELURUHAN</td>
                <td class="text-success">{{ number_format($totalPemasukan, 0, ',', '.') }}</td>
                <td class="text-danger">{{ number_format($totalPengeluaran, 0, ',', '.') }}</td>
                <td>{{ number_format($saldoPeriode, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>

    <br>
    
    <table class="total-summary">
        <tr>
            <th style="text-align: left;">GRAND TOTAL PEMASUKAN</th>
            <td class="text-success">{{ number_format($totalPemasukan, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <th style="text-align: left;">GRAND TOTAL PENGELUARAN</th>
            <td class="text-danger">{{ number_format($totalPengeluaran, 0, ',', '.') }}</td>
        </tr>
        <tr style="background-color: #ccf;">
            <th style="text-align: left;">SISA SALDO PERIODE</th>
            <td>{{ number_format($saldoPeriode, 0, ',', '.') }}</td>
        </tr>
    </table>

</body>
</html>