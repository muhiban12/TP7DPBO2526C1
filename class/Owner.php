<?php
// Class untuk mengelola entitas dan operasi CRUD data pemilik kost (owners)
class Owner {
    // Properti koneksi database dan nama tabel
    private $db;
    private $table = "owners";

    // Constructor untuk inisialisasi koneksi database
    public function __construct($database) {
        $this->db = $database;
    }

    // Mengambil seluruh data pemilik kost diurutkan dari ID terbaru
    public function getAll() {
        $stmt = $this->db->prepare("SELECT * FROM " . $this->table . " ORDER BY id DESC");
        $stmt->execute();
        return $stmt->fetchAll(); // Mengembalikan semua baris data pemilik
    }

    // Mengambil data satu pemilik kost berdasarkan ID
    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM " . $this->table . " WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(); // Mengembalikan satu baris data pemilik
    }

    // Menambahkan data pemilik kost baru ke database
    public function create($name, $phone, $email) {
        $stmt = $this->db->prepare("INSERT INTO " . $this->table . " (name, phone, email) VALUES (?, ?, ?)");
        return $stmt->execute([$name, $phone, $email]); // Eksekusi insert dengan prepared statement
    }

    // Memperbarui data spesifik pemilik kost berdasarkan ID
    public function update($id, $name, $phone, $email) {
        $stmt = $this->db->prepare("UPDATE " . $this->table . " SET name = ?, phone = ?, email = ? WHERE id = ?");
        return $stmt->execute([$name, $phone, $email, $id]); // Eksekusi update dengan prepared statement
    }

    // Menghapus data pemilik kost berdasarkan ID
    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM " . $this->table . " WHERE id = ?");
        return $stmt->execute([$id]); // Eksekusi delete dengan prepared statement
    }
}
