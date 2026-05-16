-- ============================================
-- TatilCenneti — MySQL Veritabanı
-- XAMPP / MAMP için (PHP ile birebir uyumlu)
-- ============================================

CREATE DATABASE IF NOT EXISTS tatil_db
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_turkish_ci;

USE tatil_db;

-- Eski tabloları temizle (sıra önemli!)
SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS payments;
DROP TABLE IF EXISTS reviews;
DROP TABLE IF EXISTS reservations;
DROP TABLE IF EXISTS hotels;
DROP TABLE IF EXISTS destinations;
DROP TABLE IF EXISTS users;
SET FOREIGN_KEY_CHECKS = 1;

-- ============================================
-- 1. KULLANICILAR
-- ============================================
CREATE TABLE users (
    id         INT AUTO_INCREMENT PRIMARY KEY,
    name       VARCHAR(100) NOT NULL,
    email      VARCHAR(100) NOT NULL UNIQUE,
    password   VARCHAR(255) NOT NULL,
    phone      VARCHAR(20)  DEFAULT NULL,
    address    TEXT         DEFAULT NULL,
    role       VARCHAR(20)  NOT NULL DEFAULT 'user',
    created_at DATETIME     NOT NULL DEFAULT NOW(),
    updated_at DATETIME     DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

-- ============================================
-- 2. OTELLER
-- ============================================
CREATE TABLE hotels (
    id              INT AUTO_INCREMENT PRIMARY KEY,
    name            VARCHAR(255)  NOT NULL,
    description     TEXT          DEFAULT NULL,
    location        VARCHAR(255)  NOT NULL,
    address         VARCHAR(255)  DEFAULT NULL,
    image           VARCHAR(255)  DEFAULT 'hotel1.jpg',
    rating          DECIMAL(3,1)  NOT NULL DEFAULT 0.0,
    price_per_night DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    stars           TINYINT       NOT NULL DEFAULT 3,
    created_at      DATETIME      NOT NULL DEFAULT NOW()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

-- ============================================
-- 3. DESTİNASYONLAR
-- ============================================
CREATE TABLE destinations (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    name        VARCHAR(255) NOT NULL,
    description TEXT         DEFAULT NULL,
    region      VARCHAR(100) DEFAULT NULL,
    type        VARCHAR(100) DEFAULT NULL,
    image       VARCHAR(255) DEFAULT 'hotel1.jpg',
    popularity  INT          NOT NULL DEFAULT 0,
    created_at  DATETIME     NOT NULL DEFAULT NOW()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

-- ============================================
-- 4. REZERVASYONLAR
-- ============================================
CREATE TABLE reservations (
    id             INT AUTO_INCREMENT PRIMARY KEY,
    user_id        INT           NOT NULL,
    hotel_id       INT           NOT NULL,
    check_in_date  DATE          NOT NULL,
    check_out_date DATE          NOT NULL,
    guests         TINYINT       NOT NULL DEFAULT 1,
    room_type      VARCHAR(100)  NOT NULL DEFAULT 'Standart',
    total_price    DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    payment_method VARCHAR(50)   NOT NULL DEFAULT 'credit_card',
    status         VARCHAR(20)   NOT NULL DEFAULT 'pending',
    created_at     DATETIME      NOT NULL DEFAULT NOW(),
    CONSTRAINT fk_res_user  FOREIGN KEY (user_id)  REFERENCES users(id)  ON DELETE CASCADE,
    CONSTRAINT fk_res_hotel FOREIGN KEY (hotel_id) REFERENCES hotels(id) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

-- ============================================
-- 5. ÖDEMELER
-- ============================================
CREATE TABLE payments (
    id             INT AUTO_INCREMENT PRIMARY KEY,
    reservation_id INT           NOT NULL,
    amount         DECIMAL(10,2) NOT NULL,
    payment_method VARCHAR(50)   NOT NULL DEFAULT 'credit_card',
    card_last_four VARCHAR(4)    DEFAULT NULL,
    status         VARCHAR(20)   NOT NULL DEFAULT 'completed',
    created_at     DATETIME      NOT NULL DEFAULT NOW(),
    CONSTRAINT fk_pay_res FOREIGN KEY (reservation_id) REFERENCES reservations(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

-- ============================================
-- 6. YORUMLAR
-- ============================================
CREATE TABLE reviews (
    id         INT AUTO_INCREMENT PRIMARY KEY,
    user_id    INT      NOT NULL,
    hotel_id   INT      NOT NULL,
    rating     TINYINT  NOT NULL DEFAULT 5,
    comment    TEXT     DEFAULT NULL,
    created_at DATETIME NOT NULL DEFAULT NOW(),
    CONSTRAINT chk_rating   CHECK (rating BETWEEN 1 AND 5),
    CONSTRAINT fk_rev_user  FOREIGN KEY (user_id)  REFERENCES users(id)  ON DELETE CASCADE,
    CONSTRAINT fk_rev_hotel FOREIGN KEY (hotel_id) REFERENCES hotels(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

-- ============================================
-- ÖRNEK VERİLER
-- ============================================

-- Admin (şifre: admin)
INSERT INTO users (name, email, password, phone, role) VALUES
('Admin', 'admin@tatilcenneti.com',
 '$2y$10$GnW8eiPopTE3aOzv6NhDL.fHZ0MEjbPVBsI5Og/lzt.GbSZD18Wby',
 '0544 767 78 38', 'admin');

-- Test kullanıcısı (şifre: admin)
INSERT INTO users (name, email, password, role) VALUES
('Ahmet Yılmaz', 'test@example.com',
 '$2y$10$GnW8eiPopTE3aOzv6NhDL.fHZ0MEjbPVBsI5Og/lzt.GbSZD18Wby',
 'user');

-- Oteller
INSERT INTO hotels (name, description, location, address, image, rating, price_per_night, stars) VALUES
('Luxury Resort Antalya',
 'Denize sıfır konumu ve lüks hizmetleriyle mükemmel bir tatil deneyimi.',
 'Antalya', 'Lara Caddesi No:1, Antalya', 'hotel1.jpg', 5.0, 2500.00, 5),
('Bodrum Palace Hotel',
 'Özel plajı ve muhteşem manzarasıyla Bodrum\'un incisi.',
 'Bodrum', 'Gümbet Mah. No:12, Bodrum', 'hotel2.jpg', 4.8, 3200.00, 5),
('Kapadokya Cave Suites',
 'Otantik mağara odaları ve eşsiz Kapadokya manzarası.',
 'Kapadokya', 'Göreme Mah. No:5, Nevşehir', 'hotel3.jpg', 4.7, 1800.00, 4);

-- Destinasyonlar
INSERT INTO destinations (name, description, region, type, image, popularity) VALUES
('Antalya',   'Turkuaz denizi ve muhteşem plajlarıyla',    'akdeniz',    'deniz',  'hotel1.jpg', 100),
('Bodrum',    'Eğlence ve lüksün buluştuğu cennet',         'ege',        'deniz',  'hotel2.jpg', 90),
('Kapadokya', 'Eşsiz doğal güzellikleri ve peri bacaları', 'ic-anadolu', 'kultur', 'hotel3.jpg', 85);

-- ============================================
-- GİRİŞ BİLGİLERİ
-- Admin:      admin@tatilcenneti.com / admin
-- Kullanıcı: test@example.com       / admin
-- ============================================
