var listeClients = new Array();
var listeConsos = new Array();
var derniereRequeteC;
var rafraichirHistorique;

/*
  Cette fonction permet de demander à ajax-note-transac.php d'enregistrer des
  transactions 1 conso/n clients ou n clients/1 conso
  DEPEND: www/ajax-note-transac.php; historique.js
*/
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
//  alert(clients+"\n"+consos);

    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'http://phpnote.pikachuyann.fr/ajax-note-transac.php?trClient='+clients+'&trConsos='+consos);

    rafraichirHistorique = Math.max(plisteConsos.length, plisteClients.length);

    xhr.onreadystatechange = function() {
       if (xhr.readyState == 4 && xhr.status == 200) {
	   /*
	     A la fin de la transaction, on recharge les 30 dernière transactions
	     dans l'historique
	   */
	   historique_reset(-1);
       }
    };
    xhr.send(null);
    derniereRequeteC = xhr;

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

/*
  Cette fonction gère l'affichage de la colonne deux de la note. Celle où les
  consos ou les clients déjà sélectionnés apparaissent.
  Cliquer sur un champs déselectionne l'objet associé.
*/
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

/*
  Lorsque l'on sélectionne un client ou une conso. Il y a deux cas à chaque fois:
   * Si un objet de l'autre type a été sélectionné auparavent, on lance une
     transaction;
   * Sinon on ajoute l'objet aux objets sélectionnés
*/
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

/*
  Ces fonctions prennent en charge la "dé-selection" d'un objet
*/
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

/*
  Cette fonction affiche les boutons associés à une catégorie
  DEPEND: www/ajax-note-boutons.php
*/
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

/*
  Ici est géré la recherche d'adhérent dans la barre de recherche
  DEPEND: www/ajax-note-adh.php
*/
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

/*
  TO BE DONE
  Ce sont les fonctions qui permettent d'afficher les champs spéciaux:
    * Retrait
    * Crédit
    * Transfert
*/
function retrait()
{
    if (derniereRequeteC && derniereRequeteC.readyState < 4)
	derniereRequeteC.abort();
    document.getElementById('boite-boutons').innerHTML = "";
}
