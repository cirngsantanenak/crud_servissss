CREATE DATABASE if not exists servis_komputer;

USE servis_komputer;

CREATE TABLE if not exists servis (
    id INT AUTO_INCREMENT PRIMARY KEY,
    no_nota VARCHAR(20),
    nama_pelanggan VARCHAR(100),
    biaya INT,
    keluhan TEXT,
    status_servis ENUM('Proses', 'Selesai'),
    jenis_perangkat VARCHAR(30)
);
CREATE TABLE if not exists pelanggan (
    id_pelanggan INT AUTO_INCREMENT PRIMARY KEY,
    nama_pelanggan VARCHAR(100),
    gambar VARCHAR(255)
);

INSERT INTO servis(no_nota, nama_pelanggan, biaya, keluhan, status_servis, jenis_perangkat)VALUES
('15','Jemes','990000','jelek jaringannya','selesai','jaringan'),
('18','Udin','2000000','kerusakan di kamera','proses','laptop'),
('10','Diki','690000','lemot','selesai','pc desktop'),
('13', 'Cinta','1800000','printernya gampang panas','proses','printer');