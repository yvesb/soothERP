<?php
// *************************************************************************************************************
// GESTION DES COMMANDES CLIENTS (Désactivation d'un modele pdf)
// *************************************************************************************************************

require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

if (isset ($_REQUEST["id_pdf_modele"])) {
	
	desactive_commande_client_modele_pdf ($_REQUEST["id_pdf_modele"]);
}
// *************************************************************************************************************
// AFFICHAGE
// -*************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_communication_mod_commande_client_mod.inc.php");

?>