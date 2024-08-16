<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="src/styles/sliderPages.css">
    <link rel="stylesheet" href="src/styles/styles.css">
    <title>Generator PHP</title>
</head>

<body>

    <div class="div">
        <div class="div_form">
            <form id="multiStepForm">
                <div class="step">
                    <h2>Voulez vous créer une Base de donné ou utilisé une existante</h2>
                    <div class="step-container">
                        <div class="radio-container control">
                            <label>
                                <input type="radio" name="oldOrNew" value="old" class="radio" checked>
                                <div class="radio-button">
                                    <span>
                                        Avec une base de donnée existante
                                    </span>
                                </div>
                            </label>
                            <label>
                                <input type="radio" name="oldOrNew" value="new" class="radio">
                                <div class="radio-button">
                                    <span>
                                        Avec une nouvelle base de donnée
                                    </span>
                                </div>
                            </label>
                        </div>
                    </div>
                    <button type="button" class="next-btn">Next</button>
                </div>
                <div class="step">
                    <h2></h2>
                    <div class="radio-container control" id="stepD">

                    </div>
                    <div id="stepB">
                        <button type="button" class="prev-btn">Previous</button>
                        <button type="button" class="next-btn">Next</button>
                    </div>
                </div>
                <div class="step">
                    <h2></h2>
                    <div class="radio-container control" id="stepT"></div>
                    <div id="stepB">
                        <button type="button" class="prev-btn">Previous</button>
                        <button type="button" class="next-btn">Next</button>
                    </div>
                </div>
                <div class="step">
                    <h2></h2>
                    <div id="stepC"></div>
                    <div id="stepB">
                        <button type="button" class="prev-btn">Previous</button>
                        <button type="button" class="next-btn">Next</button>
                    </div>
                </div>
                <div class="step">
                    <h2>Récapitulatif !</h2>
                    <div id="stepR"></div>
                    <div id="stepB">
                        <button type="button" class="prev-btn">Previous</button>
                        <button type="submit" class="next-btn">Generer</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        <?php 
            echo 'let operation = "'.$_GET['operation'].'";';
        ?>
    </script>
    <script src="src/styles/script.js"></script>
    <script src="src/styles/sliderPages.js"></script>
</body>

</html>