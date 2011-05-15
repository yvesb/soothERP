<?php
// *************************************************************************************************************
// Liste des inscriptions en attente
// *************************************************************************************************************
 
require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *

// Préparations des variables d'affichage
$ANNUAIRE_CATEGORIES	=	get_categories();

$civilites = get_civilites($ANNUAIRE_CATEGORIES[0]->id_categorie);

//liste des pays pour affichage dans select
$listepays = getPays_select_list();

//liste des langages
$langages = getLangues();

// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *

if(isset($_REQUEST['onglet']))
{			$onglet = $_REQUEST['onglet'];}
else{	$onglet = "inscriptions_confirmees";}

switch($onglet){
	case "inscriptions_confirmees" : default : {
		$inscriptions = Inscription_compte_user::getInscriptions_confirmees();
		break;}
	case "inscriptions_non_confirmees" : {
		$inscriptions = Inscription_compte_user::getInscriptions_non_confirmees();
		break;}
	case "modification_confirmees" : {
		$inscriptions = Modification_compte_user::getModifications_confirmees();
		break;}
	case "modification_non_confirmees" : {
		$inscriptions = Modification_compte_user::getModifications_non_confirmees();
		break;}
	default:	{
		echo "l'onglet n'est pas spécifié";
		exit; break;}
}

// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *

$listelibprofils = getAllLibProfils();
$listelibannucat = getAllLibAnnuCategs();

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_annuaire_valider_inscriptions.inc.php");
?>