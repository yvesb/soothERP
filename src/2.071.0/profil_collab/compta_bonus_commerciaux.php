<?php
require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

/* Quel num permission ??? */
if (!$_SESSION['user']->check_permission ("17")) {
	//on indique l'interdiction et on stop le script
	echo "<br /><span style=\"font-weight:bolder;color:#FF0000;\">Vos droits  d'accés ne vous permettent pas de visualiser ce type de page</span>";
	exit();
}

$commerciaux = getContacts_profil(7);


// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_compta_bonus_commerciaux.inc.php");

?>
