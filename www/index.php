<?php
include("../php-include/common-includes.php");

if ($userinfo["numcbde"] == -1) {	
  login_page("index.php","Bienvenue sur <strong>phpNote</strong>, veuillez vous identifier pour acc&eacute;der aux diff&eacute;rentes pages de gestion de la note. Si vous ne disposez pas de compte, vous pouvez vous pr&eacute;inscrire.");
}
elseif (!su(INTRANET)) 
{	
  login_page("index.php","Votre note est bloqu&eacute;e !");
}
else
{
  haut_de_page($userinfo);
?>
<p>Bienvenue sur phpNote, la <i>note Kfet</i> en php en cours de d&eacute;veloppement !</p>
<p>Vous pouvez utiliser le menu ci-dessus pour naviguer dans la note Kfet !</p>
<?php	
  bas_de_page($userinfo);	
}
?>
