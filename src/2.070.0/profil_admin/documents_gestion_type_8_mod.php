<?php
// *************************************************************************************************************
// ACCUEIL DE LA GESTION DES DOCUMENTS (FAF)
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

//$actif = 0;
//if (isset($_REQUEST["actif_".$_REQUEST["id_type_doc"]]) || ($_REQUEST["id_type_doc"] <= 8 ) ) {
//$actif = 1;
//}
//$query = "UPDATE documents_types SET actif = ".$actif.", 
//				lib_type_printed = '".addslashes($_REQUEST["lib_type_printed_".$_REQUEST["id_type_doc"]])."'
//				WHERE id_type_doc = '".$_REQUEST["id_type_doc"]."' ";
//$bdd->exec ($query);
//on demande à ce que la session soit mise à jour lors de l'ouverture des prochaines pages
//serveur_maj_file();

$code_doc = $_REQUEST["code_doc_".$_REQUEST["id_type_doc"]];

//mise à jour du lib_type_printed
$query = "UPDATE documents_types SET lib_type_printed = '".addslashes($_REQUEST["lib_type_printed_".$_REQUEST["id_type_doc"]])."'
				WHERE id_type_doc = '".$_REQUEST["id_type_doc"]."' ";
$bdd->exec ($query);

if (isset($_REQUEST["duree_avant_purge_annule_".$_REQUEST["id_type_doc"]])) {
	maj_configuration_file ("_doc_".strtolower($code_doc).".config.php", "maj_line", "\$DUREE_AVANT_PURGE_ANNULE_".strtoupper($code_doc)." =", "\$DUREE_AVANT_PURGE_ANNULE_".strtoupper($code_doc)." = ".$_REQUEST["duree_avant_purge_annule_".$_REQUEST["id_type_doc"]].";	// Délai avant la suppression des docs annulés", $DIR."documents/");
}

// *************************************************************************************************************
// AFFICHAGE
// -*************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_documents_gestion_type_mod.inc.php");

?>