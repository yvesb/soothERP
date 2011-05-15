<?php
// *************************************************************************************************************
// [COLLABORATEUR] RECHERCHE D'UNE COMMANDE EN COURS
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


//liste des types de documents
$types_liste	= array();

if (isset($_REQUEST["mode"])) {
	switch ($_REQUEST["mode"]) {
		case "vente":
		foreach ($_SESSION['types_docs'] as $type) {
			if ($type->id_type_doc == $LIVRAISON_CLIENT_ID_TYPE_DOC || $type->id_type_doc == $COMMANDE_CLIENT_ID_TYPE_DOC || $type->id_type_doc == $DEVIS_CLIENT_ID_TYPE_DOC || $type->id_type_doc == $FACTURE_CLIENT_ID_TYPE_DOC ) {
			$types_liste[$type->id_type_doc]= $type;
			}
		}
		break;
		case "achat":
		foreach ($_SESSION['types_docs'] as $type) {
			if ($type->id_type_doc == $LIVRAISON_FOURNISSEUR_ID_TYPE_DOC || $type->id_type_doc == $COMMANDE_FOURNISSEUR_ID_TYPE_DOC || $type->id_type_doc == $DEVIS_FOURNISSEUR_ID_TYPE_DOC || $type->id_type_doc == $FACTURE_FOURNISSEUR_ID_TYPE_DOC  ) {
			$types_liste[$type->id_type_doc]= $type;
			}
		}
		break;
		case "trm":
		foreach ($_SESSION['types_docs'] as $type) {
			if ($type->id_type_doc == $TRANSFERT_ID_TYPE_DOC || $type->id_type_doc == $INVENTAIRE_ID_TYPE_DOC || $type->id_type_doc == $FABRICATION_ID_TYPE_DOC || $type->id_type_doc == $DESASSEMBLAGE_ID_TYPE_DOC ) {
			$types_liste[$type->id_type_doc]= $type;
			}
		}
		break;
	}
}else {
	$types_liste = $_SESSION['types_docs'];
}

//infos pour mini moteur de recherche contact
$profils_mini = array();
foreach ($_SESSION['profils'] as $profil) {
	if ($profil->getActif() != 1) { continue; }
	$profils_mini[] = $profil;
}
unset ($profil);
foreach ($_SESSION['profils'] as $profil) {
	if ($profil->getActif() != 2 ) { continue; }
	$profils_mini[] = $profil;
}
unset ($profil);

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_documents_cmde_four_recherche.inc.php");

?>