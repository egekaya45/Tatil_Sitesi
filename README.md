# 🏖️ TatilCenneti — Tatil Rezervasyon Web Sitesi

PHP, MySQL, CSS ve JavaScript ile geliştirilmiş tam kapsamlı bir tatil rezervasyon web sitesi.

---

## 📸 Ekran Görüntüleri

> Ana sayfa, otel listeleme, giriş/kayıt ve profil sayfaları içerir.

---

## 🚀 Özellikler

- 🔐 Kullanıcı kaydı ve girişi (şifre hash'leme ile güvenli)
- 🏨 Otel listeleme ve filtreleme (lokasyon, yıldız sayısı)
- 📍 Destinasyon listeleme ve filtreleme (bölge, tatil tipi)
- 📅 Rezervasyon ve ödeme modülü (kredi kartı formu)
- 👤 Kullanıcı profil sayfası (bilgi güncelleme, şifre değiştirme)
- 🛡️ Admin paneli (kullanıcı, otel, rezervasyon istatistikleri)
- 📱 Mobil uyumlu (responsive) tasarım
- 📩 İletişim formu

---

## 🛠️ Kullanılan Teknolojiler

| Katman | Teknoloji |
|--------|-----------|
| Backend | PHP 8.x |
| Veritabanı | MySQL (phpMyAdmin) |
| Frontend | HTML5, CSS3, JavaScript |
| Sunucu | Apache (XAMPP / MAMP) |

---

## ⚙️ Kurulum

### Gereksinimler
- XAMPP veya MAMP (Apache + MySQL + PHP)
- Web tarayıcısı

### Adımlar

**1. Projeyi klonla veya indir:**
```bash
git clone https://github.com/egekaya45/Tatil_Sitesi.git
```

**2. Klasörü htdocs'a taşı:**
```
C:\xampp\htdocs\tatil-sitesi\
```

**3. XAMPP'ı başlat** (Apache + MySQL)

**4. Veritabanını oluştur:**
- `http://localhost/phpmyadmin` adresine git
- **İçe Aktar** → `SQL_Ege_Tatil_Projesi.sql` dosyasını seç → Çalıştır

**5. Siteyi aç:**
```
http://localhost/tatil-sitesi
```

---

## 🗄️ Veritabanı Yapısı

| Tablo | Açıklama |
|-------|----------|
| `users` | Kullanıcı bilgileri ve rolleri |
| `hotels` | Otel bilgileri ve fiyatları |
| `destinations` | Tatil destinasyonları |
| `reservations` | Rezervasyon kayıtları |
| `payments` | Ödeme bilgileri |
| `reviews` | Kullanıcı yorumları |

---

## 🔑 Test Giriş Bilgileri

| Rol | E-posta | Şifre |
|-----|---------|-------|
| Admin | admin@tatilcenneti.com | admin |
| Kullanıcı | test@example.com | admin |

---

## 👨‍💻 Geliştirici

**Sefer Ege Kaya**
- GitHub: [@egekaya45](https://github.com/egekaya45)
- Üniversite: İzmir Ekonomi Üniversitesi — Bilgisayar Programcılığı

---

## 📄 Lisans

Bu proje eğitim amaçlı geliştirilmiştir.