<?php
// *************************************************************************************************************
// AFFICHAGE DE L'EDITION (IMPRESSION ET ENVOIS) D'UN OU PLUSIEURS STOCKS
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

// *************************************************************************************************************
// AFFICHAGE
// -*************************************************************************************************************


if(empty($_REQUEST["code_pdf_modele"])){
	$_REQUEST["code_pdf_modele"] = stock::charge_defaut_modele_pdf();
	
}

if(empty($_REQUEST["id_stocks"])){
	$stocks = fetch_all_stocks();
	$val = "";
	foreach($stocks as $key => $stock){
		$val .= $key.',';
	}
	$_REQUEST["id_stocks"] = substr($val, 0, strlen($val)-1 );
}

include ($DIR.$_SESSION['theme']->getDir_theme()."page_stocks_editing.inc.php");
?>
