<?php
// *************************************************************************************************************
// Remise bancaire dépot bancaire depuis la caisse
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


$comptes_bancaires	=  compte_bancaire::charger_comptes_bancaires("" , 1);
$compte_caisse	= new compte_caisse($_REQUEST["id_caisse"]);

$totaux_theoriques = $compte_caisse->controle_total_caisse_move ();
$count_chq_theoriques = $compte_caisse->count_caisse_contenu ($LC_E_ID_REGMT_MODE);
// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_compta_remise_bancaire_traite.inc.php");

?>