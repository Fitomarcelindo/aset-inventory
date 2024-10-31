<?php
session_start();
require 'config/db.php';

// Hanya admin yang dapat mengakses halaman ini
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] == 0) {
    echo "Access denied!";
    exit;
}

// Mendapatkan daftar user dari database
$stmt = $pdo->prepare("SELECT id, username, name, address, is_admin FROM Users");
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<section class="content-header">
    <h1>Users
        <small>Pengguna</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Users</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">

    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Data Users</h3>
            <div class="pull-right">
                <a href="user_form.php" class="btn btn-primary btn-flat">
                    <i class="fa fa-user-plus"></i> Add User
                </a>
            </div>
        </div>
        <div class="box-body table-responsive">
            <table class="table table-bordered table-striped" id="table1">

                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Name</th>
                        <th>Address</th>
                        <th>Role</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1;
                    foreach ($users as $user): ?>
                        <tr>
                            <td><?= $no++ ?>.</td>
                            <td><?= htmlspecialchars($user['username']) ?></td>
                            <td><?= htmlspecialchars($user['name']) ?></td>
                            <td><?= htmlspecialchars($user['address']) ?></td>
                            <td><?= $user['is_admin'] ? 'Admin' : 'User' ?></td>
                            <td>
                                <a class="btn btn-primary btn-xs" href="user_form.php?id=<?= $user['id'] ?>">Edit</a>
                                <a onclick="return confirm('Apakah Anda yakin hapus data?')" class="btn btn-danger btn-xs" href="delete_user.php?id=<?= $user['id'] ?>">Delete</a>
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