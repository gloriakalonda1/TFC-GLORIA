<?php
class Database {
    private $host = 'localhost';
    private $dbname = '';
    private $user = 'root';
    private $password = '';
    public $conn;
    public $error;

    public function __construct($dbname = '') {
        $this->dbname = $dbname;
        $dsn = "mysql:host=$this->host" . ($this->dbname ? ";dbname=$this->dbname" : "");
        try {
            $this->conn = new PDO($dsn, $this->user, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            $this->error = "Erreur : " . $e->getMessage();
        }
    }

    public function getDatabases() {
        if ($this->conn) {
            $sql = "SHOW DATABASES";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        return [];
    }

    public function getTables() {
        if ($this->conn && $this->dbname) {
            $sql = "SHOW TABLES";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_NUM);
        }
        return [];
    }

    public function getTableFields($table) {
        if ($this->conn && $this->dbname) {
            $sql = "DESCRIBE $table";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        return [];
    }

    public function createDatabase($dbname) {
        try {
            $sql = "CREATE DATABASE $dbname";
            $this->conn->exec($sql);
            return "Base de données $dbname créée avec succès.";
        } catch (PDOException $e) {
            return "Erreur lors de la création de la base de données : " . $e->getMessage();
        }
    }

    public function createTable($table, $columns) {
        if ($this->conn && $this->dbname) {
            $sql = "CREATE TABLE $table (";
            $cols = [];
            foreach ($columns as $name => $attributes) {
                $cols[] = "$name $attributes";
            }
            $sql .= implode(", ", $cols) . ")";
            try {
                $this->conn->exec($sql);
                return "Table $table créée avec succès.";
            } catch (PDOException $e) {
                return "Erreur lors de la création de la table : " . $e->getMessage();
            }
        }
        return "Erreur de connexion ou base de données non spécifiée.";
    }

    public function addFieldToTable($table, $field, $attributes) {
        if ($this->conn && $this->dbname) {
            $sql = "ALTER TABLE $table ADD $field $attributes";
            try {
                $this->conn->exec($sql);
                return "Champ $field ajouté avec succès à la table $table.";
            } catch (PDOException $e) {
                return "Erreur lors de l'ajout du champ : " . $e->getMessage();
            }
        }
        return "Erreur de connexion ou base de données non spécifiée.";
    }
}
?>
