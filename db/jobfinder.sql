-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Gép: localhost
-- Létrehozás ideje: 2026. Ápr 26. 19:51
-- Kiszolgáló verziója: 10.4.32-MariaDB
-- PHP verzió: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Adatbázis: `jobfinder`
--

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- A tábla adatainak kiíratása `categories`
--

INSERT INTO `categories` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Szoftverfejlesztés', '2026-04-26 15:51:22', '2026-04-26 15:51:22'),
(2, 'Adattudomány és Mesterséges Intelligencia', '2026-04-26 15:51:22', '2026-04-26 15:51:22'),
(3, 'Rendszergazda és Felhőkezelés', '2026-04-26 15:51:22', '2026-04-26 15:51:22'),
(4, 'Kiberbiztonság', '2026-04-26 15:51:22', '2026-04-26 15:51:22'),
(5, 'UI/UX Design', '2026-04-26 15:51:22', '2026-04-26 15:51:22'),
(6, 'Pénzügy és Könyvelés', '2026-04-26 15:51:22', '2026-04-26 15:51:22'),
(7, 'Emberi Erőforrások (HR)', '2026-04-26 15:51:22', '2026-04-26 15:51:22'),
(8, 'Adminisztráció és Asszisztencia', '2026-04-26 15:51:22', '2026-04-26 15:51:22'),
(9, 'Jog és Megfelelőség', '2026-04-26 15:51:22', '2026-04-26 15:51:22'),
(10, 'Bank és Biztosítás', '2026-04-26 15:51:22', '2026-04-26 15:51:22'),
(11, 'Marketing és Kommunikáció', '2026-04-26 15:51:22', '2026-04-26 15:51:22'),
(12, 'Értékesítés és Sales', '2026-04-26 15:51:22', '2026-04-26 15:51:22'),
(13, 'Tartalomgyártás és Copywriting', '2026-04-26 15:51:22', '2026-04-26 15:51:22'),
(14, 'Grafikai tervezés és Videóvágás', '2026-04-26 15:51:22', '2026-04-26 15:51:22'),
(15, 'Ügyfélszolgálat', '2026-04-26 15:51:22', '2026-04-26 15:51:22'),
(16, 'Gyártás és Termelés', '2026-04-26 15:51:22', '2026-04-26 15:51:22'),
(17, 'Szállítás és Logisztika', '2026-04-26 15:51:22', '2026-04-26 15:51:22'),
(18, 'Építőipar és Ingatlan', '2026-04-26 15:51:22', '2026-04-26 15:51:22'),
(19, 'Vendéglátás és Turizmus', '2026-04-26 15:51:22', '2026-04-26 15:51:22'),
(20, 'Mezőgazdaság és Élelmiszeripar', '2026-04-26 15:51:22', '2026-04-26 15:51:22'),
(21, 'Oktatás és Képzés', '2026-04-26 15:51:22', '2026-04-26 15:51:22'),
(22, 'Egészségügy és Gyógyszeripar', '2026-04-26 15:51:22', '2026-04-26 15:51:22'),
(23, 'Szépségápolás és Well-being', '2026-04-26 15:51:22', '2026-04-26 15:51:22'),
(24, 'Környezetvédelem és Fenntarthatóság', '2026-04-26 15:51:22', '2026-04-26 15:51:22');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `category_job`
--

CREATE TABLE `category_job` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `job_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `currency` varchar(255) DEFAULT NULL,
  `min_salary` int(11) NOT NULL,
  `max_salary` int(11) NOT NULL,
  `location` varchar(255) DEFAULT NULL,
  `has_home_office` tinyint(1) NOT NULL,
  `capacity` int(11) NOT NULL,
  `type` enum('one-time','part-time','full-time') NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- A tábla adatainak kiíratása `jobs`
--

INSERT INTO `jobs` (`id`, `user_id`, `name`, `currency`, `min_salary`, `max_salary`, `location`, `has_home_office`, `capacity`, `type`, `description`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'Frontend programozó', 'HUF', 10000, 670000, 'Hungary', 1, 10, 'part-time', NULL, NULL, '2026-04-26 15:51:22', '2026-04-26 15:51:22'),
(2, 2, 'Backend fejlesztő', 'HUF', 5000, 10000, 'Hungary', 0, 15, 'full-time', NULL, NULL, '2026-04-26 15:51:22', '2026-04-26 15:51:22');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `job_applications`
--

CREATE TABLE `job_applications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `job_id` bigint(20) UNSIGNED NOT NULL,
  `message` text NOT NULL,
  `status` enum('pending','accepted','rejected') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `job_skill`
