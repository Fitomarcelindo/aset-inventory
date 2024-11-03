<?php
session_start();
require 'config/db.php';

// Periksa sesi pengguna
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$id = $_GET['id'] ?? null;
$lab_name = '';

// Jika ada ID, artinya ini adalah halaman edit
if ($id) {
    $stmt = $pdo->prepare("SELECT * FROM Labs WHERE lab_id = :id");
    $stmt->execute(['id' => $id]);
    $lab = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($lab) {
        $lab_name = $lab['lab_name'];
    } else {
        echo "Lab not found.";
        exit;
    }
}

// Proses form untuk tambah atau update laboratorium
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $lab_name = $_POST['lab_name'];

    if (!$id) {
        // Tambah laboratorium baru
        $stmt = $pdo->prepare("INSERT INTO Labs (lab_name) VALUES (:lab_name)");
        $stmt->execute(['lab_name' => $lab_name]);
        echo "Lab added successfully.";
    } else {
        // Update laboratorium
        $stmt = $pdo->prepare("UPDATE Labs SET lab_name = :lab_name WHERE lab_id = :id");
        $stmt->execute(['lab_name' => $lab_name, 'id' => $id]);
        echo "Lab updated successfully.";
    }

    header("Location: lab_list.php");
    exit;
}
include('templates/top.php');
?>

<section class="content-header">
    <h1>Aset
        <small>Tabel Asset</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i>Aset</a></li>
        <li class="active"> Aset</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Add Assets</h3>
            <div class="pull-right">
                <a href="lab_list.php" class="btn btn-warning btn-flat">
                    <i class="fa fa-undo"></i> Back
                </a>
            </div>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-md-4 col-md-offset-4">
                    <form method="post">
                        <div class="form-group">
                            <label>Lab Name:</label>
                            <input type="text" name="lab_name" class="form-control" value="<?= htmlspecialchars($lab_name) ?>" required>
                            <br><br>
                            <button type="submit"><?= $id ? 'Update' : 'Add' ?> Lab</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
</section>

<?php
include 'templates/bottom.php'; // Include the main layout template
?>