<?php
include("../php-include/common-includes.php");

// Faut faire gaffe sur celui-ci !
if (!isset($_POST['numcbde']))
  {
    echo "<p>Aucun adhérent à modifier</p>";
  }
else
  {
    $req = "SELECT * FROM adherents WHERE numcbde=".protect($_POST["numcbde"]).";";
    $rep = mysql_query($req, $sqlPointer);
    $info = mysql_fetch_array($rep);

    $update_droits = 0;
    $update_surdroits = 0;
    $p = 1;
    for ($i = 0; $i < count($liste_droits); $i++)
      {
	$name = "d".$p;
	if (isset($_POST[$name]) && $_POST[$name] == "on")
	  {
	    if (droits_suffisants($p, $info["droits"]) || sursu($p))
	      {
		$update_droits += $p;
	      }
	    else
	      {
		die("Pas assez de droits pour ajouter un droit");
	      }
	  }
	else
	  {
	    if (droits_suffisants($p, $info["droits"]) && !sursu($p))
	      {
		die("Pas assez de droits pour enlever un droit");
	      }
	  }
	$name = "s".$p;
	if (isset($_POST[$name]) && $_POST[$name] == "on")
	  {
	    if (droits_suffisants($p, $info["surdroits"]) || su(SUPREME))
	      {
		$update_surdroits += $p;
	      }
	    else
	      {
		die("Pas assez de droits pour ajouter un surdroit");
	      }
	  }
	else
	  {
	    if (droits_suffisants($p, $info["surdroits"]) && !sursu(SUPREME))
	      {
		die("Pas assez de droits pour enlever un surdroit");
	      }
	  }
	$p *= 2;
      }
    $req = "UPDATE adherents SET droits=".$update_droits.", surdroits=".$update_surdroits." WHERE numcbde=".$info["numcbde"].";";
    mysql_query($req, $sqlPointer);

    if ($info["numcbde"] == $userinfo["numcbde"])
      {
	header("Location: moncompte.php?type=droits&numcbde=".$info["numcbde"]);
      }
    else
      {
	header("Location: adherents.php?type=droits&numcbde=".$info["numcbde"]);
      }
  }
?>