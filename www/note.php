<?php

include("../php-include/common-includes.php");

function gen_categories() {return ""; }
if(!su(NOTE))
  {
    login_page("note.php", msg_nondroits(NOTE));
  }
else
  {
    haut_de_page($userinfo, "Note");

?>
 
<input id="searchadh" type="text" />
<div id="resultadh"></div> <!-- un tableau ou des options -->

   <?= gen_categories() ?>
<div id="resultboutons"></div> <!-- des boutons -->

<div id="currentSelection"></div> <!-- un tableau ou des options -->

<div id="historique"><table><tr><td>Coucou</td></tr><tr><td> </td></tr></table></div>

<?php
    bas_de_page($userinfo);
  }
?>