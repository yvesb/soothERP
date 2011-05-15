<?php
// *************************************************************************************************************
// GESTION DES STATS (Modele pdf par defaut)
// *************************************************************************************************************

require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

if (isset($_REQUEST["id_stat"]) && isset ($_REQUEST["id_pdf_modele"])) {
	defaut_stats_modele_pdf ($_REQUEST["id_stat"], $_REQUEST["id_pdf_modele"]);
}
// *************************************************************************************************************
// AFFICHAGE
// -*************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_communication_mod_fiche_stats_mod.inc.php");

?>