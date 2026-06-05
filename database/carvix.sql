-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Waktu pembuatan: 21 Bulan Mei 2026 pada 05.44
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `Skensa Auto Service`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `bookings`
--

CREATE TABLE `bookings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `booking_code` varchar(255) NOT NULL,
  `vehicle_id` bigint(20) UNSIGNED NOT NULL,
  `service_type` varchar(255) NOT NULL,
  `complaint` text DEFAULT NULL,
  `service_date` date NOT NULL,
  `specialist` varchar(255) DEFAULT NULL,
  `handled_by` varchar(255) DEFAULT NULL,
  `admin_notes` text DEFAULT NULL,
  `estimated_finish` datetime DEFAULT NULL,
  `service_cost` decimal(12,2) DEFAULT NULL,
  `status` enum('pending','confirmed','in_progress','completed','cancelled') NOT NULL DEFAULT 'pending',
  `progress` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `bookings`
--

INSERT INTO `bookings` (`id`, `booking_code`, `vehicle_id`, `service_type`, `complaint`, `service_date`, `specialist`, `handled_by`, `admin_notes`, `estimated_finish`, `service_cost`, `status`, `progress`, `created_at`, `updated_at`) VALUES
(1, 'CRVX-CLET-1169', 1, 'Full Maintenance', '-', '2026-05-18', NULL, NULL, NULL, NULL, NULL, 'completed', 100, '2026-05-17 08:52:15', '2026-05-17 08:56:10'),
(2, 'CRVX-MN0I-5015', 2, 'Apex Performance Upgrade', 'UPGRADE PERFORMANCE', '2026-05-18', 'KORPRI', NULL, NULL, NULL, NULL, 'completed', 100, '2026-05-17 19:12:22', '2026-05-17 19:17:48'),
(3, 'CRVX-MX2G-3332', 2, 'Full Maintenance', NULL, '2026-05-19', 'LANANG', NULL, NULL, NULL, NULL, 'completed', 100, '2026-05-18 02:08:25', '2026-05-18 02:10:15'),
(4, 'CRVX-LFMT-9452', 3, 'Full Maintenance', 'tes', '2026-05-30', 'SANKLENG', NULL, NULL, NULL, NULL, 'completed', 100, '2026-05-18 05:08:27', '2026-05-18 05:09:15'),
(5, 'CRVX-QIOL-1532', 4, 'Engine Service', 'Gabisa kebeli, uang nya nggada hiks', '2026-05-18', 'SANKLENG', NULL, NULL, NULL, NULL, 'completed', 100, '2026-05-18 05:09:23', '2026-05-18 05:10:47'),
(6, 'CRVX-QKMY-5461', 2, 'Full Maintenance', NULL, '2026-05-18', 'SANKLENG', NULL, NULL, NULL, NULL, 'completed', 100, '2026-05-18 05:16:21', '2026-05-18 05:16:42'),
(7, 'CRVX-ASPN-6638', 5, 'Diagnostic', 'RUSAK', '2026-05-18', 'badra', 'badra', NULL, '2026-05-18 22:58:00', NULL, 'cancelled', 0, '2026-05-18 05:38:16', '2026-05-18 06:58:54'),
(8, 'CRVX-VXEI-5535', 6, 'Diagnostic', NULL, '2026-05-30', 'q2eww', 'q2eww', '232r', '2026-05-15 22:49:00', NULL, 'cancelled', 0, '2026-05-18 05:53:12', '2026-05-18 06:49:55'),
(9, 'CRVX-VCET-3375', 7, 'Full Maintenance', NULL, '2026-05-27', 'em', 'em', 'tes', '2026-05-28 12:02:00', NULL, 'completed', 100, '2026-05-18 07:07:38', '2026-05-18 21:07:49'),
(10, 'CRVX-E3UF-6659', 2, 'Full Maintenance', NULL, '2026-05-18', 'SANKLENG', 'SANKLENG', 'alat tidak tersedia', '2026-05-18 23:16:00', NULL, 'cancelled', 0, '2026-05-18 07:15:42', '2026-05-18 07:16:46'),
(11, 'CRVX-HSJG-1799', 8, 'Full Maintenance', NULL, '2026-05-28', 'em', 'em', 'mek', '2026-05-29 11:23:00', NULL, 'cancelled', 0, '2026-05-18 21:14:12', '2026-05-18 21:16:13');

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `invoices`
--

CREATE TABLE `invoices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `invoice_number` varchar(255) NOT NULL,
  `booking_id` bigint(20) UNSIGNED NOT NULL,
  `subtotal` decimal(10,2) NOT NULL DEFAULT 0.00,
  `tax` decimal(10,2) NOT NULL DEFAULT 0.00,
  `total` decimal(10,2) NOT NULL DEFAULT 0.00,
  `payment_status` enum('unpaid','paid','partial') NOT NULL DEFAULT 'unpaid',
  `issue_date` date NOT NULL,
  `due_date` date NOT NULL,
  `paid_at` timestamp NULL DEFAULT NULL,
  `items` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`items`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `invoices`
