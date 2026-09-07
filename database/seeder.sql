USE sipiter;

INSERT INTO `modules` (`id`, `nama`, `label`, `sorted`, `status`, `system`) VALUES (1, 'Hub', 'hub', 1, 1, 0);
INSERT INTO `modules` (`id`, `nama`, `label`, `sorted`, `status`, `system`) VALUES (2, 'RSUP Dr. M. Djamil Padang', 'rsup', 1, 1, 0);
INSERT INTO `modules` (`id`, `nama`, `label`, `sorted`, `status`, `system`) VALUES (3, 'Dinas Kependudukan dan Pencatatan Sipil', 'sipil', 1, 1, 0);
INSERT INTO `modules` (`id`, `nama`, `label`, `sorted`, `status`, `system`) VALUES (4, 'Dinas Sosial', 'sosial', 1, 1, 0);
INSERT INTO `modules` (`id`, `nama`, `label`, `sorted`, `status`, `system`) VALUES (5, 'Badan Amil Zakat Nasional', 'baznas', 1, 1, 0);
INSERT INTO `modules` (`id`, `nama`, `label`, `sorted`, `status`, `system`) VALUES (6, 'Badan Penyelenggara Jaminan Sosial', 'bpjs', 1, 1, 0);
INSERT INTO `modules` (`id`, `nama`, `label`, `sorted`, `status`, `system`) VALUES (7, 'Profile', 'profile', 0, 1, 0);
INSERT INTO `modules` (`id`, `nama`, `label`, `sorted`, `status`, `system`) VALUES (8, 'User', 'user', 0, 1, 0);

INSERT INTO `roles` (`id`, `nama`, `label`, `status`, `system`) VALUES (1, 'Super Admin', 'superadmin', 1, 1);
INSERT INTO `roles` (`id`, `nama`, `label`, `status`, `system`) VALUES (2, 'RSUP Dr. M. Djamil Padang', 'rsup', 1, 1);
INSERT INTO `roles` (`id`, `nama`, `label`, `status`, `system`) VALUES (3, 'Dinas Kependudukan dan Pencatatan Sipil', 'sipil', 1, 1);
INSERT INTO `roles` (`id`, `nama`, `label`, `status`, `system`) VALUES (4, 'Dinas Sosial', 'sosial', 1, 1);
INSERT INTO `roles` (`id`, `nama`, `label`, `status`, `system`) VALUES (5, 'Badan Amil Zakat Nasional', 'baznas', 1, 1);
INSERT INTO `roles` (`id`, `nama`, `label`, `status`, `system`) VALUES (6, 'Badan Penyelenggara Jaminan Sosial', 'bpjs', 1, 1);

INSERT INTO `permissions` (`id`, `moduleKey`, `nama`, `label`, `readable`, `creatable`, `editable`, `deletable`) VALUES (1, 1, 'Hub', 'hub', 1, 0, 0, 0);
INSERT INTO `permissions` (`id`, `moduleKey`, `nama`, `label`, `readable`, `creatable`, `editable`, `deletable`) VALUES (2, 2, 'RSUP Dr. M. Djamil Padang', 'rsup', 1, 1, 1, 1);
INSERT INTO `permissions` (`id`, `moduleKey`, `nama`, `label`, `readable`, `creatable`, `editable`, `deletable`) VALUES (3, 3, 'Dinas Kependudukan dan Pencatatan Sipil', 'sipil', 1, 1, 1, 1);
INSERT INTO `permissions` (`id`, `moduleKey`, `nama`, `label`, `readable`, `creatable`, `editable`, `deletable`) VALUES (4, 4, 'Dinas Sosial', 'sosial', 1, 1, 1, 1);
INSERT INTO `permissions` (`id`, `moduleKey`, `nama`, `label`, `readable`, `creatable`, `editable`, `deletable`) VALUES (5, 5, 'Badan Amil Zakat Nasional', 'baznas', 1, 1, 1, 1);
INSERT INTO `permissions` (`id`, `moduleKey`, `nama`, `label`, `readable`, `creatable`, `editable`, `deletable`) VALUES (6, 6, 'Badan Penyelenggara Jaminan Sosial', 'bpjs', 1, 1, 1, 1);
INSERT INTO `permissions` (`id`, `moduleKey`, `nama`, `label`, `readable`, `creatable`, `editable`, `deletable`) VALUES (7, 7, 'Profile', 'profile', 1, 1, 1, 1);
INSERT INTO `permissions` (`id`, `moduleKey`, `nama`, `label`, `readable`, `creatable`, `editable`, `deletable`) VALUES (8, 8, 'User', 'user', 1, 1, 1, 1);

