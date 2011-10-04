<?php
// *************************************************************************************************************
// FONCTION DE CALCUL DES TARIFS ET ARRONDIS
// *************************************************************************************************************

// Sélectionne la liste des grilles tarifaires
function get_tarifs_listes ($force = 0) {
	global $bdd;

	if (isset($_SESSION['tarifs_listes']) && !$force) { false; }

	$_SESSION['tarifs_listes'] = array();
	$query = "SELECT id_tarif, lib_tarif
						FROM tarifs_listes
						ORDER BY ordre";
	$resultat = $bdd->query ($query);
	while ($tmp = $resultat->fetchObject()) { $_SESSION['tarifs_listes'][] = $tmp; }
	return true;
}


// Retourne toutes les infos des grilles tarifaires
function get_full_tarifs_listes () {
	global $bdd;
	
	$tarifs_listes = array();
	$query = "SELECT id_tarif, lib_tarif, desc_tarif, marge_moyenne, ordre
						FROM tarifs_listes
						ORDER BY ordre";
	$resultat = $bdd->query ($query);
	while ($tmp = $resultat->fetchObject()) { $tarifs_listes[] = $tmp; }
	return $tarifs_listes;
}

// Retourne les grilles tarifaires avec les formules correspondant à l'art_categ
function get_tarifs_listes_formules ($art_categ = "") {
	global $bdd;
	
	if (isset($art_categ)) { false; }
	
	$tarifs_listes = array();
	$query = "SELECT tl.id_tarif, lib_tarif, marge_moyenne, acft.formule_tarif
						FROM tarifs_listes tl
							LEFT JOIN art_categs_formules_tarifs acft ON (tl.id_tarif = acft.id_tarif 
												AND acft.ref_art_categ = '".$art_categ."' ) 
						ORDER BY ordre ASC";
	$resultat = $bdd->query ($query);
	while ($tmp = $resultat->fetchObject()) { $tarifs_listes[] = $tmp; }
	return $tarifs_listes;
}

// Affiche un tarif au format désiré
function price_format ($prix) {
	global $TARIFS_NB_DECIMALES;
	global $PRICES_DECIMAL_SEPARATOR;
	global $PRICES_MILLIER_SEPARATOR;

	return number_format($prix, $TARIFS_NB_DECIMALES, $PRICES_DECIMAL_SEPARATOR, $PRICES_MILLIER_SEPARATOR);
}


function ht2ttc ($pu_ht, $tva) {
	global $CALCUL_TARIFS_NB_DECIMALS;

	$pu_ttc = round($pu_ht * (1+$tva/100), $CALCUL_TARIFS_NB_DECIMALS);

	return $pu_ttc;
}


function ttc2ht ($pu_ttc, $tva) {
	global $CALCUL_TARIFS_NB_DECIMALS;

	$pu_ht = round($pu_ttc / (1+$tva/100), $CALCUL_TARIFS_NB_DECIMALS);

	return $pu_ht;
}



// Cette fonction défini la liste des article devant etre mis à jour suite à une modification de liste de tarif ou de formule de tarif d'une catégorie d'article
function declare_articles_maj ($id_tarif, $action, $ref_art_categ = "") {
	global $bdd;

	// Sélection des articles à mettre à jour
	$articles = array();
	switch ($action) {
		case "MAJ_TARIF_LISTE":
			$query = "SELECT a.ref_article
								FROM articles a 
									LEFT JOIN articles_formules_tarifs aft ON 
														(a.ref_article = aft.ref_article && aft.id_tarif = '".$id_tarif."')
									LEFT JOIN art_categs_formules_tarifs acft ON 
														(a.ref_art_categ = acft.ref_art_categ && acft.id_tarif = '".$id_tarif."')
								WHERE ISNULL(aft.id_tarif) && ISNULL(acft.id_tarif)";
			$resultat = $bdd->query ($query);
		break;
		case "ADD_TARIF_LISTE":
			$query = "SELECT a.ref_article
								FROM articles a ";
			$resultat = $bdd->query ($query);
		break;
		case "MAJ_TARIF_CATEG":
			$query = "SELECT a.ref_article
								FROM articles a 
									LEFT JOIN articles_formules_tarifs aft ON 
														(a.ref_article = aft.ref_article && aft.id_tarif = '".$id_tarif."')
								WHERE ISNULL(aft.id_tarif) ";
			$resultat = $bdd->query ($query);
		break;
	}
	while ($tmp = $resultat->fetchObject()) { $articles[] = $tmp; }
	if (!count($articles)) { return false; }

	// Création de la requete pour insertion dans la liste des articles à mettre à jour
	$bdd->beginTransaction();
	while (count($articles)) {
		$stop_query = count($articles) - 25;
		if ($stop_query < 0) { $stop_query = 0; }

		$query_insert = "";
		for ($i=count($articles)-1; $i >= $stop_query; $i--) {
			if ($query_insert) { $query_insert .= ","; }
			$query_insert .= "('".$articles[$i]->ref_article."', '".$id_tarif."', NOW())";
			unset($articles[$i]);
		}

		$query = "REPLACE INTO articles_tarifs_maj (ref_article, id_tarif, date_demande)
							VALUES ".$query_insert;
		//$bdd->exec ($query);
	}
	$bdd->commit();

	$GLOBALS['_INFOS']['nb_articles_affected'] = count($articles);

	return true;
}


function flush_maj_articles ($nb_articles = 10000) {
	global $bdd;
	static $MAJ_ARTICLES = 1;

	if (!$MAJ_ARTICLES) { return false; }

	$query = "SELECT ref_article, id_tarif 
						FROM articles_tarifs_maj
						ORDER BY date_demande
						LIMIT 0, ".$nb_articles;
	$resultat = $bdd->query ($query);
	while ($tmp = $resultat->fetchObject()) { 
		$article = new article ($tmp->ref_article);
		$article->maj_tarif ($tmp->id_tarif, 1);
	}
	$query = "DELETE FROM articles_tarifs_maj
						ORDER BY date_demande
						LIMIT ".$nb_articles;
	$bdd->exec ($query);

	if ($resultat->rowCount() < $nb_articles) {
		$MAJ_ARTICLES = 0;
	}

	return true;
}


function flush_all_tarifs () {
	global $bdd;

	$query = "SELECT ref_article, id_tarif, indice_qte, formule_tarif
						FROM articles_formules_tarifs 
						WHERE 1";
	$resultat = $bdd->query ($query);
	while ($tmp = $resultat->fetchObject()) { 
		$article = new article ($tmp->ref_article);
		echo "<li>".$article->getRef_article()." : ".$tmp->id_tarif." / ".$tmp->indice_qte." / ".$tmp->formule_tarif."<br>";
		$article->create_tarif($tmp->id_tarif, $tmp->indice_qte, $tmp->formule_tarif);
	}
}
?>