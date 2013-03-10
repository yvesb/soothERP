<?php
// *************************************************************************************************************
// IMPORT FICHIER tarifs_fournisseur CSV
// *************************************************************************************************************
require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

$import_tarifs_fournisseur = new import_tarifs_fournisseur_csv();
$ref_fournisseur = $import_tarifs_fournisseur->getRef_fournisseur();
$colonne = new import_tarifs_fournisseur_csv_colonne();
$array_verif_doublon = array();
$index = 1;
// On récupère la liste des champs obligatoires (définis dans la config)
$champs_obligatoires = array();
foreach($import_tarifs_fournisseur_csv['liste_entete'] as $entete){
	foreach($entete['champs'] as $champ){
		if(isset($champ['obligatoire']) && $champ['obligatoire']){
			$champs_obligatoires[$champ['id']] = $champ['lib'];
		}
	}
}

// On parcourt les données transmises
foreach ($_POST as $k => $v){
	if (substr_count($k, "_equiv_")) {continue;}
	if (substr_count($k, "_pend_")) {continue;}
	if (!$v || (is_array($v) && !count($v))) {continue;} 
	if (is_array($v)) {
		foreach ($v as $uv) {
			if (!$uv) {continue;} 
			$array_verif_doublon[$uv][] = $k;
		}
	}else{
		$array_verif_doublon[$v][] = $k;
	}
	if(in_array($k, array_keys($champs_obligatoires))){
		unset($champs_obligatoires[$k]);
	}
}

// On parcourt les champs obligatoires qui n'ont pas été saisis
foreach($champs_obligatoires as $k => $v){
	$GLOBALS['_ALERTES']['obligatoire'][] = $v;
}

// On vérifie les doublons
if (isset($array_verif_doublon)) {
	foreach ($array_verif_doublon as $ck=>$alt) {
		if (count($alt)<2) {continue;}
		$GLOBALS['_ALERTES']['doublons'] = 1;
	}
}

// Si aucun problème, on effectue les traitements
if (!count($_ALERTES)) {
	foreach ($_POST as $k => $v){
		if (substr_count($k, "_equiv_")) {continue;}
		if (substr_count($k, "_pend_")) {continue;}
		if (!$v || (is_array($v) && !count($v))) {continue;} 
		if (is_array($v)) {
			foreach ($v as $uv) {
				if (!$uv) {continue;} 
				$colonne->update($uv,$k);
			}
		}else {
			$colonne->update($v,$k);
		}
	}
	$import_tarifs_fournisseur->maj_etape(2);
}

// On créé une colonne pour la référence article interne de l'article auquel il faudra lier les données importées
$colonne = new import_tarifs_fournisseur_csv_colonne();
$colonne->setLibelle("ref_article_existant");
$colonne->setChamp_equivalent("ref_article_existant");
// Ecriture en base
$colonne->write();

echo "Colonne ref_article_existant créée : id = " . $colonne->getId_colonne() . "<br />";

// On enregistre l'identifiant de la colonne "ref_article_existant" dans la table 'csv_import_tarifs_fournisseur'
$import_tarifs_fournisseur->setId_colonne_ref_article_existant($colonne->getId_colonne());

// On cherche les correspondances avec les articles déjà présents en base
// On supprime les enregistrements correspondant à la colonne "ref_article_existant" éventuellement présents
$donnee = new import_tarifs_fournisseur_csv_donnee();
$donnee->deleteDataForColumn($import_tarifs_fournisseur->getId_colonne_ref_article_existant());

// On récupère les données insérées en base
$array_retour = $import_tarifs_fournisseur->recupererDonneesAImporter();

// On cherche les correspondances avec les articles déjà présents en base
foreach($array_retour as $k => $ret) {
	$corres_trouvee = false;
	$ref_article_existant = "";
	// D'abord sur le champ ref_oem
	if(isset($ret["ref_oem"]) && $ret["ref_oem"] != ""){
		$query = "SELECT ref_article 
					FROM  articles 
					WHERE ref_oem = '" . $ret["ref_oem"] . "' 
					LIMIT 0,1";
		$resultat = $bdd->query($query);
		if($enr = $resultat->fetchObject()){
			$ref_article_existant = $enr->ref_article;
			$corres_trouvee = true;
		}
	}
	if(!$corres_trouvee && isset($ret["ref_interne"]) && $ret["ref_interne"] != ""){
		// Ensuite sur le champ ref_interne
		$query2 = "SELECT ref_article
					FROM articles 
					WHERE ref_interne = '" . $ret["ref_interne"] . "' 
					LIMIT 0,1;";
		$resultat2 = $bdd->query($query2);
		if($enr2 = $resultat2->fetchObject()){
			$ref_article_existant = $enr2->ref_article;
			$corres_trouvee = true;
		}
	}
	if(!$corres_trouvee && isset($ret["ref_article_externe"]) && $ret["ref_article_externe"] != ""){
		// Et enfin sur le champ ref_constructeur
		$query3 = "SELECT ref_article 
					FROM articles_ref_fournisseur 
					WHERE ref_article_externe = '" . $ret["ref_article_externe"] . "' AND ref_fournisseur = '" . $ref_fournisseur . "' 
					LIMIT 0,1;";
		$resultat3 = $bdd->query($query3);
		if($enr3 = $resultat3->fetchObject()){
			$ref_article_existant = $enr3->ref_article;
			$corres_trouvee = true;
		}
	}
	
	// On enregistre la donnée (article trouvé correspondant)
	$donnee = new import_tarifs_fournisseur_csv_donnee();
	$donnee->setId_ligne($k);
	$donnee->setId_colonne($import_tarifs_fournisseur->getId_colonne_ref_article_existant());
	$donnee->setValeur($ref_article_existant);
	$donnee->write();
	
	unset($enr, $resultat, $query);
}

// On supprime les colonnes (et les données associées) qui n'ont pas été choisies
$import_tarifs_fournisseur->supprimerDonneesNonImportees();

// *************************************************************************************************************
// REDIRECT
// *************************************************************************************************************
include ($DIR.$_SESSION['theme']->getDir_theme()."/page_import_tarifs_fournisseur_csv_step1_done.inc.php");
?>