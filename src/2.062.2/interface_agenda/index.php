<?php
// *************************************************************************************************************
// ACCUEIL DE L'UTILISATEUR INTERFACE AGENDA
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

// Liste des profils autorisés
$profils_allowed = $_SESSION['user']->getProfils_allowed();

setcookie("uncahe_profil_collab", date("Y-m-d H:i:s"), time() + $COOKIE_LOGIN_LT , '/');
if(!isset($_COOKIE["cook_agenda_selected"])){
setcookie("cook_agenda_selected", 0, time() + $COOKIE_LOGIN_LT , '/');
}
if(!isset($_COOKIE["cook_agenda_selectedC1"])){
setcookie("cook_agenda_selectedC1", 0, time() + $COOKIE_LOGIN_LT , '/');
}
if(!isset($_COOKIE["cook_agenda_selectedC2"])){
setcookie("cook_agenda_selectedC2", 0, time() + $COOKIE_LOGIN_LT , '/');
}
if(!isset($_COOKIE["cook_agenda_selectedC3"])){
setcookie("cook_agenda_selectedC3", 0, time() + $COOKIE_LOGIN_LT , '/');
}
if (isset($_REQUEST["uncache"])) {
	header("Cache-Control: no-store, no-cache, must-revalidate");
}

Lib_interface_agenda::Integrite_agendas_users_events_type_affiche_permissions();

require ("_session.inc.php");

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_index.inc.php");

?>