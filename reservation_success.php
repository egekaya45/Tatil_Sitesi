<?php
session_start();
if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit(); }
if (!isset($_SESSION['last_reservation_id'])) { header("Location: index.php"); exit(); }

$reservation_id = (int)$_SESSION['last_reservation_id'];
$reservation    = null;

if (file_exists('db.php')) {
    require_once 'db.php';
    $user_id = (int)$_SESSION['user_id'];
    $sql     = "SELECT r.*, h.name AS hotel_name, h.address, h.image FROM reservations r JOIN hotels h ON r.hotel_id = h.id WHERE r.id = $reservation_id AND r.user_id = $user_id";
    $result  = $conn->query($sql);
    if ($result && $result->num_rows > 0) $reservation = $result->fetch_assoc();
    $conn->close();
}

unset($_SESSION['last_reservation_id']);
$active_page = '';
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rezervasyon Başarılı — TatilCenneti</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php include 'header.php'; ?>

<section class="success-page">
    <div class="container">
        <div class="success-box">
            <div class="success-box-top">
                <div class="success-check">✓</div>
                <h2>Rezervasyonunuz Tamamlandı!</h2>
                <p>Rezervasyon No: <strong>#<?= $reservation_id ?></strong></p>
            </div>
            <div class="success-box-body">

                <?php if ($reservation): ?>
                <div class="hotel-preview">
                    <img src="<?= htmlspecialchars($reservation['image'] ?? 'hotel1.jpg') ?>" alt="<?= htmlspecialchars($reservation['hotel_name']) ?>">
                    <div>
                        <h3><?= htmlspecialchars($reservation['hotel_name']) ?></h3>
                        <p><?= htmlspecialchars($reservation['address'] ?? '') ?></p>
                    </div>
                </div>

                <div class="res-details">
                    <h3>Rezervasyon Detayları</h3>
                    <div class="res-detail-item">
                        <strong>Giriş Tarihi</strong>
                        <span><?= date('d.m.Y', strtotime($reservation['check_in_date'])) ?></span>
                    </div>
                    <div class="res-detail-item">
                        <strong>Çıkış Tarihi</strong>
                        <span><?= date('d.m.Y', strtotime($reservation['check_out_date'])) ?></span>
                    </div>
                    <div class="res-detail-item">
                        <strong>Misafir Sayısı</strong>
                        <span><?= (int)$reservation['guests'] ?> Kişi</span>
                    </div>
                    <div class="res-detail-item">
                        <strong>Toplam Tutar</strong>
                        <span>₺<?= number_format($reservation['total_price'], 2, ',', '.') ?></span>
                    </div>
                    <div class="res-detail-item">
                        <strong>Durum</strong>
                        <span class="status status-completed">Onaylandı</span>
                    </div>
                </div>
                <?php endif; ?>

                <p style="color:var(--text-muted);font-size:14px;margin-bottom:24px">
                    Rezervasyon detaylarınız e-posta adresinize gönderilmiştir.
                </p>

                <div class="success-actions">
                    <a href="user_profile.php" class="btn btn-outline">Rezervasyonlarım</a>
                    <a href="index.php" class="btn btn-primary">Ana Sayfaya Dön</a>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'footer.php'; ?>
</body>
</html>