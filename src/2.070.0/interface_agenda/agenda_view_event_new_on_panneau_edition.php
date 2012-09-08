<?php
// *************************************************************************************************************
// 
// *************************************************************************************************************

require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

if($_SESSION["agenda"]["GestionnaireEvenements"]->gride_is_locked()){
	echo "Vous n'avez aucun droit sur aucun agenda";
	exit;
}

// L'EVENT n'existe pas en BD. Il n'est visible QUE graphiquement *************************

//@TODO Définir $event_duree_moyenne
$event_duree_moyenne = 1800; // = 30 min

// *******************************************************************************
// VERIFICATION DES DONNEES VENANT DU FORMULAIRE
// *******************************************************************************

if(!isset($_REQUEST["id_graphic_event"]) || !is_numeric($_REQUEST["id_graphic_event"])){
	echo "L'identifiant de l'évènement n'est pas spécifié";
	exit;
}
$id_graphic_event = $_REQUEST["id_graphic_event"];

if(isset($_REQUEST["Udate_event"]) && is_numeric($_REQUEST["Udate_event"]) )
{			$Udate_event_deb = intval($_REQUEST["Udate_event"]/1000);}
else{	$Udate_event_deb = time();}

if(isset($_REQUEST["duree_event"]) && is_numeric($_REQUEST["duree_event"]) )
{			$duree_event = intval($_REQUEST["duree_event"]);}
else{	$duree_event = $event_duree_moyenne;}

$Udate_event_fin = $Udate_event_deb + $duree_event;

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_agenda_view_event_new_on_panneau_edition.inc.php");

?>