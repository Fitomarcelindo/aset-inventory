<?php
session_start();
require 'config/db.php';

// Pastikan hanya admin yang dapat mengakses halaman ini
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Mendapatkan daftar aset yang aktif dari tabel Assets
    $stmt = $pdo->prepare("SELECT asset_id, status FROM Assets");
    $stmt->execute();
    $assets = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Menyiapkan laporan di tabel `inventory_evaluations`
    $evaluation_date = date('Y-m-d');
    $report_description = "Inventory evaluation report generated on $evaluation_date";

    // Loop untuk setiap aset dan mencatat laporan
    foreach ($assets as $asset) {
        $status = $asset['status'];

        // Memasukkan data ke tabel `inventory_evaluations`
        $stmt = $pdo->prepare("INSERT INTO Inventory_Evaluations (asset_id, status, comments) VALUES (:asset_id, :status, :comments)");
        $stmt->execute([
            'asset_id' => $asset['asset_id'],
            'status' => $status,
            'comments' => '-'
        ]);

        // Dapatkan `inventory_evaluation_id` yang baru saja dimasukkan
        $inventory_evaluation_id = $pdo->lastInsertId();

        // Catat laporan ke tabel `report_evaluations`
        $stmt = $pdo->prepare("INSERT INTO report_evaluations (inventory_evaluation_id, evaluation_date, description) VALUES (:inventory_evaluation_id, :evaluation_date, :description)");
        $stmt->execute([
            'inventory_evaluation_id' => $inventory_evaluation_id,
            'evaluation_date' => $evaluation_date,
            'description' => $report_description
        ]);
    }
    header("Location: view_inventory_report.php");
    exit;
}
$stmt = $pdo->prepare("SELECT re.report_evaluation_id, re.evaluation_date, re.description as keterangan
                       FROM report_evaluations re
                       ORDER BY re.evaluation_date DESC");
$stmt->execute();
$reports = $stmt->fetchAll(PDO::FETCH_ASSOC);
// echo "Inventory evaluation report generated successfully for $evaluation_date.";
?>

<section class="content-header">
    <h1>Laporan
        <small>Tabel Laporan</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="asset_list.php"><i class="fa fa-dashboard"></i></a></li>
        <li class="active">Laporan</li>
    </ol>
</section>


<!-- Main content -->
<section class="content">
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Laporan</h3>
            <div class="pull-right">
                <form method="post">
                    <button type="submit" class="btn btn-primary btn-flat">
                        <i class="fa fa-user-plus"></i> Add Laporan
                    </button>
                </form>

            </div>
        </div>
        <div class="box-body table-responsive">
            <table class="table table-bordered table-striped" id="table1">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Evaluation Date</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1;
                    foreach ($reports as $report): ?>
                        <tr>
                            <td><?= $no++ ?>.</td>
                            <td><?= htmlspecialchars($report['evaluation_date']) ?></td>
                            <td><?= htmlspecialchars($report['keterangan']) ?></td>
                            <td>
                                <a href="view_inventory_report.php?id=<?= $report['report_evaluation_id'] ?>">View Report</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>
<?php
$content = ob_get_clean(); // Get the buffered content into $content
include 'templates/main.php'; // Include the main layout template
?>