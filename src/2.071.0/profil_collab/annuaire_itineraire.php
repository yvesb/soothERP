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

// Controle de l'adresse du magasin en cours (dpart)
if (!isset($_SESSION['magasin'])) {
	echo "La référence de l'adresse du magasin en cours n'est pas precisée";
	exit;
}

$adresse_depart = new adresse ($_SESSION['magasin']->getRef_adr_stock());
if (!$adresse_depart->getRef_adresse()) {
	echo "La référence de l'adresse du magasin en cours est inconnue";
	exit;
}

// Controle de l'adresse du contact (arrive)
if (!isset($_REQUEST['ref_adresse'])) {
	echo "La référence de l'adresse du contact n'est pas precisée";
	exit;
}

$adresse_arrivee = new adresse ($_REQUEST['ref_adresse']);
if (!$adresse_arrivee->getRef_adresse()) {
	echo "La référence de l'adresse du contact est inconnue";
	exit;
}

// Adresse complète du dpart de l'itinaire (adresse, code postal, ville)
$adresse_complete_depart = str_replace("\n", "+", $adresse_depart->getText_adresse())." ".$adresse_depart->getCode_postal()." ".$adresse_depart->getVille();
$adresse_complete_depart = preg_replace('/\s\s+/', '+', $adresse_complete_depart);

// Adresse complète du dpart de l'itinaire (adresse, code postal, ville)
$adresse_complete_arrivee = str_replace("\n", "+", $adresse_arrivee->getText_adresse())." ".$adresse_arrivee->getCode_postal()." ".$adresse_arrivee->getVille();
$adresse_complete_arrivee = preg_replace('/\s\s+/', '+', $adresse_complete_arrivee);

// Lien vers google Map
$linkGoogleMap = 'http://maps.google.com/maps?saddr='.$adresse_complete_depart.'&daddr='.$adresse_complete_arrivee;

header('Location: '.$linkGoogleMap);
die;
