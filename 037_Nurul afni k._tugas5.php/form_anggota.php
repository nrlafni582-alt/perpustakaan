<?php
// Inisialisasi variabel
$errors = [];
$success = false;
$data = [];

// Fungsi validasi
function validate_required($value, $field_name) {
    if (empty(trim($value))) {
        return "$field_name wajib diisi.";
    }
    return null;
}

function validate_min_length($value, $min, $field_name) {
    if (strlen(trim($value)) < $min) {
        return "$field_name minimal $min karakter.";
    }
    return null;
}

function validate_email($email) {
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return "Format email tidak valid.";
    }
    return null;
}

function validate_telepon($telepon) {
    if (!preg_match('/^08[0-9]{8,11}$/', $telepon)) {
        return "Telepon harus dimulai dengan 08 dan terdiri dari 10-13 digit.";
    }
    return null;
}

function validate_age($tanggal_lahir) {
    $birth_date = new DateTime($tanggal_lahir);
    $current_date = new DateTime('2026-04-19'); // Tanggal saat ini
    $age = $current_date->diff($birth_date)->y;
    if ($age < 10) {
        return "Umur minimal 10 tahun.";
    }
    return null;
}

// Proses form jika disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari form
    $nama = $_POST['nama'] ?? '';
    $email = $_POST['email'] ?? '';
    $telepon = $_POST['telepon'] ?? '';
    $alamat = $_POST['alamat'] ?? '';
    $jenis_kelamin = $_POST['jenis_kelamin'] ?? '';
    $tanggal_lahir = $_POST['tanggal_lahir'] ?? '';
    $pekerjaan = $_POST['pekerjaan'] ?? '';

    // Validasi
    $errors['nama'] = validate_required($nama, 'Nama Lengkap') ?: validate_min_length($nama, 3, 'Nama Lengkap');
    $errors['email'] = validate_required($email, 'Email') ?: validate_email($email);
    $errors['telepon'] = validate_required($telepon, 'Telepon') ?: validate_telepon($telepon);
    $errors['alamat'] = validate_required($alamat, 'Alamat') ?: validate_min_length($alamat, 10, 'Alamat');
    $errors['jenis_kelamin'] = validate_required($jenis_kelamin, 'Jenis Kelamin');
    $errors['tanggal_lahir'] = validate_required($tanggal_lahir, 'Tanggal Lahir') ?: validate_age($tanggal_lahir);
    $errors['pekerjaan'] = validate_required($pekerjaan, 'Pekerjaan');

    // Filter error yang null
    $errors = array_filter($errors);

    // Jika tidak ada error
    if (empty($errors)) {
        $success = true;
        $data = [
            'nama' => $nama,
            'email' => $email,
            'telepon' => $telepon,
            'alamat' => $alamat,
            'jenis_kelamin' => $jenis_kelamin,
            'tanggal_lahir' => $tanggal_lahir,
            'pekerjaan' => $pekerjaan
        ];
    }
}

// Fungsi untuk menampilkan value
function get_value($field) {
    return $_POST[$field] ?? '';
}

// Fungsi untuk menampilkan error
function show_error($field) {
    global $errors;
    return $errors[$field] ?? '';
}

