<?php

function adh_textbox($nom_de_sortie, $par_defaut, $modifiable)
{
?>
  <span id="textbox"<?php if ($modifiable) { ?> onClick="adh_textbox_js(<?= $nom_de_sortie ?>, <?= $par_defaut ?>)" <?php } ?>><?= $par_defaut ?><input type="hidden" name="<?= $nom_de_sortie ?>" value="<?= $par_defaut ?>"/></span>
<?php
}

function adh_bool($nom_de_sortie, $par_defaut, $modifiable)
{
  if ($par_defaut) 
    {
      $ftext = "oui"; 
      $hdef = "checked";
    }
  else 
    {
      $ftext = "non";
      $hdef = "unchecked";
    }
?>
  <span id="boolbutton"<?php if ($modifiable) { ?> onClick="adh_bool_js(<?= $nom_de_sortie ?>, <?= $hdef ?>)"<?php } ?>><?= $ftext ?><input type="hidden" name="<?= $nom_de_sortie ?>" value="<?= $hdef ?>" /></span>

<?php
}

?>

