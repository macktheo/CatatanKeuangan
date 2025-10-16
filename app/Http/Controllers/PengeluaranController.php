<?php

namespace App\Http\Controllers;

use App\Models\Pengeluaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PengeluaranController extends Controller
{
    /**
     * Menampilkan daftar data pengeluaran (READ).
     */
    public function index()
    {
        $pengeluaran = Pengeluaran::where('user_id', Auth::id())
                                ->latest()
                                ->paginate(10);
                                
        return view('pengeluaran.index', compact('pengeluaran'));
    }

    /**
     * Menampilkan form untuk membuat pengeluaran baru.
     */
    public function create()
    {
        return view('pengeluaran.create');
    }

    /**
     * Menyimpan data pengeluaran baru ke database (CREATE).
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'tanggal' => 'required|date',
            'deskripsi' => 'required|string|max:255',
            'jumlah' => 'required|numeric|min:100',
            'bukti_gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', 
        ]);

        $path = null;
        if ($request->hasFile('bukti_gambar')) {
            $path = $request->file('bukti_gambar')->store('bukti_pengeluaran', 'public');
        }

        Pengeluaran::create([
            'user_id' => Auth::id(),
            'tanggal' => $validatedData['tanggal'],
            'deskripsi' => $validatedData['deskripsi'],
            'jumlah' => $validatedData['jumlah'],
            'bukti_gambar' => $path,
        ]);

        return redirect()->route('pengeluaran.index')->with('success', 'Data Pengeluaran berhasil ditambahkan!');
    }

    /**
     * Menampilkan form untuk mengedit pengeluaran.
     */
    public function edit(Pengeluaran $pengeluaran)
    {
        if ($pengeluaran->user_id !== Auth::id()) {
            abort(403);
        }
        return view('pengeluaran.edit', compact('pengeluaran'));
    }

    /**
     * Memperbarui data pengeluaran di database (UPDATE).
     */
    public function update(Request $request, Pengeluaran $pengeluaran)
    {
        // Otorisasi
        if ($pengeluaran->user_id !== Auth::id()) {
            abort(403);
        }
        
        // 1. Validasi
        $validatedData = $request->validate([
            'tanggal' => 'required|date',
            'deskripsi' => 'required|string|max:255',
            'jumlah' => 'required|numeric|min:100',
            'bukti_gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', 
        ]);

        // 2. Handle Gambar (Logika Kunci)
        $path = $pengeluaran->bukti_gambar; // Tetapkan path lama secara default
        if ($request->hasFile('bukti_gambar')) {
            // Hapus file lama dari storage jika ada
            if ($pengeluaran->bukti_gambar) {
                Storage::disk('public')->delete($pengeluaran->bukti_gambar);
            }
            // Simpan file baru
            $path = $request->file('bukti_gambar')->store('bukti_pengeluaran', 'public');
        }

        // 3. Update Data di Database
        $pengeluaran->update([
            'tanggal' => $validatedData['tanggal'],
            'deskripsi' => $validatedData['deskripsi'],
            'jumlah' => $validatedData['jumlah'],
            'bukti_gambar' => $path,
        ]);

        return redirect()->route('pengeluaran.index')->with('success', 'Data Pengeluaran berhasil diperbarui!');
    } // <--- KURUNG KURAWAL PENUTUP FUNGSI UPDATE

    /**
     * Menghapus data pengeluaran dari database (DELETE).
     */
    public function destroy(Pengeluaran $pengeluaran)
    {
        if ($pengeluaran->user_id !== Auth::id()) {
            abort(403);
        }
        
        if ($pengeluaran->bukti_gambar) {
            Storage::disk('public')->delete($pengeluaran->bukti_gambar);
        }

        $pengeluaran->delete();

        return redirect()->route('pengeluaran.index')->with('success', 'Data Pengeluaran berhasil dihapus!');
    }
} // <--- KURUNG KURAWAL PENUTUP CLASS