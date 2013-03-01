<?php
// *************************************************************************************************************
// cout de livraison des catégories d'articles
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

$livraison_mode = new livraison_modes($_REQUEST["id_livraison_mode"]);
$livraison_article = $livraison_mode->getArticle ();
$livraison_cost = $livraison_mode->charger_livraisons_modes_cost();


//chargement de la liste des article et des informations de livraison
$query = "SELECT a.ref_article, a.ref_oem, a.ref_interne, a.lib_article, a.desc_courte,
									 a.ref_constructeur, ann.nom nom_constructeur, a.dispo, a.lot,
									 ac.lib_art_categ, ac.modele, t.tva, ia.lib_file

						FROM articles a
							LEFT JOIN tvas t ON t.id_tva = a.id_tva
							LEFT JOIN annuaire ann ON a.ref_constructeur = ann.ref_contact 
							LEFT JOIN art_categs ac ON a.ref_art_categ = ac.ref_art_categ
							LEFT JOIN articles_images ai ON ai.ref_article = a.ref_article && ai.ordre = 1
							LEFT JOIN images_articles ia ON ia.id_image= ai.id_image
					WHERE a.ref_article = '".$_REQUEST["ref_article"]."' 
					ORDER BY lib_article ASC 
					";
$resultat = $bdd->query($query);
if ($fiche = $resultat->fetchObject()) {

	$query_tmp = "SELECT ref_article ,id_livraison_mode , base_calcul ,indice_min,formule
								FROM livraisons_tarifs_articles  
								WHERE ref_article = '".$fiche->ref_article."' && id_livraison_mode = '".$_REQUEST["id_livraison_mode"]."'
							";
	$resultat_tmp = $bdd->query($query_tmp);
	$fiche->livraisons_tarifs = array();
	while ($regle_tmp = $resultat_tmp->fetchObject()) {
		$fiche->livraisons_tarifs[] = $regle_tmp;
	} 
}

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_livraison_modes_cost_article_det.inc.php");

?>