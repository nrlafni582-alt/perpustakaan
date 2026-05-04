# 📘 Tugas Pertemuan 6
## Eksplorasi Database dengan Query

**Nama:** Rahmawati Azizah Afriliani  
**NIM:** 60324025  
**Program Studi:** Informatika  
**Mata Kuliah:** Pemrograman Web II  

---

## 🔹 1. Statistik Buku

### Total Buku
![Total Buku](pngtugas6/tgs1_1_1.png)
> Query ini digunakan untuk menghitung jumlah keseluruhan data buku yang tersimpan dalam tabel `buku`. 
> Perhitungan dilakukan menggunakan fungsi agregasi `COUNT(*)` yang menghitung jumlah baris dalam tabel.

### Total Nilai Inventaris
![Total Inventaris](sshasilp6/tu1_1_2.png)
> Menghitung total nilai dari harga × stok.

### Rata-rata Harga Buku
![Rata-rata Harga](sshasilp6/tu1_1_3.png)
> Menghitung nilai rata-rata harga buku.

### Buku Termahal
![Buku Termahal](sshasilp6/tu1_1_4.png)
> Menampilkan buku dengan harga tertinggi.

### Stok Terbanyak
![Stok Terbanyak](sshasilp6/tu1_1_5.png)
> Menampilkan buku dengan stok paling banyak.

---

## 🔹 2. Filter dan Pencarian

### Programming < 100.000
![Filter 1](sshasilp6/tu1_2_1.png)

### Judul PHP / MySQL
![Filter 2](sshasilp6/tu1_2_2.png)

### Tahun 2024
![Filter 3](sshasilp6/tu1_2_3.png)

### Stok 5–10
![Filter 4](sshasilp6/tu1_2_4.png)

### Pengarang Budi Raharjo
![Filter 5](sshasilp6/tu1_2_5.png)

---

## 🔹 3. Grouping & Agregasi

### Jumlah Buku per Kategori
![Grouping 1](sshasilp6/tu1_3_1.png)

### Rata-rata Harga per Kategori
![Grouping 2](sshasilp6/tu1_3_2.png)

### Nilai Inventaris Terbesar
![Grouping 3](sshasilp6/tu1_3_3.png)

---

## 🔹 4. Update Data

### Kenaikan Harga 5%
![Update 1](sshasilp6/tu1_4_1_!.png)
![Update 1](sshasilp6/tu1_4_1_2.png)

### Tambah Stok
![Update 2](sshasilp6/tu1_4_2_1.png)
![Update 2](sshasilp6/tu1_4_2_2.png)

---

## 🔹 5. Laporan

### Buku Perlu Restock
![Restock](sshasilp6/tu1_5_1.png)

### Top 5 Buku Termahal
![Top 5](sshasilp6/tu1_5_2.png)

---

# 📘 Tugas 2

## 🔹 ERD Database
![ERD](sshasilp6/erd_pemweb.png)

---

## 🔹 Struktur Database

### Relasi Tabel
![Relasi](sshasilp6/relasi%20tu2.png)

### Struktur Tabel Buku
![Struktur](sshasilp6/struktur%20buku.png)

---

## 🔹 Data Tabel

### Kategori & Penerbit
![Kategori](sshasilp6/kategori%20buku%20struktur%20tabel.png)
![Penerbit](sshasilp6/data%20penerbit.png)

### Data Buku
![Buku](sshasilp6/data%20buku.png)

---

## 🔹 Query JOIN

### Buku + Kategori + Penerbit
![Join 1](sshasilp6/4.1%20join.png)

### Jumlah per Kategori
![Join 2](sshasilp6/4.2jumlah%20buku%20perkatogori.png)

### Jumlah per Penerbit
![Join 3](sshasilp6/4.3%20jumlah%20buku%20perpenerbit.png)

### Detail Lengkap
![Join 4](sshasilp6/4.4%20buku%20beserta%20detail%20lengkap.png)

---

## 🔹 Fitur Tambahan

### Tabel Rak
![Rak](sshasilp6/data%20rak.png)

### Soft Delete
![Soft Delete](sshasilp6/is_deletedbonus2.png)
![Soft Delete](sshasilp6/5.%20buku%20is%20delete.png)

### Stored Procedure
![SP 1](sshasilp6/sp_kurangdari5.png)
![SP 2](sshasilp6/stored%20procedur.png)

---

## ✅ Keterangan
- Semua query telah diuji di phpMyAdmin
- Database menggunakan MySQL
- Data buku minimal 15 record