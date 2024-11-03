<?php
session_start();
require 'config/db.php';

// Pastikan hanya admin yang dapat mengakses halaman ini
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] == 0) {
    echo "Access denied!";
    exit;
}

// Mendapatkan daftar evaluasi inventaris dari database
$stmt = $pdo->prepare("SELECT * FROM Inventory_Evaluations");
$stmt->execute();
$evaluations = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Inventory Evaluations</title>
</head>

<body>
    <h1>Inventory Evaluations</h1>
    <a href="inventory_form.php">Add New Evaluation</a>
    <table border="1">
        <thead>
            <tr>
                <th>Date</th>
                <th>Operating</th>
                <th>Directing </th>
                <th>Idle</th>
                <th>Usul Hapus</th>
                <th>Perbaikan</th>
                <th>Teknologi Tertinggal</th>
                <th>Total</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($evaluations as $evaluation): ?>
                <tr>
                    <td><?= htmlspecialchars($evaluation['evaluation_date']) ?></td>
                    <td><?= $evaluation['code_o']   ?></td>
                    <td><?= $evaluation['code_d']   ?></td>
                    <td><?= $evaluation['code_i']   ?></td>
                    <td><?= $evaluation['code_u']   ?></td>
                    <td><?= $evaluation['code_p']   ?></td>
                    <td><?= $evaluation['code_t']   ?></td>
                    <td><?= $evaluation['total'] ?></td>
                    <td>
                        <a href="inventory_form.php?id=<?= $evaluation['inventory_evaluation_id'] ?>">Edit</a>
                        <a href="delete_inventory.php?id=<?= $evaluation['inventory_evaluation_id'] ?>" onclick="return confirm('Are you sure?')">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>

</html>