<?php
session_start();
require 'config/db.php';

// Pastikan hanya admin yang dapat menghapus aset
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$id = $_GET['id'] ?? null;
if ($id) {
    // Mengambil `puserif_number` saat ini
    $stmt = $pdo->prepare("SELECT puserif_number FROM Assets WHERE asset_id = :id");
    $stmt->execute(['id' => $id]);
    $asset = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($asset) {
        // Ubah angka awal `puserif_number` menjadi '4'
        $new_puserif_number = '4' . substr($asset['puserif_number'], 1);

        // Update status, puserif_number, dan removed_date
        $stmt = $pdo->prepare("UPDATE Assets SET status = 'removed', puserif_number = :new_puserif_number, removed_date = :removed_date WHERE asset_id = :id");
        $stmt->execute([
            'new_puserif_number' => $new_puserif_number,
            'removed_date' => date('Y-m-d'),
            'id' => $id,
        ]);
    }
}

header("Location: asset_list.php");
exit;
?>
