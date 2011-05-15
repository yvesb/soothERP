<?php
// *************************************************************************************************************
// CONFIGURATION DES DONNÉES catalogue
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

//mise à jour des données transmises

if (isset($_REQUEST["gestion_stock"]) && $_REQUEST["gestion_stock"] == "1") {
	maj_configuration_file ("config_generale.inc.php", "maj_line", "\$GESTION_STOCK				=", "\$GESTION_STOCK				= 1;								// Gestion des stocks", $CONFIG_DIR);
} else {
	maj_configuration_file ("config_generale.inc.php", "maj_line", "\$GESTION_STOCK				=", "\$GESTION_STOCK				= 0;								// Gestion des stocks", $CONFIG_DIR);
}

if (isset($_REQUEST["gestion_sn"]) && $_REQUEST["gestion_sn"] == "1") {
	maj_configuration_file ("config_generale.inc.php", "maj_line", "\$GESTION_SN 					=", "\$GESTION_SN 					= 1; 								// Gestion des numéros de série", $CONFIG_DIR);
} else {
	maj_configuration_file ("config_generale.inc.php", "maj_line", "\$GESTION_SN 					=", "\$GESTION_SN 					= 0; 								// Gestion des numéros de série", $CONFIG_DIR);
}


if (isset($_REQUEST["article_abo_time"]) && $_REQUEST["article_abo_time"] == "1") {
	maj_configuration_file ("config_generale.inc.php", "maj_line", "\$ARTICLE_ABO_TIME	=", "\$ARTICLE_ABO_TIME	= 1;								// Les articles services par abonnement utilisent l'heure pour la gestion de l'abonnement", $CONFIG_DIR);
} else {
	maj_configuration_file ("config_generale.inc.php", "maj_line", "\$ARTICLE_ABO_TIME	=", "\$ARTICLE_ABO_TIME	= 0;								// Les articles services par abonnement utilisent l'heure pour la gestion de l'abonnement", $CONFIG_DIR);
}

if (isset($_REQUEST["article_qte_nb_dec"]) && is_numeric($_REQUEST["article_qte_nb_dec"])) {
	maj_configuration_file ("config_generale.inc.php", "maj_line", "\$ARTICLE_QTE_NB_DEC =", "\$ARTICLE_QTE_NB_DEC = ".$_REQUEST["article_qte_nb_dec"].";									// Nombre de décimale pour la quantité d'un article", $CONFIG_DIR);
}

if (isset($_REQUEST["gestion_constructeur"]) && $_REQUEST["gestion_constructeur"] == "1") {
	maj_configuration_file ("config_generale.inc.php", "maj_line", "\$GESTION_CONSTRUCTEUR	=", "\$GESTION_CONSTRUCTEUR	= 1;								// Gestion de la référence du constructeur et de la référence OEM", $CONFIG_DIR);
} else {
	maj_configuration_file ("config_generale.inc.php", "maj_line", "\$GESTION_CONSTRUCTEUR	=", "\$GESTION_CONSTRUCTEUR	= 0;								// Gestion de la référence du constructeur et de la référence OEM", $CONFIG_DIR);
}

if (isset($_REQUEST["gestion_ref_interne"]) && $_REQUEST["gestion_ref_interne"] == "1") {
	maj_configuration_file ("config_generale.inc.php", "maj_line", "\$GESTION_REF_INTERNE	=", "\$GESTION_REF_INTERNE	= 1;								// Gestion de la référence interne", $CONFIG_DIR);
} else {
	maj_configuration_file ("config_generale.inc.php", "maj_line", "\$GESTION_REF_INTERNE	=", "\$GESTION_REF_INTERNE	= 0;								// Gestion de la référence interne", $CONFIG_DIR);
}



if (isset($_REQUEST["defaut_garantie"]) && is_numeric($_REQUEST["defaut_garantie"])) {
	maj_configuration_file ("config_generale.inc.php", "maj_line", "\$DEFAUT_GARANTIE			=", "\$DEFAUT_GARANTIE			= ".$_REQUEST["defaut_garantie"].";								// Durée de la garantie par défaut", $CONFIG_DIR);
}

