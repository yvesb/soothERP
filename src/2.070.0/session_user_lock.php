<?php
// *************************************************************************************************************
// MAJ DE L'ETAT D'UN TICKET
// *************************************************************************************************************
	
$_PAGE['MUST_BE_LOGIN'] = 0;
$DONT_EXTAND_USER_SESSION = 1;

require ("_dir.inc.php");
require ($DIR."_session.inc.php");

if ($_SESSION['user']->getRef_user ()) {
	$_SESSION['USER_INFOS']['id_profil']		= $_SESSION['user']->getId_profil ();
	$_SESSION['USER_INFOS']['contact_name']	= $_SESSION['user']->getContactName ();
	$_SESSION['USER_INFOS']['pseudo']				= $_SESSION['user']->getPseudo ();
	$_SESSION['USER_INFOS']['ref_user']			= $_SESSION['user']->getRef_user ();
}
unset($_SESSION['user']);

echo "pasok";

$_SESSION['date_debut_user_session'] = time();

?>