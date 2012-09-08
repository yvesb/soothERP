<?php
// *************************************************************************************************************
// MAJ de la NOTE D'UNE TACHE
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


if (isset($_REQUEST["id_tache"])) {
//maj de la tache
$tache = new tache ($_REQUEST["id_tache"]);
$tache->maj_etat_tache($_REQUEST["etat"]);
}
echo $_REQUEST["etat"];

?>k