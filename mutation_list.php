<?php
session_start();
require 'config/db.php';

// Periksa sesi pengguna
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Mendapatkan daftar unik `mutation_id` dari tabel AssetMutations
$stmt = $pdo->prepare("SELECT DISTINCT mutation_id, mutation_date FROM Asset_Mutations ORDER BY mutation_date DESC");
$stmt->execute();
$mutations = $stmt->fetchAll(PDO::FETCH_ASSOC);
include('templates/top.php');
?>
<section class="content">

    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Asset Mutation</h3>
            <div class="pull-right">
                <a href="mutation_form.php" class="btn btn-primary btn-flat">
                    <i class="fa fa-user-plus"></i> Add Assets Mutation
                </a>
            </div>
        </div>
        <div class="box-body table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Mutation ID</th>
                        <th>Mutation Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($mutations as $mutation): ?>
                        <tr>
                            <td><?= htmlspecialchars($mutation['mutation_id']) ?></td>
                            <td><?= htmlspecialchars($mutation['mutation_date']) ?></td>
                            <td>
                                <a href=" mutation_detail.php?mutation_id=<?= $mutation['mutation_id'] ?>">View Details</a>
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