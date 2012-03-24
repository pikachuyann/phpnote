<?php

include('../php-include/common-includes.php');
include('../php-include/adherents/passwd-functions.php');

haut_de_page($userinfo, "Changer un mot de passe");
if (!isset($_POST['numcbde']))
  {
    echo "<p>Aucun mot de passe à changer</p>";
  }
else
  {
    if (!isset($_POST['mdp1']) | !isset($_POST['mdp2']))
      {
	passwd_page($_POST['numcbde']);
      }
    else
      {
	if ($mdp1 != $mdp2)
	  {
	    echo "<p>Les deux mots de passes fournis sont diff&grave;rents</p>";
	    passwd_page($_POST['numcbde']);
	  }
	else
	  {
	    if (passwd_change($_POST['numcbde'], $mdp1))
	      {
		echo "<p>Changement de mot de passe effectu&egrave; avec succ&eacute;s</p>";
				
		if ($_POST['numcbde'] == $userinfo['numcbde'])
		  {
		    // modifier le header pour rediriger vers Mon Compte 
		    // après 5 secondes
		    echo "<script type=\"text/javascript\">
                      function redi()
                      {
                        window.location=\"moncompte.php\";
                      }
                      </script>
                      <span onLoad=\"setTimeout('redi()', 5000)\"></span>";

		  }
		else
		  {
		    // modifier le header pour rediriger vers 
		    // adherents.php?numcbde=<?= $_POST['numcbde'] ?>
		    // après 5 secondes
		    echo "<script type=\"text/javascript\">
                      function redi()
                      {
                        window.location=\"adherents.php?numcbde=".$_POST['numcbde']."\";
                      }
                      </script>
                      <span onLoad=\"setTimeout('redi()', 5000)\"></span>";

		  }
	      }
	    else
	      {
		echo "<p>Une erreur est survenue</p>";
		passwd_page($_POST['numcbde']);
	      }
	  }
      }
  }
bas_de_page($userinfo);
	
?>