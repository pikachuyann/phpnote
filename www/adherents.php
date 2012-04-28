<?php

include('../php-include/common-includes.php');
include('../php-include/adherents/fiche-adherent.php');

haut_de_page($userinfo, "Informations sur les adh&eacute;rents", array("inputs-adherents.js"));

global $userinfo;
if(isset($_GET['numcbde']))
  {
    // La gestion des droits est assurée par la fonction en interne
    fiche_page($_GET['numcbde']);
  }
elseif (!su(ADHERENTS))
  {
    login_page("adherents.php", msg_nondroits(ADHERENTS));
  }
else
  {
    $rep = mysql_query("SELECT * FROM adherents ORDER BY nom LIMIT 15;", $sqlPointer);
?>
  Rechercher: (par nom) <input id="searchnom" type="text" autocomplete="off" /> (par note) <input id="searchnote" type="text" autocomplete="off" />
<div id="results">
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
?>

</table>
</div>
<script type="text/javascript" src="js-include/search-adh.js"></script>
<?php
     }
bas_de_page($userinfo);
?>












