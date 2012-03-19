<?php
// Page pour se déconnecter
include('../php-include/common-includes.php');

$req = "DELETE FROM sid WHERE sid.sid='".protect($_COOKIE['sid'])."';";
if ($userinfo['sid'] == $_COOKIE['sid']) 
  // Ca serait drôle de l'enlever pour pouvoir kill les sessions des autres
  mysql_query($req);
setcookie('sid', "", time() - 1);

// Et on redirige vers la page d'acceuil
header('Location: index.php');
?>