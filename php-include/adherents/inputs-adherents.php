<?php

function adh_textbox($nom_de_sortie, $par_defaut, $modifiable)
{
?>
<span id="textbox_<?= $nom_de_sortie ?>"<?php 
  if ($modifiable) 
    { 
?> onClick="adh_textbox_js('<?= $nom_de_sortie ?>', '<?= addslashes($par_defaut) ?>')" <?php 
    } 
?>>
<?= $par_defaut ?>&nbsp;
<input type="hidden" name="<?= $nom_de_sortie ?>" value="<?= $par_defaut ?>"/>
</span>
<?php
}

function adh_td_textbox($nom_de_sortie, $par_defaut, $modifiable)
{
?>
<td id="textbox_<?= $nom_de_sortie ?>"<?php 
  if ($modifiable) 
    { 
?> onClick="adh_textbox_js('<?= $nom_de_sortie ?>', '<?= addslashes($par_defaut) ?>')" <?php 
    } 
?>>
<?= $par_defaut ?>&nbsp;
<input type="hidden" name="<?= $nom_de_sortie ?>" value="<?= $par_defaut ?>"/>
</td>
<?php
}

function adh_bool($nom_de_sortie, $par_defaut, $modifiable)
{
  if ($par_defaut) 
    {
      $real_name = "oui"; 
      $html_def = "checked";
      $html_def2 = "on";
    }
  else 
    {
      $real_name = "non";
      $html_def = "unchecked";
      $html_def2 = "off";
    }
?>
<span id="boolbutton_<?= $nom_de_sortie ?>"<?php 
  if ($modifiable) 
    { 
?> onClick="adh_bool_js('<?= $nom_de_sortie ?>', '<?= $html_def ?>')"<?php 
    } 
?>>
<?= $real_name ?>
<input type="hidden" name="<?= $nom_de_sortie ?>" value="<?= $html_def2 ?>" />
</span>
<?php
}
?>

