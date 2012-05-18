<?php
include("../php-include/common-includes.php");

if (!su(NOTE))
  {
    echo "<script type=\"text/javascript\"> document.location='note.php'; </script>;";
  }
elseif (isset($_GET["tid"]) && isset($_GET["action"]))
  {
    $tid = protect($_GET["tid"]);
    mysql_query("LOCK TABLES transactions READ;", $sqlPointer);
    $req = "SELECT * FROM transactions WHERE id=".$tid.";\n";
    $rep = mysql_query($req, $sqlPointer);
    $info = mysql_fetch_array($rep);
    if ($_GET["action"])
      {
	$mult = 1;
	$action = 1;
      }
    else
      {
	$mult = -1;
	$action = 0;
      }
    if ($info["valide"] != $action)
      {
	$req =  "LOCK TABLES adherents WRITE, transactions WRITE;\n";
	$req .= "UPDATE adherents SET solde=solde-".$mult*$info["montant"]." WHERE numcbde=".$info["emetteur"].";\n";
	$req .= "UPDATE adherents SET solde=solde+".$mult*$info["montant"]." WHERE numcbde=".$info["recepteur"].";\n";
	$req .= "UPDATE transactions SET valide=".$action." WHERE id=".$tid.";\n";
	$req .= "UNLOCK TABLES;";

	$liste_req = explode("\n",$req);
	for ($k=0;$k < count($liste_req);$k++) {
		echo "($k) ".$liste_req[$k];
		mysql_query($liste_req[$k], $sqlPointer) or die("($k)".mysql_error());
	}
      }
  }
else
  {}
    

?>