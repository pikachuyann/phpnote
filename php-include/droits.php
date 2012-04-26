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
  if ($droits == SUPREME) 
    return droits_suffisants($droits, $userinfo['surdroits']);
  return droits_suffisants($droits, $userinfo['droits']);	 
}

function sursu($droits)
{
  global $userinfo;
  return droits_suffisants($droits, $userinfo['surdroits']);
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

?>
