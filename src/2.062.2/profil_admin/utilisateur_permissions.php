<?php
// *************************************************************************************************************
// FONCTIONS DES UTILISATEURS
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


// *************************************************************************************************************
// TRAITEMENTS
// *************************************************************************************************************

if (isset($_REQUEST["ref_user"])) {

$utilisateur = new utilisateur($_REQUEST["ref_user"]);
$contact = new contact ($utilisateur->getRef_contact());


$utilisateur_permissions = charger_user_permissions($_REQUEST["ref_user"]);

$liste_profils_contact = ($contact->getProfils ());
if (isset ($liste_profils_contact [$COLLAB_ID_PROFIL])) {
	$liste_permissions_collab = charger_permissions ($COLLAB_ID_PROFIL);
}

$users = $utilisateur->liste_ref_user_actif();

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_utilisateur_permissions.inc.php");

}
?>