--

INSERT INTO `invoices` (`id`, `invoice_number`, `booking_id`, `subtotal`, `tax`, `total`, `payment_status`, `issue_date`, `due_date`, `paid_at`, `items`, `created_at`, `updated_at`) VALUES
(1, 'INV-XFGK-2026-648', 2, 5000000.00, 550000.00, 5550000.00, 'paid', '2026-05-18', '2026-06-01', '2026-05-17 19:24:11', '[{\"description\":\"Apex Performance Upgrade\",\"qty\":1,\"unit_price\":\"5000000\",\"total\":\"5000000\"}]', '2026-05-17 19:15:17', '2026-05-17 19:24:11'),
(2, 'INV-20260518-KXWA', 3, 5000000.00, 550000.00, 5550000.00, 'paid', '2026-05-18', '2026-06-01', '2026-05-18 02:11:27', '[{\"description\":\"Full Maintenance\",\"qty\":\"1\",\"unit_price\":\"5000000\",\"total\":5000000}]', '2026-05-18 02:10:15', '2026-05-18 02:11:27'),
(3, 'INV-20260518-OB9Z', 5, 100000.00, 11000.00, 111000.00, 'unpaid', '2026-05-18', '2026-06-01', NULL, '[{\"description\":\"Engine Service\",\"qty\":\"1\",\"unit_price\":\"100000\",\"total\":100000}]', '2026-05-18 05:10:47', '2026-05-18 05:10:48'),
(4, 'INV-20260518-GVU1', 6, 9999998.00, 1099999.78, 11099997.78, 'unpaid', '2026-05-18', '2026-06-01', NULL, '[{\"description\":\"Full Maintenance\",\"qty\":\"1\",\"unit_price\":\"9999998\",\"total\":9999998}]', '2026-05-18 05:16:42', '2026-05-18 05:16:42'),
(5, 'INV-20260518-NJ9K', 7, 68000.00, 7480.00, 75480.00, 'paid', '2026-05-18', '2026-06-01', '2026-05-18 06:24:02', '[{\"description\":\"Diagnostic\",\"qty\":\"1\",\"unit_price\":\"67000\",\"total\":67000},{\"description\":\"biaya hidup\",\"qty\":\"1\",\"unit_price\":\"1000\",\"total\":1000}]', '2026-05-18 06:04:48', '2026-05-18 06:24:02'),
(6, 'INV-20260518-1CNG', 8, 2000.00, 220.00, 2220.00, 'paid', '2026-05-18', '2026-06-01', '2026-05-18 06:49:55', '[{\"description\":\"Diagnostic\",\"qty\":\"1\",\"unit_price\":\"2000\",\"total\":2000}]', '2026-05-18 06:49:55', '2026-05-18 06:49:55'),
(7, 'INV-20260519-NG6M', 9, 1000000.00, 110000.00, 1110000.00, 'unpaid', '2026-05-19', '2026-06-02', NULL, '[{\"description\":\"Full Maintenance\",\"qty\":\"1\",\"unit_price\":\"1000000\",\"total\":1000000}]', '2026-05-18 19:56:29', '2026-05-18 21:07:49');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_04_30_062501_create_vehicles_table', 1),
(5, '2026_04_30_062502_create_bookings_table', 1),
(6, '2026_04_30_062503_create_services_table', 1),
(7, '2026_04_30_062504_create_invoices_table', 1),
(8, '2026_05_17_154903_add_user_id_to_vehicles_table', 1),
(9, '2026_05_18_000001_add_role_to_users_table', 2),
(10, '2026_05_18_000002_add_admin_fields_to_bookings_table', 3),
(11, '2026_05_18_032052_add_paid_at_to_invoices_table', 4);

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `services`
--

