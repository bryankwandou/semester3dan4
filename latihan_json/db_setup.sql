-- Drop databases if they exist to ensure clean setup
DROP DATABASE IF EXISTS `maskapai_aa`;
DROP DATABASE IF EXISTS `maskapai_bb`;
DROP DATABASE IF EXISTS `maskapai_cc`;

CREATE DATABASE `maskapai_aa`;
CREATE DATABASE `maskapai_bb`;
CREATE DATABASE `maskapai_cc`;

-- Setup Maskapai AA
USE `maskapai_aa`;

CREATE TABLE IF NOT EXISTS `tabel_penerbangan` (
  `id_penerbangan` VARCHAR(10) PRIMARY KEY,
  `dari` VARCHAR(50) NOT NULL,
  `ke` VARCHAR(50) NOT NULL,
  `jam_berangkat` TIME NOT NULL,
  `jam_tiba` TIME NOT NULL,
  `harga` INT NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

TRUNCATE TABLE `tabel_penerbangan`;

INSERT INTO `tabel_penerbangan` (`id_penerbangan`, `dari`, `ke`, `jam_berangkat`, `jam_tiba`, `harga`) VALUES
('AA-101', 'Jakarta (CGK)', 'Bali (DPS)', '08:00:00', '10:50:00', 1250000),
('AA-102', 'Surabaya (SUB)', 'Jakarta (CGK)', '13:15:00', '14:45:00', 850000);

-- Setup Maskapai BB
USE `maskapai_bb`;

CREATE TABLE IF NOT EXISTS `flight` (
  `flightID` VARCHAR(10) PRIMARY KEY,
  `from` VARCHAR(50) NOT NULL,
  `to` VARCHAR(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `flightTime` (
  `timeID` INT AUTO_INCREMENT PRIMARY KEY,
  `flightID` VARCHAR(10) NOT NULL,
  `date` DATE NOT NULL,
  `depart` TIME NOT NULL,
  `arrive` TIME NOT NULL,
  `duration` VARCHAR(20) NOT NULL,
  `price` INT NOT NULL,
  FOREIGN KEY (`flightID`) REFERENCES `flight` (`flightID`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

SET FOREIGN_KEY_CHECKS = 0;
TRUNCATE TABLE `flightTime`;
TRUNCATE TABLE `flight`;
SET FOREIGN_KEY_CHECKS = 1;

INSERT INTO `flight` (`flightID`, `from`, `to`) VALUES
('BB-201', 'Jakarta (CGK)', 'Singapore (SIN)'),
('BB-202', 'Medan (KNO)', 'Kuala Lumpur (KUL)');

INSERT INTO `flightTime` (`flightID`, `date`, `depart`, `arrive`, `duration`, `price`) VALUES
('BB-201', '2026-06-12', '09:30:00', '12:20:00', '1h 50m', 1500000),
('BB-202', '2026-06-12', '16:00:00', '17:00:00', '1h 00m', 1100000);

-- Setup Maskapai CC
USE `maskapai_cc`;

CREATE TABLE IF NOT EXISTS `penerbangan` (
  `kode_penerbangan` VARCHAR(10) PRIMARY KEY,
  `maskapai` VARCHAR(50) NOT NULL,
  `dari` VARCHAR(50) NOT NULL,
  `ke` VARCHAR(50) NOT NULL,
  `durasi` VARCHAR(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `jadwal` (
  `id_jadwal` INT AUTO_INCREMENT PRIMARY KEY,
  `kode_penerbangan` VARCHAR(10) NOT NULL,
  `tanggal` DATE NOT NULL,
  `berangkat` TIME NOT NULL,
  `tiba` TIME NOT NULL,
  `harga` INT NOT NULL,
  FOREIGN KEY (`kode_penerbangan`) REFERENCES `penerbangan` (`kode_penerbangan`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

SET FOREIGN_KEY_CHECKS = 0;
TRUNCATE TABLE `jadwal`;
TRUNCATE TABLE `penerbangan`;
SET FOREIGN_KEY_CHECKS = 1;

INSERT INTO `penerbangan` (`kode_penerbangan`, `maskapai`, `dari`, `ke`, `durasi`) VALUES
('CC-301', 'Maskapai CC', 'Jakarta (CGK)', 'Yogyakarta (YIA)', '1h 10m'),
('CC-302', 'Maskapai CC', 'Bali (DPS)', 'Surabaya (SUB)', '0h 55m');

INSERT INTO `jadwal` (`kode_penerbangan`, `tanggal`, `berangkat`, `tiba`, `harga`) VALUES
('CC-301', '2026-06-13', '06:00:00', '07:10:00', 750000),
('CC-302', '2026-06-13', '19:45:00', '20:40:00', 600000);
