<?php

function gen_categories()
{
  global $sqlPointer;
  $req = "SELECT * FROM categories_boutons ORDER BY nom";
  $rep = mysql_query($req, $sqlPointer);
  while($info = mysql_fetch_array($rep))
    {
      ?>
      <button onClick="note_categorie(<?= $info['id'] ?>)"><?= $info['nom'] ?>
	</button>
      <?php
    }
}
?>