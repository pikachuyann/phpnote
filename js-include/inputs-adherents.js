function adh_bool_js(var sortie, var defaut)
{
  document.getElementById("boolbutton").innerHTML = "<input type=\"checkbox\" name=\""+sortie+"\" value=\""+defaut+"\"/>";
}

function adh_textbox_js(var sortie, var defaut)
{
  document.getElementById("textbox").innerHTML = "<input type=\"text\" name=\""+sortie+"\" value=\""+defaut+"\"/>";
}
