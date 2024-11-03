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
$acquisition_value = '';
$location = '';
$status_options = [
    "directing" => "Directing",
    "idle" => "Idle",
    "perbaikan" => "Perbaikan",
    "usul hapus" => "Usul hapus",
    "ketinggalan" => "Ketinggalan Teknologi"
];
$lab_id = '';

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
        $acquisition_value =  $asset['acquisition_value'];
        $location = $asset['location'];
        $lab_id = $asset['lab_id'];
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
    $status = $_POST['statuse'];
    $description = $_POST['description'];
    $asset_class = $_POST['asset_class'];
    $acquisition_date = $_POST['acquisition_date'];
    $acquisition_value = $_POST['acquisition_value'];
    $location = $_POST['location'];
    $lab_id = $asset['lab_id'];
    // Tambah aset baru
    if (!$id) {
        $stmt = $pdo->prepare("INSERT INTO Assets (area_id, puserif_number, puslibtang_number,status , name, description, asset_class, acquisition_date, acquisition_value, location, lab_id) VALUES (:area_id, :puserif_number, :puslibtang_number, :status ,:name, :description, :asset_class, :acquisition_date, :acquisition_value, :location,  :lab_id)");
        $stmt->execute([
            'area_id' => $area_id,
            'puserif_number' => $puserif_number,
            'puslibtang_number' => $puslibtang_number,
            'name' => $name,
            'status' => $status,
            'description' => $description,
            'asset_class' => $asset_class,
            'acquisition_date' => $acquisition_date,
            'acquisition_value' => $acquisition_value,
            'location' => $location,
        ]);
        echo "Asset added successfully.";
    } else {
        // Update aset
        $stmt = $pdo->prepare("UPDATE Assets SET area_id = :area_id, puserif_number = :puserif_number, puslibtang_number = :puslibtang_number, status = :status, name = :name, description = :description, asset_class = :asset_class, acquisition_date = :acquisition_date, acquisition_value = :acquisition_value, location = :location , lab_id = :lab_id WHERE asset_id = :id");
        $stmt->execute([
            'area_id' => $area_id,
            'puserif_number' => $puserif_number,
            'puslibtang_number' => $puslibtang_number,
            'name' => $name,
            'status' => $status,
            'description' => $description,
            'asset_class' => $asset_class,
            'acquisition_date' => $acquisition_date,
            'acquisition_value' => $acquisition_value,
            'location' => $location,
            'lab_id' => $lab_id,
            'id' => $id,
        ]);
        echo "Asset updated successfully.";
    }
    echo '<script type="text/javascript">window.location.href = "asset_list.php";</script>';
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
                                <?php
                                foreach ($areas as $area) {
                                    echo '<option value="' . $area['area_id'] . '" ' . ($area['area_id'] == $area_id ? 'selected' : '') . '>';
                                    echo $area['area_code'] . ' - ' . $area['area_name'];
                                    echo '</option>';
                                }
                                ?>
                            </select>

                        </div>
                        <div class="form-group">
                            <label>Puserif Number:</label>
                            <input type="number" name="puserif_number" value="<?= htmlspecialchars($puserif_number) ?>" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Puslibtang Number:</label>
                            <input type="number" name="puslibtang_number" value="<?= htmlspecialchars($puslibtang_number) ?>" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Name:</label>
                            <input type="text" name="name" value="<?= htmlspecialchars($name) ?>" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label>Status:</label>
                            <select name="statuse" class="form-control">
                                <option>Pilih Status</option>

                                <?php
                                foreach ($status_options as $value => $label) {
                                    echo '<option value="' . $value . '" ' . ($status == $value ? 'selected' : '') . '>' . $label . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Description:</label>
                            <textarea name="description" class="form-control" required><?= htmlspecialchars($description) ?></textarea>
                        </div>
                        <div class="form-group">
                            <label>Lab:</label>
                            <select name="lab_id" class="form-control" required>
                                <option value="">Select a Lab</option>
                                <?php foreach ($labs as $lab): ?>
                                    <option value="<?= $lab['lab_id'] ?>" <?= $lab_id == $lab['lab_id'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($lab['lab_name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Asset Class:</label>
                            <input type="number" name="asset_class" value="<?= htmlspecialchars($asset_class) ?>" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Acquisition Date:</label>
                            <input type="date" name="acquisition_date" value="<?= htmlspecialchars($acquisition_date) ?>" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Acquisition Value:</label>
                            <input type="number" name="acquisition_value" value="<?= htmlspecialchars($acquisition_value) ?>" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Location:</label>
                            <input type="text" name="location" value="<?= htmlspecialchars($location) ?>" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-success">
                                <i class="fa fa-paper-plane"></i> <?php $id ? 'Update' : 'Add' ?> Asset
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