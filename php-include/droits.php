<?php

define("PUBLIC", 0);
$liste_droits = array("INTRANET", "NOTE", "ADHERENTS", "ACTIVITES", "DROIT_D_ETRE_TOTO", "BUREAU", "INSCRIPTION", "BOUTONS");
// Dans BOUTONS : on range la gestion des Catégories de boutons et des boutons réels

$p = 1;
$s = 0;
for ($i = 0; $i < count($liste_droits); $i++)
  {
    define($liste_droits[$i], $p);
    $s += $p;
    $p *= 2;
  }
define("SUPREME", $s);

function droits_suffisants($droits_requis, $droits_utilisateur)
{
  return(($droits_requis & $droits_utilisateur) == $droits_requis);
}

function su($droits)
{
  global $userinfo;
  return droits_suffisants($droits, $userinfo['droits']);
}

function msg_nondroits($droit)
{
  global $liste_droits;
  $msg = "Vous n'avez pas assez de droits. Pour vous connecter sur cette page, il vous faut le(s) droit(s):<br/>\n";
  $p = 1;
  for ($i = 0; $i < count($liste_droits); $i++)
    {
      if (($droit & $p) == $p)
	$msg = $msg." * ".$liste_droits[$i]."<br/>\n";
      $p *= 2;
    }
  return($msg."Si vous poss&eacute;dez ces droits, reconnectez-vous !<br/>\n");
}

function table_droits($droit)
{
  global $liste_droits, $s;
  $rep = "<table>";
  $p = 1;
  for ($i = 0; $i < count($liste_droits); $i++)
    {
      $rep .= "<tr><td>".$liste_droits[$i].": </td><td>";
      if (($droit && $p) == $p) {
	$rep .= "oui</td></tr>";
      } else {
	$rep .= "non</td></tr>";
      }
      $p *= 2;
    }
  $rep .= "<tr><td>SUPREME</td><td>";
  if (($droit && $s) == $s) {
    $rep .= "oui</td></tr>";
  } else {
    $rep .= "non</td></tr>";
  }
    
  return($rep."</table>");
}
?>
