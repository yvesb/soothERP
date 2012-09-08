<?php
// *************************************************************************************************************
// INSERTION D'UNE LIGNE DE COMPTE COMPTABLE DANS UN DOCUMENT
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

		
		
		
if (isset($_REQUEST["ref_doc"])) {

	$ref_doc= $_REQUEST["ref_doc"];
	$document = open_doc ($ref_doc);
	$id_type_doc = $document->getID_TYPE_DOC ();
	//permission (6) Accès Consulter les prix d’achat
	if (!$_SESSION['user']->check_permission ("5") && ($id_type_doc == $FACTURE_FOURNISSEUR_ID_TYPE_DOC || $id_type_doc == $FACTURE_CLIENT_ID_TYPE_DOC)) {
		//on indique l'interdiction et on stop le script
		echo "<br /><span style=\"font-weight:bolder;color:#FF0000;\">Vos droits d'accés ne vous permettent pas de visualiser ce type de document</span>";
		exit();
	}
	
	$i = $_REQUEST["indent"];
	
	
	$line_ventil = new stdclass;
	$line_ventil->id_journal = $_REQUEST["id_journal"];
	$line_ventil->numero_compte = "";
	$line_ventil->montant = number_format("0", $TARIFS_NB_DECIMALES, ".", ""	);
	
// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

	include ($DIR.$_SESSION['theme']->getDir_theme()."page_documents_compta_line.inc.php");

}
?>