<?php
// *************************************************************************************************************
// Controle des caisses
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

$compte_caisse_controle = compte_caisse::charge_controle_compte_caisse ($_REQUEST["id_compte_caisse_controle"]);
$compte_caisse	= new compte_caisse($compte_caisse_controle->id_compte_caisse);


// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_compta_controle_caisse_view.inc.php");

?>