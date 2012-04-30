<?php

include("../common-includes.php");

function gen_categories()
{
  if(!su(NOTE))
    {
      login_page("note.php", msg_nondroits(NOTE));
    }
  else
    {
      $req = "SELECT * FROM Categories ORDER BY nom";
      $rep = mysql_query($req, $sqlPointer);
      
      while($info = mysql_fetch_array($rep))
	{
	  ?>
	  <button value="<?= $info['nom'] ?>" onClick="note_categ(<?= $info['id'] ?>)"/>
	  <?php
	 }
    }
}
?>