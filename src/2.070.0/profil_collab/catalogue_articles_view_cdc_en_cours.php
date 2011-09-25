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

/*
$query = "
SELECT res.date_creation_doc, res.qte_livree, res.qte,
			res.ref_doc, res.ref_contact, res.nom_contact, res.ref_adr_contact, res.adresse_contact,
			res.code_postal_contact, res.ville_contact, res.id_pays_contact, res.ref_adr_livraison, res.adresse_livraison,
			res.code_postal_livraison, res.ville_livraison, res.id_pays_livraison
FROM ((
			SELECT docA.date_creation_doc, IFNULL(dl_cdcA.qte_livree, 0) as qte_livree, IFNULL(dlA.qte, 0) as qte,
			docA.ref_doc, docA.ref_contact, docA.nom_contact, docA.ref_adr_contact, docA.adresse_contact,
			docA.code_postal_contact, docA.ville_contact, docA.id_pays_contact, cdcA.ref_adr_livraison, cdcA.adresse_livraison,
			cdcA.code_postal_livraison, cdcA.ville_livraison, cdcA.id_pays_livraison
			FROM 				docs_lines dlA 
			LEFT JOIN 	doc_lines_cdc dl_cdcA ON dl_cdcA.ref_doc_line = dlA.ref_doc_line
			LEFT JOIN 	documents docA ON dlA.ref_doc = docA.ref_doc
			LEFT JOIN 	doc_cdc cdcA ON cdcA.ref_doc = docA.ref_doc
			WHERE 	docA.id_etat_doc = 9 &&
							dlA.ref_article = '".$article->getRef_article()."' && 
							cdcA.id_stock = '".$_SESSION['magasin']->getId_stock()."' &&
							cdcA.id_magasin = '".$_SESSION['magasin']->getId_magasin()."'
		)UNION(
			SELECT docB.date_creation_doc, 0 as qte_livree, IFNULL(dlB.qte, 0) as qte,
			docB.ref_doc, docB.ref_contact, docB.nom_contact, docB.ref_adr_contact, docB.adresse_contact,
			docB.code_postal_contact, docB.ville_contact, docB.id_pays_contact, cdcB.ref_adr_livraison, cdcB.adresse_livraison,
			cdcB.code_postal_livraison, cdcB.ville_livraison, cdcB.id_pays_livraison 
			FROM 				docs_lines dlB
			LEFT JOIN 	documents docB ON dlB.ref_doc = docB.ref_doc
			LEFT JOIN 	doc_cdc cdcB ON cdcB.ref_doc = docB.ref_doc
			WHERE		docB.id_etat_doc	=9 &&
							dlB.ref_article		= '".$article->getRef_article()."' && 
							cdcB.id_stock			= '".$_SESSION['magasin']->getId_stock()."' &&
							cdcB.id_magasin		= '".$_SESSION['magasin']->getId_magasin()."' &&
							dlB.ref_doc_line NOT IN ( SELECT dlcdc.ref_doc_line FROM doc_lines_cdc dlcdc )
		)) res
ORDER BY res.ref_contact";
*/

// bac 2.054.0 simplification de la requête et inclusion de la date de livraison
$query =   "SELECT dl.ref_doc, dl.qte as qte, ifnull(dlc.qte_livree,0) as qte_livree, d.nom_contact as ref_contact, d.nom_contact, d.date_creation_doc, dc.date_livraison
			FROM docs_lines dl
			    LEFT JOIN doc_lines_cdc dlc ON dlc.ref_doc_line = dl.ref_doc_line
			    LEFT JOIN documents d ON dl.ref_doc = d.ref_doc
			    LEFT JOIN doc_cdc dc ON dc.ref_doc = dl.ref_doc
			WHERE d.id_type_doc = 2 && d.id_etat_doc = 9
			and dl.ref_article = '".$article->getRef_article()."'";
//echo $query;
//echo "<br/><hr/><br/>".nl2br($query)."<br/><hr/><br/>";
$resultat = $bdd->query($query);
while ($fiche = $resultat->fetchObject()) {
	$fiches[] = $fiche; 
}
unset ($fiche, $resultat, $query);


// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_catalogue_articles_view_cdc_en_cours.inc.php");

?>