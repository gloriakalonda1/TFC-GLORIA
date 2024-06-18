<?php
// Configuration de la connexion à la base de données
$host = 'localhost';
$dbname = '';
$user = 'root';
$mdp = '';

try {
    // Connexion au serveur MySQL avec PDO
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $mdp);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Récupérer les bases de données
    $sql = "SHOW DATABASES";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $databases = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($databases) > 0) {
        echo "<h1>Listes des Bases de Données</h1>";
        echo "<ul>";
        foreach ($databases as $row) {
            echo "<li><a href='table.php?bdd=" . $row['Database'] . "'>" . $row['Database'] . "</a></li>";
        }
        echo "</ul>";
    } else {
        echo "Aucune base de données trouvée";
    }
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
