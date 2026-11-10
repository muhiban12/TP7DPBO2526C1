<?php
// Menyiapkan data awal penghuni untuk form edit jika parameter URL 'edit' diberikan
$editData = null;
if (isset($_GET['edit'])) {
    $editData = $tenantObj->getById($_GET['edit']);
}

// Menangani request pengiriman formulir POST (Tambah / Perbarui data penghuni)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        if ($_POST['action'] === 'create') {
            // Tambah data penghuni baru
            $tenantObj->create($_POST['room_id'], $_POST['name'], $_POST['ktp_number'], $_POST['entry_date']);
        } elseif ($_POST['action'] === 'update') {
            // Perbarui data penghuni yang sudah ada
            $tenantObj->update($_POST['id'], $_POST['room_id'], $_POST['name'], $_POST['ktp_number'], $_POST['entry_date']);
        }
        // Redirect kembali ke halaman daftar penghuni
        header("Location: index.php?page=tenants");
        exit;
    }
}

// Menangani permintaan penghapusan data penghuni jika parameter URL 'delete' diberikan
if (isset($_GET['delete'])) {
    $tenantObj->delete($_GET['delete']);
    header("Location: index.php?page=tenants");
    exit;
}

// Mengambil seluruh data penghuni dan daftar kamar untuk opsi dropdown
$tenants = $tenantObj->getAll();
$rooms = $roomObj->getAll();
?>

<h2>Management Data Penghuni Kost</h2>

<!-- Form Tambah / Edit Data Penghuni Kost -->
<form method="POST" class="form-card">
    <h3><?= $editData ? 'Edit Data Penghuni' : 'Tambah Penghuni Baru' ?></h3>
    <!-- Menentukan aksi apakah update atau create -->
    <input type="hidden" name="action" value="<?= $editData ? 'update' : 'create' ?>">
    <?php if ($editData): ?>
        <input type="hidden" name="id" value="<?= $editData['id'] ?>">
    <?php endif; ?>

    <!-- Pilihan Kamar Kost (Foreign Key ke tabel rooms) -->
    <div class="form-group">
        <label>Kamar Kost (Foreign Key):</label>
        <select name="room_id" required>
            <option value="">-- Pilih Kamar --</option>
            <?php foreach ($rooms as $room): ?>
                <option value="<?= $room['id'] ?>" <?= ($editData && $editData['room_id'] == $room['id']) ? 'selected' : '' ?>>
                    Kamar <?= htmlspecialchars($room['room_number']) ?> (Pemilik: <?= htmlspecialchars($room['owner_name']) ?>)
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <!-- Input Nama Lengkap Penghuni -->
    <div class="form-group">
        <label>Nama Lengkap Penghuni:</label>
        <input type="text" name="name" value="<?= $editData['name'] ?? '' ?>" required>
    </div>

    <!-- Input Nomor KTP / NIK -->
    <div class="form-group">
        <label>Nomor KTP/NIK:</label>
        <input type="text" name="ktp_number" value="<?= $editData['ktp_number'] ?? '' ?>" required>
    </div>

    <!-- Input Tanggal Masuk Kost -->
    <div class="form-group">
        <label>Tanggal Masuk:</label>
        <input type="date" name="entry_date" value="<?= $editData['entry_date'] ?? '' ?>" required>
    </div>

    <!-- Tombol Submit Form -->
    <button type="submit" class="btn btn-primary"><?= $editData ? 'Simpan Perubahan' : 'Tambah Data' ?></button>
    <?php if ($editData): ?>
        <a href="index.php?page=tenants" class="btn btn-secondary">Batal</a>
    <?php endif; ?>
</form>

<!-- Tabel Daftar Seluruh Penghuni Kost -->
<table class="data-table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nama Penghuni</th>
            <th>Nomor KTP</th>
            <th>Kamar</th>
            <th>Tgl Masuk</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($tenants as $row): ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><strong><?= htmlspecialchars($row['name']) ?></strong></td>
                <td><?= htmlspecialchars($row['ktp_number']) ?></td>
                <td>Kamar <?= htmlspecialchars($row['room_number']) ?></td>
                <td><?= htmlspecialchars($row['entry_date']) ?></td>
                <td>
                    <a href="index.php?page=tenants&edit=<?= $row['id'] ?>" class="btn-sm btn-edit">Edit</a>
                    <a href="index.php?page=tenants&delete=<?= $row['id'] ?>" class="btn-sm btn-delete" onclick="return confirm('Hapus data penghuni ini?')">Hapus</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
