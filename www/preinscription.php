<?php
	include("../php-include/common-includes.php");
	haut_de_page($userinfo,"Pr&eacute;inscription");

	if ($userinfo["numcbde"]==-1) {

		if (isset($_POST["nom"])) { $nom=trim($_POST["nom"]); } else { $nom=""; }
		if (isset($_POST["prenom"])) { $prenom=trim($_POST["prenom"]); } else { $prenom=""; }
		if (isset($_POST["sect"])) { $sect=trim($_POST["sect"]); } else { $sect=""; }
		if (isset($_POST["email"])) { $email=trim($_POST["email"]); } else { $email=""; }
		if (isset($_POST["tel"])) { $tel=trim($_POST["tel"]); } else { $tel=""; }
		if (isset($_POST["sexe"])) { $sexe=trim($_POST["sexe"]); } else { $sexe=""; }

		if (isset($_POST["nom"]) && isset($_POST["prenom"]) && isset($_POST["sexe"]) && isset($_POST["sect"]) && isset($_POST["email"]) && isset($_POST["tel"]) && isset($_POST["mdpA"]) && isset($_POST["mdpB"])) {
			if (!($sexe == "M" || $sexe == "F")) { $errorMsg="Vous &ecirc;tes de sexe inconnu? Soyez honn&ecirc;tes..."; }
			elseif (!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$",$_POST["email"])) {
				$errorMsg="L'adresse e-mail entr&eacute;e ne correspond pas &agrave; une adresse email valide...";
			}
			elseif ($_POST["mdpA"] == $_POST["mdpB"]) {
				$verif_a="SELECT * FROM adherents WHERE email='".mysql_real_escape_string($_POST["email"])."' OR numero_tel='".mysql_real_escape_string($_POST["tel"])."'";
				$verif_aR=mysql_query($verif_a);
				$verif_aR=mysql_fetch_assoc($verif_aR);
				if ($verif_aR["email"] || $verif_aR["tel"]) {
					$errorMsg="L'email ou le t&eauc;tel&eaucte;phone enregistr&eacute; a d&eacute;j&agrave; &eacute;t&eacute; utilis&eacute; !";
				}
				else {
					$requete="INSERT INTO adherents(nom,prenom,sexe,section,email,numero_tel,motdepasse,preinscription) "
					." VALUES('".mysql_real_escape_string($nom)."','".mysql_real_escape_string($prenom)."','$sexe','".mysql_real_escape_string($sect)."','".mysql_real_escape_string($email)."','".mysql_real_escape_string($tel)."','".mysql_real_escape_string(mash($_POST["mdpA"]))."',1)";
					mysql_query($requete);
					$errorMsg="<strong>Votre pr&eacute;inscription a &eacute;t&eacute; effectu&eacute;e avec succ&egrave;s !</strong>";
					// Let's get the administrative thing working
				}
			}
			else {
				$errorMsg="Veuillez entrer des mots de passe identiques...";
			}
			// Formulaire bien reçu !
		}
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
<form action='?' class='formulaire_preinscription' method='POST'>
<table>
<?php	if (isset($errorMsg)) {	?><tr class='preinscr_errMsg'><td colspan='2'><?= $errorMsg ?></td></tr><?php } ?>
<tr><th> Nom : </th><td> <input type='text' name='nom' value='<?= $nom ?>' /> </td></tr>
<tr><th> Pr&eacute;nom : </th><td> <input type='text' name='prenom' value='<?= $prenom ?>' /> </td></tr>
<tr><th> Sexe : </th><td> <select name='sexe'><option value='M'> Masculin </option><option value='F' selected='selected'> F&eacute;minin </option></select> </td></tr>
<tr><th> Section : </th><td> <input type='text' name='sect' value='<?= $sect ?>' /> </td></tr>
<tr><th> Courriel : </th><td> <input type='text' name='email' value='<?= $email ?>' /> </td></tr>
<tr><th> T&eacute;l&eacute;phone : </th><td> <input type='text' name='tel' value='<?= $tel ?>' /> </td></tr>
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
