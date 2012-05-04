<?php
	include("../php-include/common-includes.php");

	if (!su(BOUTONS)) {
		echo "Reconnectez-vous";
	}
	else {
		if ($_GET["ctgId"]) {
			$ctgId = intval($_GET["ctgId"]);
			$swto = $_GET["switch_to"];
			if ($swto == 0) { echo "Masquée"; }
			else { echo "Affichée"; }
			mysql_query("UPDATE categories_boutons SET affichage=$swto WHERE id=$ctgId");
		}
	}
?>
