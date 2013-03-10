<?php
// *************************************************************************************************************
// ACCUEIL DE L'UTILISATEUR ADMINISTRATEUR
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


if (!isset($_REQUEST['lib_agenda'])){
	echo "le libélé de l'agenda n'est pas spécifié";
	exit;
}
$lib_agenda = $_REQUEST['lib_agenda'];

if (!isset($_REQUEST['type_agenda'])){
	echo "le type de l'agenda n'est pas spécifié";
	exit;
}
$type_agenda = $_REQUEST['type_agenda'];

if (!isset($_REQUEST['couleur_1'])){
	echo "la couleur n°1 de l'agenda n'est pas spécifiée";
	exit;
}
$couleur_1 = $_REQUEST['couleur_1'];

if (!isset($_REQUEST['couleur_2'])){
	echo "la couleur n°2 de l'agenda n'est pas spécifiée";
	exit;
}
$couleur_2 = $_REQUEST['couleur_2'];

if (!isset($_REQUEST['couleur_3'])){
	$_REQUEST['couleur_3'] = $_REQUEST['couleur_1'];
//	echo "la couleur n°3 de l'agenda n'est pas spécifiée";
//	exit;
}
$couleur_3 = $_REQUEST['couleur_3'];



$agenda = null;
switch ($type_agenda) {
		case "AgendaReservationRessource" :{
			if (!isset($_REQUEST['ref_ressource'])){
				echo "la ref_ressource n'est pas spécifiée";
				exit;
			}
			$tabRessources = array();
			$tabRessources[] = $_REQUEST["ref_ressource"];
			$agenda =& AgendaReservationRessource::newAgendaWithColorsReservationRessource($lib_agenda, $tabRessources, $couleur_1, $couleur_2, $couleur_3);
			break;}
		case "AgendaContact" :{
			if (!isset($_REQUEST['ref_contact'])){
				echo "la ref_contact n'est pas spécifiée";
				exit;
			}
			$agenda =& AgendaContact::newAgendaWithColorsContact($lib_agenda, $_REQUEST["ref_contact"], $couleur_1, $couleur_2, $couleur_3);
			break;}
		case "AgendaLoacationMateriel" :{
			if (!isset($_REQUEST['ref_article'])){
					echo "la ref_article n'est pas spécifiée";
					exit;
			}
			$agenda =& AgendaLoacationMateriel::newAgendaWithColorsLoacationMateriel($lib_agenda, $_REQUEST["ref_article"], $couleur_1, $couleur_2, $couleur_3);//$id_agenda_couleurs
			break;}
		default:{
			echo "le type_agenda est inconnu";
			exit;}
}

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_agenda_configuration_add.inc.php");

?>