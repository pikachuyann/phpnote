<?php
	include("../php-include/common-includes.php");

	if (!su(BOUTONS)) {
	         echo "<script type=\"text/javascript\"> document.location='boutons.php' </script>";
	}
	else {
		if (isset($_GET["ctgId"])) {
			$ctgId = intval($_GET["ctgId"]);
			$swto = $_GET["switch_to"];
			if ($swto == 0) { echo "Masquée"; $swto=0; }
			else { echo "Affichée"; $swto=1; }
			mysql_query("UPDATE categories_boutons SET affichage=$swto WHERE id=$ctgId");
		}
		elseif (isset($_GET["btnId"])) {
			$btnId = intval($_GET["btnId"]);
			$swto = $_GET["switch_to"];
			if ($swto == 0) { echo "Masqu&eacute;"; $swto = 0; }
			else { echo "Affich&eacute;"; $swto = 1; }
			mysql_query("UPDATE boutons SET visible=$swto WHERE id=$btnId");
		}
		elseif (isset($_GET["addNB"])) {
			$addNB=$_GET["addNB"];
			$addNB=preg_split("/䈥/",$addNB);

			$categ=$addNB[0];
			$nom=$addNB[1];
			$montant=$addNB[2];
			$pourqui=$addNB[3];

			$pqiv=intval($pourqui); $montantiv=floatval($montant); $categiv=intval($categ);
			if ($montantiv == $montant && $pqiv == $pourqui && $categiv == $categ) {
				$nom=mysql_real_escape_string($nom);
				mysql_query("INSERT INTO boutons(nom,montant,receveur,categorie,visible) VALUES('$nom','$montant','$pqiv','$categiv',0)");
				$btnid=mysql_insert_id();
				echo "<tr><td>$nom</td><td>$montantiv</td><td>$pqiv</td><td id='btn".$btnid."' class='switchCategorie' onClick='chgBouton(".$btnid.")'>Masqu&eacute;</td></tr>";
			}
			else {
			}
		}
		elseif (isset($_GET["viewB"])) {
			$categ=intval($_GET["viewB"]);

			$req=mysql_query("SELECT * FROM boutons WHERE categorie='$categ'");
			while ($rep=mysql_fetch_assoc($req)) {
				echo "<tr><td>".$rep["nom"]."</td><td>".$rep["montant"]."</td><td>(ID: ".$rep["receveur"]." )</td><td id='btn".$rep["id"]."' class='switchCategorie' onClick='chgBouton(".$rep["id"].")'>";
				if ($rep["visible"]) { echo "Affich&eacute;"; } else { echo "Masqu&eacute;"; }
				echo "</td></tr>";
			}
		}
	}
?>
