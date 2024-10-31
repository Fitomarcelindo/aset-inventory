<?php
session_start();
require 'config/db.php';

// Pastikan hanya admin yang dapat mengakses halaman ini
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Mendapatkan daftar ATTB dari database
$stmt = $pdo->prepare("SELECT areas.area_name , assets.*   FROM assets join areas on assets.area_id = areas.area_id where status = 'removed'");
$stmt->execute();
$assets = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<section class="content-header">
    <h1>ATTB
        <small>Tabel ATTB</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="asset_list.php"><i class="fa fa-dashboard"></i></a></li>
        <li class="active">ATTB</li>
    </ol>
</section>


<!-- Main content -->
<section class="content">

    <div class="box">
        <div class="box-header">
            <h3 class="box-title">ATTB</h3>
            <div class="pull-right">
                <a href="asset_form.php" class="btn btn-primary btn-flat">
                    <i class="fa fa-user-plus"></i> Add Assets
                </a>
            </div>
        </div>
        <div class="box-body table-responsive">
            <table class="table table-bordered table-striped" id="table1">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Bidang Area</th>
                        <th>Puserif Number</th>
                        <th>Puslibtang Number</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Asset Class</th>
                        <th>Acquisition Date</th>
                        <th>Location</th>
                        <th>Removed Date</th>
                        <th>Actions</th>

                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1;
                    foreach ($assets as $asset): ?>
                        <tr>
                            <td><?= $no++ ?>.</td>
                            <td><?= htmlspecialchars($asset['area_name']) ?></td>
                            <td><?= htmlspecialchars($asset['puserif_number']) ?></td>
                            <td><?= htmlspecialchars($asset['puslibtang_number']) ?></td>
                            <td><?= htmlspecialchars($asset['name']) ?></td>
                            <td><?= htmlspecialchars($asset['description']) ?></td>
                            <td><?= htmlspecialchars($asset['asset_class']) ?></td>
                            <td><?= htmlspecialchars($asset['acquisition_date']) ?></td>
                            <td><?= htmlspecialchars($asset['location']) ?></td>
                            <td><?= htmlspecialchars($asset['removed_date']) ?></td>
                            <td>
                                <a class="btn btn-primary btn-xs" href="asset_form.php?id=<?= $asset['asset_id'] ?>">Edit</a>
                                <a onclick="return confirm('Apakah Anda yakin hapus data?')" class="btn btn-danger btn-xs" href="delete_asset.php?id=<?= $asset['asset_id'] ?>">Delete</a>
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