<?php
// Menyiapkan data awal untuk proses edit (jika parameter ?edit=ID tersedia di URL)
$editData = null;
if (isset($_GET['edit'])) {
    $editData = $ownerObj->getById($_GET['edit']);
}

// Menangani request pengiriman form (POST) untuk Tambah atau Update data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        if ($_POST['action'] === 'create') {
            // Tambah data pemilik baru
            $ownerObj->create($_POST['name'], $_POST['phone'], $_POST['email']);
        } elseif ($_POST['action'] === 'update') {
            // Simpan perubahan data pemilik yang diedit
            $ownerObj->update($_POST['id'], $_POST['name'], $_POST['phone'], $_POST['email']);
        }
        // Redirect kembali ke halaman data pemilik setelah aksi selesai
        header("Location: index.php?page=owners");
        exit;
    }
}

// Menangani permintaan hapus data (jika parameter ?delete=ID tersedia di URL)
if (isset($_GET['delete'])) {
    $ownerObj->delete($_GET['delete']);
    header("Location: index.php?page=owners");
    exit;
}

// Mengambil seluruh data pemilik untuk ditampilkan pada tabel
$owners = $ownerObj->getAll();
?>

<h2>Management Data Pemilik Kost</h2>

<!-- Form Tambah / Edit Data Pemilik -->
<form method="POST" class="form-card">
    <h3><?= $editData ? 'Edit Data Pemilik' : 'Tambah Pemilik Baru' ?></h3>
    <!-- Input hidden untuk menandai aksi create atau update -->
    <input type="hidden" name="action" value="<?= $editData ? 'update' : 'create' ?>">
    <?php if ($editData): ?>
        <input type="hidden" name="id" value="<?= $editData['id'] ?>">
    <?php endif; ?>

    <div class="form-group">
        <label>Nama Lengkap:</label>
        <input type="text" name="name" value="<?= $editData['name'] ?? '' ?>" required>
    </div>
    <div class="form-group">
        <label>No. Telepon/WA:</label>
        <input type="text" name="phone" value="<?= $editData['phone'] ?? '' ?>" required>
    </div>
    <div class="form-group">
        <label>Alamat Email:</label>
        <input type="email" name="email" value="<?= $editData['email'] ?? '' ?>" required>
    </div>
    <button type="submit" class="btn btn-primary"><?= $editData ? 'Simpan Perubahan' : 'Tambah Data' ?></button>
    <?php if ($editData): ?>
        <a href="index.php?page=owners" class="btn btn-secondary">Batal</a>
    <?php endif; ?>
</form>

<!-- Tabel Daftar Pemilik Kost -->
<table class="data-table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nama Pemilik</th>
            <th>No. Telepon</th>
            <th>Email</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($owners as $row): ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= htmlspecialchars($row['name']) ?></td>
                <td><?= htmlspecialchars($row['phone']) ?></td>
                <td><?= htmlspecialchars($row['email']) ?></td>
                <td>
                    <a href="index.php?page=owners&edit=<?= $row['id'] ?>" class="btn-sm btn-edit">Edit</a>
                    <a href="index.php?page=owners&delete=<?= $row['id'] ?>" class="btn-sm btn-delete" onclick="return confirm('Hapus data pemilik ini?')">Hapus</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
