<?php
// *************************************************************************************************************
// CREATION ARTICLE GESTION DES VARIANTES
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


function combine_all($tab_values, $result = array()){
	global $resultat_var;
	
	$ref_carac = key($tab_values);
	
	$tab0 = array_shift($tab_values);
	if (count($tab0)) {
		// Boucle sur toutes les valeurs de ce tableau
		foreach ($tab0 as $value) {
				// On concaténe la nouvelle valeur avec les précédentes
				if (count($result)) {$res2 = $result;}
				if ($value) {	$res2[$ref_carac] = $value;} else {break;}
				if (count($tab_values) == 0) {
					// C'était le dernier tableau, on affiche le résultat
					$resultat_var[] = $res2;
				} else {
					// On continue avec le tableau suivant
					combine_all($tab_values, $res2);
				}
		}
	}
}

	// Controle
	if (!isset($_REQUEST['ref_art_categ'])) {
		echo "La référence de la catégorie n'est pas précisée";
		exit;
	}

	$art_categ = new art_categ ($_REQUEST['ref_art_categ']);
	
	// on récupére la liste des caractéristiques
	$caracs= $art_categ->getCarac();
	
	
	if (!$art_categ->getRef_art_categ()) {
		echo "La référence de la catégorie est inconnue";		exit;

	}

//

if (!isset($_REQUEST['ref_article'])) {
	echo "La référence de l'article n'est pas précisée";
	exit;
}

$article = new article ($_REQUEST['ref_article']);
if (!$article->getRef_article()) {
	echo "La référence de l'article est inconnue";
	exit;
}
$article->find_my_master();


$tab_stock = array();

foreach ($_REQUEST as $variable => $valeur) {
	if (substr ($variable, 0, 3) != "ACC") { continue; }
	foreach($article->getCaracs() as $carac){
		if($carac->ref_carac == $variable && $carac->variante){
			$tab_stock[$variable] = explode(";", utf8_decode($valeur));
		}
	}
}
$resultat_var = array();
combine_all($tab_stock);

//modification des données en cas d'affichage variante
if ($article->getVariante() == 1) {
	//on charge un Esclave variante, alors on récupére les esclaves possibles à partir du maitre
	$ref_article_master = $article->getVariante_master();
	$article_master = new article ($ref_article_master);
	$liste_slaves = $article_master->getVariante_slaves ();
}
if ($article->getVariante() == 2) {
	//c'est un maitre on charge les esclaves
	$liste_slaves = $article->getVariante_slaves ();
}

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************


include ($DIR.$_SESSION['theme']->getDir_theme()."page_catalogue_articles_edition_variantes.inc.php");

?>