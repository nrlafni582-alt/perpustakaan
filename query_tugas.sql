-- Menggunakan database perpustakaan
USE perpustakaan;

-- 1. Statistik Buku (5 query)

-- hitung total jumlah buku (judul) yang ada di database
SELECT COUNT(*) AS total_buku_keseluruhan FROM buku;

-- hitung total nilai inventaris dari semua buku (harga X stok)
SELECT SUM(harga * stok) AS total_nilai_inventaris FROM buku;

-- hitung rata-rata harga dari keseluruhan buku
SELECT AVG(harga) AS rata_rata_harga_buku FROM buku;

-- buat menampilkan judul dan harga buku yang paling mahal (diurutkan menurun, ambil 1 teratas)
SELECT judul, harga FROM buku ORDER BY harga DESC LIMIT 1;

-- buat menampilkan data buku yang memiliki jumlah stok paling banyak
SELECT judul, stok FROM buku ORDER BY stok DESC LIMIT 1;

-- 2. Filter dan Pencarian (5 query)

-- buat menampilkan semua buku kategori Programming yang harganya < 100.000
SELECT * FROM buku WHERE kategori = 'Programming' AND harga < 100000;

-- buat menampilkan buku yang pada judulnya terdapat kata "PHP" atau "MySQL"
SELECT * FROM buku WHERE judul LIKE '%PHP%' OR judul LIKE '%MySQL%';

-- buat menampilkan buku-buku yang diterbitkan pada tahun 2024
SELECT * FROM buku WHERE tahun_terbit = 2024;

-- buat menampilkan buku-buku yang jumlah stoknya ada di 5 - 10
SELECT * FROM buku WHERE stok BETWEEN 5 AND 10;

-- buat menampilkan semua buku hasil karya pengarang "Budi Raharjo"
SELECT * FROM buku WHERE pengarang = 'Budi Raharjo';

-- 3. Grouping dan Agregasi (3 query)

-- buat menampilkan jumlah judul buku per kategori sekaligus total keseluruhan stoknya
SELECT kategori, COUNT(*) AS jumlah_buku, SUM(stok) AS total_stok_kategori 
FROM buku 
GROUP BY kategori;

-- buat menampilkan rata-rata harga buku dikelompokkan berdasarkan tiap kategorinya
SELECT kategori, AVG(harga) AS rata_rata_harga 
FROM buku 
GROUP BY kategori;

-- cari satu kategori yang memiliki total nilai inventaris paling besar
SELECT kategori, SUM(harga * stok) AS total_nilai_inventaris 
FROM buku 
GROUP BY kategori 
ORDER BY total_nilai_inventaris DESC 
LIMIT 1;

-- 4. Update Data (2 query)

-- buat menaikkan harga sebesar 5% khusus buku programming
UPDATE buku 
SET harga = harga * 1.05 
WHERE kategori = 'Programming';

-- buat menambahkan 10 buah stok baru buat semua buku yang stoknya saat ini kurang dari 5
UPDATE buku 
SET stok = stok + 10 
WHERE stok < 5;


-- 5. Laporan Khusus (2 query)

-- buat menampilkan daftar buku yang perlu direstock karena stoknya menipis (kurang dari 5)
SELECT * FROM buku WHERE stok < 5;

-- buat menampilkan 5 buku dengan harga paling mahal
SELECT * FROM buku ORDER BY harga DESC LIMIT 5;