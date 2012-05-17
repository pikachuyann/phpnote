<?php
// Cette page est la même que si on regarde la fiche d'un adhérent mais
// cela permet de cacher adherents.php plus générale 
// (mais ce n'est pas une véritable sécurité en soi vu que adherents.php
// est quand même accessible si on rentre l'url dans le navigateur, c'est
// la gestion de droits qui assure la sécurité)

include('../php-include/common-includes.php');
include('../php-include/adherents/fiche-adherent.php');

if (su(INTRANET))
  {
    haut_de_page($userinfo, "Mon compte", array("inputs-adherents.js"));
    fiche_page($userinfo['numcbde']);
    bas_de_page($userinfo);
  }
else
  {
    login_page("moncompte.php", msg_nondroits(INTRANET));
  }
// Simple non ?
?>