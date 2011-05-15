<?php
// *************************************************************************************************************
// LIVRAISONS CLIENTS NON FACTUREES
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

if (!$_SESSION['user']->check_permission ("11")) {
	//on indique l'interdiction et on stop le script
	echo "<br /><span style=\"font-weight:bolder;color:#FF0000;\">Vos droits  d'accés ne vous permettent pas de visualiser ce type de page</span>";
	exit();
}
//chargement des livraisons non facturées
$livraisons = array();
$order = "";
if (isset($_REQUEST['orderorder']) && isset($_REQUEST['orderby']) && $_REQUEST['orderorder'] != "" && $_REQUEST['orderby'] != "") {
$order = $_REQUEST['orderby']." ".$_REQUEST['orderorder'];
}

// chargement de la class du profil
$contact = new contact($_REQUEST["ref_contact"]);

$livraisons = get_client_livraisons_to_facture ($_REQUEST["ref_contact"], $order);
// *************************************************************************************************************
// AFFICHAGE
// -*************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_compta_synth_creances_contact_blnf.inc.php");

?>