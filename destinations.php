<?php
session_start();
$active_page = 'destinations';
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Destinasyonlar — TatilCenneti</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php include 'header.php'; ?>

<section class="page-header">
    <div class="container">
        <h1>Destinasyonlar</h1>
        <p>Hayalinizdeki tatil için en popüler destinasyonları keşfedin</p>
    </div>
</section>

<section class="destinations-section">
    <div class="container">
        <div class="filter-container">
            <div class="search-box">
                <input type="text" id="dest-search" placeholder="Destinasyon ara...">
            </div>
            <div class="filter-options">
                <select id="filter-region">
                    <option value="">Tüm Bölgeler</option>
                    <option value="akdeniz">Akdeniz</option>
                    <option value="ege">Ege</option>
                    <option value="ic-anadolu">İç Anadolu</option>
                    <option value="marmara">Marmara</option>
                    <option value="karadeniz">Karadeniz</option>
                </select>
                <select id="filter-type">
                    <option value="">Tüm Tatil Tipleri</option>
                    <option value="deniz">Deniz Tatili</option>
                    <option value="kultur">Kültür Turu</option>
                    <option value="doga">Doğa Tatili</option>
                </select>
            </div>
        </div>

        <div class="destinations-grid">
            <div class="destination-card" data-region="akdeniz" data-type="deniz">
                <img src="hotel1.jpg" alt="Antalya">
                <div class="destination-info">
                    <h3>Antalya</h3>
                    <p>Turkuaz denizi ve muhteşem plajlarıyla</p>
                    <div class="destination-meta">
                        <span class="region">Akdeniz</span>
                        <span class="type">Deniz Tatili</span>
                    </div>
                    <a href="hotels.php" class="btn btn-sm">Otelleri Gör</a>
                </div>
            </div>

            <div class="destination-card" data-region="ege" data-type="deniz">
                <img src="hotel2.jpg" alt="Bodrum">
                <div class="destination-info">
                    <h3>Bodrum</h3>
                    <p>Eğlence ve lüksün buluştuğu cennet</p>
                    <div class="destination-meta">
                        <span class="region">Ege</span>
                        <span class="type">Deniz Tatili</span>
                    </div>
                    <a href="hotels.php" class="btn btn-sm">Otelleri Gör</a>
                </div>
            </div>

            <div class="destination-card" data-region="ic-anadolu" data-type="kultur">
                <img src="hotel3.jpg" alt="Kapadokya">
                <div class="destination-info">
                    <h3>Kapadokya</h3>
                    <p>Eşsiz doğal güzellikleri ve peri bacalarıyla</p>
                    <div class="destination-meta">
                        <span class="region">İç Anadolu</span>
                        <span class="type">Kültür Turu</span>
                    </div>
                    <a href="hotels.php" class="btn btn-sm">Otelleri Gör</a>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'footer.php'; ?>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const searchInput  = document.getElementById('dest-search');
    const regionFilter = document.getElementById('filter-region');
    const typeFilter   = document.getElementById('filter-type');
    const cards        = document.querySelectorAll('.destination-card');

    function filterDest() {
        const term   = searchInput.value.toLowerCase();
        const region = regionFilter.value;
        const type   = typeFilter.value;

        cards.forEach(card => {
            const title       = card.querySelector('h3').textContent.toLowerCase();
            const matchSearch = title.includes(term);
            const matchRegion = !region || card.dataset.region === region;
            const matchType   = !type   || card.dataset.type   === type;

            card.style.display = (matchSearch && matchRegion && matchType) ? '' : 'none';
        });
    }

    searchInput.addEventListener('input', filterDest);
    regionFilter.addEventListener('change', filterDest);
    typeFilter.addEventListener('change', filterDest);
});
</script>

</body>
</html>