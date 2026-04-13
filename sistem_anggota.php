<?php
require_once 'functions_anggota.php';

// DATA
$anggota_list = [
    ["id"=>"AGT-001","nama"=>"Budi","email"=>"budi@email.com","telepon"=>"0812","alamat"=>"Jakarta","tanggal_daftar"=>"2024-01-15","status"=>"Aktif","total_pinjaman"=>5],
    ["id"=>"AGT-002","nama"=>"Joonghyuk","email"=>"yjh49@email.com","telepon"=>"0822","alamat"=>"Bandung","tanggal_daftar"=>"2024-02-10","status"=>"Non-Aktif","total_pinjaman"=>2],
    ["id"=>"AGT-003","nama"=>"Dokja","email"=>"kdj51@email.com","telepon"=>"0833","alamat"=>"Surabaya","tanggal_daftar"=>"2024-03-05","status"=>"Aktif","total_pinjaman"=>8],
    ["id"=>"AGT-004","nama"=>"Sooyoung","email"=>"hsy@email.com","telepon"=>"0844","alamat"=>"Jogja","tanggal_daftar"=>"2024-04-01","status"=>"Aktif","total_pinjaman"=>3],
    ["id"=>"AGT-005","nama"=>"Sangah","email"=>"Sangah@email.com","telepon"=>"0855","alamat"=>"Semarang","tanggal_daftar"=>"2024-05-20","status"=>"Non-Aktif","total_pinjaman"=>1],
];

// SEARCH
$keyword = $_GET['search'] ?? "";
if ($keyword != "") {
    $anggota_list = search_nama($anggota_list, $keyword);
}

// SORT
$anggota_list = sort_nama($anggota_list);

// STATISTIK
$total = hitung_total_anggota($anggota_list);
$aktif = hitung_anggota_aktif($anggota_list);
$rata = hitung_rata_rata_pinjaman($anggota_list);
$teraktif = cari_anggota_teraktif($anggota_list);

$nonaktif = $total - $aktif;
$persen_aktif = ($aktif/$total)*100;
$persen_nonaktif = ($nonaktif/$total)*100;

// FILTER
$aktif_list = filter_by_status($anggota_list, "Aktif");
$nonaktif_list = filter_by_status($anggota_list, "Non-Aktif");
?>

<!DOCTYPE html>
<html>
<head>
<title>Sistem Anggota</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="container mt-4">

<h2>Sistem Anggota Perpustakaan</h2>

<!-- SEARCH -->
<form class="mb-3">
    <input type="text" name="search" placeholder="Cari nama..." class="form-control w-25 d-inline">
    <button class="btn btn-primary">Search</button>
</form>

<!-- STATISTIK -->
<div class="row mb-4">
    <div class="col"><div class="card p-3 bg-primary text-white">Total: <?= $total ?></div></div>
    <div class="col"><div class="card p-3 bg-success text-white">Aktif: <?= number_format($persen_aktif,1) ?>%</div></div>
    <div class="col"><div class="card p-3 bg-danger text-white">Non: <?= number_format($persen_nonaktif,1) ?>%</div></div>
    <div class="col"><div class="card p-3 bg-warning">Rata: <?= number_format($rata,1) ?></div></div>
</div>

<!-- TERAKTIF -->
<div class="alert alert-success">
    Teraktif: <b><?= $teraktif['nama'] ?></b> (<?= $teraktif['total_pinjaman'] ?> pinjaman)
</div>

<!-- TABEL -->
<table class="table table-bordered">
<tr>
<th>ID</th><th>Nama</th><th>Email</th><th>Tanggal</th><th>Status</th><th>Pinjaman</th>
</tr>

<?php foreach ($anggota_list as $a): ?>
<tr>
<td><?= $a['id'] ?></td>
<td><?= $a['nama'] ?></td>
<td><?= validasi_email($a['email']) ? $a['email'] : "Email salah" ?></td>
<td><?= format_tanggal_indo($a['tanggal_daftar']) ?></td>
<td><?= $a['status'] ?></td>
<td><?= $a['total_pinjaman'] ?></td>
</tr>
<?php endforeach; ?>

</table>

<!-- LIST AKTIF -->
<h4>Anggota Aktif</h4>
<ul>
<?php foreach ($aktif_list as $a): ?>
<li><?= $a['nama'] ?></li>
<?php endforeach; ?>
</ul>

<!-- LIST NON AKTIF -->
<h4>Anggota Non-Aktif</h4>
<ul>
<?php foreach ($nonaktif_list as $a): ?>
<li><?= $a['nama'] ?></li>
<?php endforeach; ?>
</ul>

</body>
</html>