<?php

function adh_textbox($nom_de_sortie, $par_defaut, $modifiable)
{
?>
<span id="textbox_<?= $nom_de_sortie ?>"<?php 
  if ($modifiable) 
    { 
?> onClick="adh_textbox_js('<?= $nom_de_sortie ?>', '<?= $par_defaut ?>')" <?php 
    } 
?>>
<?= $par_defaut ?>
<input type="hidden" name="<?= $nom_de_sortie ?>" value="<?= $par_defaut ?>"/>
</span>
<?php
}

function adh_bool($nom_de_sortie, $par_defaut, $modifiable)
{
  if ($par_defaut) 
    {
      $real_name = "oui"; 
      $html_def = "checked";
    }
  else 
    {
      $real_name = "non";
      $html_def = "unchecked";
    }
?>
<span id="boolbutton_<?= $nom_de_sortie ?>"<?php 
  if ($modifiable) 
    { 
?> onClick="adh_bool_js('<?= $nom_de_sortie ?>', '<?= $html_def ?>')"<?php 
    } 
?>>
<?= $real_name ?>
<input type="hidden" name="<?= $nom_de_sortie ?>" value="<?= $html_def ?>" />
</span>
<?php
}
?>

