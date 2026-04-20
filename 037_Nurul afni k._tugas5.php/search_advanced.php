<?php
session_start();

// Data buku (minimal 10)
$buku_list = [
    ["kode" => "BK001", "judul" => "Belajar PHP Dasar", "kategori" => "Pemrograman", "pengarang" => "Kim Dokja", "penerbit" => "KDJ Company", "tahun" => 2020, "harga" => 75000, "stok" => 15],
    ["kode" => "BK002", "judul" => "JavaScript Advanced", "kategori" => "Pemrograman", "pengarang" => "Yoo Joonghyuk", "penerbit" => "YJH Publishing", "tahun" => 2021, "harga" => 95000, "stok" => 10],
    ["kode" => "BK003", "judul" => "Database MySQL", "kategori" => "Database", "pengarang" => "Han Sooyoung", "penerbit" => "tls13", "tahun" => 2019, "harga" => 85000, "stok" => 8],
    ["kode" => "BK004", "judul" => "HTML & CSS Guide", "kategori" => "Web Design", "pengarang" => "Sangah Yoo", "penerbit" => "Olimpus Design", "tahun" => 2022, "harga" => 65000, "stok" => 20],
    ["kode" => "BK005", "judul" => "Python for Beginners", "kategori" => "Pemrograman", "pengarang" => "Pildu Gong", "penerbit" => "Code Academy", "tahun" => 2023, "harga" => 80000, "stok" => 12],
    ["kode" => "BK006", "judul" => "Machine Learning Basics", "kategori" => "AI", "pengarang" => "Jung Heewon", "penerbit" => "AI Press", "tahun" => 2021, "harga" => 120000, "stok" => 5],
    ["kode" => "BK007", "judul" => "Cyber Security", "kategori" => "Keamanan", "pengarang" => "Lee Hyunsung", "penerbit" => "Secure Asgard", "tahun" => 2020, "harga" => 100000, "stok" => 7],
    ["kode" => "BK008", "judul" => "Mobile App Development", "kategori" => "Mobile", "pengarang" => "Seolhwa Lee", "penerbit" => "App Dev Inc", "tahun" => 2022, "harga" => 110000, "stok" => 9],
    ["kode" => "BK009", "judul" => "Data Science with R", "kategori" => "Data Science", "pengarang" => "Gilyoung Lee", "penerbit" => "Papyrus Insights", "tahun" => 2023, "harga" => 130000, "stok" => 6],
    ["kode" => "BK010", "judul" => "Web Development Full Stack", "kategori" => "Web Development", "pengarang" => "Uriel", "penerbit" => "Eden Press", "tahun" => 2021, "harga" => 140000, "stok" => 4],
    ["kode" => "BK011", "judul" => "Algorithm and Data Structures", "kategori" => "Pemrograman", "pengarang" => "Mia Yoo", "penerbit" => "Vedas Books", "tahun" => 2018, "harga" => 90000, "stok" => 11],
    ["kode" => "BK012", "judul" => "Cloud Computing", "kategori" => "Cloud", "pengarang" => "Wukong Sun", "penerbit" => "Emperor Tech", "tahun" => 2022, "harga" => 115000, "stok" => 8],
];

// Kategori unik untuk dropdown
$kategori_options = array_unique(array_column($buku_list, 'kategori'));

// Ambil parameter GET
$keyword = $_GET['keyword'] ?? '';
$kategori = $_GET['kategori'] ?? '';
$min_harga = $_GET['min_harga'] ?? '';
$max_harga = $_GET['max_harga'] ?? '';
$tahun = $_GET['tahun'] ?? '';
$status = $_GET['status'] ?? 'semua';
$sort = $_GET['sort'] ?? 'judul';
$page = $_GET['page'] ?? 1;

// Validasi
$errors = [];

if (!empty($min_harga) && !empty($max_harga)) {
    if ($min_harga > $max_harga) {
        $errors[] = "Harga minimum tidak boleh lebih besar dari harga maksimum";
    }
}

if (!empty($tahun)) {
    $current_year = date('Y');
    if ($tahun < 1900 || $tahun > $current_year) {
        $errors[] = "Tahun terbit harus antara 1900 dan $current_year";
    }
}

// Filter dan sorting
$hasil = $buku_list;

// Filter keyword
if (!empty($keyword)) {
    $hasil = array_filter($hasil, function($buku) use ($keyword) {
        return stripos($buku['judul'], $keyword) !== false || stripos($buku['pengarang'], $keyword) !== false;
    });
}

