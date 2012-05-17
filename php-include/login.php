<?php

	/* Gestion des identifications */
if (isset($_POST['user']) && isset($_POST['pwd']))
  {
    $login_ok = do_login($_POST);
    if (isset($_COOKIE['post_keys']))
      $_POST = load('post');
    if (isset($_COOKIE['get_keys']))
      $_GET = load('get');
    setcookie('post', "", time() - 1);
    setcookie('get', "", time() - 1);
    if ($login_ok == 1)
      {
	if (isset($_COOKIE['source']))
	  {
	    login_page($_COOKIE['source'], "Couple Nom d'utilisateur/Mot de passe invalide");
	  }
	else
	  {
	    login_page("index.php", "Couple Nom d'utilisateur/Mot de passe invalide");
	  }
      }
  }
else
  {
    if (!isset($_COOKIE["sid"])) {}
    else {
      $sid=mysql_real_escape_string($_COOKIE["sid"]);
      /* Il faudrait trouver un meilleur moyen pour traiter l'expiration des SID */
      $reply=mysql_query("SELECT * FROM sid, adherents WHERE sid.sid='$sid' AND sid.expiration>NOW() AND sid.numcbde=adherents.numcbde");
      while ($answer=mysql_fetch_assoc($reply)) { // Le sid étant unique
	// On a plus ou moins l'userinfo dans la réponse...
	$upd_req="";
	if (strtotime($answer["expircomplet"]) > $time) {
	  $upd_req=", expircomplet='".date("Y-m-d H:i:s", time()+TEMPS_EXPIRCOMPLET)."'";
	}
	else {
	  $answer["droits"] = $answer["droits"] & NOTE;
	  $answer["supreme"] = false;
	}
	mysql_query("UPDATE sid SET expiration='".date("Y-m-d H:i:s", time()+TEMPS_EXPIRE)."'$upd_req WHERE sid='$sid'");
	$userinfo=$answer;
      }
    }	
    if (!isset($userinfo)) {
      $userinfo["numcbde"]=-1;
      $userinfo["droits"]=0;
      $userinfo["supreme"]=false;
    }
    elseif (!$userinfo["valide"]) {
      $userinfo["droits"]=0;
      $userinfo["supreme"]=false;
    }
  }

function gen_sid()
{
  global $sqlPointer;
  $chaine = "azertyuiopqsdfghjklmwxcvbn1234567890";
    // Non mon clavier n'est pas du tout un azerty !
  $res = "";
  for ($i = 0; $i < 42; $i++)
    {
      $res .= $chaine[rand(0, 35)];
    }
  return($res);
}

function do_level1()
{
  global $sqlPointer,$_COOKIE,$userinfo;
  $req = "UPDATE sid SET expircomplet='00-00-00 00:00:00' WHERE numcbde=".$userinfo["numcbde"].";";
  mysql_query($req, $sqlPointer) or die(mysql_error());
  $userinfo["droits"] = $userinfo["droits"] & NOTE;
  $userinfo["supreme"] = false;
}

function do_login($post)
{
  global $sqlPointer,$_COOKIE,$userinfo;
  $req = "SELECT numcbde FROM adherents 
          WHERE pseudo='".protect($post['user'])."' 
            AND motdepasse='".mash($post['pwd'])."'
            AND valide=1;";
  $reponse = mysql_query($req, $sqlPointer);
  //echo $req;
  if ($traiter = mysql_fetch_array($reponse))
    {
      do
	{
	  $s = gen_sid();
	  $req = "SELECT COUNT(*) AS c FROM sid 
                  WHERE sid.sid='".$s."';";
	  $reponse = mysql_query($req, $sqlPointer);
	  $t = mysql_fetch_array($reponse);
	}
      while($t['c'] != 0);
      // On supprime les anciennes sessions
      // => on ne peut pas lancer plus d'une session en même temps avec un couple login/mdp
      $req = "DELETE FROM sid WHERE numcbde=".$traiter['numcbde'].";";
      // On commence une nouvelle session
      $req = "INSERT INTO sid (sid, expircomplet, expiration, numcbde)
              VALUES ('".$s."', '";
      if ($post["level"] == 2)
	{
	  $req .= date("Y-m-d H:i:s", time()+TEMPS_EXPIRCOMPLET);
	}
      else
	{
	  $req .= '00-00-00 00:00:00';
	}
      $req .= "', '".date("Y-m-d H:i:s", time()+TEMPS_EXPIRE)."', ".$traiter['numcbde'].");";
      mysql_query($req, $sqlPointer);
      setcookie('sid', $s);
      $reqb = "SELECT * FROM adherents WHERE numcbde='".$traiter['numcbde']."'";
      $userinfo=mysql_fetch_assoc(mysql_query($reqb));
      if ($post["level"] != 2)
	{
	  $userinfo["droits"] = $userinfo["droits"] & NOTE;
	  $userinfo["supreme"] = false;
	}
      $_COOKIE['sid']=$s;

      return 0;
    }
  else
    { return 1; } 
}

function login_page($source, $msg)	
{
  global $userinfo;
  setcookie('source', $source);
  save('post', $_POST);
  save('get', $_GET);
  // $userinfo["numcbde"]=-1; << Pourquoi ai-je fais cela ?
  haut_de_page($userinfo,"Identification n&eacute;cessaire");
?>
<!-- <p>Bienvenue sur <strong>phpnote</strong>.</p> -->
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

<?php
  bas_de_page(NULL);
  exit();
}
?>
