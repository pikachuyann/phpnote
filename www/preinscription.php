<?php
	include("../php-include/common-includes.php");
	haut_de_page($userinfo,"Pr&eacute;inscription");
	if ($userinfo["numcbde"]==-1) {
// Note de Skippy à Pika': 
//  j'ai ajouté un champs preinscription à la table adherents et un droit
//  INSCRIPTION pour gérer les inscriptions (à moins qu'on dit que c'est le
//  droit ADHERENTS)
//  Je m'occupe de l'administration des adhérents

/* Vu, thanks */
?>
<div class='titre_de_page'>Bienvenue sur la page de pr&eacute;inscription &agrave; phpNote !</div>
<p>Pour vous inscrire &agrave; phpNote, vous devez:</p>
<ul style='margin-top:0px;'>
<li> Remplir ce formulaire de pr&eacute;inscription. Certains champs sont obligatoires (et sont signal&eacute;s par une ast&eacute;risque (*)), d'autres ne le sont pas. Il est pr&eacute;f&eacute;rable de remplir enti&egrave;rement ce formulaire. Les informations enregistr&eacute;es dans ce formulaire ne seront pas utilis&eacute;es en dehors de la phpNote. <i>Attention: C'est une base de <strong>test</strong> qui n'est pas enregistr&eacute;e &agrave; la CNIL !</i> </li>
<li> Votre inscription sera ensuite valid&eacute;e par l'un des codeurs de cette phpNote, apr&egrave;s demande de votre part. </li>
</ul>
<p> Le formulaire n'est pas encore fonctionnel (hum...) </p>
<form action='?' class='formulaire_preinscription'>
<table>
<tr><th> Nom : </th><td> <input type='text' name='nom' /> </td></tr>
<tr><th> Pr&eacute;nom : </th><td> <input type='text' name='prenom' /> </td></tr>
<tr><th> Sexe : </th><td> <select name='sexe'><option value='M'> Masculin </option><option value='F'> F&eacute;minin </option></select> </td></tr>
<tr><th> Section : </th><td> <input type='text' name='sect' /> </td></tr>
<tr><th> Courriel : </th><td> <input type='text' name='email' /> </td></tr>
<tr><th> T&eacute;l&eacute;phone : </th><td> <input type='text' name='tel' /> </td></tr>
<tr><th> Mot de passe : </th><td> <input type='password' name='mdpA' /> </td></tr>
<tr><th> Confirmation : </th><td> <input type='password' name='mdpB' /> </td></tr>
<tr><th> &nbsp; </th><td> <input type='submit' value='Se pr&eacute;inscrire !' /> </td></tr>
</table>
</form>
<?php	}	else {	?>
<p>Vous n'&ecirc;tes pas autoris&eacute;s &agrave; voir cette page...</p>
<?php	}
	bas_de_page($userinfo);
	?>
