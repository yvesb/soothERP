<?php
// *************************************************************************************************************
// Considére un tache d'admin comme executée
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

if (isset($_REQUEST["id_tache_admin"])) {
	$taches_admin = new tache_admin($_REQUEST["id_tache_admin"]);
	
	$taches_admin->exec_tache () ;
}

include ($DIR.$_SESSION['theme']->getDir_theme()."page_tache_admin_exec.inc.php");

?>