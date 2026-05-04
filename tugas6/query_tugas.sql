-- STATISTIK BUKU

-- 1. Total buku
SELECT COUNT(*) AS total_buku
FROM buku;

-- 2. Total nilai inventaris
SELECT SUM(harga * stok) AS total_nilai
FROM buku;

-- 3. Rata-rata harga
SELECT AVG(harga) AS rata_harga
FROM buku;

-- 4. Buku termahal
SELECT judul, harga
FROM buku
ORDER BY harga DESC
LIMIT 1;

-- 5. Stok terbanyak
SELECT judul, stok
FROM buku
ORDER BY stok DESC
LIMIT 1;

-- FILTER & PENCARIAN

-- 6. Kategori Programming < 100000
SELECT *
FROM buku
WHERE kategori = 'Programming'
AND harga < 100000;

-- 7. Judul mengandung PHP/MySQL
SELECT *
FROM buku
WHERE judul LIKE '%PHP%'
OR judul LIKE '%MySQL%';

-- 8. Tahun 2024
SELECT *
FROM buku
WHERE tahun_terbit = 2024;

-- 9. Stok 5–10
SELECT *
FROM buku
WHERE stok BETWEEN 5 AND 10;

-- 10. Pengarang Budi Raharjo
SELECT *
FROM buku
WHERE pengarang = 'Budi Raharjo';

-- GROUPING

-- 11. Jumlah & stok per kategori
SELECT kategori, COUNT(*) AS jumlah, SUM(stok) AS total_stok
FROM buku
GROUP BY kategori;

-- 12. Rata-rata harga per kategori
SELECT kategori, AVG(harga) AS rata_harga
FROM buku
GROUP BY kategori;

-- 13. Nilai inventaris terbesar
SELECT kategori, SUM(harga * stok) AS total_nilai
FROM buku
GROUP BY kategori
ORDER BY total_nilai DESC
LIMIT 1;

-- UPDATE DATA

-- 14. Naikkan harga 5%
UPDATE buku
SET harga = ROUND(harga * 1.05, 0)
WHERE kategori = 'Programming';

-- 15. Tambah stok +10
UPDATE buku
SET stok = stok + 10
WHERE stok < 5;

-- LAPORAN

-- 16. Stok kurang dari 5
SELECT *
FROM buku
WHERE stok < 5;

-- 17. Top 5 buku termahal
SELECT judul, harga, stok
FROM buku
ORDER BY harga DESC
LIMIT 5;