// Fungsi untuk class invalid
function is_invalid($field) {
    global $errors;
    return isset($errors[$field]) ? 'is-invalid' : '';
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Registrasi Anggota</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h3 class="card-title mb-0">Form Registrasi Anggota Perpustakaan</h3>
                    </div>
                    <div class="card-body">
                        <?php if ($success): ?>
                            <div class="alert alert-success">
                                <h5>Registrasi Berhasil!</h5>
                                <p>Data anggota telah berhasil didaftarkan.</p>
                            </div>
                            <div class="card border-success">
                                <div class="card-header">
                                    <h5>Data Anggota</h5>
                                </div>
                                <div class="card-body">
                                    <p><strong>Nama Lengkap:</strong> <?= htmlspecialchars($data['nama']) ?></p>
                                    <p><strong>Email:</strong> <?= htmlspecialchars($data['email']) ?></p>
                                    <p><strong>Telepon:</strong> <?= htmlspecialchars($data['telepon']) ?></p>
                                    <p><strong>Alamat:</strong> <?= htmlspecialchars($data['alamat']) ?></p>
                                    <p><strong>Jenis Kelamin:</strong> <?= htmlspecialchars($data['jenis_kelamin']) ?></p>
                                    <p><strong>Tanggal Lahir:</strong> <?= htmlspecialchars($data['tanggal_lahir']) ?></p>
                                    <p><strong>Pekerjaan:</strong> <?= htmlspecialchars($data['pekerjaan']) ?></p>
                                </div>
                            </div>
                        <?php else: ?>
                            <form method="POST" novalidate>
                                <!-- Nama Lengkap -->
                                <div class="mb-3">
                                    <label for="nama" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control <?= is_invalid('nama') ?>" id="nama" name="nama" value="<?= htmlspecialchars(get_value('nama')) ?>" required>
                                    <div class="invalid-feedback">
                                        <?= show_error('nama') ?>
                                    </div>
                                </div>

                                <!-- Email -->
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control <?= is_invalid('email') ?>" id="email" name="email" value="<?= htmlspecialchars(get_value('email')) ?>" required>
                                    <div class="invalid-feedback">
                                        <?= show_error('email') ?>
                                    </div>
                                </div>

                                <!-- Telepon -->
                                <div class="mb-3">
                                    <label for="telepon" class="form-label">Telepon <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control <?= is_invalid('telepon') ?>" id="telepon" name="telepon" value="<?= htmlspecialchars(get_value('telepon')) ?>" placeholder="08xxxxxxxxxx" required>
                                    <div class="invalid-feedback">
                                        <?= show_error('telepon') ?>
                                    </div>
                                </div>

                                <!-- Alamat -->
                                <div class="mb-3">
                                    <label for="alamat" class="form-label">Alamat <span class="text-danger">*</span></label>
                                    <textarea class="form-control <?= is_invalid('alamat') ?>" id="alamat" name="alamat" rows="3" required><?= htmlspecialchars(get_value('alamat')) ?></textarea>
                                    <div class="invalid-feedback">
                                        <?= show_error('alamat') ?>
                                    </div>
                                </div>

                                <!-- Jenis Kelamin -->
                                <div class="mb-3">
                                    <label class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                                    <div class="form-check">
                                        <input class="form-check-input <?= isset($errors['jenis_kelamin']) ? 'is-invalid' : '' ?>" type="radio" name="jenis_kelamin" id="laki" value="Laki-laki" <?= get_value('jenis_kelamin') === 'Laki-laki' ? 'checked' : '' ?> required>
                                        <label class="form-check-label" for="laki">
                                            Laki-laki
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input <?= isset($errors['jenis_kelamin']) ? 'is-invalid' : '' ?>" type="radio" name="jenis_kelamin" id="perempuan" value="Perempuan" <?= get_value('jenis_kelamin') === 'Perempuan' ? 'checked' : '' ?> required>
                                        <label class="form-check-label" for="perempuan">
                                            Perempuan
                                        </label>
                                    </div>
                                    <?php if (isset($errors['jenis_kelamin'])): ?>
                                        <div class="text-danger small mt-1">
                                            <?= $errors['jenis_kelamin'] ?>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <!-- Tanggal Lahir -->
                                <div class="mb-3">
                                    <label for="tanggal_lahir" class="form-label">Tanggal Lahir <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control <?= is_invalid('tanggal_lahir') ?>" id="tanggal_lahir" name="tanggal_lahir" value="<?= htmlspecialchars(get_value('tanggal_lahir')) ?>" required>
                                    <div class="invalid-feedback">
                                        <?= show_error('tanggal_lahir') ?>
                                    </div>
                                </div>

                                <!-- Pekerjaan -->
                                <div class="mb-3">
                                    <label for="pekerjaan" class="form-label">Pekerjaan <span class="text-danger">*</span></label>
                                    <select class="form-select <?= is_invalid('pekerjaan') ?>" id="pekerjaan" name="pekerjaan" required>
                                        <option value="">Pilih Pekerjaan</option>
                                        <option value="Pelajar" <?= get_value('pekerjaan') === 'Pelajar' ? 'selected' : '' ?>>Pelajar</option>
                                        <option value="Mahasiswa" <?= get_value('pekerjaan') === 'Mahasiswa' ? 'selected' : '' ?>>Mahasiswa</option>
                                        <option value="Pegawai" <?= get_value('pekerjaan') === 'Pegawai' ? 'selected' : '' ?>>Pegawai</option>
                                        <option value="Lainnya" <?= get_value('pekerjaan') === 'Lainnya' ? 'selected' : '' ?>>Lainnya</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        <?= show_error('pekerjaan') ?>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary">Daftar</button>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
