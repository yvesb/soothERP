<?php
// *************************************************************************************************************
// IMPORT FICHIER tarifs_fournisseur CSV ETAPE 2 (après correspondance des colonnes et des valeurs du fichier)
// *************************************************************************************************************

require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

$import_tarifs_fournisseur = new import_tarifs_fournisseur_csv(); 

$donnee = new import_tarifs_fournisseur_csv_donnee();
$lignes = $donnee->readAll();
if (!count($lignes)) {
	// Import terminé ou aucun enregistrement à traiter
	$import_tarifs_fournisseur->maj_etape(3);
	header ("Location: ".$DIR."profil_".$_SESSION['profils'][$ID_PROFIL]->getCode_profil()."/import_tarifs_fournisseur_csv_step3.php");
	exit();
}
		
// On récupère les données devant être importées (les colonnes qui ont été sélectionnées par l'utilisateur)
$array_retour = $import_tarifs_fournisseur->recupererDonneesAImporter();

$count_prix_vide = 0;
$count_corres_non_trouvee = 0;
foreach ($array_retour as $k=>$ret) {
	if(!trim($ret["pa_ht"])){
		$count_prix_vide++;
	}else{
		if(!trim($ret["ref_article_existant"])){
			$count_corres_non_trouvee++;
		}
	}
}

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************
include ($DIR.$_SESSION['theme']->getDir_theme()."/page_import_tarifs_fournisseur_csv_step2.inc.php");
?>