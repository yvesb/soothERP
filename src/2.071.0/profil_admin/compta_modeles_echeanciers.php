<?php
// *************************************************************************************************************
// journal des ventes
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


//$compta_e = new compta_exercices ();

//creation de l'instance d'export
//$compta_export = new compta_export ();

//$compta_e->check_exercice();
//chargement des exercices
//$liste_exercices	= $compta_e->charger_compta_exercices();

//_vardump($_REQUEST);

require_once ("../profil_client/_contact_client.class.php");
$liste_categ_clients = contact_client::charger_clients_categories ();
$reglements_modes = getReglements_modes();
$modeles = modele_echeancier::charger_modeles_echeances();

if (isset($_REQUEST["ref_contact"])) {
	$contact = new contact ($_REQUEST['ref_contact']);
	if (!$contact->getRef_contact()) {
		echo "La référence du contact est inconnue";		exit;

	}
}

//$liste_journaux = charger_liste_journaux_treso ();
// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_compta_modeles_echeanciers.inc.php");

?>