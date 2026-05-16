<?php
session_start();

if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once 'db.php';

    $email    = $conn->real_escape_string(trim($_POST['email']));
    $password = $_POST['password'];

    $sql    = "SELECT id, email, password, name FROM users WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows == 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id']    = $user['id'];
            $_SESSION['user_name']  = $user['name'];
            $_SESSION['user_email'] = $user['email'];
            header("Location: index.php");
            exit();
        }
    }
    $error = "Hatalı e-posta veya şifre!";
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giriş Yap — TatilCenneti</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php $active_page = ''; include 'header.php'; ?>

<section class="auth-section">
    <div class="container">
        <div class="auth-container">
            <h2>Tekrar Hoş Geldiniz</h2>
            <p style="color:var(--text-muted);margin-bottom:24px;">Hesabınıza giriş yapın</p>

            <?php if ($error): ?>
                <div class="error-message"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <form action="login.php" method="POST" class="auth-form">
                <div class="form-group">
                    <label for="email">E-posta</label>
                    <input type="email" id="email" name="email" placeholder="ornek@email.com" required>
                </div>
                <div class="form-group">
                    <label for="password">Şifre</label>
                    <input type="password" id="password" name="password" placeholder="••••••••" required>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Giriş Yap</button>
                </div>
                <div class="auth-links">
                    <a href="register.php">Hesabınız yok mu? <strong>Üye Olun</strong></a>
                </div>
            </form>
        </div>
    </div>
</section>

<?php include 'footer.php'; ?>
</body>
</html>