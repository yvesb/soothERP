<?php
// *************************************************************************************************************
// CATALOGUE CLIENT PANIER PAIEMENT
// *************************************************************************************************************

require("_dir.inc.php");
require ("_profil.inc.php");
require ("_session.inc.php");



if (!$_SESSION['user']->getLogin())
{		header ("Location: _user_login.php?page_from=".$_SERVER['PHP_SELF']);}

//GESTION DU PANIER
$GLOBALS['_OPTIONS']['CREATE_DOC']['ref_contact'] = $_SESSION['user']->getRef_contact ();
gestion_panier();

if (count($_SESSION["panier_interface_".$_INTERFACE['ID_INTERFACE']]["contenu"]) == 0) 
{		header ("Location: catalogue_panier_view.php");}

//Récupération du panier
unset($GLOBALS['_OPTIONS']['CREATE_DOC']);
$GLOBALS['_OPTIONS']['CREATE_DOC']['ref_contact'] = $_SESSION['user']->getRef_contact();
$panier = open_client_panier ();

$panier_contenu = $panier->getContenu(); 

if (count($panier_contenu) == 0) // Si le panier est vide, on redirige vers catalogue_panier_view.php
{		header ("Location: catalogue_panier_view.php");}


if(!isset($_REQUEST['id_livraison_mode'])){
	echo "le mode de livraison n'est pas spécifié";
	exit;
}
$id_livraison_mode = $_REQUEST['id_livraison_mode'];

$panier->maj_id_livraison_mode($_REQUEST['id_livraison_mode']) ;

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


$reglements_dispos = array();
$reglements = explode(";", $REGLEMENTES_MODES_VALIDES);
$reglements_modes	 = getReglements_modes();
foreach ($reglements_modes as $reglement) {
	if (!in_array($reglement->id_reglement_mode, $reglements) ) { continue;}
	$reglements_dispos[] = $reglement;
}
// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_catalogue_panier_validation_step3.inc.php");

?>