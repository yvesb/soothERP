<?php
// *************************************************************************************************************
// journal client
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

_vardump($_REQUEST);
if (!$_SESSION['user']->check_permission ("12")) {
	//on indique l'interdiction et on stop le script
	echo "<br /><span style=\"font-weight:bolder;color:#FF0000;\">Vos droits  d'accés ne vous permettent pas de visualiser ce type de page</span>";
	exit();
}

if (!empty($_REQUEST['aut_to_del'])){
    $query = "DELETE FROM comptes_bancaires_autorisations WHERE id_compte_bancaire_autorisation = '".$_REQUEST["aut_to_del"]."'";
    $bdd->exec($query);
}
?>