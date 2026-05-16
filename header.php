<?php
// Bu dosya tüm sayfalara include edilir
// $active_page değişkeni sayfada tanımlanmalı (örn: 'home', 'hotels', 'destinations')
if (!isset($active_page)) $active_page = '';
?>
<header>
    <div class="container">
        <a href="index.php" class="logo">
            <img src="logo.jpg" alt="TatilCenneti Logo">
            <h1>TatilCenneti</h1>
        </a>

        <nav>
            <ul>
                <li><a href="index.php" <?= $active_page === 'home' ? 'class="active"' : '' ?>>Ana Sayfa</a></li>
                <li><a href="destinations.php" <?= $active_page === 'destinations' ? 'class="active"' : '' ?>>Destinasyonlar</a></li>
                <li><a href="hotels.php" <?= $active_page === 'hotels' ? 'class="active"' : '' ?>>Oteller</a></li>
                <li><a href="contact.php" <?= $active_page === 'contact' ? 'class="active"' : '' ?>>İletişim</a></li>
            </ul>
        </nav>

        <div class="user-actions">
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="user_profile.php" class="btn btn-outline">Profilim</a>
                <a href="logout.php" class="btn btn-primary">Çıkış Yap</a>
            <?php else: ?>
                <a href="login.php" class="btn btn-outline">Giriş Yap</a>
                <a href="register.php" class="btn btn-primary">Üye Ol</a>
            <?php endif; ?>
        </div>

        <button class="nav-hamburger" id="navHamburger" aria-label="Menü">
            <span></span><span></span><span></span>
        </button>
    </div>
</header>