<?php
// DATA ANGGOTA
$anggota_list = [
    [
        "id" => "AGT-001",
        "nama" => "Budi Santoso",
        "email" => "budi@email.com",
        "telepon" => "081234567890",
        "alamat" => "Jakarta",
        "tanggal_daftar" => "2024-01-15",
        "status" => "Aktif",
        "total_pinjaman" => 5
    ],
    [
        "id" => "AGT-002",
        "nama" => "Yoo Joonghyuk",
        "email" => "yjh49@email.com",
        "telepon" => "082233445566",
        "alamat" => "Bandung",
        "tanggal_daftar" => "2024-02-10",
        "status" => "Non-Aktif",
        "total_pinjaman" => 2
    ],
    [
        "id" => "AGT-003",
        "nama" => "Kim Dokja",
        "email" => "kdj51@email.com",
        "telepon" => "083344556677",
        "alamat" => "Surabaya",
        "tanggal_daftar" => "2024-03-05",
        "status" => "Aktif",
        "total_pinjaman" => 8
    ],
    [
        "id" => "AGT-004",
        "nama" => "Han Sooyoung",
        "email" => "hsy@email.com",
        "telepon" => "084455667788",
        "alamat" => "Yogyakarta",
        "tanggal_daftar" => "2024-04-01",
        "status" => "Aktif",
        "total_pinjaman" => 3
    ],
    [
        "id" => "AGT-005",
        "nama" => "Yoo Sangah",
        "email" => "sangah@email.com",
        "telepon" => "085566778899",
        "alamat" => "Semarang",
        "tanggal_daftar" => "2024-05-20",
        "status" => "Non-Aktif",
        "total_pinjaman" => 1
    ]
];

// ============================
// LOGIKA PERHITUNGAN
// ============================

$total_anggota = count($anggota_list);

$aktif = 0;
$non_aktif = 0;
$total_pinjaman = 0;

$teraktif = $anggota_list[0];

foreach ($anggota_list as $anggota) {
    // Hitung status
    if ($anggota['status'] == "Aktif") {
        $aktif++;
    } else {
        $non_aktif++;
    }

    // Total pinjaman
    $total_pinjaman += $anggota['total_pinjaman'];

    // Cari anggota teraktif
    if ($anggota['total_pinjaman'] > $teraktif['total_pinjaman']) {
        $teraktif = $anggota;
    }
}

// Hitung statistik
$persen_aktif = ($aktif / $total_anggota) * 100;
$persen_non_aktif = ($non_aktif / $total_anggota) * 100;
$rata_pinjaman = $total_pinjaman / $total_anggota;

// FILTER STATUS
$filter_status = $_GET['status'] ?? "Semua";

$filtered_list = [];
foreach ($anggota_list as $anggota) {
    if ($filter_status == "Semua" || $anggota['status'] == $filter_status) {
        $filtered_list[] = $anggota;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Anggota Perpustakaan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-4">

<h2 class="mb-4">Data Anggota Perpustakaan</h2>

<!-- FILTER -->
<form method="GET" class="mb-3">
    <select name="status" class="form-select w-25 d-inline">
        <option>Semua</option>
        <option>Aktif</option>
        <option>Non-Aktif</option>
    </select>
    <button class="btn btn-primary">Filter</button>
</form>

<!-- STATISTIK -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card p-3 bg-primary text-white">
            <h5>Total Anggota</h5>
            <h3><?= $total_anggota ?></h3>
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
            <h3><?= number_format($persen_non_aktif, 1) ?>%</h3>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card p-3 bg-warning text-dark">
            <h5>Rata Pinjaman</h5>
            <h3><?= number_format($rata_pinjaman, 1) ?></h3>
        </div>
    </div>
</div>

<!-- TERAKTIF -->
<div class="alert alert-info">
    <strong>Anggota Teraktif:</strong> <?= $teraktif['nama'] ?> (<?= $teraktif['total_pinjaman'] ?> pinjaman)
</div>

<!-- TABEL -->
<table class="table table-bordered table-striped">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Nama</th>
            <th>Email</th>
            <th>Telepon</th>
            <th>Alamat</th>
            <th>Tanggal Daftar</th>
            <th>Status</th>
            <th>Total Pinjaman</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($filtered_list as $a): ?>
        <tr>
            <td><?= $a['id'] ?></td>
            <td><?= $a['nama'] ?></td>
            <td><?= $a['email'] ?></td>
            <td><?= $a['telepon'] ?></td>
            <td><?= $a['alamat'] ?></td>
            <td><?= $a['tanggal_daftar'] ?></td>
            <td><?= $a['status'] ?></td>
            <td><?= $a['total_pinjaman'] ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

</body>
</html>