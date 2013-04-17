<?php
// *************************************************************************************************************
// PANNEAU AFFICHE EN BAS DE L'INTERFACE DE CAISSE
// *************************************************************************************************************

require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


// ************************************************************************************
// RECUPERATION DES DONNNES
// ************************************************************************************
if(!isset($_REQUEST["scale_used"])){
	echo "l'échelle n'est pas spécifiée";
	exit;
}
$scale_used = $_REQUEST["scale_used"];

if(isset($_REQUEST["id_graphic_event"]))
{			$id_graphic_event =$_REQUEST["id_graphic_event"];}
else{	$id_graphic_event = "";}

if(!isset($_REQUEST["event_lib"])){
	echo "le libélé de l'évènement n'est pas spécifié";
	exit;
}
$event_lib = htmlspecialchars(utf8_decode($_REQUEST["event_lib"]));

if(!isset($_REQUEST["ref_agenda"])){
	echo "la référence de l'agenda n'est pas spécifiée";
	exit;
}
$ref_agenda = $_REQUEST["ref_agenda"];

if(!isset($_REQUEST["id_type_event"])){
	echo "l'identifiant du type de l'événement n'est pas spécifié";
	exit;
}
$id_type_event = $_REQUEST["id_type_event"];

if(!isset($_REQUEST["sdate_deb"])){
	echo "la date de commencement de l'évènement n'est pas spécifiée";
	exit;
}
$sdate_deb = $_REQUEST["sdate_deb"];

if(!isset($_REQUEST["sdate_fin"])){
	echo "la date de fin de l'évènement n'est pas spécifiée";
	exit;
}
$sdate_fin = $_REQUEST["sdate_fin"];

if(!isset($_REQUEST["sheure_deb"])){
	echo "l'heure de commencement de l'évènement n'est pas spécifiée";
	exit;
}
$sheure_deb = $_REQUEST["sheure_deb"];

if(!isset($_REQUEST["sheure_fin"])){
	echo "l'heure de fin de l'évènement n'est pas spécifiée";
	exit;
}
$sheure_fin = $_REQUEST["sheure_fin"];

if(isset($_REQUEST["note"]))
{		$note = htmlspecialchars(utf8_decode($_REQUEST["note"]));}
else{		$note = "";}

// ************************************************************************************
// VERIFICATION DES DONNNES
// ************************************************************************************

$date_deb = date_Fr_to_Us($sdate_deb)." ".$sheure_deb.":00";
$date_fin = date_Fr_to_Us($sdate_fin)." ".$sheure_fin.":00";

$Udate_deb = strtotime($date_deb);
$Udate_fin = strtotime($date_fin);
	
if($Udate_deb > $Udate_fin){
	echo "l'heure de fin de l'évènement est avant l'heure de commencement";
	exit;
}
$duree = round( ($Udate_fin - $Udate_deb) / 60 ); //durée en minutes
$event_Parent = null;

// ************************************************************************************
// TRAITEMENT
// ************************************************************************************

$event =& Event::newEvent($ref_agenda, $id_type_event, $event_Parent, $event_lib, $note, $Udate_deb, $duree);

if($event == null){
	echo "l'obejt event est null";
	exit;
}

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

switch ($scale_used){
	case "jour" 		: { unset($scale_used); include ($DIR.$_SESSION['theme']->getDir_theme()."page_agenda_operation_add_event_jour.inc.php"); break;}
	case "semaine" 	: { unset($scale_used); include ($DIR.$_SESSION['theme']->getDir_theme()."page_agenda_operation_add_event_semaine.inc.php"); break;}
	case "mois" 		: { unset($scale_used); include ($DIR.$_SESSION['theme']->getDir_theme()."page_agenda_operation_add_event_mois.inc.php"); break;}
}

?>