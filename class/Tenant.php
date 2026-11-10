<?php
// Class untuk mengelola entitas dan operasi CRUD tabel penyewa (tenants)
class Tenant {
    // Properti koneksi database dan nama tabel
    private $db;
    private $table = "tenants";

    // Constructor untuk menginisialisasi instance koneksi database
    public function __construct($database) {
        $this->db = $database;
    }

    // Mengambil semua data penyewa beserta relasi nomor kamar dari tabel rooms
    public function getAll() {
        // Query join ke tabel rooms untuk mengambil nomor kamar
        $query = "SELECT tenants.*, rooms.room_number 
                  FROM " . $this->table . " 
                  JOIN rooms ON tenants.room_id = rooms.id 
                  ORDER BY tenants.id DESC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(); // Mengembalikan seluruh baris data penyewa
    }

    // Mengambil data satu penyewa berdasarkan ID
    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM " . $this->table . " WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(); // Mengembalikan satu baris data penyewa
    }

    // Menambahkan data penyewa baru ke database
    public function create($room_id, $name, $ktp_number, $entry_date) {
        $query = "INSERT INTO " . $this->table . " (room_id, name, ktp_number, entry_date) VALUES (?, ?, ?, ?)";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([$room_id, $name, $ktp_number, $entry_date]); // Eksekusi insert dengan prepared statement
    }

    // Memperbarui data penyewa yang sudah ada berdasarkan ID
    public function update($id, $room_id, $name, $ktp_number, $entry_date) {
        $query = "UPDATE " . $this->table . " SET room_id = ?, name = ?, ktp_number = ?, entry_date = ? WHERE id = ?";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([$room_id, $name, $ktp_number, $entry_date, $id]); // Eksekusi update dengan prepared statement
    }

    // Menghapus data penyewa berdasarkan ID
    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM " . $this->table . " WHERE id = ?");
        return $stmt->execute([$id]); // Eksekusi delete dengan prepared statement
    }
}
