<?php
session_start();
require 'config/db.php';

// Pastikan hanya admin yang dapat mengakses halaman ini
if (!isset($_SESSION['user_id'])) {
    echo "Access denied!";
    exit;
}

// Mendapatkan tanggal laporan dari parameter GET
$id = $_GET['id'] ?? null;

// Mendapatkan daftar laporan evaluasi untuk tanggal yang ditentukan
$stmt = $pdo->prepare("SELECT  a.asset_id,
                        areas.area_name,
                        a.puserif_number,
                        a.puslibtang_number,
                        a.name,
                        a.description,
                        a.asset_class,
                        a.acquisition_date,
                        a.location,
                        ie.status,
                        ie.comments,
                        aq.quantity_date,
                        aq.quantity,
                        am.mutation_date,
                        am.physical_mutation,
                        am.currency_mutation
                         FROM Assets a
                         JOIN areas ON a.area_id = areas.area_id
                      LEFT JOIN inventory_evaluations ie ON a.asset_id = ie.asset_id
                      LEFT JOIN report_evaluations re ON ie.inventory_evaluation_id = re.inventory_evaluation_id
                        LEFT JOIN asset_quantities aq ON a.asset_id = aq.asset_id
                      LEFT JOIN asset_mutations am ON a.asset_id = am.asset_id
                       WHERE re.report_evaluation_id = :id");
$stmt->execute(['id' => $id]);
$reports = $stmt->fetchAll(PDO::FETCH_ASSOC);
include('templates/top.php');
?>
<h1>Inventory Evaluation Report for </h1>
<table border="1">
    <thead>
        <tr>
            <th>Asset ID</th>
            <th>Area</th>
            <th>Puserif Number</th>
            <th>Puslibtang Number</th>
            <th>Name</th>
            <th>Description</th>
            <th>Asset Class</th>
            <th>Acquisition Date</th>
            <th>Location</th>
            <th>Status</th>
            <th>Comments</th>
            <th>Quantity</th>
            <th>Physical Mutation</th>
            <th>Currency Mutation</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($reports as $report): ?>
            <tr>
                <td><?= htmlspecialchars($report['asset_id']) ?></td>
                <td><?= htmlspecialchars($report['area_name']) ?></td>
                <td><?= htmlspecialchars($report['puserif_number']) ?></td>
                <td><?= htmlspecialchars($report['puslibtang_number']) ?></td>
                <td><?= htmlspecialchars($report['name']) ?></td>
                <td><?= htmlspecialchars($report['description']) ?></td>
                <td><?= htmlspecialchars($report['asset_class']) ?></td>
                <td><?= htmlspecialchars($report['acquisition_date']) ?></td>
                <td><?= htmlspecialchars($report['location']) ?></td>
                <td><?= htmlspecialchars($report['status']) ?></td>
                <td><?= htmlspecialchars($report['comments']) ?></td>
                <td><?= htmlspecialchars($report['quantity']) ?></td>
                <td><?= htmlspecialchars($report['physical_mutation']) ?></td>
                <td><?= htmlspecialchars($report['currency_mutation']) ?></td>

            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<a href="generate_inventory_report.php">Generate New Report</a>
<?php
include 'templates/bottom.php'; // Include the main layout template
?>