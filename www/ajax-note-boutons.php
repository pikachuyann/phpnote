<?php

/*
  Une fois qu'on clique sur une catégorie, l'AJAX va charger les boutons ici
*/
include("../php-include/common-includes.php");

if(!su(NOTE))
  {
    echo "<script type=\"text/javascript\"> document.location='note.php' </script>";
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
<button onClick="note_bouton(<?= $info['id'] ?>,'<?= addslashes($info['nom']) ?>',<?= $info['montant'] ?>)" onMouseOver="note_mouseover('<?= addslashes($info['nom']) ?>', <?= $info['montant'] ?>)" ><?= $info['nom'] ?></button>
<?php
      }
  }
?> 