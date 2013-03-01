<?php
// *************************************************************************************************************
// GESTION DES TAXES ADMINISTRATION
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


//affichage pour les taxes
	//liste des pays
	$taxes_pays	= defined_taxes_pays();
	
	unset($query, $resultat);
	
	$id_pays_sel=$DEFAUT_ID_PAYS;
	
	//liste des taxes du pays par defaut
	$taxes = taxes_pays ($id_pays_sel);
	
// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_catalogue_taxes.inc.php");

?>