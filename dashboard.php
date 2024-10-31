<!-- dashboard.php -->
<?php
session_start();
require 'config/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
ob_start(); // Start output buffering

$stmt = $pdo->prepare("
SELECT
    COUNT(asset_id) AS total_asset,
    SUM(CASE WHEN status = 'operating' THEN 1 ELSE 0 END) AS total_asset_operating,
    SUM(CASE WHEN status = 'perbaikan' THEN 1 ELSE 0 END) AS total_asset_rusak,
    SUM(CASE WHEN status = 'idle' THEN 1 ELSE 0 END) AS total_asset_idle
FROM
    assets
");
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
// Konten khusus halaman dashboard
?>
<section class="content-header">
    <h1>Dashboard
        <small>Control Panel</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-aqua"><i class="fa fa-th"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Asset</span>
                    <span class="info-box-number"><?= $result['total_asset']  ?></span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-green"><i class="fa fa-play-circle"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Total Asset Operating</span>
                        <span class="info-box-number"><?= $result['total_asset_operating']  ?></span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-red"><i class="fa fa-wrench"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Total Asset Rusak</span>
                            <span class="info-box-number"><?= $result['total_asset_rusak']  ?></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <div class="info-box">
                            <span class="info-box-icon bg-yellow"><i class="fa fa-pause-circle"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Total Asset Idle</span>
                                <span class="info-box-number"><?= $result['total_asset_idle']  ?></span>
                            </div>
                        </div>
                    </div>
</section>
<?php
$content = ob_get_clean(); // Get the buffered content into $content
include 'templates/main.php'; // Include the main layout template
?>