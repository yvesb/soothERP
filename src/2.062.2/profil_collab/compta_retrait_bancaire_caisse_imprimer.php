<?php
// *************************************************************************************************************
// IMPRESSION Retrait DE LA BANQUE VERS  LA CAISSE
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

$print = 0;
if (isset($_REQUEST["print"])) {$print = 1;}
//imprimer un controle
$compte_caisse	= new compte_caisse($_REQUEST["id_caisse"]);
$compte_caisse->imprimer_retrait_caisse ($print, $_REQUEST["id_compte_caisse_retrait"]);


?>