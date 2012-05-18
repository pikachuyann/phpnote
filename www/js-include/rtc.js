/*
  TO BE DONE
  Ce sont les fonctions qui permettent d'effectuer les consommations:
    * Retrait
    * Crédit
    * Transfert
*/

function transfert_argent(emetteur, destinataire, montant, remarque)
{
//    alert(emetteur+'|'+destinataire+'|'+montant+'|'+remarque);
	var xhr = new XMLHttpRequest();
	xhr.open('GET','http://phpnote.pikachuyann.fr/ajax-note-transac.php?trInfo='+emetteur+'|'+destinataire+'|'+montant+'|'+remarque);

	xhr.onreadystatechange = function() {
		if (xhr.readyState == 4 && xhr.status == 200) {
			historique_reset(-1);
		}
	};
	xhr.send(null);
	derniereRequeteC = xhr;
    // faire la transaction
}

function do_switch()
{
    if (listeClients[0] && listeClients[1])
    {
	var tmp = listeClients[0];
	listeClients[0] = listeClients[1];
	listeClients[1] = tmp;
	draw_selection();
    }
}

function do_retrait()
{
    var source;
    var value;
    if (listeClients[0] && (source = document.getElementById('montant')) && source.value != '' && (value = parseFloat(source.value.replace(',', '.'))))
    {
	transfert_argent(listeClients[0].id, 0, value, 'Retrait');
	note_client_undo(listeClients[0].id);
    }
}

function do_credit()
{
    var source;
    var value;
    if (listeClients[0] && (source = document.getElementById('montant')) && source.value != '' && (value = parseFloat(source.value.replace(',', '.'))))
    {
	transfert_argent(0, listeClients[0].id, value, 'Credit');
	note_client_undo(listeClients[0].id);
    }
}

function do_transfert()
{
    var source;
    var value;
    if (listeClients[0] && listeClients[1] && (source = document.getElementById('montant')) && source.value != '' && (value = parseFloat(source.value.replace(',', '.'))))
    {
	transfert_argent(listeClients[0].id, listeClients[1].id, value, 'Transfert');
	note_client_undo(listeClients[0].id);
	note_client_undo(listeClients[1].id);
    }
}

/*
  TO BE DEBUG
  Ce sont les fonctions qui permettent d'afficher les consommations:
    * Retrait
    * Crédit
    * Transfert
*/

function draw_retrait()
{
    if (derniereRequeteC && derniereRequeteC.readyState < 4)
	derniereRequeteC.abort();
    var bb = document.getElementById('boite-boutons');
    var res = "<table>      <tr><th>Retrait:</th><td></td></tr>      <tr><td>de: <span id=\"nom1\">";
    if (listeClients[0])
    {
	res += listeClients[0].note;
    }
    res += "</span></td>de: <input type=\"text\" id=\"montant\"></input></td></tr>    <tr><td></td><td><button onClick=\"do_retrait()\">Retirer</button></td></tr>    </table>";
    bb.innerHTML = res;
    //alert(res);
    listeConsos = new Array();
    draw_selection();
}

function draw_credit()
{
    if (derniereRequeteC && derniereRequeteC.readyState < 4)
	derniereRequeteC.abort();
    var bb = document.getElementById('boite-boutons');
    var res = "<table><tr><th>Cr&eacute;dit:</th><td></td></tr>      <tr><td>de: <span id=\"nom1\">";
    if (listeClients[0])
    {
	res += listeClients[0].note;
    }
    res += "</span></td>de: <input type=\"text\" id=\"montant\"></input></td></tr>    <tr><td></td><td><button onClick=\"do_credit()\">Cr&eacute;diter</button></td></tr>    </table>";
    bb.innerHTML = res;
    listeConsos = new Array();
    draw_selection();
}

function draw_transfert()
{
    if (derniereRequeteC && derniereRequeteC.readyState < 4)
	derniereRequeteC.abort();
    var bb = document.getElementById('boite-boutons');
    var res = "<table>      <tr><th>Transfert:</th><td></td><td></td></tr>      <tr><td>de: <span id=\"nom1\">";
    if (listeClients[0])
    {
	res += listeClients[0].note;
    }
    res += "</span></td><td>&agrave;: <span id=\"nom2\">";
    if (listeClients[1])
    {
	res += listeClients[1].note;
    }
    res += "</span></td>de: <input type=\"text\" id=\"montant\"></input></td></tr>    <tr><td></td><td><button onClick=\"do_switch()\">Inverser</button></td><td><button onClick=\"do_transfert()\">Transf&eacute;rer</button></td></tr>    </table>";
    bb.innerHTML = res
    listeConsos = new Array();
    draw_selection();
}
