<?php
	// A COPIER EN mysql.php APRES avoir modifié les champs SERVEUR USERNAME MOTDEPASSE et BASEDEDONNEES

	// Bonjour, ceci est un hack relativement sale pour forcer la déconnexion au serveur MySQL à la fin de chaque script
	class MySql_connexion {
		function __construct() {
			$this->sqlPointer=mysql_connect("SERVEUR","USERNAME","MOTDEPASSE");
			mysql_select_db("BASEDEDONNEES",$this->sqlPointer);
		}
		function __destruct() {
			mysql_close($this->sqlPointer);
		}
	}
	$sql_class = new MySql_connexion();
	$sqlPointer = $sql_class->sqlPointer;
?>
