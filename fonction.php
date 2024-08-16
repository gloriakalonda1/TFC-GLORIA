<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generator</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <div class="container-wrapper">
            <div class="contact-image">
                <img src="style/img.jpg" alt="Contact Image">
                <div class="overlay"></div>
                <div class="contact-text">
                    <h1>Welcomme to my generator</h1>
                    <p>Quel formulaire voulez-vous generer ?</p>
                </div>
            </div>
            <div class="contact-form">
                <h2>Liste des fonctions</h2>
                <ul class="button-list">
                    <li><a href="index.php?operation=create" class="btn">Création</a></li>
                    <li><a href="index.php?operation=delete" class="btn">supression</a></li>
                    <li><a href="index.php?operation=edit" class="btn">modification</a></li>
                    <li><a href="index.php?operation=connexion" class="btn">connexion</a></li>
                </ul>
            </div>

        </div>

    </div>


    <script src="style/script.js"></script>
</body>
</html>
