<?php


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");
global $PDF_MODELES_DIR;

ini_set("memory_limit","40M");

//****************
// ??? NECESSAIRE A LA RECHERCHE DE CONTACT ?
$ANNUAIRE_CATEGORIES	=	get_categories();
// *************************************************
// Profils à afficher
$profils = array();
foreach ($_SESSION['profils'] as $profil) {
	if ($profil->getActif() == 0) { continue; }
	$profils[] = $profil;
}
unset ($profil);


// *************************************************
// Données pour le formulaire et la recherche

$nb_fiches = 0;
// FIN NECESSAIRE A LA RECHERCHE DE CONTACT ?
//*************************************************

	$GLOBALS['PDF_OPTIONS']['HideToolbar'] = 0;
	$GLOBALS['PDF_OPTIONS']['AutoPrint'] = 0;

	// Création du fichier
	$pdf = new PDF_etendu ();

	// Ajout du document au PDF
	$pdf->add_list_contact ();

	global $REF_CONTACT_ENTREPRISE;
	$contact_entreprise = new contact($REF_CONTACT_ENTREPRISE);
	$nom_entreprise = str_replace (CHR(13), " " ,str_replace (CHR(10), " " , $contact_entreprise->getNom()));

	$this->SetAuthor	($nom_entreprise);
	$pdf->SetCreator	("SoothERP (un fork de Lundi Matin Business®)");
	$pdf->SetDisplayMode ("real", "single");
	$pdf->Output();


?>