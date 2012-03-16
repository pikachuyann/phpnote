<?php

function gen_sid()
{
  global $sqlPointer;
  $chaine = "azertyuiopqsdfghjklmwxcvbn1234567890";
    // Non mon clavier n'est pas du tout un azerty !
  $res = "";
  for ($i = 0; $i < 32; $i++)
    {
      $res .= $chaine[rand(0, 35)];
    }
  return($res);
}

function do_login($post)
{
  global $sqlPointer;
  $req = "SELECT numcbde FROM Adherents 
          WHERE pseudo='".protect($post['user'])."' 
            AND motdepasse='".mash($post['pwd'])."'
            AND valide=1;";
  $reponse = mysql_query($req, $sqlPointer);
  if ($traiter = mysql_fetch_array($reponse))
    {
      do
	{
	  $s = gen_sid();
	  $req = "SELECT COUNT(*) AS c FROM sid 
                  WHERE sid.sid='".$s."';";
	  $reponse = mysql_query($req);
	  $t = mysql_fetch_array($reponse);
	}
      while($t['c'] != 0);
      $req = "INSERT INTO sid (sid, expircomplet, expiration, numcbde)
              VALUES ('".$s."', '".date("Y-m-d H:i:s", time()+TEMPS_EXPIRCOMPLET)."', '".date("Y-m-d H:i:s", time()+TEMPS_EXPIRE)."', ".$traiter['numcbde'].");";
      mysql_query($req);
      setcookie('sid', $s);
    }
}
  else
    { return 1; }
  // ToDo 
}

function login_page($source, $msg)	{
  $userinfo["numcbde"]=-1;
  haut_de_page($userinfo,"Identification n&eacute;cessaire");
?>
<p>Bienvenue sur <strong>phpnote</strong>.</p>
<p><?= $msg ?></p>
<form method="post" action="<?= $source ?>">
<table>
<tr><td>Nom d'utilisateur:</td><td><input type="text" name="user"/></td></tr>
<tr><td>Mot de passe:</td><td><input type="password" name="pwd"/></td></tr>
<? // Pour la gestion des levels ?>
<tr><td>Droits:</td>
  <td><input type="radio" name="level" value="2" id="level2" checked="checked"/><label for="level2">Tous mes droits</label></td></tr>
<tr><td></td>
  <td><input type="radio" name="level" value="1" id="level1"/><label for="level1">Droits note seulement</label></td></tr>
<tr><td></td>
  <td><input type="submit" value="Envoyer"/></td></tr>
</table>
</form>

<?= bas_de_page(NULL) ?>
<?php
}
?>
