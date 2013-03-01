<?php
// *************************************************************************************************************
// PANNEAU AFFICHE EN BAS DE L'INTERFACE DE CAISSE
// *************************************************************************************************************
if(!isset($NoRequireFor_agenda_selectionner_agendas_result)){
	require ("_dir.inc.php");
	require ("_profil.inc.php");
	require ($DIR."_session.inc.php");

	if(!isset($_REQUEST['page_source'])){
		echo "La page source est inconnue";
		exit;
	}
	$page_source = $_REQUEST['page_source'];
	
	if(!isset($_REQUEST['page_cible'])){
		echo "La page cible est inconnue";
		exit;
	}
	$page_cible = $_REQUEST['page_cible'];
	
	if(!isset($_REQUEST['id_liste_agenda'])){
		echo "L'id de la liste d'agenda est inconnu";
		exit;
	}
	$id_liste_agenda = $_REQUEST['id_liste_agenda'];
}else{
	if(!isset($page_source)){
		echo "La page source n'est pas spécifiée";
		exit;
	}
	
	if(!isset($page_cible)){
		echo "La page cible n'est pas spécifiée";
		exit;
	}
	
	if(!isset($id_liste_agenda)){
		echo "L'identifiant de la liste d'agenda est inconnu";
		exit;
	}
}

if($id_liste_agenda == 0){
	$agendasAvecDroits = $_SESSION["agenda"]["GestionnaireAgendas"]->getAgendasAvecDroits();
}else{
	$agendasAvecDroits = $_SESSION["agenda"]["GestionnaireAgendas"]->getAgendasAvecDroits($id_liste_agenda);
}


// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_agenda_selectionner_agendas_result.inc.php");

?>