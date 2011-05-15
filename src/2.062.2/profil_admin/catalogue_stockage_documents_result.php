<?php
// *************************************************************************************************************
// AFFICHAGE DES DOCUMENTS NON CLOT D'UN STOCK
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


// Moteur de recherche pour les documents 

// *************************************************
// Données pour le formulaire && la requete
$id_stock = 1;
if (isset($_REQUEST['id_stock'])) {
	$id_stock = $_REQUEST['id_stock'];
	// *************************************************
	// Résultat de la recherche
	$fiches = array();
	// Recherche
	$query = "SELECT d.ref_doc, d.id_type_doc, dt.lib_type_doc, d.id_etat_doc, de.lib_etat_doc, ref_contact, nom_contact , 

										( SELECT SUM(qte * pu_ht * (1-remise/100) * (1+tva/100))
									 		FROM docs_lines dl
									 		WHERE d.ref_doc = dl.ref_doc && ISNULL(dl.ref_doc_line_parent) && visible = 1 ) as montant_ttc,

									 		d.date_creation_doc as date_doc

	
						FROM documents d 
						LEFT JOIN doc_blc dblc ON d.ref_doc = dblc.ref_doc 
						LEFT JOIN doc_cdc dcdc ON d.ref_doc = dcdc.ref_doc 
						LEFT JOIN doc_def ddef ON d.ref_doc = ddef.ref_doc 
						LEFT JOIN doc_blf dblf ON d.ref_doc = dblf.ref_doc 
						LEFT JOIN doc_cdf dcdf ON d.ref_doc = dcdf.ref_doc 
						LEFT JOIN doc_trm dtrm ON d.ref_doc = dtrm.ref_doc 
						LEFT JOIN doc_inv dinv ON d.ref_doc = dinv.ref_doc 
						LEFT JOIN doc_des ddes ON d.ref_doc = ddes.ref_doc 
						LEFT JOIN doc_fab dfab ON d.ref_doc = dfab.ref_doc 
						LEFT JOIN documents_types dt ON d.id_type_doc = dt.id_type_doc 
						LEFT JOIN documents_etats de ON d.id_etat_doc = de.id_etat_doc 
	
						WHERE  (d.id_etat_doc IN (6,9) && dblc.id_stock = '".$id_stock."') 
								|| (d.id_etat_doc IN (11,13,14) && dcdc.id_stock = '".$id_stock."') 
								|| (d.id_etat_doc IN (20,22) && ddef.id_stock = '".$id_stock."') 
								|| (d.id_etat_doc IN (25,27) && dblf.id_stock = '".$id_stock."') 
								|| (d.id_etat_doc IN (29) && dcdf.id_stock = '".$id_stock."') 
								|| (d.id_etat_doc IN (36,38,39) && dtrm.id_stock_source = '".$id_stock."' && dtrm.id_stock_cible = '".$id_stock."') 
								|| (d.id_etat_doc IN (44) && dinv.id_stock = '".$id_stock."') 
								|| (d.id_etat_doc IN (47,49,50) && dfab.id_stock = '".$id_stock."') 
								|| (d.id_etat_doc IN (52,54,55) && ddes.id_stock = '".$id_stock."') ";
	$resultat = $bdd->query($query);
	while ($fiche = $resultat->fetchObject()) { $fiches[] = $fiche; }
	//echo nl2br ($query);
	unset ($fiche, $resultat, $query);
	
	// Comptage des résultats
	 $nb_fiches = count($fiches);



// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_catalogue_stockage_documents_result.inc.php");
}
?>