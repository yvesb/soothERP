<?php
// *************************************************************************************************************
// MAJ DE L'ETAT D'UN TICKET
// *************************************************************************************************************
	
	
	require ("_dir.inc.php");
	require ("_profil.inc.php");
	require ("_session.inc.php");
	
	
	if (!isset($_REQUEST['ref_doc']) || $_REQUEST['ref_doc'] == "") {
		echo "La référence du ticket n'est pas spécifiée";
		exit;
	}
	
	if (!isset($_REQUEST['new_etat_doc']) || $_REQUEST['new_etat_doc'] == "") {
		echo "Le nouvel état n'est pas spécifié";
		exit;
	}
	
	$new_etat_doc = $_REQUEST['new_etat_doc'];
	
	$document = open_doc ($_REQUEST['ref_doc']);
	
	if($document->getId_etat_doc() != $new_etat_doc){
		$document->maj_etat_doc($_REQUEST['new_etat_doc']);
	}
	
	include ($DIR.$_SESSION['theme']->getDir_theme()."page_caisse_maj_etat_ticket.inc.php");
?>
