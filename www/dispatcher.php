<?php
// ce code n'est sûrement pas fonctionnel pour le moment, faut voir comment le changer, mais plus tard...
// nb: penser à changer la cible de fiche_adherent.php
switch($_POST['action'])
  {
  case "Changer le mot de passe": 
    include('chgpass.php');
    break;
  case "Valider":
  case "Valider la pr&eacute;inscription":
    include('chgadh.php');
    break;
  default:
    include('moncompte.php');
  }
?>