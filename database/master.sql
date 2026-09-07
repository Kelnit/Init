USE sipiter;

DROP VIEW IF EXISTS `tunggujemput`;
DROP VIEW IF EXISTS `roleview`;
DROP TABLE IF EXISTS `dokumen`;
DROP TABLE IF EXISTS `pengantar`;
DROP TABLE IF EXISTS `keluarga`;
DROP TABLE IF EXISTS `sosial`;
DROP TABLE IF EXISTS `patient`;
DROP TABLE IF EXISTS `sessions`;
DROP TABLE IF EXISTS `instansi`;
DROP TABLE IF EXISTS `login_credential`;
DROP TABLE IF EXISTS `staff`;
DROP TABLE IF EXISTS `privileges`;
DROP TABLE IF EXISTS `permissions`;
DROP TABLE IF EXISTS `roles`;
DROP TABLE IF EXISTS `modules`;
DROP TABLE IF EXISTS `wilayah`;

CREATE TABLE `modules` (
  `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `nama` VARCHAR(50) NOT NULL,
  `label` VARCHAR(50) NOT NULL,
  `sorted` TINYINT NOT NULL DEFAULT 0,
  `status` BOOLEAN DEFAULT TRUE,
  `system` BOOLEAN NOT NULL DEFAULT FALSE,
  `created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted` TIMESTAMP NULL DEFAULT NULL
);

CREATE TABLE `roles` (
  `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `nama` VARCHAR(50) NOT NULL,
  `label` VARCHAR(50) NOT NULL,
  `status` BOOLEAN DEFAULT TRUE,
  `system` BOOLEAN NOT NULL DEFAULT FALSE,
  `created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted` TIMESTAMP NULL DEFAULT NULL
);

CREATE TABLE `permissions` (
  `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `moduleKey` INT NOT NULL,
  `nama` VARCHAR(50) NOT NULL,
  `label` VARCHAR(50) NOT NULL,
  `readable` BOOLEAN NOT NULL DEFAULT TRUE,
  `creatable` BOOLEAN NOT NULL DEFAULT TRUE,
  `editable` BOOLEAN NOT NULL DEFAULT TRUE,
  `deletable` BOOLEAN NOT NULL DEFAULT TRUE,
  `created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted` TIMESTAMP NULL DEFAULT NULL,
  UNIQUE KEY `unique_module_nama` (`moduleKey`, `nama`),
  KEY `idx_permissions_moduleKey` (`moduleKey`),
  CONSTRAINT `fk_permissions_module`
    FOREIGN KEY (`moduleKey`) REFERENCES `modules` (`id`)
    ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE `privileges` (
  `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `roleKey` INT NOT NULL,
  `permissionKey` INT NOT NULL,
  `readable` BOOLEAN NOT NULL DEFAULT FALSE,
  `creatable` BOOLEAN NOT NULL DEFAULT FALSE,
  `editable` BOOLEAN NOT NULL DEFAULT FALSE,
  `deletable` BOOLEAN NOT NULL DEFAULT FALSE,
  `status` BOOLEAN NOT NULL DEFAULT TRUE,
  `created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted` TIMESTAMP NULL DEFAULT NULL,
  UNIQUE KEY `unique_role_permission` (`roleKey`, `permissionKey`),
  KEY `idx_privileges_roleKey` (`roleKey`),
  KEY `fk_privileges_permission` (`permissionKey`),
  CONSTRAINT `fk_privileges_role`
    FOREIGN KEY (`roleKey`) REFERENCES `roles` (`id`)
    ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_privileges_permission`
    FOREIGN KEY (`permissionKey`) REFERENCES `permissions` (`id`)
    ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE `staff` (
  `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `kode` VARCHAR(7) NOT NULL,
  `roleKey` INT NOT NULL,
  `nik` VARCHAR(16) NOT NULL,
  `nip` VARCHAR(20) NOT NULL,
  `fullname` VARCHAR(150) NOT NULL,
  `email` VARCHAR(150) NOT NULL,
  `phone` VARCHAR(20) NOT NULL,
  `gender` ENUM('Pria', 'Wanita') NOT NULL,
  `unit` VARCHAR(50) NOT NULL,
  `isactive` BOOLEAN DEFAULT TRUE,
  `created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted` TIMESTAMP NULL DEFAULT NULL,
  UNIQUE KEY `kode` (`kode`),
  UNIQUE KEY `nik` (`nik`),
  UNIQUE KEY `nip` (`nip`),
  UNIQUE KEY `email` (`email`),
  KEY `idx_staff_roleKey` (`roleKey`),
  CONSTRAINT `fk_staff_role`
    FOREIGN KEY (`roleKey`) REFERENCES `roles` (`id`)
    ON DELETE RESTRICT ON UPDATE CASCADE
);

