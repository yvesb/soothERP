<?php
// *************************************************************************************************************
// OUVERTURE DE LA COMPTABILITE DANS UN DOCUMENT
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

		
		
if (isset($_REQUEST["ref_doc_compta"])) {

	$ref_doc= $_REQUEST["ref_doc_compta"];
	$document = open_doc ($ref_doc);
	
	$id_type_doc = $document->getID_TYPE_DOC ();
	$ref_contact = $document->getRef_contact ();
	
	$infos_lines = array();
	for ($i = 0; $i < $_REQUEST["indentation_compta_lignes"]; $i++) {
		if (!isset($_REQUEST["numero_compte_".$i])) { continue ; }
		$infos_lines[] = array("id_journal"=>$_REQUEST["id_journal_".$i], "montant"=>$_REQUEST["montant_".$i], "numero_compte"=>$_REQUEST["numero_compte_".$i]);
	}
	if (count($infos_lines)) {
		$document->supprime_ventilation_facture ();
		$document->ajout_ventilation_facture ($infos_lines);
	}
	
// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

}
if (isset($id_type_doc)) {
	include ($DIR.$_SESSION['theme']->getDir_theme()."page_documents_compta_".$id_type_doc."_mod.inc.php");
}
?>