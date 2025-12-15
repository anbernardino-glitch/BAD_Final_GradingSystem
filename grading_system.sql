-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 15, 2025 at 10:04 AM
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
-- Database: `grading_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `user_id`, `name`, `email`, `created_at`, `updated_at`) VALUES
(2, 39, 'admin', 'admin@gmail.com', '2025-12-05 07:19:43', '2025-12-05 07:19:43');

-- --------------------------------------------------------

--
-- Table structure for table `audit_logs`
--

CREATE TABLE `audit_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `action` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `grade_id` bigint(20) UNSIGNED DEFAULT NULL,
  `student_id` bigint(20) UNSIGNED DEFAULT NULL,
  `subject_id` bigint(20) UNSIGNED DEFAULT NULL,
  `term` varchar(255) DEFAULT NULL,
  `old_values` longtext DEFAULT NULL,
  `new_values` longtext DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `audit_logs`
--

INSERT INTO `audit_logs` (`id`, `action`, `user_id`, `grade_id`, `student_id`, `subject_id`, `term`, `old_values`, `new_values`, `created_at`, `updated_at`) VALUES
(1, 'deleted', 39, NULL, 3, 30, NULL, '{\"id\":1,\"student_id\":3,\"subject_id\":30,\"quiz\":\"[\\\"89.00\\\"]\",\"project\":\"[\\\"89\\\"]\",\"exam\":\"[\\\"89.00\\\"]\",\"final\":\"89.00\",\"status\":\"locked\",\"revision_reason\":null,\"created_at\":\"2025-12-03T14:19:58.000000Z\",\"updated_at\":\"2025-12-05T15:10:33.000000Z\"}', NULL, '2025-12-05 07:35:54', '2025-12-05 07:35:54'),
(2, 'deleted', 39, 2, 4, 30, NULL, '{\"id\":2,\"student_id\":4,\"subject_id\":30,\"quiz\":\"[\\\"88.00\\\"]\",\"project\":\"[\\\"88.00\\\"]\",\"exam\":\"[\\\"88.00\\\"]\",\"final\":88,\"status\":\"locked\",\"revision_reason\":null,\"created_at\":\"2025-12-03T14:19:58.000000Z\",\"updated_at\":\"2025-12-05T15:10:33.000000Z\",\"deleted_at\":null}', NULL, '2025-12-05 07:46:50', '2025-12-05 07:46:50');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `user_id`, `name`, `email`, `created_at`, `updated_at`) VALUES
(2, 38, 'department', 'department@gmail.com', '2025-12-04 07:59:44', '2025-12-04 07:59:44');

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
-- Table structure for table `grades`
--

CREATE TABLE `grades` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `subject_id` bigint(20) UNSIGNED NOT NULL,
  `term` varchar(50) NOT NULL,
  `quiz` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`quiz`)),
  `project` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`project`)),
  `exam` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`exam`)),
  `final` decimal(5,2) DEFAULT 0.00,
  `status` enum('submitted','approved','locked','revision_requested') NOT NULL,
  `justification` varchar(255) DEFAULT NULL,
  `revision_reason` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `grades`
--

