<?php
// *************************************************************************************************************
// ACCUEIL COMPTA CLIENT
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");



if (!$_SESSION['user']->check_permission ("11")) {
	//on indique l'interdiction et on stop le script
	echo "<br /><span style=\"font-weight:bolder;color:#FF0000;\">Vos droits  d'accès ne vous permettent pas de visualiser ce type de page</span>";
	exit();
}

global $bdd;

//$nbre_non_editee = get_nb_Factures_pour_niveau_relance(1);


//$nbre_relance = get_nb_Factures_pour_niveau_relance(array(2,3,4,5,6,7,8,9,10,11,12));


//$nbre_contentieux = get_nb_Factures_pour_niveau_relance(array(13,14,15,16));

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_compta_situation_client.inc.php");

?>
