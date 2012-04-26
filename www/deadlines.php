<?php
	include("../php-include/common-includes.php");
	haut_de_page($userinfo,"Deadlines");

?>
<div class='titre_de_page'>Deadlines du projet phpNote</div>
<p>Les dates (pr&eacute;vues en objectif) du projet PHP :</p>
<ul style='margin-top:0px;'>
<li> 20 mai 2012 : avoir rendu le rapport de projet </li>
<li> 25 mai 2012 : soutenance </li>
</ul>
<p>Les dates de la phpNote :</p>
<ul style='margin-top:0px;'>
<li> <strong>Version &beta; 0.1:</strong> 26 avril 2012, 16h46 
<ul style='margin-top:0px;'>
<li> Gestion des pr&eacute;inscription et des adh&eacute;rents (modification des informations, (d&eacute;)validations…) , de la modification des droits </li>
</ul>
<li> <strong>Version &beta; 0.2:</strong>
<ul style='margin-top:0px;'>
<li> Gestion des boutons </li>
<li> La Note en elle-m&ecirc;me (transferts, utilisations de boutons pour un adh&eacute;rent pr&eacute;cis), en version largement am&eacute;liorable (type version &alpha;)</li>
</ul>
<li> … </li>
<li> <strong>Version finale:</Strong> avant le 18 mai 2012
<ul style='margin-top:0px;'>
<li> Gestion des transactions: 
<ul style='margin-top:0px;'>
<li> Rajout ou retrait d'argent sur le compte </li>
<li> Utilisation des boutons </li>
<li> Transactions entre adh&eacute;rents </li>
<li> Recherche efficace d'un adh&eacute;rent, en prenant en compte l'historique des pseudos </li>
</ul>
<li> Gestion des adh&eacute;rents :
<ul style='margin-top:0px;'>
<li> Modification des noms de note (pseudos), des droits, et des informations sur les comptes </li>
</ul>
<li> Gestion des activit&eacute;s :
<ul style='margin-top:0px;'>
<li> Cr&eacute;ation et modification des activit&eacute;s, de leurs lieux, de leurs dates, et de leurs responsables (a choisir parmi les adh&eacute;rents) </li>
<li> Disponibilit&eacute; d'un fichier externe (<i>xml</i>) permettant de pouvoir voir les activit&eacute;s de l'ext&eacute;rieur.
</ul>
</ul>
</ul>
<?php	
bas_de_page($userinfo);
	?>
