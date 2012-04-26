<?php
//include('../../php-include/common-includes.php');

function passwd_page($numcbde)
  {
    global $userinfo, $sqlPointer;
    $req = "SELECT * FROM adherents WHERE numcbde=".protect($numcbde).";";
    if (!($rep = mysql_query($req, $sqlPointer)))
      {
	echo "<p>L'adh&egrave;rent ".$numcbde." n'a pas &egrave;t&egrave; trouv&egrave;";
	return 1;
      }
    else
      {
	$info = mysql_fetch_array($rep);
	if ((!su(ADHERENTS) && $numcbde != $userinfo['numcbde']) || $userinfo['numcbde'] == -1 || !droits_suffisants($info['droits'], $userinfo['droits']))
	  {
	    login_page("chgpass.php?numcbde=".$numcbde, "Vous n'avez pas assez de droits");
	  }
	else
	  {
?>
<p>Modifier le mot de passe de <span style="font-vaviant: small-caps;"><?= $info['nom'] ?> <?= $info['prenom'] ?></span></p>
<form action="chgpass.php?numcbde=<?= $numcbde ?>" method="post">
<table>
<tr>
  <td>Nouveau mot de passe:</td>
  <td><input type="password" name="mdp1"/></td>
</tr>
<tr>
  <td>Confirmer le mot de passe:</td>
  <td><input type="password" name="mdp2"/></td>
</tr>
<tr>
  <td></td>
  <td><input type="submit" value="Envoyer"/></td>
</tr>
</table>
</form>
<?php
}
}
}

function passwd_change($numcbde, $newpasswd)
  {
    global $userinfo, $sqlPointer;
    $req = "SELECT * FROM adherents WHERE numcbde=".protect($numcbde).";";
    if (!($rep = mysql_query($req, $sqlPointer)))
      {
	echo "<p>L'adh&egrave;rent ".$numcbde." n'a pas &egrave;t&egrave; trouv&egrave;";
	return 1;
      }
    else
      {
	$info = mysql_fetch_array($rep);
	if ((!su(ADHERENTS) && $numcbde != $userinfo['numcbde']) || $userinfo['numcbde'] == -1 || !droits_suffisants($info['droits'], $userinfo['droits']))
	  {
	    login_page("chgpass.php?numcbde=".$numcbde, "Vous n'avez pas assez de droits");
	  }
	else
	  {
            $req = "UPDATE adherents SET motdepasse='".mash($newpasswd)."' WHERE numcbde=".$numcbde.";";
            return(mysql_query($req, $sqlPointer));
          }
       }
  }
