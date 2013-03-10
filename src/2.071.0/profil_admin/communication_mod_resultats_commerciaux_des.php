<?php
// *************************************************************************************************************
// GESTION DES Résultats commerciaux (Désactivation d'un modele pdf)
// *************************************************************************************************************

require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

if (isset ($_REQUEST["id_pdf_modele"])) {
	
	desactive_resultats_commerciaux_modele_pdf ($_REQUEST["id_pdf_modele"]);
}
// *************************************************************************************************************
// AFFICHAGE
// -*************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_communication_mod_resultats_commerciaux_mod.inc.php");

?>