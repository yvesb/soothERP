<?php
// *************************************************************************************************************
// DEPLACEMENT DES ARTICLES D'UN STOCK ET SUPPRESSION DU STOCK
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


if (isset($_REQUEST['id_stock']) && isset($_REQUEST['type_doc'])) {	
	// *************************************************
	// Création de la catégorie
	$stock_liste = new stock ($_REQUEST['id_stock']);
	
	//soit on transfere les articles soit on les livre
	if ($_REQUEST['type_doc'] == "TRM") {
		$stock_liste->supprime_stock_transferer ($_REQUEST['new_id_stock']);
	}
	if ($_REQUEST['type_doc'] == "BLC") {
		$stock_liste->supprime_stock_livrer ($_REQUEST['ref_contact']);
	}

// *************************************************************************************************************
// AFFICHAGE
// -*************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_catalogue_stockage_sup_deplace_art.inc.php");
}

?>