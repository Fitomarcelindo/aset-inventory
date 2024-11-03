<?php
session_start();
require 'config/db.php';

// Pastikan hanya admin yang dapat mengakses halaman ini
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
$areas = $pdo->query("SELECT area_name, area_id, area_code FROM areas")->fetchAll(PDO::FETCH_ASSOC);
$labs = $pdo->query("SELECT lab_name, lab_id FROM labs")->fetchAll(PDO::FETCH_ASSOC);
// Mendapatkan daftar aset dari database
$status_options = [
    "directing" => "Directing",
    "idle" => "Idle",
    "perbaikan" => "Perbaikan",
    "usul hapus" => "Usul hapus",
    "ketinggalan" => "Ketinggalan Teknologi"
];
$lab_id = '';

$sql = "SELECT areas.area_name , labs.lab_name , assets.*  FROM assets join areas on assets.area_id = areas.area_id  JOIN labs on assets.lab_id = labs.lab_id where status != 'removed'";
if (!empty($area_id)) {
    $sql .= " AND areas.area_id = :area_id";
}
if (!empty($lab_id)) {
    $sql .= " AND labs.lab_id = :lab_id";
}
if (!empty($status)) {
    $sql .= " AND assets.status = :status";
}

$stmt = $pdo->prepare($sql);

// Bind parameter filter jika ada
if (!empty($area_id)) {
    $stmt->bindValue(':area_id', $area_id);
}
if (!empty($lab_id)) {
    $stmt->bindValue(':lab_id', $lab_id);
}
if (!empty($status)) {
    $stmt->bindValue(':status', $status);
}

$stmt->execute();
$assets = $stmt->fetchAll(PDO::FETCH_ASSOC);
include('templates/top.php');
?>

<section class="content-header">
    <h1>Aset
        <small>Tabel Asset</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="asset_list.php"><i class="fa fa-dashboard"></i></a></li>
        <li class="active">Aset</li>
    </ol>
</section>


<!-- Main content -->
<section class="content">

    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Aset</h3>
            <div class="pull-right">
                <a href="asset_form.php" class="btn btn-primary btn-flat">
                    <i class="fa fa-user-plus"></i> Add Assets
                </a>
            </div>
            <form method="GET" action="asset_list.php">
                <div class="form-group">
                    <!-- Filter untuk Area -->
                    <select name="area_name" class="form-control">
                        <option>Pilih Area</option>
                        <?php
                        foreach ($areas as $area) {
                            echo '<option value="' . $area['area_id'] . '" ' . ($area['area_id'] == $area_id ? 'selected' : '') . '>';
                            echo $area['area_code'] . ' - ' . $area['area_name'];
                            echo '</option>';
                        }
                        ?>
                    </select>

                    <!-- Filter untuk Lab -->

                    <select name="lab_id" class="form-control" required>
                        <option value="">Select a Lab</option>
                        <?php foreach ($labs as $lab): ?>
                            <option value="<?= $lab['lab_id'] ?>" <?= $lab_id == $lab['lab_id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($lab['lab_name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>

                    <!-- Filter untuk Status -->
                    <select name="status" class="form-control">
                        <option value="">Select Status</option>
                        <option>Pilih Status</option>

                        <?php
                        foreach ($status_options as $value => $label) {
                            echo '<option value="' . $value . '" ' . ($status == $value ? 'selected' : '') . '>' . $label . '</option>';
                        }
                        ?>
                    </select>

                    <button type="submit" class="btn btn-info">Filter</button>
                    <a href="export.php?<?= http_build_query($_GET) ?>" class="btn btn-success">Export to Excel</a>
                </div>
            </form>

        </div>
        <div class="box-body table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Bidang Area</th>
                        <th>Puserif Number</th>
                        <th>Puslibtang Number</th>
                        <th>Name</th>
                        <th>Status</th>
                        <th>Description</th>
                        <th>Asset Labs</th>
                        <th>Asset Class</th>
                        <th>Acquisition Date</th>
                        <th>Location</th>
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
                            <td><?= htmlspecialchars($asset['status']) ?></td>
                            <td><?= htmlspecialchars($asset['description']) ?></td>
                            <td><?= htmlspecialchars($asset['lab_name']) ?></td>
                            <td><?= htmlspecialchars($asset['asset_class']) ?></td>
                            <td><?= htmlspecialchars($asset['acquisition_date']) ?></td>
                            <td><?= htmlspecialchars($asset['location']) ?></td>
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
include 'templates/bottom.php'; // Include the main layout template
?>