<?php
// *************************************************************************************************************
// ajout ar de fonds pour caisse 
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");



$compte_caisse	= new compte_caisse($_REQUEST["id_compte_caisse"]);


$info = array();
$info["montant_ar"] 	= $_REQUEST["montant_ar"];
$info["commentaire"] 			= $_REQUEST["commentaire"];	
	
$id_compte_caisse_ar = $compte_caisse->create_ar_fonds_caisse ($info);

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_compta_ar_fonds_caisse_create.inc.php");

?>