CREATE TABLE `services` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `booking_id` bigint(20) UNSIGNED NOT NULL,
  `stage_name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `status` enum('pending','in_progress','completed') NOT NULL DEFAULT 'pending',
  `completed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('cQxYL20qoeR9dKd55D2sb7ewMARQtlCvtbvaRcjM', 4, '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiQjd0NmJTNzVuaFgxaE9iUlNsV3B6OUtRRHN0NTlDamVBbmFldVR1UyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjk6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9oaXN0b3J5IjtzOjU6InJvdXRlIjtzOjc6Imhpc3RvcnkiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTo0O30=', 1779208193),
('LPJrQtg2sJcQhWOJ3uGYEmxQiLJy4sRxiv5mXgcc', 2, '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiZUJXZ0dodGRHbGc3ZmhKUlJCVnZVQkc5Q1BzM2lMa0lVSlYxWkFFMCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9kYXNoYm9hcmQiO3M6NToicm91dGUiO3M6MTU6ImFkbWluLmRhc2hib2FyZCI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjI7fQ==', 1779333226),
('pNGWHD3o6qPG28gYZDy104F5m0DXmAi5GgebvOG1', 3, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 Edg/148.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiQUFac1MyRjk3ZU1mWk1OemtxS0txVzA0VDlWdFRmYldVRWVSVWZFMyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjk6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9oaXN0b3J5IjtzOjU6InJvdXRlIjtzOjc6Imhpc3RvcnkiO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTozO30=', 1779207953),
('Ut31M4iOxeL2fXcLG4Zy3yDOfwjzp9F0tDQncoZY', 2, '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64; rv:146.0) Gecko/20100101 Firefox/146.0', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiTURkMnU2bUFhZEg3QVhES0ozcDdSTHAwTFdvWEFFSEtYenU4OEZpOSI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czozOToiaHR0cDovL2xvY2FsaG9zdDo4MDAwL2FkbWluL2Jvb2tpbmdzLzExIjt9czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzc6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9hZG1pbi9kYXNoYm9hcmQiO3M6NToicm91dGUiO3M6MTU6ImFkbWluLmRhc2hib2FyZCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjI7fQ==', 1779204661);

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `role` enum('user','admin') NOT NULL DEFAULT 'user',
  `phone` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `role`, `phone`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'RIZKY', 'rizkyramadhan8057@gmail.com', 'user', '+6281238085758', NULL, '$2y$12$Amiipt4Q.Yvb//GOu.Tej.aHcRMk5KVXwZY/DlceOUfsDnna/bbTu', NULL, '2026-05-17 07:55:12', '2026-05-17 07:55:12'),
(2, 'Admin Skensa Auto Service', 'admin@Skensa Auto Service.com', 'admin', '08123456789', NULL, '$2y$12$MkbdTWgr2ROgzKewziayeezIg3Bw7lXPug1XhlZnkhCt6JREoc96C', NULL, '2026-05-17 08:16:45', '2026-05-17 08:16:45'),
(3, 'Falihah Nailatusy Syarafah', 'falihahnayla12@gmail.com', 'user', '089505434624', NULL, '$2y$12$e2k0FSSHRO56yTRQd4vkv.lgvmdpcmJfRQc9ksZSu2isY9e.0raBe', NULL, '2026-05-18 05:03:59', '2026-05-18 05:03:59'),
(4, 'gus sanjaya', 'idabagusputusanjaya@gmail.com', 'user', '081238716369', NULL, '$2y$12$YlMMf2aNPfgYdrIfx56GfuwsfIX8EHugIfXVuYnGpugFhrxIQr5dy', NULL, '2026-05-18 05:06:22', '2026-05-18 05:06:22'),
(5, 'bap', 'bapanci@gmail.com', 'user', '676767676767', NULL, '$2y$12$vC9Re/T5vRyiCuxKcmE4sO0TuaxgeY7ZHt4JUtVKjnKYC7yEN89pC', 'agFHvwqqkIwTy0cIIvxh1W8OkhS2IGhQFdoucL82h2RxOhglfIF1PE3yk4g4', '2026-05-18 05:36:44', '2026-05-18 05:36:44');

-- --------------------------------------------------------

--
-- Struktur dari tabel `vehicles`
--

CREATE TABLE `vehicles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `owner_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `brand` varchar(255) NOT NULL,
  `model` varchar(255) NOT NULL,
  `year` year(4) NOT NULL,
  `license_plate` varchar(255) NOT NULL,
  `vin` varchar(255) NOT NULL,
  `color` varchar(255) DEFAULT NULL,
  `mileage` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `vehicles`
--

INSERT INTO `vehicles` (`id`, `owner_name`, `email`, `phone`, `brand`, `model`, `year`, `license_plate`, `vin`, `color`, `mileage`, `created_at`, `updated_at`, `user_id`) VALUES
(1, 'RIZKY', 'rizkyramadhan8057@gmail.com', '+6281238085758', 'FORD', 'RAPTOR', '2025', 'DK-1-KY', 'O1AH8EHQCGXUER9NL', NULL, 0, '2026-05-17 08:52:15', '2026-05-17 08:52:15', 1),
(2, 'RIZKY', 'rizkyramadhan8057@gmail.com', '+6281238085758', 'Toyota', 'Fortuner', '2013', 'DK 1781 HK', '6XDW3MBGJG1QVN7LJ', NULL, 0, '2026-05-17 19:12:22', '2026-05-17 19:12:22', 1),
(3, 'gus sanjaya', 'idabagusputusanjaya@gmail.com', '081238716369', 'Mercedes-AMG', 'GT 63 Pro', '2026', 'DK 1234 AB', 'TQRBMXKFQ1SVHZ9I4', NULL, 0, '2026-05-18 05:08:27', '2026-05-18 05:08:27', 4),
(4, 'Falihah Nailatusy Syarafah', 'falihahnayla12@gmail.com', '089505434624', 'Lamborghini', 'Temerario', '2025', 'SA-5643-T', '86FY63HKUJKZUBIN5', NULL, 0, '2026-05-18 05:09:23', '2026-05-18 05:09:23', 3),
(5, 'bap', 'bapanci@gmail.com', '676767676767', 'Aston Martin', 'Valkryie', '1990', '12367DC', 'NPJBSGGUP6AYNCXGD', NULL, 0, '2026-05-18 05:38:16', '2026-05-18 05:38:16', 5),
(6, 'gus sanjaya', 'idabagusputusanjaya@gmail.com', '081238716369', 'Mercedes-AMG', 'GT 60 Pro', '2002', 'DK 1234 ABC', '9B4Y67TOL860MLXOT', NULL, 0, '2026-05-18 05:53:12', '2026-05-18 05:53:12', 4),
(7, 'gus sanjaya', 'idabagusputusanjaya@gmail.com', '081238716369', 'Mercedes-AMG', 'GT 59 Pro', '2023', 'DK 54 ABC', 'UK0EWFHFSJTNVOYHN', NULL, 0, '2026-05-18 07:07:38', '2026-05-18 07:07:38', 4),
(8, 'gus sanjaya', 'idabagusputusanjaya@gmail.com', '081238716369', 'Mercedes-AMG', 'GT 6 Pro', '2009', 'DK 54 N', '7THB6PQHT1RZ7MGLH', NULL, 0, '2026-05-18 21:14:12', '2026-05-18 21:14:12', 4);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `bookings_booking_code_unique` (`booking_code`),
  ADD KEY `bookings_vehicle_id_foreign` (`vehicle_id`);

--
-- Indeks untuk tabel `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indeks untuk tabel `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `invoices_invoice_number_unique` (`invoice_number`),
  ADD KEY `invoices_booking_id_foreign` (`booking_id`);

--
-- Indeks untuk tabel `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indeks untuk tabel `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indeks untuk tabel `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`),
  ADD KEY `services_booking_id_foreign` (`booking_id`);

--
-- Indeks untuk tabel `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indeks untuk tabel `vehicles`
--
ALTER TABLE `vehicles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `vehicles_vin_unique` (`vin`),
  ADD KEY `vehicles_user_id_foreign` (`user_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `services`
--
ALTER TABLE `services`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `vehicles`
--
ALTER TABLE `vehicles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_vehicle_id_foreign` FOREIGN KEY (`vehicle_id`) REFERENCES `vehicles` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `invoices`
--
ALTER TABLE `invoices`
  ADD CONSTRAINT `invoices_booking_id_foreign` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `services`
--
ALTER TABLE `services`
  ADD CONSTRAINT `services_booking_id_foreign` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `vehicles`
--
ALTER TABLE `vehicles`
  ADD CONSTRAINT `vehicles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
