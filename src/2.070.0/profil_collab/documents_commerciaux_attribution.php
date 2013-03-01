<?php
// *************************************************************************************************************
// ONGLET DES MARGES DU DOCUMENT ajout de commerciaux au document
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");
require ($DIR.$_SESSION['theme']->getDir_theme()."_theme.config.php");



		
		
if (isset($_REQUEST["ref_doc"])) {
	$ref_doc= $_REQUEST["ref_doc"];
	$document = open_doc ($ref_doc);
	
	
	
	
	$id_type_doc = $document->getID_TYPE_DOC ();
	$ref_contact = $document->getRef_contact ();

	$commerciaux = array();
	foreach ($_REQUEST as $key=>$val) {
		if (substr ($key, 0, 5) != "part_") { continue; }
		if (!$val) {continue;}
		if (isset($_REQUEST["attrib_ref_commercial_".substr ($key, 5, strlen($key))]) && $_REQUEST["attrib_ref_commercial_".substr ($key, 5, strlen($key))]) {
		
			$contact_commercial = new contact($_REQUEST["attrib_ref_commercial_".substr ($key, 5, strlen($key))]);
			if (!$contact_commercial->is_profiled ($COMMERCIAL_ID_PROFIL)) {
				$new_profils = array();
				$new_profils["id_profil"] = $COMMERCIAL_ID_PROFIL;
				$contact_commercial->create_profiled_infos ($new_profils);
			}
			$commercial = new stdclass;
			$commercial->ref_contact = $_REQUEST["attrib_ref_commercial_".substr ($key, 5, strlen($key))];
			$commercial->part = $val;
			$commerciaux[] = $commercial;
		}
	}
	
	$document->attribution_commercial ($commerciaux);
// *************************************************************************************************************
// AFFICHAGE
// -*************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_documents_commerciaux_attribution.inc.php");
}

?>