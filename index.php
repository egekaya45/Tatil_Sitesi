<?php
session_start();
$active_page = 'home';
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TatilCenneti — Hayalinizdeki Tatili Bulun</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php include 'header.php'; ?>

<!-- HERO -->
<section class="hero">
    <div class="container hero-container">
        <!-- Sol: Başlık + Arama -->
        <div class="hero-content">
            <h2>Hayalinizdeki Tatili<br>Keşfedin</h2>
            <p>En güzel destinasyonlar, lüks oteller ve uygun fiyatlı paketler TatilCenneti'nde!</p>
            <div style="background:white;border-radius:14px;padding:16px 20px;margin-top:28px;box-shadow:0 8px 32px rgba(0,0,0,0.18);">
                <form action="hotels.php" method="GET">
                    <div style="display:grid;grid-template-columns:minmax(0,1.4fr) minmax(0,1fr) minmax(0,1fr) minmax(0,0.85fr) auto;gap:8px;align-items:end;">
                        <div style="display:flex;flex-direction:column;min-width:0;">
                            <span style="font-size:10px;font-weight:700;color:#6b7280;text-transform:uppercase;letter-spacing:0.07em;margin-bottom:5px;white-space:nowrap;">Nereye?</span>
                            <input type="text" name="destination" placeholder="Şehir veya ülke" style="padding:9px 10px;border:1.5px solid #e5e7eb;border-radius:8px;font-size:13px;font-family:inherit;outline:none;color:#1a1a2e;min-width:0;width:100%;box-sizing:border-box;">
                        </div>
                        <div style="display:flex;flex-direction:column;min-width:0;">
                            <span style="font-size:10px;font-weight:700;color:#6b7280;text-transform:uppercase;letter-spacing:0.07em;margin-bottom:5px;white-space:nowrap;">Giriş Tarihi</span>
                            <input type="date" name="check_in" id="check_in" style="padding:9px 6px;border:1.5px solid #e5e7eb;border-radius:8px;font-size:12px;font-family:inherit;outline:none;color:#1a1a2e;min-width:0;width:100%;box-sizing:border-box;">
                        </div>
                        <div style="display:flex;flex-direction:column;min-width:0;">
                            <span style="font-size:10px;font-weight:700;color:#6b7280;text-transform:uppercase;letter-spacing:0.07em;margin-bottom:5px;white-space:nowrap;">Çıkış Tarihi</span>
                            <input type="date" name="check_out" id="check_out" style="padding:9px 6px;border:1.5px solid #e5e7eb;border-radius:8px;font-size:12px;font-family:inherit;outline:none;color:#1a1a2e;min-width:0;width:100%;box-sizing:border-box;">
                        </div>
                        <div style="display:flex;flex-direction:column;min-width:0;">
                            <span style="font-size:10px;font-weight:700;color:#6b7280;text-transform:uppercase;letter-spacing:0.07em;margin-bottom:5px;white-space:nowrap;">Kişi Sayısı</span>
                            <select name="guests" style="padding:9px 6px;border:1.5px solid #e5e7eb;border-radius:8px;font-size:13px;font-family:inherit;outline:none;color:#1a1a2e;background:white;min-width:0;width:100%;box-sizing:border-box;">
                                <option value="1">1 Kişi</option>
                                <option value="2" selected>2 Kişi</option>
                                <option value="3">3 Kişi</option>
                                <option value="4">4 Kişi</option>
                                <option value="5">5+ Kişi</option>
                            </select>
                        </div>
                        <button type="submit" style="background:#1a6b8a;color:white;border:none;border-radius:8px;padding:0 28px;font-size:14px;font-weight:600;font-family:inherit;cursor:pointer;height:40px;white-space:nowrap;align-self:end;">Ara</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Sağ: Stats kartı -->
        <div class="hero-visual">
            <div class="hero-stat-card">
                <div class="hero-stat-badge">✈️ Bu Yaz Nereye?</div>
                <h3>Türkiye'nin En İyi<br>Tatil Destinasyonları</h3>
                <div class="hero-stats">
                    <div class="hero-stat-item">
                        <span class="stat-num" data-target="500">0</span><span class="stat-plus">+</span>
                        <div class="stat-label">Otel</div>
                    </div>
                    <div class="hero-stat-item">
                        <span class="stat-num" data-target="50">0</span><span class="stat-plus">+</span>
                        <div class="stat-label">Destinasyon</div>
                    </div>
                    <div class="hero-stat-item">
                        <span class="stat-num" data-target="99">0</span><span class="stat-plus">%</span>
                        <div class="stat-label">Memnuniyet</div>
                    </div>
                </div>
                <div class="hero-tags">
                    <span>🏖️ Deniz</span>
                    <span>🏔️ Doğa</span>
                    <span>🏛️ Kültür</span>
                    <span>💆 Termal</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- POPÜlER DESTİNASYONLAR -->
