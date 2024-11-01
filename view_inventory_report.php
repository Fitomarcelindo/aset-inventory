<?php
session_start();
require 'config/db.php';

// Pastikan hanya admin yang dapat mengakses halaman ini
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] == 0) {
    echo "Access denied!";
    exit;
}

// Mendapatkan tanggal laporan dari parameter GET
$id = $_GET['id'] ?? null;

// Mendapatkan daftar laporan evaluasi untuk tanggal yang ditentukan
$stmt = $pdo->prepare("SELECT re.report_evaluation_id, ie.status, ie.comments, re.evaluation_date, re.description, a.name AS asset_name
                       FROM report_evaluations re
                       JOIN inventory_evaluations ie ON re.inventory_evaluation_id = ie.inventory_evaluation_id
                       JOIN Assets a ON ie.asset_id = a.asset_id
                       WHERE re.report_evaluation_id = :id");
$stmt->execute(['id' => $id]);
$reports = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Inventory Evaluation Report</title>
</head>

<body>
    <h1>Inventory Evaluation Report for <?= htmlspecialchars($report['evaluation_date']) ?></h1>
    <table border="1">
        <thead>
            <tr>
                <th>Report ID</th>
                <th>Asset Name</th>
                <th>Status</th>

                <th>Description</th>
                <th>Comments</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($reports as $report): ?>
                <tr>
                    <td><?= htmlspecialchars($report['report_evaluation_id']) ?></td>
                    <td><?= htmlspecialchars($report['asset_name']) ?></td>
                    <td><?= htmlspecialchars($report['status']) ?></td>

                    <td><?= htmlspecialchars($report['description']) ?></td>
                    <td><?= htmlspecialchars($report['comments']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <a href="generate_inventory_report.php">Generate New Report</a>
</body>

</html>