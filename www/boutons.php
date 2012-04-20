<?php

include('../php-include/common-includes.php');
include('../php-include/adherents/fiche-adherent.php');

haut_de_page($userinfo, "Gestion des boutons", array("inputs-adherents.js"));

global $userinfo;

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


bas_de_page($userinfo);
?>
