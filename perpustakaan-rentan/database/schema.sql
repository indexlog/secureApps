--  Perpustakaan Mini Online - VERSI RENTAN
-- rentan menyimpan password sebagai PLAINTEXT

DROP DATABASE IF EXISTS perpus_rentan;
CREATE DATABASE perpus_rentan CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE perpus_rentan;

CREATE TABLE users (
    id        INT AUTO_INCREMENT PRIMARY KEY,
    username  VARCHAR(50)  NOT NULL UNIQUE,
    password  VARCHAR(255) NOT NULL,
    role      VARCHAR(20)  NOT NULL DEFAULT 'petugas',
    email     VARCHAR(100) NOT NULL
);

CREATE TABLE books (
    id        INT AUTO_INCREMENT PRIMARY KEY,
    judul     VARCHAR(120) NOT NULL,
    pengarang VARCHAR(80)  NOT NULL,
    tahun     INT          NOT NULL,
    kategori  VARCHAR(40)  NOT NULL
);

CREATE TABLE members (
    id         INT AUTO_INCREMENT PRIMARY KEY,
    nama       VARCHAR(80)  NOT NULL,
    no_anggota VARCHAR(20)  NOT NULL,
    telepon    VARCHAR(20)  NOT NULL,
    alamat     VARCHAR(120) NOT NULL
);

INSERT INTO users (username, password, role, email) VALUES
('admin',   'Adm1n#2025', 'administrator', 'admin@perpus.local'),
('petugas', 'P3tugas!',   'petugas',       'petugas@perpus.local'),
('staff',   'Staff123',   'petugas',       'staff@perpus.local');

INSERT INTO books (judul, pengarang, tahun, kategori) VALUES
('Laskar Pelangi',            'Andrea Hirata',     2005, 'Novel'),
('Bumi Manusia',              'Pramoedya A. Toer', 1980, 'Novel'),
('Algoritma dan Pemrograman', 'Rinaldi Munir',     2016, 'Teknologi'),
('Jaringan Komputer',         'Andrew Tanenbaum',  2011, 'Teknologi'),
('Keamanan Aplikasi Web',     'Dafydd Stuttard',   2011, 'Teknologi'),
('Filosofi Teras',            'Henry Manampiring', 2018, 'Pengembangan Diri'),
('Atomic Habits',             'James Clear',       2018, 'Pengembangan Diri'),
('Sapiens',                   'Yuval N. Harari',   2011, 'Sejarah');

INSERT INTO members (nama, no_anggota, telepon, alamat) VALUES
('Ambar Pratiwi', 'AGT-0001', '081200000001', 'Jl. Melati No.1'),
('Budi Santoso',  'AGT-0002', '081200000002', 'Jl. Mawar No.2'),
('Citra Dewi',    'AGT-0003', '081200000003', 'Jl. Kenanga No.3'),
('Dimas Prayoga', 'AGT-0004', '081200000004', 'Jl. Anggrek No.4');