if (isset($_REQUEST["defaut_article_lt"]) && is_numeric($_REQUEST["defaut_article_lt"])) {
	maj_configuration_file ("config_generale.inc.php", "maj_line", "\$DEFAUT_ARTICLE_LT 		=", "\$DEFAUT_ARTICLE_LT 		= ".$_REQUEST["defaut_article_lt"]."*24*3600;		// Durée de vie d'un article, par défaut", $CONFIG_DIR);
}


if (isset($_REQUEST["defaut_id_valo"])) {
	maj_configuration_file ("config_generale.inc.php", "maj_line", "\$DEFAUT_ID_VALO =", "\$DEFAUT_ID_VALO = \"".$_REQUEST["defaut_id_valo"]."\";				// Valorisation par defaut", $CONFIG_DIR);
}

if (isset($_REQUEST["defaut_indice_valorisation"]) && is_numeric($_REQUEST["defaut_indice_valorisation"])) {
	maj_configuration_file ("config_generale.inc.php", "maj_line", "\$DEFAUT_INDICE_VALORISATION =", "\$DEFAUT_INDICE_VALORISATION = ".$_REQUEST["defaut_indice_valorisation"].";					// Indice de valorisation par defaut", $CONFIG_DIR);
}


if (isset($_REQUEST["defaut_gestion_sn"])) {
	maj_configuration_file ("config_generale.inc.php", "maj_line", "\$DEFAUT_GESTION_SN 		=", "\$DEFAUT_GESTION_SN 		= ".$_REQUEST["defaut_gestion_sn"].";", $CONFIG_DIR);
}

if (isset($_REQUEST["defaut_lot"]) && is_numeric($_REQUEST["defaut_lot"])) {
	maj_configuration_file ("config_generale.inc.php", "maj_line", "\$DEFAUT_LOT				 		=", "\$DEFAUT_LOT				 		= ".$_REQUEST["defaut_lot"].";", $CONFIG_DIR);
}

if (isset($_REQUEST["defaut_id_tva"])) {
	maj_configuration_file ("config_generale.inc.php", "maj_line", "\$DEFAUT_ID_TVA				=", "\$DEFAUT_ID_TVA				= ".$_REQUEST["defaut_id_tva"].";								// Taux de TVA par défaut pour les catégories d'articles", $CONFIG_DIR);
}

if (isset($_REQUEST["delai_article_is_new"]) && is_numeric($_REQUEST["delai_article_is_new"])) {
	maj_configuration_file ("config_generale.inc.php", "maj_line", "\$DELAI_ARTICLE_IS_NEW	=", "\$DELAI_ARTICLE_IS_NEW	= ".($_REQUEST["delai_article_is_new"]*24*3600).";					// Délai pendant lequel un article est considéré comme nouveau. (30j)", $CONFIG_DIR);
}

if (isset($_REQUEST["article_image_miniature_ratio"]) && is_numeric($_REQUEST["article_image_miniature_ratio"])) {
	maj_configuration_file ("config_generale.inc.php", "maj_line", "\$ARTICLE_IMAGE_MINIATURE_RATIO =", "\$ARTICLE_IMAGE_MINIATURE_RATIO = ".$_REQUEST["article_image_miniature_ratio"]."; //ratio de réduction des images d'articles pour la miniature", $CONFIG_DIR);
}

if (isset($_REQUEST["article_variante_nom"]) && is_numeric($_REQUEST["article_variante_nom"])) {
	maj_configuration_file ("config_generale.inc.php", "maj_line", "\$ARTICLE_VARIANTE_NOM	=",  "\$ARTICLE_VARIANTE_NOM	= ".$_REQUEST["article_variante_nom"].";								// Nom des Variantes d'un article (1:val val dans lib; 2 : carac et val dans lib; 3: carac et val dans desc).", $CONFIG_DIR);
}
// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_configuration_catalogue_maj.inc.php");
?>