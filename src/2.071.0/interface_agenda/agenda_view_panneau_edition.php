<?php
// *************************************************************************************************************
// PANNEAU AFFICHE EN BAS DE L'INTERFACE DE CAISSE
// *************************************************************************************************************

require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

//@TODO Définir $event_duree_moyenne
$event_duree_moyenne = 1800; // = 30 min

$id_graphic_event = "";

$ref_event 				= "";
$ref_agenda		 		= "";
$lib_event 				= "";
$Udate_event_deb 	= time();
$Udate_event_fin 	= time()+$event_duree_moyenne;
$note_event 			= "";

$bt_maj_visible = "vierge"; 

// L'EVENT existe déjà en BD ***************************************************************
if(isset($_REQUEST["ref_event"]) && $_REQUEST["ref_event"] != ""){
	$event = new Event($_REQUEST["ref_event"]);	
	if(!$event->getRef_event()){
		echo "La référence de l'évènement est mal formatée";
		exit;
	}
	
	if(isset($_REQUEST["id_graphic_event"]) && is_numeric($_REQUEST["id_graphic_event"])){
		if(!isset($_REQUEST["id_graphic_event"])){
			echo "L'identifiant de l'évènement n'est pas spécifié";
			exit;
		}
		$id_graphic_event = $_REQUEST["id_graphic_event"];
		
		if(!isset($_REQUEST["Udate_event"]) || !is_numeric($_REQUEST["Udate_event"]) ){
			echo "La date de l'évènement n'est pas spécifiée";
			exit;
		}
		$event->setUdate_event($_REQUEST["Udate_event"]/1000);
		
		if(!isset($_REQUEST["duree_event"]) || !is_numeric($_REQUEST["duree_event"]) ){
			echo "La durée de l'évènement n'est pas spécifiée";
			exit;
		}
		$event->setDuree_event(round($_REQUEST["duree_event"]/60));
		
		$bt_maj_visible = "edition";
	}
	
	$ref_event 				= $event->getRef_event();
	$ref_agenda		 		= $event->getRef_agenda();
	$lib_event		 		= $event->getLib_event();
	$Udate_event_deb 	= $event->getUdate_event();
	$Udate_event_fin 	= $event->getUdate_event()+($event->getDuree_event()*60);
	$note_event 			= $event->getNote_event();
	
	unset($event);	
}// L'EVENT n'existe pas en BD. Il n'est visible QUE graphiquement *************************
	elseif(isset($_REQUEST["id_graphic_event"]) && is_numeric($_REQUEST["id_graphic_event"])){
	if(!isset($_REQUEST["id_graphic_event"])){
		echo "L'identifiant de l'évènement n'est pas spécifié";
		exit;
	}
	$id_graphic_event = $_REQUEST["id_graphic_event"];
	
	if(!isset($_REQUEST["Udate_event"]) || !is_numeric($_REQUEST["Udate_event"]) ){
		echo "La date de l'évènement n'est pas spécifiée";
		exit;
	}
	$Udate_event_deb = $_REQUEST["Udate_event"]/1000;
	
	if(!isset($_REQUEST["duree_event"]) || !is_numeric($_REQUEST["duree_event"]) ){
		echo "La durée de l'évènement n'est pas spécifiée";
		exit;
	}
	$Udate_event_fin = $Udate_event_deb + round($_REQUEST["duree_event"]);
	
	$bt_maj_visible = "validation";
}


// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_agenda_view_panneau_edition.inc.php");

?>