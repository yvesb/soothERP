<?php
// *************************************************************************************************************
// ACCUEIL DE L'UTILISATEUR ADMINISTRATEUR
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ("_session.inc.php");

// Liste des profils autorisés
$profils_allowed = $_SESSION['user']->getProfils_allowed();

//@TODO profil_collab => interface_caisse ?
setcookie("uncahe_profil_collab", date("Y-m-d H:i:s"), time() + $COOKIE_LOGIN_LT , '/');
if (isset($_REQUEST["uncache"])) {
	header("Cache-Control: no-store, no-cache, must-revalidate");
}

$magasin_changed = Icaisse::MAGASIN_NOT_CHANGED;

if($_SESSION['magasin']->getMode_vente() != "VAC" || count(compte_caisse::charger_comptes_caisses($_SESSION['magasin']->getId_magasin(), true)) == 0){
	$magasin_changed = Icaisse::searchMagasinVACWithCaisseActive();
}

if(!Icaisse::IcaisseExistsInSESSION()){
	$tmp = compte_caisse::charger_comptes_caisses($_SESSION['magasin']->getId_magasin(), true);
	if(count($tmp) > 0){
		Icaisse::setSESSION_IdCompteCaisse($tmp[0]->id_compte_caisse);
	}
}

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_index.inc.php");

?>