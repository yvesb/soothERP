<?php
// *************************************************************************************************************
// GESTION DES STATS (Modele pdf par defaut)
// *************************************************************************************************************

require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

if ( isset ($_REQUEST["id_export_modele"])) {
	defaut_documents_export($_REQUEST["id_export_modele"]);
}
// *************************************************************************************************************
// AFFICHAGE
// -*************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_communication_mod_export_documents_mod.inc.php");

?>