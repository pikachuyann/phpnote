<?php
	setlocale(LC_TIME, 'fr_FR'); 
	date_default_timezone_set("Europe/Paris");
	$time=time();

        include("../php-include/config.php");
	include("../php-include/mysql.php");
	include("../php-include/style-v1.php");
	include("../php-include/droits.php");
	include("../php-include/login.php");

	/* Gestion des identifications */
	if (!isset($_COOKIE["sid"])) {
	}
	else {
		$sid=mysql_real_escape_string($_COOKIE["sid"]);
		/* Il faudrait trouver un meilleur moyen pour traiter l'expiration des SID */
		$reply=mysql_query("SELECT * FROM sid, adherents WHERE sid.sid='$sid' AND sid.expiration>NOW() AND sid.numcbde=adherents.numcbde");
		while ($answer=mysql_fetch_assoc($reply)) { // Le sid étant unique
			// On a plus ou moins l'userinfo dans la réponse...
			$upd_req="";
			if (strtotime($answer["expircomplet"]) < $time) {
				$upd_req=", expircomplet='".date("Y-m-d H:i:s", time()+TEMPS_EXPIRCOMPLET)."'";
			}
			mysql_query("UPDATE sid SET expiration='".date("Y-m-d H:i:s", time()+TEMPS_EXPIRE)."'$upd_req WHERE sid='$sid'");
			$userinfo=$answer;
		}
	}	

	if (!isset($userinfo)) {
		$userinfo["numcbde"]=-1;
		$userinfo["droits"]=0;
	}

function protect($text)
{
  return(mysql_real_escape_string(htmlspecialchars($text)));
}

function mash($text)
{
  return(md5($text));
}
?>
