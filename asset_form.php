<?php
session_start();
require 'config/db.php';

// Pastikan hanya admin yang dapat mengakses halaman ini
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$id = $_GET['id'] ?? null;
$area_id = '';
$puserif_number = '';
$puslibtang_number = '';
$name = '';
$description = '';
$status = '';
$asset_class = '';
$acquisition_date = '';
$location = '';
// Mendapatkan daftar area dari database
$stmt = $pdo->prepare("SELECT * FROM Areas");
$stmt->execute();
$areas = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Jika ada ID, artinya ini adalah halaman edit aset
if ($id) {
    $stmt = $pdo->prepare("SELECT * FROM Assets WHERE asset_id = :id");
    $stmt->execute(['id' => $id]);
    $asset = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($asset) {
        $area_id = $asset['area_id'];
        $puserif_number = $asset['puserif_number'];
        $puslibtang_number = $asset['puslibtang_number'];
        $name = $asset['name'];
        $status = $asset['status'];
        $description = $asset['description'];
        $asset_class = $asset['asset_class'];
        $acquisition_date = $asset['acquisition_date'];
        $location = $asset['location'];
    } else {
        echo "Asset not found.";
        exit;
    }
}

// Proses form untuk tambah atau update aset
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $area_id = $_POST['area_id'];
    $puserif_number = $_POST['puserif_number'];
    $puslibtang_number = $_POST['puslibtang_number'];
    $name = $_POST['name'];
    $status = $_POST['status'];
    $description = $_POST['description'];
    $asset_class = $_POST['asset_class'];
    $acquisition_date = $_POST['acquisition_date'];
    $location = $_POST['location'];

    // Tambah aset baru
    if (!$id) {
        $stmt = $pdo->prepare("INSERT INTO Assets (area_id, puserif_number, puslibtang_number, name, description, asset_class, acquisition_date, location) VALUES (:area_id, :puserif_number, :puslibtang_number, :name, :description, :asset_class, :acquisition_date, :location)");
        $stmt->execute([
            'area_id' => $area_id,
            'puserif_number' => $puserif_number,
            'puslibtang_number' => $puslibtang_number,
            'name' => $name,
            'status' => $status,
            'description' => $description,
            'asset_class' => $asset_class,
            'acquisition_date' => $acquisition_date,
            'location' => $location,
        ]);
        echo "Asset added successfully.";
    } else {
        // Update aset
        $stmt = $pdo->prepare("UPDATE Assets SET area_id = :area_id, puserif_number = :puserif_number, puslibtang_number = :puslibtang_number, name = :name, description = :description, asset_class = :asset_class, acquisition_date = :acquisition_date, location = :location WHERE asset_id = :id");
        $stmt->execute([
            'area_id' => $area_id,
            'puserif_number' => $puserif_number,
            'puslibtang_number' => $puslibtang_number,
            'name' => $name,
            'status' => $status,
            'description' => $description,
            'asset_class' => $asset_class,
            'acquisition_date' => $acquisition_date,
            'location' => $location,
            'id' => $id,
        ]);
        echo "Asset updated successfully.";
    }

    header("Location: asset_list.php");
    exit;
}
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
                <a href="asset_list.php" class="btn btn-warning btn-flat">
                    <i class="fa fa-undo"></i> Back
                </a>
            </div>
        </div>

        <div class="box-body">
            <div class="row">
                <div class="col-md-4 col-md-offset-4">
                    <form method="post">
                        <div class="form-group">
                            <label>Area:</label>
                            <select name="area_id" class="form-control">
                                <option>Pilih Area</option>

                                <?php foreach ($areas as $area): ?>
                                    <option value="<?= $area['area_id'] ?> " <?php $area['area_id'] == $area_id ? "selected" : null ?>>
                                        <?= $area['area_code'] . " - " . $area['area_name'] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>

                        </div>
                        <div class="form-group">
                            <label>Puserif Number:</label>
                            <input type="text" name="puserif_number" value="<?= htmlspecialchars($puserif_number) ?>" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Puslibtang Number:</label>
                            <input type="text" name="puslibtang_number" value="<?= htmlspecialchars($puslibtang_number) ?>" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Name:</label>
                            <input type="text" name="name" value="<?= htmlspecialchars($name) ?>" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label>Status : </label>
                            <select name="status">
                                <option>Pilih Status</option>

                                <option value="operating">Operating</option>
                                <option value="directing" <?php $status == 'directing' ? 'selected' : null ?>>Directing</option>
                                <option value="idle" <?php $status == 'idle' ? 'selected' : null ?>>Idle</option>
                                <option value="perbaikan" <?php $status == 'perbaikan' ? 'selected' : null ?>>Perbaikan</option>
                                <option value="usul hapus" <?php $status == 'usul hapus' ? 'selected' : null ?>>Usul hapus</option>
                                <option value="ketinggalan" <?php $status == 'ketinggalan' ? 'selected' : null ?>>Ketinggalan Teknologi</option>

                            </select>
                        </div>
                        <div class="form-group">
                            <label>Description:</label>
                            <textarea name="description" class="form-control" required><?= htmlspecialchars($description) ?></textarea>
                        </div>
                        <div class="form-group">
                            <label>Asset Class:</label>
                            <input type="text" name="asset_class" value="<?= htmlspecialchars($asset_class) ?>" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Acquisition Date:</label>
                            <input type="date" name="acquisition_date" value="<?= htmlspecialchars($acquisition_date) ?>" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Location:</label>
                            <input type="text" name="location" value="<?= htmlspecialchars($location) ?>" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-success">
                                <i class="fa fa-paper-plane"></i> <?= $id ? 'Update' : 'Add' ?> Asset
                            </button>
                            <button type="reset" class="btn btn-flat">Reset</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
</section>


<?php
$content = ob_get_clean(); // Get the buffered content into $content
include 'templates/main.php'; // Include the main layout template
?>