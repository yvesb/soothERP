<?php
// *************************************************************************************************************
// ARCHIVAGE D'ARTICLE PERIMES
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");




// *************************************************
// Résultat de la recherche
$fiches = array();


	// Recherche
	$query = "SELECT a.ref_article, SUM(sa.qte) qte_stock, a.ref_oem, a.ref_interne, a.lib_article, a.desc_courte,
									 a.ref_constructeur, ann.nom nom_constructeur, a.dispo,
									 ac.lib_art_categ

						FROM articles a
							LEFT JOIN tvas t ON t.id_tva = a.id_tva
							LEFT JOIN annuaire ann ON a.ref_constructeur = ann.ref_contact 
							LEFT JOIN art_categs ac ON a.ref_art_categ = ac.ref_art_categ 
							LEFT JOIN stocks_articles sa ON a.ref_article = sa.ref_article
						WHERE a.dispo = 1 && a.date_fin_dispo < '".date("Y:m:d h:i:s", time())."' && a.variante != 2
						GROUP BY a.ref_article 
						ORDER BY ref_article";
						
	$resultat = $bdd->query($query);
	while ($fiche = $resultat->fetchObject()) {
		if ($fiche->qte_stock <= 0) {
		$article = new article ($fiche->ref_article);
		$article->stop_article ();
		$fiches[] = $fiche; 
		}
	}
	unset ($fiche, $resultat, $query);




// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_stocks_archiver_perime.inc.php");

?>