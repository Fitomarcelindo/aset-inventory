<?php
session_start();
require 'config/db.php';

// Hanya admin yang dapat menghapus area
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$id = $_GET['id'] ?? null;
if ($id) {
    $stmt = $pdo->prepare("DELETE FROM Areas WHERE area_id = :id");
    $stmt->execute(['id' => $id]);
}

header("Location: area_list.php");
exit;
