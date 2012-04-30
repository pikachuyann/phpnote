var selectionType;
var selectionId;


function note_client_mouseover(nom, solde)
{
    // Modif d'un innerHTML pour l'affichage
}

function note_client(id, nom, solde)
{
    if (selectionType == "conso")
    {
	transaction_nconso(selectionId, id);
	selectionType = "none";
    }
    else if (selectionType == "none")
    {
	selectionType = "client";
	selectionId = array(id);
    }
    else // if (selectionType == "client")
    { 
	selectionId.push(id);
    }
    draw_selection();
}

function note_bouton(id, nom)
{
    if (selectionType == "client")
    {
	transaction_nclient(selectionId, id);
	selectionType = "none";
    }
    else if (selectionType == "none")
    {
	selectionType = "conso";
	selectionId = array(id);
    }
    else // if (selectionType == "conso")
    { 
	selectionId.push(id);
    }
    draw_selection();
}

function note_categorie(id)
{
    // AJAX vers ajax-note-boutons.php
}