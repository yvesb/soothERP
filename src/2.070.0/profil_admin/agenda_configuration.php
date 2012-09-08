<?php
// *************************************************************************************************************
// ACCUEIL DE L'UTILISATEUR ADMINISTRATEUR
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_redirection_extension.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

$all_agendas =& Lib_interface_agenda::getAgendas();
$all_agenda_types = Lib_interface_agenda::getAllAgendaTypes();
$allRessources_AgendaReservationRessource = Lib_interface_agenda::getAllRessources_AgendaReservationRessource();

//$event_duree_moyenne = 1800; // = 30 min


//infos pour mini moteur de recherche contact
$profils_mini = array();
foreach ($_SESSION['profils'] as $profil) {
	if ($profil->getActif() != 1 && $profil->getActif() != 2) { continue; }
	$profils_mini[] = $profil;
}
unset ($profil);

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_agenda_configuration.inc.php");

?>