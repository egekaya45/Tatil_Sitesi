<footer>
    <div class="container">
        <div class="footer-content">
            <div class="footer-logo">
                <img src="logo.jpg" alt="TatilCenneti Logo">
                <h3>TatilCenneti</h3>
                <p>Hayalinizdeki tatili en iyi fiyatlarla bulmanızı sağlıyoruz.</p>
            </div>
            <div class="footer-links">
                <h4>Hızlı Erişim</h4>
                <ul>
                    <li><a href="index.php">Ana Sayfa</a></li>
                    <li><a href="destinations.php">Destinasyonlar</a></li>
                    <li><a href="hotels.php">Oteller</a></li>
                    <li><a href="contact.php">İletişim</a></li>
                </ul>
            </div>
            <div class="footer-contact">
                <h4>İletişim</h4>
                <p>📍 Tatil Caddesi No:123, İstanbul</p>
                <p>📞 +90 212 345 67 89</p>
                <p>✉️ info@tatilcenneti.com</p>
            </div>
            <div class="footer-newsletter">
                <h4>Bültenimize Abone Olun</h4>
                <p>En güncel fırsatlardan haberdar olmak için abone olun.</p>
                <form id="newsletterForm" onsubmit="handleNewsletter(event)">
                    <input type="email" id="newsletterEmail" placeholder="E-posta adresiniz" required>
                    <button type="submit">Abone Ol</button>
                </form>
                <div id="newsletterMsg" style="display:none;margin-top:10px;font-size:13px;color:#4ade80;font-weight:500">
                    ✅ Abone oldunuz! Teşekkürler.
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2026 TatilCenneti. Tüm hakları saklıdır.</p>
        </div>
    </div>
</footer>

<script>
    // Hamburger menü
    const hamburger = document.getElementById('navHamburger');
    const nav = document.querySelector('nav');
    if (hamburger) {
        hamburger.addEventListener('click', () => {
            nav.classList.toggle('nav-open');
            hamburger.classList.toggle('open');
        });
    }

    // Bülten abone ol
    function handleNewsletter(e) {
        e.preventDefault();
        const email = document.getElementById('newsletterEmail').value;
        if (!email) return;
        document.getElementById('newsletterForm').style.display = 'none';
        document.getElementById('newsletterMsg').style.display = 'block';
    }
</script>