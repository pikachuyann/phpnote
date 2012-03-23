<?php

include('../php-include/common-includes.php');
include('../php-include/adherents/fiche-adherent.php');

haut_de_page($userinfo, "Informations sur les adh&egrave;rents", array("inputs-adherents.js"));
if(isset($_GET['numcbde']))
  {
    fiche_page($_GET['numcbde']);
  }
else if (su(ADHERENTS))
  {
?>
  <!--Rechercher: <form><input type="text" onChange="recherche_adh()" /></form>-->
  <table>
      <th><td>Carte</td><td>Nom</td><td>Pr&egrave;nom</td><td>Nom de note</td><td>Solde</td><td>Num&egrave;ro de t&egravel&egrave;phone</td></th>
<?php
    $req = "SELECT numcbde, nom, prenom, pseudo, solde, numero_tel FROM adherents ORDER BY nom LIMIT 30";
    $rep = mysql_query($req, $sqlPointer);
    while ($info = mysql_fetch_array($rep))
      {
	echo "<tr onClick=\"load_adh(".$info['numcbde']".)\">
              <td>".$info['numcbde']."</td>
              <td>".$info['nom']."</td>
              <td>".$info['prenom']."</td>
              <td>".$info['pseudo']."</td>
              <td>".$info['solde']."</td>
              <td>".$info['numero_tel']."</td>
              </tr>";
	// avec load_adh($numcbde) une fonction javascript qui redirige
	// juste vers adherents.php?numcbde=$numcbde
      }
    // Note de Skippy à Pika':
    // Je sais pas trop comment faire un bouton ou un champs Rechercher
    // qui va modifier la requête à envoyer à la base pour remplir les
    // champs et je ne suis pas chaud pour produire toute la liste en js

    // Note de Skippy à Pika':
    // J'ai modifié fiche_page(1) de telle sorte que si l'adhérent est
    // juste préinscrit, on ne puisse que modifier les champs et 
    // "Valider la préinscription" au lieu de "Valider les modifications".
    // j'hésite à faire traiter le formulaire par deux fichiers séparés...
    // Je vais créer un droit INSCRIPTION je crois...
    // Tiens mon windows à côté avec juste Itunes qui tournait vient de
    // Blue Screen sans raisons...
    // Donc soit on crée un onglet "inscriptions" dans la barre supérieure
    // on fait un copier/coller de cette page et on rajoute
    // "WHERE preinscription = 1" à la requête, soit on trouve un moyen 
    // pour ajouter des filtres à la requête (vu qu'on sera obliger de le 
    // faire avec le champs "Rechercher" et on met un "bouton" qui
    // applique le filtre tout en restant sur cette page

    // Résumé: Pour les inscriptions je splitte en une deuxième page
    //         identique ou pas ? 
    // Avis:   Je suis pas pour mais je sais pas trop faire autrement là
?>
    </table>
<?php
  }
?>












