<?php
// *************************************************************************************************************
// PANNEAU AFFICHE EN BAS DE L'INTERFACE DE CAISSE
// *************************************************************************************************************

require ("_dir.inc.php");
require ("_profil.inc.php");
require ("_session.inc.php");

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

if($_REQUEST['lib_panneau'] && $_REQUEST['lib_panneau'] != ""){
	$lib_panneau = $_REQUEST['lib_panneau'];
}else{
	$lib_panneau = "Liste de Tickets";
}

$ticket_editable = false;

//ETAT 		TYPE 	LIB 			ORDRE ISOPEN
//59			15		En saisie		1		1
//60			15		Annulé			2		0
//61			15		En Attente	3		0
//62			15		Encaissé		4		0

$tickets = array();
$ref_user = $_SESSION['user']->getRef_user();
$etats_tickets = "";
if(isset($_REQUEST['etats_tickets'])){
	//exemple 1 : etats_tickets = "59"
	//exemple 2 : etats_tickets = "59, 60, 61" ou "59; 60; 61" 
	$etats_tickets = str_replace(";", ",", $_REQUEST['etats_tickets']);	

	$ticket_editable = true;
	
	$query = "SELECT d.ref_doc, d.date_creation_doc as date_doc
						FROM documents d
						LEFT JOIN documents_types dt ON d.id_type_doc = dt.id_type_doc
						LEFT JOIN documents_etats de ON d.id_etat_doc = de.id_etat_doc
						LEFT JOIN documents_events dev ON d.ref_doc = dev.ref_doc && dev.id_event_type = 1
						WHERE d.id_type_doc = '15'
						&&		d.id_etat_doc IN (".$etats_tickets.")
						&&		dev.ref_user = '".$ref_user."' 
						GROUP BY d.ref_doc
						ORDER BY d.date_creation_doc DESC";
	
	$resultat = $bdd->query($query);
	while ($ticket = $resultat->fetchObject()) { $tickets[] = open_doc($ticket->ref_doc); }

	//Les 2 requêtes sont nécessaires parce cette architecture de requete ne marche pas :
	//(SELECT * FROM toto t WHERE t.condition = condition1 ORDER BY t.date DESC) 
	//UNION 
	//(SELECT * FROM toto t WHERE t.condition = condition2 ORDER BY t.date DESC)
	//Le OREDER BY n'est pas correct
	$query = "SELECT d.ref_doc, d.date_creation_doc as date_doc
						FROM documents d
						LEFT JOIN documents_types dt ON d.id_type_doc = dt.id_type_doc
						LEFT JOIN documents_etats de ON d.id_etat_doc = de.id_etat_doc
						LEFT JOIN documents_events dev ON d.ref_doc = dev.ref_doc && dev.id_event_type = 1
						WHERE d.id_type_doc = '15'
						&&		d.id_etat_doc IN (".$etats_tickets.")
						&&		dev.ref_user <> '".$ref_user."' 
						GROUP BY d.ref_doc
						ORDER BY d.date_creation_doc DESC";
	
	$resultat = $bdd->query($query);
	while ($ticket = $resultat->fetchObject()) { $tickets[] = open_doc($ticket->ref_doc); }
	
}else{
	$query = "SELECT d.ref_doc, d.date_creation_doc as date_doc
						FROM documents d
						LEFT JOIN documents_types dt ON d.id_type_doc = dt.id_type_doc
						LEFT JOIN documents_etats de ON d.id_etat_doc = de.id_etat_doc
						LEFT JOIN documents_events dev ON d.ref_doc = dev.ref_doc && dev.id_event_type = 1
						WHERE d.id_type_doc = '15'
						&&		d.date_creation_doc > '".strftime("%Y-%m-%d 00:00:00")."'
						&&		dev.ref_user = '".$ref_user."' 
						GROUP BY d.ref_doc
						ORDER BY d.date_creation_doc ASC";
	
	$resultat = $bdd->query($query);
	
	while ($ticket = $resultat->fetchObject()) { $tickets[] = open_doc($ticket->ref_doc); }
}


unset ($ticket, $resultat, $query);

include ($DIR.$_SESSION['theme']->getDir_theme()."page_caisse_panneau_afficher_tickets.inc.php");

?>