<?php
$page_title = "Edit Data Anggota";
require_once '../../config/database.php';
require_once '../../includes/header.php';

// =====================
// CEK ID
// =====================
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) {
    header("Location: index.php?error=ID tidak valid");
    exit();
}

// =====================
// AMBIL DATA
// =====================
$stmt = $conn->prepare("SELECT * FROM anggota WHERE id_anggota=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$member = $result->fetch_assoc();

if (!$member) {
    header("Location: index.php?error=Data tidak ditemukan");
    exit();
}

$errors = [];

// =====================
// PROSES UPDATE
// =====================
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Ambil data (aman dari error)
    $kode      = sanitize($_POST['kode'] ?? $member['kode_anggota']);
    $nama      = sanitize($_POST['nama'] ?? $member['nama']);
    $email     = sanitize($_POST['email'] ?? $member['email']);
    $telepon   = sanitize($_POST['telepon'] ?? $member['telepon']);
    $alamat    = sanitize($_POST['alamat'] ?? $member['alamat']);
    $tgl_lahir = $_POST['tanggal_lahir'] ?? $member['tanggal_lahir'];
    $jk        = $_POST['jenis_kelamin'] ?? $member['jenis_kelamin'];
    $pekerjaan = sanitize($_POST['pekerjaan'] ?? $member['pekerjaan']);
    $status    = $_POST['status'] ?? $member['status'];

    // =====================
    // VALIDASI
    // =====================

    if (empty($kode)) $errors[] = "Kode wajib diisi";
    if (empty($nama)) $errors[] = "Nama wajib diisi";

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Email tidak valid";
    }

    if (!preg_match('/^08[0-9]{8,11}$/', $telepon)) {
        $errors[] = "Format telepon salah (08xxxxxxxx)";
    }

    // Validasi umur
    $umur = date_diff(date_create($tgl_lahir), date_create('today'))->y;
    if ($umur < 10) {
        $errors[] = "Umur minimal 10 tahun";
    }

    // =====================
    // CEK DUPLIKAT (kecuali dirinya sendiri)
    // =====================
    if (empty($errors)) {
        $stmt_check = $conn->prepare("SELECT id_anggota FROM anggota WHERE (kode_anggota=? OR email=?) AND id_anggota!=?");
        $stmt_check->bind_param("ssi", $kode, $email, $id);
        $stmt_check->execute();
        if ($stmt_check->get_result()->num_rows > 0) {
            $errors[] = "Kode atau Email sudah digunakan";
        }
        $stmt_check->close();
    }

    // =====================
    // UPLOAD FOTO
    // =====================
    $foto_name = $member['foto'] ?? '';

    if (!empty($_FILES['foto']['name'])) {
        $target_dir = "uploads/";

        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        $ext = strtolower(pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg','jpeg','png'];

        if (!in_array($ext, $allowed)) {
            $errors[] = "Format foto harus JPG/PNG";
        } else {
            $foto_name = time() . "_" . $kode . "." . $ext;

            if (move_uploaded_file($_FILES['foto']['tmp_name'], $target_dir . $foto_name)) {
                // Hapus foto lama
                if (!empty($member['foto']) && file_exists($target_dir . $member['foto'])) {
                    unlink($target_dir . $member['foto']);
                }
            } else {
                $errors[] = "Gagal upload foto";
            }
        }
    }

    // =====================
    // UPDATE DATABASE
    // =====================
    if (empty($errors)) {

        $stmt_upd = $conn->prepare("UPDATE anggota SET 
            kode_anggota=?, nama=?, email=?, telepon=?, alamat=?, 
            tanggal_lahir=?, jenis_kelamin=?, pekerjaan=?, status=?, foto=? 
            WHERE id_anggota=?");

        $stmt_upd->bind_param("ssssssssssi",
            $kode, $nama, $email, $telepon, $alamat,
            $tgl_lahir, $jk, $pekerjaan, $status, $foto_name, $id
        );

        if ($stmt_upd->execute()) {
            header("Location: index.php?success=" . urlencode("Data anggota berhasil diupdate"));
            exit();
        } else {
            $errors[] = "Gagal update: " . $conn->error;
        }

        $stmt_upd->close();
    }
}
?>

<div class="container mt-4 mb-5">
<div class="card shadow">

<div class="card-header bg-warning">
<h4>Edit Data Anggota</h4>
</div>

<div class="card-body">

<?php if (!empty($errors)): ?>
<div class="alert alert-danger">
<ul>
<?php foreach($errors as $e) echo "<li>$e</li>"; ?>
</ul>
</div>
<?php endif; ?>

<form method="POST" enctype="multipart/form-data">

<div class="row">

<div class="col-md-6 mb-3">
<label>Kode</label>
<input type="text" name="kode" class="form-control"
value="<?= htmlspecialchars($member['kode_anggota'] ?? '') ?>">
</div>

<div class="col-md-6 mb-3">
<label>Nama</label>
<input type="text" name="nama" class="form-control"
value="<?= htmlspecialchars($member['nama'] ?? '') ?>">
</div>

<div class="col-md-6 mb-3">
<label>Email</label>
<input type="email" name="email" class="form-control"
value="<?= htmlspecialchars($member['email'] ?? '') ?>">
</div>

<div class="col-md-6 mb-3">
<label>Telepon</label>
<input type="text" name="telepon" class="form-control"
value="<?= htmlspecialchars($member['telepon'] ?? '') ?>">
</div>

<div class="col-md-6 mb-3">
<label>Tanggal Lahir</label>
<input type="date" name="tanggal_lahir" class="form-control"
value="<?= $member['tanggal_lahir'] ?? '' ?>">
</div>

<div class="col-md-6 mb-3">
<label>Jenis Kelamin</label>
<select name="jenis_kelamin" class="form-select">
<option value="Laki-laki" <?= (($member['jenis_kelamin'] ?? '')=='Laki-laki')?'selected':'' ?>>Laki-laki</option>
<option value="Perempuan" <?= (($member['jenis_kelamin'] ?? '')=='Perempuan')?'selected':'' ?>>Perempuan</option>
</select>
</div>

<div class="col-md-6 mb-3">
<label>Status</label>
<select name="status" class="form-select">
<option value="Aktif" <?= (($member['status'] ?? '')=='Aktif')?'selected':'' ?>>Aktif</option>
<option value="Nonaktif" <?= (($member['status'] ?? '')=='Nonaktif')?'selected':'' ?>>Nonaktif</option>
</select>
</div>

<div class="col-md-6 mb-3">
<label>Foto</label>
<input type="file" name="foto" class="form-control">

<?php if (!empty($member['foto'])): ?>
<img src="uploads/<?= $member['foto'] ?>" width="80" class="mt-2">
<?php endif; ?>
</div>

<div class="col-md-6 mb-3">
<label>Pekerjaan</label>
<input type="text" name="pekerjaan" class="form-control"
value="<?= htmlspecialchars($member['pekerjaan'] ?? '') ?>">
</div>

<div class="col-12 mb-3">
<label>Alamat</label>
<textarea name="alamat" class="form-control"><?= htmlspecialchars($member['alamat'] ?? '') ?></textarea>
</div>

</div>

<button class="btn btn-warning">Update</button>
<a href="index.php" class="btn btn-secondary">Batal</a>

</form>

</div>
</div>
</div>

<?php require_once '../../includes/footer.php'; ?>