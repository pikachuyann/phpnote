<?php
/*	if !(droit_suffisant(ADHERENTS, $_SESSION['droits_user']))
	   {
	        // On redirige vers login.php
	   }
*/

	function haut_de_page($userinfo,$titre="") {
		// Userinfo contiendra les données de l'utilisateur dont en aprticulier ses droits (ça pourrait être utile...)
		if ($titre != "") { $titre = " :: "; }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<title><?= $titre ?>phpNote</title>
</head>
<body>
<?php
	}

	function bas_de_page($userinfo) {
		// Userinfo n'est pas forcément utile ?
?>
</body>
</html>
<?php
	}
?>
