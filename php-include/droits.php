<?php

define("PUBLIC", 0);
$liste_droits = array("INTRANET", "NOTE", "ADHERENTS", "ACTIVITES", "DROIT_D_ETRE_TOTO");

$p = 1;
for ($i = 0; $i < count($liste_droits); $i++)
  {
    define($liste_droits[$i], $p);
    $p *= 2;
  }

function droits_suffisants($droits_requis, $droits_utilisateur)
{
  return($droits_requis & $droits_utilisateur == $droits_requis);
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
