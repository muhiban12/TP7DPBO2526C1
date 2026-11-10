<?php
// Menyiapkan data untuk form edit jika parameter URL 'edit' diberikan
$editData = null;
if (isset($_GET['edit'])) {
    $editData = $roomObj->getById($_GET['edit']);
}

// Menangani request pengiriman formulir POST (Tambah / Update data kamar)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        if ($_POST['action'] === 'create') {
            // Tambah data kamar baru ke database
            $roomObj->create($_POST['owner_id'], $_POST['room_number'], $_POST['price_per_month'], $_POST['status']);
        } elseif ($_POST['action'] === 'update') {
            // Perbarui data kamar yang sudah ada
            $roomObj->update($_POST['id'], $_POST['owner_id'], $_POST['room_number'], $_POST['price_per_month'], $_POST['status']);
        }
        // Redirect kembali ke halaman manajemen kamar
        header("Location: index.php?page=rooms");
        exit;
    }
}

// Menangani permintaan penghapusan data kamar jika parameter URL 'delete' diberikan
if (isset($_GET['delete'])) {
    $roomObj->delete($_GET['delete']);
    header("Location: index.php?page=rooms");
    exit;
}

// Mengambil seluruh data kamar dan data pemilik untuk dropdown opsi
$rooms = $roomObj->getAll();
$owners = $ownerObj->getAll();
?>

<h2>Management Data Kamar Kost</h2>

<!-- Form Tambah / Edit Data Kamar Kost -->
<form method="POST" class="form-card">
    <h3><?= $editData ? 'Edit Data Kamar' : 'Tambah Kamar Baru' ?></h3>
    <!-- Menentukan aksi apakah update atau create -->
    <input type="hidden" name="action" value="<?= $editData ? 'update' : 'create' ?>">
    <?php if ($editData): ?>
        <input type="hidden" name="id" value="<?= $editData['id'] ?>">
    <?php endif; ?>

    <!-- Pilihan Pemilik Kamar (Foreign Key ke tabel owners) -->
    <div class="form-group">
        <label>Pemilik Kost (Foreign Key):</label>
        <select name="owner_id" required>
            <option value="">-- Pilih Pemilik --</option>
            <?php foreach ($owners as $owner): ?>
                <option value="<?= $owner['id'] ?>" <?= ($editData && $editData['owner_id'] == $owner['id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($owner['name']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <!-- Input Nomor / Kode Kamar -->
    <div class="form-group">
        <label>Nomor/Kode Kamar:</label>
        <input type="text" name="room_number" value="<?= $editData['room_number'] ?? '' ?>" required>
    </div>

    <!-- Input Harga Sewa per Bulan -->
    <div class="form-group">
        <label>Harga Sewa / Bulan (Rp):</label>
        <input type="number" step="0.01" name="price_per_month" value="<?= $editData['price_per_month'] ?? '' ?>" required>
    </div>

    <!-- Pilihan Status Ketersediaan Kamar -->
    <div class="form-group">
        <label>Status Kamar:</label>
        <select name="status" required>
            <option value="Available" <?= ($editData && $editData['status'] == 'Available') ? 'selected' : '' ?>>Available</option>
            <option value="Occupied" <?= ($editData && $editData['status'] == 'Occupied') ? 'selected' : '' ?>>Occupied</option>
        </select>
    </div>

    <!-- Tombol Submit Form -->
    <button type="submit" class="btn btn-primary"><?= $editData ? 'Simpan Perubahan' : 'Tambah Data' ?></button>
    <?php if ($editData): ?>
        <a href="index.php?page=rooms" class="btn btn-secondary">Batal</a>
    <?php endif; ?>
</form>

<!-- Tabel Daftar Seluruh Kamar Kost -->
<table class="data-table">
    <thead>
        <tr>
            <th>ID</th>
            <th>No. Kamar</th>
            <th>Pemilik</th>
            <th>Harga/Bulan</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($rooms as $row): ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><strong><?= htmlspecialchars($row['room_number']) ?></strong></td>
                <td><?= htmlspecialchars($row['owner_name']) ?></td>
                <td>Rp <?= number_format($row['price_per_month'], 0, ',', '.') ?></td>
                <td><span class="badge badge-<?= strtolower($row['status']) ?>"><?= $row['status'] ?></span></td>
                <td>
                    <a href="index.php?page=rooms&edit=<?= $row['id'] ?>" class="btn-sm btn-edit">Edit</a>
                    <a href="index.php?page=rooms&delete=<?= $row['id'] ?>" class="btn-sm btn-delete" onclick="return confirm('Hapus data kamar ini?')">Hapus</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
