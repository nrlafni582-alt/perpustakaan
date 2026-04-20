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

// Hitung status dan denda
$total_denda = 0;
if ($buku_terlambat > 0) {
    $total_denda = $denda_per_hari_per_buku * $hari_keterlambatan * $buku_terlambat;
    if ($total_denda > $max_denda) {
        $total_denda = $max_denda;
    }
}

if ($total_pinjaman >= $max_pinjaman) {
    $status_pinjam = "Tidak bisa pinjam lagi karena sudah mencapai batas maksimal $max_pinjaman buku.";
} elseif ($buku_terlambat > 0) {
    $status_pinjam = "Tidak bisa pinjam lagi karena ada buku yang terlambat dikembalikan.";
} else {
    $status_pinjam = "Bisa pinjam lagi.";
}

$level_member = "Tidak valid";
switch (true) {
    case ($total_pinjaman <= 5):
        $level_member = "Bronze";
        break;
    case ($total_pinjaman <= 15):
        $level_member = "Silver";
        break;
    default:
        $level_member = "Gold";
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Status Peminjaman</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        .box { max-width: 480px; margin: auto; border: 1px solid #ccc; padding: 16px; border-radius: 8px; }
        .header { font-size: 18px; font-weight: bold; margin-bottom: 12px; }
        .row { margin-bottom: 8px; }
        .label { font-weight: bold; display: inline-block; width: 160px; }
        .status { padding: 8px; border-radius: 4px; display: inline-block; }
        .ok { background: #d4edda; color: #155724; }
        .fail { background: #f8d7da; color: #721c24; }
        .warn { background: #fff3cd; color: #856404; }
    </style>
</head>
<body>
    <div class="box">
        <div class="header">Status Peminjaman Anggota</div>
        <div class="row"><span class="label">Nama:</span><?= htmlspecialchars($nama_anggota) ?></div>
        <div class="row"><span class="label">Total pinjaman:</span><?= $total_pinjaman ?> buku</div>
        <div class="row"><span class="label">Buku terlambat:</span><?= $buku_terlambat ?> buku</div>
        <div class="row"><span class="label">Hari keterlambatan:</span><?= $hari_keterlambatan ?> hari</div>
        <hr>
        <div class="row"><span class="label">Status pinjam:</span>
            <span class="status <?= $status_pinjam === 'Bisa pinjam lagi.' ? 'ok' : 'fail' ?>"><?= htmlspecialchars($status_pinjam) ?></span>
        </div>
        <?php if ($buku_terlambat > 0): ?>
        <div class="row warn"><span class="label">Total denda:</span>Rp <?= number_format($total_denda, 0, ',', '.') ?></div>
        <div class="row warn"><span class="label">Peringatan:</span>Harap segera kembalikan buku terlambat.</div>
        <?php endif; ?>
        <hr>
        <div class="row"><span class="label">Level member:</span><?= htmlspecialchars($level_member) ?></div>
    </div>
</body>
</html>

