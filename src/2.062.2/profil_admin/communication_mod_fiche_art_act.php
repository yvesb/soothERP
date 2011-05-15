<?php
// *************************************************************************************************************
// GESTION DES ARTICLES (Activation d'un modele pdf)
// *************************************************************************************************************

require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

if (isset($_REQUEST["ref_art_categ"]) && isset ($_REQUEST["id_pdf_modele"])) {
	active_art_modele_pdf ($_REQUEST["ref_art_categ"], $_REQUEST["id_pdf_modele"]);
}
// *************************************************************************************************************
// AFFICHAGE
// -*************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_communication_mod_fiche_art_mod.inc.php");

?>