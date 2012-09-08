<?php
// *************************************************************************************************************
// CHARGEMENTS DES PIECES JOINTES D'UN OBJET
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");
require_once ($DIR."_contact_liaisons_types.class.php");


//**************************************
// Controle

if(!isset($_REQUEST["ref_contact"])){
	echo "la référence du contact n'est pas spécifiée.";
	exit;
}

$contact = new contact($_REQUEST["ref_contact"]);

$liaisons_type_liste = Contact_liaison_type::getLiaisons_type();

//$liaison_type_vers_autre_contact = Contact_liaison_type::getLiaisons_type_vers_autre_contact();
//$liaison_type_depuis_autre_contact = Contact_liaison_type::getLiaisons_type_depuis_autre_contact();

if(is_null($liaisons_type_liste)){
	echo "La liste des types de liaisons et nulle";
	exit;
}

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_annuaire_view_liaisons.inc.php");

?>