<?php
// Data Anggota
$nama_anggota = "Budi Santoso";
$total_pinjaman = 2;
$buku_terlambat = 1;
$hari_keterlambatan = 5; // hari

// Aturan Business Logic
$max_pinjaman = 3;
$denda_per_hari_per_buku = 1000;
$max_denda = 50000;

// Tampilkan Informasi Anggota
echo "Informasi Anggota:<br>";
echo "Nama: $nama_anggota<br>";
echo "Total Pinjaman: $total_pinjaman<br>";
echo "Buku Terlambat: $buku_terlambat<br>";
echo "Hari Keterlambatan: $hari_keterlambatan<br><br>";

// Status Peminjaman Saat Ini
echo "Status Peminjaman Saat Ini:<br>";
echo "Total Pinjaman: $total_pinjaman buku<br>";
if ($buku_terlambat > 0) {
    echo "Ada $buku_terlambat buku yang terlambat dikembalikan.<br><br>";
} else {
    echo "Tidak ada buku yang terlambat.<br><br>";
}

// Menggunakan IF-ELSEIF-ELSE
echo "Cek Kemampuan Pinjam Lagi:<br>";
if ($total_pinjaman >= $max_pinjaman) {
    echo "Tidak bisa pinjam lagi karena sudah mencapai batas maksimal $max_pinjaman buku.<br>";
} elseif ($buku_terlambat > 0) {
    echo "Tidak bisa pinjam lagi karena ada buku yang terlambat dikembalikan.<br>";
    // Hitung total denda
    $total_denda = $denda_per_hari_per_buku * $hari_keterlambatan * $buku_terlambat;
    if ($total_denda > $max_denda) {
        $total_denda = $max_denda;
    }
    echo "Total Denda: Rp " . number_format($total_denda, 0, ',', '.') . "<br>";
    // Peringatan keterlambatan
    echo "Peringatan: Harap segera kembalikan buku yang terlambat untuk menghindari denda lebih lanjut.<br>";
} else {
    echo "Bisa pinjam lagi.<br>";
}

// Menggunakan SWITCH untuk Tentukan Level Member
echo "<br>Level Member:<br>";
switch (true) {
    case ($total_pinjaman >= 0 && $total_pinjaman <= 5):
        echo "Bronze<br>";
        break;
    case ($total_pinjaman >= 6 && $total_pinjaman <= 15):
        echo "Silver<br>";
        break;
    case ($total_pinjaman > 15):
        echo "Gold<br>";
        break;
    default:
        echo "Tidak valid<br>";
        break;
}
?>
