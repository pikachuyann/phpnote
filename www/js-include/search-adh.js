(function()
 {
     var searchElement = document.getElementById('search');
     var results = document.getElementById('results');
     var previousRequest;
     var previousValue = searchElement.value;

     function getResults(filtre)
     {
	 var xhr = new XMLHttpRequest();
	 xhr.open('GET', 'http://phpnote.pikachuyann.fr/adh-ajax.php?filtre='+encodeURIComponent(filtre));
	 
	 xhr.onreadystatechange = function() {
	     if (xhr.readyState == 4 && xhr.status == 200) {
		 results.innerHTML = xhr.responseText;
	     }
	 };
	 xhr.send(null);
	 return xhr;
     }

     searchElement.onkeyup = function(e)
     {
	 if (searchElement.value != previousValue)
	 {
	     previousValue = searchElement.value;
	     if (previousRequest && previousRequest.readyState < 4)
		 previousRequest.abort();

	     previousRequest = getResults(previousValue);
	 }
     };   
 }) ();