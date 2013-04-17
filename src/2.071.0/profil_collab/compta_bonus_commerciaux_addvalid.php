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

$bonus = new commission_bonus();
$bonus->create($_REQUEST['ref_commercial'],$_REQUEST['lib_bonus'],$_REQUEST['desc_bonus'], $_REQUEST['montant']);

?>
