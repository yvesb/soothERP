<?php
// *************************************************************************************************************
// CONFIG DES DONNEES tarifaires
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

//liste des pays pour affichage dans select
$listepays = getPays_select_list ();

$id_pays = $DEFAUT_ID_PAYS;
if (isset($_REQUEST["id_pays"])) { $id_pays = $_REQUEST["id_pays"]; }


$tvas = get_tvas ($id_pays);
// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_configuration_tva.inc.php");

?>