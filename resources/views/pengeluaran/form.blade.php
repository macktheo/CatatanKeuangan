<form action="{{ isset($pengeluaran) ? route('pengeluaran.update', $pengeluaran->id) : route('pengeluaran.store') }}" 
      method="POST" 
      enctype="multipart/form-data" 
      class="row g-4">
    @csrf
    {{-- Wajib untuk mode Edit/Update --}}
    @if(isset($pengeluaran))
        @method('PUT')
    @endif

    {{-- BARIS 1: Tanggal Transaksi --}}
    <div class="col-md-6">
        <label for="tanggal" class="form-label fw-bold">Tanggal Transaksi</label>
        <input type="date" class="form-control form-control-lg @error('tanggal') is-invalid @enderror" id="tanggal" name="tanggal" 
               {{-- Mengisi nilai lama --}}
               value="{{ old('tanggal', $pengeluaran->tanggal ?? now()->format('Y-m-d')) }}" required>
        @error('tanggal')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    {{-- BARIS 2: Jumlah Pengeluaran --}}
    <div class="col-md-6">
        <label for="jumlah" class="form-label fw-bold">Jumlah Pengeluaran (Rp)</label>
        <input type="number" class="form-control form-control-lg @error('jumlah') is-invalid @enderror" id="jumlah" name="jumlah" 
               {{-- Mengisi nilai lama --}}
               value="{{ old('jumlah', $pengeluaran->jumlah ?? '') }}" placeholder="Contoh: 150000" required min="100">
        @error('jumlah')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    {{-- BARIS 3: Deskripsi / Tujuan Pengeluaran (Full Width) --}}
    <div class="col-12">
        <label for="deskripsi" class="form-label fw-bold">Deskripsi / Tujuan Pengeluaran</label>
        <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi" rows="3" required>{{ old('deskripsi', $pengeluaran->deskripsi ?? '') }}</textarea>
        @error('deskripsi')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    {{-- BARIS 4: Bukti Foto / Gambar (Full Width) --}}
    <div class="col-md-12">
        <label for="bukti_gambar" class="form-label fw-bold"><i class="fas fa-camera me-1"></i> Bukti Foto / Gambar (Opsional)</label>
        <input type="file" class="form-control @error('bukti_gambar') is-invalid @enderror" id="bukti_gambar" name="bukti_gambar">
        @error('bukti_gambar')<div class="invalid-feedback">{{ $message }}</div>@enderror
        
        {{-- Logika Preview Gambar Lama --}}
        @if(isset($pengeluaran) && $pengeluaran->bukti_gambar)
            <div class="mt-3 p-3 border rounded bg-light">
                <p class="text-muted mb-1 fw-bold">Gambar saat ini:</p>
                <img src="{{ asset('storage/' . $pengeluaran->bukti_gambar) }}" alt="Bukti Pengeluaran" class="img-thumbnail" style="max-width: 200px; height: auto;">
                <small class="d-block mt-2 text-danger">Upload file baru akan menggantikan gambar ini.</small>
            </div>
        @endif
    </div>
    
    {{-- BARIS 5: Tombol Aksi --}}
    <div class="col-12 mt-5">
        <button type="submit" class="btn btn-danger btn-lg me-3">
            <i class="fas fa-save me-1"></i> {{ isset($pengeluaran) ? 'Simpan Perubahan' : 'Tambah Pengeluaran' }}
        </button>
        <a href="{{ route('pengeluaran.index') }}" class="btn btn-secondary btn-lg">Batal</a>
    </div>
</form>