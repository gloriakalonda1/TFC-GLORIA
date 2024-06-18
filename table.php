<?php
// Récupérer la base de données sélectionnée
$db = $_GET['bdd'];

// Configuration de la connexion à la base de données
$host = 'localhost';
$user = 'root';
$mdp = '';

try {
    // Connexion au serveur MySQL avec PDO
    $conn = new PDO("mysql:host=$host;dbname=$db", $user, $mdp);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Récupérer les tables de la base de données
    $sql = "SHOW TABLES";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $tables = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($tables) > 0) {
        echo "<h1>Tables dans la base de données: " . htmlspecialchars($db) . "</h1>";
        echo "<ul>";
        foreach ($tables as $row) {
            $table = $row[array_keys($row)[0]];
            echo "<li><a href='champs.php?db=" . htmlspecialchars($db) . "&table=" . htmlspecialchars($table) . "'>" . htmlspecialchars($table) . "</a></li>";
        }
        echo "</ul>";
    } else {
        echo "Aucune table trouvée dans la base de données " . htmlspecialchars($db);
    }
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
?>
