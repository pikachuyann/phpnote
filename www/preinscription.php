<?php
	include("../php-include/common-includes.php");
	haut_de_page($userinfo,"Pr&eacute;inscription");
	if ($userinfo["numcbde"]==-1) {
// Note de Skippy à Pika': 
//  j'ai ajouté un champs preinscription à la table adherents et un droit
//  INSCRIPTION pour gérer les inscriptions (à moins qu'on dit que c'est le
//  droit ADHERENTS)
//  Je m'occupe de l'administration des adhérents
?>
<div class='titre_de_page'>Bienvenue sur la page de pr&eacute;inscription &agrave; phpNote !</div>
<p>Pour vous inscrire &agrave; phpNote, vous devez:</p>
<ul style='margin-top:0px;'>
<li> Remplir ce formulaire de pr&eacute;inscription. Certains champs sont obligatoires (et sont signal&eacute;s par une ast&eacute;risque (*)), d'autres ne le sont pas. Il est pr&eacute;f&eacute;rable de remplir enti&egrave;rement ce formulaire. Les informations enregistr&eacute;es dans ce formulaire ne seront pas utilis&eacute;es en dehors de la phpNote. <i>Attention: C'est une base de <strong>test</strong> qui n'est pas enregistr&eacute;e &agrave; la CNIL !</i> </li>
<li> Votre inscription sera ensuite valid&eacute;e par l'un des codeurs de cette phpNote, apr&egrave;s demande de votre part. </li>
</ul>
<?php	}	else {	?>
<p>Vous n'&ecirc;tes pas autoris&eacute;s &agrave; voir cette page...</p>
<?php	}
	bas_de_page($userinfo);
	?>
