<?php
// *************************************************************************************************************
// CONFIG DES DONNEES du catalogue
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

require_once ($DIR."_contact_liaisons_types.class.php");

//on charge Toutes les liaisons existantes

// Renvoie les différents types de liaisons existants
function get_annu_liaisons_types_exist () {
	global $bdd;

	$liaisons = array();
	$query = "SELECT id_liaison_type, lib_liaison_type , ordre, actif, systeme
						FROM annuaire_liaisons_types
						ORDER BY ordre ASC";
	$resultat = $bdd->query ($query);
	while ($liaison = $resultat->fetchObject())
	{		$liaisons[] = $liaison; }
	
	return $liaisons;
}

$liaisons_liste	= get_annu_liaisons_types_exist();
// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_annuaire_gestion_liaisons_contact.inc.php");

?>