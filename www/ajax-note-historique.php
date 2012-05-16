<?php

include("../php-include/common-includes.php");

function str_real_pad($string, $taille, $alignement = STR_PAD_RIGHT)
{
  if (strlen($string) > $taille)
    {
      return substr($string, 0, $taille);
    }
  else
    {
      return str_pad($string, $taille, " ", $alignement);
    }
};

if (!su(NOTE))
  {
    login_page("note.php", msg_nondroits(NOTE));
  }
else if(!isset($_GET["nb"]))
  {
    $offset = 0;
    if (isset($_GET["offset"])) { $offset = $_GET["offset"]; }
    $count = 20;
    if (isset($_GET["count"])) { $count = $_GET["count"]; }
    
    if (!isset($_GET["adh"]))
      {
	$req = "SELECT t.id, t.date, a1.pseudo AS nom_emetteur, a2.pseudo AS nom_destinataire, b.nom AS nom_conso, t.montant, t.valide 
                FROM transactions AS t
                INNER JOIN adherents AS a1 ON t.emetteur=a1.numcbde
                INNER JOIN adherents AS a2 ON t.recepteur=a2.numcbde
                INNER JOIN boutons AS b ON t.idconso=b.id
                ORDER BY date DESC
                LIMIT ".protect($offset).", ".protect($count).";";
      }
    else
      {
	$req = "SELECT t.id, t.date, a1.pseudo AS nom_emetteur, a2.pseudo AS nom_destinataire, b.nom AS nom_conso, t.montant 
                FROM transactions AS t
                INNER JOIN adherents AS a1 ON t.emetteur=a1.numcbde
                INNER JOIN adherents AS a2 ON t.recepteur=a2.numcbde
                INNER JOIN boutons AS b ON t.idconso=b.id
                WHERE (a1.numcbde=".protect($_GET["adh"])." 
                OR     a2.numcbde=".protect($_GET["adh"]).") 
                AND    t.valide=1 
                ORDER BY date DESC
                LIMIT ".protect($offset).", ".protect($count).";";
      }
    $rep = mysql_query($req, $sqlPointer) or die(mysql_error());
    while($info = mysql_fetch_array($rep))
      {	
	$res = "<option value=".$info['id']." >";
	$res .= $info["date"]." ";
	$res .= str_real_pad($info["nom_emetteur"], 10)." ";
	$res .= str_real_pad($info["nom_destinataire"], 10)." ";
	$res .= str_real_pad($info["nom_conso"], 10)." ";
	$res .= $info["montant"]." "; 
	if (!isset($_GET["adh"])) 
	  { 
	    if($info["valide"]) 
	      {
		$res .= "oui";
	      } 
	    else 
	      {
		$res .= "non";
	      } 
	  }
	$res .= "</option>";
	echo $res;
      }
  }
else
  {
    $req = "SELECT COUNT(*) AS c FROM transactions";
    if (isset($_GET["adh"]))
      {
	$adh = $_GET["adh"];
	$req .= " WHERE emetteur=".protect($adh)." OR recepteur=".protect($adh);
      }
    $req .= ";";
    $rep = mysql_query($req, $sqlPointer);
    $info = mysql_fetch_array($rep);
    echo $info["c"];
  }
?>