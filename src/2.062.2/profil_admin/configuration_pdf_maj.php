<?php
// *************************************************************************************************************
// CONFIRGURATION DES DONNÉES pdf
// *************************************************************************************************************

$MUST_BE_LOGIN = 1;
require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");



//mise à jour des données transmises
//logo
if (!empty($_FILES['image']['tmp_name'])) {
	//copie du fichier
	if ((	substr_count($_FILES["image"]["name"], ".jpg") || substr_count($_FILES["image"]["name"], ".jpeg") ) && (	copy ($_FILES['image']['tmp_name'], $IMAGES_DIR.$_FILES["image"]["name"]))) {
		//maj de l'info logo dans le config_generale
		maj_configuration_file ("config_generale.inc.php", "maj_line", "\$DOCUMENTS_IMG_LOGO =", "\$DOCUMENTS_IMG_LOGO = \"".$_FILES["image"]["name"]."\";", $CONFIG_DIR);
	} 
}


if (isset($_REQUEST["aff_remises"]) && $_REQUEST["aff_remises"] == "1") {
	maj_configuration_file ("config_generale.inc.php", "maj_line", "\$AFF_REMISES	=", "\$AFF_REMISES	= 1;", $CONFIG_DIR);
} else {
	maj_configuration_file ("config_generale.inc.php", "maj_line", "\$AFF_REMISES	=", "\$AFF_REMISES	= 0;", $CONFIG_DIR);
}

//textes de pied de page pdf
maj_configuration_file ("config_generale.inc.php", "maj_line", "\$PIED_DE_PAGE_GAUCHE_0 =", "\$PIED_DE_PAGE_GAUCHE_0 = \"".str_replace("¤", "€", (addslashes($_REQUEST["pied_de_page_gauche_0"])))."\";", $CONFIG_DIR);

maj_configuration_file ("config_generale.inc.php", "maj_line", "\$PIED_DE_PAGE_GAUCHE_1 =", "\$PIED_DE_PAGE_GAUCHE_1 = \"".str_replace("¤", "€", (addslashes($_REQUEST["pied_de_page_gauche_1"])))."\";", $CONFIG_DIR);

maj_configuration_file ("config_generale.inc.php", "maj_line", "\$PIED_DE_PAGE_DROIT_0 =", "\$PIED_DE_PAGE_DROIT_0 = \"".str_replace("¤", "€", (addslashes($_REQUEST["pied_de_page_droit_0"])))."\";", $CONFIG_DIR);

maj_configuration_file ("config_generale.inc.php", "maj_line", "\$PIED_DE_PAGE_DROIT_1 =", "\$PIED_DE_PAGE_DROIT_1 = \"".str_replace("¤", "€", (addslashes($_REQUEST["pied_de_page_droit_1"])))."\";", $CONFIG_DIR);

//délai commandes en cours

maj_configuration_file ("config_generale.inc.php", "maj_line", "\$DELAI_COMMANDE_CLIENT_RECENTE =", "\$DELAI_COMMANDE_CLIENT_RECENTE = \"".$_REQUEST["delai_commande_client_recente"]."\";", $CONFIG_DIR);

maj_configuration_file ("config_generale.inc.php", "maj_line", "\$DELAI_COMMANDE_CLIENT_RETARD =", "\$DELAI_COMMANDE_CLIENT_RETARD = \"".$_REQUEST["delai_commande_client_retard"]."\";", $CONFIG_DIR);

maj_configuration_file ("config_generale.inc.php", "maj_line", "\$DELAI_COMMANDE_FOURNISSEUR_RECENTE =", "\$DELAI_COMMANDE_FOURNISSEUR_RECENTE = \"".$_REQUEST["delai_commande_fournisseur_recente"]."\";", $CONFIG_DIR);

maj_configuration_file ("config_generale.inc.php", "maj_line", "\$DELAI_COMMANDE_FOURNISSEUR_RETARD =", "\$DELAI_COMMANDE_FOURNISSEUR_RETARD = \"".$_REQUEST["delai_commande_fournisseur_retard"]."\";", $CONFIG_DIR);

maj_configuration_file ("config_generale.inc.php", "maj_line", "\$DELAI_DEVIS_CLIENT_RECENT =", "\$DELAI_DEVIS_CLIENT_RECENT = \"".$_REQUEST["delai_devis_client_recent"]."\";", $CONFIG_DIR);

maj_configuration_file ("config_generale.inc.php", "maj_line", "\$DELAI_DEVIS_CLIENT_RETARD =", "\$DELAI_DEVIS_CLIENT_RETARD = \"".$_REQUEST["delai_devis_client_perime"]."\";", $CONFIG_DIR);


// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_configuration_pdf_maj.inc.php");
?>