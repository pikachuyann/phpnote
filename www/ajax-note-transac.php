<?php

include("../php-include/common-includes.php");

if (!su(NOTE)) {
	login_page("note.php", msg_nondroits(NOTE));
}
else {
	$cli=$_GET["trClient"];
	$con=$_GET["trConsos"];

	$cli=explode('|',$cli);
	$con=explode('|',$con);

	$requetes="";

	for ($i=0;$i < count($cli);$i++) {
		for ($j=0; $j < count($con);$j++) {
			$emetteur=mysql_real_escape_string($cli[$i]);

			$bouton=mysql_real_escape_string($con[$j]);
			$req=mysql_query("SELECT * FROM boutons WHERE id='$bouton'");
			$rep=mysql_fetch_assoc($req);
			if ($rep["id"]>0) {
				$receveur=$rep["receveur"];
				$cout=$rep["montant"];
				$commentaire=mysql_real_escape_string($rep["nom"]);
				$requetes.="UPDATE adherents SET solde=solde+$cout WHERE numcbde=$receveur;\n";
				$requetes.="UPDATE adherents SET solde=solde-$cout WHERE numcbde=$emetteur;\n";
				$requetes.="INSERT transactions(emetteur,recepteur,montant,idconso,commentaire,valide) VALUES('$emetteur','$receveur','$cout','$bouton','$commentaire',1);\n";
			}
		}
	}

	$requete="LOCK TABLES adherents WRITE, transactions WRITE;\n";
	$requete.=$requetes;
	$requete.="UNLOCK TABLES;\n";

	$liste_requete=explode("\n",$requete);
	for ($k=0;$k < count($liste_requete);$k++) {
		echo "($k) ".$liste_requete[$k];
		mysql_query($liste_requete[$k]);
	}

//	echo $requete;


}
?>
