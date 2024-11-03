<?php
session_start();
require 'config/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=assets_export.xls");
header("Pragma: no-cache");
header("Expires: 0");

// Query untuk ekspor data dengan filter
$sql = "SELECT areas.area_name, labs.lab_name, assets.* 
        FROM assets 
        JOIN areas ON assets.area_id = areas.area_id  
        JOIN labs ON assets.lab_id = labs.lab_id 
        WHERE assets.status != 'removed'";

// Tambahkan kondisi filter berdasarkan parameter GET
if (!empty($_GET['area_name'])) {
    $sql .= " AND areas.area_id = :area_id";
}
if (!empty($_GET['lab_id'])) {
    $sql .= " AND labs.lab_id = :lab_id";
}
if (!empty($_GET['status'])) {
    $sql .= " AND assets.status = :status";
}

$stmt = $pdo->prepare($sql);

// Bind parameter berdasarkan filter
if (!empty($_GET['area_name'])) {
    $stmt->bindValue(':area_id', $_GET['area_name']);
}
if (!empty($_GET['lab_id'])) {
    $stmt->bindValue(':lab_id', $_GET['lab_id']);
}
if (!empty($_GET['status'])) {
    $stmt->bindValue(':status', $_GET['status']);
}

$stmt->execute();
$assets = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Output header kolom untuk Excel
echo "No\tBidang Area\tPuserif Number\tPuslibtang Number\tName\tStatus\tDescription\tAsset Labs\tAsset Class\tAcquisition Date\tLocation\n";

// Loop untuk output data
$no = 1;
foreach ($assets as $asset) {
    echo $no++ . "\t";
    echo $asset['area_name'] . "\t";
    echo $asset['puserif_number'] . "\t";
    echo $asset['puslibtang_number'] . "\t";
    echo $asset['name'] . "\t";
    echo $asset['status'] . "\t";
    echo $asset['description'] . "\t";
    echo $asset['lab_name'] . "\t";
    echo $asset['asset_class'] . "\t";
    echo $asset['acquisition_date'] . "\t";
    echo $asset['location'] . "\n";
}
