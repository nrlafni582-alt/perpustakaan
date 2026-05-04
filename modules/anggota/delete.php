<?php
require_once '../../config/database.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // 1. Ambil nama file foto lama untuk dihapus dari folder
    $stmt = $conn->prepare("SELECT foto FROM anggota WHERE id_anggota = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();

    if ($data) {
        // Hapus file fisik jika ada dan bukan file default
        if (!empty($data['foto']) && file_exists("uploads/" . $data['foto'])) {
            unlink("uploads/" . $data['foto']);
        }

        // 2. Hapus data dari database
        $del = $conn->prepare("DELETE FROM anggota WHERE id_anggota = ?");
        $del->bind_param("i", $id);
        
        if ($del->execute()) {
            header("Location: index.php?success=Data berhasil dihapus");
        } else {
            header("Location: index.php?error=Gagal menghapus data");
        }
    }
} else {
    header("Location: index.php");
}
exit();