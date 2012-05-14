<?php

include("../php-include/common-includes.php");


function str_real_pad($string, $taille, $alignement = STR_PAD_RIGHT)
{
  if (strlen($string) > $taille)
    {
      return substr($string, 0, $taille);
    }
  else
    {
      return str_pad($string, $taille, " ", $alignement);
    }
}

if (!su(NOTE))
  {
    login_page("note.php", msg_nondroits(NOTE));
  }
else
  {
    $offset = 1;
    if (isset($_GET["offset"]))
      $offset = $_GET["offset"];
    if (!isset($_GET["adh"])
      {
	$req = "SELECT t.id, t.date, a1.pseudo AS nom_emetteur, a2.pseudo AS nom_destinataire, b.nom AS nom_conso, t.montant, t.valide 
                FROM transactions AS t
                INNER JOIN adherents AS a1 ON t.emetteur=a1.numcbde
                INNER JOIN adherents AS a2 ON t.destinataire=a2.numcbde
                INNER JOIN boutons AS b ON t.idconso=b.id
                ORDER BY date DESC
                LIMIT ".protect($offset).", 20;";
      }
    else
      {
	$req = "SELECT t.id, t.date, a1.pseudo AS nom_emetteur, a2.pseudo AS nom_destinataire, b.nom AS nom_conso, t.montant 
                FROM transactions AS t
                INNER JOIN adherents AS a1 ON t.emetteur=a1.numcbde
                INNER JOIN adherents AS a2 ON t.destinataire=a2.numcbde
                INNER JOIN boutons AS b ON t.idconso=b.id
                WHERE (a1.numcbde=".protect($_GET["adh"])." 
                OR     a2.numcbde=".protect($_GET["adh"]).") 
                AND    t.valide=1 
                ORDER BY date DESC
                LIMIT ".protect($offset).", 20;";
      }
    $rep = mysql_query($req, $sqlPointer);
    while($info = mysql_fetch_array($req))
      {
?>	
	  <option value="<?= $info['id'] ?>" >
	  <?= $info["date"] ?> <?= str_real_pad($info["nom_emetteur"], 10) ?> <?= str_real_pad($info["nom_destinataire"], 10) ?> <?= str_real_pad($info["nom_conso"], 10) ?> <?= $info["montant"] ?> <?php if (!isset($_GET["adh"])) { if($info["valide"]) {echo "oui";} else {echo "non";} } ?></option>
<?php
      }
  }
?>