<?php
/*	if !(droit_suffisant(ADHERENTS, $_SESSION['droits_user']))
	   {
	        // On redirige vers login.php
	   }
*/

	function haut_de_page($userinfo,$titre="") {
		// Userinfo contiendra les données de l'utilisateur dont en aprticulier ses droits (ça pourrait être utile...)
		if ($titre != "") { $titre = "$titre :: "; }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<title><?= $titre ?>phpNote</title>
	<link rel="stylesheet" type="text/css" href="style/common.css" />
</head>
<body>
<div class='header_infos'>
<span class='header_info_text'>Vive la O&ucirc;EstChar[list] !</span> &nbsp;
<span class='header_info_time'>Nous sommes le <?= strftime("%A %e %B") ?>, et il est <?= strftime("%H:%M") ?>.</span>
</div>
<div class='header_menu'><div>
	<a href='/'>Index</a>
	<?php if ($userinfo["numcbde"]==-1) {	?><a href='/preinscription.php'>Pr&eacute;inscription</a><?php	} ?>
</div></div>
<?php
	}

	function bas_de_page($userinfo) {
		// Userinfo n'est pas forcément utile ?
?>
<div class='bottom_credits'> phpNote Version &alpha;, cod&eacute;e par <i>Skippy</i> et <i>pika</i>. </div>
</body>
</html>
<?php
	}
?>
