
<?php
// VARIABLES //
// Une variable peut être redefinie
$maVariable = 12;
$maVariable = [1, 2];
$maVariable = 'Ma premiere variable';
$varC = [[1, 2], [3, 4], [5, 6]];

echo ($maVariable);
// For each dans un foreach pour lire la variable C
foreach ($varC as $tab) {
    foreach ($tab as $row) {
        echo $row . '<br>';
    }
}



?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EXO</title>
</head>

<body>
    <h1>Ma premiere page</h1>

    <?php echo ($maVariable); ?>

    <a href=<?php echo ('http://www.google.fr'); ?>>Lien</a>

    <p>Ma variable est :<?php echo gettype($maVariable); ?></p>

    <h2>CONCATENATION : 3 méthodes</h2>
    <!-- METHODE 1 -->
    <p><?php echo ("Ma concat : $maVariable"); ?></p>

    <!-- METHODE 2 -->
    <p><?php echo ("Ma concat 2 :" . $maVariable); ?></p>

    <!-- METHODE 3 -->
    <p><?php echo ("Ma concat 3 : {$maVariable}"); ?></p>


</body>

</html> #}



