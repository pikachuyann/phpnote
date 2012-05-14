var maxScroll = 0;
var maxContent = 0;
var derniereRequeteH;

function historique_scroll(sel, adh = -1)
{
    if (AncienneRequeteH && AncienneRequeteH.readyState < 4)
    {
	sel.scrollTop = maxScroll;
    }
    else if (sel.scrollTop > maxScroll)
    {
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
		document.getElementById('historique_content').innerHTML = document.getElementById('historique_content').innerHTML + xhr.responseText;
		maxContent += 30;
		maxScroll = document.getElementById('historique').scrollTop;
	    }
	};
	xhr.send(null);
	derniereRequeteH = xhr;
    }
}

function historique_reset()
{
    if (derniereRequeteH && derniereRequeteH.readyState < 4)
    {
	dernireRequeteH.abort();
    }
    else
    {
	var xhr = new XMLHttpRequest();
	xhr.open('GET', 'http://phpnote.pikachuyann.fr/ajax-note-historique.php?limit='+encodeURIComponent(maxContent));
	 
	xhr.onreadystatechange = function() {
	    if (xhr.readyState == 4 && xhr.status == 200) {
		document.getElementById('historique_content').innerHTML = xhr.responseText;
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
	    alert("unvalid "+content.options[i].id);
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
	    alert("valid "+content.options[i].id);
	}
    }
}