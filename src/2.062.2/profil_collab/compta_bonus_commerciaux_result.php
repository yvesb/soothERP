<?php
require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

if (!$_SESSION['user']->check_permission ("17")) {
	//on indique l'interdiction et on stop le script
	echo "<br /><span style=\"font-weight:bolder;color:#FF0000;\">Vos droits  d'accés ne vous permettent pas de visualiser ce type de page</span>";
	exit();
}

$params = array();
$params["ref_commercial"] = $_REQUEST["ref_commercial"];
$params["date_debut"] = $_REQUEST["date_deb"];
$params["date_fin"] = $_REQUEST["date_fin"];
$params["lib_bonus"] = $_REQUEST["lib_bonus"];
$params["montant"] = $_REQUEST["montant"];
$params["delta"] = $_REQUEST["delta"];
$params["order"] = $_REQUEST["order"];

$bonus = new commission_bonus();
$lesbonus = $bonus->findBonus($params);

include ($DIR.$_SESSION['theme']->getDir_theme()."page_compta_bonus_commerciaux_result.inc.php");

?>
