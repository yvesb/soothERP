<?php
// *************************************************************************************************************
// AFFICHAGE DE L'EDITION D'UN CONTACT (partie document pdf)
// *************************************************************************************************************

$MUST_BE_LOGIN = 1;
require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

function stats_create_pdf($code_pdf_modele, $print = 0){
	$GLOBALS['PDF_OPTIONS']['HideToolbar'] = 0;
	$GLOBALS['PDF_OPTIONS']['AutoPrint'] = $print;
	
	$pdf = new PDF_etendu();
	$pdf->add_stats($code_pdf_modele);//"", $this);
	return $pdf;
}

ini_set("memory_limit","40M");
//if (isset($_REQUEST["ref_contact"])) {
	$GLOBALS['_OPTIONS']['CREATE_DOC']['no_charge_all_sn'] = 1;
		
	//changement du code pdf_modele*/
	if (!isset($_REQUEST["code_pdf_modele"])) {
		$_REQUEST["code_pdf_modele"] = get_code_pdf_modele_stat();
	}
	
	if (isset($_REQUEST["print"])) {
		$pdf = stats_create_pdf($_REQUEST["code_pdf_modele"], 1);
	}else {
		$pdf = stats_create_pdf($_REQUEST["code_pdf_modele"], 0);
	}
	$pdf->Output();
//}

?>