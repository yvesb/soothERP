<?php
// *************************************************************************************************************
// PANNEAU AFFICHE EN BAS DE L'INTERFACE DE CAISSE
// *************************************************************************************************************
require ("_dir.inc.php");
include ("./_redirection_extension.inc.php");

require ("_profil.inc.php");
require ($DIR."_session.inc.php");

if(!isset($_REQUEST["Udate_used"])){
	echo "la date au format timestamp UNIX n'est pas spécifié";
	exit;
}
$Udate_used = intval($_REQUEST["Udate_used"]/1000);

if(isset($_REQUEST["HEURE_DE_DEPART"])){
	$_SESSION["agenda"]["vision_semaine"]["HEURE_DE_DEPART"] = $_REQUEST["HEURE_DE_DEPART"]; //en px 
}

$array_Udate_used = getdate($Udate_used);
//$Udate_deb_semaine = date du 1er jour de la semaine (lundi) à 00h00
$Udate_deb_semaine = mktime( 0,  0,  0, $array_Udate_used["mon"], $array_Udate_used["mday"], $array_Udate_used["year"]);
if($array_Udate_used["wday"] != 1)
{		$Udate_deb_semaine = strtotime("last Monday", $Udate_deb_semaine);}

//$Udate_fin_semaine = date du dernier jour de la semaine (dimanche) à 23h59
$Udate_fin_semaine = strtotime("+1 week", $Udate_deb_semaine)-1;
$Udate_lundi 		= $Udate_deb_semaine;
$Udate_mardi 		= strtotime("+1 day" , $Udate_deb_semaine);
$Udate_mercredi = strtotime("+2 days", $Udate_deb_semaine);
$Udate_jeudi 		= strtotime("+3 days", $Udate_deb_semaine);
$Udate_vendredi = strtotime("+4 days", $Udate_deb_semaine);
$Udate_samedi 	= strtotime("+5 days", $Udate_deb_semaine);
$Udate_dimanche = strtotime("+6 days", $Udate_deb_semaine);

$Udate_now 	= time();
$numSemaine = strftime("%W", $Udate_deb_semaine);

unset($array_Udate_used);

$droitsUserAgendas=getDroitVoirAgenda($_SESSION["user"]->getRef_user(),42);
$droitsUserEvents=getDroitVoirAgenda($_SESSION["user"]->getRef_user(),43);

$gride_is_locked = $_SESSION["agenda"]["GestionnaireEvenements"]->gride_is_locked();

$eventsGrilleAvecDroit =& $_SESSION["agenda"]["GestionnaireEvenements"]->getEventsGrilleAvecDroit($Udate_lundi, $Udate_dimanche+86399);// de lundi à 00h00 à dimanche 23h59

//$eventsGrilleAvecDroit[REF_AGENDA_EVENT] = Event


$events_etendus = array();
//$events_grille =& getEvents_atomiques($Udate_lundi, $Udate_dimanche+86399);// de lundi à 00h00 à dimanche 23h59
//$events_etendus =& getEvents_etendus($Udate_lundi, $Udate_dimanche+86399);// de lundi à 00h00 à dimanche 23h59
/*
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
*/

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

//$file_to_load = "page_agenda_view_semaine.inc.php";

include ($DIR.$_SESSION['theme']->getDir_theme()."page_agenda_view_semaine.inc.php");


?>