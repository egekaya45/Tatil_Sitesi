<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require_once 'db.php';

$user_id = (int)$_SESSION['user_id'];
$success = '';
$error   = '';

// Kullanıcı bilgisi
$result = $conn->query("SELECT * FROM users WHERE id = $user_id");
if (!$result || $result->num_rows === 0) {
    header("Location: logout.php");
    exit();
}
$user = $result->fetch_assoc();

// Rezervasyonlar
$res_result   = $conn->query("SELECT r.*, h.name AS hotel_name, h.image FROM reservations r JOIN hotels h ON r.hotel_id = h.id WHERE r.user_id = $user_id ORDER BY r.created_at DESC");
$reservations = [];
if ($res_result && $res_result->num_rows > 0) {
    while ($row = $res_result->fetch_assoc()) {
        $reservations[] = $row;
    }
}

// Profil güncelle
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_profile'])) {
    $name  = $conn->real_escape_string(trim($_POST['name']));
    $email = $conn->real_escape_string(trim($_POST['email']));
    $phone = $conn->real_escape_string(trim($_POST['phone'] ?? ''));

    if ($email !== $user['email']) {
        $check = $conn->query("SELECT id FROM users WHERE email = '$email' AND id != $user_id");
        if ($check && $check->num_rows > 0) {
            $error = "Bu e-posta zaten kayıtlı!";
        }
    }

    if (empty($error)) {
        if ($conn->query("UPDATE users SET name='$name', email='$email', phone='$phone', updated_at=NOW() WHERE id=$user_id")) {
            $success = "Profil bilgileriniz güncellendi.";
            $_SESSION['user_name']  = $name;
            $_SESSION['user_email'] = $email;
            $user['name']  = $name;
            $user['email'] = $email;
            $user['phone'] = $phone;
        } else {
            $error = "Güncelleme başarısız.";
        }
    }
}


// Şifre değiştir
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['change_password'])) {
    $current = $_POST['current_password'];
    $new     = $_POST['new_password'];
    $confirm = $_POST['confirm_password'];

    if (!password_verify($current, $user['password'])) {
        $error = "Mevcut şifreniz hatalı!";
    } elseif ($new !== $confirm) {
        $error = "Yeni şifreler eşleşmiyor!";
    } elseif (strlen($new) < 6) {
        $error = "Şifre en az 6 karakter olmalıdır.";
    } else {
        $hashed = password_hash($new, PASSWORD_DEFAULT);
        if ($conn->query("UPDATE users SET password='$hashed', updated_at=NOW() WHERE id=$user_id")) {
            $success = "Şifreniz başarıyla değiştirildi.";
        } else {
            $error = "Şifre değiştirme başarısız.";
        }
    }
}

$conn->close();
$active_page = '';
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profilim — TatilCenneti</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php include 'header.php'; ?>

<section class="page-header">
    <div class="container">
        <h1>Profilim</h1>
        <p>Hesap bilgilerinizi ve rezervasyonlarınızı yönetin</p>
    </div>
</section>

