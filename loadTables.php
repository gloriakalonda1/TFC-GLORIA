<?php
header('Content-Type: application/json');

include '../db.php';

try {
    $tb=[];
    $input = json_decode(file_get_contents('php://input'), true);
    $data = '';
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && $input !== null) {
        $data = $input;
    }else{
        $data = $_GET;
    }

    if (!isset($data['bdds'])) {
        echo json_encode(['error' => 'Missing required parameters']);
        exit;
    }

    $bdds = $data['bdds'];
    $db = new Database($bdds);
    $tables = $db->getTables();

    for ($i = 0; $i < count($tables); $i++) {
        $tb[$i] = $tables[$i][0];
    }

    echo json_encode(['tables' => $tb]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
?>