<?php
session_start();
$active_page = 'hotels';
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Oteller — TatilCenneti</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php include 'header.php'; ?>

<section class="page-header">
    <div class="container">
        <h1>Oteller</h1>
        <p>Konforlu ve unutulmaz konaklama için en iyi oteller</p>
    </div>
</section>

<section class="hotels-section">
    <div class="container">
        <div class="filter-container">
            <div class="search-box">
                <input type="text" id="hotel-search" placeholder="Otel ara...">
            </div>
            <div class="filter-options">
                <select id="filter-location">
                    <option value="">Tüm Lokasyonlar</option>
                    <option value="antalya">Antalya</option>
                    <option value="bodrum">Bodrum</option>
                    <option value="kapadokya">Kapadokya</option>
                </select>
                <select id="filter-stars">
                    <option value="">Tüm Yıldızlar</option>
                    <option value="5">5 Yıldız</option>
                    <option value="4">4 Yıldız</option>
                </select>
            </div>
        </div>

        <div class="hotels-grid">
            <div class="hotel-card" data-location="antalya" data-stars="5">
                <div class="hotel-image">
                    <img src="hotel1.jpg" alt="Luxury Resort Antalya">
                    <div class="hotel-rating">5.0</div>
                </div>
                <div class="hotel-info">
                    <h3>Luxury Resort Antalya</h3>
                    <div class="hotel-location">📍 Antalya, Türkiye</div>
                    <div class="hotel-stars">★★★★★</div>
                    <p>Denize sıfır konumu ve lüks hizmetleriyle mükemmel bir tatil deneyimi</p>
                    <div class="hotel-price">
                        <span class="price">₺2.500</span>
                        <span class="per-night">/ gece</span>
                    </div>
                    <a href="#" class="btn btn-primary">Rezervasyon Yap</a>
                </div>
            </div>

            <div class="hotel-card" data-location="bodrum" data-stars="5">
                <div class="hotel-image">
                    <img src="hotel2.jpg" alt="Bodrum Palace Hotel">
                    <div class="hotel-rating">4.8</div>
                </div>
                <div class="hotel-info">
                    <h3>Bodrum Palace Hotel</h3>
                    <div class="hotel-location">📍 Bodrum, Türkiye</div>
                    <div class="hotel-stars">★★★★★</div>
                    <p>Özel plajı ve muhteşem manzarasıyla Bodrum'un incisi</p>
                    <div class="hotel-price">
                        <span class="price">₺3.200</span>
                        <span class="per-night">/ gece</span>
                    </div>
                    <a href="#" class="btn btn-primary">Rezervasyon Yap</a>
                </div>
            </div>

            <div class="hotel-card" data-location="kapadokya" data-stars="4">
                <div class="hotel-image">
                    <img src="hotel3.jpg" alt="Kapadokya Cave Suites">
                    <div class="hotel-rating">4.7</div>
                </div>
                <div class="hotel-info">
                    <h3>Kapadokya Cave Suites</h3>
                    <div class="hotel-location">📍 Kapadokya, Türkiye</div>
                    <div class="hotel-stars">★★★★☆</div>
                    <p>Otantik mağara odaları ve eşsiz Kapadokya manzarası</p>
                    <div class="hotel-price">
                        <span class="price">₺1.800</span>
                        <span class="per-night">/ gece</span>
                    </div>
                    <a href="#" class="btn btn-primary">Rezervasyon Yap</a>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'footer.php'; ?>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const searchInput     = document.getElementById('hotel-search');
    const locationFilter  = document.getElementById('filter-location');
    const starsFilter     = document.getElementById('filter-stars');
    const cards           = document.querySelectorAll('.hotel-card');

    function filterHotels() {
        const term     = searchInput.value.toLowerCase();
        const location = locationFilter.value;
        const stars    = starsFilter.value;

        cards.forEach(card => {
            const title         = card.querySelector('h3').textContent.toLowerCase();
            const matchSearch   = title.includes(term);
            const matchLocation = !location || card.dataset.location === location;
            const matchStars    = !stars    || card.dataset.stars    === stars;

            card.style.display = (matchSearch && matchLocation && matchStars) ? '' : 'none';
        });
    }

    searchInput.addEventListener('input', filterHotels);
    locationFilter.addEventListener('change', filterHotels);
    starsFilter.addEventListener('change', filterHotels);
});
</script>

</body>
</html>