<div class="container">
    <div class="profile-layout">

        <!-- Sidebar -->
        <div>
            <div class="profile-sidebar-card">
                <h3>Menü</h3>
                <nav class="profile-menu">
                    <a href="#profile" class="active">Profil Bilgilerim</a>
                    <a href="#reservations">Rezervasyonlarım</a>
                    <a href="#password">Şifre Değiştir</a>
                </nav>
            </div>
        </div>

        <!-- İçerik -->
        <div>
            <?php if ($success): ?>
                <div class="success-message"><?= htmlspecialchars($success) ?></div>
            <?php endif; ?>
            <?php if ($error): ?>
                <div class="error-message"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <!-- Profil -->
            <div id="profile" class="profile-card">
                <h2>Profil Bilgilerim</h2>
                <form action="user_profile.php" method="POST">
                    <div class="form-group">
                        <label>Ad Soyad</label>
                        <input type="text" name="name" value="<?= htmlspecialchars($user['name']) ?>" required>
                    </div>
                    <div class="form-group">
                        <label>E-posta</label>
                        <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Telefon</label>
                        <input type="text" id="phoneInput" name="phone" value="<?= htmlspecialchars($user['phone'] ?? '') ?>" placeholder="0544 767 78 38" maxlength="14">
                    </div>
                    <button type="submit" name="update_profile" class="btn btn-primary">Bilgilerimi Güncelle</button>
                </form>
            </div>

            <!-- Rezervasyonlar -->
            <div id="reservations" class="profile-card">
                <h2>Rezervasyonlarım</h2>
                <?php if (empty($reservations)): ?>
                    <p style="color:var(--text-muted)">Henüz rezervasyonunuz bulunmuyor. <a href="hotels.php" style="color:var(--primary)">Otel inceleyin →</a></p>
                <?php else: ?>
                    <?php foreach ($reservations as $res): ?>
                        <div class="reservation-card">
                            <div class="reservation-header">
                                <img src="<?= htmlspecialchars($res['image']) ?>" alt="<?= htmlspecialchars($res['hotel_name']) ?>">
                                <div class="reservation-info">
                                    <h3><?= htmlspecialchars($res['hotel_name']) ?></h3>
                                    <p>Rezervasyon No: #<?= $res['id'] ?></p>
                                </div>
                                <div class="reservation-status">
                                    <?php
                                        $statusMap = ['completed' => ['label' => 'Tamamlandı', 'class' => 'status-completed'], 'pending' => ['label' => 'Beklemede', 'class' => 'status-pending'], 'cancelled' => ['label' => 'İptal Edildi', 'class' => 'status-cancelled']];
                                        $s = $statusMap[$res['status']] ?? ['label' => $res['status'], 'class' => ''];
                                    ?>
                                    <span class="status <?= $s['class'] ?>"><?= $s['label'] ?></span>
                                </div>
                            </div>
                            <div class="reservation-body">
                                <div class="reservation-details">
                                    <div class="detail-item">
                                        <strong>Giriş Tarihi</strong>
                                        <span><?= date('d.m.Y', strtotime($res['check_in_date'])) ?></span>
                                    </div>
                                    <div class="detail-item">
                                        <strong>Çıkış Tarihi</strong>
                                        <span><?= date('d.m.Y', strtotime($res['check_out_date'])) ?></span>
                                    </div>
                                    <div class="detail-item">
                                        <strong>Toplam</strong>
                                        <span>₺<?= number_format($res['total_price'], 2, ',', '.') ?></span>
                                    </div>
                                </div>
                                <?php if ($res['status'] === 'pending'): ?>
                                    <div class="reservation-actions">
                                        <a href="cancel_reservation.php?id=<?= $res['id'] ?>" class="btn btn-sm" onclick="return confirm('Rezervasyonu iptal etmek istediğinizden emin misiniz?')">İptal Et</a>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <!-- Şifre -->
            <div id="password" class="profile-card">
                <h2>Şifre Değiştir</h2>
                <form action="user_profile.php" method="POST">
                    <div class="form-group">
                        <label>Mevcut Şifre</label>
                        <input type="password" name="current_password" required>
                    </div>
                    <div class="form-group">
                        <label>Yeni Şifre</label>
                        <input type="password" name="new_password" required minlength="6">
                    </div>
                    <div class="form-group">
                        <label>Yeni Şifre Tekrar</label>
                        <input type="password" name="confirm_password" required minlength="6">
                    </div>
                    <button type="submit" name="change_password" class="btn btn-primary">Şifremi Değiştir</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const links = document.querySelectorAll('.profile-menu a');
    links.forEach(link => {
        link.addEventListener('click', function (e) {
            e.preventDefault();
            links.forEach(l => l.classList.remove('active'));
            this.classList.add('active');
            const target = document.getElementById(this.getAttribute('href').substring(1));
            if (target) window.scrollTo({ top: target.offsetTop - 90, behavior: 'smooth' });
        });
    });
});

// Telefon formatlaması
const phoneInput = document.getElementById('phoneInput');
if (phoneInput) {
    phoneInput.addEventListener('input', function(e) {
        let val = e.target.value.replace(/\D/g, '');
        if (val.length > 0 && !val.startsWith('0')) val = '0' + val;
        val = val.slice(0, 11);
        let f = val;
        if (val.length > 4)  f = val.slice(0,4) + ' ' + val.slice(4);
        if (val.length > 7)  f = val.slice(0,4) + ' ' + val.slice(4,7) + ' ' + val.slice(7);
        if (val.length > 9)  f = val.slice(0,4) + ' ' + val.slice(4,7) + ' ' + val.slice(7,9) + ' ' + val.slice(9);
        e.target.value = f;
    });
}
</script>
</body>

</html>