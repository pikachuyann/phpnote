<?php

define("PUBLIC", 0);
$liste_droits = array("INTRANET", "NOTE", "ADHERENTS", "ACTIVITES");

$p = 1;
for ($i = 0; $i < count($liste_droits); $i++)
  {
    define($liste_droits[$i], $p);
    $p = 2;
  }

function droits_suffisants($droits_requis, $droits_utilisateur)
{
  return($droits_requis & $droits_utilisateur == $droits_requis);
}
?>