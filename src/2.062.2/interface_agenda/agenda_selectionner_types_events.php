<?php
// *************************************************************************************************************
// PANNEAU AFFICHE EN BAS DE L'INTERFACE DE CAISSE
// *************************************************************************************************************

require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

//$_SESSION['user'];

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************



$agendasTypesAvecDroit = $_SESSION["agenda"]["GestionnaireAgendas"]->getAgendasTypesAvecDroitsNonVides();
//$agendasTypesAvecDroit[ID_TYPE_AGENDA] = libTypeAgenda


include ($DIR.$_SESSION['theme']->getDir_theme()."page_agenda_selectionner_types_events.inc.php");

?>