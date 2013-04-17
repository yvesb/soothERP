<?php
// *************************************************************************************************************
// OUVERTURE DE LA COMPTABILITE DANS UN DOCUMENT
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

		
include_once ($CONFIG_DIR."profil_client.config.php");
// chargement de la class du profil
		
include_once ($CONFIG_DIR."profil_fournisseur.config.php");
// chargement de la class du profil
		
if (isset($_REQUEST["ref_doc"])) {

	$ref_doc= $_REQUEST["ref_doc"];
	$document = open_doc ($ref_doc);
	$id_type_doc = $document->getID_TYPE_DOC ();
	//permission (5) Accès Comptabilité
	if (!$_SESSION['user']->check_permission ("5") && ($id_type_doc == $FACTURE_FOURNISSEUR_ID_TYPE_DOC || $id_type_doc == $FACTURE_CLIENT_ID_TYPE_DOC) ) {
		//on indique l'interdiction et on stop le script
		echo "<br /><span style=\"font-weight:bolder;color:#FF0000;\">Vos droits d'accés ne vous permettent pas de visualiser ce type de document</span>";
		exit();
	}
	$ref_contact = $document->getRef_contact ();
	
	$ventillation_facture = $document->charger_ventilation_facture();
	
// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

}
if (isset($id_type_doc)) {
	include ($DIR.$_SESSION['theme']->getDir_theme()."page_documents_compta_".$id_type_doc.".inc.php");
}
?>