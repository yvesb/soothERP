<?php
// *************************************************************************************************************
// ACCUEIL DE L'UTILISATEUR ADMINISTRATEUR
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


//ouverture de la class compte_bancaire
	$compte_bancaire = new compte_bancaire ($_REQUEST["id_compte_bancaire"]);

$infos = array();
$infos['ref_contact'] 	= $_REQUEST["ref_contact_".$_REQUEST["id_compte_bancaire"]];
$infos['lib_compte'] 		= $_REQUEST["lib_compte_".$_REQUEST["id_compte_bancaire"]];
$infos['ref_banque'] 		= $_REQUEST["ref_banque_".$_REQUEST["id_compte_bancaire"]];
$infos['code_banque'] 	= $_REQUEST["code_banque_".$_REQUEST["id_compte_bancaire"]];
$infos['code_guichet'] 	= $_REQUEST["code_guichet_".$_REQUEST["id_compte_bancaire"]];
$infos['numero_compte'] = $_REQUEST["numero_compte_".$_REQUEST["id_compte_bancaire"]];
$infos['cle_rib'] 			= $_REQUEST["cle_rib_".$_REQUEST["id_compte_bancaire"]];
$infos['iban'] 					= $_REQUEST["iban_".$_REQUEST["id_compte_bancaire"]];
$infos['swift'] 				= $_REQUEST["swift_".$_REQUEST["id_compte_bancaire"]];
	
	
	//modification du compte
	$compte_bancaire->maj_compte_bancaire ($infos);

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_compta_compte_bancaire_contact_mod.inc.php");

?>