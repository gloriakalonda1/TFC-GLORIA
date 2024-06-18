<?php
// Récupérer la base de données et la table sélectionnées
$db = $_GET['db'];
$table = $_GET['table'];

// Configuration de la connexion à la base de données
$host = 'localhost';
$username = 'root';
$password = '';

try {
    // Connexion au serveur MySQL avec PDO
    $conn = new PDO("mysql:host=$host;dbname=$db", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Récupérer les colonnes de la table
    $sql = "SHOW COLUMNS FROM " . $table;
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($columns) > 0) {
        echo "<h1>Colonnes dans la table: " . htmlspecialchars($table) . " (Base de données: " . htmlspecialchars($db) . ")</h1>";
        echo "<ul>";
        foreach ($columns as $row) {
            echo "<li>" . htmlspecialchars($row['Field']) . " - " . htmlspecialchars($row['Type']) . "</li>";
        }
        echo "</ul>";
    } else {
        echo "Aucune colonne trouvée dans la table " . htmlspecialchars($table);
    }
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
?>