INSERT INTO `privileges` (`id`, `roleKey`, `permissionKey`, `readable`, `creatable`, `editable`, `deletable`, `status`) VALUES (1, 2, 1, 1, 1, 1, 1, 1);
INSERT INTO `privileges` (`id`, `roleKey`, `permissionKey`, `readable`, `creatable`, `editable`, `deletable`, `status`) VALUES (2, 2, 2, 1, 1, 1, 1, 1);
INSERT INTO `privileges` (`id`, `roleKey`, `permissionKey`, `readable`, `creatable`, `editable`, `deletable`, `status`) VALUES (3, 2, 3, 1, 1, 1, 1, 1);
INSERT INTO `privileges` (`id`, `roleKey`, `permissionKey`, `readable`, `creatable`, `editable`, `deletable`, `status`) VALUES (4, 2, 4, 1, 1, 1, 1, 1);
INSERT INTO `privileges` (`id`, `roleKey`, `permissionKey`, `readable`, `creatable`, `editable`, `deletable`, `status`) VALUES (5, 2, 5, 1, 1, 1, 1, 1);
INSERT INTO `privileges` (`id`, `roleKey`, `permissionKey`, `readable`, `creatable`, `editable`, `deletable`, `status`) VALUES (6, 2, 6, 1, 1, 1, 1, 1);
INSERT INTO `privileges` (`id`, `roleKey`, `permissionKey`, `readable`, `creatable`, `editable`, `deletable`, `status`) VALUES (7, 2, 7, 1, 1, 1, 1, 1);
INSERT INTO `privileges` (`id`, `roleKey`, `permissionKey`, `readable`, `creatable`, `editable`, `deletable`, `status`) VALUES (8, 3, 1, 1, 0, 0, 0, 1);
INSERT INTO `privileges` (`id`, `roleKey`, `permissionKey`, `readable`, `creatable`, `editable`, `deletable`, `status`) VALUES (9, 3, 3, 1, 1, 1, 1, 1);
INSERT INTO `privileges` (`id`, `roleKey`, `permissionKey`, `readable`, `creatable`, `editable`, `deletable`, `status`) VALUES (10, 3, 7, 1, 1, 1, 1, 1);
INSERT INTO `privileges` (`id`, `roleKey`, `permissionKey`, `readable`, `creatable`, `editable`, `deletable`, `status`) VALUES (11, 4, 1, 1, 0, 0, 0, 1);
INSERT INTO `privileges` (`id`, `roleKey`, `permissionKey`, `readable`, `creatable`, `editable`, `deletable`, `status`) VALUES (12, 4, 4, 1, 1, 1, 1, 1);
INSERT INTO `privileges` (`id`, `roleKey`, `permissionKey`, `readable`, `creatable`, `editable`, `deletable`, `status`) VALUES (13, 4, 7, 1, 1, 1, 1, 1);
INSERT INTO `privileges` (`id`, `roleKey`, `permissionKey`, `readable`, `creatable`, `editable`, `deletable`, `status`) VALUES (14, 5, 1, 1, 0, 0, 0, 1);
INSERT INTO `privileges` (`id`, `roleKey`, `permissionKey`, `readable`, `creatable`, `editable`, `deletable`, `status`) VALUES (15, 5, 5, 1, 1, 1, 1, 1);
INSERT INTO `privileges` (`id`, `roleKey`, `permissionKey`, `readable`, `creatable`, `editable`, `deletable`, `status`) VALUES (16, 5, 7, 1, 1, 1, 1, 1);
INSERT INTO `privileges` (`id`, `roleKey`, `permissionKey`, `readable`, `creatable`, `editable`, `deletable`, `status`) VALUES (17, 6, 1, 1, 0, 0, 0, 1);
INSERT INTO `privileges` (`id`, `roleKey`, `permissionKey`, `readable`, `creatable`, `editable`, `deletable`, `status`) VALUES (18, 6, 6, 1, 1, 1, 1, 1);
INSERT INTO `privileges` (`id`, `roleKey`, `permissionKey`, `readable`, `creatable`, `editable`, `deletable`, `status`) VALUES (19, 6, 7, 1, 1, 1, 1, 1);

INSERT INTO `instansi` (`id`, `roleKey`, `nama`, `singkatan`, `alamat`, `status`) VALUES (1, 2, 'RSUP Dr. M. Djamil Padang', 'Djamil', NULL, 1);
INSERT INTO `instansi` (`id`, `roleKey`, `nama`, `singkatan`, `alamat`, `status`) VALUES (2, 3, 'Dinas Kependudukan dan Pencatatan Sipil', 'Dukcapil', NULL, 1);
INSERT INTO `instansi` (`id`, `roleKey`, `nama`, `singkatan`, `alamat`, `status`) VALUES (3, 4, 'Dinas Sosial', 'Dinsos', NULL, 1);
INSERT INTO `instansi` (`id`, `roleKey`, `nama`, `singkatan`, `alamat`, `status`) VALUES (4, 5, 'Badan Amil Zakat Nasional', 'Baznas', NULL, 1);
INSERT INTO `instansi` (`id`, `roleKey`, `nama`, `singkatan`, `alamat`, `status`) VALUES (5, 6, 'Badan Penyelenggara Jaminan Sosial', 'BPJS', NULL, 1);