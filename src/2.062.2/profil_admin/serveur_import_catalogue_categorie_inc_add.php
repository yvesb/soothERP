<?php
// *************************************************************************************************************
// ACCUEIL DE L'UTILISATEUR ADMINISTRATEUR
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");
require ($DIR.$_SESSION['theme']->getDir_theme()."_theme.config.php" );


//liste des tvas du pays par defaut
$tvas = get_tvas ($DEFAUT_ID_PAYS);
	
	
	if (isset($_POST['carac_groupes'])) {
		$exist_carac_groupes = ($_POST['carac_groupes']);
		if (!is_array($exist_carac_groupes)) {$exist_carac_groupes	=	array();}
	} else {
		$exist_carac_groupes	=	array();
	}
	
	if (isset($_POST['carac'])) {
		$exist_caracs = ($_POST['carac']);
		if (!is_array($exist_caracs)) {$exist_caracs	=	array();}
	} else {
		$exist_caracs	=	array();
	}
	
// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_serveur_import_catalogue_categorie_inc_add.inc.php");

?>