<?php
// *************************************************************************************************************
// ACCUEIL DE L'UTILISATEUR ADMINISTRATEUR
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


//reception des infos
$id_taxe	=	urldecode($_REQUEST["id_taxe"]);

$import_taxe	=	new taxe($id_taxe);
$import_taxe->suppression();
// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_catalogue_taxes_sup.inc.php");

?>