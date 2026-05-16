<?php
session_start();
if (!isset($_SESSION['user_id']))  { header("Location: login.php"); exit(); }
if (!isset($_SESSION['reservation'])) { header("Location: hotels.php"); exit(); }
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header("Location: payment.php"); exit(); }

$payment_method = $_POST['payment_method'] ?? 'credit_card';
$card_number    = str_replace(' ', '', $_POST['card_number'] ?? '');
$expiry_date    = $_POST['expiry_date'] ?? '';
$cvv            = $_POST['cvv'] ?? '';

$errors = [];
if (strlen($card_number) !== 16) $errors[] = "Kart numarası 16 haneli olmalıdır.";
if (!preg_match('/^\d{2}\/\d{2}$/', $expiry_date)) $errors[] = "Son kullanma tarihi AA/YY formatında olmalıdır.";
if (strlen($cvv) !== 3) $errors[] = "CVV kodu 3 haneli olmalıdır.";

if (!empty($errors)) {
    $_SESSION['payment_error'] = implode('<br>', $errors);
    header("Location: payment.php");
    exit();
}

require_once 'db.php';

$reservation = $_SESSION['reservation'];
$user_id     = (int)$_SESSION['user_id'];
$hotel_id    = (int)($reservation['hotel_id'] ?? 0);
$check_in    = $conn->real_escape_string($reservation['check_in']  ?? date('Y-m-d'));
$check_out   = $conn->real_escape_string($reservation['check_out'] ?? date('Y-m-d', strtotime('+1 day')));
$guests      = (int)($reservation['guests']       ?? 1);
$room_type   = $conn->real_escape_string($reservation['room_type'] ?? 'Standart');
$total_price = (float)($reservation['total_price'] ?? 0);

$sql = "INSERT INTO reservations (user_id, hotel_id, check_in_date, check_out_date, guests, room_type, total_price, payment_method, status, created_at)
        VALUES ('$user_id','$hotel_id','$check_in','$check_out','$guests','$room_type','$total_price','$payment_method','completed',NOW())";

if ($conn->query($sql) === TRUE) {
    $reservation_id = $conn->insert_id;
    $last_four      = substr($card_number, -4);
    $conn->query("INSERT INTO payments (reservation_id, amount, payment_method, card_last_four, status, created_at)
                  VALUES ('$reservation_id','$total_price','$payment_method','$last_four','completed',NOW())");
    unset($_SESSION['reservation']);
    $_SESSION['last_reservation_id'] = $reservation_id;
    header("Location: reservation_success.php");
} else {
    $_SESSION['payment_error'] = "Ödeme işlemi sırasında bir hata oluştu. Lütfen tekrar deneyin.";
    header("Location: payment.php");
}
$conn->close();
exit();
?>