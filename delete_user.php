<?php
session_start();
require 'config/db.php';

// Hanya admin yang dapat menghapus user
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] == 0) {
    echo "Access denied!";
    exit;
}

$id = $_GET['id'] ?? null;
if ($id) {
    $stmt = $pdo->prepare("DELETE FROM Users WHERE id = :id");
    $stmt->execute(['id' => $id]);
}

header("Location: user_list.php");
exit;
