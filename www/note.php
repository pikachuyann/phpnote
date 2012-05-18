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
<td><div id="boite-adh"><select size="4"></select></div> <!-- un tableau ou des options --></td>
<td><div id="affiche_selection"></div> <!-- un tableau ou des options -->
</td>
<td><?= gen_categories() ?></td>
<td>
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

<select id="historique" size="10" onScroll="historique_scroll(this, -1)" multiple="multiple">
</select>
<button onClick="historique_reset(-1)">Reset</button>
<button onClick="historique_validate()">Valider tout</button>
<button onClick="historique_unvalidate()">D&eacute;valider tout</button>
<script type="text/javascript" src="js-include/note.js"></script>
<script type="text/javascript" src="js-include/rtc.js"></script>
<script type="text/javascript" src="js-include/historique.js"></script>
<script type="text/javascript"> historique_reset(-1); </script>

<?php
    bas_de_page($userinfo);
  }
?>