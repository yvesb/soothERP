<?php
// *************************************************************************************************************
// journal des ventes
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


$compta_e = new compta_exercices ();

//creation de l'instance d'export
$compta_export = new compta_export ();

$compta_e->check_exercice();
//chargement des exercices
$liste_exercices	= $compta_e->charger_compta_exercices();

if (isset($_REQUEST["ref_contact"])) {
	$contact = new contact ($_REQUEST['ref_contact']);
	if (!$contact->getRef_contact()) {
		echo "La référence du contact est inconnue";		exit;

	}
}

$liste_journaux = charger_liste_journaux_treso ();
// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

// *************************************************************************************************************
// Modification éffectuée par Yves Bourvon 
// Correctif bug exports journaux des ventes 'page_compta_journal_veac_export_2.inc.php' modifié en 'page_compta_journal_veac_export.inc.php'
// Possibilités d'export plus importantes avec cet appel de page php
// Attention le fichier de remplacement fait appel à des fonctions 'expérimentales' selon LMB (signalé dans la page d'export)
include ($DIR.$_SESSION['theme']->getDir_theme()."page_compta_journal_veac_export.inc.php");
// Fin de modification
?>