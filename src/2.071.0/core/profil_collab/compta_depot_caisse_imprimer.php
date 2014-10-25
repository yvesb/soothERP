<?php
// *************************************************************************************************************
// IMPRESSION DEPOT DE LA CAISSE VERS LA BANQUE
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

$print = 0;
if (isset($_REQUEST["print"])) {$print = 1;}
//imprimer un controle
$compte_caisse	= new compte_caisse($_REQUEST["id_caisse"]);
$compte_caisse->imprimer_depot_caisse ($print, $_REQUEST["id_compte_caisse_depot"]);


?>