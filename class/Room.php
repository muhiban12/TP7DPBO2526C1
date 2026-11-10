<?php
// Class untuk mengelola entitas dan operasi CRUD data kamar kost (rooms)
class Room {
    // Properti koneksi database dan nama tabel
    private $db;
    private $table = "rooms";

    // Constructor untuk inisialisasi koneksi database
    public function __construct($database) {
        $this->db = $database;
    }

    // Mengambil seluruh data kamar beserta nama pemiliknya (JOIN tabel owners)
    public function getAll() {
        // Query join ke tabel owners untuk mengambil nama pemilik kamar
        $query = "SELECT rooms.*, owners.name AS owner_name 
                  FROM " . $this->table . " 
                  JOIN owners ON rooms.owner_id = owners.id 
                  ORDER BY rooms.id DESC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(); // Mengembalikan seluruh baris data kamar
    }

    // Mengambil data satu kamar kost berdasarkan ID
    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM " . $this->table . " WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(); // Mengembalikan satu baris data kamar
    }

    // Menambahkan data kamar kost baru ke database
    public function create($owner_id, $room_number, $price_per_month, $status) {
        $query = "INSERT INTO " . $this->table . " (owner_id, room_number, price_per_month, status) VALUES (?, ?, ?, ?)";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([$owner_id, $room_number, $price_per_month, $status]); // Eksekusi insert dengan prepared statement
    }

    // Memperbarui data kamar kost berdasarkan ID
    public function update($id, $owner_id, $room_number, $price_per_month, $status) {
        $query = "UPDATE " . $this->table . " SET owner_id = ?, room_number = ?, price_per_month = ?, status = ? WHERE id = ?";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([$owner_id, $room_number, $price_per_month, $status, $id]); // Eksekusi update dengan prepared statement
    }

    // Menghapus data kamar kost berdasarkan ID
    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM " . $this->table . " WHERE id = ?");
        return $stmt->execute([$id]); // Eksekusi delete dengan prepared statement
    }
}
