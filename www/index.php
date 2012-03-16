<?php
	include("../php-include/common-includes.php");
if (isset($_POST['user']) & isset($_POST['pwd']))
  {
    do_login($_POST);
  }
        if ($userinfo["numcbde"] == -1) {	
		login_page("index.php","Salut ? Qui es-tu ?");
	}
	else {
	haut_de_page($userinfo);
?>
<p>Bienvenue sur phpNote, la <i>note Kfet</i> en php en cours de d&eacute;veloppement !</p>
<p>Vous pouvez utiliser le menu ci-dessus pour naviguer dans la note Kfet !</p>
<?php	bas_de_page($userinfo);	
	}	?>
