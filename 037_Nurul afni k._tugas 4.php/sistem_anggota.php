<?php
require_once 'functions_anggota.php';

// Data anggota perpustakaan
$anggota_list = [
    ["id" => "AGT-001", "nama" => "Budi", "email" => "budi@email.com", "telepon" => "0812", "alamat" => "Jakarta", "tanggal_daftar" => "2024-01-15", "status" => "Aktif", "total_pinjaman" => 5],
    ["id" => "AGT-002", "nama" => "Joonghyuk", "email" => "yjh49@email.com", "telepon" => "0822", "alamat" => "Bandung", "tanggal_daftar" => "2024-02-10", "status" => "Non-Aktif", "total_pinjaman" => 2],
    ["id" => "AGT-003", "nama" => "Dokja", "email" => "kdj51@email.com", "telepon" => "0833", "alamat" => "Surabaya", "tanggal_daftar" => "2024-03-05", "status" => "Aktif", "total_pinjaman" => 8],
    ["id" => "AGT-004", "nama" => "Sooyoung", "email" => "hsy@email.com", "telepon" => "0844", "alamat" => "Jogja", "tanggal_daftar" => "2024-04-01", "status" => "Aktif", "total_pinjaman" => 3],
    ["id" => "AGT-005", "nama" => "Sangah", "email" => "Sangah@email.com", "telepon" => "0855", "alamat" => "Semarang", "tanggal_daftar" => "2024-05-20", "status" => "Non-Aktif", "total_pinjaman" => 1],
];

// Pencarian berdasarkan nama
$keyword = $_GET['search'] ?? "";
$sort = $_GET['sort'] ?? "";
if ($keyword != "") {
    $anggota_list = search_nama($anggota_list, $keyword);
}

// Urutkan berdasarkan nama jika diminta
if ($sort === 'nama') {
    $anggota_list = sort_nama($anggota_list);
}

// Hitung statistik
$total = hitung_total_anggota($anggota_list);
$aktif = hitung_anggota_aktif($anggota_list);
$rata = hitung_rata_rata_pinjaman($anggota_list);
$teraktif = cari_anggota_teraktif($anggota_list);

$nonaktif = $total - $aktif;
$persen_aktif = ($total > 0) ? ($aktif / $total) * 100 : 0;
$persen_nonaktif = ($total > 0) ? ($nonaktif / $total) * 100 : 0;

// Filter berdasarkan status
$aktif_list = filter_by_status($anggota_list, "Aktif");
$nonaktif_list = filter_by_status($anggota_list, "Non-Aktif");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Anggota Perpustakaan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="container mt-4">

    <h2 class="mb-4">Sistem Anggota Perpustakaan</h2>

    <!-- Form Pencarian dan Sort -->
    <form class="mb-3" method="GET">
        <div class="row g-2 align-items-center w-100">
            <div class="col-md-6">
                <input type="text" name="search" placeholder="Cari nama anggota..." class="form-control" value="<?= htmlspecialchars($keyword) ?>">
            </div>
            <div class="col-md-3">
                <select name="sort" class="form-select">
                    <option value="" <?= $sort !== 'nama' ? 'selected' : '' ?>>Urutkan</option>
                    <option value="nama" <?= $sort === 'nama' ? 'selected' : '' ?>>Nama A-Z</option>
                </select>
            </div>
            <div class="col-md-3">
                <button class="btn btn-primary w-100" type="submit">Terapkan</button>
            </div>
        </div>
    </form>

    <!-- Kartu Statistik -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card p-3 bg-primary text-white">
                <h5>Total Anggota</h5>
                <h3><?= $total ?></h3>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card p-3 bg-success text-white">
                <h5>Aktif</h5>
                <h3><?= number_format($persen_aktif, 1) ?>%</h3>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card p-3 bg-danger text-white">
                <h5>Non-Aktif</h5>
                <h3><?= number_format($persen_nonaktif, 1) ?>%</h3>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card p-3 bg-warning">
                <h5>Rata-rata Pinjaman</h5>
                <h3><?= number_format($rata, 1) ?></h3>
            </div>
        </div>
    </div>

    <!-- Anggota Teraktif -->
    <div class="alert alert-success">
        <strong>Anggota Teraktif:</strong> <?= $teraktif['nama'] ?> (<?= $teraktif['total_pinjaman'] ?> pinjaman)
    </div>

    <!-- Tabel Anggota -->
    <table class="table table-striped table-bordered">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Tanggal Daftar</th>
                <th>Status</th>
                <th>Total Pinjaman</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($anggota_list as $anggota): ?>
            <tr>
                <td><?= htmlspecialchars($anggota['id']) ?></td>
                <td><?= htmlspecialchars($anggota['nama']) ?></td>
                <td><?= validasi_email($anggota['email']) ? htmlspecialchars($anggota['email']) : '<span class="text-danger">Email tidak valid</span>' ?></td>
                <td><?= htmlspecialchars(format_tanggal_indo($anggota['tanggal_daftar'])) ?></td>
                <td>
                    <span class="badge bg-<?= $anggota['status'] == 'Aktif' ? 'success' : 'secondary' ?>">
                        <?= htmlspecialchars($anggota['status']) ?>
                    </span>
                </td>
                <td><?= htmlspecialchars($anggota['total_pinjaman']) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Daftar Anggota Aktif -->
    <h4 class="mt-4">Daftar Anggota Aktif</h4>
    <ul class="list-group mb-4">
        <?php foreach ($aktif_list as $anggota): ?>
        <li class="list-group-item"><?= htmlspecialchars($anggota['nama']) ?></li>
        <?php endforeach; ?>
    </ul>

    <!-- Daftar Anggota Non-Aktif -->
    <h4>Daftar Anggota Non-Aktif</h4>
    <ul class="list-group">
        <?php foreach ($nonaktif_list as $anggota): ?>
        <li class="list-group-item"><?= htmlspecialchars($anggota['nama']) ?></li>
        <?php endforeach; ?>
    </ul>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>