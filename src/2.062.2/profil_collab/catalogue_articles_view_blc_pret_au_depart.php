<?php
// *************************************************************************************************************
// [COLLABORRATEUR] RECHERCHE D'UN ARTICLE CATALOGUE
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


// *************************************************************************************************************
// TRAITEMENTS
// *************************************************************************************************************


if (!isset($_REQUEST['ref_article'])){
	echo "la référence de l'article n'est pas spécifiée.";
	exit;
}
$article = new article($_REQUEST['ref_article']);

// *************************************************
// Données pour le formulaire && la requete
// *************************************************

$nb_fiches = 0;

// *************************************************
// Résultat de la recherche
// *************************************************

$fiches = array();

$query = "
			SELECT	docA.date_creation_doc, IFNULL(dlA.qte, 0) as qte_a_livrer,
							docA.ref_doc, docA.ref_contact, docA.nom_contact, docA.ref_adr_contact, docA.adresse_contact,
							docA.code_postal_contact, docA.ville_contact, docA.id_pays_contact
			FROM 				docs_lines dlA 
			LEFT JOIN 	documents docA ON dlA.ref_doc = docA.ref_doc
			LEFT JOIN 	doc_blc blcA ON blcA.ref_doc = docA.ref_doc
			WHERE 	docA.id_etat_doc = 13 &&
							dlA.ref_article = '".$article->getRef_article()."' && 
							blcA.id_stock = '".$_SESSION['magasin']->getId_stock()."' &&
							blcA.id_magasin = '".$_SESSION['magasin']->getId_magasin()."'
			ORDER BY docA.ref_contact";

//echo "<br/><hr/><br/>".nl2br($query)."<br/><hr/><br/>";
$resultat = $bdd->query($query);
while ($fiche = $resultat->fetchObject()) {
	$fiches[] = $fiche; 
}
unset ($fiche, $resultat, $query);


// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_catalogue_articles_view_blc_pret_au_depart.inc.php");

?>