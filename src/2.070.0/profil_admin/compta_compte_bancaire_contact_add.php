<?php
// *************************************************************************************************************
// ACCUEIL DE L'UTILISATEUR ADMINISTRATEUR
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


//ouverture de la class compte_bancaire
	$compte_bancaire = new compte_bancaire ();

$infos = array();
$infos['ref_contact'] 	= $_REQUEST["ref_contact"];
$infos['lib_compte'] 		= $_REQUEST["lib_compte"];
$infos['ref_banque'] 		= $_REQUEST["ref_banque"];
$infos['code_banque'] 	= $_REQUEST["code_banque"];
$infos['code_guichet'] 	= $_REQUEST["code_guichet"];
$infos['numero_compte'] = $_REQUEST["numero_compte"];
$infos['cle_rib'] 			= $_REQUEST["cle_rib"];
$infos['iban'] 					= $_REQUEST["iban"];
$infos['swift'] 				= $_REQUEST["swift"];
	
	
	//création du compte
	$compte_bancaire->create_compte_bancaire ($infos);

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_compta_compte_bancaire_contact_add.inc.php");

?>