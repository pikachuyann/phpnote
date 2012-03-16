<?php
	setlocale(LC_ALL, 'fr_FR@euro', 'fr_FR', 'fr', 'fr'); 
	date_default_timezone_set("Europe/Paris");
	$time=time();

	include("../php-include/mysql.php");
	include("../php-include/style-v1.php");

	/* Gestion des identifications */
	if (!isset($_COOKIE["sid"])) {
		$userinfo["numcbde"]=-1;
	}
	else {
		$sid=mysql_real_escape($_COOKIE["sid"]);
		/* Il faudrait trouver un meilleur moyen pour traiter l'expiration des SID */
		$reply=mysql_query("SELECT * FROM sid, adherents WHERE sid.sid='$sid' AND sid.expiration<$time AND sid.numcbde=adherents.numcbde");
		while ($answer=mysql_fetch_assoc($reply)) { // Le sid étant unique
			// On a plus ou moins l'userinfo dans la réponse...
			$userinfo=$answer;			
		}
	}	
?>
