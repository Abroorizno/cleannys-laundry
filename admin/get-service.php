<?php
include '../db/koneksi.php';

$ID = isset($_GET['id_service']) ? $_GET['id_service'] : "";

$sql = mysqli_query($conn, "SELECT * FROM services WHERE id = $ID");
$result = mysqli_fetch_assoc($sql);

$response = ['status' => 'success', 'message' => 'success', 'data' => $result];
echo json_encode($response);
