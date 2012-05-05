function chgCategorie(id_categ)
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
};

function chgBouton(id_bouton) {
	var xhr = new XMLHttpRequest();
	var texte = document.getElementById("btn"+id_bouton).innerHTML;
	var boutonswitch=0;

	var pattern = /A/;
	if (texte.match(pattern)) { boutonswitch=0; }
	else { boutonswitch=1; }
	xhr.open('GET', 'http://phpnote.pikachuyann.fr/ajax-boutons.php?btnId='+id_bouton+'&switch_to='+boutonswitch);

	xhr.onreadystatechange = function() {
		if (xhr.readyState == 4 && xhr.status == 200) {
			document.getElementById('btn'+id_bouton).innerHTML = xhr.responseText;
		}
	};
	xhr.send(null);
	return xhr;
};

function addBouton() {
	var receveur = document.getElementById("newButtonWho").value;
	var montant = document.getElementById("newButtonValue").value;
	var nom = document.getElementById("newButtonName").value;	

	var categ = document.getElementById("slctCategory").value;

	var xhr = new XMLHttpRequest();

	xhr.open('GET', 'http://phpnote.pikachuyann.fr/ajax-boutons.php?addNB='+categ+'䈥'+nom+'䈥'+montant+'䈥'+receveur);

	xhr.onreadystatechange = function() {
		if (xhr.readyState == 4 && xhr.status == 200) {
			document.getElementById('btnList').innerHTML=document.getElementById('btnList').innerHTML+xhr.responseText;
		}
		else {
		}
	};
	xhr.send(null);
	return xhr;
};

function updBoutons() {
	var categ=document.getElementById("slctCategory").value;

	var xhr = new XMLHttpRequest();
	xhr.open('GET', 'http://phpnote.pikachuyann.fr/ajax-boutons.php?viewB='+categ);

	xhr.onreadystatechange = function() {
		if (xhr.readyState == 4 && xhr.status == 200) {
			document.getElementById('btnList').innerHTML=xhr.responseText;
		}
	};
	xhr.send(null);
	return xhr;
}	
