<?php
// *************************************************************************************************************
// AFFICHAGE DE L'EDITION D'UN DOCUMENT (partie document pdf)
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

ini_set("memory_limit","40M");
if (isset($_REQUEST["ref_doc"])) {
    if (is_array($_REQUEST["ref_doc"])){
        $GLOBALS['PDF_OPTIONS']['HideToolbar'] = 0;
	$GLOBALS['PDF_OPTIONS']['AutoPrint'] = 0;

	// Création du fichier
	$pdf = new PDF_etendu ();
        $pdf->disable_footer = true;
        // Ajout du courrier de relance
        if (isset($_REQUEST["courrier"])){
            $id_courrier = $_REQUEST["courrier"];
            //$courrier = new CourrierEtendu($id_courrier);
            $pdf->add_courrier($id_courrier);
            //add_courrier_standard(&$pdf, $courrier);

        }

	// Ajout des documents au PDF
        foreach($_REQUEST["ref_doc"] as $document){
            $document = open_doc ($document);
            $pdf->add_doc ("", $document);
        }
	$pdf->Output();
    }else{
	$GLOBALS['_OPTIONS']['CREATE_DOC']['no_charge_all_sn'] = 1;
	$document = open_doc ($_REQUEST['ref_doc']);
	
	if (isset($_REQUEST["filigrane"])) { $GLOBALS['PDF_OPTIONS']['filigrane'] = $_REQUEST["filigrane"];}
	//changement du code pdf_modele
	
	if (isset($_REQUEST["code_pdf_modele"])) {
            if($_REQUEST["code_pdf_modele"] =="")
                $document->change_code_pdf_modele ("doc_standard");
            else
		$document->change_code_pdf_modele ($_REQUEST["code_pdf_modele"]);

	}
	if (isset($_REQUEST["print"])) {
		$document->print_pdf();
	}else {
		$document->view_pdf();
	}
    }
}

?>