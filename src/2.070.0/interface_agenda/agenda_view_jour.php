<?php
// *************************************************************************************************************
// PANNEAU AFFICHE EN BAS DE L'INTERFACE DE CAISSE
// *************************************************************************************************************
require ("_dir.inc.php");
include ("./_redirection_extension.inc.php");

require ("_profil.inc.php");
require ($DIR."_session.inc.php");

// *************************************************************************************************************
// RECUPERATION DES VARIABLES
// *************************************************************************************************************

if(!isset($_REQUEST["Udate_used"])){
	echo "la date au format timestamp UNIX n'est pas spécifié";
	exit;
}
$Udate_used = intval($_REQUEST["Udate_used"]/1000);

if(isset($_REQUEST["HEURE_DE_DEPART"])){
	$_SESSION["agenda"]["vision_semaine"]["HEURE_DE_DEPART"] = $_REQUEST["HEURE_DE_DEPART"]; //en px 
}

// *************************************************************************************************************
// TRAITEMENT
// *************************************************************************************************************

$array_Udate_used = getdate($Udate_used);
//$Udate_deb_jour = jour J à 00h00
$Udate_deb_jour = mktime( 0,  0,  0, $array_Udate_used["mon"], $array_Udate_used["mday"], $array_Udate_used["year"]);
//$Udate_fin_jour = jour J à 23h59
$Udate_fin_jour = mktime( 23, 59, 59, $array_Udate_used["mon"], $array_Udate_used["mday"], $array_Udate_used["year"]);
$Udate_now 	= time();

unset($array_Udate_used);


$eventsGrilleAvecDroit =& $_SESSION["agenda"]["GestionnaireEvenements"]->getEventsGrilleAvecDroit($Udate_deb_jour, $Udate_fin_jour);
$gride_is_locked = $_SESSION["agenda"]["GestionnaireEvenements"]->gride_is_locked();

$droitsUserAgendas=getDroitVoirAgenda($_SESSION["user"]->getRef_user(),42);
$droitsUserEvents=getDroitVoirAgenda($_SESSION["user"]->getRef_user(),43);

$events_etendus = array();

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

//$file_to_load = "page_agenda_view_jour.inc.php";

include ($DIR.$_SESSION['theme']->getDir_theme()."page_agenda_view_jour.inc.php");



?>