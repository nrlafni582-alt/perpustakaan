<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Perhitungan Diskon - Tugas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Sistem Perhitungan Diskon Bertingkat</h1>

        <?php
        // Data input
        $nama_pembeli = "Budi Santoso";
        $judul_buku = "Laravel Advanced";
        $harga_satuan = 150000;
        $jumlah_beli = 4;
        $is_member = true; // true atau false

        // Hitung subtotal
        $subtotal = $harga_satuan * $jumlah_beli;

        // Tentukan persentase diskon berdasarkan jumlah
        if ($jumlah_beli >= 1 && $jumlah_beli <= 2) {
            $persentase_diskon = 0;
        } elseif ($jumlah_beli >= 3 && $jumlah_beli <= 5) {
            $persentase_diskon = 10;
        } elseif ($jumlah_beli >= 6 && $jumlah_beli <= 10) {
            $persentase_diskon = 15;
        } else {
            $persentase_diskon = 20;
        }

        // Hitung diskon utama
        $diskon = ($subtotal * $persentase_diskon) / 100;

        // Total setelah diskon pertama
        $total_setelah_diskon1 = $subtotal - $diskon;

        // Hitung diskon member jika member
        $diskon_member = 0;
        $persentase_member = 0;
        if ($is_member) {
            $persentase_member = 5;
            $diskon_member = ($total_setelah_diskon1 * $persentase_member) / 100;
        }

        // Total setelah semua diskon
        $total_setelah_diskon = $total_setelah_diskon1 - $diskon_member;

        // Hitung PPN
        $ppn = $total_setelah_diskon * 0.11;

        // Total akhir
        $total_akhir = $total_setelah_diskon + $ppn;

        // Total penghematan
        $total_hemat = $diskon + $diskon_member;

        function rupiah($angka) {
            return 'Rp ' . number_format($angka, 0, ',', '.');
        }
        ?>

        <div class="card shadow mb-4">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0">Ringkasan Pembelian</h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr><th>Nama Pembeli</th><td>: <?php echo $nama_pembeli; ?></td></tr>
                    <tr><th>Judul Buku</th><td>: <?php echo $judul_buku; ?></td></tr>
                    <tr><th>Harga Satuan</th><td>: <?php echo rupiah($harga_satuan); ?></td></tr>
                    <tr><th>Jumlah Beli</th><td>: <?php echo $jumlah_beli; ?> buku</td></tr>
                    <tr><th>Status Member</th><td>: <?php echo $is_member ? '<span class="badge bg-success">Member</span>' : '<span class="badge bg-secondary">Non-Member</span>'; ?></td></tr>
                    <tr><th>Subtotal</th><td>: <?php echo rupiah($subtotal); ?></td></tr>
                    <tr><th>Diskon</th><td>: <?php echo rupiah($diskon); ?> (<?php echo $persentase_diskon; ?>%)</td></tr>
                    <tr><th>Diskon Member</th><td>: <?php echo rupiah($diskon_member); ?> (<?php echo $persentase_member; ?>%)</td></tr>
                    <tr><th>Total setelah Diskon</th><td>: <?php echo rupiah($total_setelah_diskon); ?></td></tr>
                    <tr><th>PPN 11%</th><td>: <?php echo rupiah($ppn); ?></td></tr>
                    <tr><th>Total Akhir</th><td>: <?php echo rupiah($total_akhir); ?></td></tr>
                    <tr><th>Total Penghematan</th><td>: <?php echo rupiah($total_hemat); ?></td></tr>
                </table>
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
