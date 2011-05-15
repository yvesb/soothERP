<?php
// *************************************************************************************************************
// GESTION DES EVENEMENTS (modification d'un type d'événement)
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

if (isset($_REQUEST["id_comm_event_type"])) {
	//modification d'un type d'évenement
	contact::mod_types_evenements ($_REQUEST["id_comm_event_type"], $_REQUEST["lib_comm_event_type_".$_REQUEST["id_comm_event_type"]]);
}
// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_annuaire_gestion_evenements_contact_mod.inc.php");

?>