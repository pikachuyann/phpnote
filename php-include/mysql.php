<?php
	// Bonjour, ceci est un hack relativement sale pour forcer la déconnexion au serveur MySQL à la fin de chaque script
	class MySql_connexion {
		function __construct() {
			$this->sqlPointer=mysql_connect("localhost","phpnote","hVW2np7QJwdxhhYd")k;
			mysql_select_db("phpnote",$this->sqlPointer);
		}
		function __destruct() {
			mysql_close($this->sqlPointer);
		}
	}
	$sql_class = new MySql_connexion();
	$sqlPointer = $sql_class->sqlPointer;
?>
