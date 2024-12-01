<?php

require '../config/db.php';

header('Access-Control-Allow-Origin: http://localhost:5173');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
header('Access-Control-Allow-Credentials: true');
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'PUT') {
    echo json_encode(['error' => 'Invalid request method']);
    http_response_code(405); 
    exit;
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : null;

if (!$id) {
    echo json_encode(['error' => 'Missing or invalid patient ID']);
    http_response_code(400); 
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);
if (!$data || !isset($data['patientName'], $data['patientAge'])) {
    echo json_encode(['error' => 'Invalid JSON payload']);
    http_response_code(400);
    exit;
}


$stmt = $db->prepare("UPDATE patient SET patientName = ?, patientAge = ? WHERE patientId = ?");
if (!$stmt) {
    echo json_encode(['error' => 'Failed to prepare statement', 'details' => $db->error]);
    http_response_code(500); 
    exit;
}

$stmt->bind_param("sii", $data['patientName'], $data['patientAge'], $id);
if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['error' => 'Database error', 'details' => $stmt->error]);
    http_response_code(500); 
}
