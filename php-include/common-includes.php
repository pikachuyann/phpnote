<?php
	setlocale(LC_TIME, 'fr_FR'); 
	date_default_timezone_set("Europe/Paris");
	$time=time();

 
        include("../php-include/config.php");
        include("../php-include/sample-functions.php");
	include("../php-include/mysql.php");
	include("../php-include/style-v1.php");

	include("../php-include/droits.php");
	include("../php-include/login.php");
        include("../php-include/note/categories.php");

?>
