function chgCategorie(id_categ, nvelle_valeur)
	{
	 var xhr = new XMLHttpRequest();
	var texte = document.getElementById("categ"+id_categ).innerHTML;
	var categswitch = 0;

        var pattern = /A/;
	if (texte.match(pattern)) { categswitch = 0; }
	else { categswitch = 1; }
	 xhr.open('GET', 'http://phpnote.pikachuyann.fr/ajax-boutons.php?ctgId='+id_categ+'&switch_to='+categswitch);
	 
	 xhr.onreadystatechange = function() {
	     if (xhr.readyState == 4 && xhr.status == 200) {
		 document.getElementById('categ'+id_categ).innerHTML = xhr.responseText;
	     }
	 };
	 xhr.send(null);
	 return xhr;
     }
