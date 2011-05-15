<?php
$DIR = "../";
require ($DIR."_session.inc.php");


// Changement du magasin en cours pour la session
if (!isset($_REQUEST['id_magasin'])) {
	$GLOBALS['_ALERTES']['no_id_magasin'] = 1;
}
if ( !is_numeric($_REQUEST['id_magasin']) || !isset($_SESSION['magasins'][$_REQUEST['id_magasin']]) ) {
	$GLOBALS['_ALERTES']['bad_id_magasin'] = 1;
}

if (count($GLOBALS['_ALERTES'])) { return false; }


setcookie('last_id_magasin', $_REQUEST['id_magasin'], time() + (365*24*3600), "/");
$_SESSION['magasin'] = &$_SESSION['magasins'][$_REQUEST['id_magasin']];

return true;
?>