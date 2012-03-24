<?php
//include('../../php-include/common-includes.php');
include('../php-include/adherents/common.php'); // Les fichiers sont inclus depuis www/ - yann

// <!-- a_inclure_quelque_part = "<script type=\"text/javascript\" src=\"../php-include/adherents/common.js"; --> Done les js s'includent dans haut_de_page !

function fiche_page($numcbde)
{
  global $sqlPointer,$_COOKIE,$userinfo;
  if (!su(ADHERENTS) | $numcbde != $userinfo['numcbde'] | $userinfo['numcbde'] == -1)
    {
      login_page("adherents.php?numcbde=".$numcbde, msg_nondroits(ADHERENTS));
      // Penser au do_login() dans la page appellante
    }
  else
    {
      $req = "SELECT * FROM adherents WHERE numcbde=".protect($numcbde).";";
      if (!($rep = mysql_query($req, $sqlPointer)))
        {
          echo "<p>L'adh&egrave;rent ".$numcbde." n'a pas &egrave;t&egrave; trouv&egrave;";
	  return 1;
	}
      else
        {
	  /* 
	     La suite gère juste l'affichage d'un tableau 
	     avec des fonctions adh_ qui rendent le champs
	     correspondant modifiable si et seulement si on
	     a les droits (le troisième paramètre)
	  */
	  $passe_droit = su(ADHERENTS) | ($info['numcbde'] == $userinfo['numcbe']); 
	  // Pour les champs pouvant être modifié par soi-même ou quelqu'un
	  // qui a les droits ADHERENTS
	  
	  $cible = "modif_adherents.php";
	  if ($info['preinscription'])
	    $cible = "modif_inscription.php";
	  // Pour que les inscriptions se passent dans la page inscription
?>
<form action="<?= $cible ?>" method="post">
<p>Fiche de l'adhérent <span style="font-vaviant: small-caps;"><?= adh_textbox("nom", $info['nom'], su(SUPREME)) ?> <?= adh_textbox("prenom", $info['prenom'], su(SUPREME)) ?></span></p>
<table>
<tr>
  <td>Numéro de carte BDE:</td>
  <td><?= $info['numcbde'] ?><input type="hidden" name="numcbde" value="<?= $info['numcbde'] ?>"/></td>
</tr>
<tr>
  <td>Nom de note:</td>
  <td><?= adh_textbox("pseudo", $info['pseudo'], $passe_droit) ?></td>
</tr>
<tr>
  <td>Solde:</td>
  <td><?= $info['solde'] ?></td>
</tr>
<?php 
   if ((su(ADHERENTS) & $info['droits'] <= $userinfo['droits']) | ($numcbde == $userinfo['numcbde'])) 
     {
       // On peut modifier son mot de passe, sinon il faut plus de droits que
       // la personne à qui tu changes le mot de passe 
       // (sinon autant donner les droits SUPREME à tout le monde)
?>
<tr>
  <td></td>
  <td><form action="passwd.php" method="post">
      <input type="hidden" name="numcbde" value="<?= $numcbde ?>"/>
      <input type="submit" value="Changer le mot de passe" />
      </form>
  </td>
</tr>
<?php
     }
?>
<tr>
  <td>Section:</td>
  <td><?= adh_textbox("section", $info['section'], $passe_droit) ?></td>
</tr>
<tr>
  <td>Fonctions:</td>
  <td><?= adh_textbox("fonctions", $info['fonctions'], su(BUREAU)) ?></td>
</tr>
<tr>
  <td>email:</td>
  <td><?= adh_textbox("email", $info['email'], $passe_droit) ?></td>
</tr>
<tr>
  <td>Num&egrave;ro de t&egtave;l&egrave;phone:</td>
  <td><?= adh_textbox("numero_tel", $info['numero_tel'], $passe_droit) ?></td>
</tr>
<tr>
  <td>Probl&eacute;mes de sant&egrave;:</td>
  <td><?= adh_textbox("pb_sante", $info['pb_sante'], $passe_droit) ?></td>
</tr>
<?php
  // Pour utiliser la même fonction pour afficher deux choses différentes
  // (Quoi je suis sale ??)
  if (!$info['preinscription'])
    {
?>
<tr>
  <td>Valide:</td>
  <td><?= adh_bool("valide", $info['valide'], su(BUREAU)) ?></td>
</tr>
<tr>
  <td><input type="hidden" name="preinscription" value="0"/></td>
  <td><input type="submit" value="Valider"/></td>
</tr>
<?php
    }
  else
    {
?>
<tr>
  <td><input type="hidden" name="preinscription" value="1"/></td>
  <td><?php if (su(INSCRIPTION)) { ?><input type="submit" value="Valider la pr&egrave;inscription"/><?php } ?></td>
</tr>
<?php
    }
?>
<tr>
  <td></td>
  <td><input type="button" value="Retour"/></td>
</tr>
</table>
</form>
<?php
} // Fermeture de si on trouve l'adhérent
} // Fermeture de si on a les droits
} // Fermeture de la définition de la fonction
?>
