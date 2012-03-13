<?php

define("PUBLIC", 0);
$liste_droits = {"INTRANET", "NOTE", "ADHERENTS", "ACTIVITES"};

foreach($i = 0; $i < count($liste_droits); $i++)
  {
    define($liste_droits[$i], pow(2, $i));
  }

function droits_suffisants($droits_requis, $droits_utilisateur)
{
  $i=0;
  while($i < count($liste_droits))
    {
      if (not(not($droits_requis % 2) || ($droits_utilisateurs % 2))) {break;}
      $droits_requis /= 2;
      $droits_utilisateurs /= 2;
      $i++;
    }
  return($i == count($liste_droits));
}

?>
    