<?php
session_start();
require 'config/db.php';

// Periksa sesi pengguna
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Fungsi untuk membuat `mutation_id` unik
function generateUniqueMutationId($pdo)
{
    do {
        $mutation_id = rand(100000, 999999); // Membuat nomor acak antara 100000 dan 999999
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM Asset_Mutations WHERE mutation_id = :mutation_id");
        $stmt->execute(['mutation_id' => $mutation_id]);
        $exists = $stmt->fetchColumn();
    } while ($exists > 0); // Ulangi jika `mutation_id` sudah ada

    return $mutation_id;
}

// Mendapatkan daftar aset dari tabel Assets
$asset_stmt = $pdo->prepare("SELECT asset_id, puserif_number name FROM Assets");
$asset_stmt->execute();
$assets = $asset_stmt->fetchAll(PDO::FETCH_ASSOC);

// Proses form untuk menambahkan mutasi untuk setiap aset
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $mutation_id = generateUniqueMutationId($pdo); // Membuat `mutation_id` unik untuk satu batch mutasi
    $mutation_date = $_POST['mutation_date'];

    foreach ($_POST['assets'] as $asset_id => $data) {
        $physical_mutation = $data['physical_mutation'];
        $currency_mutation = $data['currency_mutation'];

        // Masukkan data mutasi ke database
        $stmt = $pdo->prepare("INSERT INTO Asset_Mutations (mutation_id, asset_id, mutation_date, physical_mutation, currency_mutation) VALUES (:mutation_id, :asset_id, :mutation_date, :physical_mutation, :currency_mutation)");
        $stmt->execute([
            'mutation_id' => $mutation_id,
            'asset_id' => $asset_id,
            'mutation_date' => $mutation_date,
            'physical_mutation' => $physical_mutation,
            'currency_mutation' => $currency_mutation,
        ]);
    }

    echo "Mutations added successfully for all assets.";
    header("Location: mutation_list.php");
    exit;
}
include('templates/top.php');
?>

<section class="content-header">
    <h1>Aset
        <small>Tabel Asset Mutations</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="mutation_list.php"><i class="fa fa-dashboard"></i>Aset Mutasi</a></li>
        <li class="active"> Aset Mutasi Form</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Add Assets</h3>
            <div class="pull-right">
                <a href="mutation_list.php" class="btn btn-warning btn-flat">
                    <i class="fa fa-undo"></i> Back
                </a>
            </div>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-md-4 col-md-offset-4">
                    <form method="post">
                        <div class="form-group">
                            <label>Mutation Date:</label>
                            <input type="date" name="mutation_date" class="form-control" required>
                        </div>
                        <?php foreach ($assets as $asset): ?>
                            <h3>Asset : <?= htmlspecialchars($asset['name']) ?></h3>
                            <div class="form-group">
                                <label>Physical Mutation:</label>
                                <input type="number" name="assets[<?= $asset['asset_id'] ?>][physical_mutation]" value="<?= htmlspecialchars($puserif_number) ?>" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Currency Mutation:</label>
                                <input type="number" name="assets[<?= $asset['asset_id'] ?>][currency_mutation]" value="<?= htmlspecialchars($puserif_number) ?>" class="form-control" required>
                            </div>
                            <br>

                        <?php endforeach; ?>
                        <div class="form-group">
                            <button type="submit" class="btn btn-success">
                                <i class="fa fa-paper-plane"></i> Add Mutations
                            </button>
                            <button type="reset" class="btn btn-flat">Reset</button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
</section>

<?php
include 'templates/bottom.php'; // Include the main layout template
?>