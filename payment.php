<?php
session_start();
if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit(); }
if (!isset($_SESSION['reservation']) || empty($_SESSION['reservation'])) { header("Location: hotels.php"); exit(); }

$reservation = $_SESSION['reservation'];
$hotel = ['name' => 'Seçilen Otel'];

// DB bağlantısı varsa otel bilgisi çek
if (file_exists('db.php')) {
    require_once 'db.php';
    $hotel_id = (int)($reservation['hotel_id'] ?? 0);
    if ($hotel_id) {
        $r = $conn->query("SELECT * FROM hotels WHERE id = $hotel_id");
        if ($r && $r->num_rows > 0) $hotel = $r->fetch_assoc();
    }
    $conn->close();
}

$error = '';
if (isset($_SESSION['payment_error'])) {
    $error = $_SESSION['payment_error'];
    unset($_SESSION['payment_error']);
}
$active_page = '';
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ödeme — TatilCenneti</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php include 'header.php'; ?>

<section class="page-header">
    <div class="container">
        <h1>Ödeme</h1>
        <p>Güvenli ödeme ile rezervasyonunuzu tamamlayın</p>
    </div>
</section>

<section class="payment-section">
    <div class="container">
        <div class="payment-grid">

            <!-- Form -->
            <div class="payment-form-box">
                <div class="box-header">
                    <h2>Ödeme Bilgileri</h2>
                </div>
                <div class="box-body">
                    <?php if ($error): ?>
                        <div class="error-message"><?= htmlspecialchars($error) ?></div>
                    <?php endif; ?>

                    <form action="payment_process.php" method="POST">
                        <p style="font-weight:600;margin-bottom:14px;color:var(--text)">Ödeme Yöntemi</p>

                        <div class="payment-method-option">
                            <input type="radio" id="credit_card" name="payment_method" value="credit_card" checked>
                            <label for="credit_card" style="cursor:pointer;font-weight:500">💳 Kredi / Banka Kartı</label>
                        </div>

                        <div class="card-fields">
                            <div class="form-group">
                                <label>Kart Üzerindeki İsim</label>
                                <input type="text" name="card_holder" placeholder="AD SOYAD" required>
                            </div>
                            <div class="form-group">
                                <label>Kart Numarası</label>
                                <input type="text" id="card-number" name="card_number" placeholder="0000 0000 0000 0000" required maxlength="19">
                            </div>
                            <div class="form-row">
                                <div class="form-group">
                                    <label>Son Kullanma Tarihi</label>
                                    <input type="text" id="expiry" name="expiry_date" placeholder="AA/YY" required maxlength="5">
                                </div>
                                <div class="form-group">
                                    <label>CVV</label>
                                    <input type="text" id="cvv" name="cvv" placeholder="•••" required maxlength="3">
                                </div>
                            </div>
                        </div>

                        <div class="payment-actions" style="margin-top:28px">
                            <a href="hotels.php" class="btn btn-outline">← Geri Dön</a>
                            <button type="submit" class="btn btn-primary">🔒 Ödemeyi Tamamla</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Özet -->
            <div class="payment-summary-box">
                <div class="box-header">
                    <h2>Rezervasyon Özeti</h2>
                </div>
                <div class="box-body">
                    <div class="summary-item">
                        <span>Otel</span>
                        <span style="font-weight:600"><?= htmlspecialchars($hotel['name']) ?></span>
                    </div>
                    <?php if (isset($reservation['check_in'])): ?>
                    <div class="summary-item">
                        <span>Giriş</span>
                        <span><?= date('d.m.Y', strtotime($reservation['check_in'])) ?></span>
                    </div>
                    <div class="summary-item">
                        <span>Çıkış</span>
                        <span><?= date('d.m.Y', strtotime($reservation['check_out'])) ?></span>
                    </div>
                    <?php endif; ?>
                    <?php if (isset($reservation['guests'])): ?>
                    <div class="summary-item">
                        <span>Misafir</span>
                        <span><?= (int)$reservation['guests'] ?> Kişi</span>
                    </div>
                    <?php endif; ?>
                    <?php if (isset($reservation['nights'])): ?>
                    <div class="summary-item">
                        <span>Konaklama</span>
                        <span><?= (int)$reservation['nights'] ?> Gece</span>
                    </div>
                    <?php endif; ?>
                    <?php if (isset($reservation['total_price'])): ?>
                    <div class="summary-item total">
                        <span>Toplam</span>
                        <span>₺<?= number_format($reservation['total_price'], 2, ',', '.') ?></span>
                    </div>
                    <?php endif; ?>

                    <p style="font-size:12px;color:var(--text-muted);margin-top:16px;line-height:1.5">
                        🔒 Ödeme bilgileriniz SSL ile şifrelenmektedir.
                    </p>
                </div>
            </div>

        </div>
    </div>
</section>

<?php include 'footer.php'; ?>

<script>
const cardInput  = document.getElementById('card-number');
const expiryInput = document.getElementById('expiry');
const cvvInput   = document.getElementById('cvv');

cardInput.addEventListener('input', function () {
    let v = this.value.replace(/\D/g, '').slice(0, 16);
    this.value = v.replace(/(.{4})/g, '$1 ').trim();
});

expiryInput.addEventListener('input', function () {
    let v = this.value.replace(/\D/g, '').slice(0, 4);
    if (v.length > 2) v = v.slice(0, 2) + '/' + v.slice(2);
    this.value = v;
});

cvvInput.addEventListener('input', function () {
    this.value = this.value.replace(/\D/g, '').slice(0, 3);
});
</script>

</body>

</html>