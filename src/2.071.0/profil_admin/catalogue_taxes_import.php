<?php
// *************************************************************************************************************
// ACCUEIL DE L'UTILISATEUR ADMINISTRATEUR
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


//reception des infos
$id_taxe	=	urldecode($_REQUEST["id_taxe"]);
$lib_taxe	=	urldecode($_REQUEST["lib_taxe"]);
$id_pays	=	urldecode($_REQUEST["id_pays"]);
$code_taxe	=	urldecode($_REQUEST["code_taxe"]);
$info_calcul	=	urldecode($_REQUEST["info_calcul"]);

$import_taxe	=	new taxe();
$import_taxe->import ($id_taxe, $lib_taxe, $id_pays, $code_taxe, $info_calcul);
// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_catalogue_taxes_import.inc.php");

?>