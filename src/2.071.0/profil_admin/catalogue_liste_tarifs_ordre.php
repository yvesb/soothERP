<?php
// *************************************************************************************************************
// MODIFICATION DE L'ORDRE DES GRILLES TARIFAIRES
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");



// *************************************************
// Controle des données fournies par le formulaire


$new_ordre				= $_REQUEST['ordre'];
$new_ordre_other	= $_REQUEST['ordre_other'];

//on récupére fonction de l'ordre la premier ref
$id_tarif	= getId_tarif_from_ordre($_REQUEST['ordre_other']);

//on récupére fonction de l'ordre la deuxième ref
$id_tarif_other	= getId_tarif_from_ordre ($_REQUEST['ordre']);



// *************************************************
// modification de l'ordre
$tarif_liste			 = new tarif_liste ($id_tarif);
$tarif_liste-> modifier_ordre ($new_ordre);

// *************************************************************************************************************
// AFFICHAGE
// -*************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_catalogue_liste_tarifs_ordre.inc.php");

?>