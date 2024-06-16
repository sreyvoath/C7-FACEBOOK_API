-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 16, 2024 at 08:29 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `facebook_api`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `post_id` bigint(20) UNSIGNED NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `user_id`, `post_id`, `content`, `created_at`, `updated_at`) VALUES
(3, 4, 3, 'Very Nice', '2024-06-12 02:08:30', '2024-06-12 02:08:30'),
(4, 5, 3, 'Very Nice', '2024-06-12 02:10:13', '2024-06-12 02:10:13'),
(5, 4, 3, 'Very Nice', '2024-06-14 18:52:49', '2024-06-14 18:52:49');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
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
-- Table structure for table `friend_requests`
--

CREATE TABLE `friend_requests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sender_id` bigint(20) UNSIGNED NOT NULL,
  `receiver_id` bigint(20) UNSIGNED NOT NULL,
  `status` enum('pending','accepted','rejected') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `friend_requests`
--

INSERT INTO `friend_requests` (`id`, `sender_id`, `receiver_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 4, 2, 'pending', '2024-06-12 05:30:05', '2024-06-12 05:30:05'),
(11, 7, 4, 'pending', '2024-06-15 18:23:30', '2024-06-15 18:23:30');

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `post_id` bigint(20) UNSIGNED NOT NULL,
  `react_type` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `likes`
--

INSERT INTO `likes` (`id`, `user_id`, `post_id`, `react_type`, `created_at`, `updated_at`) VALUES
(9, 4, 1, 'Like', '2024-06-12 03:12:46', '2024-06-12 03:12:46'),
(12, 4, 3, 'Love', '2024-06-14 18:55:55', '2024-06-14 18:55:55'),
(13, 4, 3, 'Like', '2024-06-14 18:56:19', '2024-06-14 18:56:19'),
(14, 4, 2, 'Love', '2024-06-14 18:56:29', '2024-06-14 18:56:29'),
(16, 4, 7, 'Love', '2024-06-15 18:22:02', '2024-06-15 18:22:02');

-- --------------------------------------------------------

--
-- Table structure for table `media`
--

CREATE TABLE `media` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `profile_image` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `media`
--

INSERT INTO `media` (`id`, `profile_image`, `created_at`, `updated_at`) VALUES
(1, 'images/omNg8xtv9Pvs6JovCYGMRhVu1OVoxWzGsl5oxm9B.jpg', '2024-06-11 17:08:53', '2024-06-11 17:08:53'),
(2, 'images/hZLDOrZIEEdWNRYN542F0cw7uLNkj6MGuzMRTRnJ.jpg', '2024-06-14 18:46:01', '2024-06-14 18:46:01'),
(3, 'images/zNBjQA2k9R41MT5D7IX3a493dzXgtMC9o6zV7UuF.jpg', '2024-06-15 18:14:30', '2024-06-15 18:14:30'),
(4, 'images/aAC5IDMqSM8cjVagFZAVWy82hgSXyJeNH8OBmOJ0.jpg', '2024-06-15 18:14:39', '2024-06-15 18:14:39');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2019_08_19_000000_create_failed_jobs_table', 1),
(3, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(4, '2024_06_08_053259_create_permission_tables', 1),
(5, '2024_06_09_044835_create_posts_table', 1),
(6, '2024_06_11_023221_create_reset_passwords_table', 1),
(7, '2024_06_11_130934_create_media_table', 1),
(8, '2024_06_12_032325_create_likes_table', 2),
(9, '2024_06_12_032338_create_comments_table', 2),
(10, '2024_06_12_103121_create_friends_table', 3),
(11, '2024_06_12_105101_create_friend_requests_table', 3);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_permissions`
--

INSERT INTO `model_has_permissions` (`permission_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1),
(1, 'App\\Models\\User', 2),
(1, 'App\\Models\\User', 3),
(1, 'App\\Models\\User', 4),
(1, 'App\\Models\\User', 5),
(1, 'App\\Models\\User', 6),
(1, 'App\\Models\\User', 7),
(2, 'App\\Models\\User', 1),
(3, 'App\\Models\\User', 1),
(4, 'App\\Models\\User', 1),
(5, 'App\\Models\\User', 1),
(5, 'App\\Models\\User', 2),
(5, 'App\\Models\\User', 3),
(5, 'App\\Models\\User', 4),
(5, 'App\\Models\\User', 5),
(5, 'App\\Models\\User', 6),
(5, 'App\\Models\\User', 7),
(6, 'App\\Models\\User', 1),
(7, 'App\\Models\\User', 1),
(8, 'App\\Models\\User', 1),
(9, 'App\\Models\\User', 1),
(9, 'App\\Models\\User', 2),
(9, 'App\\Models\\User', 3),
(9, 'App\\Models\\User', 4),
(9, 'App\\Models\\User', 5),
(9, 'App\\Models\\User', 6),
(9, 'App\\Models\\User', 7),
(10, 'App\\Models\\User', 1),
(11, 'App\\Models\\User', 1),
(12, 'App\\Models\\User', 1);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1),
(2, 'App\\Models\\User', 1),
(2, 'App\\Models\\User', 2),
(2, 'App\\Models\\User', 3),
(2, 'App\\Models\\User', 4),
(2, 'App\\Models\\User', 5),
(2, 'App\\Models\\User', 6),
(2, 'App\\Models\\User', 7);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'view_users', 'web', '2024-06-11 09:30:39', '2024-06-11 09:30:39'),
(2, 'add_users', 'web', '2024-06-11 09:30:39', '2024-06-11 09:30:39'),
(3, 'edit_users', 'web', '2024-06-11 09:30:39', '2024-06-11 09:30:39'),
(4, 'delete_users', 'web', '2024-06-11 09:30:39', '2024-06-11 09:30:39'),
(5, 'view_roles', 'web', '2024-06-11 09:30:39', '2024-06-11 09:30:39'),
(6, 'add_roles', 'web', '2024-06-11 09:30:39', '2024-06-11 09:30:39'),
(7, 'edit_roles', 'web', '2024-06-11 09:30:39', '2024-06-11 09:30:39'),
(8, 'delete_roles', 'web', '2024-06-11 09:30:39', '2024-06-11 09:30:39'),
(9, 'view_permissions', 'web', '2024-06-11 09:30:39', '2024-06-11 09:30:39'),
(10, 'add_permissions', 'web', '2024-06-11 09:30:39', '2024-06-11 09:30:39'),
(11, 'edit_permissions', 'web', '2024-06-11 09:30:39', '2024-06-11 09:30:39'),
(12, 'delete_permissions', 'web', '2024-06-11 09:30:39', '2024-06-11 09:30:39');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(1, 'App\\Models\\User', 3, 'auth_token', '00c127964cb21473a092100e35ccad38534eb6a3ec28347d3fae8603892be211', '[\"*\"]', NULL, NULL, '2024-06-11 09:31:02', '2024-06-11 09:31:02'),
(2, 'App\\Models\\User', 4, 'auth_token', '8788e58fba4064809816fdbc0973d59e3959af369644f21f9fac699903512c6a', '[\"*\"]', '2024-06-11 17:08:57', NULL, '2024-06-11 17:07:28', '2024-06-11 17:08:57'),
(4, 'App\\Models\\User', 3, 'auth_token', 'a4a0670b296ec60652b21eb0c3a8ff21dd2e7c381a0d478777a1358649a13cec', '[\"*\"]', '2024-06-11 18:17:06', NULL, '2024-06-11 18:15:36', '2024-06-11 18:17:06'),
(6, 'App\\Models\\User', 4, 'auth_token', '636a30e71b86925966c1828fc9a9d48e49d2a585048ac2c8f99fbf1ef494837f', '[\"*\"]', '2024-06-11 18:51:11', NULL, '2024-06-11 18:36:25', '2024-06-11 18:51:11'),
(8, 'App\\Models\\User', 4, 'auth_token', 'd51756a0ccaa7ae4790197ec58c7d77561d59a9b090dbc70ddfb6c115b8b95be', '[\"*\"]', '2024-06-12 03:22:00', NULL, '2024-06-11 19:10:11', '2024-06-12 03:22:00'),
(9, 'App\\Models\\User', 4, 'auth_token', 'f80ad4864428a7e9c04c5941749cffb6425f27b6354384dd129a1d3572b026df', '[\"*\"]', '2024-06-12 02:08:36', NULL, '2024-06-12 01:37:18', '2024-06-12 02:08:36'),
(10, 'App\\Models\\User', 5, 'auth_token', 'e309ee3f8326b2e06d7cc6ea5b06dd3d30074bac29b2c6bf7f8a7ecef308d4ee', '[\"*\"]', '2024-06-12 03:26:50', NULL, '2024-06-12 02:07:45', '2024-06-12 03:26:50'),
(11, 'App\\Models\\User', 4, 'auth_token', '36690986600a3b98fe71b893dfc63b50535824d79806fa3cf0d082a34f3ce468', '[\"*\"]', '2024-06-12 02:55:54', NULL, '2024-06-12 02:31:10', '2024-06-12 02:55:54'),
(12, 'App\\Models\\User', 4, 'auth_token', '4476c898c67b37c7ced82217391ef1ad6b2c29fb4f9a26a7449789a1f7fb173c', '[\"*\"]', '2024-06-12 03:13:44', NULL, '2024-06-12 03:13:31', '2024-06-12 03:13:44'),
(13, 'App\\Models\\User', 4, 'auth_token', 'e34e826262f5da597bee4e13e44ce0c575c541f5d47ddbb92089b3372c82a1f6', '[\"*\"]', '2024-06-12 18:37:13', NULL, '2024-06-12 03:56:01', '2024-06-12 18:37:13'),
(14, 'App\\Models\\User', 4, 'auth_token', 'fe8cba31082a31e8e36f3436f5a31ddb044c8dcf24b7fa2480e3da5830402f61', '[\"*\"]', '2024-06-12 16:46:23', NULL, '2024-06-12 16:40:04', '2024-06-12 16:46:23'),
(15, 'App\\Models\\User', 5, 'auth_token', '8107227b7a9512be8b99fb006d136b1a8b7c47ef684ec9e09723dd82cb0aa867', '[\"*\"]', '2024-06-12 17:51:45', NULL, '2024-06-12 17:10:22', '2024-06-12 17:51:45'),
(16, 'App\\Models\\User', 3, 'auth_token', 'a3ebf47badf5c887ea96abf099bc7da4a2b6a073624d5890989fdd2150f566ae', '[\"*\"]', '2024-06-12 18:55:54', NULL, '2024-06-12 17:52:19', '2024-06-12 18:55:54'),
(17, 'App\\Models\\User', 5, 'auth_token', '6eab482d9674bd155967c0cdc855ad16a04cd48608fde6f9b45313941dfe8421', '[\"*\"]', '2024-06-12 18:28:04', NULL, '2024-06-12 17:55:24', '2024-06-12 18:28:04'),
(18, 'App\\Models\\User', 4, 'auth_token', 'd78f590c62c0d950b937cc760b7199e9b67a4918bb036cc41d4dd9947274fe1c', '[\"*\"]', '2024-06-12 18:58:11', NULL, '2024-06-12 18:29:30', '2024-06-12 18:58:11'),
(19, 'App\\Models\\User', 4, 'auth_token', '5601713e2cca3f50b4df4ceedc5622adf4e986062a18411f0b396caff6807ce0', '[\"*\"]', '2024-06-14 05:56:52', NULL, '2024-06-12 18:56:27', '2024-06-14 05:56:52'),
(20, 'App\\Models\\User', 3, 'auth_token', '519b25ac0bd80c5e344cf3a214893edb2248455e5c731dffcd011068e6af2d3c', '[\"*\"]', '2024-06-12 21:43:52', NULL, '2024-06-12 18:57:29', '2024-06-12 21:43:52'),
(21, 'App\\Models\\User', 3, 'auth_token', '80f6fa086a515f2808aecac3dce3711a3e33a0e5a542bf0f6658d5d91dbf0127', '[\"*\"]', '2024-06-12 21:41:33', NULL, '2024-06-12 20:03:18', '2024-06-12 21:41:33'),
(22, 'App\\Models\\User', 3, 'auth_token', 'f084664cfcd98a624670ffe2fe6f5139b47481d57b8bcbe66b73a02115d0388d', '[\"*\"]', NULL, NULL, '2024-06-12 21:01:52', '2024-06-12 21:01:52'),
(23, 'App\\Models\\User', 4, 'auth_token', '3f8cd7868ceeac93b3bbed2ec438cfcfe06aedb33498a046c3a6e6bb1e82a024', '[\"*\"]', '2024-06-14 19:00:51', NULL, '2024-06-12 21:13:52', '2024-06-14 19:00:51'),
(24, 'App\\Models\\User', 5, 'auth_token', '91fdc7a771cbd63525517cb42266402640d57ce2cd75f7bc416ab7085049cfa6', '[\"*\"]', '2024-06-12 21:45:56', NULL, '2024-06-12 21:45:36', '2024-06-12 21:45:56'),
(26, 'App\\Models\\User', 5, 'auth_token', '1df0ab8e0856f05d00e2712392441e6eedfeb8e6eaf508fd4b247fa879a38eb0', '[\"*\"]', NULL, NULL, '2024-06-13 19:38:29', '2024-06-13 19:38:29'),
(27, 'App\\Models\\User', 6, 'auth_token', 'c90e99ffa8a0bad49e324fe2a998e66856a165e4b315eb079fb3a19cd75cd10e', '[\"*\"]', NULL, NULL, '2024-06-14 18:36:23', '2024-06-14 18:36:23'),
(30, 'App\\Models\\User', 4, 'auth_token', 'fbb6ef5339431f5d05661dc10c456ab91c02d4b982dd27bfda4bea7aa1e56894', '[\"*\"]', '2024-06-15 18:22:02', NULL, '2024-06-14 18:42:36', '2024-06-15 18:22:02'),
(31, 'App\\Models\\User', 5, 'auth_token', '949c8af10242da60006a7a8f51ce2ad1536e4acf8edad3a7249a06aa8e3505b4', '[\"*\"]', '2024-06-15 18:24:19', NULL, '2024-06-14 18:59:57', '2024-06-15 18:24:19'),
(32, 'App\\Models\\User', 5, 'auth_token', '8da198e32f58afab779f781d0b98a07362eb9c7fe2d1692b326a0e53daad2a5c', '[\"*\"]', NULL, NULL, '2024-06-14 22:25:20', '2024-06-14 22:25:20'),
(33, 'App\\Models\\User', 7, 'auth_token', 'b3dc8f451e679d67a1138f0d11421568d375dd6dbf0bfaa3bc94c568b0ee6714', '[\"*\"]', NULL, NULL, '2024-06-15 18:08:29', '2024-06-15 18:08:29'),
(35, 'App\\Models\\User', 7, 'auth_token', 'a30b58e81a06d6e3cd1dc5141b6d1d20a63bff382a0625ec146296e60e08c84a', '[\"*\"]', '2024-06-15 23:28:51', NULL, '2024-06-15 18:11:38', '2024-06-15 23:28:51'),
(36, 'App\\Models\\User', 3, 'auth_token', '483409e8ac2dbeaaebb6a3d7e598c28c4fb188fca0a9f7cfb23341e25d85eca6', '[\"*\"]', '2024-06-15 18:29:14', NULL, '2024-06-15 18:25:46', '2024-06-15 18:29:14');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `title`, `content`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 'Cambodia', 'Alone with my friends', 4, '2024-06-11 20:45:16', '2024-06-11 20:45:16'),
(2, 'PNC', 'I am a student at PNC', 4, '2024-06-11 21:06:39', '2024-06-11 21:06:39'),
(3, 'PNV', 'I am a student at PNV', 5, '2024-06-12 02:08:13', '2024-06-12 02:08:13'),
(4, 'PNC', 'I am a student at PNC', 4, '2024-06-14 18:47:34', '2024-06-14 18:47:34'),
(7, 'PNV', 'this is pnv', 7, '2024-06-15 18:16:52', '2024-06-15 18:16:52');

-- --------------------------------------------------------

--
-- Table structure for table `reset_passwords`
--

CREATE TABLE `reset_passwords` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(255) NOT NULL,
  `passcode` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reset_passwords`
--

INSERT INTO `reset_passwords` (`id`, `email`, `passcode`, `created_at`, `updated_at`) VALUES
(2, 'koemsran@gmail.com', 'Y1gZwv', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'web', '2024-06-11 09:30:39', '2024-06-11 09:30:39'),
(2, 'User', 'web', '2024-06-11 09:30:39', '2024-06-11 09:30:39');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(6, 1),
(7, 1),
(8, 1),
(9, 1),
(10, 1),
(11, 1),
(12, 1);

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
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
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `media_id` int(11) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `media_id`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin@gmail.com', '2024-06-11 09:30:39', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, 'MfvHMg5e1WR4PVDxaoxI', '2024-06-11 09:30:39', '2024-06-11 09:30:39'),
(2, 'User', 'user@gmail.com', '2024-06-11 09:30:39', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, 'BH0TA8fzojsIayW8b6I8', '2024-06-11 09:30:39', '2024-06-11 09:30:39'),
(3, 'Sreyvoath', 'sreyvoath@gmail.com', '2024-06-11 09:31:02', '$2y$12$S5mTwxcgbfC6MWj1JuRO/OqRAYSOyCRkIPWBBdFZAzIAom/G4Xbna', NULL, 'UUSX6RoDMJ89X1i1B018', '2024-06-11 09:31:02', '2024-06-11 09:31:02'),
(4, 'Koemsrsan Phon', 'koemsranphon@gmail.com', '2024-06-11 17:07:28', '$2y$12$XSMxIWOIYOjypU./T2gDFOj3Wj6/X5oAAwvMu1DsYeEhVGtBLFDTa', 3, 'hZmrPYZ3fCgzjbafckSh', '2024-06-11 17:07:28', '2024-06-15 18:14:30'),
(5, 'Kemleang', 'kemleang@gmail.com', '2024-06-11 18:57:28', '$2y$12$DZH/qYjhDV9QX2pU4lbWW./pxKfv/gmtzhK1cjGn8XzKY/ah0Kf3C', NULL, 'p3U6ZJYhFBM6KHctvwa6', '2024-06-11 18:57:28', '2024-06-13 19:38:02'),
(6, 'Kos Kourk', 'kourk22@gmail.com', '2024-06-14 18:36:22', '$2y$12$UO24vWkwIVvnsfxJJ.IcxOntx57KwGpX9OG5Lnro5zS2nA9MX4oX6', NULL, 'PqoXSsUkMwYIHXDU3RC5', '2024-06-14 18:36:22', '2024-06-14 18:36:22'),
(7, 'Kos Korek', 'koskorek@gmail.com', '2024-06-15 18:08:29', '$2y$12$b9qjpWCGSNhXWVrXSNcVfOaBROdkUQul5RnjelSBZMJrFgN0aoKge', 4, 'iTbqrjerkq2Eh0oRapT9', '2024-06-15 18:08:29', '2024-06-15 18:14:39');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `comments_user_id_foreign` (`user_id`),
  ADD KEY `comments_post_id_foreign` (`post_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `friend_requests`
--
ALTER TABLE `friend_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `friend_requests_sender_id_foreign` (`sender_id`),
  ADD KEY `friend_requests_receiver_id_foreign` (`receiver_id`);

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `likes_user_id_post_id_react_type_unique` (`user_id`,`post_id`,`react_type`),
  ADD KEY `likes_post_id_foreign` (`post_id`);

--
-- Indexes for table `media`
--
ALTER TABLE `media`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reset_passwords`
--
ALTER TABLE `reset_passwords`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reset_passwords_email_index` (`email`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

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
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `friend_requests`
--
ALTER TABLE `friend_requests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `likes`
--
ALTER TABLE `likes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `media`
--
ALTER TABLE `media`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `reset_passwords`
--
ALTER TABLE `reset_passwords`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_post_id_foreign` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `friend_requests`
--
ALTER TABLE `friend_requests`
  ADD CONSTRAINT `friend_requests_receiver_id_foreign` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `friend_requests_sender_id_foreign` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `likes`
--
ALTER TABLE `likes`
  ADD CONSTRAINT `likes_post_id_foreign` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `likes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
