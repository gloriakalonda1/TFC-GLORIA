<?php

class BddGenerateur{

    private $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function generateBdd(
        $bddName = 'bdd',
        $host = 'localhost',
        $dbname = 'test',
        $username = 'root',
        $password = ''
    ){
        // Les données envoyées par le contrôleur sont sous forme de tableau
        // [['name', 'type'], ['name', 'type']]
        $dbname = $this->data['bdds'];


        $bdd_code = "<?php\n\n";
        $bdd_code .= "// Bdd\n\n";
        $bdd_code .= "// Création de la class\n";
        $bdd_code .= "class Bdd {\n\n";
        $bdd_code .= "  // Initialiser les propriétés de la classe\n";
        $bdd_code .= "  private \$bdd;\n";
        $bdd_code .= "  private \$host;\n";
        $bdd_code .= "  private \$dbname;\n";
        $bdd_code .= "  private \$username;\n";
        $bdd_code .= "  private \$password;\n\n";

        $bdd_code .= "  // Initialisation du constructeur\n";
        $bdd_code .= "  public function __construct() {\n";
        $bdd_code .= "    \$this->host = '$host';\n";
        $bdd_code .= "    \$this->dbname = '$dbname';\n";
        $bdd_code .= "    \$this->username = '$username';\n";
        $bdd_code .= "    \$this->password = '$password';\n";
        $bdd_code .= "    \$this->connexionBdd();\n";
        $bdd_code .= "  }\n\n";

        $bdd_code .= "  // Initialisation de la méthode pour insérer les données\n";
        $bdd_code .= "  public function insererDonnees(\$donnees, \$table) {\n";
        $bdd_code .= "    \$sql = \"INSERT INTO \$table (\";\n";
        $bdd_code .= "    \$sql .= implode(\", \", array_keys(\$donnees));\n";
        $bdd_code .= "    \$sql .= \") VALUES (:\";\n";
        $bdd_code .= "    \$sql .= implode(\", :\", array_keys(\$donnees));\n";
        $bdd_code .= "    \$sql .= \")\";\n";
        $bdd_code .= "    \$stmt = \$this->bdd->prepare(\$sql);\n";
        $bdd_code .= "    \$stmt->execute(\$donnees);\n";
        $bdd_code .= "  }\n\n";

        $bdd_code .= "  // Initialisation de la méthode pour mettre à jour les données\n";	
        $bdd_code .= "  public function mettreAJourDonnees(\$donnees, \$table) {\n";
        $bdd_code .= "    \$sql = \"UPDATE \$table SET \";\n";
        $bdd_code .= "    \$sql .= implode(\", :\", array_keys(\$donnees));\n";
        $bdd_code .= "    \$sql .= \" = :\";\n";
        $bdd_code .= "    \$sql .= implode(\", :\", array_keys(\$donnees));\n";
        $bdd_code .= "    \$sql .= \" WHERE id = :id\";\n";
        $bdd_code .= "    \$stmt = \$this->bdd->prepare(\$sql);\n";
        $bdd_code .= "    \$stmt->execute(\$donnees);\n";
        $bdd_code .= "  }\n\n";

        $bdd_code .= "  // Initialisation de la méthode pour recuperer les données\n";
        $bdd_code .= "  public function recupererDonnees(\$table) {\n";
        $bdd_code .= "    \$sql = \"SELECT * FROM \$table\";\n";
        $bdd_code .= "    \$stmt = \$this->bdd->prepare(\$sql);\n";
        $bdd_code .= "    \$stmt->execute();\n";
        $bdd_code .= "    return \$stmt->fetchAll();\n";
        $bdd_code .= "  }\n\n";

        $bdd_code .= "  // Initialisation de la méthode pour recuperer une donnée\n";
        $bdd_code .= "  public function recupererDonnee(\$id, \$table) {\n";
        $bdd_code .= "    \$sql = \"SELECT * FROM \$table WHERE id = :id\";\n";
        $bdd_code .= "    \$stmt = \$this->bdd->prepare(\$sql);\n";
        $bdd_code .= "    \$stmt->execute(['id' => \$id]);\n";
        $bdd_code .= "    return \$stmt->fetch();\n";
        $bdd_code .= "  }\n\n";

        $bdd_code .= "  // Initialisation de la méthode pour supprimer une donnée\n";
        $bdd_code .= "  public function supprimerDonnee(\$id, \$table) {\n";
        $bdd_code .= "    \$sql = \"DELETE FROM \$table WHERE id = :id\";\n";
        $bdd_code .= "    \$stmt = \$this->bdd->prepare(\$sql);\n";
        $bdd_code .= "    \$stmt->execute(['id' => \$id]);\n";
        $bdd_code .= "  }\n\n";
        
        $bdd_code .= "  // Initialisation de la méthode pour fermer la connexion\n";
        $bdd_code .= "  public function closeBdd() {\n";
        $bdd_code .= "    \$this->bdd = null;\n";
        $bdd_code .= "  }\n\n";

        $bdd_code .= " // Création de la connexion à la base de données\n";
        $bdd_code .= "  private function connexionBdd() {\n";
        $bdd_code .= "      try {\n";
        $bdd_code .= "          \$this->bdd = new PDO(\"mysql:host=\".\$this->host.\";dbname=\".\$this->dbname, \$this->username, \$this->password);\n";
        $bdd_code .= "          // Activer les erreurs PDO\n";
        $bdd_code .= "          \$this->bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);\n";
        $bdd_code .= "      } catch(PDOException \$e) {\n";
        $bdd_code .= "          echo \"Erreur : \" . \$e->getMessage();\n";
        $bdd_code .= "      }\n";
        $bdd_code .= "  }\n\n";
        $bdd_code .= "}\n\n";

        return $bdd_code;
    }


}