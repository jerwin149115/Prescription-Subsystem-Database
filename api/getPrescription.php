<?php
require '../config/db.php';

header('Access-Control-Allow-Origin: http://localhost:5173');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
header('Access-Control-Allow-Credentials: true');
header('Content-Type: application/json');

if (isset($_GET['patientId']) && is_numeric($_GET['patientId'])) {
    $patientId = $_GET['patientId'];

    $stmt = $db->prepare("SELECT * FROM prescriptions WHERE patientId = ? ORDER BY created_at DESC");
    $stmt->bind_param("i", $patientId); 
    $stmt->execute();

    $result = $stmt->get_result();
    $prescriptions = $result->fetch_all(MYSQLI_ASSOC);

    if (count($prescriptions) > 0) {
        echo json_encode($prescriptions);
    } else {
        echo json_encode(["message" => "No prescription found for the given patient ID"]);
    }

    $stmt->close();
} else {
    echo json_encode(["error" => "patientId is required and must be numeric"]);
}

$db->close();
