<?php
// *************************************************************************************************************
// AJOUT D'UNE FONCTION COLLAB A UNE TACHE
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

if (isset($_REQUEST["id_tache"])) {
	//maj de la tache
	$tache = new tache ($_REQUEST["id_tache"]);
	$tache->add_fonction($_REQUEST["id_fonction"]);
}

?>k