<?php
// *************************************************************************************************************
// AJOUT D'UNE REGLE DE COMMISSIONNEMENT
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


if (isset($_REQUEST['ajout_comm'])) {	
	// *************************************************
	// Controle des données fournies par le formulaire

	
	$lib_comm						= $_REQUEST['lib_comm'];
	$formule_comm			= $_REQUEST['formule_comm'];

	
	// *************************************************
	// Création de la grille de comm
	$commission_liste = new commission_liste ();
	$commission_liste->create ($lib_comm, $formule_comm);
}

// *************************************************************************************************************
// AFFICHAGE
// -*************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_commission_add.inc.php");

?>