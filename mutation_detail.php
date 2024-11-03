<?php
session_start();
require 'config/db.php';

// Periksa sesi pengguna
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Mendapatkan `mutation_id` dari parameter URL
$mutation_id = $_GET['mutation_id'] ?? null;

if (!$mutation_id) {
    echo "Mutation ID is missing.";
    exit;
}

// Mendapatkan detail semua aset yang memiliki `mutation_id` yang sama
$stmt = $pdo->prepare("
    SELECT am.*, a.name AS asset_name 
    FROM Asset_Mutations am
    JOIN Assets a ON am.asset_id = a.asset_id
    WHERE am.mutation_id = :mutation_id
");
$stmt->execute(['mutation_id' => $mutation_id]);
$mutationDetails = $stmt->fetchAll(PDO::FETCH_ASSOC);
include('templates/top.php');
?>
<section class="content">
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Asset Mutation</h3>
            <div class="pull-right">
                <a href="asset_form.php" class="btn btn-primary btn-flat">
                    <i class="fa fa-user-plus"></i> Add Assets Mutation
                </a>
            </div>
        </div>
        <div class="box-body table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Asset ID</th>
                        <th>Asset Name</th>
                        <th>Mutation Date</th>
                        <th>Physical Mutation</th>
                        <th>Currency Mutation</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($mutationDetails as $detail): ?>
                        <tr>
                            <td><?= htmlspecialchars($detail['asset_id']) ?></td>
                            <td><?= htmlspecialchars($detail['asset_name']) ?></td>
                            <td><?= htmlspecialchars($detail['mutation_date']) ?></td>
                            <td><?= htmlspecialchars($detail['physical_mutation']) ?></td>
                            <td><?= htmlspecialchars($detail['currency_mutation']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>
<?php
include 'templates/bottom.php';
