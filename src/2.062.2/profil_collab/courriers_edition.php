<?php
// *************************************************************************************************************
// OUVERTURE D'UN COURRIER EN MODE EDITION
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


//$infos_types = courrier_infos_types();

$destinataire = new contact ($_REQUEST['ref_destinataire']);
if (!$destinataire->getRef_contact()) {
	echo "La référence du destinataire est inconnuel";
	exit;
}

if(isset($_REQUEST['id_courrier']) && is_numeric($_REQUEST['id_courrier']) && $_REQUEST['id_courrier'] >0){
	$courrier = new CourrierEtendu($_REQUEST['id_courrier']);
}
else{
	echo "L'identifiant du courrier est inconnu";
	exit;
}

// *************************************************************************************************************
// AFFICHAGE
// -*************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_courriers_edition.inc.php");

?>