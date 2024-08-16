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

    if (!isset($data['bdds']) || !isset($data['tables'])) {
        echo json_encode(['error' => 'Missing required parameters']);
        exit;
    }
      
    $bdds = $data['bdds'];
    $db = new Database($bdds);
    $tables = $data['tables'];
    
    $fields = [];
    
    foreach ($tables as $i => $tableName) {
        $tableFields = $db->getTableFields($tableName); 
        if ($tableFields === false) {
            echo json_encode(['error' => "Error retrieving fields for table: $tableName"]);
            exit;
        }
        
        $fields[$tableName] = $tableFields; 
    }
    
    echo json_encode(['tables' => $fields]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
?>