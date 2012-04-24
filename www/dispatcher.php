<?php
// ce code n'est sûrement pas fonctionnel pour le moment, faut voir comment le changer, mais plus tard...
// nb: penser à changer la cible de fiche_adherent.php
switch($_POST['action'])
  {
  case "Valider":
  case "Valider la préinscription":
    include('chgadh.php');
    break;
  case "Annuler":
    include('../php-include/common-includes.php');
    if ($_POST['numcbde'] == $userinfo['numcbde'])
      {
	header('Location: moncompte.php');
      }
    else
      {
	header('Location: adherents.php?numcbde='.$_POST['numcbde']);
      }
    break;
  default:
    include('moncompte.php');
  }
?>
