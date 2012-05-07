var listeClients = new Array();
var listeConsos = new Array();
var derniereRequeteC;

function transaction(plisteClients, plisteConsos)
{
    clients = plisteClients[0].id;
    for (i = 1; i < plisteClients.length; i++)
    {
	clients = clients + "|" + plisteClients[i].id;
    }
    consos = plisteConsos[0].id;
    for (i = 1; i < plisteConsos.length; i++)
    {
	consos = consos + "|" + plisteConsos[i].id;
    }
    alert(clients+"\n"+consos);
}

function note_mouseover(nom, solde)
{
    // Modif d'un innerHTML pour l'affichage
    document.getElementById('affiche_adh_nom').innerHTML = nom;
    document.getElementById('affiche_adh_argent').innerHTML = solde;
}

function escape_all(ch) 
{
    /*
    ch = ch.replace(/\\/g,"\\\\");
    ch = ch.replace(/\'/g,"\\'");
    ch = ch.replace(/\"/g,"\\\"");
    */
    return ch;
}

function draw_selection()
{
    var selection = document.getElementById('affiche_selection');
    var res = "<table>";
    if (listeClients.length > 0)
    {
	for (i = 0; i < listeClients.length; i++)
	{
	    res = res+"<tr><td onClick=\"note_client_undo("+escape_all(listeClients[i].id)+")\" onMouseOver=\"note_mouseover("+escape_all(listeClients[i].note)+", "+escape_all(listeClients[i].solde)+")\" >"+listeClients[i].note+"</td></tr>";
	}
    }
    else
    {
	for (i = 0; i < listeConsos.length; i++)
	{
	    res = res+"<tr><td onClick=\"note_bouton_undo("+escape_all(listeConsos[i].id)+")\" onMouseOver=\"note_mouseover("+escape_all(listeConsos[i].nom)+", "+escape_all(listeConsos[i].montant)+")\" >"+listeConsos[i].nom+"</td></tr>";
	}
    }
    res = res + "</table>";
    selection.innerHTML = res;
}

function note_client(pid, pnom, psolde)
{
    if (listeConsos.length > 0)
    {
	transaction(new Array({id: pid, note: pnom, solde: psolde}), listeConsos);
	listeConsos = new Array();
    }
    else
    {
	listeClients.push({id: pid, note: pnom, solde: psolde});
    }
    draw_selection();
}

function note_bouton(pid, pnom, pmontant, preceveur)
{
    if (listeClients.length > 0)
    {
	transaction(listeClients, new Array({id: pid, nom: pnom, montant: pmontant}));
	listeClients = new Array();
    }
    else
    {
	listeConsos.push({id: pid, nom: pnom, montant: pmontant});
    }
    draw_selection();
}

function note_client_undo(pid)
{
    for (i = 0; i < listeClients.length; i++)
    {
	if (listeClients[i].id == pid)
	{
	    for(j = i; j < listeClients.length - 1; j++)
	    {
		listeClients[j] = listeClients[j+1];
	    }
	    listeClients.pop();
	    break;
	}
    }
    draw_selection();
}

function note_bouton_undo(pid)
{
    for (i = 0; i < listeConsos.length; i++)
    {
	if (listeConsos[i].id == pid)
	{
	    for(j = i; j < listeConsos.length - 1; j++)
	    {
		listeConsos[j] = listeConsos[j+1];
	    }
	    listeConsos.pop();
	    break;
	}
    }
    draw_selection();
}

function note_categorie(id)
{
    // alert("Categorie click");
    // AJAX vers ajax-note-boutons.php
    if (derniereRequeteC && derniereRequeteC.readyState < 4)
	derniereRequeteC.abort();
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'http://phpnote.pikachuyann.fr/ajax-note-boutons.php?categ='+encodeURIComponent(id));
	 
    xhr.onreadystatechange = function() {
	if (xhr.readyState == 4 && xhr.status == 200) {
	    document.getElementById('boite-boutons').innerHTML = xhr.responseText;
	}
    };
    xhr.send(null);
    derniereRequeteC = xhr;
}

var ancienneValeurA = "";
var ancienneRequeteA;

function search_adh()
{
    var searchNom = document.getElementById('search');

    if (searchNom.value != ancienneValeurA)
    {
	ancienneValeurA = searchNom.value;
	if (ancienneRequeteA && ancienneRequeteA.readystate < 4)
	    ancienneRequeteA.abort();

	var xhr = new XMLHttpRequest();
	xhr.open('GET', 'http://phpnote.pikachuyann.fr/ajax-note-adh.php?filtre='+encodeURIComponent(ancienneValeurA));
	
	xhr.onreadystatechange = function() {
	    if (xhr.readyState == 4 && xhr.status == 200) {
		document.getElementById('boite-adh').innerHTML = xhr.responseText;
	    }
	};
	xhr.send(null);
	derniereRequeteA = xhr;
    }
}
