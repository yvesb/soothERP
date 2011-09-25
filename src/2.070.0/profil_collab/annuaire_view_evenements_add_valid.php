<?php
// *************************************************************************************************************
// AJOUT D'UN EVENEMENT
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


if (!isset($_REQUEST['ref_contact_event'])) {
	echo "La référence du contact n'est pas précisée";
	exit;
}

$contact = new contact ($_REQUEST['ref_contact_event']);
if (!$contact->getRef_contact()) {
	echo "La référence du contact est inconnue";		exit;

}
$heure_event = "00:00:00";
if ($_REQUEST["heure_event"]) {$heure_event = $_REQUEST["heure_event"].":00";}
$date_event = date_Fr_to_Us($_REQUEST["date_event"])." ".$heure_event;
$duree_event = "00:00:00";
if ($_REQUEST["duree_event"]) {$duree_event = $_REQUEST["duree_event"].":00";}
$ref_user = $_REQUEST["ref_user"] ;
$id_comm_event_type = $_REQUEST["id_comm_event_type"] ;
$texte = $_REQUEST["texte"] ;

$date_rappel = "0000-00-00 00:00:00";
if ($_REQUEST["date_rappel"]) {$date_rappel = date_Fr_to_Us($_REQUEST["date_rappel"])." ".getTime_from_date($_REQUEST["date_rappel"]).":00";}

$contact->add_evenement ($date_event, $duree_event, $ref_user, $id_comm_event_type, $texte, $date_rappel);

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_annuaire_view_evenements_add_valid.inc.php");

?>