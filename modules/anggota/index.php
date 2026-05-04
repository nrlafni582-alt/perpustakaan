<?php
$page_title = "Daftar Anggota";
require_once '../../config/database.php';
require_once '../../includes/header.php';

// --- LOGIKA PENCARIAN & PAGINATION ---
$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
$limit = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Query Hitung Total Data untuk Pagination
$total_query = "SELECT COUNT(*) as total FROM anggota WHERE nama LIKE '%$search%' OR email LIKE '%$search%' OR telepon LIKE '%$search%'";
$total_result = $conn->query($total_query);
$total_data = $total_result->fetch_assoc()['total'];
$total_pages = ceil($total_data / $limit);

// Query Ambil Data
$sql = "SELECT * FROM anggota 
        WHERE nama LIKE '%$search%' OR email LIKE '%$search%' OR telepon LIKE '%$search%' 
        ORDER BY created_at DESC LIMIT $limit OFFSET $offset";
$result = $conn->query($sql);
?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Daftar Anggota Perpustakaan</h3>
        <a href="create.php" class="btn btn-primary">+ Tambah Anggota</a>
    </div>

    <!-- Filter & Search -->
    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <form method="GET" class="row g-3">
                <div class="col-md-10">
                    <input type="text" name="search" class="form-control" placeholder="Cari berdasarkan nama, email, atau telepon..." value="<?= $search ?>">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-dark w-100">Cari</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Table -->
    <div class="table-responsive shadow-sm">
        <table class="table table-hover table-bordered bg-white">
            <thead class="table-primary text-center">
                <tr>
                    <th>Foto</th>
                    <th>ID/Kode</th>
                    <th>Biodata</th>
                    <th>Kontak</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td class="text-center">
                                <?php if ($row['foto']): ?>
                                    <img src="uploads/<?= $row['foto'] ?>" width="60" height="60" class="rounded-circle object-fit-cover" alt="Foto">
                                <?php else: ?>
                                    <div class="bg-light text-muted d-flex align-items-center justify-content-center rounded-circle m-auto" style="width:60px; height:60px; font-size: 10px;">No Photo</div>
                                <?php endif; ?>
                            </td>
                            <td>
                                <strong><?= $row['kode_anggota'] ?></strong><br>
                                <small class="text-muted">Join: <?= date('d/m/Y', strtotime($row['tanggal_daftar'])) ?></small>
                            </td>
                            <td>
                                <strong><?= $row['nama'] ?></strong><br>
                                <span class="badge bg-info text-dark" style="font-size: 10px;"><?= $row['jenis_kelamin'] ?></span>
                                <small class="d-block text-muted"><?= $row['pekerjaan'] ?></small>
                            </td>
                            <td>
                                <small><?= $row['email'] ?></small><br>
                                <small><?= $row['telepon'] ?></small>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-<?= $row['status'] == 'Aktif' ? 'success' : 'danger' ?>">
                                    <?= $row['status'] ?>
                                </span>
                            </td>
                            <td class="text-center">
                                <div class="btn-group btn-group-sm">
                                    <a href="edit.php?id=<?= $row['id_anggota'] ?>" class="btn btn-warning">Edit</a>
                                    <a href="delete.php?id=<?= $row['id_anggota'] ?>" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus anggota ini?')">Hapus</a>
                                </div>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="6" class="text-center py-4 text-muted">Data tidak ditemukan.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <?php if ($total_pages > 1): ?>
    <nav>
        <ul class="pagination justify-content-center">
            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <li class="page-item <?= ($page == $i) ? 'active' : '' ?>">
                    <a class="page-link" href="?page=<?= $i ?>&search=<?= $search ?>"><?= $i ?></a>
                </li>
            <?php endfor; ?>
        </ul>
    </nav>
    <?php endif; ?>
</div>

<?php require_once '../../includes/footer.php'; ?>