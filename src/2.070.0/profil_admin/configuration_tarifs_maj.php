<?php
// *************************************************************************************************************
// CONFIGURATION DES DONN�ES tarifs
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");




//mise � jour des donn�es transmises

if (isset($_REQUEST["CALCUL_VAA"])) {
	maj_configuration_file ("config_generale.inc.php", "maj_line", "\$CALCUL_VAA =", "\$CALCUL_VAA = \"".$_REQUEST["CALCUL_VAA"]."\"; //PA utilis� pour calcul de Valeur d'Achat Actuelle", $CONFIG_DIR);
}


if (isset($_REQUEST["DUREE_VALIDITE_PAF_an"])) {
	$duree_val_an				=	$_REQUEST['DUREE_VALIDITE_PAF_an'];
	$duree_val_mois			=	$_REQUEST['DUREE_VALIDITE_PAF_mois'];
	$duree_val_jour			=	$_REQUEST['DUREE_VALIDITE_PAF_jour'];
	$duree_val = (($duree_val_an*365)+($duree_val_mois*30)+($duree_val_jour));
	
	maj_configuration_file ("config_generale.inc.php", "maj_line", "\$DUREE_VALIDITE_PAF =", "\$DUREE_VALIDITE_PAF = ".$duree_val."; //dur�e validit� PA fournisseur", $CONFIG_DIR);
}

if (isset($_REQUEST["CALCUL_VAS"])) {
	maj_configuration_file ("config_generale.inc.php", "maj_line", "\$CALCUL_VAS =", "\$CALCUL_VAS = \"".$_REQUEST["CALCUL_VAS"]."\"; //PA utilis� pour calcul de Valeur d'Achat Stock�e", $CONFIG_DIR);
}

if (isset($_REQUEST["MAJ_PV"])) {
	maj_configuration_file ("config_generale.inc.php", "maj_line", "\$MAJ_PV =", "\$MAJ_PV = \"".$_REQUEST["MAJ_PV"]."\"; //maj du prix de vente", $CONFIG_DIR);
}

if (isset($_REQUEST["taxe_in_pu"])&& $_REQUEST["taxe_in_pu"] == "1") {

	maj_configuration_file ("config_generale.inc.php", "maj_line", "\$TAXE_IN_PU =", "\$TAXE_IN_PU = 1;								// utilisation des cotations client", $CONFIG_DIR);
} else {

	maj_configuration_file ("config_generale.inc.php", "maj_line", "\$TAXE_IN_PU =", "\$TAXE_IN_PU = 0;								// utilisation des cotations client", $CONFIG_DIR);
}

if (isset($_REQUEST["devise"]) && isset($TYPES_DEVISES[$_REQUEST["devise"]])) {
	maj_configuration_file ("config_generale.inc.php", "maj_line", "\$MONNAIE	=", "\$MONNAIE	= array(\"".$TYPES_DEVISES[$_REQUEST["devise"]][0]."\", \"".$TYPES_DEVISES[$_REQUEST["devise"]][1]."\", \"".$TYPES_DEVISES[$_REQUEST["devise"]][2]."\", \"".$TYPES_DEVISES[$_REQUEST["devise"]][3]."\", \"".$TYPES_DEVISES[$_REQUEST["devise"]][4]."\", array(".implode(",", $TYPES_DEVISES[$_REQUEST["devise"]][5])."));		// Symbol, Symbol XHTML, Abreviation, complet, complet au pluriel.", $CONFIG_DIR);
}

if (isset($_REQUEST["use_formules"]) && $_REQUEST["use_formules"] == "1") {
	maj_configuration_file ("config_generale.inc.php", "maj_line", "\$USE_FORMULES					=", "\$USE_FORMULES					= 1;								// utilisation du g�n�rateur de formule (sinon, tarifs d�finis arbitrairements)", $CONFIG_DIR);
} else {
	maj_configuration_file ("config_generale.inc.php", "maj_line", "\$USE_FORMULES					=", "\$USE_FORMULES					= 0;								// utilisation du g�n�rateur de formule (sinon, tarifs d�finis arbitrairements)", $CONFIG_DIR);
}

if (isset($_REQUEST["use_cotations"]) && $_REQUEST["use_cotations"] == "1") {
	maj_configuration_file ("config_generale.inc.php", "maj_line", "\$USE_COTATIONS				=", "\$USE_COTATIONS				= 1;								// utilisation des cotations client", $CONFIG_DIR);
} else {
	maj_configuration_file ("config_generale.inc.php", "maj_line", "\$USE_COTATIONS				=", "\$USE_COTATIONS				= 0;								// utilisation des cotations client", $CONFIG_DIR);
}

if (isset($_REQUEST["defaut_arrondi"])) {
	maj_configuration_file ("config_generale.inc.php", "maj_line", "\$DEFAUT_ARRONDI				=", "\$DEFAUT_ARRONDI				= \"".$_REQUEST["defaut_arrondi"]."\"; 						// Par d�faut, l'arrondi est PRO, SUP, ou INF", $CONFIG_DIR);
}

if (isset($_REQUEST["defaut_arrondi_pas"]) && is_numeric($_REQUEST["defaut_arrondi_pas"])) {
	maj_configuration_file ("config_generale.inc.php", "maj_line", "\$DEFAUT_ARRONDI_PAS		=", "\$DEFAUT_ARRONDI_PAS		= ".$_REQUEST["defaut_arrondi_pas"].";							// Nombre de d�cimales par d�faut pour l'arrondi d'un article", $CONFIG_DIR);
}

if (isset($_REQUEST["tarifs_nb_decimales"]) && is_numeric($_REQUEST["tarifs_nb_decimales"])) {
	maj_configuration_file ("config_generale.inc.php", "maj_line", "\$TARIFS_NB_DECIMALES =", "\$TARIFS_NB_DECIMALES = ".$_REQUEST["tarifs_nb_decimales"].";									// Nombre de d�cimales affich�es pour les tarifs", $CONFIG_DIR);
}

if (isset($_REQUEST["defaut_app_tarifs_client"])) {
	maj_configuration_file ("config_generale.inc.php", "maj_line", "\$DEFAUT_APP_TARIFS_CLIENT 			=", "\$DEFAUT_APP_TARIFS_CLIENT 			= \"".$_REQUEST["defaut_app_tarifs_client"]."\";	// Affichage des tarifs HT ou TTC par d�faut pour les clients", $CONFIG_DIR);
}

if (isset($_REQUEST["defaut_app_tarifs_fournisseur"])) {
	maj_configuration_file ("config_generale.inc.php", "maj_line", "\$DEFAUT_APP_TARIFS_FOURNISSEUR	=", "\$DEFAUT_APP_TARIFS_FOURNISSEUR	= \"".$_REQUEST["defaut_app_tarifs_fournisseur"]."\";		// Affichage des tarifs HT ou TTC par d�faut pour les fournisseurs", $CONFIG_DIR);
}



// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_configuration_tarifs_maj.inc.php");
?>