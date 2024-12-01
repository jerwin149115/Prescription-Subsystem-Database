<?php

require '../config/db.php';

header('Access-Control-Allow-Origin: http://localhost:5173'); 
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
header('Access-Control-Allow-Credentials: true'); 
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['doctorName'], $data['patientName'], $data['medicine'], $data['dosage'], $data['patientId'])) {
    echo json_encode(['error' => 'Invalid input']);
    exit;
}

try {
    $stmt = $db->prepare("INSERT INTO Prescriptions (patientId, patientName, doctorName, medicine, dosage, created_at) VALUES (?, ?, ?, ?, ?, NOW())");
    
    if (!$stmt) {
        throw new Exception("Preparation failed: " . $db->error);
    }
    
    $stmt->bind_param("issss", 
        $data['patientId'], 
        $data['patientName'], 
        $data['doctorName'], 
        $data['medicine'], 
        $data['dosage']
    );
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'id' => $db->insert_id]);
    } else {
        throw new Exception("Execution failed: " . $stmt->error);
    }

} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
