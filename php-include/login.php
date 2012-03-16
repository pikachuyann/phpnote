<?php
include("../php-include/common-includes.php");
function login_page($source, $msg)	{
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title> phpnote </title>
</head>
<body>
<?= haut_de_page(NULL) ?>
Bienvenue sur <strong>phpnote</strong>.<BR />
<?= $msg ?>
<form method="post" action="<?= $source ?>">
<p><table>
<tr><td>Nom d'utilisateur:</td><td><input type="text" name="user"/></td></tr>
<tr><td>Mot de passe:</td><td><input type="password" name="pwd"/></td></tr>
<? // Pour la gestion des levels ?>
<tr><td>Droits:</td>
  <td><input type="radio" name="level" value="2" name="level2" id="level2" checked="checked"/><label for="level2">Tout mes droits</label></td></tr>
<tr><td></td>
  <td><input type="radio" name="level" value="1" name="level1" id="level1"/><label for="level1">Droits note seulement</label></td></tr>
<tr><td></td>
  <td><input type="submit" value="Envoyer"/></td></tr>
</table></p>
</form>

<?= bas_de_page(NULL) ?>
</body>
</html>
<?php
}
?>
