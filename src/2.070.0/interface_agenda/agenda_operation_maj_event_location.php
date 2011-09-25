<?php
// *************************************************************************************************************
// PANNEAU AFFICHE EN BAS DE L'INTERFACE DE CAISSE
// *************************************************************************************************************

require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

// ************************************************************************************
// RECUPERATION DES DONNEES MINIMALES POUR LA VERIFICATION DES DROITS
// ************************************************************************************
if(!isset($_REQUEST["ref_agenda"])){
	echo "la référence de l'agenda n'est pas spécifiée";
	exit;
}
$ref_agenda = $_REQUEST["ref_agenda"];

if(!isset($_REQUEST["id_type_event"])){
	echo "l'identifiant du type d'événement n'est pas spécifié";
	exit;
}
$id_type_event = intval($_REQUEST["id_type_event"]);
// ************************************************************************************


// ************************************************************************************
// VERIFICATIONS DES DROITS
// ************************************************************************************
if(!$_SESSION["agenda"]["GestionnaireAgendas"]->addEvent($ref_agenda, $id_type_event)){
	echo "Vous n'avez pas les droits d'ajouter ou de modifier cet événement";
	exit;
}
// ************************************************************************************


// ************************************************************************************
// RECUPERATION ET VERIFICATION DES DONNNES DU FORMULAIRE 
// ************************************************************************************


if(!isset($_REQUEST["scale_used"])){
	echo "l'échelle n'est pas spécifiée";
	exit;
}
$scale_used = $_REQUEST["scale_used"];

if(!isset($_REQUEST["id_graphic_event"])){
	echo "l'identifiant de l'événement graphique n'est pas spécifié";
	exit;
}
$id_graphic_event = $_REQUEST["id_graphic_event"];

if(!isset($_REQUEST["event_lib"])){
	echo "le libélé de l'évènement n'est pas spécifié";
	exit;
}
$event_lib = utf8_decode($_REQUEST["event_lib"]);

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

$date_deb = date_Fr_to_Us($sdate_deb)." ".$sheure_deb.":00";
$date_fin = date_Fr_to_Us($sdate_fin)." ".$sheure_fin.":00";

$Udate_deb = strtotime($date_deb);
$Udate_fin = strtotime($date_fin);

if($Udate_deb > $Udate_fin){
	echo "l'heure de fin de l'évènement est avant l'heure de commencement";
	exit;
}
$duree = round( ($Udate_fin - $Udate_deb) / 60 ); //durée en minutes


if(isset($_REQUEST["note"]))
{			$note = htmlspecialchars(utf8_decode($_REQUEST["note"]));}
else{	$note = "";}

if(!isset($_REQUEST["id_stock"])){
	echo "le stock à débiter n'est pas spécifié";
	exit;
}
$id_stock = $_REQUEST["id_stock"];

if(!isset($_REQUEST["qte"])){
	echo "le quantité à débiter n'est pas spécifiée";
	exit;
}
$qte = $_REQUEST["qte"];
// ************************************************************************************


// ************************************************************************************
// CREATION DE L'obj Event
// ************************************************************************************
if(!isset($_REQUEST["ref_event"])){
	echo "la référence de l'événement n'est pas spécifiée";
	exit;
}
$ref_event = $_REQUEST["ref_event"];
$event = new Event($ref_event);
// ************************************************************************************
global $bdd;
$query = "SELECT `lib_article` FROM `articles` WHERE `ref_article` = (SELECT `ref_article` FROM `agendas_types_location` WHERE `ref_agenda` = '".$ref_agenda."')";
$results = $bdd->query($query);
if ($result = $results->fetchObject()){
	$event_lib1 = substr($event_lib,0,9);
	$event_lib2 = substr($event_lib,9);
	$event_lib = $event_lib1 . $result->lib_article . $event_lib2;
	
	$query2="SELECT COUNT(*) nb_stock FROM `stocks` WHERE `actif` = 1";
	$nbstocks = $bdd->query($query2);
	if ($nbstock = $nbstocks->fetchObject()){
		if($nbstock->nb_stock > 1){
			$query3="SELECT `lib_stock` FROM `stocks` WHERE `id_stock` = '".$id_stock."' ";
			$libstocksselected = $bdd->query($query3);
			if ($libstockselected = $libstocksselected->fetchObject()){
				$event_lib = $event_lib." depuis ".$libstockselected->lib_stock;
			}
		}
	}
	
}
if(!$event->setLib_event($event_lib, $_SESSION["agenda"]["GestionnaireEvenements"]))
{echo "Vous n'avez pas le droit de modifier le libélé de l'événement";}

// ************************************************************************************
// MISES A JOUR DE l'événement
// ************************************************************************************
//if(!$event->setLib_event($event_lib, $_SESSION["agenda"]["GestionnaireEvenements"]))
//{echo "Vous n'avez pas le droit de modifier le libélé de l'événement";}

if(!$event->setRef_Agenda($ref_agenda, $_SESSION["agenda"]["GestionnaireEvenements"]))
{echo "Vous n'avez pas le droit de changer l'événement d'agenda";}

if(!$event->setId_type_event($id_type_event, $_SESSION["agenda"]["GestionnaireEvenements"]))
{echo "Vous n'avez pas le droit de changer l'événement de type";}

if(!$event->setUdate_event($Udate_deb, $_SESSION["agenda"]["GestionnaireEvenements"])/* || !$event->setDuree_event($duree, $_SESSION["agenda"]["GestionnaireEvenements"])*/)
{echo "Vous n'avez pas le droit de mlettre à jour l'heure de l'événement";}

if(!$event->setDuree_event($duree, $_SESSION["agenda"]["GestionnaireEvenements"]))
{echo "L'heure de l'événement n'a pas été mise à jour";}

if(!$event->setNote_event($note, $_SESSION["agenda"]["GestionnaireEvenements"]))
{echo "Vous n'avez pas le droit de modifier les notes de l'événement";}

$jour_semaine = strftime("%w", $Udate_deb);

if($jour_semaine == "0")
{				$jour_semaine = 6;}
else{		$jour_semaine = $jour_semaine - 1;}

$query = "UPDATE `agendas_events_location` SET `id_stock` = '".$id_stock."',  `quantite` = '".$qte."' WHERE `ref_agenda_event` = '".$event->getRef_event()."' ";
if(!$bdd->exec(($query))){
	$query = "INSERT INTO agendas_events_location (id_stock, quantite, ref_agenda_event) VALUES ('".$id_stock."', '".$qte."', '".$event->getRef_event()."') ";
	try {
	$bdd->exec($query);
	}
	catch (Exception $e){

	}
}




$canBeShown = $_SESSION["agenda"]["GestionnaireEvenements"]->canBeShown($event);

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

switch ($scale_used){
	case "jour" 		: { unset($scale_used); include ($DIR.$_SESSION['theme']->getDir_theme()."page_agenda_operation_maj_event_jour.inc.php"); break;}
	case "semaine" 	: { unset($scale_used); include ($DIR.$_SESSION['theme']->getDir_theme()."page_agenda_operation_maj_event_semaine.inc.php"); break;}
	case "mois" 		: { unset($scale_used); include ($DIR.$_SESSION['theme']->getDir_theme()."page_agenda_operation_maj_event_mois.inc.php"); break;}
}

?>