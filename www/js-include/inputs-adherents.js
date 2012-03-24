// On a une checkbox qui apparaît quand on clique sur la valeur modifiable
function adh_bool_js(var sortie, var defaut)
{
    document.getElementById("boolbutton_"+sortie).innerHTML = "<input type=\"checkbox\" name=\""+sortie+"\" value=\""+defaut+"\"/>";
}

// On a une zone de texte qui apparaît quand on clique sur la valeur modifiable
function adh_textbox_js(var sortie, var defaut)
{
    document.getElementById("textbox_"+sortie).innerHTML = "<input type=\"text\" name=\""+sortie+"\" value=\""+defaut+"\"/>";
}

// Ou comment faire un lien...
function load_adh(var num)
{
    window.location = "adherents.php?numcbde="+num;
}

function load_myaccount()
{
    window.location = "moncompte.php";
}