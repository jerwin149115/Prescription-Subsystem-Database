<?php

require '../config/db.php';
header('Access-Control-Allow-Origin: http://localhost:5173'); 
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
header('Access-Control-Allow-Credentials: true'); 
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);
if (!isset($data['patientName'], $data['patientAge'])) {
    echo json_encode(['error' => 'Invalid input']);
    exit;
}

$stmt = $db->prepare("INSERT INTO patient (patientName, patientAge, created_patient_at) VALUES (?, ?, NOW())");
$stmt->bind_param("si", $data['patientName'], $data['patientAge']);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'id' => $db->insert_id]);
} else {
    echo json_encode(['error' => 'Database error']);
}