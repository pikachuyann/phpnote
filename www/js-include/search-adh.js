(function()
 {
     var searchNom = document.getElementById('searchnom');
     var searchNote = document.getElementById('searchnote');
     var results = document.getElementById('results');
     var previousRequest;
     var previousNom = searchNom.value;
     var previousNote = searchNote.value;

     function getResults(filtre_nom, filtre_note)
     {
	 var xhr = new XMLHttpRequest();
	 xhr.open('GET', 'http://phpnote.pikachuyann.fr/adh-ajax.php?filtre_nom='+encodeURIComponent(filtre_nom)+'&filtre_note='+encodeURIComponent(filtre_note));
	 
	 xhr.onreadystatechange = function() {
	     if (xhr.readyState == 4 && xhr.status == 200) {
		 results.innerHTML = xhr.responseText;
	     }
	 };
	 xhr.send(null);
	 return xhr;
     }

     searchNom.onkeyup = function(e)
     {
	 if (searchNom.value != previousNom)
	 {
	     previousNom = searchNom.value;
	     if (previousRequest && previousRequest.readyState < 4)
		 previousRequest.abort();

	     previousRequest = getResults(previousNom, previousNote);
	 }
     };   

     searchNote.onkeyup = function(e)
     {
	 if (searchNote.value != previousNote)
	 {
	     previousNote = searchNote.value;
	     if (previousRequest && previousRequest.readyState < 4)
		 previousRequest.abort();

	     previousRequest = getResults(previousNom, previousNote);
	 }
     };   
 }) ();