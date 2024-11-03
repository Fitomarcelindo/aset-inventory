<?php
session_start();
require 'config/db.php';

// Periksa sesi pengguna
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Mendapatkan daftar laboratorium dari database
$stmt = $pdo->prepare("SELECT * FROM Labs");
$stmt->execute();
$labs = $stmt->fetchAll(PDO::FETCH_ASSOC);
include('templates/top.php');
?>
<section class="content">

    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Labs</h3>
            <div class="pull-right">
                <a href="lab_form.php" class="btn btn-primary btn-flat">
                    <i class="fa fa-user-plus"></i> Add Labs
                </a>
            </div>
        </div>
        <div class="box-body table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Lab ID</th>
                        <th>Lab Name</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($labs as $lab): ?>
                        <tr>
                            <td><?= htmlspecialchars($lab['lab_id']) ?></td>
                            <td><?= htmlspecialchars($lab['lab_name']) ?></td>
                            <td>
                                <a href="lab_form.php?id=<?= $lab['lab_id'] ?>">Edit</a>
                                <a href="delete_lab.php?id=<?= $lab['lab_id'] ?>" onclick="return confirm('Are you sure?')">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>
<?php
include 'templates/bottom.php'; // Include the main layout template
?>