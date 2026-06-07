-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 07, 2026 at 12:35 PM
-- Server version: 8.4.3
-- PHP Version: 8.3.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `skripsi_kpi`
--

-- --------------------------------------------------------

--
-- Table structure for table `log_approval`
--

CREATE TABLE `log_approval` (
  `id` bigint UNSIGNED NOT NULL,
  `tugas_id` bigint NOT NULL,
  `pegawai_id` bigint NOT NULL,
  `notes` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `log_approval`
--

INSERT INTO `log_approval` (`id`, `tugas_id`, `pegawai_id`, `notes`, `created_at`, `updated_at`) VALUES
(5, 3, 7, 'Uarain belum Lengkap', '2026-06-07 04:26:41', '2026-06-07 04:26:41'),
(6, 3, 7, 'Mohon Approvalnya', '2026-06-07 04:27:30', '2026-06-07 04:27:30'),
(7, 3, 6, 'Ok Laporan Diterima', '2026-06-07 04:28:42', '2026-06-07 04:28:42');

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
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(3, '2026_06_04_181922_create_m_jabatan_table', 2),
(4, '2026_06_04_182212_create_pegawai_table', 3),
(5, '2026_06_04_182408_create_tugas_table', 4),
(6, '2026_06_04_182939_create_log_approval_table', 5);

-- --------------------------------------------------------

--
-- Table structure for table `m_jabatan`
--

CREATE TABLE `m_jabatan` (
  `id` bigint UNSIGNED NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent_id` bigint DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `m_jabatan`
--

INSERT INTO `m_jabatan` (`id`, `nama`, `deskripsi`, `parent_id`, `created_at`, `updated_at`) VALUES
(1, 'Camat', 'Camat', NULL, '2026-06-04 11:16:30', '2026-06-04 11:16:30'),
(2, 'Sekertaris', 'Sekertaris', 1, '2026-06-04 11:19:20', '2026-06-04 11:19:20'),
(3, 'Staf 1', 'Staf 1', 2, '2026-06-04 11:28:27', '2026-06-04 11:28:27'),
(5, 'Staf 2', 'Staf 2', 2, '2026-06-05 20:53:09', '2026-06-05 20:53:09'),
(6, 'KASI A', 'KASI A', 1, '2026-06-07 04:20:21', '2026-06-07 04:20:21'),
(7, 'Staf Kasi A', 'Staf Kasi A', 6, '2026-06-07 04:20:38', '2026-06-07 04:20:38');

-- --------------------------------------------------------

--
-- Table structure for table `pegawai`
--

CREATE TABLE `pegawai` (
  `id` bigint UNSIGNED NOT NULL,
  `nip` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jk` enum('L','P') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_hp` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jabatan_id` bigint NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pegawai`
--

INSERT INTO `pegawai` (`id`, `nip`, `nama`, `jk`, `alamat`, `no_hp`, `jabatan_id`, `created_at`, `updated_at`) VALUES
(2, '123456789', 'FRANSESKUS DUGIS, SE', 'L', '-', '-', 1, '2026-06-04 17:47:51', '2026-06-04 17:47:51'),
(3, '12345678', 'ADRIANUS JEHAMAT, SH', 'L', '-', '-', 2, '2026-06-04 17:48:31', '2026-06-04 17:48:31'),
(4, '1234567', 'LIDINA BAHUL, AMD', 'P', '-', '-', 3, '2026-06-04 17:49:23', '2026-06-04 18:06:45'),
(5, '1234567', 'Bacondng', 'L', '-', '34567', 5, '2026-06-05 19:33:25', '2026-06-05 20:53:37'),
(6, '12345678', 'Fadli', 'L', '-', '-', 6, '2026-06-07 04:21:53', '2026-06-07 04:21:53'),
(7, '1234567', 'Bento', 'L', '-', '-', 7, '2026-06-07 04:22:22', '2026-06-07 04:22:22');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tugas`
--

CREATE TABLE `tugas` (
  `id` bigint UNSIGNED NOT NULL,
  `judul` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal` date NOT NULL,
  `uraian` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `dokumentasi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('draft','submit','posted','reject') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'draft',
  `pegawai_id` bigint NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tugas`
--

INSERT INTO `tugas` (`id`, `judul`, `tanggal`, `uraian`, `dokumentasi`, `status`, `pegawai_id`, `created_at`, `updated_at`) VALUES
(3, 'Pelayanan Perekaman Data E-KTP', '2026-06-07', '<ol data-start=\"49\" data-end=\"1270\"><li data-section-id=\"1cy8z1s\" data-start=\"49\" data-end=\"184\">Melayani masyarakat yang mengajukan perekaman data <strong data-start=\"103\" data-end=\"146\">Kartu Tanda Penduduk Elektronik (E-KTP)</strong> sesuai dengan ketentuan yang berlaku.\r\n</li>\r\n<li data-section-id=\"1sjzfm7\" data-start=\"185\" data-end=\"257\">\r\nMemeriksa kelengkapan dan keabsahan persyaratan administrasi pemohon.\r\n</li>\r\n<li data-section-id=\"1n4z0pr\" data-start=\"258\" data-end=\"359\">\r\nMelakukan verifikasi dan validasi data kependudukan pemohon pada sistem administrasi kependudukan.\r\n</li>\r\n<li data-section-id=\"14xhcl3\" data-start=\"360\" data-end=\"488\">\r\nMelaksanakan perekaman data biometrik, meliputi foto, tanda tangan, sidik jari, dan iris mata (sesuai prosedur yang berlaku).\r\n</li>\r\n<li data-section-id=\"17qu1fs\" data-start=\"489\" data-end=\"575\">\r\nMengoperasikan dan memelihara perangkat perekaman E-KTP agar berfungsi dengan baik.\r\n</li>\r\n<li data-section-id=\"nuhf0r\" data-start=\"576\" data-end=\"680\">\r\nMemastikan data hasil perekaman tersimpan dan terkirim ke sistem pusat secara akurat dan tepat waktu.\r\n</li>\r\n<li data-section-id=\"nbw5cb\" data-start=\"681\" data-end=\"792\">\r\nMemberikan informasi, arahan, dan konsultasi kepada masyarakat terkait proses pembuatan dan perekaman E-KTP.\r\n</li>\r\n<li data-section-id=\"30z51a\" data-start=\"793\" data-end=\"874\">\r\nMenangani permasalahan atau kendala yang terjadi selama proses perekaman data.\r\n</li>\r\n<li data-section-id=\"1y235p8\" data-start=\"875\" data-end=\"969\">\r\nMenjaga kerahasiaan dan keamanan data pribadi penduduk sesuai peraturan perundang-undangan.\r\n</li>\r\n<li data-section-id=\"136vwaa\" data-start=\"970\" data-end=\"1053\">\r\nMenyusun laporan pelaksanaan perekaman data E-KTP secara berkala kepada atasan.\r\n</li>\r\n<li data-section-id=\"1lilx8k\" data-start=\"1054\" data-end=\"1160\">\r\nBerkoordinasi dengan unit kerja terkait dalam rangka penyelesaian pelayanan administrasi kependudukan.\r\n</li>\r\n<li data-section-id=\"1jzfjo7\" data-start=\"1161\" data-end=\"1270\">\r\nMelaksanakan tugas kedinasan lainnya yang diberikan oleh pimpinan sesuai bidang tugas dan tanggung jawab.\r\n</li>\r\n</ol><p data-start=\"1272\" data-end=\"1288\"><strong data-start=\"1272\" data-end=\"1288\">Hasil Kerja:</strong></p><p>\r\n\r\n</p><ul data-start=\"1289\" data-end=\"1563\" data-is-last-node=\"\" data-is-only-node=\"\">\r\n<li data-section-id=\"14nb5uu\" data-start=\"1289\" data-end=\"1353\">\r\nData penduduk yang telah direkam dan tervalidasi dengan benar.\r\n</li>\r\n<li data-section-id=\"el0ggb\" data-start=\"1354\" data-end=\"1411\">\r\nDokumen administrasi perekaman yang lengkap dan tertib.\r\n</li>\r\n<li data-section-id=\"gvpytr\" data-start=\"1412\" data-end=\"1476\">\r\nLaporan pelayanan perekaman E-KTP yang akurat dan tepat waktu.\r\n</li>\r\n<li data-section-id=\"1ymjo5\" data-start=\"1477\" data-end=\"1563\" data-is-last-node=\"\">\r\nPelayanan administrasi kependudukan yang cepat, tepat, dan sesuai standar pelayanan.</li></ul>', '6a256381cae92.jpg', 'posted', 7, '2026-06-07 04:26:41', '2026-06-07 04:28:42');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `level` enum('admin','pimpinan','pegawai') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pegawai',
  `pegawai_id` bigint DEFAULT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `nama`, `level`, `pegawai_id`, `username`, `password`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin', NULL, 'admin', '$2y$10$1FSthlym3eGYEXgmPcpWne49IXMgRV/sJqDsX30FZGmX.0xv6VzK2', '2026-06-04 10:31:42', '2026-06-04 10:31:42'),
(4, 'FRANSESKUS DUGIS, SE', 'pimpinan', 2, 'camat', '$2y$10$qCzLUOFfjbYLGMHeOGZ00OJzjrk7ZFpWvaxXs6FVbJNDQn97gIGjW', '2026-06-04 22:30:36', '2026-06-04 22:30:36'),
(5, 'ADRIANUS JEHAMAT, SH', 'pimpinan', 3, 'sekertaris', '$2y$10$Y31C8F3u3nRJuKuJqTtule4BdvN/w97osjLjJjXhv3AWIj6xiiH/a', '2026-06-04 22:32:53', '2026-06-04 22:32:53'),
(6, 'LIDINA BAHUL, AMD', 'pegawai', 4, 'staf', '$2y$10$h5tS0yS/ZHfWweQydOVazOiNrA55bpGXOM9j9VPjPWN30OLDaP1Ye', '2026-06-04 22:33:23', '2026-06-04 22:33:23'),
(7, 'Bacondeng', 'pegawai', 5, 'staf1', '$2y$10$Mk5HY.wwIDEg535Rvck.CugN/5OKFCKicnBseE4RaJXtVGo257oWG', '2026-06-05 19:33:48', '2026-06-05 19:33:48'),
(8, 'fadli', 'pimpinan', 6, 'fadli', '$2y$10$nTmCS86CwB5zx7f5joFByuq.O70FL48Dh9tEyjR9tfMtvlIOYlmXC', '2026-06-07 04:23:02', '2026-06-07 04:23:02'),
(9, 'Bento', 'pegawai', 7, 'bento', '$2y$10$OOyzsu/w3//xrpCSFLjD9eoTdKt7Xo3FWlWneG75ZMrESK75LGtum', '2026-06-07 04:23:25', '2026-06-07 04:23:25');

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_log_approval_timeline`
-- (See below for the actual view)
--
CREATE TABLE `v_log_approval_timeline` (
`log_id` bigint unsigned
,`tugas_id` bigint
,`pegawai_id` bigint
,`nama_pegawai` varchar(255)
,`notes` varchar(255)
,`tanggal` date
,`jam` time
,`tanggal_format` varchar(72)
,`jam_format` varchar(10)
,`created_at` timestamp
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_pegawai_bawahan_all`
-- (See below for the actual view)
--
CREATE TABLE `v_pegawai_bawahan_all` (
`pegawai_atasan_id` bigint unsigned
,`nama_atasan` varchar(255)
,`jabatan_atasan_id` bigint unsigned
,`jabatan_atasan` varchar(255)
,`pegawai_bawahan_id` bigint unsigned
,`nama_bawahan` varchar(255)
,`jabatan_bawahan_id` bigint unsigned
,`jabatan_bawahan` varchar(255)
,`level` bigint
);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `log_approval`
--
ALTER TABLE `log_approval`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `m_jabatan`
--
ALTER TABLE `m_jabatan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pegawai`
--
ALTER TABLE `pegawai`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `tugas`
--
ALTER TABLE `tugas`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for table `log_approval`
--
ALTER TABLE `log_approval`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `m_jabatan`
--
ALTER TABLE `m_jabatan`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `pegawai`
--
ALTER TABLE `pegawai`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tugas`
--
ALTER TABLE `tugas`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

-- --------------------------------------------------------

--
-- Structure for view `v_log_approval_timeline`
--
DROP TABLE IF EXISTS `v_log_approval_timeline`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_log_approval_timeline`  AS SELECT `la`.`id` AS `log_id`, `la`.`tugas_id` AS `tugas_id`, `la`.`pegawai_id` AS `pegawai_id`, `p`.`nama` AS `nama_pegawai`, `la`.`notes` AS `notes`, cast(`la`.`created_at` as date) AS `tanggal`, cast(`la`.`created_at` as time) AS `jam`, date_format(`la`.`created_at`,'%d %M %Y') AS `tanggal_format`, date_format(`la`.`created_at`,'%H:%i') AS `jam_format`, `la`.`created_at` AS `created_at` FROM (`log_approval` `la` left join `pegawai` `p` on((`p`.`id` = `la`.`pegawai_id`))) ;

-- --------------------------------------------------------

--
-- Structure for view `v_pegawai_bawahan_all`
--
DROP TABLE IF EXISTS `v_pegawai_bawahan_all`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_pegawai_bawahan_all`  AS WITH recursive   `hirarki_jabatan` as (select `j`.`id` AS `jabatan_atasan_id`,`j`.`nama` AS `jabatan_atasan`,`jb`.`id` AS `jabatan_bawahan_id`,`jb`.`nama` AS `jabatan_bawahan`,1 AS `level` from (`m_jabatan` `j` join `m_jabatan` `jb` on((`jb`.`parent_id` = `j`.`id`))) union all select `hj`.`jabatan_atasan_id` AS `jabatan_atasan_id`,`hj`.`jabatan_atasan` AS `jabatan_atasan`,`jb`.`id` AS `jabatan_bawahan_id`,`jb`.`nama` AS `jabatan_bawahan`,(`hj`.`level` + 1) AS `level` from (`hirarki_jabatan` `hj` join `m_jabatan` `jb` on((`jb`.`parent_id` = `hj`.`jabatan_bawahan_id`)))) select `p_atasan`.`id` AS `pegawai_atasan_id`,`p_atasan`.`nama` AS `nama_atasan`,`hj`.`jabatan_atasan_id` AS `jabatan_atasan_id`,`hj`.`jabatan_atasan` AS `jabatan_atasan`,`p_bawahan`.`id` AS `pegawai_bawahan_id`,`p_bawahan`.`nama` AS `nama_bawahan`,`hj`.`jabatan_bawahan_id` AS `jabatan_bawahan_id`,`hj`.`jabatan_bawahan` AS `jabatan_bawahan`,`hj`.`level` AS `level` from ((`hirarki_jabatan` `hj` join `pegawai` `p_atasan` on((`p_atasan`.`jabatan_id` = `hj`.`jabatan_atasan_id`))) join `pegawai` `p_bawahan` on((`p_bawahan`.`jabatan_id` = `hj`.`jabatan_bawahan_id`)))  ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
