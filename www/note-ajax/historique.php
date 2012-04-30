<?php

include("../../php-include/common-includes.php");

function note_bool($nom_de_sortie, $par_defaut)
{
  if ($par_defaut) 
    {
      $real_name = "oui"; 
      $html_def = "checked";
      $html_def2 = "on";
    }
  else 
    {
      $real_name = "non";
      $html_def = "unchecked";
      $html_def2 = "off";
    }
?>
<span id="boolbutton_<?= $nom_de_sortie ?>" onClick="note_bool_js('<?= $nom_de_sortie ?>', '<?= $html_def ?>')">
<?= $real_name ?>
<input type="hidden" name="<?= $nom_de_sortie ?>" value="<?= $html_def2 ?>" />
</span>
<?php
}

if (!su(NOTE))
  {
    login_page("note.php", msg_nondroits(NOTE));
  }
else
  {
    $offset = 1;
    if (isset($_GET["offset"]))
      $offset = $_GET["offset"];
    $req = "SELECT t.id, t.date, a1.pseudo AS nom_emetteur, a2.pseudo AS nom_destinataire, b.nom AS nom_conso, t.montant, t.valide 
            FROM transactions AS t
            INNER JOIN adherents AS a1 ON t.emetteur=a1.numcbde
            INNER JOIN adherents AS a2 ON t.destinataire=a2.numcbde
            INNER JOIN boutons AS b ON t.idconso=b.id
            ORDER BY date DESC
            LIMIT ".protect($offset).", 20;";
    $rep = mysql_query($req, $sqlPointer);
?>
<table>
<tr><th>Date</th><th>Emetteur</th><th>Destinataire</th><th>Conso</th><th>Montant</th><th>Valide</th></tr>
<?php
    while($info = mysql_fetch_array($req))
      {
?>	
	<tr>
	  <td><?= $info["date"] ?></td>
	  <td><?= $info["nom_emetteur"] ?></td>
	  <td><?= $info["nom_destinataire"] ?></td>
	  <td><?= $info["nom_conso"] ?></td>
	  <td><?= $info["montant"] ?></td>
	  <td><?= note_bool("v".$info["id"], $info["valide"]) ?></td>
	</tr>
<?php
      }
?>
    </table>
<?php
  }
?>