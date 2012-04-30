<?php

include("../../php-include/common-includes.php");

if (!su(ADHERENTS))
  {
    die("Cette page n'est pas accessible sans les droits appropriés");
  }
elseif (isset($_GET["filtre"]))
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
            ORDER BY a.pold;";

    $rep = mysql_query($req, $sqlPointer);
    while($info = mysql_fetch_array($rep))
      {
	echo "<input type=\"hidden\" id=\"s".$info["numcbde"]."\" value=\"".$info["solde"]."\" />";
	echo "<option id=\"n".$info["numcbde"]."\" >";
	// Je ferai moins moche plus tard
	if ($info["pold"] != $info["pnow"])
	  {
	    echo "<i>".$info["pold"]."</i> -> ".$info["pnow"]."</option>";
	  }
	else
	  {
	    echo $info["pnow"]."</option>";
	  }
      }
  }