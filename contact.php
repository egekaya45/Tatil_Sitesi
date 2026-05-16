<?php
session_start();
$active_page = 'contact';

$success = '';
$error   = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name    = trim($_POST['name'] ?? '');
    $email   = trim($_POST['email'] ?? '');
    $subject = trim($_POST['subject'] ?? '');
    $message = trim($_POST['message'] ?? '');

    if (empty($name) || empty($email) || empty($message)) {
        $error = 'Lütfen zorunlu alanları doldurun.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Geçerli bir e-posta adresi girin.';
    } else {
        // normalde mail() veya PHPMailer ile mail gonderilir
        $success = 'Mesajınız başarıyla iletildi! En kısa sürede size döneceğiz.';
    }
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>İletişim — TatilCenneti</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php include 'header.php'; ?>

<section class="page-header">
    <div class="container">
        <h1>İletişim</h1>
        <p>Sorularınız için bize ulaşın, en kısa sürede yanıt vereceğiz</p>
    </div>
</section>

<section class="contact-section">
    <div class="container">
        <div class="contact-grid">

            <!-- Bilgi Kutusu -->
            <div class="contact-info-box">
                <h2>Merhaba!</h2>
                <p>Size nasıl yardımcı olabiliriz? Aşağıdaki iletişim bilgilerimizden veya formu doldurarak bize ulaşabilirsiniz.</p>

                <div class="contact-item">
                    <div class="contact-item-icon">📍</div>
                    <div class="contact-item-text">
                        <strong>Adres</strong>
                        <span>Tatil Caddesi No:123, İstanbul, Türkiye</span>
                    </div>
                </div>

                <div class="contact-item">
                    <div class="contact-item-icon">📞</div>
                    <div class="contact-item-text">
                        <strong>Telefon</strong>
                        <span>+90 212 345 67 89</span>
                    </div>
                </div>

                <div class="contact-item">
                    <div class="contact-item-icon">✉️</div>
                    <div class="contact-item-text">
                        <strong>E-posta</strong>
                        <span>info@tatilcenneti.com</span>
                    </div>
                </div>

                <div class="contact-item">
                    <div class="contact-item-icon">🕐</div>
                    <div class="contact-item-text">
                        <strong>Çalışma Saatleri</strong>
                        <span>Hft. içi 09:00 – 18:00</span>
                    </div>
                </div>
            </div>

            <!-- Form -->
            <div class="contact-form-box">
                <h2>Bize Yazın</h2>

                <?php if ($success): ?>
                    <div class="success-message"><?= htmlspecialchars($success) ?></div>
                <?php endif; ?>
                <?php if ($error): ?>
                    <div class="error-message"><?= htmlspecialchars($error) ?></div>
                <?php endif; ?>

                <form action="contact.php" method="POST" class="contact-form">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="name">Ad Soyad *</label>
                            <input type="text" id="name" name="name" placeholder="Adınız Soyadınız" required value="<?= htmlspecialchars($_POST['name'] ?? '') ?>">
                        </div>
                        <div class="form-group">
                            <label for="email">E-posta *</label>
                            <input type="email" id="email" name="email" placeholder="ornek@email.com" required value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="subject">Konu</label>
                        <select id="subject" name="subject">
                            <option value="">Konu seçin...</option>
                            <option value="rezervasyon">Rezervasyon</option>
                            <option value="otel">Otel Bilgisi</option>
                            <option value="iptal">İptal / Değişiklik</option>
                            <option value="sikayet">Şikayet</option>
                            <option value="diger">Diğer</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="message">Mesajınız *</label>
                        <textarea id="message" name="message" placeholder="Mesajınızı buraya yazın..." required><?= htmlspecialchars($_POST['message'] ?? '') ?></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Mesaj Gönder</button>
                </form>
            </div>

        </div>
    </div>
</section>

<?php include 'footer.php'; ?>

</body>
</html>