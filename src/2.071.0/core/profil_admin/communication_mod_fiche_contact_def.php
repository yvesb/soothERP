<?php
// *************************************************************************************************************
// GESTION DES ARTICLES (Modele pdf par defaut)
// *************************************************************************************************************

require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

if (isset($_REQUEST["id_profil"]) && isset ($_REQUEST["id_pdf_modele"])) {
	defaut_contact_modele_pdf ($_REQUEST["id_profil"], $_REQUEST["id_pdf_modele"]);
}
// *************************************************************************************************************
// AFFICHAGE
// -*************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_communication_mod_fiche_contact_mod.inc.php");

?>