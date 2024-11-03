<?php
session_start();
require 'config/db.php';

// Periksa sesi pengguna
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$id = $_GET['id'] ?? null;
if ($id) {
    $stmt = $pdo->prepare("DELETE FROM Asset_Mutations WHERE mutation_id = :id");
    $stmt->execute(['id' => $id]);
}

header("Location: mutation_list.php");
exit;
