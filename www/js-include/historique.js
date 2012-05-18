var myCurrentScroll = 0;
var maxContent = 30;
var nbTransac = 0;
var derniereRequeteH;
var h = document.getElementById('historique');

/*
  L'argument adh permet de filtrer les résultat sur un adhérent en particulier.
  Comme ça on a pas besoin de réécrire toutes les fonctions pour afficher
  l'historique d'un adhérent.
  DEPEND: www/ajax-note-historique.php
*/
function historique_scroll(sel, adh)
{
    if (derniereRequeteH && derniereRequeteH.readyState < 4)
    {
	
    }
    else if (sel.scrollTop > sel.scrollHeight - sel.clientHeight - 20 && maxContent < nbTransac)
    {
	//alert('toto');
	/*
	  si on est à la fin de la barre de scroll et qu'on a pas charger toute la
	  table, on lui demande les autres transactions à afficher.
	*/
	myCurrentScroll = sel.scrollTop;
	//maxContent = h.options.length;
	var xhr = new XMLHttpRequest();
	if (adh == -1)
	{
	    //alert(h.options[h.options.length - 1].value);
	    xhr.open('GET', 'http://phpnote.pikachuyann.fr/ajax-note-historique.php?offset='+encodeURIComponent(h.options[h.options.length -1].value));
	}
	else
	{
	    xhr.open('GET', 'http://phpnote.pikachuyann.fr/ajax-note-historique.php?offset='+encodeURIComponent(h.options[h.options.length - 1].value)+"&adh="+encodeURIComponent(adh));
	}
	xhr.onreadystatechange = function() {
	    if (xhr.readyState == 4 && xhr.status == 200) {
		h.innerHTML = h.innerHTML + xhr.responseText;
		h.scrollTop = myCurrentScroll;
		maxContent = h.options.length;
		//alert(maxContent+'|'+nbTransac);
	    }
	};
	xhr.send(null);
	derniereRequeteH = xhr;
    }
}

/*
  Cf commentaire à l'intérieur
  DEPEND: www/ajax-note-historique.php
*/
var madh = -1;
function historique_reset(adh)
{
    madh = adh;
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
	    /*
	      Compte le nombre total de transactions, histoire que quand t'as 
	      scrollé toute la table, le navigateur ne continue pas à spammer
	      de requêtes AJAX.
	    */
	    historique_really_reset(adh);
	}
    };
    xhr.send(null);
    derniereRequeteH = xhr;
}

/*
  C'est cette fonction qui recharge réellement les 30 premières entrées de
  l'historique. Elle s'exécute seulement après avoir calculé le nombre maximal
  de transactions à afficher pour des raisons expliquer plus haut.
  DEPEND: www/ajax-note-historique.php
*/
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
	    xhr.open('GET', 'http://phpnote.pikachuyann.fr/ajax-note-historique.php?count=30');
	}
	else
	{
	    xhr.open('GET', 'http://phpnote.pikachuyann.fr/ajax-note-historique.php?count=30&adh='+encodeURIComponent(adh));
	}
	xhr.onreadystatechange = function() {
	    if (xhr.readyState == 4 && xhr.status == 200) {
		h.innerHTML = xhr.responseText;
		maxContent = h.options.length;
		/*
		  Remet à jour la liste des transactions
		*/
	    }
	};
	xhr.send(null);
	derniereRequeteH = xhr;
    }
}

/*
  DEPRECATED:
  Permettait de recharger l'historique à chaque transactions, mais cela
  poser un problème: si deux transactions sont exécutées en parallèle, le résultat
  de cette commande est non définit.
  Du coup, il vaut mieux recharger l'historique via "historique_reset()".
  Avant que je fixe à 30 le nombre de résultats rechargé, cela pouvait entraîner
  des attaques de déni de service assez aisément en fonctionnement normal.
  Mais maintenant plus de soucis.
  DEPEND: www/ajax-note-historique.php
*/
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

/*
  Cherche dans le <select> les options cochées pour les valider/dévalider
*/
function historique_unvalidate()
{
    var content = document.getElementById('historique');
    for (var i = 0; i < content.options.length; i++)
    {
	if (content.options[i].selected)
	{
	    //alert("unvalid "+content.options[i].value);
	    var xhr = new XMLHttpRequest();
	    xhr.open('GET', 'http://phpnote.pikachuyann.fr/ajax-note-valid.php?tid='+encodeURIComponent(content.options[i].value)+'&action=0');
	    
	    xhr.onreadystatechange = function() {
		if (xhr.readyState == 4 && xhr.status == 200) {
		    historique_reset(madh);
		}
	    };
	    
	    xhr.send(null);
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
	    //alert("valid "+content.options[i].value);
	    var xhr = new XMLHttpRequest();
	    xhr.open('GET', 'http://phpnote.pikachuyann.fr/ajax-note-valid.php?tid='+encodeURIComponent(content.options[i].value)+'&action=1');
	    
	    xhr.onreadystatechange = function() {
		if (xhr.readyState == 4 && xhr.status == 200) {
		    historique_reset(madh);
		}
	    };
	    
	    xhr.send(null);
	}
    }
}