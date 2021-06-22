CREATE TRIGGER `before_insert_barang` BEFORE INSERT ON `barang`
 FOR EACH ROW SET new.id = uuid();

CREATE TRIGGER `before_insert_gedung` BEFORE INSERT ON `gedung`
 FOR EACH ROW SET new.id = uuid();

CREATE TRIGGER `before_insert_golongan` BEFORE INSERT ON `golongan`
 FOR EACH ROW SET new.id = uuid();

CREATE TRIGGER `before_insert_history` BEFORE INSERT ON `history`
 FOR EACH ROW SET new.history_id = uuid();

CREATE TRIGGER `before_insert_kartu_stok_non_aset` BEFORE INSERT ON `kartu_stok_non_aset`
 FOR EACH ROW SET new.id = uuid();

CREATE TRIGGER `before_insert_kelompok` BEFORE INSERT ON `kelompok`
 FOR EACH ROW SET new.id = uuid();

CREATE TRIGGER `before_insert_ksa_kendaraan` BEFORE INSERT ON `ksa_kendaraan`
 FOR EACH ROW SET new.id = uuid();

CREATE TRIGGER `before_insert_product` BEFORE INSERT ON `product`
 FOR EACH ROW SET new.id = uuid();

CREATE TRIGGER `before_insert_product_kendaraan` BEFORE INSERT ON `product_kendaraan`
 FOR EACH ROW SET new.id = uuid();

CREATE TRIGGER `before_insert_ruangan` BEFORE INSERT ON `ruangan`
 FOR EACH ROW SET new.id = uuid();

CREATE TRIGGER `before_insert_satuan` BEFORE INSERT ON `satuan`
 FOR EACH ROW SET new.id = uuid();

CREATE TRIGGER `before_insert_sub_kelompok` BEFORE INSERT ON `sub_kelompok`
 FOR EACH ROW SET new.id = uuid();

CREATE TRIGGER `before_insert_users` BEFORE INSERT ON `users`
 FOR EACH ROW SET new.user_id = uuid();
