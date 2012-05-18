<?php

function gen_categories()
{
  global $sqlPointer;
  $req = "SELECT * FROM categories_boutons ORDER BY nom";
  $rep = mysql_query($req, $sqlPointer);
  echo "<table>";
  while($info = mysql_fetch_array($rep))
    {
      ?>
      <tr><td><button onClick="note_categorie(<?= $info['id'] ?>)"><?= $info['nom'] ?>
	</button></td></tr>
      <?php
    }
  echo "<tr><td><button onClick=\"draw_credit()\">Cr&eacute;dit</button></td></tr>";
  echo "<tr><td><button onClick=\"draw_retrait()\">Retrait</button></td></tr>";
  echo "<tr><td><button onClick=\"draw_tranfert()\">Transfert</button></td></tr>";
  echo "</table>";
}
?>