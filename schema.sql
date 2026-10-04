-- ============================================
-- AHASS Booking Servis - Database Schema
-- Framework: CodeIgniter 3
-- Database: MySQL
-- ============================================

-- Buat database
CREATE DATABASE IF NOT EXISTS `ahass_booking` 
  CHARACTER SET utf8mb4 
  COLLATE utf8mb4_general_ci;

USE `ahass_booking`;

-- ============================================
-- Tabel: paket_servis
-- Menyimpan master data paket servis
-- ============================================
CREATE TABLE IF NOT EXISTS `paket_servis` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nama_paket` VARCHAR(100) NOT NULL,
  `deskripsi` TEXT DEFAULT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ============================================
-- Tabel: bookings
-- Menyimpan data booking servis pelanggan
-- ============================================
CREATE TABLE IF NOT EXISTS `bookings` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `plat_nomor` VARCHAR(15) NOT NULL,
  `nama_pelanggan` VARCHAR(100) NOT NULL,
  `tipe_motor` VARCHAR(50) NOT NULL,
  `tanggal_servis` DATE NOT NULL,
  `jam_servis` TIME NOT NULL,
  `paket_id` INT(11) UNSIGNED NOT NULL,
  `status` ENUM('pending','confirmed','completed','cancelled') NOT NULL DEFAULT 'pending',
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_tanggal_jam` (`tanggal_servis`, `jam_servis`),
  KEY `idx_plat_nomor` (`plat_nomor`),
  KEY `idx_status` (`status`),
  KEY `fk_paket_id` (`paket_id`),
  CONSTRAINT `fk_bookings_paket` FOREIGN KEY (`paket_id`) 
    REFERENCES `paket_servis` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ============================================
-- Seed Data: paket_servis
-- Data awal paket servis AHASS
-- ============================================
INSERT INTO `paket_servis` (`nama_paket`, `deskripsi`) VALUES
('Servis Ringan', 'Ganti oli, cek filter udara, cek busi, cek rantai'),
('Servis Lengkap', 'Servis ringan + ganti filter oli, cek rem, cek kelistrikan, tune up mesin'),
('Ganti Oli Mesin', 'Penggantian oli mesin Honda Genuine Oil (HGO) 0.8L'),
('Ganti Oli Mesin + Gear', 'Penggantian oli mesin + oli gardan/gear'),
('Paket Rem', 'Cek & ganti kampas rem depan dan belakang'),
('Paket Injeksi', 'Pembersihan & kalibrasi sistem injeksi (PGM-FI)'),
('Paket Ban & Velg', 'Cek tekanan ban, balancing, spooring ringan'),
('Paket Body Repair', 'Perbaikan body ringan, cat touch up, poles');
