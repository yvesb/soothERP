<?php
// *************************************************************************************************************
// SUPPRESSION D'UN REGLEMENT
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

		
if (isset($_REQUEST["ref_reglement"])) {
	if (isset($_REQUEST["ref_contact_".$_REQUEST["ref_reglement"]]) && $_REQUEST["ref_contact_".$_REQUEST["ref_reglement"]] != "") {
		$ref_contact = $_REQUEST["ref_contact_".$_REQUEST["ref_reglement"]];
	}

	$reglement = new reglement ($_REQUEST["ref_reglement"]);
	
	if (isset($_REQUEST["ref_doc_".$_REQUEST["ref_reglement"]]) && $_REQUEST["ref_doc_".$_REQUEST["ref_reglement"]] != "") {
		$ref_doc = $_REQUEST["ref_doc_".$_REQUEST["ref_reglement"]];
		
		$document = open_doc ($ref_doc);
		$document->delier_reglement ($reglement->getRef_reglement());
	} else {
		//on vérifie les documents impactés par la suppression pour les mettre à jour.
		$lettrages = $reglement->getLettrages ();
		foreach ($lettrages as $lettre) {
			$document = open_doc ($lettre->ref_doc);
			$document->delier_reglement ($reglement->getRef_reglement());
		
		}
	}
	
	//supression du règlement
	$reglement->delete_reglement ();  

}


// *************************************************************************************************************
// AFFICHAGE
// -*************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_compta_reglements_sup.inc.php");

?>