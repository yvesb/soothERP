<?php
// *************************************************************************************************************
// ACCUEIL DE L'UTILISATEUR ADMINISTRATEUR
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

$_REQUEST['recherche'] = 1;

// Moteur de recherche pour les documents 

// *************************************************
// Données pour le formulaire && la requete
$form['page_to_show'] = $search['page_to_show'] = 1;
if (isset($_REQUEST['page_to_show'])) {
	$form['page_to_show'] = $_REQUEST['page_to_show'];
	$search['page_to_show'] = $_REQUEST['page_to_show'];
}
$form['fiches_par_page'] = $search['fiches_par_page'] = $DOCUMENT_RECHERCHE_SHOWED_FICHES;
if (isset($_REQUEST['fiches_par_page'])) {
	$form['fiches_par_page'] = $_REQUEST['fiches_par_page'];
	$search['fiches_par_page'] = $_REQUEST['fiches_par_page'];
}
$form['orderby'] = $search['orderby'] = "date_doc";
if (isset($_REQUEST['orderby'])) {
	$form['orderby'] = $_REQUEST['orderby'];
	$search['orderby'] = $_REQUEST['orderby'];
}
$form['orderorder'] = $search['orderorder'] = "DESC";
if (isset($_REQUEST['orderorder'])) {
	$form['orderorder'] = $_REQUEST['orderorder'];
	$search['orderorder'] = $_REQUEST['orderorder'];
}
$nb_fiches = 0;

$form['ref_contact'] = $search['ref_contact'] = "";
if (isset($_REQUEST['ref_contact'])) {
	$form['ref_contact'] = $_REQUEST['ref_contact'];
	$search['ref_contact'] = $_REQUEST['ref_contact'];
}
$form['id_type_doc'] = $search['id_type_doc'] = 0;
if (isset($_REQUEST['id_type_doc'])) {
	$form['id_type_doc'] = $_REQUEST['id_type_doc'];
	$search['id_type_doc'] = $_REQUEST['id_type_doc'];
}

$form['id_etat_doc'] = $search['id_etat_doc'] = 0;
if (isset($_REQUEST['id_etat_doc'])) {
	$form['id_etat_doc'] = $_REQUEST['id_etat_doc'];
	$search['id_etat_doc'] = $_REQUEST['id_etat_doc'];
}


$form['ref_doc'] = $search['ref_doc'] = "";
if (isset($_REQUEST['ref_doc'])) {
	$form['ref_doc'] = trim($_REQUEST['ref_doc']);
	$search['ref_doc'] = trim($_REQUEST['ref_doc']);
}


// *************************************************
// Résultat de la recherche
$fiches = array();
if (isset($_REQUEST['recherche'])) {
	// Préparation de la requete
	$query_join 	= "";
	$query_join_count = "";
	$query_where 	= "1 ";
	$query_limit	= (($search['page_to_show']-1)*$search['fiches_par_page']).", ".$search['fiches_par_page'];
	
	
	// ref_contact
	if ($search['ref_contact']) {
		$query_where 	.= "&& d.ref_contact = '".$search['ref_contact']."'";
	}
	
	// recherche 'Tous'
	if ( $_SESSION['id_type_groupe'] != 0 )
	{
		$query_where 	.= "&& dt.id_type_groupe = ".$_SESSION['id_type_groupe'];
		$query_join_count 	.= " LEFT JOIN documents_types dt ON d.id_type_doc = dt.id_type_doc "; 
		$query_join 	.= " LEFT JOIN documents_types_groupes dtg ON dt.id_type_groupe = dtg.id_type_groupe";
	}
	
	// Type de document
	if ($search['id_type_doc']) {
		 $query_where 	.= "&& d.id_type_doc = '".$search['id_type_doc']."'";
	}
	
	// Etat du document
	if ($search['id_etat_doc']) { 
		$query_where 	.= "&& d.id_etat_doc IN (".$search['id_etat_doc']." )";
	}
	// ref_doc
	if ($search['ref_doc']) {
		$query_where 	.= "&& d.ref_doc = '".$search['ref_doc']."'";
	}

		if(isset($TAXE_IN_PU) && $TAXE_IN_PU ==0)
        {$query_where2 = "(ISNULL(dl.ref_doc_line_parent) || dl.lib_article IN(SELECT distinct lib_taxe FROM taxes))";}
        else
        {$query_where2 = "ISNULL(dl.ref_doc_line_parent)";}
	// Recherche
	$query = "SELECT d.ref_doc, d.id_type_doc, dt.lib_type_doc, dt.id_type_groupe, d.id_etat_doc, de.lib_etat_doc, ref_contact, nom_contact, 

										( SELECT SUM(qte * pu_ht * (1-remise/100) * (1+tva/100))
									 		FROM docs_lines dl
									 		WHERE d.ref_doc = dl.ref_doc && ".$query_where2." && visible = 1 ) as montant_ttc,
									 		
											d.date_creation_doc as date_doc

						FROM documents d 
							LEFT JOIN documents_types dt ON d.id_type_doc = dt.id_type_doc 
							LEFT JOIN documents_etats de ON d.id_etat_doc = de.id_etat_doc 
							LEFT JOIN docs_lines dl ON d.ref_doc = dl.ref_doc 
							".$query_join."

						WHERE ".$query_where."
						GROUP BY dl.ref_doc  
						ORDER BY ".$search['orderby']." ".$search['orderorder']."
						LIMIT ".$query_limit;
	$resultat = $bdd->query($query);

	// Liste des documents ne contenant pas de référence externe
	$list = array('DES','DES_SN','ECHEANCIERS','FAB','FAB_SN','INV','MOD','PAC','TIC','TRM');

	while ($fiche = $resultat->fetchObject()) {
		// Recherche référence externe
		if(!in_array(substr($fiche->ref_doc, 0, 3), $list)) {
			$query_ref_doc_externe 	= "SELECT ref_doc, ref_doc_externe FROM doc_".strtolower(substr($fiche->ref_doc, 0, 3))." WHERE ref_doc = '".$fiche->ref_doc."'";
			$result = $bdd->query($query_ref_doc_externe);
			$ref_doc_externe = $result->fetchObject();
			$fiche->ref_doc_externe = $ref_doc_externe->ref_doc_externe;
		}
		$fiches[] = $fiche;
	}
	//echo nl2br ($query);
	unset ($fiche, $resultat, $query);
	
	// Comptage des résultats
	$query = "SELECT COUNT(d.ref_doc) nb_fiches
						FROM documents d 
							".$query_join_count
							.$query_join."
						WHERE ".$query_where."
						GROUP BY d.ref_doc " ;
	
	$resultat = $bdd->query($query);
	while ($result = $resultat->fetchObject()) { $nb_fiches += $result->nb_fiches; }
	//echo "<br><hr>".nl2br ($query);
	unset ($result, $resultat, $query);
}



// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_documents_recherche_result.inc.php");
?>