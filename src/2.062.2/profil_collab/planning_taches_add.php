<?php
// *************************************************************************************************************
// AJOUT D'UNE TACHE
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

$collabs = array();
$collabs_fonctions = array();
	
foreach ($_REQUEST as $variable => $valeur) {
	if (substr_count($variable, "ref_contact_collab_")) {
		$collabs[] = $valeur;
	}
}
//fonctions de collaborateurs
$liste_fonctions_collab = charger_fonctions ($COLLAB_ID_PROFIL);
//on parcoure les fonctions pour retrouver les categories de collaborateurs cochées
foreach ($liste_fonctions_collab as $liste_fonction_collab) {
	if (isset($_REQUEST['id_fonction_'.$liste_fonction_collab->id_fonction])) {
	$collabs_fonctions[] = $liste_fonction_collab->id_fonction;
	}
}
		
//insertion de la tache
$tache = new tache ();
$tache->create_tache($_REQUEST["lib_tache"], $_REQUEST["text_tache"], $_REQUEST["importance"], $_REQUEST["urgence"], date_Fr_to_Us($_REQUEST["date_echeance"]), $collabs, $collabs_fonctions);
	
	
// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_planning_taches_add.inc.php");

?>