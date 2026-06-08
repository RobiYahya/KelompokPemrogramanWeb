-- ============================================================
  -- Buat & pilih database secara otomatis
  -- ============================================================
  CREATE DATABASE IF NOT EXISTS `magura_db`
    DEFAULT CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

  USE `magura_db`;

  SET FOREIGN_KEY_CHECKS = 0;

  -- Tabel aplikasi
  DROP TABLE IF EXISTS `histori_aktivitas`;
  DROP TABLE IF EXISTS `barang_masuk`;
  DROP TABLE IF EXISTS `barang_keluar`;
  DROP TABLE IF EXISTS `barang`;
  DROP TABLE IF EXISTS `supplier`;
  DROP TABLE IF EXISTS `kategori`;
  DROP TABLE IF EXISTS `users`;

  SET FOREIGN_KEY_CHECKS = 1;

  -- --------------------------------------------------------
  -- 1. Tabel Users
  -- --------------------------------------------------------
  CREATE TABLE `users` (
    `id_user` bigint unsigned NOT NULL AUTO_INCREMENT,
    `nama` varchar(50) NOT NULL,
    `email` varchar(50) NOT NULL,
    `email_verified_at` timestamp NULL DEFAULT NULL,
    `id_pegawai` varchar(50) DEFAULT NULL,
    `role` varchar(50) DEFAULT 'admin',
    `password` varchar(255) NOT NULL,
    `remember_token` varchar(100) DEFAULT NULL,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL,
    PRIMARY KEY (`id_user`),
    UNIQUE KEY `users_email_unique` (`email`),
    UNIQUE KEY `users_id_pegawai_unique` (`id_pegawai`)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

  -- --------------------------------------------------------
  -- 2. Tabel Kategori
  -- --------------------------------------------------------
  CREATE TABLE `kategori` (
    `id_kategori` bigint unsigned NOT NULL AUTO_INCREMENT,
    `nama_kategori` varchar(50) NOT NULL,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL,
    PRIMARY KEY (`id_kategori`)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

  -- --------------------------------------------------------
  -- 3. Tabel Supplier
  -- --------------------------------------------------------
  CREATE TABLE `supplier` (
    `id_supplier` bigint unsigned NOT NULL AUTO_INCREMENT,
    `nama_supplier` varchar(50) NOT NULL,
    `divisi` varchar(50) DEFAULT NULL,
    `kontak` varchar(50) DEFAULT NULL,
    `no_telp` varchar(20) DEFAULT NULL,
    `alamat` varchar(250) DEFAULT NULL,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL,
    PRIMARY KEY (`id_supplier`)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

  -- --------------------------------------------------------
  -- 4. Tabel Barang
  -- --------------------------------------------------------
  CREATE TABLE `barang` (
    `id_barang` bigint unsigned NOT NULL AUTO_INCREMENT,
    `nama_barang` varchar(50) NOT NULL,
    `id_kategori` bigint unsigned DEFAULT NULL,
    `id_supplier` bigint unsigned DEFAULT NULL,
    `stok` int unsigned NOT NULL DEFAULT 0,
    `min_stok` int unsigned NOT NULL DEFAULT 10,
    `harga` decimal(10,2) NOT NULL DEFAULT 0.00,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL,
    `deleted_at` timestamp NULL DEFAULT NULL,
    PRIMARY KEY (`id_barang`),
    KEY `barang_id_kategori_foreign` (`id_kategori`),
    KEY `barang_id_supplier_foreign` (`id_supplier`),
    CONSTRAINT `barang_id_kategori_foreign` FOREIGN KEY (`id_kategori`) REFERENCES `kategori` (`id_kategori`) ON DELETE SET NULL,
    CONSTRAINT `barang_id_supplier_foreign` FOREIGN KEY (`id_supplier`) REFERENCES `supplier` (`id_supplier`) ON DELETE SET NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

  -- --------------------------------------------------------
  -- 5. Tabel Barang Masuk
  -- --------------------------------------------------------
  CREATE TABLE `barang_masuk` (
    `id_masuk` bigint unsigned NOT NULL AUTO_INCREMENT,
    `id_barang` bigint unsigned NOT NULL,
    `id_user` bigint unsigned DEFAULT NULL,
    `jumlah` int unsigned NOT NULL,
    `tanggal` date NOT NULL,
    `deskripsi` varchar(50) DEFAULT NULL,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL,
    PRIMARY KEY (`id_masuk`),
    KEY `barang_masuk_id_barang_foreign` (`id_barang`),
    KEY `barang_masuk_id_user_foreign` (`id_user`),
    KEY `barang_masuk_tanggal_index` (`tanggal`),
    CONSTRAINT `barang_masuk_id_barang_foreign` FOREIGN KEY (`id_barang`) REFERENCES `barang` (`id_barang`) ON DELETE CASCADE,
    CONSTRAINT `barang_masuk_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE SET NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

  -- --------------------------------------------------------
  -- 6. Tabel Barang Keluar
  -- --------------------------------------------------------
  CREATE TABLE `barang_keluar` (
    `id_keluar` bigint unsigned NOT NULL AUTO_INCREMENT,
    `id_barang` bigint unsigned NOT NULL,
    `id_user` bigint unsigned DEFAULT NULL,
    `jumlah` int unsigned NOT NULL,
    `tanggal` date NOT NULL,
    `deskripsi` varchar(50) DEFAULT NULL,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL,
    PRIMARY KEY (`id_keluar`),
    KEY `barang_keluar_id_barang_foreign` (`id_barang`),
    KEY `barang_keluar_id_user_foreign` (`id_user`),
    KEY `barang_keluar_tanggal_index` (`tanggal`),
    CONSTRAINT `barang_keluar_id_barang_foreign` FOREIGN KEY (`id_barang`) REFERENCES `barang` (`id_barang`) ON DELETE CASCADE,
    CONSTRAINT `barang_keluar_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE SET NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

  -- --------------------------------------------------------
  -- 7. Tabel Histori Aktivitas
  -- --------------------------------------------------------
  CREATE TABLE `histori_aktivitas` (
    `id_histori` bigint unsigned NOT NULL AUTO_INCREMENT,
    `id_user` bigint unsigned DEFAULT NULL,
    `aksi` varchar(50) NOT NULL,
    `id_kategori` bigint unsigned DEFAULT NULL,
    `nama_barang` varchar(50) DEFAULT NULL,
    `deskripsi` text NOT NULL,
    `tanggal` timestamp NULL DEFAULT NULL,
    PRIMARY KEY (`id_histori`),
    KEY `histori_aktivitas_id_user_foreign` (`id_user`),
    KEY `histori_aktivitas_tanggal_index` (`tanggal`),
    CONSTRAINT `histori_aktivitas_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE SET NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

  -- --------------------------------------------------------
  -- SEED DATA AWAL
  -- --------------------------------------------------------
  INSERT INTO `users` (`id_user`, `nama`, `email`, `email_verified_at`, `id_pegawai`, `role`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
  (1, 'Super Admin', 'superadmin@Magura.com', NULL, 'SUP001', 'super_admin', '$2y$12$tuVWe2JpPmhuxct6SYiGN.dJQceIUoLJhK5ohA5QtiKlVq9epaRoa', NULL, NOW(), NOW()),
  (2, 'Shofi', 'shofi@Magura.com', NULL, 'ADM001', 'admin', '$2y$12$tuVWe2JpPmhuxct6SYiGN.dJQceIUoLJhK5ohA5QtiKlVq9epaRoa', NULL, NOW(), NOW()),
  (3, 'Cahya', 'cahya@Magura.com', NULL, 'ADM002', 'admin', '$2y$12$tuVWe2JpPmhuxct6SYiGN.dJQceIUoLJhK5ohA5QtiKlVq9epaRoa', NULL, NOW(), NOW()),
  (4, 'Robi', 'robi@Magura.com', NULL, 'MGR001', 'manager', '$2y$12$tuVWe2JpPmhuxct6SYiGN.dJQceIUoLJhK5ohA5QtiKlVq9epaRoa', NULL, NOW(), NOW());