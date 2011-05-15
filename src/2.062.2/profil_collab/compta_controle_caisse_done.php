<?php
// *************************************************************************************************************
// Controle des caisses
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


$compte_caisse	= new compte_caisse($_REQUEST["id_caisse"]);

$totaux_theoriques = $compte_caisse->controle_total_caisse_move ();
$count_chq_theoriques = $compte_caisse->count_caisse_contenu ($CHQ_E_ID_REGMT_MODE);
$count_cb_theoriques = $compte_caisse->count_caisse_contenu ($CB_E_ID_REGMT_MODE);
// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_compta_controle_caisse_done.inc.php");

?>