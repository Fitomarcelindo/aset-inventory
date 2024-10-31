<!-- main.php -->
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

include_once 'includes/head.php';
?>

<body class="hold-transition skin-blue sidebar-mini">


    <div class="wrapper">
        <?php
        include_once 'includes/header.php';
        include_once 'includes/sidebar.php';
        ?>
        <div class="content-wrapper">
            <!-- This will be the main content section where pages are displayed -->
            <?= $content ?>
        </div>

        <?php include_once 'includes/footer.php'; ?>
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