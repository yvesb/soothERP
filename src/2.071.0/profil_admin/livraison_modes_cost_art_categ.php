<?php
// *************************************************************************************************************
// commissionnements des catégories d'articles
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

$livraison_mode = new livraison_modes($_REQUEST["id_livraison_mode"]);
$livraison_article = $livraison_mode->getArticle ();
$livraison_cost = $livraison_mode->charger_livraisons_modes_cost();


//chargement de la liste des art_categ et des informations de commissionnement
$fiches = array();
$fiches_tmp = array();
$query = "SELECT ac.ref_art_categ, lib_art_categ, modele, desc_art_categ, defaut_id_tva, duree_dispo, ref_art_categ_parent
									
					FROM art_categs ac
					ORDER BY lib_art_categ ASC 
					";
$resultat = $bdd->query($query);
while ($fiche = $resultat->fetchObject()) {

	$query_tmp = "SELECT ref_art_categ ,id_livraison_mode , base_calcul ,indice_min,formule
								FROM livraisons_tarifs_art_categ  
								WHERE ref_art_categ = '".$fiche->ref_art_categ."' && id_livraison_mode = '".$_REQUEST["id_livraison_mode"]."'
							";
	$resultat_tmp = $bdd->query($query_tmp);
	$fiche->livraisons_tarifs = array();
	while ($regle_tmp = $resultat_tmp->fetchObject()) {
		$fiche->livraisons_tarifs[] = $regle_tmp;
	} 
	unset ($resultat_tmp, $query_tmp, $regle_tmp);
	$fiches_tmp[] = $fiche; 
}
$fiches = order_by_parent ($fiches, $fiches_tmp, "ref_art_categ", "ref_art_categ_parent", "","");
// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_livraison_modes_cost_art_categ.inc.php");

?>