<?php

include("../php-include/common-includes.php");

/*
  Pour afficher dynamiquement les noms de note associés au filtre dans la note
*/
if (!su(ADHERENTS))
  {
    die("Cette page n'est pas accessible sans les droits appropriés");
  }
elseif (isset($_GET["filtre"]) && $_GET["filtre"] != "")
  {
    $data = array();
    $now=date("Y-m-d H:i:s");
    $req = "SELECT a.numcbde, a.pseudo AS pnow, a.solde, f.pseudo AS pold
            FROM adherents AS a 
            INNER JOIN historique_pseudo AS f ON a.numcbde = h.numcbde
            WHERE f.id IN
                (SELECT h.id FROM historique_pseudo AS h WHERE 
                   h.pseudo LIKE '".protect($_GET["filtre"])."%' 
                   AND h.fin_affichage = '0000-00-00 00:00:00')
            OR f.id IN
                (SELECT h.id FROM historique_pseudo AS h WHERE 
                   h.pseudo LIKE '".protect($_GET["filtre"])."%'
                   AND 
                      NOT EXISTS (
                        SELECT n.id FROM historique_pseudo AS n WHERE 
                               n.pseudo LIKE '".protect($_GET["filtre"])."%' 
                           AND n.fin_affichage = '0000-00-00 00:00:00'
                           AND n.numcbde = h.numcbde)
                   AND h.fin_affichage =
                      (SELECT MAX(n.fin_affichage) FROM historique_pseudo AS n
                       WHERE n.pseudo LIKE '".protect($_GET["filtre"])."%'
                       AND n.numcbde = h.numcbde AND n.fin_affichage > '".$now."')  
            ORDER BY a.pold;"; // << PAN
    /*
      Ca c'était la requête que je dois débboguer si jamais je veux que les 
      anciens noms de notes apparaissent dans la note... Mais vu que ça marchera
      jamais, j'ai choisi d'utiliser une requête plus simple:
    */
    $req = "SELECT numcbde, pseudo, solde FROM adherents WHERE pseudo LIKE '".protect($_GET["filtre"])."%' ORDER BY pseudo;";
    $rep = mysql_query($req, $sqlPointer);
?>
<select size="4">
<?php
    while($info = mysql_fetch_array($rep))
      {
?>
<option onClick="note_client(<?= $info['numcbde'] ?>,'<?= addslashes($info['pseudo']) ?>',<?= $info['solde'] ?>)" onMouseOver="note_mouseover('<?= addslashes($info['pseudo']) ?>',<?= $info['solde'] ?>)" ><?= $info['pseudo'] ?></option>
<?php
	// Si jamais on veut vraiment que les anciens noms de notes apparaissent:
        // (A condition que la requête à debboguer marche)
	/*
	if ($info["pold"] != $info["pnow"])
	  {
	    echo "<i>".$info["pold"]."</i> -> ".$info["pnow"]."</option>";
	  }
	else
	  {
	    echo $info["pnow"]."</option>";
	  }
	*/
      }
?>
</select>
<?php
  }
else
  {
?>
    <select size="4"></select>
<?php
  }
?>
