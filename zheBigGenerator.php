<?php

// Controleur

header('Content-Type: application/json');
require_once '../src/composant/FormGenerateur.php';
require_once '../src/composant/ControlleurGenerateur.php';
require_once '../src/composant/ModelGenerateur.php';
require_once '../src/composant/BddGenerateur.php';
require_once '../src/composant/ViewGenerateur.php';


$style = <<<HTML
body{
    background-color: #f1f1f1;
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
}
.div{
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}
input{
    padding: 10px;
    margin-bottom: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
}
button{
    padding: 10px 20px;
    background-color: #333;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}
button:hover{
    background-color: #555;
}
HTML;


try {
    $input = json_decode(file_get_contents('php://input'), true);

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && $input !== null) {
        $data = $input;
    } else {
        $data = $_GET;
    }

    $transformedData = [];

    foreach ($data as $key => $value) {
        if (strpos($key, 'GT') === 0) {
            $tableName = substr($key, 2);
            $fields = [];
    
            foreach ($value as $field) {
                $parts = explode('|', $field);
                if (count($parts) == 2) {
                    $fields[] = [$parts[0], $parts[1]];
                }
            }
    
            $transformedData[$tableName] = $fields;
        }
    }

    foreach ($transformedData as $key => $value) {
        $controller = new ControlleurGenerateur($value, $key);
        $model = new ModelGenerateur($value, $key);
        $view = new ViewGenerateur($value, $key);
    
        // Générer les fichiers
        generatFile($controller->generateController($_GET['operation']), $key . 'Controller.php', 'controller');
        generatFile($model->generateModel(), $key . 'Model.php', 'model');
        generatFile($view->generateView($_GET['operation']), $key . 'View.php', 'view');  // Assuming you want to generate a view
    }

    $form = new Form($transformedData);
    $bdd = new BddGenerateur($input);

    generatFile($form->generateForm(), 'index.php');
    generatFile($style, 'style.css', 'styles');
    generatFile($bdd->generateBdd(), 'bdd.php');
    
    echo json_encode(['data' => $transformedData]);
    exit();

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}

function generatFile($data, $fileName, $type = null) {
    $baseDir = '../Generate';
    
    if ($type === 'controller') {
        $dir = "$baseDir/src/controller";
    } elseif ($type === 'model') {
        $dir = "$baseDir/src/model";
    } elseif ($type === 'view') {
        $dir = "$baseDir/src/view";
    } else {
        $dir = $baseDir;
    }

    if (!file_exists($dir)) {
        mkdir($dir, 0777, true);
    }

    file_put_contents("$dir/$fileName", $data);
}
