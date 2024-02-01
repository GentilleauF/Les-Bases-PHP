<?php
//J'active ma super global $_SESSION
session_start();

//Je détruis les données de ma super global => ça me déconnecte
session_destroy();

//Redirection vers la page index.php
header('Location: ./index.php');
exit;
?>