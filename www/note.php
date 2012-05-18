<?php

include("../php-include/common-includes.php");
//include("../php-include/note/categories.php");

if(!su(NOTE))
  {
    login_page("note.php", msg_nondroits(NOTE));
  }
else
  {
    haut_de_page($userinfo, "Note");

?>

<table> 
<tr>
<td><input id="search" type="text" onKeyUp="search_adh()" /></td><td>
</td>
<td></td><td></td>
</tr>
<tr>
<td valign='top'><div id="boite-adh"><select size="8"></select></div> <!-- un tableau ou des options --></td>
<td valign='top'><div id="affiche_selection"></div> <!-- un tableau ou des options -->
</td>
<td valign='top'><?= gen_categories() ?></td>
<td valign='top'>
<div id="boite-boutons"></div> <!-- des boutons -->
</td>
<tr>
<td></td>
<td></td>
<td>
<div id="affiche_adh_nom"></div>
<div id="affiche_adh_argent"></div>
</td>
<td></td>
</tr>
</table>

<div>
<select id="historique" size="10" onScroll="historique_scroll(this, -1)" multiple="multiple">
</select>
<span id="boutons_historique">
<button onClick="historique_reset(-1)">Rafra&icirc;chir</button><BR />
<button onClick="historique_validate()">Valider les transactions s&eacute;l&eacute;ctionn&eacute;es</button><BR />
<button onClick="historique_unvalidate()">D&eacute;valider les transactions s&eacute;l&eacute;ctionn&eacute;es</button><BR />
</span>
</div>
<script type="text/javascript" src="js-include/note.js"></script>
<script type="text/javascript" src="js-include/rtc.js"></script>
<script type="text/javascript" src="js-include/historique.js"></script>
<script type="text/javascript"> historique_reset(-1); </script>

<?php
    bas_de_page($userinfo);
  }
?>
