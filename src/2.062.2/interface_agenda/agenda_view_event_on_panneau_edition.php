<?php
// *************************************************************************************************************
// PANNEAU AFFICHE EN BAS DE L'INTERFACE DE CAISSE
// *************************************************************************************************************

require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

//@TODO Définir $event_duree_moyenne
$event_duree_moyenne = 1800; // = 30 min

$Udate_event_deb 	= time();
$Udate_event_fin 	= time()+$event_duree_moyenne;

define("VIERGE", 0, true);
define("EDITION", 1, true);
define("VALIDATION", 2, true);
define("CREATION", 3, true);
define("PAS_DROIT", 4, true);

$bt_maj_visible = VIERGE;

if(!isset($_REQUEST["echelle"]) || $_REQUEST["echelle"] == ""){
	echo "L'échelle de l'agenda n'est pas spécifiée";
	exit;
}
$echelle = $_REQUEST["echelle"]; //JOUR, SEMAINE, MOIS

// L'EVENT existe déjà en BD ***************************************************************
if(!isset($_REQUEST["ref_event"]) || $_REQUEST["ref_event"] == ""){
	echo "La référence de l'évènement n'est pas spécifiée";
	exit;
}

$event = new Event($_REQUEST["ref_event"]);	
if(!$event->getRef_event($_SESSION["agenda"]["GestionnaireEvenements"])){
	echo "La référence de l'évènement est mal formatée";
	exit;
}


if(isset($_REQUEST["readonly"])){
	$readonly = $_REQUEST["readonly"];	
}

if(!isset($_REQUEST["id_graphic_event"]) || !is_numeric($_REQUEST["id_graphic_event"])){
	echo "L'identifiant graphique de l'évènement n'est pas spécifié";
	exit;
}
$id_graphic_event = $_REQUEST["id_graphic_event"];

if(isset($_REQUEST["Udate_event"]) && is_numeric($_REQUEST["Udate_event"]) ){
	$event->setUdate_event(intval($_REQUEST["Udate_event"]/1000), $_SESSION["agenda"]["GestionnaireEvenements"]);
}

if(isset($_REQUEST["duree_event"]) && is_numeric($_REQUEST["duree_event"]) ){
	$event->setDuree_event(round(intval($_REQUEST["duree_event"])/60), $_SESSION["agenda"]["GestionnaireEvenements"]);
}

if($_SESSION["agenda"]["GestionnaireEvenements"]->modifier_type_event($event)){
	$bt_maj_visible = EDITION;
}else{
	$bt_maj_visible = PAS_DROIT;
}

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_agenda_view_event_on_panneau_edition.inc.php");

?>