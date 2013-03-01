<?php
// *************************************************************************************************************
// GESTION DES COURRIERS (assigne un model PDF par défaut pour une type de courrier)
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

if (isset($_REQUEST["id_type_courrier"]) && isset($_REQUEST["id_pdf_modele"])) {
	
	set_defaut_courrier_modele_pdf($_REQUEST["id_type_courrier"], $_REQUEST["id_pdf_modele"]);
}
// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_courriers_gestion_types_mod.inc.php");

?>