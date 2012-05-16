var myCurrentScroll = 0;
var maxContent = 30;
var nbTransac = 0;
var derniereRequeteH;

function historique_scroll(sel, adh)
{
    if (derniereRequeteH && derniereRequeteH.readyState < 4)
    {
	
    }
    else if (sel.scrollTop > sel.scrollHeight - sel.clientHeight - 20 && maxContent < nbTransac)
    {
	//alert("plop");
	myCurrentScroll = sel.scrollTop;
	var xhr = new XMLHttpRequest();
	if (adh == -1)
	{
	    xhr.open('GET', 'http://phpnote.pikachuyann.fr/ajax-note-historique.php?offset='+encodeURIComponent(maxContent));
	}
	else
	{
	    xhr.open('GET', 'http://phpnote.pikachuyann.fr/ajax-note-historique.php?offset='+encodeURIComponent(maxContent)+"&adh="+encodeURIComponent(adh));
	}
	xhr.onreadystatechange = function() {
	    if (xhr.readyState == 4 && xhr.status == 200) {
		var h = document.getElementById('historique');
		h.innerHTML = h.innerHTML + xhr.responseText;
		h.scrollTop = myCurrentScroll;
		maxContent += 20;
	    }
	};
	xhr.send(null);
	derniereRequeteH = xhr;
    }
}

function historique_reset(adh)
{
    var xhr = new XMLHttpRequest();
    if (adh == -1)
    {
	xhr.open('GET', 'http://phpnote.pikachuyann.fr/ajax-note-historique.php?nb=1');	
    }
    else
    {
	xhr.open('GET', 'http://phpnote.pikachuyann.fr/ajax-note-historique.php?nb=1&adh='+encodeURIComponent(adh));
    }	
    xhr.onreadystatechange = function() {
	if (xhr.readyState == 4 && xhr.status == 200) {
	    nbTransac = xhr.responseText;
	    historique_really_reset(adh);
	}
    };
    xhr.send(null);
    derniereRequeteH = xhr;
}

function historique_really_reset(adh)
{
    if (derniereRequeteH && derniereRequeteH.readyState < 4)
    {
	dernireRequeteH.abort();
    }
    else
    {
	var xhr = new XMLHttpRequest();
	if (adh == -1)
	{
	    xhr.open('GET', 'http://phpnote.pikachuyann.fr/ajax-note-historique.php?count='+encodeURIComponent(maxContent));
	}
	else
	{
	    xhr.open('GET', 'http://phpnote.pikachuyann.fr/ajax-note-historique.php?count='+encodeURIComponent(maxContent)+'&adh='+encodeURIComponent(adh));
	}
	xhr.onreadystatechange = function() {
	    if (xhr.readyState == 4 && xhr.status == 200) {
		document.getElementById('historique').innerHTML = xhr.responseText;
	    }
	};
	xhr.send(null);
	derniereRequeteH = xhr;
    }
}

function historique_add(n)
{
    if (derniereRequeteH && derniereRequeteH.readyState < 4)
    {
	dernireRequeteH.abort();
    }
    else
    {
	var xhr = new XMLHttpRequest();
	xhr.open('GET', 'http://phpnote.pikachuyann.fr/ajax-note-historique.php?count='+encodeURIComponent(n));
	 
	xhr.onreadystatechange = function() {
	    if (xhr.readyState == 4 && xhr.status == 200) {
		document.getElementById('historique').innerHTML = xhr.responseText+document.getElementById('historique').innerHTML;
		maxContent += n;
	    }
	};
	xhr.send(null);
	derniereRequeteH = xhr;
    }
}

function historique_unvalidate()
{
    var content = document.getElementById('historique');
    for (var i = 0; i < content.options.length; i++)
    {
	if (content.options[i].selected)
	{
	    alert("unvalid "+content.options[i].value);
	}
    }
}

function historique_validate()
{
    var content = document.getElementById('historique');
    for (var i = 0; i < content.options.length; i++)
    {
	if (content.options[i].selected)
	{
	    alert("valid "+content.options[i].value);
	}
    }
}