--

CREATE TABLE `job_skill` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `skill_id` bigint(20) UNSIGNED NOT NULL,
  `job_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `job_user`
--

CREATE TABLE `job_user` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `job_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- A tábla adatainak kiíratása `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_02_08_183705_create_notifications_table', 1),
(5, '2026_02_08_183949_create_skills_table', 1),
(6, '2026_02_08_184134_create_job_applications_table', 1),
(7, '2026_02_18_193212_create_ratings_table', 1),
(8, '2026_02_18_193925_create_organizations_table', 1),
(9, '2026_02_18_194135_create_categories_table', 1),
(10, '2026_03_01_184411_create_personal_access_tokens_table', 1);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `to_user_id` bigint(20) UNSIGNED NOT NULL,
  `from_user_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `message` varchar(255) NOT NULL,
  `type` enum('accept','reject','general','system') NOT NULL DEFAULT 'general',
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `organizations`
--

CREATE TABLE `organizations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `founded_at` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- A tábla adatainak kiíratása `organizations`
--

INSERT INTO `organizations` (`id`, `name`, `founded_at`, `created_at`, `updated_at`) VALUES
(1, 'JobNest', '2026-04-26', '2026-04-26 15:51:22', '2026-04-26 15:51:22');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `organization_user`
--

CREATE TABLE `organization_user` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `organization_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- A tábla adatainak kiíratása `organization_user`
--

INSERT INTO `organization_user` (`id`, `user_id`, `organization_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, NULL, NULL),
(2, 2, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` text NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `ratings`
--

CREATE TABLE `ratings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `job_id` bigint(20) UNSIGNED NOT NULL,
  `rating` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `skills`
--

CREATE TABLE `skills` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- A tábla adatainak kiíratása `skills`
--

INSERT INTO `skills` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'PHP (Laravel)', '2026-04-26 15:51:22', '2026-04-26 15:51:22'),
(2, 'JavaScript (React/Vue)', '2026-04-26 15:51:22', '2026-04-26 15:51:22'),
(3, 'Python', '2026-04-26 15:51:22', '2026-04-26 15:51:22'),
(4, 'Docker & Kubernetes', '2026-04-26 15:51:22', '2026-04-26 15:51:22'),
(5, 'SQL & NoSQL', '2026-04-26 15:51:22', '2026-04-26 15:51:22'),
(6, 'Figma', '2026-04-26 15:51:22', '2026-04-26 15:51:22'),
(7, 'Bérszámfejtés', '2026-04-26 15:51:22', '2026-04-26 15:51:22'),
(8, 'Projektmenedzsment', '2026-04-26 15:51:22', '2026-04-26 15:51:22'),
(9, 'Pénzügyi elemzés', '2026-04-26 15:51:22', '2026-04-26 15:51:22'),
(10, 'Munkajogi ismeretek', '2026-04-26 15:51:22', '2026-04-26 15:51:22'),
(11, 'Tárgyalástechnika', '2026-04-26 15:51:22', '2026-04-26 15:51:22'),
(12, 'Google Ads / Facebook Ads', '2026-04-26 15:51:22', '2026-04-26 15:51:22'),
(13, 'SEO optimalizálás', '2026-04-26 15:51:22', '2026-04-26 15:51:22'),
(14, 'Adobe Creative Cloud', '2026-04-26 15:51:22', '2026-04-26 15:51:22'),
(15, 'Copywriting', '2026-04-26 15:51:22', '2026-04-26 15:51:22'),
(16, 'CRM rendszerek kezelése', '2026-04-26 15:51:22', '2026-04-26 15:51:22'),
(17, 'Raktárkezelés', '2026-04-26 15:51:22', '2026-04-26 15:51:22'),
(18, 'Targoncavezetői jogosítvány', '2026-04-26 15:51:22', '2026-04-26 15:51:22'),
(19, 'Minőségbiztosítás', '2026-04-26 15:51:22', '2026-04-26 15:51:22'),
(20, 'Beszerzési ismeretek', '2026-04-26 15:51:22', '2026-04-26 15:51:22'),
(21, 'CAD tervezés', '2026-04-26 15:51:22', '2026-04-26 15:51:22'),
(22, 'Idegen nyelv oktatás', '2026-04-26 15:51:22', '2026-04-26 15:51:22'),
(23, 'Szakápolói ismeretek', '2026-04-26 15:51:22', '2026-04-26 15:51:22'),
(24, 'Előadástechnika', '2026-04-26 15:51:22', '2026-04-26 15:51:22'),
(25, 'Elsősegélynyújtás', '2026-04-26 15:51:22', '2026-04-26 15:51:22');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `skill_user`
--

CREATE TABLE `skill_user` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `skill_id` bigint(20) UNSIGNED NOT NULL,
  `level` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `gender` enum('male','female','not-given') DEFAULT 'not-given',
  `birthdate` date DEFAULT NULL,
  `role` enum('user','admin','banned') DEFAULT 'user',
  `phone` varchar(255) DEFAULT NULL,
  `work_experience` int(11) DEFAULT NULL,
  `bio` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- A tábla adatainak kiíratása `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `email`, `password`, `gender`, `birthdate`, `role`, `phone`, `work_experience`, `bio`, `created_at`, `updated_at`) VALUES
