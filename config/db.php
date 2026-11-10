<?php
// Class untuk mengelola konfigurasi dan koneksi database MySQL menggunakan PDO
class Database {
    // Parameter konfigurasi database
    private $host = "localhost";
    private $db_name = "db_satuatap";
    private $username = "root";
    private $password = "";
    public $conn;

    // Method untuk membuat dan mengembalikan objek koneksi PDO
    public function getConnection() {
        $this->conn = null;
        try {
            // Inisialisasi koneksi PDO ke database MySQL
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->db_name,
                $this->username,
                $this->password,
                [
                    // Mengaktifkan error mode Exception dan fetch mode default berupa Associative Array
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ]
            );
        } catch (PDOException $exception) {
            // Tangkap error dan hentikan eksekusi jika koneksi gagal
            die("Koneksi Database Gagal: " . $exception->getMessage());
        }
        return $this->conn;
    }
}
