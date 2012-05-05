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
 
<input id="search" type="text" onKeyUp="search_adh()" />

<div id="boite-adh"></div> <!-- un tableau ou des options -->

<?= gen_categories() ?>

<div id="boite-boutons"></div> <!-- des boutons -->

<div id="affiche_selection"></div> <!-- un tableau ou des options -->

<div id="affiche_adh_nom"></div>
<div id="affiche_adh_argent"></div>

<div id="historique"></div>

<script type="text/javascript" src="js-include/note.js"></script>
<?php
    bas_de_page($userinfo);
  }
?>