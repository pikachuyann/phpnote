<?php
include('../../php-include/common-includes.php');
include('../../php-include/adherents/common.php');

// <!-- a_inclure_quelque_part = "<script type=\"text/javascript\" src=\"../php-include/adherents/common.js"; -->

// note sur cette page:
// penser à mettre la valeur su(ADHERENTS) | $numcbde = $userinfo['numcbde'] 
// dans une variable pour alléger le code (faudra trouver un nom explicite)

function fiche_page($numcbde)
{
  global $sqlPointer,$_COOKIE,$userinfo;
  if (!su(ADHERENTS) | $numcbde != $userinfo['numcbde'] | $userinfo['numcbde'] == -1)
    {
      login_page("toto.php?id=".$numcbde, msg_nondroits(ADHERENTS));
      // Penser au do_login() dans la page appellante
    }
  else
    {
      $req = "SELECT * FROM adherents WHERE numcbde=".$numcbde.";";
      if (!($rep = mysql_query($req, $sqlPointer)))
        {
          echo "<p>L'adh&egrave;rent ".$numcbde." n'a pas &egrave;t&egrave; trouv&egrave;";
	  return 1;
	}
      else
        {
?>
<form action="modif_adh.php" method="post">
<p>Fiche de l'adhérent <span style="font-vaviant: small-caps;"><?= adh_textbox("nom", $userinfo['nom'], su(SUPREME)) ?> <?= adh_textbox("prenom", $userinfo['prenom'], su(SUPREME)) ?></span></p>
<table>
<tr><td>Numéro de carte BDE:</td><td><?= $info['numcbde'] ?></td></tr>
<tr><td>Nom de note:</td><td><?= adh_textbox("pseudo", $info['pseudo'], su(ADHERENTS) | $numcbde == $userinfo['numcbde']) ?></td></tr>
<tr><td>Solde:</td><td><?= $info['solde'] ?></td></tr>
<tr><td>Section:</td><td><?= adh_textbox("section", $info['section'], su(ADHERENTS) | $numcbde == $userinfo['numcbde']) ?></td></tr>
<tr><td>Fonctions:</td><td><?= adh_textbox("fonctions", $info['fonctions'], su(BUREAU)) ?></td></tr>
<tr><td>email:</td><td><?= adh_textbox("email", $info['email'], su(ADHERENTS) | $numcbde == $userinfo['numcbde']) ?></td></tr>
<tr><td>Num&egrave;ro de t&egtave;l&egrave;phone:</td><td><?= adh_textbox("numero_tel", $info['numero_tel'], su(ADHERENTS) | $numcbde == $userinfo['numcbde']) ?></td></tr>
<tr><td>Probl&eacute;mes de sant&egrave;:</td><td><?= adh_textbox("pb_sante", $info['pb_sante'], su(ADHERENTS) | $numcbde == $userinfo['numcbde']) ?></td></tr>
<tr><td>Valide:</td><td><?= adh_bool("valide", $info['valide'], su(BUREAU)) ?></td></tr>
<tr><td></td><td><input type="submit" value="Valider"/></td></tr>
<tr><td></td><td><input type="button" value="Retour"/></td></tr>
</table>
</form>
<?php
} // Fermeture de si on trouve l'adhérent
} // Fermeture de si on a les droits
} // Fermeture de la définition de la fonction
?>
