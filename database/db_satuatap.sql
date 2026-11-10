CREATE DATABASE IF NOT EXISTS db_satuatap;
USE db_satuatap;

-- 1. Tabel Pemilik Kost (owners)
CREATE TABLE IF NOT EXISTS owners (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 2. Tabel Kamar Kost (rooms) - Relasi ke owners (FK: owner_id)
CREATE TABLE IF NOT EXISTS rooms (
    id INT AUTO_INCREMENT PRIMARY KEY,
    owner_id INT NOT NULL,
    room_number VARCHAR(10) NOT NULL,
    price_per_month DECIMAL(12,2) NOT NULL,
    status ENUM('Available', 'Occupied') DEFAULT 'Available',
    FOREIGN KEY (owner_id) REFERENCES owners(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 3. Tabel Penghuni Kost (tenants) - Relasi ke rooms (FK: room_id)
CREATE TABLE IF NOT EXISTS tenants (
    id INT AUTO_INCREMENT PRIMARY KEY,
    room_id INT NOT NULL,
    name VARCHAR(100) NOT NULL,
    ktp_number VARCHAR(20) NOT NULL UNIQUE,
    entry_date DATE NOT NULL,
    FOREIGN KEY (room_id) REFERENCES rooms(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Data Awal (Dummy Data)
INSERT INTO owners (name, phone, email) VALUES
('Ahmad Subagja', '081234567890', 'ahmad@satuatap.id'),
('Siti Rahmawati', '082198765432', 'siti@satuatap.id');

INSERT INTO rooms (owner_id, room_number, price_per_month, status) VALUES
(1, 'A-101', 1500000.00, 'Occupied'),
(1, 'A-102', 1700000.00, 'Available'),
(2, 'B-201', 2000000.00, 'Occupied');

INSERT INTO tenants (room_id, name, ktp_number, entry_date) VALUES
(1, 'Muhiban Fadlan Nursaid', '3273012400382001', '2026-09-01'),
(3, 'Muhammad Fillan', '3273012400382002', '2026-10-15');