(1, 'Tamás', 'Bóka', 'tamasboka@jobnest.hu', '$2y$12$zgnme37dWaRN8AM3WCcCdOsnZPZ14DcYywQUPDgeytHurgaTOJE/m', 'male', NULL, 'admin', '062012312312', NULL, NULL, '2026-04-26 15:51:22', '2026-04-26 15:51:22'),
(2, 'Bence', 'Beretzky', 'beretzkybence@jobnest.hu', '$2y$12$qIH2hIHx3RfdiVOGghZ9KOKYijL2kkzd1FQzByfgddnLVcGVqWve2', 'male', NULL, 'admin', '0630111111', NULL, NULL, '2026-04-26 15:51:22', '2026-04-26 15:51:22');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `user_saved_jobs`
--

CREATE TABLE `user_saved_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `job_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexek a kiírt táblákhoz
--

--
-- A tábla indexei `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- A tábla indexei `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- A tábla indexei `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `category_job`
--
ALTER TABLE `category_job`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_job_category_id_foreign` (`category_id`),
  ADD KEY `category_job_job_id_foreign` (`job_id`);

--
-- A tábla indexei `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_user_id_foreign` (`user_id`);

--
-- A tábla indexei `job_applications`
--
ALTER TABLE `job_applications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `job_applications_user_id_foreign` (`user_id`),
  ADD KEY `job_applications_job_id_foreign` (`job_id`);

--
-- A tábla indexei `job_skill`
--
ALTER TABLE `job_skill`
  ADD PRIMARY KEY (`id`),
  ADD KEY `job_skill_skill_id_foreign` (`skill_id`),
  ADD KEY `job_skill_job_id_foreign` (`job_id`);

--
-- A tábla indexei `job_user`
--
ALTER TABLE `job_user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `job_user_user_id_foreign` (`user_id`),
  ADD KEY `job_user_job_id_foreign` (`job_id`);

--
-- A tábla indexei `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_to_user_id_foreign` (`to_user_id`),
  ADD KEY `notifications_from_user_id_foreign` (`from_user_id`);

--
-- A tábla indexei `organizations`
--
ALTER TABLE `organizations`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `organization_user`
--
ALTER TABLE `organization_user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `organization_user_user_id_foreign` (`user_id`),
  ADD KEY `organization_user_organization_id_foreign` (`organization_id`);

--
-- A tábla indexei `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- A tábla indexei `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`),
  ADD KEY `personal_access_tokens_expires_at_index` (`expires_at`);