CREATE TABLE `login_credential` (
  `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `userKey` VARCHAR(7) NOT NULL,
  `nik` VARCHAR(16) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `roleKey` INT NOT NULL,
  `isactive` BOOLEAN DEFAULT TRUE,
  `last_login` TIMESTAMP NULL DEFAULT NULL,
  `created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  UNIQUE KEY `nik` (`nik`),
  UNIQUE KEY `userKey` (`userKey`),
  KEY `idx_login_credential_roleKey` (`roleKey`),
  CONSTRAINT `fk_login_credential_role`
    FOREIGN KEY (`roleKey`) REFERENCES `roles` (`id`)
    ON DELETE RESTRICT ON UPDATE CASCADE
);

CREATE TABLE `instansi` (
  `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `roleKey` INT DEFAULT NULL,
  `nama` VARCHAR(100) NOT NULL,
  `singkatan` VARCHAR(20) NOT NULL,
  `alamat` TEXT,
  `status` BOOLEAN DEFAULT TRUE,
  `created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted` TIMESTAMP NULL DEFAULT NULL,
  UNIQUE KEY `singkatan` (`singkatan`),
  KEY `idx_instansi_roleKey` (`roleKey`),
  CONSTRAINT `fk_instansi_role`
    FOREIGN KEY (`roleKey`) REFERENCES `roles` (`id`)
    ON DELETE SET NULL ON UPDATE CASCADE
);

CREATE TABLE `patient` (
  `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `kode` VARCHAR(7) NOT NULL,
  `mrn` VARCHAR(9) NOT NULL DEFAULT '00000000',
  `nik` VARCHAR(16) NOT NULL DEFAULT '0000000000000000',
  `fullname` VARCHAR(150) NOT NULL,
  `dob` DATE DEFAULT NULL,
  `gender` ENUM('Pria', 'Wanita') NOT NULL,
  `alamat` TEXT,
  `kelurahan` VARCHAR(100) DEFAULT NULL,
  `kecamatan` VARCHAR(100) DEFAULT NULL,
  `kota` VARCHAR(100) DEFAULT NULL,
  `agama` VARCHAR(20) DEFAULT NULL,
  `usia` VARCHAR(20) DEFAULT NULL,
  `datang` ENUM('Diantar', 'Sendiri') DEFAULT NULL,
  `kondisi` ENUM('Hidup', 'Meninggal') DEFAULT NULL,
  `lokasi` VARCHAR(75) NOT NULL DEFAULT 'Instalasi Gawat Darurat',
  `isactive` BOOLEAN DEFAULT TRUE,
  `created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted` TIMESTAMP NULL DEFAULT NULL,
  UNIQUE KEY `kode` (`kode`)
);

CREATE TABLE `sosial` (
  `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `patientKey` VARCHAR(7) NOT NULL,
  `regisdate` DATE DEFAULT NULL,
  `selesai` BOOLEAN DEFAULT FALSE,
  `tglselesai` DATE DEFAULT NULL,
  `tgljemput` DATE DEFAULT NULL,
  `jamjemput` TIME DEFAULT NULL,
  `penjemput` VARCHAR(50) NULL,
  `telephone` VARCHAR(13) NULL,
  `dijemput` BOOLEAN DEFAULT FALSE,
  `identity` BOOLEAN NOT NULL DEFAULT FALSE,
  `keluarga` BOOLEAN NOT NULL DEFAULT FALSE,
  `created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  UNIQUE KEY `patientKey` (`patientKey`),
  CONSTRAINT `fk_sosial_patient`
    FOREIGN KEY (`patientKey`) REFERENCES `patient` (`kode`)
);

CREATE TABLE `keluarga` (
  `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `patientKey` VARCHAR(7) NOT NULL,
  `nama` VARCHAR(150) DEFAULT NULL,
  `hubungan` ENUM('Ayah', 'Ibu', 'Saudara Kandung', 'Kakek', 'Nenek', 'Lain') DEFAULT NULL,
  `telephone` VARCHAR(20) DEFAULT NULL,
  `alamat` TEXT,
  `created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  UNIQUE KEY `patientKey` (`patientKey`),
  CONSTRAINT `fk_keluarga_patient`
    FOREIGN KEY (`patientKey`) REFERENCES `patient` (`kode`)
);

