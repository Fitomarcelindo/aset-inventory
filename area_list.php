<?php
session_start();
require 'config/db.php';

// Pastikan hanya admin yang dapat mengakses halaman ini
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Mendapatkan daftar area dari database
$stmt = $pdo->prepare("SELECT * FROM Areas");
$stmt->execute();
$areas = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<section class="content-header">
    <h1>Area
        <small>Tabel Area</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="area_list.php"><i class="fa fa-dashboard"></i></a></li>
        <li class="active">Area</li>
    </ol>
</section>


<!-- Main content -->
<section class="content">

    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Area</h3>
            <div class="pull-right">
                <a href="area_form.php" class="btn btn-primary btn-flat">
                    <i class="fa fa-user-plus"></i> Add Area
                </a>
            </div>
        </div>
        <div class="box-body table-responsive">
            <table class="table table-bordered table-striped" id="table1">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Area Code</th>
                        <th>Area Name</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1;
                    foreach ($areas as $area): ?>
                        <tr>
                            <td><?= $no++ ?>.</td>
                            <td><?= htmlspecialchars($area['area_code']) ?></td>
                            <td><?= htmlspecialchars($area['area_name']) ?></td>
                            <td>
                                <a class="btn btn-primary btn-xs" href="area_form.php?id=<?= $area['area_id'] ?>"> <i class="fa fa-pencil"></i> Update</a>
                                <a href="delete_area.php?id=<?= $area['area_id'] ?>" onclick="return confirm('Apakah Anda yakin hapus data?')" class="btn btn-danger btn-xs"> <i class="fa fa-pencil"></i> Delete</a>
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