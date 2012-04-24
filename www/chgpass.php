<?php

include('../php-include/common-includes.php');
include('../php-include/adherents/passwd-functions.php');

haut_de_page($userinfo, "Changer un mot de passe");

// La gestion des droits est gérée par les passwd_page() et password_change() en interne
if (!isset($_GET['numcbde']))
  {
    echo "<p>Aucun mot de passe à changer</p>";
  }
else
  {
    if (!isset($_POST['mdp1']) || !isset($_POST['mdp2']))
      {
	passwd_page($_GET['numcbde']);
      }
    else
      {
	
	if ($_POST['mdp1'] != $_POST['mdp2'])
	  {
	    echo "<p>Les deux mots de passes fournis sont diff&eacute;rents</p>";
	    passwd_page($_GET['numcbde']);
	  }
	else
	  {
	    if (passwd_change($_GET['numcbde'], $_POST['mdp1']))
	      {
		echo "<p>Changement de mot de passe effectu&eacute; avec succ&eacute;s</p>";
		echo "<p>Redirection automatique dans 2 secondes</p>";
						
		if ($_GET['numcbde'] == $userinfo['numcbde'])
		  {
		    // modifier le header pour rediriger vers Mon Compte 
		    // après 5 secondes
		    echo "<script type=\"text/javascript\">
                      function redi()
                      {
                        window.location=\"moncompte.php\";
                      }
                      setTimeout(\"redi()\", 2000);
                      </script>"; 
		  }
		else
		  {
		    // modifier le header pour rediriger vers 
		    // adherents.php?numcbde= $_POST['numcbde'] 
		    // après 5 secondes
		    echo "<script type=\"text/javascript\">
                      function redi()
                      {
                        window.location=\"adherents.php?numcbde=".$_GET['numcbde']."\";
                      }
                      setTimeout(\"redi()\", 2000);
                      </script>"; 
		  }
	      }
	    else
	      {
		echo "<p>Une erreur est survenue</p>";
		passwd_page($_GET['numcbde']);
	      }
          }
      }
  }
bas_de_page($userinfo);

?>