// Filter kategori
if (!empty($kategori)) {
    $hasil = array_filter($hasil, function($buku) use ($kategori) {
        return $buku['kategori'] === $kategori;
    });
}

// Filter harga
if (!empty($min_harga)) {
    $hasil = array_filter($hasil, function($buku) use ($min_harga) {
        return $buku['harga'] >= $min_harga;
    });
}

if (!empty($max_harga)) {
    $hasil = array_filter($hasil, function($buku) use ($max_harga) {
        return $buku['harga'] <= $max_harga;
    });
}

// Filter tahun
if (!empty($tahun)) {
    $hasil = array_filter($hasil, function($buku) use ($tahun) {
        return $buku['tahun'] == $tahun;
    });
}

// Filter status
if ($status === 'tersedia') {
    $hasil = array_filter($hasil, function($buku) {
        return $buku['stok'] > 0;
    });
} elseif ($status === 'habis') {
    $hasil = array_filter($hasil, function($buku) {
        return $buku['stok'] == 0;
    });
}

// Sorting
usort($hasil, function($a, $b) use ($sort) {
    if ($sort === 'harga') {
        return $a['harga'] <=> $b['harga'];
    } elseif ($sort === 'tahun') {
        return $b['tahun'] <=> $a['tahun']; // Descending untuk tahun
    } else {
        return strcmp($a['judul'], $b['judul']);
    }
});

// Pagination
$per_page = 10;
$total_results = count($hasil);
$total_pages = ceil($total_results / $per_page);
$page = max(1, min($page, $total_pages));
$offset = ($page - 1) * $per_page;
$hasil_paginated = array_slice($hasil, $offset, $per_page);

// Highlight keyword
function highlight_keyword($text, $keyword) {
    if (empty($keyword)) return $text;
    return preg_replace('/(' . preg_quote($keyword, '/') . ')/i', '<mark>$1</mark>', $text);
}

// Save pencarian ke session (bonus)
if (!empty($keyword) || !empty($kategori) || !empty($min_harga) || !empty($max_harga) || !empty($tahun) || $status !== 'semua') {
    $search_params = [
        'keyword' => $keyword,
        'kategori' => $kategori,
        'min_harga' => $min_harga,
        'max_harga' => $max_harga,
        'tahun' => $tahun,
        'status' => $status,
        'timestamp' => time()
    ];
    if (!isset($_SESSION['recent_searches'])) {
        $_SESSION['recent_searches'] = [];
    }
    array_unshift($_SESSION['recent_searches'], $search_params);
    $_SESSION['recent_searches'] = array_slice($_SESSION['recent_searches'], 0, 5); // Simpan 5 terakhir
}

