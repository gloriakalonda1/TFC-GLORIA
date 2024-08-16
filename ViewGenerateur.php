<?php


class ViewGenerateur {
    private $data;
    private $name;

    public function __construct($data, $name)
    {
        $this->data = $data;
        $this->name = $name;
    }

    public function generateView(
        $operation,
        $viewName = 'view',
        $modelName = '',
        $bddName = 'bdd',
    ){
        // Les données envoyées par le contrôleur sont sous forme de tableau
        // [['name', 'type'], ['name', 'type']]

        $modelName = '../src/model/' . $this->name . 'Model.php';

        $view_code = "<?php\n\n";
        $view_code .= "// Vue\n\n";

        $view_code .= "// Inclure le fichier bdd.php\n";
        $view_code .= "require_once '{$bddName}.php';\n\n";

        $view_code .= "// Inclure le fichier model.php\n";
        $view_code .= "require_once '{$modelName}.php';\n\n";

        $view_code .= "// Récupérer les données envoyées par le formulaire\n";
        $view_code .= "if (\$_SERVER['REQUEST_METHOD'] === 'GET') {\n\n";

        $view_code .= "  // Créer une instance de la classe model\n";
        $view_code .= "  \$model = new Model();\n\n";

        $view_code .= "  // Parcourir les données envoyées et les insérée dans la bdd \n";
        foreach ($this->data as $item) {
            $view_code .= "\$model->set".ucfirst($item[0])."(\$_GET['".$item[0]."']);\n";
        }

        $view_code .= "  // Créer une instance de la classe bdd\n";
        $view_code .= "  \$bdd = new Bdd();\n\n";     

        if($operation=='create'){
            $view_code .= "  // Inserer les données dans la bdd \n";
            $view_code .= "  \$bdd->InsererDonnees(\$model, 'table');\n\n";

        }else if($operation=='delete'){
            $view_code .= "  // Supprimer les données dans la bdd \n";
            $view_code .= "  \$bdd->supprimerDonnee(\$model, 'table');\n\n";
            
        }else if($operation=='edit'){
            $view_code .= "  // Mettre à jour les données dans la bdd \n";
            $view_code .= "  \$bdd->mettreAJourDonnees(\$model, 'table');\n\n";

        }else{

        }
        

        $view_code .= "}\n\n";
        $view_code .= "?>";

        return $view_code;
    }

}