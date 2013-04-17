<?php
// *************************************************************************************************************
// [COLLABORRATEUR] RECHERCHE D'UN ARTICLE CATALOGUE
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


// *************************************************************************************************************
// TRAITEMENTS
// *************************************************************************************************************

$fournisseur = null;
if (isset($_REQUEST['ref_fournisseur'])){
	$fournisseur = new contact($_REQUEST['ref_fournisseur']);
	if($fournisseur->getRef_contact() == "")
	{		$fournisseur = null;}
}


//liste des fournisseurs
$fournisseurs_liste = array();
//$fournisseurs_liste = get_fournisseurs();


//infos pour mini moteur de recherche contact
$profils_mini = array();
foreach ($_SESSION['profils'] as $profil) {
	if ($profil->getActif() != 1) { continue; }
	$profils_mini[] = $profil;
}
unset ($profil);
foreach ($_SESSION['profils'] as $profil) {
	if ($profil->getActif() != 2 ) { continue; }
	$profils_mini[] = $profil;
}
unset ($profil);


// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_catalogue_articles_proposes_fournisseur.inc.php");

?>