// Export to CSV (bonus)
if (isset($_GET['export']) && $_GET['export'] === 'csv') {
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="hasil_pencarian.csv"');
    $output = fopen('php://output', 'w');
    fputcsv($output, ['Kode', 'Judul', 'Kategori', 'Pengarang', 'Penerbit', 'Tahun', 'Harga', 'Stok']);
    foreach ($hasil as $buku) {
        fputcsv($output, $buku);
    }
    fclose($output);
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pencarian Buku Lanjutan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h3 class="card-title mb-0">Pencarian Buku Lanjutan</h3>
                    </div>
                    <div class="card-body">
                        <!-- Form Pencarian -->
                        <form method="GET" class="mb-4">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="keyword" class="form-label">Keyword (Judul/Pengarang)</label>
                                    <input type="text" class="form-control" id="keyword" name="keyword" value="<?= htmlspecialchars($keyword) ?>" placeholder="Cari judul atau pengarang...">
                                </div>
                                <div class="col-md-6">
                                    <label for="kategori" class="form-label">Kategori</label>
                                    <select class="form-select" id="kategori" name="kategori">
                                        <option value="">Semua Kategori</option>
                                        <?php foreach ($kategori_options as $kat): ?>
                                            <option value="<?= htmlspecialchars($kat) ?>" <?= $kategori === $kat ? 'selected' : '' ?>><?= htmlspecialchars($kat) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-3">
                                    <label for="min_harga" class="form-label">Harga Min</label>
                                    <input type="number" class="form-control" id="min_harga" name="min_harga" value="<?= htmlspecialchars($min_harga) ?>" min="0">
                                </div>
                                <div class="col-md-3">
                                    <label for="max_harga" class="form-label">Harga Max</label>
                                    <input type="number" class="form-control" id="max_harga" name="max_harga" value="<?= htmlspecialchars($max_harga) ?>" min="0">
                                </div>
                                <div class="col-md-3">
                                    <label for="tahun" class="form-label">Tahun Terbit</label>
                                    <input type="number" class="form-control" id="tahun" name="tahun" value="<?= htmlspecialchars($tahun) ?>" min="1900" max="<?= date('Y') ?>">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Status Ketersediaan</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="status" id="semua" value="semua" <?= $status === 'semua' ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="semua">Semua</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="status" id="tersedia" value="tersedia" <?= $status === 'tersedia' ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="tersedia">Tersedia</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="status" id="habis" value="habis" <?= $status === 'habis' ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="habis">Habis</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <label for="sort" class="form-label">Urutkan Berdasarkan</label>
                                    <select class="form-select" id="sort" name="sort">
                                        <option value="judul" <?= $sort === 'judul' ? 'selected' : '' ?>>Judul</option>
                                        <option value="harga" <?= $sort === 'harga' ? 'selected' : '' ?>>Harga</option>
                                        <option value="tahun" <?= $sort === 'tahun' ? 'selected' : '' ?>>Tahun (Terbaru)</option>
                                    </select>
                                </div>
                                <div class="col-md-6 d-flex align-items-end">
                                    <button type="submit" class="btn btn-primary me-2">Cari</button>
                                    <a href="?export=csv&<?= http_build_query($_GET) ?>" class="btn btn-success">Export CSV</a>
                                </div>
                            </div>
                        </form>

                        <!-- Error Messages -->
                        <?php if (!empty($errors)): ?>
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    <?php foreach ($errors as $error): ?>
                                        <li><?= htmlspecialchars($error) ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>

                        <!-- Hasil Pencarian -->
                        <?php if (!empty($hasil)): ?>
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5>Ditemukan <?= $total_results ?> buku</h5>
                                <?php if (isset($_SESSION['recent_searches']) && !empty($_SESSION['recent_searches'])): ?>
                                    <div>
                                        <h6>Pencarian Terakhir:</h6>
                                        <ul class="list-inline">
                                            <?php foreach (array_slice($_SESSION['recent_searches'], 0, 3) as $search): ?>
                                                <li class="list-inline-item">
                                                    <a href="?<?= http_build_query($search) ?>" class="badge bg-secondary text-decoration-none">
                                                        <?= htmlspecialchars($search['keyword'] ?: 'Filter') ?>
                                                    </a>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <!-- Tabel Hasil -->
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>Kode</th>
                                            <th>Judul</th>
                                            <th>Kategori</th>
                                            <th>Pengarang</th>
                                            <th>Penerbit</th>
                                            <th>Tahun</th>
                                            <th>Harga</th>
                                            <th>Stok</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($hasil_paginated as $buku): ?>
                                            <tr>
                                                <td><?= htmlspecialchars($buku['kode']) ?></td>
                                                <td><?= highlight_keyword(htmlspecialchars($buku['judul']), $keyword) ?></td>
                                                <td><?= htmlspecialchars($buku['kategori']) ?></td>
                                                <td><?= highlight_keyword(htmlspecialchars($buku['pengarang']), $keyword) ?></td>
                                                <td><?= htmlspecialchars($buku['penerbit']) ?></td>
                                                <td><?= htmlspecialchars($buku['tahun']) ?></td>
                                                <td>Rp <?= number_format($buku['harga'], 0, ',', '.') ?></td>
                                                <td>
                                                    <span class="badge bg-<?= $buku['stok'] > 0 ? 'success' : 'danger' ?>">
                                                        <?= $buku['stok'] > 0 ? 'Tersedia (' . $buku['stok'] . ')' : 'Habis' ?>
                                                    </span>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>

                            <!-- Pagination -->
                            <?php if ($total_pages > 1): ?>
                                <nav aria-label="Pagination">
                                    <ul class="pagination justify-content-center">
                                        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                                            <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                                                <a class="page-link" href="?<?= http_build_query(array_merge($_GET, ['page' => $i])) ?>"><?= $i ?></a>
                                            </li>
                                        <?php endfor; ?>
                                    </ul>
                                </nav>
                            <?php endif; ?>
                        <?php elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && !empty(array_filter($_GET))): ?>
                            <div class="alert alert-info">
                                Tidak ada buku yang ditemukan dengan kriteria tersebut.
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
