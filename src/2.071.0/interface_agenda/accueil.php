<?php
// *************************************************************************************************************
// ACCUEIL DE L'UTILISATEUR ADMINISTRATEUR
// *************************************************************************************************************

require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");
require ("_session.inc.php");
require ($CONFIG_DIR."profil_".$_SESSION['profils'][$COLLAB_ID_PROFIL]->getCode_profil().".config.php");



// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

$agendasAvecDroits = $_SESSION["agenda"]["GestionnaireAgendas"]->getAgendasAvecDroits();
//$agendasAvecDroits[REF_AGENDA] = array();
//$agendasAvecDroits[REF_AGENDA]["libAgenda"] = string;
//$agendasAvecDroits[REF_AGENDA]["affiche"] = bool;
//$agendasAvecDroits[REF_AGENDA]["droits"] = int[];
//$agendasAvecDroits[REF_AGENDA]["couleur1"] = string;
//$agendasAvecDroits[REF_AGENDA]["couleur2"] = string;
//$agendasAvecDroits[REF_AGENDA]["couleur3"] = string;
//$agendasAvecDroits[REF_AGENDA]["id_type_agenda"] = int;
//$agendasAvecDroits[REF_AGENDA]["lib_type_agenda"] = string;


$eventsTypesAvecDroit = $_SESSION["agenda"]["GestionnaireEvenements"]->getEventsTypesAvecDroits();
//$eventsTypessAvecDroit[ID_TYPE_EVENT] = array();
//$eventsTypessAvecDroit[ID_TYPE_EVENT]["libEvent"] = string;
//$eventsTypessAvecDroit[ID_TYPE_EVENT]["affiche"] = bool;
//$eventsTypessAvecDroit[ID_TYPE_EVENT]["droits"] = int[];

$droitsUserAgendas=getDroitVoirAgenda($_SESSION["user"]->getRef_user(),42);
$droitsUserEvents=getDroitVoirAgenda($_SESSION["user"]->getRef_user(),43);

reset($agendasAvecDroits);
$index = key($agendasAvecDroits);

if($index != null)
{			$eventsTypesAvecDroitFirstAg = $_SESSION["agenda"]["GestionnaireEvenements"]->getEventsTypesAvecDroits($agendasAvecDroits[$index]["id_type_agenda"]);}
else{	$eventsTypesAvecDroitFirstAg = array();}
//$eventsTypesAvecDroitFirstAg[ID_TYPE_EVENT] = array();
//$eventsTypesAvecDroitFirstAg[ID_TYPE_EVENT]["libEvent"] = string;
//$eventsTypesAvecDroitFirstAg[ID_TYPE_EVENT]["affiche"] = bool;
//$eventsTypesAvecDroitFirstAg[ID_TYPE_EVENT]["droits"] = int[];

unset($index);

include ($DIR.$_SESSION["theme"]->getDir_theme()."page_accueil.inc.php");

?>