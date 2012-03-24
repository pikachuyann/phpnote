<?php

include('../php-include/common-includes.php');

$passe_droit = su(ADHERENTS) | ($userinfo['numcbde'] == $_POST['numcbde']);

$req = "UPDATE adherents SET ";
if ($passe_droit)
  {
    $req = $req."pseudo='".protect($_POST['pseudo'])."',
                 section='".protect($_POST['section'])."', 
                 email='".protect($_POST['email'])."', 
                 numero_tel='".protect($_POST['numero_tel'])."', 
                 pb_sante='".protect($_POST['pb_sante'])."'";

    if ($_POST['preinscription']=="1" && su(INSCRIPTION))
      {
	$req = $req.", valide=1, preinscription=0";
      }
    else if (su(BUREAU))
      {
	$req = $req.", valide=".protect($_POST['valide']);
      }
    if (su(BUREAU))
      {
	$req = $req.", fonctions='".protect($_POST['fonctions'])."'";
	if (su(SUPREME))
	  {
	    $req = $req.", nom='".protect($_POST['nom'])."', 
                           prenom='".protect($_POST['prenom'])."'";
	  }
      }
    $req = $req." WHERE numcbde=".protect($_POST['numcbde']).";";
    if (!mysql_query($req, $sqlPointer))
      {
	echo "BUG!<br/>";
	echo $req;
      }
    else if ($userinfo['numcbde']=$_POST['numcbde'])
      {
	header('Location: moncompte.php');
      }
    else
      {
	header('Location: adherents.php?numcbde='.$_POST['numcbde']);
      }
  }
else
  {
    echo msg_nondroits(ADHERENTS);
    exit();
  }