<!-- Template Header Aplikasi SatuAtap -->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SatuAtap - Sistem Manajemen Kost</title>
    <!-- Menghubungkan stylesheet utama -->
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- Navigasi Utama -->
    <header class="navbar">
        <div class="logo">🏠 <strong>SatuAtap</strong> Management System</div>
        <!-- Menu Navigasi dengan penanda menu aktif berdasarkan parameter $page -->
        <nav>
            <a href="index.php?page=owners" class="<?= ($page == 'owners') ? 'active' : '' ?>">Pemilik Kost</a>
            <a href="index.php?page=rooms" class="<?= ($page == 'rooms') ? 'active' : '' ?>">Kamar Kost</a>
            <a href="index.php?page=tenants" class="<?= ($page == 'tenants') ? 'active' : '' ?>">Penghuni Kost</a>
        </nav>
    </header>
    <!-- Kontainer utama untuk memuat isi konten tiap halaman -->
    <main class="container">
