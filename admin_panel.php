<?php
session_start();
if (!isset($_SESSION['user_id']) || ($_SESSION['user_role'] ?? '') !== 'admin') {
    header("Location: login.php");
    exit();
}

require_once 'db.php';

$stats = ['users' => 0, 'hotels' => 0, 'reservations' => 0, 'revenue' => 0];

$r = $conn->query("SELECT COUNT(*) AS t FROM users");
if ($r) $stats['users'] = $r->fetch_assoc()['t'];

$r = $conn->query("SELECT COUNT(*) AS t FROM hotels");
if ($r) $stats['hotels'] = $r->fetch_assoc()['t'];

$r = $conn->query("SELECT COUNT(*) AS t FROM reservations");
if ($r) $stats['reservations'] = $r->fetch_assoc()['t'];

$r = $conn->query("SELECT SUM(total_price) AS t FROM reservations WHERE status='completed'");
if ($r) $stats['revenue'] = (float)($r->fetch_assoc()['t'] ?? 0);

$recent = [];
$r = $conn->query("SELECT res.*, u.name AS user_name, h.name AS hotel_name FROM reservations res JOIN users u ON res.user_id = u.id JOIN hotels h ON res.hotel_id = h.id ORDER BY res.created_at DESC LIMIT 8");
if ($r && $r->num_rows > 0) {
    while ($row = $r->fetch_assoc()) $recent[] = $row;
}
$conn->close();
$active_page = '';
?>
<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel — TatilCenneti</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<?php include 'header.php'; ?>

<div class="admin-layout">
    <!-- Sidebar -->
    <div class="admin-sidebar">
        <div class="sidebar-title">Yönetim</div>
        <ul>
            <li class="active"><a href="admin_panel.php">📊 Dashboard</a></li>
            <li><a href="#">🏨 Oteller</a></li>
            <li><a href="#">📍 Destinasyonlar</a></li>
            <li><a href="#">📋 Rezervasyonlar</a></li>
            <li><a href="#">👥 Kullanıcılar</a></li>
            <li><a href="#">⭐ Yorumlar</a></li>
        </ul>
        <div class="sidebar-title">Hesap</div>
        <ul>
            <li><a href="index.php">🌐 Siteyi Görüntüle</a></li>
            <li><a href="logout.php">🚪 Çıkış Yap</a></li>
        </ul>
    </div>

    <!-- İçerik -->
    <div class="admin-content">
        <h1 class="admin-page-title">Dashboard</h1>

        <div class="stats-container">
            <div class="stat-card">
                <h3>Toplam Kullanıcı</h3>
                <div class="value"><?= $stats['users'] ?></div>
            </div>
            <div class="stat-card">
                <h3>Toplam Otel</h3>
                <div class="value"><?= $stats['hotels'] ?></div>
            </div>
            <div class="stat-card">
                <h3>Toplam Rezervasyon</h3>
                <div class="value"><?= $stats['reservations'] ?></div>
            </div>
            <div class="stat-card">
                <h3>Toplam Gelir</h3>
                <div class="value">₺<?= number_format($stats['revenue'], 0, ',', '.') ?></div>
            </div>
        </div>

        <div class="data-table-container">
            <div class="data-table-header">
                <h3>Son Rezervasyonlar</h3>
                <a href="#" class="btn btn-sm">Tümünü Gör</a>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kullanıcı</th>
                        <th>Otel</th>
                        <th>Giriş</th>
                        <th>Çıkış</th>
                        <th>Tutar</th>
                        <th>Durum</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($recent)): ?>
                        <tr><td colspan="7" style="text-align:center;color:var(--text-muted);padding:32px">Henüz rezervasyon bulunmuyor.</td></tr>
                    <?php else: ?>
                        <?php foreach ($recent as $res): ?>
                            <?php
                                $statusMap = ['completed' => ['label' => 'Tamamlandı', 'class' => 'status-completed'], 'pending' => ['label' => 'Beklemede', 'class' => 'status-pending'], 'cancelled' => ['label' => 'İptal', 'class' => 'status-cancelled']];
                                $s = $statusMap[$res['status']] ?? ['label' => $res['status'], 'class' => ''];
                            ?>
                            <tr>
                                <td>#<?= $res['id'] ?></td>
                                <td><?= htmlspecialchars($res['user_name']) ?></td>
                                <td><?= htmlspecialchars($res['hotel_name']) ?></td>
                                <td><?= date('d.m.Y', strtotime($res['check_in_date'])) ?></td>
                                <td><?= date('d.m.Y', strtotime($res['check_out_date'])) ?></td>
                                <td>₺<?= number_format($res['total_price'], 2, ',', '.') ?></td>
                                <td><span class="status <?= $s['class'] ?>"><?= $s['label'] ?></span></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>

</body>
</html>