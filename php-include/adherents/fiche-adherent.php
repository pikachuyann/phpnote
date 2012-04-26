<?php
//include('../../php-include/common-includes.php');
include('../php-include/adherents/common.php'); // Les fichiers sont inclus depuis www/ - yann

// <!-- a_inclure_quelque_part = "<script type=\"text/javascript\" src=\"../php-include/adherents/common.js"; --> Done les js s'includent dans haut_de_page !

function fiche_page($numcbde)
{
  global $sqlPointer,$_COOKIE,$userinfo,$liste_droits;
  if ((!su(ADHERENTS) && $numcbde != $userinfo['numcbde']) || $userinfo['numcbde'] == -1)
    {
      login_page("adherents.php?numcbde=".$numcbde, msg_nondroits(ADHERENTS));
    }
  else
    {
      $req = "SELECT * FROM adherents WHERE numcbde=".protect($numcbde).";";
      if (!($rep = mysql_query($req, $sqlPointer)))
        {
          echo "<p>L'adh&eacute;rent ".$numcbde." n'a pas &eacute;t&eacute; trouv&eacute;";
	  return 1;
	}
      else
        {
	  $info = mysql_fetch_array($rep);
	  /* 
	     La suite gère juste l'affichage d'un tableau 
	     avec des fonctions adh_ qui rendent le champs
	     correspondant modifiable si et seulement si on
	     a les droits (le troisième paramètre)
	  */
	  $passe_droit = su(ADHERENTS) || ($info['numcbde'] == $userinfo['numcbde']); 
	  // Pour les champs pouvant être modifié par soi-même ou quelqu'un
	  // qui a les droits ADHERENTS
	  
	  // $cible = "dispatcher.php";

	  $cible = "chgadh.php";
	  // if ($info['preinscription'])
	  //   $cible = "modif_inscription.php";
	  // Pour que les inscriptions se passent dans la page inscriptino


	  $type="profil";
	  if (isset($_GET["type"])) {
	    if ($_GET["type"]=="droits") { 
	      $type="droits"; $cible="chgdroits.php";
	    }
}
?>
<form action="<?= $cible ?>" class="formulaire_preinscription" method="post">


<div class='titre_de_page'>Fiche de l'adh&eacute;rent <?= adh_textbox("nom", $info['nom'], ($type=="profil") && su(SUPREME)) ?> <?= adh_textbox("prenom", $info['prenom'], ($type=="profil") && su(SUPREME)) ?></div> <?php //' ?> 
<div class='menu_interieur'>
<?php if ($type=="profil") { ?><strong>Profil</strong><?php } else { ?><a href='?numcbde=<?= $numcbde ?>&type=profil'>Profil</a><?php } ?>
 -
<?php if ($type=="droits") { ?><strong>Droits</strong><?php } else { ?><a href='?numcbde=<?= $numcbde ?>&type=droits'>Droits</a><?php } ?>
<?php if (passwd_condition($info))
   {
?> - <a href='chgpass.php?numcbde=<?= $numcbde ?>'>Changer le mot de passe</a>
<?php } ?>
</div>

<?php
	if ($type=="droits") {
?>
<input type="hidden" name="numcbde" value="<?= $numcbde ?>" />
<table>
<tr><th>Nom</th><th>Droit</th><th>Surdroit</th></tr>
<?php
	    $p = 1;
	    for($i = 0; $i < count($liste_droits); $i++)
	      {
?>
<tr><td><?= $liste_droits[$i] ?></td><td><?= adh_bool("d".$p, droits_suffisants($p, $info['droits']), sursu($p)) ?></td><td><?= adh_bool("s".$p, droits_suffisants($p, $info['surdroits']), su(SUPREME)) ?></td></tr>
<?php
               $p *= 2;
              }
?>
<tr><td>SUPREME</td><td></td><td><?php if ($info["supreme"]) {echo "oui";} else {echo "non";} ?></td></tr>
<tr><td></td><td></td><td><input type="submit" value="Valider"/></td></tr>
</table>
</form>
<?php
	}
	else 
	  {
?>
<table>
<tr>
  <td>Num&eacute;ro de carte BDE:</td>
  <td><?= $info['numcbde'] ?><input type="hidden" name="numcbde" value="<?= $info['numcbde'] ?>"/></td>
</tr>
<tr>
  <td>Nom de note:</td>
  <?= adh_td_textbox("pseudo", $info['pseudo'], $passe_droit) ?>
</tr>
<tr>
  <td>Solde:</td>
  <td><?= $info['solde'] ?></td>
</tr>
<tr>
  <td>Section:</td>
  <?= adh_td_textbox("section", $info['section'], $passe_droit) ?>
</tr>
<tr>
  <td>Fonctions:</td>
  <?= adh_td_textbox("fonctions", $info['fonctions'], su(BUREAU)) ?>
</tr>
<tr>
  <td>email:</td>
  <?= adh_td_textbox("email", $info['email'], $passe_droit) ?>
</tr>
<tr>
  <td>Num&eacute;ro de t&eacute;l&eacute;phone:</td>
  <?= adh_td_textbox("numero_tel", $info['numero_tel'], $passe_droit) ?>
</tr>
<tr>
  <td>Probl&egrave;mes de sant&eacute;:</td>
  <?= adh_td_textbox("pb_sante", $info['pb_sante'], $passe_droit) ?>
</tr>
<?php
  // Pour utiliser la même fonction pour afficher deux choses différentes
  // (Quoi je suis sale ??)
  if (!$info['preinscription'])
    {
?>
<tr>
  <td><input type='hidden' name='send_valide' value='Exists'>Valide:</td>
  <td><?= adh_bool("valide", $info['valide'], su(BUREAU)) ?></td>
</tr>
<tr>
  <td><input type="hidden" name="preinscription" value="0"/></td>
  <td><input type="submit" name="action" value="Valider"/></td>
</tr>
<?php
    }
  else
    {
?>
<tr>
  <td><input type="hidden" name="preinscription" value="1"/></td>
  <td><?php if (su(INSCRIPTION)) { ?><input type="submit" name="action" value="Valider la préinscription"/><?php } ?></td>
</tr>
<?php
    }
?>
<tr>
  <td></td>
  <td><input type="submit" name="action" value="Annuler"/></td>
</tr>
</table>
</form>
<?php
   } // Fermeture de type == "profil"
} // Fermeture de si on trouve l'adhérent
} // Fermeture de si on a les droits
} // Fermeture de la définition de la fonction
?>
