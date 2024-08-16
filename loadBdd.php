<?php
header('Content-Type: application/json');

include '../db.php';

try {
    $db = new Database();
    $databases = $db->getDatabases();

    echo json_encode(['databases' => $databases]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
?>
