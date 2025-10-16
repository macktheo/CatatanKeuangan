<?php

namespace App\Http\Controllers;

use App\Models\Pemasukan;
use App\Models\Pengeluaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    /**
     * Fungsi untuk mendapatkan data transaksi rinci (harian) berdasarkan filter.
     */
    private function getFilteredTransactions(Request $request): Collection
    {
        $userId = Auth::id();
        // Ambil input tanggal langsung dari Request yang dikirimkan ke index/exportPdf
        $tanggalMulai = $request->input('tanggal_mulai') ?? $request->tanggal_mulai;
        $tanggalSelesai = $request->input('tanggal_selesai') ?? $request->tanggal_selesai;
        $transaksi = collect();

        if ($tanggalMulai && $tanggalSelesai) {
            
            // Query Pemasukan
            $queryPemasukan = Pemasukan::select('tanggal', 'deskripsi', 'jumlah')
                                        ->where('user_id', $userId)
                                        ->whereDate('tanggal', '>=', $tanggalMulai)
                                        ->whereDate('tanggal', '<=', $tanggalSelesai);
            
            $pemasukanData = $queryPemasukan->get()->map(function($item) {
                $item->type = 'Pemasukan';
                return $item;
            });
            $transaksi = $transaksi->merge($pemasukanData);
            
            // Query Pengeluaran
            $queryPengeluaran = Pengeluaran::select('tanggal', 'deskripsi', 'jumlah')
                                            ->where('user_id', $userId)
                                            ->whereDate('tanggal', '>=', $tanggalMulai)
                                            ->whereDate('tanggal', '<=', $tanggalSelesai);
            
            $pengeluaranData = $queryPengeluaran->get()->map(function($item) {
                $item->type = 'Pengeluaran';
                return $item;
            });
            $transaksi = $transaksi->merge($pengeluaranData);
            
            // Mengurutkan berdasarkan tanggal
            return $transaksi->sortBy('tanggal')->values();
        }
        return $transaksi;
    }


    /**
     * Menampilkan halaman filter dan laporan Rincian Harian.
     */
    public function index(Request $request)
    {
        // Variabel untuk data rincian harian
        $transaksi = collect(); 
        $totalPemasukan = 0;
        $totalPengeluaran = 0;
        $saldoPeriode = 0;

        $tanggalMulai = $request->input('tanggal_mulai');
        $tanggalSelesai = $request->input('tanggal_selesai');

        // --- Logika Penentuan Tanggal (Default atau Input User) ---
        // Jika tidak ada input tanggal SAMA SEKALI (akses pertama kali), atur default tahun berjalan.
        if (!$request->input('tanggal_mulai') && !$request->input('tanggal_selesai')) {
             $now = Carbon::now();
             $tanggalMulai = $now->copy()->startOfYear()->format('Y-m-d'); 
             $tanggalSelesai = $now->format('Y-m-d'); 
        }
        // -----------------------------------------------------------

        // Perhitungan selalu dijalankan jika TANGGAL ADA
        if ($tanggalMulai && $tanggalSelesai) {
            
            // Ambil Rincian Transaksi Harian
            $transaksi = $this->getFilteredTransactions($request);
            
            // Hitung Grand Total
            $totalPemasukan = $transaksi->where('type', 'Pemasukan')->sum('jumlah');
            $totalPengeluaran = $transaksi->where('type', 'Pengeluaran')->sum('jumlah');
            $saldoPeriode = $totalPemasukan - $totalPengeluaran;
        }

        // Catatan: Variabel $monthlyData dihapus, diganti $transaksi
        return view('laporan.index', compact(
            'tanggalMulai', 'tanggalSelesai',
            'totalPemasukan', 'totalPengeluaran', 'saldoPeriode', 
            'transaksi' 
        ));
    }


    /**
     * Fungsi untuk EKSPOR DATA RINCI ke PDF.
     */
    public function exportPdf(Request $request)
    {
        // 1. Validasi Filter Tanggal
        if (!$request->tanggal_mulai || !$request->tanggal_selesai) {
            return redirect()->route('laporan.index')->with('error', 'Pilih rentang tanggal untuk ekspor PDF.');
        }

        $tanggalMulai = $request->tanggal_mulai;
        $tanggalSelesai = $request->tanggal_selesai;

        // 2. Ambil data rinci harian
        $transaksi = $this->getFilteredTransactions($request);

        if ($transaksi->isEmpty()) {
            return redirect()->route('laporan.index')->with('error', 'Tidak ada data untuk diekspor ke PDF.');
        }

        // 3. Hitung Total Summary
        $totalPemasukan = $transaksi->where('type', 'Pemasukan')->sum('jumlah');
        $totalPengeluaran = $transaksi->where('type', 'Pengeluaran')->sum('jumlah');
        $saldoPeriode = $totalPemasukan - $totalPengeluaran;

        // 4. Siapkan data untuk View PDF
        $data = compact('transaksi', 'tanggalMulai', 'tanggalSelesai', 'totalPemasukan', 'totalPengeluaran', 'saldoPeriode');
        
        // 5. Generate PDF
        // Memanggil View PDF Rincian Harian
        $pdf = Pdf::loadView('laporan.pdf_rincian', $data); 

        $filename = 'Laporan_Rincian_Harian_' . Carbon::now()->format('Ymd') . '.pdf';

        return $pdf->download($filename);
    }
}