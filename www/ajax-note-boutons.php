<?php

include("../php-include/common-includes.php");

if(!su(NOTE))
  {
    login_page("note.php", msg_nondroits(NOTE));
  }
else
  {
    if (!isset($_GET["categ"])) die("Manque la cat&eacute;gorie");
    $req = "SELECT * FROM boutons
            WHERE categorie = ".protect($_GET["categ"])." 
            AND visible = 1 ORDER BY nom;";
    $rep = mysql_query($req, $sqlPointer);
    while($info = mysql_fetch_array($rep))
      {
?>
<button value="<?= $info['nom'] ?>" onClick="note_bouton(<?= $info['id'] ?>)"/>
<?php
      }
  }
?> 