<?php
// *************************************************************************************************************
// ACCUEIL DE L'UTILISATEUR ADMINISTRATEUR
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

//affichage pour les taxes
$id_pays_sel=$DEFAUT_ID_PAYS;
if (isset($_REQUEST["id_pays"])) {
	$id_pays_sel=$_REQUEST["id_pays"];
}

//liste des taxes du pays choisi
$taxes = taxes_pays ($id_pays_sel);

include ($DIR.$_SESSION['theme']->getDir_theme()."page_catalogue_taxes_client.inc.php");
?>