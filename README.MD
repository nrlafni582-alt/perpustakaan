# 📘 Tugas Pertemuan 6 - Eksplorasi Database dengan Query

**Nama:** Nurul Afni Khasifa  
**NIM:** 60324037  
**Program Studi:** Informatika  
**Mata Kuliah:** Pemrograman Web II  

---

## 🔹 1. STATISTIK BUKU

### 1.1 Total Buku
**Deskripsi:** Menghitung jumlah keseluruhan data buku dalam tabel

```sql
SELECT COUNT(*) AS total_buku
FROM buku;
```

![Total Buku](pngtugas6/tgs1_1_1.png)

---

### 1.2 Total Nilai Inventaris
**Deskripsi:** Menghitung total nilai inventaris (harga × stok)

```sql
SELECT SUM(harga * stok) AS total_nilai
FROM buku;
```

![Total Inventaris](pngtugas6/tgs1_1_2.png)

---

### 1.3 Rata-rata Harga Buku
**Deskripsi:** Menghitung nilai rata-rata harga semua buku

```sql
SELECT AVG(harga) AS rata_harga
FROM buku;
```

![Rata-rata Harga](pngtugas6/tgs1_1_3.png)

---

### 1.4 Buku Termahal
**Deskripsi:** Menampilkan buku dengan harga tertinggi

```sql
SELECT judul, harga
FROM buku
ORDER BY harga DESC
LIMIT 1;
```

![Buku Termahal](pngtugas6/tgs1_1_4.png)

---

### 1.5 Stok Terbanyak
**Deskripsi:** Menampilkan buku dengan stok paling banyak

```sql
SELECT judul, stok
FROM buku
ORDER BY stok DESC
LIMIT 1;
```

![Stok Terbanyak](pngtugas6/tgs1_1_5.png)

---

## 🔹 2. FILTER & PENCARIAN

### 2.1 Kategori Programming dengan Harga < 100.000
**Deskripsi:** Mencari buku kategori Programming dengan harga di bawah Rp 100.000

```sql
SELECT *
FROM buku
WHERE kategori = 'Programming'
AND harga < 100000;
```

![Filter 1](pngtugas6/tgs1_2_1.png)

---

### 2.2 Buku dengan Judul Mengandung PHP atau MySQL
**Deskripsi:** Mencari buku yang judulnya mengandung kata PHP atau MySQL

```sql
SELECT *
FROM buku
WHERE judul LIKE '%PHP%'
OR judul LIKE '%MySQL%';
```

![Filter 2](pngtugas6/tgs1_2_2.png)

---

### 2.3 Buku Terbit Tahun 2024
**Deskripsi:** Menampilkan semua buku yang terbit pada tahun 2024

```sql
SELECT *
FROM buku
WHERE tahun_terbit = 2024;
```

![Filter 3](pngtugas6/tgs1_2_3.png)

---

### 2.4 Buku dengan Stok Antara 5–10
**Deskripsi:** Mencari buku yang memiliki stok dalam rentang 5 hingga 10 unit

```sql
SELECT *
FROM buku
WHERE stok BETWEEN 5 AND 10;
```

![Filter 4](pngtugas6/tgs1_2_4.png)

---

### 2.5 Buku Pengarang Budi Raharjo
**Deskripsi:** Mencari semua buku yang ditulis oleh Budi Raharjo

```sql
SELECT *
FROM buku
WHERE pengarang = 'Budi Raharjo';
```

![Filter 5](pngtugas6/tgs1_2_5.png)

---

## 🔹 3. GROUPING & AGREGASI

### 3.1 Jumlah Buku dan Stok per Kategori
**Deskripsi:** Mengelompokkan data buku berdasarkan kategori dengan menghitung jumlah buku dan total stok

```sql
SELECT kategori, COUNT(*) AS jumlah, SUM(stok) AS total_stok
FROM buku
GROUP BY kategori;
```

![Grouping 1](pngtugas6/tgs1_3_1.png)

---

### 3.2 Rata-rata Harga per Kategori
**Deskripsi:** Menghitung rata-rata harga buku untuk setiap kategori

```sql
SELECT kategori, AVG(harga) AS rata_harga
FROM buku
GROUP BY kategori;
```

![Grouping 2](pngtugas6/tgs1_3_2.png)

---

### 3.3 Nilai Inventaris Terbesar per Kategori
**Deskripsi:** Menemukan kategori dengan nilai inventaris (total harga × stok) terbesar

```sql
SELECT kategori, SUM(harga * stok) AS total_nilai
FROM buku
GROUP BY kategori
ORDER BY total_nilai DESC
LIMIT 1;
```

![Grouping 3](pngtugas6/tgs1_3_3.png)

---

## 🔹 4. UPDATE DATA

### 4.1 Kenaikan Harga 5% untuk Kategori Programming
**Deskripsi:** Meningkatkan harga semua buku kategori Programming sebesar 5%

```sql
UPDATE buku
SET harga = ROUND(harga * 1.05, 0)
WHERE kategori = 'Programming';
```

![Update 1 - Sebelum](pngtugas6/tgs1_4_1_1.png)
![Update 1 - Sesudah](pngtugas6/tgs1_4_1_2.png)

