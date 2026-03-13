-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 13, 2026 at 06:43 AM
-- Server version: 8.4.3
-- PHP Version: 8.3.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sistempengelolaandatakaryawanperawat`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `data_cuti_karyawan`
--

CREATE TABLE `data_cuti_karyawan` (
  `id_cuti` bigint UNSIGNED NOT NULL,
  `nik` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tgl_pengajuan` date NOT NULL,
  `tgl_mulai` date NOT NULL,
  `tgl_selesai` date NOT NULL,
  `alasan_cuti` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status_persetujuan` enum('Menunggu','Disetujui','Ditolak') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Menunggu',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `data_cuti_karyawan`
--

INSERT INTO `data_cuti_karyawan` (`id_cuti`, `nik`, `tgl_pengajuan`, `tgl_mulai`, `tgl_selesai`, `alasan_cuti`, `status_persetujuan`, `created_at`, `updated_at`) VALUES
(1, 'PRW2026001', '2026-03-12', '2026-03-13', '2026-03-14', 'Melayat ke Kampung', 'Disetujui', '2026-03-12 13:47:55', '2026-03-12 13:48:40'),
(2, 'PRW2026001', '2026-03-13', '2026-03-16', '2026-03-17', 'Tidur', 'Disetujui', '2026-03-12 19:54:48', '2026-03-12 19:55:15');

-- --------------------------------------------------------

--
-- Table structure for table `data_karyawan`
--

CREATE TABLE `data_karyawan` (
  `nik` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_login` bigint UNSIGNED NOT NULL,
  `nama_lengkap` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenis_kelamin` enum('L','P') COLLATE utf8mb4_unicode_ci NOT NULL,
  `jabatan` enum('Perawat Terampil','Perawat Mahir','Perawat Penyelia','Perawat Ahli Pertama','Perawat Ahli Muda','Perawat Ahli Madya','Perawat Ahli Utama') COLLATE utf8mb4_unicode_ci NOT NULL,
  `status_karyawan` enum('Aktif','Resign') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `data_karyawan`
--

INSERT INTO `data_karyawan` (`nik`, `id_login`, `nama_lengkap`, `jenis_kelamin`, `jabatan`, `status_karyawan`, `created_at`, `updated_at`) VALUES
('PRW2026001', 3, 'NI WAYAN SARI', 'P', 'Perawat Penyelia', 'Aktif', '2026-03-12 13:31:11', '2026-03-12 14:05:40');

-- --------------------------------------------------------

--
-- Table structure for table `data_login`
--

CREATE TABLE `data_login` (
  `id_login` bigint UNSIGNED NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('HR','Keuangan','Perawat') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `data_presensi`
--

CREATE TABLE `data_presensi` (
  `id_presensi` bigint UNSIGNED NOT NULL,
  `nik` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal` date NOT NULL,
  `jam_masuk` time DEFAULT NULL,
  `jam_keluar` time DEFAULT NULL,
  `keterangan_shift` enum('Pagi','Siang','Malam') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `data_presensi`
--

INSERT INTO `data_presensi` (`id_presensi`, `nik`, `tanggal`, `jam_masuk`, `jam_keluar`, `keterangan_shift`, `created_at`, `updated_at`) VALUES
(11, 'PRW2026001', '2026-03-13', '05:40:17', '03:54:16', 'Pagi', '2026-03-12 13:40:17', '2026-03-12 19:54:16');

-- --------------------------------------------------------

--
-- Table structure for table `data_tunjangan_karyawan`
--

