<?php

// *************************************************************************************************************
// GESTION DES COMMANDES CLIENTS (Modele pdf par defaut)
// *************************************************************************************************************

require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

if (isset ($_REQUEST["id_pdf_modele"])) {
	defaut_commande_client_modele_pdf($_REQUEST["id_pdf_modele"]);
}
// *************************************************************************************************************
// AFFICHAGE
// -*************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_communication_mod_commande_client_mod.inc.php");

?>