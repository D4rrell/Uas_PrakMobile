-- --------------------------------------------------------
-- Host:                         localhost
-- Server version:               8.0.30 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for spk_moora
CREATE DATABASE IF NOT EXISTS `spk_moora` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `spk_moora`;

-- Dumping structure for table spk_moora.data_penilaian
CREATE TABLE IF NOT EXISTS `data_penilaian` (
  `Kode` char(2) NOT NULL,
  `Nama_Jurusan` varchar(50) NOT NULL,
  `K1` int NOT NULL,
  `K2` int NOT NULL,
  `K3` int NOT NULL,
  `K4` int NOT NULL,
  PRIMARY KEY (`Kode`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table spk_moora.data_penilaian: ~4 rows (approximately)
INSERT INTO `data_penilaian` (`Kode`, `Nama_Jurusan`, `K1`, `K2`, `K3`, `K4`) VALUES
	('A1', 'REKAYASA PERANGKAT LUNAK', 1, 1, 4, 1),
	('A2', 'MULTIMEDIA', 2, 3, 4, 2),
	('A3', 'PERKANTORAN', 3, 5, 3, 4),
	('A4', 'AKUNTANSI', 5, 3, 4, 4);

-- Dumping structure for table spk_moora.kriteria
CREATE TABLE IF NOT EXISTS `kriteria` (
  `Kode` char(2) NOT NULL,
  `Kriteria` varchar(50) NOT NULL,
  `Bobot_Kriteria` decimal(3,2) NOT NULL,
  PRIMARY KEY (`Kode`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table spk_moora.kriteria: ~5 rows (approximately)
INSERT INTO `kriteria` (`Kode`, `Kriteria`, `Bobot_Kriteria`) VALUES
	('K1', 'NILAI UTS', 0.25),
	('K2', 'TES TERTULIS', 0.25),
	('K3', 'TES LISAN', 0.20),
	('K4', 'MINAT', 0.30),
	('K5', 'Kelas', 0.40);

-- Dumping structure for table spk_moora.subkriteria_minat
CREATE TABLE IF NOT EXISTS `subkriteria_minat` (
  `Subkriteria` varchar(50) NOT NULL,
  `Bobot` int NOT NULL,
  PRIMARY KEY (`Subkriteria`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table spk_moora.subkriteria_minat: ~5 rows (approximately)
INSERT INTO `subkriteria_minat` (`Subkriteria`, `Bobot`) VALUES
	('Cukup Minat', 3),
	('Minat', 4),
	('Sangat Minat', 5),
	('Sedikit Minat', 2),
	('Tidak Minat', 1);

-- Dumping structure for table spk_moora.subkriteria_nilai_lisan
CREATE TABLE IF NOT EXISTS `subkriteria_nilai_lisan` (
  `Subkriteria` varchar(50) NOT NULL,
  `Bobot` int NOT NULL,
  PRIMARY KEY (`Subkriteria`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table spk_moora.subkriteria_nilai_lisan: ~5 rows (approximately)
INSERT INTO `subkriteria_nilai_lisan` (`Subkriteria`, `Bobot`) VALUES
	('Nilai Tes Lisan < 60', 1),
	('Nilai Tes Lisan => 60', 2),
	('Nilai Tes Lisan => 70', 3),
	('Nilai Tes Lisan => 80', 4),
	('Nilai Tes Lisan => 90', 5);

-- Dumping structure for table spk_moora.subkriteria_nilai_tertulis
CREATE TABLE IF NOT EXISTS `subkriteria_nilai_tertulis` (
  `Subkriteria` varchar(50) NOT NULL,
  `Bobot` int NOT NULL,
  PRIMARY KEY (`Subkriteria`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table spk_moora.subkriteria_nilai_tertulis: ~5 rows (approximately)
INSERT INTO `subkriteria_nilai_tertulis` (`Subkriteria`, `Bobot`) VALUES
	('Nilai Tes Tertulis  < 60', 1),
	('Nilai Tes Tertulis  => 60', 2),
	('Nilai Tes Tertulis  => 70', 3),
	('Nilai Tes Tertulis  => 80', 4),
	('Nilai Tes Tertulis  => 90', 5);

-- Dumping structure for table spk_moora.subkriteria_nilai_us
CREATE TABLE IF NOT EXISTS `subkriteria_nilai_us` (
  `Subkriteria` varchar(50) NOT NULL,
  `Bobot` int NOT NULL,
  PRIMARY KEY (`Subkriteria`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table spk_moora.subkriteria_nilai_us: ~6 rows (approximately)
INSERT INTO `subkriteria_nilai_us` (`Subkriteria`, `Bobot`) VALUES
	('Nilai US < 50', 1),
	('Nilai US => 50', 2),
	('Nilai US => 60', 3),
	('Nilai US => 70', 4),
	('Nilai US => 80', 5),
	('Nilai US => 90', 6);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
