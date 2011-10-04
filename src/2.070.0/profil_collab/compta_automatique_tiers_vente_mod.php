<?php
// *************************************************************************************************************
// Modification d'un compte de catégorie de client
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

// Fichier de configuration de ce profil
include_once ($CONFIG_DIR."profil_client.config.php");

// chargement de la class du profil
contact::load_profil_class($CLIENT_ID_PROFIL);


if (isset($_REQUEST["id_client_categ"])) {

	$infos	=	array();
	$infos['id_client_categ']				=	$_REQUEST["id_client_categ"];
	$infos['defaut_numero_compte']				=	$_REQUEST["retour_value"];
	//création de la catégorie
	contact_client::maj_defaut_numero_compte_categories ($infos);

}
?>