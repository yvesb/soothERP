<?php
// *************************************************************************************************************
// PANNEAU AFFICHE EN BAS DE L'INTERFACE DE CAISSE
// *************************************************************************************************************
if(!isset($NoRequireFor_agenda_selectionner_types_events_result)){
	require ("_dir.inc.php");
	require ("_profil.inc.php");
	require ($DIR."_session.inc.php");
	
	if(!isset($_REQUEST['page_source'])){
		echo "La page source n'est pas spécifiée";
		exit;
	}
	$page_source = $_REQUEST['page_source'];
	
	if(!isset($_REQUEST['page_cible'])){
		echo "La page cible n'est pas spécifiée";
		exit;
	}
	$page_cible = $_REQUEST['page_cible'];
	
	if(!isset($_REQUEST['id_type_agenda'])){
		echo "L'iddentifiant du type d'agenda n'est pas spécifié";
		exit;
	}
	$id_type_agenda = $_REQUEST['id_type_agenda'];
}else{
	if(!isset($page_source)){
		echo "La page source n'est pas spécifiée";
		exit;
	}
	
	if(!isset($page_cible)){
		echo "La page cible n'est pas spécifiée";
		exit;
	}
	
	if(!isset($id_type_agenda)){
		echo "L'identifiant du type d'agenda n'est pas spécifié";
		exit;
	}
}



if($id_type_agenda == 0){
	$typesEventsAvecDroits = $_SESSION["agenda"]["GestionnaireAgendas"]->getTypesEventsAvecDroits();
}else{
	$typesEventsAvecDroits = $_SESSION["agenda"]["GestionnaireAgendas"]->getTypesEventsAvecDroits($id_type_agenda);
}

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_agenda_selectionner_types_events_result.inc.php");

?>