INSERT INTO `grades` (`id`, `student_id`, `subject_id`, `term`, `quiz`, `project`, `exam`, `final`, `status`, `justification`, `revision_reason`, `created_at`, `updated_at`, `deleted_at`) VALUES
(2, 4, 30, '', '\"[\\\"88.00\\\"]\"', '\"[\\\"88.00\\\"]\"', '\"[\\\"88.00\\\"]\"', 88.00, 'locked', NULL, NULL, '2025-12-03 06:19:58', '2025-12-05 07:46:50', '2025-12-05 07:46:50'),
(5, 4, 34, '1st Term', '\"[\\\"99\\\"]\"', '\"[\\\"99\\\"]\"', '\"[\\\"99\\\"]\"', 99.00, 'locked', NULL, NULL, '2025-12-14 05:50:36', '2025-12-14 06:57:17', NULL),
(6, 2, 34, '1st Term', '\"[\\\"99\\\"]\"', '\"[\\\"99\\\"]\"', '\"[\\\"99\\\"]\"', 99.00, 'locked', 'ffff', NULL, '2025-12-14 05:50:36', '2025-12-14 06:57:17', NULL),
(7, 6, 34, '1st Term', '\"[\\\"99\\\"]\"', '\"[\\\"99\\\"]\"', '\"[\\\"99\\\"]\"', 99.00, 'locked', 'because', NULL, '2025-12-14 05:50:36', '2025-12-14 06:57:17', NULL),
(8, 7, 34, '1st Term', '\"[\\\"88\\\"]\"', '\"[\\\"88\\\"]\"', '\"[\\\"88\\\"]\"', 88.00, 'locked', NULL, NULL, '2025-12-14 05:50:36', '2025-12-14 06:57:17', NULL),
(9, 2, 33, '1st Term', '\"[\\\"78\\\"]\"', '\"[\\\"88\\\"]\"', '\"[\\\"89\\\"]\"', 85.40, 'submitted', NULL, NULL, '2025-12-15 00:58:38', '2025-12-15 00:58:38', NULL),
(10, 4, 33, '1st Term', '\"[\\\"89\\\"]\"', '\"[\\\"88\\\"]\"', '\"[\\\"88\\\"]\"', 88.30, 'submitted', NULL, NULL, '2025-12-15 00:58:38', '2025-12-15 00:58:38', NULL),
(11, 6, 33, '1st Term', '\"[\\\"99\\\"]\"', '\"[\\\"99\\\"]\"', '\"[\\\"87\\\"]\"', 94.20, 'submitted', NULL, NULL, '2025-12-15 00:58:38', '2025-12-15 00:58:38', NULL),
(12, 7, 33, '1st Term', '\"[\\\"88\\\"]\"', '\"[\\\"89\\\"]\"', '\"[\\\"76\\\"]\"', 83.50, 'submitted', NULL, NULL, '2025-12-15 00:58:38', '2025-12-15 00:58:38', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `grade_reviews`
--

CREATE TABLE `grade_reviews` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `grade_id` bigint(20) UNSIGNED NOT NULL,
  `department_id` bigint(20) UNSIGNED NOT NULL,
  `status` enum('pending','approved','revision_requested') NOT NULL DEFAULT 'pending',
  `remarks` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
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
-- Table structure for table `job_batches`
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
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_11_30_133720_create_students_table', 1),
(5, '2025_11_30_134033_create_users_table', 2),
(6, '2025_11_30_134047_create_subjects_table', 2),
(7, '2025_11_30_134054_create_grades_table', 2),
(8, '2025_11_30_134100_create_audit_logs_table', 2),
(9, '2025_11_30_134247_create_grade_components_table', 2),
(10, '2025_11_30_134528_create_terms_table', 2),
(11, '2025_11_30_140548_add_role_to_users_table', 2),
(13, '2025_12_01_090420_create_enrollments_table', 2),
(14, '2025_12_01_101022_add_fields_to_users_table', 3),
(15, '2025_12_01_105118_add_teacher_id_to_subjects_table', 4),
(16, '2025_12_01_110842_create_subject_student_table', 5),
(17, '2025_12_01_133232_add_role_to_users_table', 6),
(18, '2025_12_01_090314_create_teachers_table', 7),
(19, '2025_12_02_073720_add_grade_to_student_subject_table', 8),
(20, '2025_12_02_121027_fix_teacher_foreign_key_on_subjects_table', 9),
(21, '2025_12_02_122639_create_grades_table', 10),
(22, '2025_12_03_141353_create_grades_table', 11),
(23, '2025_12_03_142914_create_departments_table', 12),
(24, '2025_12_03_143053_add_department_id_to_subjects', 13),
(25, '2025_12_03_143053_add_department_id_to_teachers', 13),
(26, '2025_12_04_150645_create_registrars_table', 14),
(27, '2025_12_04_152229_create_admins_table', 15),
(28, '2025_12_04_152347_create_admins_table', 16),
(29, '2025_12_04_152945_create_admins_table', 17),
(30, '2025_12_04_155610_add_user_id_to_departments_table', 18),
(31, '2025_12_05_154131_add_deleted_at_to_grades_table', 19),
(32, '2025_12_14_144014_add_justification_to_grades_table', 20),
(33, '2025_12_14_144508_update_status_enum_in_grades_table', 21);

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
-- Table structure for table `registrars`
--

CREATE TABLE `registrars` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `registrars`
--

INSERT INTO `registrars` (`id`, `user_id`, `name`, `email`, `created_at`, `updated_at`) VALUES
(1, 32, 'registar', 'registar@gmail.com', '2025-12-04 07:13:00', '2025-12-04 07:13:00');

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

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('5t886EB3tvecqAiy7MI7Qfc8WVZED6GjAc1POxlo', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoicjA1TjFVeFNWaG9ZNmQ3dGRCTW9OYjhNS2thNE5QYm5xOU4wVldjVyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzg6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbi9kZXBhcnRtZW50IjtzOjU6InJvdXRlIjtzOjEwOiJsb2dpbi5mb3JtIjt9fQ==', 1765789139);

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `student_number` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `user_id`, `name`, `student_number`, `created_at`, `updated_at`, `email`) VALUES
(2, 23, 'angel2', '12345666', '2025-12-02 04:02:20', '2025-12-02 04:02:20', NULL),
(3, 25, 'male', '1234555', '2025-12-03 05:34:22', '2025-12-03 05:34:22', NULL),
(4, 26, 'female', '1234444', '2025-12-03 05:42:05', '2025-12-03 05:42:05', NULL),
(6, 42, 'eva', '2314456', '2025-12-12 01:38:31', '2025-12-12 01:38:31', NULL),
(7, 43, 'jazz', '0325089', '2025-12-14 05:34:55', '2025-12-14 05:34:55', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `student_subject`
--

CREATE TABLE `student_subject` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `subject_id` bigint(20) UNSIGNED NOT NULL,
  `grade` varchar(10) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student_subject`
--

INSERT INTO `student_subject` (`id`, `student_id`, `subject_id`, `grade`, `created_at`, `updated_at`) VALUES
(6, 3, 30, NULL, NULL, NULL),
(7, 4, 30, NULL, NULL, NULL),
(13, 4, 33, NULL, NULL, NULL),
(14, 4, 34, NULL, NULL, NULL),
(16, 2, 33, NULL, NULL, NULL),
(17, 2, 34, NULL, NULL, NULL),
(18, 6, 30, NULL, NULL, NULL),
(19, 6, 33, NULL, NULL, NULL),
(20, 6, 34, NULL, NULL, NULL),
(21, 7, 30, NULL, NULL, NULL),
(22, 7, 34, NULL, NULL, NULL),
(23, 7, 33, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `teacher_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `department_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`id`, `name`, `teacher_id`, `created_at`, `updated_at`, `department_id`) VALUES
(30, 'Science', 3, '2025-12-03 05:29:06', '2025-12-03 05:29:06', NULL),
(33, 'Mathematics', 3, '2025-12-14 05:30:30', '2025-12-14 05:30:30', NULL),
(34, 'English', 3, '2025-12-14 05:30:39', '2025-12-14 05:30:39', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `teachers`
--

CREATE TABLE `teachers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `department` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `department_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `teachers`
--

INSERT INTO `teachers` (`id`, `user_id`, `name`, `email`, `department`, `created_at`, `updated_at`, `department_id`) VALUES
(2, 20, 'Justin2', 'justin2@gmail.com', 'Science', '2025-12-02 03:46:42', '2025-12-02 03:46:42', NULL),
(3, 24, 'Anji', 'anji@gmail.com', 'Filipino', '2025-12-03 04:58:59', '2025-12-03 04:58:59', NULL),
(4, 30, 'apir', 'apir@gmail.com', 'maths', '2025-12-04 06:33:44', '2025-12-04 06:33:44', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `terms`
--

CREATE TABLE `terms` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'student',
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `role`, `password`, `created_at`, `updated_at`) VALUES
(19, 'Justin1', 'justin1@gmail.com', 'teacher', '$2y$12$Z9RiPufTg7IoDNHKkhPl2OTz6RWsgedpJvpjjmUw090WavQJp6h9S', '2025-12-02 03:35:48', '2025-12-02 03:35:48'),
(20, 'Justin2', 'justin2@gmail.com', 'teacher', '$2y$12$uSFoYPuYLoUWQTSRuKrNUuqLnX/VddE7Qv9i/yOsCcYS4RjuBC5Di', '2025-12-02 03:46:42', '2025-12-02 03:46:42'),
(23, 'angel2', 'angel2@gmail.com', 'student', '$2y$12$ccR9QrMJla2Mzm0exfj/yuYo9DLyT7KgKEuCAjui6CawWujR4VOPq', '2025-12-02 04:02:20', '2025-12-02 04:02:20'),
(24, 'Anji', 'anji@gmail.com', 'teacher', '$2y$12$yKuyZeBh3dCk9ZQBHtA2iOTQMRVtp2dsIg.E7HdwB/YcKSWfvb1iq', '2025-12-03 04:58:59', '2025-12-03 04:58:59'),
(25, 'male', 'male@gmail.com', 'student', '$2y$12$.hiDR8I3tRs9e.nYz4zWP.M2DgIzRuZ93VxIZTOmUZSSVXWdH923G', '2025-12-03 05:34:22', '2025-12-03 05:34:22'),
(26, 'female', 'female@gmail.com', 'student', '$2y$12$KKSDL9zSh1VOnm1vwDAjc.5GBQBWs68Ij42sWVNpgbpSg.b1HTSDS', '2025-12-03 05:42:05', '2025-12-03 05:42:05'),
(27, 'Alice Department', 'alice@school.com', 'department_head', '$2y$12$8tRyDPgMiu1wNQbmIenufuEvgry2973YRPdpYhM/dNZgf2gSC9Aly', '2025-12-03 06:44:51', '2025-12-03 06:44:51'),
(28, 'Bob Registrar', 'bob@school.com', 'registrar', '$2y$12$tnw1A5WVXniKuStOw20a7eI8HIdbjGyE4gkVlrbC1Y7sbATbfFnWO', '2025-12-03 06:44:51', '2025-12-03 06:44:51'),
(29, 'Charlie Admin', 'charlie@school.com', 'administrator', '$2y$12$80xNd6gDJAFm.CgS/vD8..hyTgKFLhA1gJf08oazNsSBd60EIshQG', '2025-12-03 06:44:52', '2025-12-03 06:44:52'),
(30, 'apir', 'apir@gmail.com', 'teacher', '$2y$12$CdfZjCbRRAU2NYPFvXpRF.Sx.xvPY4TG2Z1g0lUK7v3x6sneZ10LK', '2025-12-04 06:33:44', '2025-12-04 06:33:44'),
(31, 'regist', 'regist@gmail.com', 'registrar', '$2y$12$C/py.GD1k4bqNFM4VUVHYOExWbi98fRkkpXG5CQ1LBW2dUvXmq4Ce', '2025-12-04 07:06:12', '2025-12-04 07:06:12'),
(32, 'registar', 'registar@gmail.com', 'registrar', '$2y$12$jmYOdfwd5gNUmMqLxqO4wuwBXE9pvCGAsdZb.Xj7h34R4eyxwJTzG', '2025-12-04 07:13:00', '2025-12-04 07:13:00'),
(37, 'depts', 'deptss@gmail.com', 'department', '$2y$12$dH6w.r/nP6Yn4ml7lBPNnedN9zgDwLnWmcijI7Vf4kKQw78nwvcya', '2025-12-04 07:57:32', '2025-12-04 07:57:32'),
(38, 'department', 'department@gmail.com', 'department', '$2y$12$yr46LG9m0myUIVJC3bak9e2H8XJPtTIHMbPZZiT8ePJoABkyq4X36', '2025-12-04 07:59:44', '2025-12-04 07:59:44'),
(39, 'admin', 'admin@gmail.com', 'admin', '$2y$12$Aeifh9UUMy6ZkF.vVd87Au/5FHK.K1PGgxBJPzz6iqs7AUgdLhNgW', '2025-12-05 07:19:43', '2025-12-05 07:19:43'),
(42, 'eva', 'eva@gmail.com', 'student', '$2y$12$ymrBvgObkrRc50E.Cczlp.ClCo1.hJjgxV1/Fe/dGvf1VWn.H0RKW', '2025-12-12 01:38:31', '2025-12-12 01:38:31'),
(43, 'jazz', 'jazz@gmail.com', 'student', '$2y$12$uMPwqijxpgFl2Sg1zDtHJeZOZJU4HmIh/kNWvY7xiVOfRVEFlaWgG', '2025-12-14 05:34:55', '2025-12-14 05:34:55');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admins_email_unique` (`email`),
  ADD KEY `admins_user_id_foreign` (`user_id`);

--
-- Indexes for table `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_audit_user` (`user_id`),
  ADD KEY `fk_audit_grade` (`grade_id`),
  ADD KEY `fk_audit_student` (`student_id`),
  ADD KEY `fk_audit_subject` (`subject_id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `departments_user_id_foreign` (`user_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `grades`
--
ALTER TABLE `grades`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_grade` (`student_id`,`subject_id`,`term`),
  ADD KEY `fk_grades_subject` (`subject_id`);

--
-- Indexes for table `grade_reviews`
--
ALTER TABLE `grade_reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `grade_id` (`grade_id`),
  ADD KEY `department_id` (`department_id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

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
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `registrars`
--
ALTER TABLE `registrars`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `registrars_email_unique` (`email`),
  ADD KEY `registrars_user_id_foreign` (`user_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `students_student_number_unique` (`student_number`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `fk_students_user` (`user_id`);

--
-- Indexes for table `student_subject`
--
ALTER TABLE `student_subject`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_student` (`student_id`),
  ADD KEY `fk_subject` (`subject_id`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subjects_teacher_id_foreign` (`teacher_id`),
  ADD KEY `subjects_department_id_foreign` (`department_id`);

--
-- Indexes for table `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `teachers_user_id_foreign` (`user_id`),
  ADD KEY `teachers_department_id_foreign` (`department_id`);

--
-- Indexes for table `terms`
--
ALTER TABLE `terms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `audit_logs`
--
ALTER TABLE `audit_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `grades`
--
ALTER TABLE `grades`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `grade_reviews`
--
ALTER TABLE `grade_reviews`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `registrars`
--
ALTER TABLE `registrars`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `student_subject`
--
ALTER TABLE `student_subject`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `teachers`
--
ALTER TABLE `teachers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `terms`
--
ALTER TABLE `terms`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admins`
--
ALTER TABLE `admins`
  ADD CONSTRAINT `admins_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD CONSTRAINT `fk_audit_grade` FOREIGN KEY (`grade_id`) REFERENCES `grades` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_audit_student` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_audit_subject` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_audit_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `departments`
--
ALTER TABLE `departments`
  ADD CONSTRAINT `departments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `grades`
--
ALTER TABLE `grades`
  ADD CONSTRAINT `fk_grades_student` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_grades_subject` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `grade_reviews`
--
ALTER TABLE `grade_reviews`
  ADD CONSTRAINT `grade_reviews_ibfk_1` FOREIGN KEY (`grade_id`) REFERENCES `grades` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `grade_reviews_ibfk_2` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `registrars`
--
ALTER TABLE `registrars`
  ADD CONSTRAINT `registrars_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `fk_students_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `student_subject`
--
ALTER TABLE `student_subject`
  ADD CONSTRAINT `fk_student` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_subject` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `subjects`
--
ALTER TABLE `subjects`
  ADD CONSTRAINT `fk_subjects_teacher` FOREIGN KEY (`teacher_id`) REFERENCES `teachers` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `subjects_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `subjects_teacher_id_foreign` FOREIGN KEY (`teacher_id`) REFERENCES `teachers` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `teachers`
--
ALTER TABLE `teachers`
  ADD CONSTRAINT `teachers_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `teachers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
