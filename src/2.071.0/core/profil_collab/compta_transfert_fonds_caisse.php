<?php
// *************************************************************************************************************
// TRANFERT de fonds d'une caisse vars une autre caisse
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


$comptes_caisses	= compte_caisse::charger_comptes_caisses("", "1");
$compte_caisse	= new compte_caisse($_REQUEST["id_caisse"]);

$totaux_theoriques = $compte_caisse->controle_total_caisse_move ();
$count_chq_theoriques = $compte_caisse->count_caisse_contenu ($CHQ_E_ID_REGMT_MODE);
// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_compta_transfert_fonds_caisse.inc.php");

?>