<?php
session_start();
require 'config/db.php';

// Pastikan hanya admin yang dapat mengakses halaman ini
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$id = $_GET['id'] ?? null;
$area_code = '';
$area_name = '';

// Jika ada ID, artinya ini adalah halaman edit area
if ($id) {
    $stmt = $pdo->prepare("SELECT * FROM Areas WHERE area_id = :id");
    $stmt->execute(['id' => $id]);
    $area = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($area) {
        $area_code = $area['area_code'];
        $area_name = $area['area_name'];
    } else {
        echo "Area not found.";
        exit;
    }
}

// Proses form untuk tambah atau update area
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $area_code = $_POST['area_code'];
    $area_name = $_POST['area_name'];

    // Tambah area baru
    if (!$id) {
        $stmt = $pdo->prepare("INSERT INTO Areas (area_code, area_name) VALUES (:area_code, :area_name)");
        $stmt->execute([
            'area_code' => $area_code,
            'area_name' => $area_name,
        ]);
        echo "Area added successfully.";
    } else {
        // Update area
        $stmt = $pdo->prepare("UPDATE Areas SET area_code = :area_code, area_name = :area_name WHERE area_id = :id");
        $stmt->execute([
            'area_code' => $area_code,
            'area_name' => $area_name,
            'area_id' => $id,
        ]);
        echo "Area updated successfully.";
    }

    header("Location: area_list.php");
    exit;
}
?>
<section class="content-header">
    <h1>Areas
        <small>Area</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Areas</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="box">
        <div class="box-header">
            <h3 class="box-title"><?= $id ? 'Edit Area' : 'Add Area' ?></h3>
            <div class="pull-right">
                <a href="area_list.php" class="btn btn-warning btn-flat">
                    <i class="fa fa-undo"></i> Back
                </a>
            </div>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-md-4 col-md-offset-4">
                    <form method="post">
                        <div class="form-group">
                            <label>Area Code:</label>
                            <input type="text" name="area_code" value="<?= htmlspecialchars($area_code) ?>" required>
                            <br>
                        </div>
                        <div class="form-group">
                            <label>Area Name:</label>
                            <input type="text" name="area_name" value="<?= htmlspecialchars($area_name) ?>" required>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-success btn-flat">
                                <i class="fa fa-paper-plane"></i> <?= $id ? 'Update' : 'Add' ?> Area
                            </button>
                            <button type="reset" class="btn btn-flat">Reset</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</section>


<?php
$content = ob_get_clean(); // Get the buffered content into $content
include 'templates/main.php'; // Include the main layout template
?>