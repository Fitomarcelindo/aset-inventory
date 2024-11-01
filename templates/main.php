<!-- main.php -->
<?php

// declare(strict_types=1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

require_once 'includes/head.php';

$content = $content ?? '';
?>

<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
        <?php
        if (file_exists('includes/header.php')) {
            include_once 'includes/header.php';
        } else {
            echo '<p>Error: header.php not found.</p>';
        }

        if (file_exists('includes/sidebar.php')) {
            include_once 'includes/sidebar.php';
        } else {
            echo '<p>Error: sidebar.php not found.</p>';
        }
        ?>

        <div class="content-wrapper">
            <?= htmlspecialchars($content, ENT_QUOTES, 'UTF-8') ?>
        </div>

        <?php
        if (file_exists('includes/footer.php')) {
            include_once 'includes/footer.php';
        } else {
            echo '<p>Error: footer.php not found.</p>';
        }
        ?>
    </div>

    <script src="assets/bower_components/jquery/dist/jquery.min.js"></script>
    <script src="assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="assets/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
    <script src="assets/dist/js/adminlte.min.js"></script>
    <script src="assets/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="assets/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#table1').DataTable();
        });
    </script>
</body>