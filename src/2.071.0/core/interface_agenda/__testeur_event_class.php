<?php 
require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


//$reference = new reference(36);
//$ref_event = $reference->generer_ref();
/*
$tressources = array();
$tressources[] = array();
$tressources[0]["ref_ressource"] = "RES-000000-00020";
$tressources[0]["lib_ressource"] = "ma ressource";
*/

//$agenda =& AgendaContact::newAgendaContact("agenda de test", "C-000000-00001");
//$agenda = new AgendaContact("AG_C-000000-00010");

//$agenda =& AgendaLoacationMateriel::newAgendaLoacationMateriel("agenda de test", "A-000000-00005");
$agenda = new AgendaLoacationMateriel("AGLM-000000-00001");



//$agenda =& AgendaReservationRessource::newAgendaReservationRessource("agenda de test", $tressources);
//$agenda = new AgendaReservationRessource("AGRR-000000-00043");

$eventParent = null;
$agenda->addNewEvent($eventParent, "event_de_test4", "ma note4", "2009-12-30 10:12:14", 45);
$agenda->addNewEvent($eventParent, "event_de_test5", "ma note5", "2009-12-30 10:12:14", 45);
$agenda->addNewEvent($eventParent, "event_de_test6", "ma note6", "2009-12-30 10:12:14", 45);

$events =& $agenda->getEvents();




var_dump($agenda);
echo "<br/><hr/><br/>";
var_dump($events);
?>