<?php
// *************************************************************************************************************
// SUPPRESSION D'UN fonction POUR UN COLLABORATEUR
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


	if (!isset($_REQUEST['ref_contact'])) {
		echo "La référence du contact n'est pas précisée";
		exit;
	}

	$contact = new contact ($_REQUEST['ref_contact']);
	if (!$contact->getRef_contact()) {
		echo "La référence du contact est inconnue";		exit;

	}
	$profils 	= $contact->getProfils();
	$profils[$COLLAB_ID_PROFIL]->del_fonction ($_REQUEST['id_fonction']);
	
	//maj des permissions users
	if (isset($_REQUEST["maj_user_perms"]) && $_REQUEST["maj_user_perms"] == "1") {
		fonctions::maj_user_permissions ($contact->getRef_contact()); 
	}


?>k