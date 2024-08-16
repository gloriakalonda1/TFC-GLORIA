<?php

class ControlleurGenerateur {
    private $data;
    private $name;

    public function __construct($data, $name) {
        $this->data = $data;
        $this->name = $name;
    }

    public function generateController($operation, $methodName = 'POST', $modelName = '', $bddName = 'bdd') {
        $modelName = '../src/model/' . $this->name . 'Model.php';
        $controller_code = "<?php\n\n";
        $controller_code .= "// Controleur\n\n";

        $controller_code .= "// Inclure le fichier bdd.php\n";
        $controller_code .= "require_once '{$bddName}.php';\n\n";

        $controller_code .= "// Inclure le fichier model.php\n";
        $controller_code .= "require_once '{$modelName}.php';\n\n";

        if ($operation == 'create') {
            $controller_code .= "if (\$_SERVER['REQUEST_METHOD'] === '{$methodName}') {\n\n";
            $controller_code .= "  // Créer une instance de la classe model\n";
            $controller_code .= "  \$model = new Model();\n\n";
            foreach ($this->data as $item) {
                $controller_code .= "  \$model->set".ucfirst($item[0])."(\$_POST['".$item[0]."']);\n";
            }
            $controller_code .= "  // Créer une instance de la classe bdd\n";
            $controller_code .= "  \$bdd = new Bdd();\n\n";
            $controller_code .= "  // Insérer les données dans la bdd \n";
            $controller_code .= "  \$bdd->insererDonnees(\$model, 'table');\n\n";
            $controller_code .= "}\n\n";
        } elseif ($operation == 'delete') {
            $controller_code .= "if (\$_SERVER['REQUEST_METHOD'] === '{$methodName}') {\n\n";
            $controller_code .= "  // Créer une instance de la classe bdd\n";
            $controller_code .= "  \$bdd = new Bdd();\n\n";
            $controller_code .= "  // Supprimer les données de la bdd \n";
            $controller_code .= "  \$bdd->supprimerDonnees(\$_POST['id'], 'table');\n\n";
            $controller_code .= "}\n\n";
        } elseif ($operation == 'edit') {
            $controller_code .= "if (\$_SERVER['REQUEST_METHOD'] === '{$methodName}') {\n\n";
            $controller_code .= "  // Créer une instance de la classe model\n";
            $controller_code .= "  \$model = new Model();\n\n";
            foreach ($this->data as $item) {
                $controller_code .= "  \$model->set".ucfirst($item[0])."(\$_POST['".$item[0]."']);\n";
            }
            $controller_code .= "  // Créer une instance de la classe bdd\n";
            $controller_code .= "  \$bdd = new Bdd();\n\n";
            $controller_code .= "  // Mettre à jour les données dans la bdd \n";
            $controller_code .= "  \$bdd->mettreAJourDonnees(\$model, 'table');\n\n";
            $controller_code .= "}\n\n";
        }

        return $controller_code;
    }
}

?>
