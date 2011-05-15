<?php
// *************************************************************************************************************
// GESTION DES COURRIERS (Désactivation d'un modele pdf)
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

if (isset($_REQUEST["id_type_courrier"])) {
	desactive_courrier_modele_pdf($_REQUEST["id_type_courrier"]);
}
// *************************************************************************************************************
// AFFICHAGE
// -*************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_courriers_gestion_types_mod.inc.php");

?>