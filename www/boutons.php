<?php

include('../php-include/common-includes.php');
include('../php-include/adherents/fiche-adherent.php');

haut_de_page($userinfo, "Gestion des boutons", array("inputs-adherents.js"));

global $userinfo;

// Skippy: voici comment procéder pour la gestion des droits. Le else c'est pour être vraiment sûr mais en fait login_page termine sur un exit(0).
if (!su(BOUTONS))
  {
    login_page("boutons.php", msg_nondroits(BOUTONS));
  }
else {

$type="boutons";
if (isset($_GET["type"])) {
	if ($_GET["type"]=="categ") { $type="categ"; }
}
?>
<div class='titre_de_page'>Gestion des boutons</div>
<div class='menu_interieur'>
<?php if ($type=="boutons") { ?><strong>Boutons</strong><?php } else { ?><a href='?type=boutons'>Boutons</a><?php } ?>
 -
<?php if ($type=="categ") { ?><strong>Catégories</strong><?php } else { ?><a href='?type=categ'>Catégories</a><?php } ?>
</div>

<?php
	if ($type=="categ") {
		/* Gestion des diverses catégories */
		if (isset($_POST["nom"])) {
			$nom=mysql_real_escape_string(trim($_POST["nom"]));
			mysql_query("INSERT INTO categories_boutons(nom,affichage) VALUES('".$nom."',0)");
		}
?>
<p>Vous pouvez ajouter une cat&eacute;gorie de boutons. Pour chaque cat&eacute;gorie, vous pouvez d&eacute;cider si elle est affich&eacute;e ou non dans l'interface de la note.</p>
<table class='listeCategories' border=1>
<form name='ajouterCategorie' action='?type=categ' method='POST'>
<tr>
<td> <input type='text' name='nom'> </td>
<td> <input type='submit' value='Ajouter'> </td>
</tr>
<?php
	$requete="SELECT * FROM categories_boutons";
	$reponseS=mysql_query($requete);
	while ($reponse=mysql_fetch_assoc($reponseS)) {
		echo "<tr><td>".$reponse["nom"]."</td><td id='categ".$reponse["id"]."' class='switchCategorie' ";
		if ($reponse["affichage"]) {
			echo "onClick='chgCategorie(".$reponse["id"].")'>Affichée";
		}
		else {
			echo "onClick='chgCategorie(".$reponse["id"].")'>Masquée";
		}
		echo "</td></tr>";
	}
?>
</form>

</table>
<?php
	}
	else {
		/* Gestion des boutons */
		// Génération de la liste des catégories pour le SELECT hors formulaire
		$options="";
		$requete="SELECT * FROM categories_boutons";
		$reponseS=mysql_query($requete);
		while ($reponse=mysql_fetch_assoc($reponseS)) {
			$options.="<option value='".$reponse["id"]."'>".$reponse["nom"]."</option>";
		}
?>
<center style='margin:10px;'> <select id='slctCategory' onChange='updBoutons()'><?= $options ?></select> </center>
<table border=1>
	<thead>
		<tr><th>Nom</th><th>Montant</th><th>Receveur</th><th> </th></tr>
	</thead>
	<tbody id='btnList'>
	</tbody>
	<tfoot>
		<tr><td><input type='text' name='nom' id='newButtonName'></td><td><input type='text' name='montant' size='5' id='newButtonValue'></td><td><input type='text' name='receveur' size='3' id='newButtonWho'></td><td><input type='submit' value='Ajouter' onClick='addBouton()'></td></tr>
	</tfoot>
</table>

<?php
	}
?>
<script type="text/javascript" src="js-include/boutons.js"></script>
<?php
	if (isset($options)) { echo "<script type='text/javascript'> updBoutons() </script>"; }
}

bas_de_page($userinfo);
?>
