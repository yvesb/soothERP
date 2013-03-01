<?php
// *************************************************************************************************************
// suppression des commissions
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


if (isset($_REQUEST['id_commission_regle'])) {	
	// Création de la catégorie
	$commission_liste = new commission_liste ($_REQUEST['id_commission_regle']);
	$commission_liste->suppression ($_REQUEST['id_commission_regle_remplacement_'.$_REQUEST['id_commission_regle']]);
}

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_commission_sup.inc.php");

?>