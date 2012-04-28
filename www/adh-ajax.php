<?php

include("../php-include/common-includes.php");

if (!su(ADHERENTS))
  {
    die("Cette page n'est pas accessible sans les droits appropriés");
  }
else
  {
    // Renvoie du html
    if(!isset($_GET["filtre"]) || $_GET["filtre"] == "")
      {
	$rep = mysql_query("SELECT * FROM adherents ORDER BY nom LIMIT 15;", $sqlPointer);
      }
    else
      {
	$req = "SELECT * FROM adherents 
                WHERE pseudo LIKE '".protect($_GET["filtre"])."%' 
                OR       nom LIKE '".protect($_GET["filtre"])."%' 
                OR    prenom LIKE '".protect($_GET["filtre"])."%' 
                ORDER BY nom
                LIMIT 15;";
	$rep = mysql_query($req, $sqlPointer) or die(mysql_error());
      }
?>
<table>
   <tr><th>Carte</th><th>Nom</th><th>Pr&eacute;nom</th><th>Nom de note</th><th>Solde</th><th>Num&eacute;ro de t&eacute;l&eacute;phone</th></tr>
<?php
    while($info = mysql_fetch_array($rep))
      {
	echo "<tr onClick=\"load_adh(".$info["numcbde"].")\">
                <td>".$info['numcbde']."</td>
                <td>".$info['nom']."</td>
                <td>".$info['prenom']."</td>
                <td>".$info['pseudo']."</td>
                <td>".$info['solde']."</td>
                <td>".$info['numero_tel']."</td>
              </tr>";
      }
    echo "</table>";
  }