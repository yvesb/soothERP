<?php
// *************************************************************************************************************
// REGLEMENTS INSERTION DU FORMULAIRE DE PAIEMENT
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");
	
		
if (isset($_REQUEST["ref_contact"])) {
	$ref_contact = $_REQUEST["ref_contact"];
}


//liste des reglements_modes
$reglements_modes	= getReglements_modes_date_echeance ($_REQUEST["id_reglement_mode"]);


//chargement des comptes bancaires
$comptes_bancaires_societe	= compte_bancaire::charger_comptes_bancaires("" , 1);

//chargement des comptes bancaires du contact du document
$comptes_bancaires	= compte_bancaire::charger_comptes_bancaires($ref_contact, 1);

//chargement des comptes de caisses
$comptes_caisses	=	compte_caisse::charger_comptes_caisses ($_SESSION['magasin']->getId_magasin (), 1);

//chargement des comptes tpe
$comptes_tpes	=	compte_tpe::charger_comptes_tpes ($_SESSION['magasin']->getId_magasin (), 1);

//chargement des comptes cbs
$comptes_cbs	=	compte_cb::charger_comptes_cbs (1);
//chargement des comptes tpv
$comptes_tpv	=	compte_tpv::charger_comptes_tpv (1);

// *************************************************************************************************************
// AFFICHAGE
// -*************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_documents_reglements_".$_REQUEST["id_reglement_mode"].".inc.php");

?>