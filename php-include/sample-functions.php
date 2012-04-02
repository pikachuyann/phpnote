<?php

// Pour sauvegarder et charger les $_POST et $_GET
function save($name, $double_array)
{
  $keys = "";
  $data = "";
  foreach($double_array as $key => $value)
    {
      $keys = $keys.";".$key;
      $data = $data.";".$value;
    }
  setcookie($name."_keys", substr($keys, 1));
  setcookie($name."_data", substr($data, 1));
}

function load($name)
{
  $keys = explode(";", $_COOKIE[$name."_keys"]);
  $data = explode(";", $_COOKIE[$name."_data"]);
  if (count($keys) != count($data))
    die("Un ; dans un $_POST ou un $_GET, c'est mal !");
  return(array_combine($keys, $data));
}

// Fonctions générales
function protect($text)
{
  return(mysql_real_escape_string(htmlspecialchars($text)));
}

// Fonction de hashage des mots de passes dans la base
function mash($text)
{
  return(md5($text));
}