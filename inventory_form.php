<?php
session_start();
require 'config/db.php';

// Pastikan hanya admin yang dapat mengakses halaman ini
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] == 0) {
    echo "Access denied!";
    exit;
}

$asset_stmt = $pdo->prepare("SELECT asset_id, name FROM Assets");
$asset_stmt->execute();
$assets = $asset_stmt->fetchAll(PDO::FETCH_ASSOC);

$id = $_GET['id'] ?? null;
$evaluation_date = '';
$code_o = 0;
$code_d = 0;
$code_i = 0;
$code_u = 0;
$code_p = 0;
$code_t = 0;
$asset_id = '';

// Jika ada ID, artinya ini adalah halaman edit
if ($id) {
    $stmt = $pdo->prepare("SELECT * FROM Inventory_Evaluations WHERE inventory_evaluation_id = :id");
    $stmt->execute(['id' => $id]);
    $evaluation = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($evaluation) {
        $evaluation_date = $evaluation['evaluation_date'];
        $code_o = $evaluation['code_o'];
        $code_d = $evaluation['code_d'];
        $code_i = $evaluation['code_i'];
        $code_u = $evaluation['code_u'];
        $code_p = $evaluation['code_p'];
        $code_t = $evaluation['code_t'];
        $asset_id = $evaluation['asset_id'];
    } else {
        echo "Evaluation not found.";
        exit;
    }
}

// Proses form untuk tambah atau update evaluasi
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $evaluation_date = $_POST['evaluation_date'];
    $code_o = isset($_POST['code_o']) ? 1 : 0;
    $code_d = isset($_POST['code_d']) ? 1 : 0;
    $code_i = isset($_POST['code_i']) ? 1 : 0;
    $code_u = isset($_POST['code_u']) ? 1 : 0;
    $code_p = isset($_POST['code_p']) ? 1 : 0;
    $code_t = isset($_POST['code_t']) ? 1 : 0;
    $asset_id = $_POST['asset_id'];

    if (!$id) {
        // Tambah evaluasi baru
        $stmt = $pdo->prepare("INSERT INTO Inventory_Evaluations (evaluation_date, code_o, code_d, code_i, code_u, code_p, code_t, asset_id) VALUES (:evaluation_date, :code_o, :code_d, :code_i, :code_u, :code_p, :code_t, :asset_id)");
        $stmt->execute([
            'evaluation_date' => $evaluation_date,
            'code_o' => $code_o,
            'code_d' => $code_d,
            'code_i' => $code_i,
            'code_u' => $code_u,
            'code_p' => $code_p,
            'code_t' => $code_t,
            'asset_id' => $asset_id,
        ]);
        echo "Evaluation added successfully.";
    } else {
        // Update evaluasi
        $stmt = $pdo->prepare("UPDATE Inventory_Evaluations SET evaluation_date = :evaluation_date, code_o = :code_o, code_d = :code_d, code_i = :code_i, code_u = :code_u, code_p = :code_p, code_t = :code_t, asset_id = :asset_id WHERE inventory_evaluation_id = :id");
        $stmt->execute([
            'evaluation_date' => $evaluation_date,
            'code_o' => $code_o,
            'code_d' => $code_d,
            'code_i' => $code_i,
            'code_u' => $code_u,
            'code_p' => $code_p,
            'code_t' => $code_t,
            'asset_id' => $asset_id,
            'id' => $id,
        ]);
        echo "Evaluation updated successfully.";
    }

    header("Location: inventory_list.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title><?= $id ? 'Edit' : 'Add' ?> Inventory Evaluation</title>
</head>

<body>
    <h1><?= $id ? 'Edit' : 'Add New' ?> Inventory Evaluation</h1>
    <form method="post">
        <label>Evaluation Date:</label>
        <input type="date" name="evaluation_date" value="<?= htmlspecialchars($evaluation_date) ?>" required>
        <br>
        <label>Code Operating:</label>
        <input type="number" name="code_o" value="<?= htmlspecialchars($code_o) ?>" min="0">
        <br>
        <label>Code Directing:</label>
        <input type="number" name="code_d" value="<?= htmlspecialchars($code_d) ?>" min="0">
        <br>
        <label>Code Idle:</label>
        <input type="number" name="code_i" value="<?= htmlspecialchars($code_i) ?>" min="0">
        <br>
        <label>Code Usul Hapus:</label>
        <input type="number" name="code_u" value="<?= htmlspecialchars($code_u) ?>" min="0">
        <br>
        <label>Code Perbaikan:</label>
        <input type="number" name="code_p" value="<?= htmlspecialchars($code_p) ?>" min="0">
        <br>
        <label>Code Teknologi Tertinggal:</label>
        <input type="number" name="code_t" value="<?= htmlspecialchars($code_t) ?>" min="0">
        <br>
        <label>Asset:</label>
        <select name="asset_id" required>
            <option value="">Select an Asset</option>
            <?php foreach ($assets as $asset): ?>
                <option value="<?= $asset['asset_id'] ?>" <?= $asset_id == $asset['asset_id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($asset['name']) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <br><br>
        <button type="submit"><?= $id ? 'Update' : 'Add' ?> Evaluation</button>
    </form>
    <a href="inventory_list.php">Back to Inventory List</a>
</body>

</html>