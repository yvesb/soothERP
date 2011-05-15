<?php
// *************************************************************************************************************
// REMISE A ZERO D'UNE CAISSE
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


$compte_caisse	= new compte_caisse($_REQUEST["id_caisse"]);
$last_date_controle = $compte_caisse->getLast_date_controle ();
$totaux_theoriques = $compte_caisse->controle_total_caisse_move ();
// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_compta_raz_caisse.inc.php");

?>