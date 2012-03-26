<?php
/*	if !(droit_suffisant(ADHERENTS, $_SESSION['droits_user']))
	   {
	        // On redirige vers login.php
	   }
*/

$HdPAffiche=0; $BdPAffiche=0;
global $HdPAffiche;
global $BdPAffiche;

function haut_de_page($userinfo,$titre="", $js_list=array()) {
		global $HdPAffiche;
		if ($HdPAffiche==1) { return 42; }
		else { $HdPAffiche=1; }
		// Userinfo contiendra les données de l'utilisateur dont en aprticulier ses droits (ça pourrait être utile...)
		if ($titre != "") { $titre = "$titre :: "; }
		$messages=file("../php-include/messages");
		if (isset($userinfo["droits"])) { $droits=$userinfo["droits"]; }
		else { $droits=0; }
		$up_message=$messages[rand(0,(count($messages)-1))];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<title><?= $titre ?>phpNote</title>
	<link rel="stylesheet" type="text/css" href="style/common.css" />
        <?php
          foreach($js_list as $script)
            {
              echo "<script type=\"text/javascript\" src=\"js-include/".$script."\"></script>\n";
            }
	?>
</head>
<body>
<div class='header_infos'>
<span class='header_info_text' style='color:red;'><?= $up_message ?></span> &nbsp;
<span class='header_info_time'>Nous sommes le <?= strftime("%A %e %B") ?>, et il est <?= strftime("%H:%M") ?>.</span>
</div>
<div class='header_menu'><div>
	<a href='/'>Index</a>
	<?php if ($userinfo["numcbde"]==-1) {	?><a href='/preinscription.php'>Pr&eacute;inscription</a><?php	} ?>
	<?php if (droits_suffisants(INTRANET,$droits)) { ?><a href='delog.php'>Se d&eacute;connecter</a><?php	} ?>
        <?php if (su(INTRANET)) { ?><a href='moncompte.php'>Mon compte</a><?php	} ?>
        <?php if (su(ADHERENTS)) { ?><a href='adherents.php'>Adh&eacute;rents</a><?php	} ?>
</div></div>
<?php
	}

	function bas_de_page($userinfo) {
		global $BdPAffiche;
		if ($BdPAffiche==1) { return 42; }
		else { $BdPAffiche=1; }
		// Userinfo n'est pas forcément utile ?
?>
<div class='bottom_credits'> phpNote Version &alpha;, cod&eacute;e par <i>Skippy</i> et <i>pika</i>, et parce que <i>ju&#x0109;jo</i> est un charg&eacute; de projet trollesque... </div>
</body>
</html>
<?php
	}
?>
