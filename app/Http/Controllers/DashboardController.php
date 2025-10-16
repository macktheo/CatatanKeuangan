<?php

namespace App\Http\Controllers;

use App\Models\Pemasukan;
use App\Models\Pengeluaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Menghitung mutasi bulanan, dimulai dari bulan transaksi paling awal (Historis).
     */
    private function getMonthlySummary($userId)
    {
        $minPemasukanDate = Pemasukan::where('user_id', $userId)->min('tanggal');
        $minPengeluaranDate = Pengeluaran::where('user_id', $userId)->min('tanggal');

        $minDate = null;
        if ($minPemasukanDate && $minPengeluaranDate) {
            $minDate = min($minPemasukanDate, $minPengeluaranDate);
        } elseif ($minPemasukanDate) {
            $minDate = $minPemasukanDate;
        } elseif ($minPengeluaranDate) {
            $minDate = $minPengeluaranDate;
        }

        if (!$minDate) {
            return [];
        }

        $startDate = Carbon::parse($minDate)->startOfMonth(); 
        $endDate = Carbon::now()->startOfMonth(); 
        $results = [];

        $date = $startDate->copy();
        while ($date->lte($endDate)) {
            
            $pemasukan = Pemasukan::where('user_id', $userId)
                ->whereYear('tanggal', $date->year)
                ->whereMonth('tanggal', $date->month)
                ->sum('jumlah');
                
            $pengeluaran = Pengeluaran::where('user_id', $userId)
                ->whereYear('tanggal', $date->year)
                ->whereMonth('tanggal', $date->month)
                ->sum('jumlah');
                
            $results[] = [
                'label' => $date->translatedFormat('M y'), 
                'pemasukan' => $pemasukan,
                'pengeluaran' => $pengeluaran,
            ];
            
            $date->addMonth(); 
        }
        
        return $results;
    }
    
    /**
     * Mengambil 5 transaksi terakhir (pemasukan & pengeluaran).
     */
    private function getLastTransactions($userId)
    {
         $transactions = DB::table('pemasukan')
            ->select('tanggal', DB::raw('jumlah as amount'), 'deskripsi', DB::raw("'Pemasukan' as type"))
            ->where('user_id', $userId)
            ->unionAll(
                DB::table('pengeluaran')
                    ->select('tanggal', DB::raw('jumlah as amount'), 'deskripsi', DB::raw("'Pengeluaran' as type"))
                    ->where('user_id', $userId)
            )
            ->orderBy('tanggal', 'desc')
            ->limit(5)
            ->get();
            
        return $transactions;
    }

    public function index(Request $request)
    {
        $userId = Auth::id();
        $bulanIni = now()->month;
        $tahunIni = now()->year;

        // 1. Informasi Saldo Total (Untuk Kartu)
        $totalPemasukan = Pemasukan::where('user_id', $userId)->sum('jumlah');
        $totalPengeluaran = Pengeluaran::where('user_id', $userId)->sum('jumlah');
        $saldoSaatIni = $totalPemasukan - $totalPengeluaran;
        
        // 2. Kinerja Bulan Ini (Untuk Kartu Pemasukan/Pengeluaran Bulanan)
        $pemasukanBulanIni = Pemasukan::where('user_id', $userId)
                                ->whereMonth('tanggal', $bulanIni)
                                ->whereYear('tanggal', $tahunIni)
                                ->sum('jumlah');
        $pengeluaranBulanIni = Pengeluaran::where('user_id', $userId)
                                ->whereMonth('tanggal', $bulanIni)
                                ->whereYear('tanggal', $tahunIni)
                                ->sum('jumlah');

        // 3. Data Chart & Transaksi Terakhir
        $chartData = $this->getMonthlySummary($userId); // Data historis untuk chart
        $lastTransactions = $this->getLastTransactions($userId); // 5 Transaksi terakhir

        return view('dashboard', compact(
            'saldoSaatIni', 
            'totalPemasukan',
            'totalPengeluaran',
            'pemasukanBulanIni', 
            'pengeluaranBulanIni',
            'chartData',      
            'lastTransactions'
        ));
    }
}