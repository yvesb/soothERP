<?php
// *************************************************************************************************************
// SUPPRESSION D'UN COLLAB A UNE TACHE
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

if (isset($_REQUEST["id_tache"])) {
	//maj de la tache
	$tache = new tache ($_REQUEST["id_tache"]);
	$tache->del_collab($_REQUEST["ref_contact"]);
}

?>k