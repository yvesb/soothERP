<?php
// *************************************************************************************************************
// ajout retrait de fonds pour caisse 
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


$compte_caisse	= new compte_caisse($_REQUEST["id_caisse"]);

$totaux_theoriques = $compte_caisse->controle_total_caisse_move ();
// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_compta_ar_fonds_caisse.inc.php");

?>