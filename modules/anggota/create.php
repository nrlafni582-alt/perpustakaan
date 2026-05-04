<?php
$page_title = "Tambah Anggota";
require_once '../../config/database.php'; // Pastikan path ini benar
require_once '../../includes/header.php'; // Pastikan path ini benar

/**
 * 1. FUNGSI SANITASI (Mencegah XSS & SQL Injection dasar)
 */
function sanitize($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

$errors = [];
$status = 'Aktif'; // Default status sesuai spesifikasi

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Ambil data dari form
    $kode      = sanitize($_POST['kode']);
    $nama      = sanitize($_POST['nama']);
    $email     = sanitize($_POST['email']);
    $telepon   = sanitize($_POST['telepon']);
    $alamat    = sanitize($_POST['alamat']);
    $tgl_lahir = $_POST['tanggal_lahir'];
    $jk        = $_POST['jenis_kelamin'];
    $pekerjaan = sanitize($_POST['pekerjaan']);

    /**
     * 2. VALIDASI INPUT
     */
    if (empty($kode)) $errors[] = "Kode wajib diisi";
    if (empty($nama)) $errors[] = "Nama wajib diisi";
    
    // Validasi Email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Format email tidak valid";
    }

    // Validasi Telepon (08xxxxxxxxxx)
    if (!preg_match('/^08[0-9]{8,11}$/', $telepon)) {
        $errors[] = "Format telepon salah (Harus 08... dan 10-13 digit)";
    }

    // Validasi Umur Minimal 10 Tahun
    if (!empty($tgl_lahir)) {
        $birthDate = new DateTime($tgl_lahir);
        $today = new DateTime('today');
        $age = $today->diff($birthDate)->y;
        if ($age < 10) {
            $errors[] = "Umur minimal anggota adalah 10 tahun";
        }
    } else {
        $errors[] = "Tanggal lahir wajib diisi";
    }

    /**
     * 3. PROSES UPLOAD FOTO
     */
    $foto_name = null; // Default jika tidak upload foto
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
        $target_dir = "uploads/";
        
        // Buat folder jika belum ada
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        $file_ext = pathinfo($_FILES["foto"]["name"], PATHINFO_EXTENSION);
        $foto_name = time() . "_" . $kode . "." . $file_ext; // Rename file agar unik
        $target_file = $target_dir . $foto_name;

        // Validasi ekstensi
        $allowed = ['jpg', 'jpeg', 'png'];
        if (!in_array(strtolower($file_ext), $allowed)) {
            $errors[] = "Hanya file JPG, JPEG, dan PNG yang diperbolehkan";
        } else {
            move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file);
        }
    }

    /**
     * 4. CEK DUPLIKAT (KODE & EMAIL)
     */
    if (empty($errors)) {
        $check = $conn->prepare("SELECT id_anggota FROM anggota WHERE kode_anggota=? OR email=?");
        $check->bind_param("ss", $kode, $email);
        $check->execute();
        if ($check->get_result()->num_rows > 0) {
            $errors[] = "Kode Anggota atau Email sudah terdaftar";
        }
        $check->close();
    }

    /**
     * 5. PROSES INSERT KE DATABASE
     */
    if (empty($errors)) {
        // Query dengan 11 kolom (termasuk foto dan CURDATE untuk tanggal_daftar)
        $sql = "INSERT INTO anggota 
                (kode_anggota, nama, email, telepon, alamat, tanggal_lahir, jenis_kelamin, pekerjaan, tanggal_daftar, status, foto)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, CURDATE(), ?, ?)";
        
        $stmt = $conn->prepare($sql);
        
        // "ssssssssss" -> Ada 10 parameter string (CURDATE tidak dihitung karena bukan parameter ?)
        $stmt->bind_param("ssssssssss", 
            $kode, $nama, $email, $telepon, $alamat, $tgl_lahir, $jk, $pekerjaan, $status, $foto_name
        );

        if ($stmt->execute()) {
            echo "<script>alert('Data Berhasil Disimpan!'); window.location='index.php';</script>";
            exit();
        } else {
            $errors[] = "Gagal menyimpan ke database: " . $stmt->error;
        }
        $stmt->close();
    }
}
?>

<div class="container mt-4 mb-5">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Form Tambah Anggota</h4>
        </div>
        <div class="card-body">

            <!-- Tampilkan Error jika ada -->
            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        <?php foreach($errors as $e) echo "<li>$e</li>"; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form method="POST" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Kode Anggota</label>
                        <input type="text" name="kode" class="form-control" placeholder="Contoh: AGT001" value="<?= $_POST['kode'] ?? '' ?>" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" name="nama" class="form-control" placeholder="Masukkan nama lengkap" value="<?= $_POST['nama'] ?? '' ?>" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" placeholder="nama@email.com" value="<?= $_POST['email'] ?? '' ?>" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nomor Telepon</label>
                        <input type="text" name="telepon" class="form-control" placeholder="08xxxxxxxxxx" value="<?= $_POST['telepon'] ?? '' ?>" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" class="form-control" value="<?= $_POST['tanggal_lahir'] ?? '' ?>" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Jenis Kelamin</label>
                        <select name="jenis_kelamin" class="form-select">
                            <option value="Laki-laki">Laki-laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Pekerjaan</label>
                        <input type="text" name="pekerjaan" class="form-control" placeholder="Pekerjaan saat ini" value="<?= $_POST['pekerjaan'] ?? '' ?>">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Foto Profil</label>
                        <input type="file" name="foto" class="form-control" accept="image/*">
                    </div>
                    <div class="col-12 mb-4">
                        <label class="form-label">Alamat Lengkap</label>
                        <textarea name="alamat" class="form-control" rows="3" required><?= $_POST['alamat'] ?? '' ?></textarea>
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary px-4">Simpan Anggota</button>
                    <a href="index.php" class="btn btn-secondary px-4">Batal</a>
                </div>
            </form>

        </div>
    </div>
</div>

<?php require_once '../../includes/footer.php'; ?>