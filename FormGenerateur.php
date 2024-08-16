<?php

class Form {
    private $data;

    public function __construct($data) {
        $this->data = $data;
    }

    public function input(string $type, string $label, string $value) {
        return "<div class='form-group'>
            <label for='field{$value}'>{$label}</label>
            <input type='$type' id='field{$value}' class='' name='{$label}' value='{$value}' required>
            </div>";
    }

    public function generateForm(
        string $action = 'controller.php',
        string $submit = 'submit',
        string $method = 'post'
    ) {
        $input = '';
        $noms_champs = array_keys($this->data); 
        $champCache = "<input type='hidden' name='noms_champs' value='" . implode(',', $noms_champs) . "'>";
        
        foreach ($this->data as $table => $fields) {
            $input .= "<h2>Table: $table</h2> \n";
            foreach ($fields as $field) {
                $type = $field[1];
                if($type == 'varchar(255)'){
                    $type = 'text';
                }else if($type == 'int'){
                    $type = 'number';
                }
                $input .= $this->input($type, $field[0], $field[0]);
            }
        }

        return <<<HTML
        <!DOCTYPE html>
        <html lang="fr">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" href="style.css">
            <title>Document</title>
        </head>
        <body>
            <div class='div'>
                <form action='$action' method='$method'>
                    <h1>Formulaire</h1>
                    $input
                    $champCache
                    <button type='submit'>$submit</button>
                </form>
            </div>
        </body>
        </html>
        HTML;
    }
}

