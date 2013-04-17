<?php
// *************************************************************************************************************
// GESTION DES STATS (Désactivation d'un modele pdf)
// *************************************************************************************************************

require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

if ( isset ($_REQUEST["id_export_modele"])) {
	desactive_resultats_commerciaux_export($_REQUEST["id_export_modele"]);
}
// *************************************************************************************************************
// AFFICHAGE
// -*************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_communication_mod_export_resultat_commerciaux_mod.inc.php");

?>