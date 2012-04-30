<?php

include("../php-include/common-includes.php");

if (!su(ADHERENTS))
  {
    die("Cette page n'est pas accessible sans les droits appropriés");
  }
else
  {
    function not_empty($t)
    {
      return($t != "");
    }
    function gen_name_condition($filtre)
    {
      $efiltre = array_filter(explode(' ', $filtre), "not_empty");
      if (count($efiltre) < 2)
	{
	  return("      nom LIKE '".protect(trim($filtre))."%' 
                  OR    nom LIKE '% ".protect(trim($filtre))."%' 
                  OR prenom LIKE '".protect(trim($filtre))."%' ");
	}
      else
	{
	  // On va considérer que les gens ne rentrent qu'un prénom (pas de Pierre Auguste Marie-Jean)
	  // mais peuvent avoir un nom composé.
	  $res = "";
	  foreach($efiltre as $prenom)
	    {
	      // J'en choisi un comme prenom
	      if (not_empty($res)) $res .= "OR ";
	      $res .= "(prenom LIKE '".protect(trim($prenom))."%' ";
	      foreach($efiltre as $nom)
		{
		  if ($nom != $prenom)
		    {
		      $res .= "AND (nom LIKE '".protect(trim($nom))."%' OR nom LIKE '% ".protect(trim($nom))."%') ";
		      // J'impose que les autres soient dans le nom, en début de mot
		      // d'où l'espace essentiel dans la deuxième partie de la condition
		    }
		}
	      $res .= ") ";
	    }
	  // Si le prenom n'est en fait pas spécifié:
	  $res .= "OR ( 1 = 1 ";
	  foreach($efiltre as $nom)
	    {
	      $res .= "AND (nom LIKE '".protect(trim($nom))."%' OR nom LIKE '% ".protect(trim($nom))."%') ";
	    }
	  $res .= ") ";
	  return($res);
	}
    }

    function note_highlight($note, $filtrage)
    {
      return(str_replace($filtrage, "<b>".$filtrage."</b>", $note));
    }

    function nom_highlight($nom, $filtrage)
    {
      $efiltrage = array_filter(explode(' ', $filtrage), "not_empty");
      $nom = "$".$nom; // => Je vais être sale
      foreach($efiltrage as $filtre)
	{
	  $nom = str_replace(" ".$filtre, " <b>".$filtre."</b>", $nom);
	  $nom = str_replace("$".$filtre, "<b>".$filtre."</b>", $nom);
	}
      return(str_replace("$", "", $nom));
      // Et si jamais quelqu'un a un dollar dans son nom, fuuuu !!!!!
    }
      
    // Renvoie du html
    $filtrage_nom = isset($_GET["filtre_nom"]) && $_GET["filtre_nom"] != "";
    $filtrage_note = isset($_GET["filtre_note"]) && $_GET["filtre_note"] != "";

    if(!$filtrage_nom && !$filtrage_note)
      {
	$rep = mysql_query("SELECT * FROM adherents ORDER BY nom LIMIT 15;", $sqlPointer);
      }
    elseif ($filtrage_nom && !$filtrage_note)
      {
	$req = "SELECT * FROM adherents 
                WHERE ".gen_name_condition($_GET["filtre_nom"])."  
                ORDER BY nom
                LIMIT 15;";
	$rep = mysql_query($req, $sqlPointer) or die(mysql_error());
      }
    else
      {
	$now=date("Y-m-d H:i:s");
	$req = "SELECT a.numcbde, a.nom, a.prenom, a.pseudo AS pnow, a.solde, a.numero_tel, h.pseudo AS pold, h.debut, h.fin
                FROM adherents AS a 
                INNER JOIN historique_pseudo AS h 
                ON a.numcbde = h.numcbde
                WHERE (".gen_name_condition($_GET["filtre_nom"]).") 
                AND h.pseudo LIKE '%".protect($_GET["filtre_note"])."%' 
                AND (h.fin_affichage = '0000-00-00 00:00:00' OR h.fin_affichage > '".$now."')  
                ORDER BY a.nom
                LIMIT 15;";
	$rep = mysql_query($req, $sqlPointer) or die(mysql_error());
      }
?>
<table>
   <tr><th>Carte</th><th>Nom</th><th>Pr&eacute;nom</th><th>Nom de note</th><th>Solde</th><th>Num&eacute;ro de t&eacute;l&eacute;phone</th></tr>
<?php
																   $dejadit = array();
    while($info = mysql_fetch_array($rep))
      {
	if (!$filtrage_note)
	  {
	    echo "<tr onClick=\"load_adh(".$info["numcbde"].")\">
                   <td>".$info["numcbde"]."</td>
                   <td>".nom_highlight($info["nom"], $_GET["filtre_nom"])."</td>
                   <td>".nom_highlight($info["prenom"], $_GET["filtre_nom"])."</td>
                   <td>".$info["pseudo"]."</td>
                   <td>".$info["solde"]."</td>
                   <td>".$info["numero_tel"]."</td>
                  </tr>";
	  }
	else
	  {
	    if(!isset($dejadit[$info["numcbde"]]) || !$dejadit[$info["numcbde"]])
	      {
		$dejadit[$info["numcbde"]] = true;
		echo "<tr onClick=\"load_adh(".$info["numcbde"].")\">
                   <td>".$info["numcbde"]."</td>
                   <td>".nom_highlight($info["nom"], $_GET["filtre_nom"])."</td>
                   <td>".nom_highlight($info["prenom"], $_GET["filtre_nom"])."</td>
                   <td>".note_highlight($info["pnow"], $_GET["filtre_note"])."</td>
                   <td>".$info["solde"]."</td>
                   <td>".$info["numero_tel"]."</td>
                  </tr>";
	      }
	    if (strcmp($info["pold"], $info["pnow"]))
	      {
		echo "<tr onClick=\"load_adh(".$info["numcbde"].")\">
                       <td></td>
                       <td colspan=\"2\" ><i>".$info["debut"]." -> ".$info["fin"]."</i></td>
                       <td><i>".note_highlight($info["pold"], $_GET["filtre_note"])."</i></td>
                       <td></td>
                       <td></td>
                      </tr>";
	      }
	  }
      }
  }
?>
</table>