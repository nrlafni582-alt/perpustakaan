<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Info Buku - Perpustakaan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1 class="mb-4">Informasi Buku</h1>

    <?php
    // Data semua buku dalam array
    $buku = [
        [
            "judul" => "Pemrograman Web dengan PHP",
            "pengarang" => "Budi Raharjo",
            "penerbit" => "Informatika",
            "tahun" => 2023,
            "harga" => 85000,
            "stok" => 15,
            "isbn" => "978-602-1234-56-7",
            "kategori" => "Programming",
            "bahasa" => "Indonesia",
            "halaman" => 250,
            "berat" => 300
        ],
        [
            "judul" => "Belajar MySQL Dasar",
            "pengarang" => "Kim Dokja",
            "penerbit" => "KDJ Company",
            "tahun" => 2022,
            "harga" => 75000,
            "stok" => 10,
            "isbn" => "978-602-1111-22-3",
            "kategori" => "Database",
            "bahasa" => "Indonesia",
            "halaman" => 200,
            "berat" => 250
        ],
        [
            "judul" => "HTML & CSS for Beginners",
            "pengarang" => "Yoo Joonghyuk",
            "penerbit" => "YJH Publishing",
            "tahun" => 2021,
            "harga" => 95000,
            "stok" => 8,
            "isbn" => "978-602-2222-33-4",
            "kategori" => "Web Design",
            "bahasa" => "Inggris",
            "halaman" => 300,
            "berat" => 350
        ],
        [
            "judul" => "JavaScript Modern",
            "pengarang" => "Han Sooyoung",
            "penerbit" => "tls13",
            "tahun" => 2024,
            "harga" => 120000,
            "stok" => 12,
            "isbn" => "978-602-3333-44-5",
            "kategori" => "Programming",
            "bahasa" => "Indonesia",
            "halaman" => 320,
            "berat" => 400
        ]
    ];

    // Fungsi warna badge kategori
    function badgeKategori($kategori) {
        switch($kategori) {
            case "Programming": return "bg-primary";
            case "Database": return "bg-success";
            case "Web Design": return "bg-warning text-dark";
            default: return "bg-secondary";
        }
    }
    ?>

    <div class="row">
        <?php foreach ($buku as $b) : ?>
            <div class="col-md-6 mb-4">
                <div class="card shadow">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><?php echo $b['judul']; ?></h5>
                        <span class="badge <?php echo badgeKategori($b['kategori']); ?>">
                            <?php echo $b['kategori']; ?>
                        </span>
                    </div>
                    <div class="card-body">
                        <table class="table table-borderless">
                            <tr><th>Pengarang</th><td>: <?php echo $b['pengarang']; ?></td></tr>
                            <tr><th>Penerbit</th><td>: <?php echo $b['penerbit']; ?></td></tr>
                            <tr><th>Tahun Terbit</th><td>: <?php echo $b['tahun']; ?></td></tr>
                            <tr><th>ISBN</th><td>: <?php echo $b['isbn']; ?></td></tr>
                            <tr><th>Harga</th><td>: Rp <?php echo number_format($b['harga'], 0, ',', '.'); ?></td></tr>
                            <tr><th>Stok</th><td>: <?php echo $b['stok']; ?> buku</td></tr>
                            <tr><th>Bahasa</th><td>: <?php echo $b['bahasa']; ?></td></tr>
                            <tr><th>Jumlah Halaman</th><td>: <?php echo $b['halaman']; ?> halaman</td></tr>
                            <tr><th>Berat</th><td>: <?php echo $b['berat']; ?> gram</td></tr>
                        </table>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>