<?php
include 'data2.php';
ob_start();
?>


<?php foreach ($USERS_HUMAN as $user) :
?>
    <h2>Nom: <?= $user['name'] ?> </h2>
    <p>Email: <?= $user['email'] ?> </p>
    <p>Age: <?= $user['age'] ?>ans </p>


<?php
endforeach;
$profil = ob_get_clean();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=*, initial-scale=1.0">
    <title></title>
</head>

<body>
    <?= $profil ?>
</body>

</html>