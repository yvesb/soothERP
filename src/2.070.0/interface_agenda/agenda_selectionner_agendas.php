<?php
// *************************************************************************************************************
// PANNEAU AFFICHE EN BAS DE L'INTERFACE DE CAISSE
// *************************************************************************************************************

require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");
require ("_session.inc.php");

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

$groupesAgendasAvecDroits = $_SESSION["agenda"]["GestionnaireAgendas"]->getListesAgendasAvecDroitsNonVides();
//$groupesAgendasAvecDroits[ID_GROUPE] = libGroupe

$agendasAvecDroits = $_SESSION["agenda"]["GestionnaireAgendas"]->getAgendasAvecDroits();
//$agendasAvecDroit[REF_AGENDA] = array();
//$agendasAvecDroit[REF_AGENDA]["libAgenda"] = string;
//$agendasAvecDroit[REF_AGENDA]["affiche"] = bool;
//$agendasAvecDroit[REF_AGENDA]["droits"] = int[];
//$agendasAvecDroit[REF_AGENDA]["couleur1"] = string;
//$agendasAvecDroit[REF_AGENDA]["couleur2"] = string;
//$agendasAvecDroit[REF_AGENDA]["couleur3"] = string;

include ($DIR.$_SESSION['theme']->getDir_theme()."page_agenda_selectionner_agendas.inc.php");

?>