CREATE TABLE `pengantar` (
  `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `patientKey` VARCHAR(7) DEFAULT NULL,
  `nama` VARCHAR(150) NOT NULL,
  `telephone` VARCHAR(20) NOT NULL,
  `lokasi` TEXT,
  `created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  KEY `idx_pengantar_patientKey` (`patientKey`),
  CONSTRAINT `fk_pengantar_patient`
    FOREIGN KEY (`patientKey`) REFERENCES `patient` (`kode`)
);

CREATE TABLE `dokumen` (
  `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `patientKey` VARCHAR(7) NOT NULL,
  `instansi_asal_key` INT NOT NULL,
  `instansi_tujuan_key` INT NOT NULL,
  `jenis_surat` VARCHAR(150) DEFAULT NULL,
  `nomor_surat` VARCHAR(100) DEFAULT NULL,
  `tanggal_surat` DATE DEFAULT NULL,
  `file_url` TEXT,
  `status` ENUM('Draft', 'Terkirim', 'Diterima', 'Ditolak') NOT NULL DEFAULT 'Draft',
  `created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  KEY `idx_dokumen_patientKey` (`patientKey`),
  KEY `idx_dokumen_instansiAsalKey` (`instansi_asal_key`),
  KEY `idx_dokumen_instansiTujuanKey` (`instansi_tujuan_key`),
  CONSTRAINT `fk_dokumen_patient`
    FOREIGN KEY (`patientKey`) REFERENCES `patient` (`kode`),
  CONSTRAINT `fk_dokumen_instansi_asal`
    FOREIGN KEY (`instansi_asal_key`) REFERENCES `instansi` (`id`),
  CONSTRAINT `fk_dokumen_instansi_tujuan`
    FOREIGN KEY (`instansi_tujuan_key`) REFERENCES `instansi` (`id`)
);

CREATE TABLE `sessions` (
  `id` VARCHAR(128) NOT NULL PRIMARY KEY,
  `ip_address` VARCHAR(45) NOT NULL,
  `timestamp` INT UNSIGNED NOT NULL DEFAULT 0,
  `data` BLOB NOT NULL,
  KEY `ci_sessions_timestamp` (`timestamp`)
);

CREATE TABLE `wilayah` (
  `kode` VARCHAR(13) NOT NULL,
  `nama` VARCHAR(100) NOT NULL,
  `induk_kode` VARCHAR(13) DEFAULT NULL,
  `tingkat` TINYINT UNSIGNED NOT NULL,
  PRIMARY KEY (`kode`),
  KEY `idx_induk_kode` (`induk_kode`),
  KEY `idx_tingkat` (`tingkat`),
  CONSTRAINT `fk_wilayah_induk`
    FOREIGN KEY (`induk_kode`) REFERENCES `wilayah` (`kode`)
    ON DELETE CASCADE
);

CREATE OR REPLACE VIEW `roleview` AS
  SELECT
    `privileges`.`id` AS `privilege_id`,
    `privileges`.`roleKey` AS `role_id`,
    `privileges`.`permissionKey` AS `permission_id`,
    `privileges`.`readable` AS `readable`,
    `privileges`.`creatable` AS `creatable`,
    `privileges`.`editable` AS `editable`,
    `privileges`.`deletable` AS `deletable`,
    `privileges`.`status` AS `privilege_status`,
    `permissions`.`nama` AS `permission_nama`,
    `permissions`.`label` AS `permission_label`,
    `permissions`.`moduleKey` AS `module_id`
  FROM `privileges`
  JOIN `permissions` ON `permissions`.`id` = `privileges`.`permissionKey`
  WHERE `privileges`.`status` = 1
    AND `privileges`.`deleted` IS NULL
    AND `permissions`.`deleted` IS NULL;

CREATE OR REPLACE VIEW `tunggujemput` AS
  SELECT
    s.patientKey,
    p.fullname,
    s.tglselesai,
    DATEDIFF(NOW(), s.tglselesai) AS lama
  FROM sosial s
  JOIN patient p ON p.kode = s.patientKey
  WHERE s.dijemput = FALSE
    AND s.tglselesai IS NOT NULL
  ORDER BY lama DESC;