--
-- A tábla indexei `ratings`
--
ALTER TABLE `ratings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ratings_user_id_foreign` (`user_id`),
  ADD KEY `ratings_job_id_foreign` (`job_id`);

--
-- A tábla indexei `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- A tábla indexei `skills`
--
ALTER TABLE `skills`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `skill_user`
--
ALTER TABLE `skill_user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `skill_user_user_id_foreign` (`user_id`),
  ADD KEY `skill_user_skill_id_foreign` (`skill_id`);

--
-- A tábla indexei `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- A tábla indexei `user_saved_jobs`
--
ALTER TABLE `user_saved_jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_saved_jobs_user_id_foreign` (`user_id`),
  ADD KEY `user_saved_jobs_job_id_foreign` (`job_id`);

--
-- A kiírt táblák AUTO_INCREMENT értéke
--

--
-- AUTO_INCREMENT a táblához `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT a táblához `category_job`
--
ALTER TABLE `category_job`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT a táblához `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT a táblához `job_applications`
--
ALTER TABLE `job_applications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT a táblához `job_skill`
--
ALTER TABLE `job_skill`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT a táblához `job_user`
--
ALTER TABLE `job_user`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT a táblához `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT a táblához `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT a táblához `organizations`
--
ALTER TABLE `organizations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT a táblához `organization_user`
--
ALTER TABLE `organization_user`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT a táblához `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT a táblához `ratings`
--
ALTER TABLE `ratings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT a táblához `skills`
--
ALTER TABLE `skills`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT a táblához `skill_user`
--
ALTER TABLE `skill_user`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT a táblához `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT a táblához `user_saved_jobs`
--
ALTER TABLE `user_saved_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Megkötések a kiírt táblákhoz
--

--
-- Megkötések a táblához `category_job`
--
ALTER TABLE `category_job`
  ADD CONSTRAINT `category_job_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `category_job_job_id_foreign` FOREIGN KEY (`job_id`) REFERENCES `jobs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Megkötések a táblához `jobs`
--
ALTER TABLE `jobs`
  ADD CONSTRAINT `jobs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Megkötések a táblához `job_applications`
--
ALTER TABLE `job_applications`
  ADD CONSTRAINT `job_applications_job_id_foreign` FOREIGN KEY (`job_id`) REFERENCES `jobs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `job_applications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Megkötések a táblához `job_skill`
--
ALTER TABLE `job_skill`
  ADD CONSTRAINT `job_skill_job_id_foreign` FOREIGN KEY (`job_id`) REFERENCES `jobs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `job_skill_skill_id_foreign` FOREIGN KEY (`skill_id`) REFERENCES `skills` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Megkötések a táblához `job_user`
--
ALTER TABLE `job_user`
  ADD CONSTRAINT `job_user_job_id_foreign` FOREIGN KEY (`job_id`) REFERENCES `jobs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `job_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Megkötések a táblához `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_from_user_id_foreign` FOREIGN KEY (`from_user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `notifications_to_user_id_foreign` FOREIGN KEY (`to_user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Megkötések a táblához `organization_user`
--
ALTER TABLE `organization_user`
  ADD CONSTRAINT `organization_user_organization_id_foreign` FOREIGN KEY (`organization_id`) REFERENCES `organizations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `organization_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Megkötések a táblához `ratings`
--
ALTER TABLE `ratings`
  ADD CONSTRAINT `ratings_job_id_foreign` FOREIGN KEY (`job_id`) REFERENCES `jobs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ratings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Megkötések a táblához `skill_user`
--
ALTER TABLE `skill_user`
  ADD CONSTRAINT `skill_user_skill_id_foreign` FOREIGN KEY (`skill_id`) REFERENCES `skills` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `skill_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Megkötések a táblához `user_saved_jobs`
--
ALTER TABLE `user_saved_jobs`
  ADD CONSTRAINT `user_saved_jobs_job_id_foreign` FOREIGN KEY (`job_id`) REFERENCES `jobs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_saved_jobs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
