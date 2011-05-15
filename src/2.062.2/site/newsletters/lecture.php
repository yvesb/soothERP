<?php
// *************************************************************************************************************
// Lecture d'un email d'une newsletter
// *************************************************************************************************************

$_INTERFACE['MUST_BE_LOGIN'] = 0;

require ("__dir.inc.php");
require ($DIR."_session.inc.php");

if (isset($_REQUEST["id_envoi"]) && isset($_REQUEST["email"]) ) {
	maj_envoi_lecture ($_REQUEST["id_envoi"], $_REQUEST["email"], 1);
}

header ("Location: ".$DIR.$_SESSION['theme']->getDir_theme();."images/blank.gif");
?>