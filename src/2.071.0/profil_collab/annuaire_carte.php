<?php
// *************************************************************************************************************
// [ADMINISTRATEUR] AFFICHAGE D'UNE FICHE D'ADRESSE
// *************************************************************************************************************



require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");
require ($DIR.$_SESSION['theme']->getDir_theme()."_theme.config.php");


// *************************************************************************************************************
// TRAITEMENTS
// *************************************************************************************************************


// Controle de l'adresse du contact
if (!isset($_REQUEST['ref_adresse'])) {
	echo "La référence de l'adresse du contact n'est pas précise";
	exit;
}

$adresse = new adresse ($_REQUEST['ref_adresse']);
if (!$adresse->getRef_adresse()) {
	echo "La référence de l'adresse du contact est inconnue";
	exit;
}

// Adresse complète du contact (adresse, code postal, ville)
$adresse_complete = str_replace("\n", " ", $adresse->getText_adresse())." ".$adresse->getCode_postal()." ".$adresse->getVille();
$adresse_complete = preg_replace('/\s\s+/', '+', $adresse_complete);

// Lien vers google Map
$linkGoogleMap = 'http://maps.google.com/maps?q='.$adresse_complete;

header('Location: '.$linkGoogleMap);
die;