---

### 4.2 Tambah Stok 10 Unit untuk Buku dengan Stok < 5
**Deskripsi:** Menambah stok sebanyak 10 unit untuk buku yang stoknya kurang dari 5

```sql
UPDATE buku
SET stok = stok + 10
WHERE stok < 5;
```

![Update 2 - Sebelum](pngtugas6/tgs1_4_2_1.png)
![Update 2 - Sesudah](pngtugas6/tgs1_4_2_2.png)

---

## 🔹 5. LAPORAN

### 5.1 Buku yang Perlu Restock (Stok < 5)
**Deskripsi:** Menampilkan daftar buku yang stoknya kurang dari 5 unit dan perlu untuk direstock

```sql
SELECT *
FROM buku
WHERE stok < 5;
```

![Restock](pngtugas6/tgs1_5_1.png)

---

### 5.2 Top 5 Buku Termahal
**Deskripsi:** Menampilkan 5 buku dengan harga tertinggi beserta informasi stok

```sql
SELECT judul, harga, stok
FROM buku
ORDER BY harga DESC
LIMIT 5;
```

![Top 5 Termahal](pngtugas6/tgs1_5_2.png)

---

## 📊 Tugas 2 - DESAIN DATABASE

### Diagram Entity Relationship (ERD)
**Keterangan:** Diagram ERD menggambarkan entitas utama dan hubungan antar tabel dalam sistem perpustakaan. Model ini membantu memahami struktur data secara keseluruhan.

![ERD Database](pngtugas6/erd_drawio.png)

---

### Struktur Relasi Tabel
**Keterangan:** Gambar relasi menjelaskan cara tabel-tabel saling terhubung, termasuk hubungan kunci primer dan kunci asing. Ini penting untuk menjaga konsistensi data.

![Relasi Tabel](pngtugas6/relasi%20tu2.png)

---

### Struktur Tabel Buku
**Keterangan:** Struktur tabel buku menampilkan kolom data utama seperti judul, pengarang, harga, stok, kategori, dan penerbit. Penjelasan ini memudahkan pemahaman format penyimpanan data buku.

![Struktur](pngtugas6/struktur_buku.png)

---

## 🔹 Data Tabel

### Kategori & Penerbit
**Keterangan:** Menampilkan data tabel `kategori` dan `penerbit` yang menjadi referensi untuk buku. Struktur ini menjelaskan bagaimana relasi kategori dan penerbit tersimpan dalam database.

![Kategori](pngtugas6/kategori%20buku%20struktur%20tabel.png)
![Penerbit](pngtugas6/data%20penerbit.png)

### Data Buku
**Keterangan:** Menunjukkan isi tabel `buku` beserta contoh data yang dimasukkan. Gambar ini membantu memverifikasi bahwa field buku sesuai dengan ERD dan struktur relasi.

![Buku](pngtugas6/data%20buku.png)

---

## 🔹 Query JOIN

### Buku + Kategori + Penerbit
**Keterangan:** Menampilkan hasil query JOIN antara tabel buku, kategori, dan penerbit. Ini memperlihatkan informasi lengkap buku beserta nama kategori dan penerbit.

![Join 1](pngtugas6/4.1%20menampilkan%20buku.png)

### Jumlah per Kategori
**Keterangan:** Menampilkan total buku berdasarkan setiap kategori. Query ini digunakan untuk melihat distribusi jumlah buku per kategori.

![Join 2](pngtugas6/4.2%20jumlah%20per%20kategori.png)

### Jumlah per Penerbit
**Keterangan:** Menampilkan total buku berdasarkan penerbit. Ini membantu mengevaluasi kontribusi setiap penerbit terhadap koleksi buku.

![Join 3](pngtugas6/4.3%20jumlah%20per%20penerbit.png)

### Detail Lengkap
**Keterangan:** Menampilkan detail lengkap buku, termasuk kategori dan penerbit, dalam satu tampilan. Hasil ini berguna untuk laporan data buku yang komprehensif.

![Join 4](pngtugas6/4.4%20buku%20detail%20lengkap.png)

---

## 🔹 Fitur Tambahan

### Tabel Rak
**Keterangan:** Memperlihatkan tabel rak sebagai fitur tambahan untuk mengelompokkan buku berdasarkan lokasi penyimpanan. Fitur ini membantu manajemen inventaris di perpustakaan.

![Rak](pngtugas6/data%20rak.png)

### Soft Delete
**Keterangan:** Menunjukkan mekanisme soft delete pada tabel buku sehingga data tidak dihapus secara permanen. Soft delete menjaga data tetap ada untuk audit dan pemulihan.

![Soft Delete](pngtugas6/soft%20delete.png)
![Soft Delete](pngtugas6/buku%20is%20delete.png)

### Stored Procedure
**Keterangan:** Menampilkan contoh stored procedure untuk fungsi otomatis seperti mengecek stok kurang dari 5. Stored procedure ini meningkatkan efisiensi pengolahan data di database.

![SP 1](pngtugas6/stok%20kurang%20dari%205.png)
![SP 2](pngtugas6/stored%20procedur.png)

---