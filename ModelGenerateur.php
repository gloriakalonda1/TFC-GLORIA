<?php

class ModelGenerateur {
    private $data;
    private $name;

    public function __construct($data, $name)
    {
        $this->data = $data;
        $this->name = $name;
    }

    public function generateModel(){
        // Les données envoyées par le contrôleur sont sous forme de tableau
        // [['name', 'type'], ['name', 'type']]

        $model_code = "<?php\n\n";
        $model_code .= "// Modèle\n\n";
        $model_code .= "// création de la class model pour chaque donnée\n";
        $model_code .= "class Model {\n\n";
        $model_code .= "  // Initialiser les propriétés de la classe\n";

        foreach ($this->data as $item) {
            $model_code .= "  private \$".$item[0].";\n";
        }

        $model_code .= "  // Initialisation de getteur\n";

        foreach ($this->data as $item) {
            $model_code .= "  public function get".ucfirst($item[0])."() {\n";
            $model_code .= "    return \$this->".$item[0].";\n";
            $model_code .= "  }\n\n";
        }

        $model_code .= "  // Initialisation de setteur\n";

        foreach ($this->data as $item) {
            $model_code .= "  public function set".ucfirst($item[0])."(\$".$item[0].") {\n";
            $model_code .= "    \$this->".$item[0]." = \$".$item[0].";\n";
            $model_code .= "  }\n\n";
        }

        $model_code .= "}\n\n";
        $model_code .= "?>";

        return $model_code;
    }
}