<section class="popular-destinations">
    <div class="container">
        <h2 class="section-title">Popüler Destinasyonlar</h2>
        <p class="section-subtitle">Türkiye'nin en çok tercih edilen tatil noktaları</p>
        <div class="destinations-grid">
            <div class="destination-card">
                <img src="hotel1.jpg" alt="Antalya">
                <div class="destination-info">
                    <h3>Antalya</h3>
                    <p>Turkuaz denizi ve muhteşem plajlarıyla</p>
                    <a href="destinations.php" class="btn btn-sm">Keşfet</a>
                </div>
            </div>
            <div class="destination-card">
                <img src="hotel2.jpg" alt="Bodrum">
                <div class="destination-info">
                    <h3>Bodrum</h3>
                    <p>Eğlence ve lüksün buluştuğu cennet</p>
                    <a href="destinations.php" class="btn btn-sm">Keşfet</a>
                </div>
            </div>
            <div class="destination-card">
                <img src="hotel3.jpg" alt="Kapadokya">
                <div class="destination-info">
                    <h3>Kapadokya</h3>
                    <p>Eşsiz doğal güzellikleri ve peri bacalarıyla</p>
                    <a href="destinations.php" class="btn btn-sm">Keşfet</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ÖZEL FIRSATLAR -->
<section class="special-offers">
    <div class="container">
        <h2 class="section-title">Özel Fırsatlar</h2>
        <p class="section-subtitle">Sınırlı süreli kampanyaları kaçırmayın</p>
        <div class="offers-grid">
            <div class="offer-card">
                <div class="offer-badge">%25 İndirim</div>
                <h3>Yaz Tatili Erken Rezervasyon</h3>
                <p>Erken rezervasyon yapın, %25'e varan indirimlerden yararlanın. Tüm 5 yıldızlı otellerde geçerlidir.</p>
                <a href="hotels.php" class="btn btn-primary">Hemen Rezervasyon Yap</a>
            </div>
            <div class="offer-card">
                <div class="offer-badge">Özel Paket</div>
                <h3>Balayı Paketleri</h3>
                <p>Unutulmaz bir balayı için özel hazırlanmış lüks paketler. Çift kişilik oda, kahvaltı ve spa dahil.</p>
                <a href="hotels.php" class="btn btn-primary">Paketi İncele</a>
            </div>
        </div>
    </div>
</section>

<!-- MÜŞTERİ YORUMLARI -->
<section class="testimonials">
    <div class="container">
        <h2 class="section-title">Müşteri Yorumları</h2>
        <p class="section-subtitle" style="color:rgba(255,255,255,0.6);">Binlerce mutlu müşterimizden bazıları</p>
        <div class="testimonials-slider">
            <div class="testimonial">
                <div class="testimonial-content">
                    <p>TatilCenneti sayesinde harika bir tatil geçirdik. Rezervasyon süreci çok kolaydı ve her şey sorunsuz ilerledi.</p>
                </div>
                <div class="testimonial-author">
                    <h4>Ahmet Yılmaz</h4>
                    <p>Antalya Tatili</p>
                </div>
            </div>
            <div class="testimonial">
                <div class="testimonial-content">
                    <p>Fiyat/performans açısından mükemmel. Sunulan hizmet beklentilerimizin çok üzerindeydi. Kesinlikle tekrar tercih edeceğiz.</p>
                </div>
                <div class="testimonial-author">
                    <h4>Ayşe Kaya</h4>
                    <p>Bodrum Tatili</p>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'footer.php'; ?>

<script src="script.js"></script>
</body>
</html>