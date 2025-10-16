<form action="{{ isset($pemasukan) ? route('pemasukan.update', $pemasukan->id) : route('pemasukan.store') }}" 
      method="POST" 
      enctype="multipart/form-data" 
      class="row g-4">
    @csrf
    @if(isset($pemasukan))
        @method('PUT')
    @endif

    <div class="col-md-6">
        <label for="tanggal" class="form-label fw-bold">Tanggal Transaksi</label>
        <input type="date" class="form-control form-control-lg @error('tanggal') is-invalid @enderror" id="tanggal" name="tanggal" value="{{ old('tanggal', $pemasukan->tanggal ?? now()->format('Y-m-d')) }}" required>
        @error('tanggal')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-6">
        {{-- PERBAIKAN LABEL JUMLAH --}}
        <label for="jumlah" class="form-label fw-bold">Jumlah Pemasukan (Rp)</label>
        <input type="number" class="form-control form-control-lg @error('jumlah') is-invalid @enderror" id="jumlah" name="jumlah" value="{{ old('jumlah', $pemasukan->jumlah ?? '') }}" placeholder="Contoh: 500000" required min="100">
        @error('jumlah')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-12">
        {{-- PERBAIKAN LABEL DESKRIPSI --}}
        <label for="deskripsi" class="form-label fw-bold">Deskripsi / Sumber Pemasukan</label>
        <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi" rows="3" required>{{ old('deskripsi', $pemasukan->deskripsi ?? '') }}</textarea>
        @error('deskripsi')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    {{-- Fasilitas Gambar/Foto --}}
    <div class="col-md-12">
        <label for="bukti_gambar" class="form-label fw-bold"><i class="fas fa-camera me-1"></i> Bukti Foto / Gambar (Opsional)</label>
        <input type="file" class="form-control @error('bukti_gambar') is-invalid @enderror" id="bukti_gambar" name="bukti_gambar">
        @error('bukti_gambar')<div class="invalid-feedback">{{ $message }}</div>@enderror
        
        @if(isset($pemasukan) && $pemasukan->bukti_gambar)
            <div class="mt-3 p-3 border rounded bg-light">
                <p class="text-muted mb-1 fw-bold">Gambar saat ini:</p>
                <img src="{{ asset('storage/' . $pemasukan->bukti_gambar) }}" alt="Bukti Pemasukan" class="img-thumbnail" style="max-width: 200px; height: auto;">
                <small class="d-block mt-2">Upload file baru akan menggantikan gambar ini.</small>
            </div>
        @endif
    </div>

    <div class="col-12 mt-5">
        {{-- PERBAIKAN TOMBOL DAN WARNA (Merah ke Hijau) --}}
        <button type="submit" class="btn btn-success btn-lg me-3">
            <i class="fas fa-save me-1"></i> {{ isset($pemasukan) ? 'Simpan Perubahan' : 'Tambah Pemasukan' }}
        </button>
        <a href="{{ route('pemasukan.index') }}" class="btn btn-secondary btn-lg">Batal</a>
    </div>
</form>