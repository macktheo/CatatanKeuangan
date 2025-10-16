<?php

namespace App\Http\Controllers;

use App\Models\Pemasukan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PemasukanController extends Controller
{
    /**
     * Menampilkan daftar data pemasukan (READ).
     */
    public function index()
    {
        $pemasukan = Pemasukan::where('user_id', Auth::id())
                                ->latest()
                                ->paginate(10);
        return view('pemasukan.index', compact('pemasukan'));
    }

    /**
     * Menampilkan form untuk membuat pemasukan baru.
     */
    public function create()
    {
        return view('pemasukan.create');
    }

    /**
     * Menyimpan data pemasukan baru ke database (CREATE).
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'tanggal' => 'required|date',
            'deskripsi' => 'required|string|max:255',
            'jumlah' => 'required|numeric|min:100',
            'bukti_gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Fasilitas Gambar
        ]);

        $path = null;
        if ($request->hasFile('bukti_gambar')) {
            // Simpan file di storage/app/public/bukti_pemasukan
            $path = $request->file('bukti_gambar')->store('bukti_pemasukan', 'public');
        }

        Pemasukan::create([
            'user_id' => Auth::id(),
            'tanggal' => $validatedData['tanggal'],
            'deskripsi' => $validatedData['deskripsi'],
            'jumlah' => $validatedData['jumlah'],
            'bukti_gambar' => $path,
        ]);

        return redirect()->route('pemasukan.index')->with('success', 'Data Pemasukan berhasil ditambahkan!');
    }

    /**
     * Menampilkan form untuk mengedit pemasukan.
     */
    public function edit(Pemasukan $pemasukan)
    {
        if ($pemasukan->user_id !== Auth::id()) {
            abort(403); 
        }
        return view('pemasukan.edit', compact('pemasukan'));
    }

    /**
     * Memperbarui data pemasukan di database (UPDATE).
     */
  // app/Http/Controllers/PemasukanController.php

public function update(Request $request, Pemasukan $pemasukan)
{
    // Cek otorisasi
    if ($pemasukan->user_id !== Auth::id()) {
        abort(403);
    }
    
    // 1. Validasi
    $validatedData = $request->validate([
        'tanggal' => 'required|date',
        'deskripsi' => 'required|string|max:255',
        'jumlah' => 'required|numeric|min:100',
        'bukti_gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', 
    ]);

    // 2. Handle Gambar
    $path = $pemasukan->bukti_gambar; // Pertahankan gambar lama
    if ($request->hasFile('bukti_gambar')) {
        // Hapus gambar lama jika ada
        if ($pemasukan->bukti_gambar) {
            Storage::disk('public')->delete($pemasukan->bukti_gambar);
        }
        // Simpan gambar baru
        $path = $request->file('bukti_gambar')->store('bukti_pemasukan', 'public');
    }

    // 3. Update Data
    $pemasukan->update([
        'tanggal' => $validatedData['tanggal'],
        'deskripsi' => $validatedData['deskripsi'],
        'jumlah' => $validatedData['jumlah'],
        'bukti_gambar' => $path,
    ]);

    return redirect()->route('pemasukan.index')->with('success', 'Data Pemasukan berhasil diperbarui!');
}
    /**
     * Menghapus data pemasukan dari database (DELETE).
     */
    public function destroy(Pemasukan $pemasukan)
    {
        if ($pemasukan->user_id !== Auth::id()) {
            abort(403);
        }
        
        if ($pemasukan->bukti_gambar) {
            Storage::disk('public')->delete($pemasukan->bukti_gambar);
        }

        $pemasukan->delete();

        return redirect()->route('pemasukan.index')->with('success', 'Data Pemasukan berhasil dihapus!');
    }
}