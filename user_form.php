<?php
session_start();
require 'config/db.php';

// Hanya admin yang dapat mengakses halaman ini
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] == 0) {
    echo "Access denied!";
    exit;
}

$id = $_GET['id'] ?? null;
$username = '';
$name = '';
$password = '';
$address = '';
$is_admin = '';

// Jika ada ID, berarti sedang melakukan edit user
if ($id) {
    $stmt = $pdo->prepare("SELECT * FROM Users WHERE id = :id");
    $stmt->execute(['id' => $id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $username = $user['username'];
        $name = $user['name'];
        $address = $user['address'];
        $is_admin = $user['is_admin'];
    } else {
        echo "User not found.";
        exit;
    }
}

// Proses form untuk tambah atau update user
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $name = $_POST['name'];

    $address = $_POST['address'];
    $is_admin = isset($_POST['is_admin']) ? 1 : 0;

    // Validasi apakah username sudah ada
    $stmt = $pdo->prepare("SELECT id FROM Users WHERE username = :username AND id != :id");
    $stmt->execute(['username' => $username, 'id' => $id ?? 0]);
    if ($stmt->fetch()) {
        echo "Username already exists.";
        exit;
    }

    // Jika sedang menambah user baru
    if (!$id) {
        $password = $_POST['password'];
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO Users (username, name, password, address, is_admin) VALUES (:username, :name, :password, :address, :is_admin)");
        $stmt->execute([
            'username' => $username,
            'name' => $name,
            'password' => $hashedPassword,
            'address' => $address,
            'is_admin' => $is_admin,
        ]);
        echo "User added successfully.";
    } else {
        // Jika sedang mengedit user
        $stmt = $pdo->prepare("UPDATE Users SET username = :username, name = :name, address = :address, is_admin = :is_admin" . " WHERE id = :id");
        $params = [
            'username' => $username,
            'name' => $name,
            'address' => $address,
            'is_admin' => $is_admin,
            'id' => $id,
        ];

        $stmt->execute($params);
        echo "User updated successfully. ";
        echo  $is_admin;
    }

    header("address: user_list.php");
    exit;
}
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
            <h3 class="box-title"><?= $id ? 'Edit User' : 'Add User' ?></h3>
            <div class="pull-right">
                <a href="user_list.php" class="btn btn-warning btn-flat">
                    <i class="fa fa-undo"></i> Back
                </a>
            </div>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-md-4 col-md-offset-4">
                    <form method="post">
                        <div class="form-group">
                            <label>Name *</label>
                            <input type="text" name="name" value="<?= htmlspecialchars($name) ?>" class="form-control" placeholder="Full Name" required>
                        </div>
                        <div class="form-group">
                            <label>Username *</label>
                            <input type="text" name="username" value="<?= htmlspecialchars($username) ?>" class="form-control" required>
                        </div>
                        <?php if (!$id): ?>
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Password Confirmation</label>
                                <input type="password" name="passconf" class="form-control" required>
                            </div>
                        <?php endif; ?>
                        <div class="form-group">
                            <label>Address</label>
                            <textarea name="address" class="form-control"><?= htmlspecialchars($address) ?></textarea>
                        </div>
                        <div class="form-group">
                            <label>Level *</label>
                            <select name="is_admin" class="form-control">
                                <option value="">- Pilih -</option>
                                <option value="1" <?= $is_admin ? "selected" : null ?>>Admin</option>
                                <option value="0" <?= !$is_admin ? "selected" : null ?>>User</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-success btn-flat">
                                <i class="fa fa-paper-plane"></i> <?= $id ? 'Update' : 'Add' ?> User
                            </button>
                            <button type="reset" class="btn btn-flat">Reset</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>


<?php
$content = ob_get_clean(); // Get the buffered content into $content
include 'templates/main.php'; // Include the main layout template
?>