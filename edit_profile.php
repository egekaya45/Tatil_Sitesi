<?php
session_start();
if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit(); }

require_once 'db.php';
$user_id = (int)$_SESSION['user_id'];
$result  = $conn->query("SELECT * FROM users WHERE id = $user_id");
if (!$result || $result->num_rows === 0) { header("Location: logout.php"); exit(); }
$user = $result->fetch_assoc();

$success = '';
$error   = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name    = $conn->real_escape_string(trim($_POST['name']));
    $email   = $conn->real_escape_string(trim($_POST['email']));
    $phone   = $conn->real_escape_string(trim($_POST['phone'] ?? ''));
    $address = $conn->real_escape_string(trim($_POST['address'] ?? ''));

    if ($email !== $user['email']) {
        $check = $conn->query("SELECT id FROM users WHERE email='$email' AND id != $user_id");
        if ($check && $check->num_rows > 0) $error = "Bu e-posta adresi zaten kullanılıyor!";
    }

    if (empty($error)) {
        if ($conn->query("UPDATE users SET name='$name', email='$email', phone='$phone', address='$address', updated_at=NOW() WHERE id=$user_id")) {
            $_SESSION['user_name']  = $name;
            $_SESSION['user_email'] = $email;
            header("Location: user_profile.php");
            exit();
        } else {
            $error = "Güncelleme sırasında bir hata oluştu.";
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
    <title>Profil Düzenle — TatilCenneti</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php include 'header.php'; ?>

<section class="page-header">
    <div class="container">
        <h1>Profil Düzenle</h1>
        <p>Kişisel bilgilerinizi güncelleyin</p>
    </div>
</section>

<div class="container" style="padding-top:48px;padding-bottom:80px">
    <div class="auth-container" style="max-width:560px">
        <?php if ($error): ?>
            <div class="error-message"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form action="edit_profile.php" method="POST" class="auth-form">
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
                <input type="text" name="phone" value="<?= htmlspecialchars($user['phone'] ?? '') ?>" placeholder="+90 5xx xxx xx xx">
            </div>
            <div class="form-group">
                <label>Adres</label>
                <textarea name="address" rows="3" style="width:100%;padding:11px 14px;border:1.5px solid var(--border);border-radius:8px;font-family:inherit;font-size:14px;outline:none;resize:vertical"><?= htmlspecialchars($user['address'] ?? '') ?></textarea>
            </div>
            <div style="display:flex;gap:12px">
                <button type="submit" class="btn btn-primary">Güncelle</button>
                <a href="user_profile.php" class="btn btn-outline">İptal</a>
            </div>
        </form>
    </div>
</div>

<?php include 'footer.php'; ?>
</body>
</html>