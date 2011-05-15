<?php
// *************************************************************************************************************
// GESTION DES ARTICLES (modele pdf par défaut)
// *************************************************************************************************************

require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

if (isset($_REQUEST["ref_art_categ"]) && isset ($_REQUEST["id_pdf_modele"])) {
	defaut_art_modele_pdf ($_REQUEST["ref_art_categ"], $_REQUEST["id_pdf_modele"]);
}
// *************************************************************************************************************
// AFFICHAGE
// -*************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_communication_mod_fiche_art_mod.inc.php");

?>