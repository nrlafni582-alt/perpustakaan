<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Transaksi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Daftar Transaksi Peminjaman</h1>
        
        <?php
        // Hitung statistik dengan loop
        $total_transaksi = 0;
        $total_dipinjam = 0;
        $total_dikembalikan = 0;
        
        // Loop pertama untuk hitung statistik
        for ($i = 1; $i <= 10; $i++) {
            if ($i % 2 == 0) continue; // Skip genap
            if ($i > 8) break; // Stop di 8
            
            $status = ($i % 3 == 0) ? "Dikembalikan" : "Dipinjam";
            $total_transaksi++;
            if ($status == "Dipinjam") {
                $total_dipinjam++;
            } else {
                $total_dikembalikan++;
            }
        }
        ?>
        
        <!-- Tampilkan statistik dalam cards -->
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">Total Transaksi</h5>
                        <p class="card-text display-4"><?php echo $total_transaksi; ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">Masih Dipinjam</h5>
                        <p class="card-text display-4"><?php echo $total_dipinjam; ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">Sudah Dikembalikan</h5>
                        <p class="card-text display-4"><?php echo $total_dikembalikan; ?></p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Tampilkan tabel transaksi -->
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>ID Transaksi</th>
                    <th>Peminjam</th>
                    <th>Buku</th>
                    <th>Tgl Pinjam</th>
                    <th>Tgl Kembali</th>
                    <th>Hari</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Loop untuk tampilkan data
                $no = 1;
                for ($i = 1; $i <= 10; $i++) {
                    if ($i % 2 == 0) continue; // Skip genap
                    if ($i > 8) break; // Stop di 8
                    
                    // Generate data transaksi
                    $id_transaksi = "TRX-" . str_pad($i, 4, "0", STR_PAD_LEFT);
                    $nama_peminjam = "Anggota " . $i;
                    $judul_buku = "Buku Teknologi Vol. " . $i;
                    $tanggal_pinjam = date('Y-m-d', strtotime("-$i days"));
                    $tanggal_kembali = date('Y-m-d', strtotime("+7 days", strtotime($tanggal_pinjam)));
                    $status = ($i % 3 == 0) ? "Dikembalikan" : "Dipinjam";
                    
                    // Hitung hari sejak pinjam
                    $now = new DateTime();
                    $pinjam_date = new DateTime($tanggal_pinjam);
                    $interval = $now->diff($pinjam_date);
                    $hari = $interval->days;
                    
                    // Badge untuk status
                    $badge_class = ($status == "Dikembalikan") ? "badge bg-success" : "badge bg-warning";
                    
                    echo "<tr>";
                    echo "<td>$no</td>";
                    echo "<td>$id_transaksi</td>";
                    echo "<td>$nama_peminjam</td>";
                    echo "<td>$judul_buku</td>";
                    echo "<td>$tanggal_pinjam</td>";
                    echo "<td>$tanggal_kembali</td>";
                    echo "<td>$hari</td>";
                    echo "<td><span class='$badge_class'>$status</span></td>";
                    echo "</tr>";
                    
                    $no++;
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>