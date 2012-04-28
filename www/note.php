<?php

include("../php-include/common-include.php");

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

<div id="historique"></div> <!-- un tableau et une barre de défilement -->  

<?php
    bas_de_page($userinfo);
?>