<?php
// *************************************************************************************************************
// CHARGEMENTS DES COURRIER D'UN CONTACT
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


// *************************************************************************************************************
// TRAITEMENTS
// *************************************************************************************************************



if(!isset($_REQUEST["ref_contact"])){
	echo "La référence du contact est inconnue";
	exit;
}
$ref_contact = $_REQUEST["ref_contact"];
$contact = new contact ($_REQUEST['ref_contact']);
$coordonnees = $contact->getCoordonnees ();
// *************************************************
// Profils à afficher
$profils = array();
foreach ($_SESSION['profils'] as $profil) {
	if ($profil->getActif() != 1) { continue; }
	$profils[] = $profil;
}
unset ($profil);


// *************************************************
// Données nécessaire à la barre de navigation + le tri des données par objet, date, expéditeur 
$form['page_to_show'] = $search['page_to_show'] = 1;
if (isset($_REQUEST['page_to_show'])) {
	$form['page_to_show'] = $_REQUEST['page_to_show'];
	$search['page_to_show'] = $_REQUEST['page_to_show'];
}
$form['courriers_par_page'] = $search['courriers_par_page'] = $ANNUAIRE_COMMUNICATION_SHOWED_COURRIERS;
if (isset($_REQUEST['courriers_par_page'])) {
	$form['courriers_par_page'] = $_REQUEST['courriers_par_page'];
	$search['courriers_par_page'] = $_REQUEST['courriers_par_page'];
}

//On tri les résultat par defaut par date
$form['orderby'] = $search['orderby'] = "date";
if (isset($_REQUEST['orderby'])) {
	$form['orderby'] = $_REQUEST['orderby'];
	$search['orderby'] = $_REQUEST['orderby'];
}
$form['orderorder'] = $search['orderorder'] = "DESC";
if (isset($_REQUEST['orderorder'])) {
	$form['orderorder'] = $_REQUEST['orderorder'];
	$search['orderorder'] = $_REQUEST['orderorder'];
}
$form['id_profil'] = 0;
if (isset($_REQUEST['id_profil'])) {
	$form['id_profil'] = $_REQUEST['id_profil'];
	$search['id_profil'] = $_REQUEST['id_profil'];
}


// *************************************************
// Résultat de la recherche


$courriers =  getCourriersDunDestinataire($ref_contact, ($search['page_to_show']-1)*$search['courriers_par_page'], $search['courriers_par_page'], $search['orderby'], $search['orderorder']);
$nb_courriers = count(getCourriersDunDestinataire($ref_contact));

//$courriers = getCourriersDunDestinataire($ref_contact);
// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************


include ($DIR.$_SESSION['theme']->getDir_theme()."page_annuaire_view_courriers.inc.php");

?>
