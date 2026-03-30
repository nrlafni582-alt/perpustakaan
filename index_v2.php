<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Perpustakaan</title>
    <style>
    
    body{
        font-family: Arial, sans-serif;
        max-width: 800px;
        margin: 50px auto;
        padding: 20px;
        background:#f4f4f4;
    }
    .card{
        background:white;
        padding:25px;
        border-radius:8px;
        margin:15px 0;
        box-shadow:0 2px 8px rgba(0,0,0,0.1);
    }
    h1{ color:#2c3e50; border-bottom:3px solid #27ae60; padding-bottom:10px;}
    .info{ background:#e8f5e9; border-left:4px solid #27ae60; padding:12px; margin:10px 0;}
    .server{ background:#fff3cd; border-left:4px solid #ffc107; padding:12px; margin:10px 0;}
    .perpus{ background:#e3f2fd; border-left:4px solid #2196f3; padding:12px; margin:10px 0;}
    </style>

</head>
<body>
    <div class="card">
        <h1>🏛️ Sistem Manajemen Perpustakaan</h1>
        
        <div class="info">
            <h3>Selamat Datang!</h3>
            <p><strong>Dibuat oleh:</strong> <?php echo "Nurul Afni Khasifa"; ?></p>
            <p><strong>Tanggal:</strong> <?php echo date('d F Y'); ?></p>
            <p><strong>Waktu Server:</strong> <?php echo date('H:i:s'); ?></p>
        </div>
        
    <div class="server">
        <h3>Informasi Server</h3>
        <p><strong>PHP Version:</strong> <?php echo phpversion(); ?></p>
        <p><strong>Server Software:</strong> <?php echo $_SERVER['SERVER_SOFTWARE']; ?></p>
        <p><strong>Document Root:</strong> <?php echo $_SERVER['DOCUMENT_ROOT']; ?></p>
    </div>
    
    <?php
    // Data statis
    $nama_perpus="Perpustakaan Universitas Shibuya";
    $total_buku=1250;
    $total_anggota=450;
    $buku_dipinjam=178;
    $buku_tersedia=$total_buku-$buku_dipinjam;
    $persen_tersedia=round(($buku_tersedia/$total_buku)*100,1);
    
    // informasi perpustakaan
    $alamat_perpus="Distrik Shibuya, Tokyo, Jepang";
    $telepon_perpus="021-12345678";
    $jam_buka="08:00";
    $jam_tutup="16:00";
    ?>
    
    <div class="info">
        <h3>📊 Statistik <?php echo $nama_perpus; ?></h3>
        <p><strong>Total Buku:</strong> <?php echo number_format($total_buku); ?> buku</p>
        <p><strong>Total Anggota:</strong> <?php echo number_format($total_anggota); ?> orang</p>
        <p><strong>Sedang Dipinjam:</strong> <?php echo $buku_dipinjam; ?> buku</p>
        <p><strong>Buku Tersedia:</strong> <?php echo number_format($buku_tersedia); ?> buku</p>
        <p><strong>Persentase Buku Tersedia:</strong> <?php echo $persen_tersedia; ?>%</p>
    </div>
    
    <div class="perpus">
        <h3>📚 Informasi Perpustakaan</h3>
        <p><strong>Alamat:</strong> <?php echo $alamat_perpus; ?></p>
        <p><strong>Telepon:</strong> <?php echo $telepon_perpus; ?></p>
        <p><strong>Jam Operasional:</strong> <?php echo $jam_buka; ?> - <?php echo $jam_tutup; ?></p>
        <p><strong>Hari Libur:</strong> Sabtu – Minggu</p>
    </div>

</div>

</body>
</html>