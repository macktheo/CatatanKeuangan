# 💰 Aplikasi Catatan Keuangan

Aplikasi **Catatan Keuangan** adalah sistem berbasis web yang dikembangkan menggunakan **Laravel Framework** dan lingkungan pengembangan **Laragon**.  
Aplikasi ini membantu pengguna — terutama mahasiswa — dalam mencatat, memantau, dan menganalisis pemasukan serta pengeluaran secara efisien.

---

## 📚 Daftar Isi
- [Latar Belakang](#-latar-belakang)
- [Fitur Utama](#-fitur-utama)
- [Teknologi yang Digunakan](#-teknologi-yang-digunakan)
- [Struktur Database](#-struktur-database)
- [Konsep MVC](#-konsep-mvc)
- [Instalasi dan Konfigurasi](#-instalasi-dan-konfigurasi)
- [Tampilan Aplikasi](#-tampilan-aplikasi)
- [Pengembang](#-pengembang)

---

## 🎯 Latar Belakang
Aplikasi ini dikembangkan sebagai solusi terhadap masalah manajemen finansial pribadi di kalangan mahasiswa.  
Seringkali mahasiswa kesulitan menyeimbangkan kebutuhan akademik, sosial, dan keuangan.  
Aplikasi ini memberikan **alat bantu visual dan akurat** untuk:
- Mencatat pemasukan dan pengeluaran,
- Melihat grafik mutasi keuangan,
- Menghasilkan laporan transaksi harian dalam format **PDF**.

Tujuannya adalah **mendorong disiplin finansial dan pengambilan keputusan yang lebih bijak.**

---

## ⚙️ Fitur Utama

✅ **Autentikasi User**
- Registrasi dan login pengguna.  
- Role-based access (admin & user).

✅ **CRUD Transaksi**
- Tambah, ubah, hapus, dan tampilkan **Pemasukan** dan **Pengeluaran**.  
- Upload **bukti gambar/foto** transaksi.

✅ **Dashboard Dinamis**
- Menampilkan saldo total, pemasukan dan pengeluaran bulan ini.
- Grafik mutasi keuangan bulanan dengan **Chart.js**.
- Daftar 5 transaksi terbaru.

✅ **Laporan Keuangan**
- Filter laporan berdasarkan rentang tanggal.
- Rekap total pemasukan, pengeluaran, dan saldo periode.
- Fitur **Export ke PDF** menggunakan template custom.

---

## 🧠 Teknologi yang Digunakan
| Komponen | Teknologi |
|-----------|------------|
| Framework | Laravel 12.x |
| Server Lokal | Laragon (Apache, MySQL, PHP 8.3) |
| Database | MySQL |
| Frontend | Blade Template + Bootstrap 5 + Font Awesome |
| Grafik | Chart.js |
| Ekspor Laporan | DOMPDF / Laravel Snappy |

---

## 🗄️ Struktur Database (ERD)
Terdiri dari tiga entitas utama:

- **Users**  
  Menyimpan informasi pengguna dan autentikasi.
- **Pemasukan**  
  Menyimpan catatan dana masuk, relasi `user_id → users.id`.
- **Pengeluaran**  
  Menyimpan catatan dana keluar, relasi `user_id → users.id`.

Relasi:  
`User (1) — (∞) Pemasukan`  
`User (1) — (∞) Pengeluaran`

---

## 🧩 Konsep MVC
Aplikasi ini dibangun dengan arsitektur **Model–View–Controller (MVC)**.

- **Model** → Mengelola data dan logika bisnis (`User`, `Pemasukan`, `Pengeluaran`).  
- **View** → Menyajikan antarmuka menggunakan Blade Template.  
- **Controller** → Menjembatani logika antara Model dan View. 
