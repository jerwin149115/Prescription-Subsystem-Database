<?php
require '../config/db.php';
header('Access-Control-Allow-Origin: http://localhost:5173'); 
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
header('Access-Control-Allow-Credentials: true'); 
header('Content-Type: application/json');


$result = $db->query("SELECT * FROM patient ORDER BY created_patient_at DESC");
$patients = $result->fetch_all(MYSQLI_ASSOC);

echo json_encode($patients);
