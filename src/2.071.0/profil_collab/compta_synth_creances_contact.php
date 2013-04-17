<?php
// *************************************************************************************************************
// FACTURES CLIENTS NON REGLEES
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");
require ($CONFIG_DIR."profil_".$_SESSION['profils'][$CLIENT_ID_PROFIL]->getCode_profil().".config.php");

if (!$_SESSION['user']->check_permission ("11")) {
	//on indique l'interdiction et on stop le script
	echo "<br /><span style=\"font-weight:bolder;color:#FF0000;\">Vos droits  d'accés ne vous permettent pas de visualiser ce type de page</span>";
	exit();
}
// chargement de la class du profil
$contact = new contact($_REQUEST["ref_contact"]);
$profils 	= $contact->getProfils();
//chargement des factures non réglées
$factures = array();
$factures = get_client_factures_to_pay ($contact->getRef_contact());

$liste_niveaux_relance = getNiveaux_relance ($profils[$CLIENT_ID_PROFIL]->getId_client_categ ()) ;

// *************************************************************************************************************
// AFFICHAGE
// -*************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_compta_synth_creances_contact.inc.php");

?>