CREATE TABLE `data_tunjangan_karyawan` (
  `id_tunjangan` bigint UNSIGNED NOT NULL,
  `nik` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `periode_bulan` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nominal_dasar` int NOT NULL,
  `total_tunjangan` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `data_tunjangan_karyawan`
--

INSERT INTO `data_tunjangan_karyawan` (`id_tunjangan`, `nik`, `periode_bulan`, `nominal_dasar`, `total_tunjangan`, `created_at`, `updated_at`) VALUES
(1, 'PRW2026001', '2026-03', 2000000, 4000000, '2026-03-12 13:46:48', '2026-03-12 13:46:48'),
(2, 'PRW2026001', '2026-04', 3500000, 3550000, '2026-03-12 19:52:28', '2026-03-12 19:52:28');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_03_11_202858_create_data_logins_table', 1),
(5, '2026_03_11_202859_create_data_karyawans_table', 1),
(6, '2026_03_11_202860_create_data_presensis_table', 1),
(7, '2026_03_11_202861_create_data_cuti_karyawans_table', 1),
(8, '2026_03_11_203062_create_data_tunjangan_karyawans_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('NrQYsMACNYCOpvDQpX4buI9fSPeWHl0OAj2WBou2', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiOWFiU0M4cW5zMVVqTlJ0ZWR0Vk1iOHlNbHExNWRpc2ZHUGc0YmhuayI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMCI7czo1OiJyb3V0ZSI7Tjt9fQ==', 1773376352);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'perawat',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `role`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin HRD Utama', 'adminhrd', 'hrd', '$2y$12$T7apwYIsmxMipxfdhpY1yuSdyPCbmP/5arjWrtrLOwtV.iLIukN8G', NULL, '2026-03-12 13:08:35', '2026-03-12 13:08:35'),
(2, 'Ibu Finance', 'adminkeuangan', 'keuangan', '$2y$12$lPXeJqloOikjyOngl3lfAez1d5Fuzy6E.hysC.9CaJZwJJ0VygsXi', NULL, '2026-03-12 13:08:35', '2026-03-12 13:08:35'),
(3, 'Ni Wayan Sari, S.Kep', 'PRW2026001', 'perawat', '$2y$12$MBjZ8MvjBwETlJPavmBbi.hPX3F2kzSvcwzIWQl4PRLphVgEJslUa', NULL, '2026-03-12 13:08:36', '2026-03-12 13:08:36');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `data_cuti_karyawan`
--
ALTER TABLE `data_cuti_karyawan`
  ADD PRIMARY KEY (`id_cuti`),
  ADD KEY `data_cuti_karyawan_nik_foreign` (`nik`);

--
-- Indexes for table `data_karyawan`
--
ALTER TABLE `data_karyawan`
  ADD PRIMARY KEY (`nik`),
  ADD UNIQUE KEY `data_karyawan_id_login_unique` (`id_login`);

--
-- Indexes for table `data_login`
--
ALTER TABLE `data_login`
  ADD PRIMARY KEY (`id_login`),
  ADD UNIQUE KEY `data_login_username_unique` (`username`);

--
-- Indexes for table `data_presensi`
--
ALTER TABLE `data_presensi`
  ADD PRIMARY KEY (`id_presensi`),
  ADD KEY `data_presensi_nik_foreign` (`nik`);

--
-- Indexes for table `data_tunjangan_karyawan`
--
ALTER TABLE `data_tunjangan_karyawan`
  ADD PRIMARY KEY (`id_tunjangan`),
  ADD KEY `data_tunjangan_karyawan_nik_foreign` (`nik`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_reserved_at_available_at_index` (`queue`,`reserved_at`,`available_at`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_username_unique` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `data_cuti_karyawan`
--
ALTER TABLE `data_cuti_karyawan`
  MODIFY `id_cuti` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `data_login`
--
ALTER TABLE `data_login`
  MODIFY `id_login` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `data_presensi`
--
ALTER TABLE `data_presensi`
  MODIFY `id_presensi` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `data_tunjangan_karyawan`
--
ALTER TABLE `data_tunjangan_karyawan`
  MODIFY `id_tunjangan` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `data_cuti_karyawan`
--
ALTER TABLE `data_cuti_karyawan`
  ADD CONSTRAINT `data_cuti_karyawan_nik_foreign` FOREIGN KEY (`nik`) REFERENCES `data_karyawan` (`nik`) ON DELETE CASCADE;

--
-- Constraints for table `data_karyawan`
--
ALTER TABLE `data_karyawan`
  ADD CONSTRAINT `data_karyawan_id_login_foreign` FOREIGN KEY (`id_login`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT;

--
-- Constraints for table `data_presensi`
--
ALTER TABLE `data_presensi`
  ADD CONSTRAINT `data_presensi_nik_foreign` FOREIGN KEY (`nik`) REFERENCES `data_karyawan` (`nik`) ON DELETE CASCADE;

--
-- Constraints for table `data_tunjangan_karyawan`
--
ALTER TABLE `data_tunjangan_karyawan`
  ADD CONSTRAINT `data_tunjangan_karyawan_nik_foreign` FOREIGN KEY (`nik`) REFERENCES `data_karyawan` (`nik`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
