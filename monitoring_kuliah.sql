/*
 Navicat Premium Data Transfer

 Source Server         : localhostt
 Source Server Type    : MySQL
 Source Server Version : 50734
 Source Host           : localhost:3306
 Source Schema         : monitoring_kuliah

 Target Server Type    : MySQL
 Target Server Version : 50734
 File Encoding         : 65001

 Date: 15/04/2022 12:55:08
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for dosen
-- ----------------------------
DROP TABLE IF EXISTS `dosen`;
CREATE TABLE `dosen` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `prodi_id` varchar(11) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nidn` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jenis_kelamin` enum('laki-laki','perempuan') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of dosen
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for failed_jobs
-- ----------------------------
DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of failed_jobs
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for mahasiswa
-- ----------------------------
DROP TABLE IF EXISTS `mahasiswa`;
CREATE TABLE `mahasiswa` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `prodi_id` int(11) DEFAULT NULL,
  `nim` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jenis_kelamin` enum('laki-laki','perempuan') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_ketua` enum('ya','tidak') COLLATE utf8mb4_unicode_ci DEFAULT 'tidak',
  `tahun_angkatan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of mahasiswa
-- ----------------------------
BEGIN;
INSERT INTO `mahasiswa` VALUES (1, 1, '111111', 'Abdurrahman Shifa', 'abdurrahmanshifa@gmail.com', 'laki-laki', 'ya', '2013', '2022-04-13 13:42:37', '2022-04-13 13:42:37', NULL);
INSERT INTO `mahasiswa` VALUES (2, 1, '111111', 'Shifa', 'abdurrahmanshif@gmail.com', 'perempuan', 'tidak', '2013', '2022-04-13 13:42:37', '2022-04-13 13:42:37', NULL);
COMMIT;

-- ----------------------------
-- Table structure for mata_kuliah
-- ----------------------------
DROP TABLE IF EXISTS `mata_kuliah`;
CREATE TABLE `mata_kuliah` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `prodi_id` int(11) DEFAULT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of mata_kuliah
-- ----------------------------
BEGIN;
INSERT INTO `mata_kuliah` VALUES (1, 1, 'Peringatan Keamanan', NULL, '2022-04-13 13:55:12', '2022-04-13 13:55:12', NULL);
COMMIT;

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of migrations
-- ----------------------------
BEGIN;
INSERT INTO `migrations` VALUES (5, '2014_10_12_000000_create_users_table', 1);
INSERT INTO `migrations` VALUES (6, '2014_10_12_100000_create_password_resets_table', 1);
INSERT INTO `migrations` VALUES (7, '2019_08_19_000000_create_failed_jobs_table', 1);
INSERT INTO `migrations` VALUES (8, '2019_12_14_000001_create_personal_access_tokens_table', 1);
INSERT INTO `migrations` VALUES (9, '2022_04_07_042859_create_mahasiswa_table', 2);
INSERT INTO `migrations` VALUES (10, '2022_04_07_043356_create_prodi_table', 2);
INSERT INTO `migrations` VALUES (11, '2022_04_07_043505_create_mata_kuliah_table', 2);
INSERT INTO `migrations` VALUES (12, '2022_04_07_043642_create_dosen_table', 2);
INSERT INTO `migrations` VALUES (13, '2022_04_07_043750_create_ruang_table', 2);
INSERT INTO `migrations` VALUES (14, '2022_04_07_233806_create_semester_table', 3);
INSERT INTO `migrations` VALUES (15, '2022_04_08_031938_create_monitoring_table', 4);
INSERT INTO `migrations` VALUES (16, '2022_04_15_024149_create_survey_pertanyaan_table', 5);
INSERT INTO `migrations` VALUES (17, '2022_04_15_024402_create_survey_table', 5);
COMMIT;

-- ----------------------------
-- Table structure for monitoring
-- ----------------------------
DROP TABLE IF EXISTS `monitoring`;
CREATE TABLE `monitoring` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `semester_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `prodi_id` int(11) NOT NULL,
  `tgl_perkuliahan` date NOT NULL,
  `mata_kuliah_id` int(11) NOT NULL,
  `pokok_bahasan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dosen_id` int(11) NOT NULL,
  `ruang_id` int(11) NOT NULL,
  `hadir_dosen` enum('hadir','tidak hadir','jadwal ulang','lainnya') COLLATE utf8mb4_unicode_ci NOT NULL,
  `ket_hadir_dosen` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jumlah_mahasiswa` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `foto_absensi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `foto_mahasiswa` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of monitoring
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for password_resets
-- ----------------------------
DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of password_resets
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for personal_access_tokens
-- ----------------------------
DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of personal_access_tokens
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for prodi
-- ----------------------------
DROP TABLE IF EXISTS `prodi`;
CREATE TABLE `prodi` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of prodi
-- ----------------------------
BEGIN;
INSERT INTO `prodi` VALUES (1, 'Teknik Informatika', NULL, '2022-04-13 19:01:01', '2022-04-13 13:35:23', NULL);
INSERT INTO `prodi` VALUES (4, 'Teknik Industri', NULL, '2022-04-15 00:31:04', '2022-04-15 00:31:04', NULL);
INSERT INTO `prodi` VALUES (5, 'Teknik Kimia', NULL, '2022-04-15 00:31:32', '2022-04-15 00:31:32', NULL);
COMMIT;

-- ----------------------------
-- Table structure for ruang
-- ----------------------------
DROP TABLE IF EXISTS `ruang`;
CREATE TABLE `ruang` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of ruang
-- ----------------------------
BEGIN;
INSERT INTO `ruang` VALUES (1, 'JCO', NULL, '2022-04-13 13:55:31', '2022-04-13 13:55:31', NULL);
COMMIT;

-- ----------------------------
-- Table structure for semester
-- ----------------------------
DROP TABLE IF EXISTS `semester`;
CREATE TABLE `semester` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tahun` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('aktif','tidak aktif') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'tidak aktif',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of semester
-- ----------------------------
BEGIN;
INSERT INTO `semester` VALUES (1, 'Semester Ganjil', '2020-2021', 'aktif', '2022-04-13 14:01:32', '2022-04-13 14:01:32', NULL);
COMMIT;

-- ----------------------------
-- Table structure for survey
-- ----------------------------
DROP TABLE IF EXISTS `survey`;
CREATE TABLE `survey` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `dosen_id` int(11) NOT NULL,
  `semester_id` int(11) NOT NULL,
  `pertanyaan_id` int(11) NOT NULL,
  `nilai` enum('Sangat Baik','Baik','Cukup','Kurang') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of survey
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for survey_pertanyaan
-- ----------------------------
DROP TABLE IF EXISTS `survey_pertanyaan`;
CREATE TABLE `survey_pertanyaan` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keterangan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of survey_pertanyaan
-- ----------------------------
BEGIN;
INSERT INTO `survey_pertanyaan` VALUES (1, 'Kemampuan dosen menjelaskan materi perkuliahan dan menghidupkan suasana kelas', 'Aspek Pedagogik', '2022-04-15 09:52:45', NULL, NULL);
INSERT INTO `survey_pertanyaan` VALUES (2, 'Kemampuan dosen terhadap bidang/topik yang diajarkan, menerapkan kedisiplinan ', 'Aspek Profesionalisme', '2022-04-15 09:53:09', NULL, NULL);
INSERT INTO `survey_pertanyaan` VALUES (3, 'Menjadi contoh bersikap, arif dalam mengambil keputusan dan kewibawaan sebagai dosen', 'Aspek Kepribadian', '2022-04-15 09:53:29', NULL, NULL);
INSERT INTO `survey_pertanyaan` VALUES (4, 'Mengenal dengan baik mahasiswa serta mampu menerima saran dan kritik serta perbedaan pendapat', 'Aspek Sosial', '2022-04-15 09:53:51', NULL, NULL);
INSERT INTO `survey_pertanyaan` VALUES (5, 'Pemanfaatan media teknologi informasi dan komunikasi serta SPADA', 'Aspek Teknologi', '2022-04-15 09:54:09', NULL, NULL);
COMMIT;

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `prodi_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` enum('admin','prodi','mahasiswa') COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('aktif','tidak aktif') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'aktif',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of users
-- ----------------------------
BEGIN;
INSERT INTO `users` VALUES (1, NULL, 'Administrator', 'admin@gmail.com', NULL, '$2y$10$888b0Yveo0hbhRkGQ74hne9MHAD.8D0jmOiEqOYBHWFIsxZDS4CnO', 'admin', 'aktif', NULL, '2022-04-07 03:55:24', '2022-04-07 03:55:24', NULL);
INSERT INTO `users` VALUES (3, 1, 'Prodi Teknik Informatika', 'ti@gmail.com', NULL, '$2y$10$A.ej.Ku6mMKipCrXxbIjzeglDTBRedaMw29UUfpT91uGOh2lY96PC', 'prodi', 'aktif', NULL, '2022-04-07 07:49:14', '2022-04-07 07:49:14', NULL);
INSERT INTO `users` VALUES (4, 1, 'Abdurrahman Shifa', 'abdurrahmanshifa@gmail.com', NULL, '$2y$10$yVzce2i.5tWX5wQQPL3KG.COOdKAuuZp.JzeQ7.B7wDSg7J0mHhKW', 'mahasiswa', 'aktif', NULL, '2022-04-13 13:42:37', '2022-04-13 13:42:37', NULL);
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
