<?php
// Memuat konfigurasi database dan seluruh class model yang dibutuhkan
require_once "config/db.php";
require_once "class/Owner.php";
require_once "class/Room.php";
require_once "class/Tenant.php";

// Inisialisasi koneksi database PDO
$database = new Database();
$db = $database->getConnection();

// Inisialisasi instance dari setiap model dengan menyertakan koneksi database
$ownerObj = new Owner($db);
$roomObj = new Room($db);
$tenantObj = new Tenant($db);

// Mendapatkan halaman yang diminta dari query string URL (?page=...), default ke 'rooms'
$page = isset($_GET['page']) ? $_GET['page'] : 'rooms';

// Memuat bagian header halaman (HTML head, navbar)
include "view/header.php";

// Routing tampilan halaman view sesuai nilai $page
switch ($page) {
    case 'owners':
        include "view/owners.php";
        break;
    case 'rooms':
        include "view/rooms.php";
        break;
    case 'tenants':
        include "view/tenants.php";
        break;
    default:
        include "view/rooms.php";
        break;
}

// Memuat bagian footer halaman (penutup tag HTML & copyright)
include "view/footer.php";
