<?php
// *************************************************************************************************************
// CATALOGUE CLIENT PANIER RESUME
// *************************************************************************************************************

require("_dir.inc.php");
require ("_profil.inc.php");
require ("_session.inc.php");



if (!$_SESSION['user']->getLogin())
{		header ("Location: _user_login.php?page_from=".$_SERVER['PHP_SELF']);}

//GESTION DU PANIER
$GLOBALS['_OPTIONS']['CREATE_DOC']['ref_contact'] = $_SESSION['user']->getRef_contact ();
gestion_panier();

$liste_contenu = $_SESSION["panier_interface_".$_INTERFACE['ID_INTERFACE']]["contenu"];

if (count($liste_contenu) == 0) // Si le panier est vide, on redirige vers catalogue_panier_view.php
{		header ("Location: catalogue_panier_view.php");}

$panier = open_client_panier ();

$panier->delete_all_line();

foreach($liste_contenu as $contenu) {
	$infos = array();
	$infos['type_of_line']	=	"article";
	$infos['sn']						= array();
	$infos['ref_article']		=	$contenu->article->getRef_article();
	$infos['qte']						=	$contenu->qte;
	$panier->add_line($infos);
}

//MODES DE LIVRAISON
$livraison_modes = charger_livraisons_modes();

foreach ($livraison_modes as $liv_mod) {
	$tmp_livraison_mode = new livraison_modes ($liv_mod->id_livraison_mode);
	$liv_mod->cout_liv = $tmp_livraison_mode->contenu_calcul_frais_livraison($panier);
	$liv_mod->nd = 0;
	if (isset($GLOBALS['_INFOS']['calcul_livraison_mode_ND']) || isset($GLOBALS['_INFOS']['calcul_livraison_mode_nozone']) || isset($GLOBALS['_INFOS']['calcul_livraison_mode_impzone'])) {
		$liv_mod->nd = 1;
		unset($GLOBALS['_INFOS']['calcul_livraison_mode_ND'], $GLOBALS['_INFOS']['calcul_livraison_mode_nozone'], $GLOBALS['_INFOS']['calcul_livraison_mode_impzone']);
	}
}
sort($livraison_modes);

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_catalogue_panier_validation_step2.inc.php");

?>