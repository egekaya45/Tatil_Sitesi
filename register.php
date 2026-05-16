<?php
session_start();

if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$error   = '';
$success = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once 'db.php';

    $name             = $conn->real_escape_string(trim($_POST['name']));
    $email            = $conn->real_escape_string(trim($_POST['email']));
    $phone            = $conn->real_escape_string(trim($_POST['phone'] ?? ''));
    $password         = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if (empty($phone)) {
        $error = "Telefon numarası zorunludur.";
    } elseif (strlen($password) < 6) {
        $error = "Şifre en az 6 karakter olmalıdır.";
    } elseif ($password !== $confirm_password) {
        $error = "Şifreler eşleşmiyor!";
    } else {
        $check  = "SELECT id FROM users WHERE email = '$email'";
        $result = $conn->query($check);
        if ($result && $result->num_rows > 0) {
            $error = "Bu e-posta adresi zaten kayıtlı!";
        } else {
            $hashed = password_hash($password, PASSWORD_DEFAULT);
            $sql    = "INSERT INTO users (name, email, password, phone, created_at) VALUES ('$name', '$email', '$hashed', '$phone', NOW())";
            if ($conn->query($sql) === TRUE) {
                $success = "Kayıt başarılı! Şimdi giriş yapabilirsiniz.";
            } else {
                $error = "Kayıt sırasında bir hata oluştu.";
            }
        }
    }
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Üye Ol — TatilCenneti</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php $active_page = ''; include 'header.php'; ?>

<section class="auth-section">
    <div class="container">
        <div class="auth-container">
            <h2>Hesap Oluştur</h2>
            <p style="color:var(--text-muted);margin-bottom:24px;">Hemen ücretsiz üye olun</p>

            <?php if ($error): ?>
                <div class="error-message"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
            <?php if ($success): ?>
                <div class="success-message">
                    <?= htmlspecialchars($success) ?>
                    <br><a href="login.php" style="color:inherit;font-weight:600;">Giriş yapmak için tıklayın →</a>
                </div>
            <?php endif; ?>

            <form action="register.php" method="POST" class="auth-form">
                <div class="form-group">
                    <label for="name">Ad Soyad</label>
                    <input type="text" id="name" name="name" placeholder="Adınız Soyadınız" required>
                </div>
                <div class="form-group">
                    <label for="email">E-posta</label>
                    <input type="email" id="email" name="email" placeholder="ornek@email.com" required>
                </div>
                <div class="form-group">
                    <label for="phone">Telefon Numarası</label>
                    <input type="text" id="phone" name="phone" placeholder="0544 767 78 38" required maxlength="14">
                </div>
                <div class="form-group">
                    <label for="password">Şifre</label>
                    <input type="password" id="password" name="password" placeholder="En az 6 karakter" required minlength="6">
                </div>
                <div class="form-group">
                    <label for="confirm_password">Şifre Tekrar</label>
                    <input type="password" id="confirm_password" name="confirm_password" placeholder="Şifrenizi tekrar girin" required minlength="6">
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Üye Ol</button>
                </div>
                <div class="auth-links">
                    <a href="login.php">Zaten üye misiniz? <strong>Giriş Yapın</strong></a>
                </div>
            </form>
        </div>
    </div>
</section>

<?php include 'footer.php'; ?>

<script>
document.getElementById('phone').addEventListener('input', function(e) {
    let val = e.target.value.replace(/\D/g, '');
    if (val.length > 0 && !val.startsWith('0')) val = '0' + val;
    val = val.slice(0, 11);
    let f = val;
    if (val.length > 4)  f = val.slice(0,4) + ' ' + val.slice(4);
    if (val.length > 7)  f = val.slice(0,4) + ' ' + val.slice(4,7) + ' ' + val.slice(7);
    if (val.length > 9)  f = val.slice(0,4) + ' ' + val.slice(4,7) + ' ' + val.slice(7,9) + ' ' + val.slice(9);
    e.target.value = f;
});
</script>
</body>
</html>