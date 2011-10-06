<?php
// *************************************************************************************************************
// MOTEUR DE RECHERCHE DES DOCUMENTS
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

$form['id_magasin'] = $search['id_magasin'] = "";
if (isset($_REQUEST['id_magasin'])) {
	$form['id_magasin'] = $_REQUEST['id_magasin'];
	$search['id_magasin'] = $_REQUEST['id_magasin'];
}



$form['ref_contact'] = $search['ref_contact'] = "";
if (isset($_REQUEST['ref_contact'])) {
	$form['ref_contact'] = $_REQUEST['ref_contact'];
	$search['ref_contact'] = $_REQUEST['ref_contact'];
}
$form['ref_commercial'] = $search['ref_commercial'] = "";
if (isset($_REQUEST['ref_commercial'])) {
	$form['ref_commercial'] = $_REQUEST['ref_commercial'];
	$search['ref_commercial'] = $_REQUEST['ref_commercial'];
}
$form['id_type_doc'] = $search['id_type_doc'] = 0;
if (isset($_REQUEST['id_type_doc'])) {
	$form['id_type_doc'] = $_REQUEST['id_type_doc'];
	$search['id_type_doc'] = $_REQUEST['id_type_doc'];
}
$form['id_etat_doc'] = $search['id_etat_doc'] = 0;
if (isset($_REQUEST['id_etat_doc'])) {
	$form['id_etat_doc'] = urldecode($_REQUEST['id_etat_doc']);
	$search['id_etat_doc'] = urldecode($_REQUEST['id_etat_doc']);
}

// *************************************************
// Mode de recherche

$form['mode_recherche'] = "";
$search['mode_recherche'] = array();

if (isset($_REQUEST['mode_recherche'])) {
	$form['mode_recherche'] = urldecode($_REQUEST['mode_recherche']);
	$search['mode_recherche'] = explode(",",  urldecode($_REQUEST['mode_recherche']));
}

$form['string_recherche'] = $search['string_recherche'] = "";

foreach ($search['mode_recherche'] as $mode_recherche) {
	switch ($mode_recherche) {
		case "ref_article":
			$form['ref_article'] = $search['ref_article'] = "";
			if (isset($_REQUEST['ref_article'])) {
				$form['ref_article'] 		= trim(urldecode($_REQUEST['ref_article']));
				$search['ref_article'] 	= trim(urldecode($_REQUEST['ref_article']));
			}
			break;
		case "lib_article":
			$form['lib_article'] = $search['lib_article'] = "";
			if (isset($_REQUEST['lib_article'])) {
				$form['lib_article'] 		= trim(urldecode($_REQUEST['lib_article']));
				$search['lib_article'] 	= trim(urldecode($_REQUEST['lib_article']));
			}
			break;
		case "numero_serie":
			if (isset($_REQUEST['numero_serie'])) {
				$form['numero_serie'] 	= trim(urldecode($_REQUEST['numero_serie']));
				$search['numero_serie'] = trim(urldecode($_REQUEST['numero_serie']));
			}
			break;
		case "code_barre":
			if (isset($_REQUEST['code_barre'])) {
				$form['code_barre'] 	= trim(urldecode($_REQUEST['code_barre']));
				$search['code_barre'] = trim(urldecode($_REQUEST['code_barre']));
			}
			break;
		case "ref_doc":
			if (isset($_REQUEST['ref_doc'])) {
				$form['ref_doc'] 	= trim(urldecode($_REQUEST['ref_doc']));
				$search['ref_doc'] = trim(urldecode($_REQUEST['ref_doc']));
			}
			break;
		case "montant":
			if (isset($_REQUEST['montant'])) {
				$form['montant'] 	= str_replace(" ","",trim(urldecode($_REQUEST['montant'])));
				$search['montant'] = str_replace(" ","",trim(urldecode($_REQUEST['montant'])));
			}
			break;
		case "date":
			if (isset($_REQUEST['date_debut'])) {
				$form['date_debut'] 	= Date_Fr_to_Us($_REQUEST['date_debut']);
				$search['date_debut'] = Date_Fr_to_Us($_REQUEST['date_debut']);
			}
			if (isset($_REQUEST['date_fin'])) {
				$form['date_fin'] 	= Date_Fr_to_Us($_REQUEST['date_fin']);
				$search['date_fin'] = Date_Fr_to_Us($_REQUEST['date_fin']);
			}
			break;
		case "code_affaire":
			if (isset($_REQUEST['code_affaire'])) {
				$form['code_affaire'] 	= str_replace(" ","",trim(urldecode($_REQUEST['code_affaire'])));
				$search['code_affaire'] = str_replace(" ","",trim(urldecode($_REQUEST['code_affaire'])));
			}
			break;
	}
}


// *************************************************
// Résultat de la recherche
$fiches = array();
if (isset($_REQUEST['recherche'])) {
	// Préparation de la requete
	$query_join 	= "";
	$query_having 	= "";
	$query_where 	= "1 ";
	$query_limit	= (($search['page_to_show']-1)*$search['fiches_par_page']).", ".$search['fiches_par_page'];

		// ref_magasin
	if ($search['id_magasin']) {
		$query_where 	.= " && (blc.id_magasin = '".$search['id_magasin']."' || cdc.id_magasin = '".$search['id_magasin']."' || dev.id_magasin = '".$search['id_magasin']."' || fac.id_magasin = '".$search['id_magasin']."' || tic.id_magasin = '".$search['id_magasin']."') ";
		$query_join  .= " LEFT JOIN doc_blc blc ON blc.ref_doc = d.ref_doc ";
		$query_join  .= " LEFT JOIN doc_cdc cdc ON cdc.ref_doc = d.ref_doc ";
		$query_join  .= " LEFT JOIN doc_dev dev ON dev.ref_doc = d.ref_doc ";
		$query_join  .= " LEFT JOIN doc_fac fac ON fac.ref_doc = d.ref_doc ";
		$query_join  .= " LEFT JOIN doc_tic tic ON tic.ref_doc = d.ref_doc ";
		
	}
	
	
	// ref_contact
	if ($search['ref_contact']) {
		$query_where 	.= " && d.ref_contact = '".$search['ref_contact']."'";
	}
	// ref_commercial
	if ($search['ref_commercial']) {
		$query_where 	.= " && dvc.ref_contact = '".$search['ref_commercial']."'";
		$query_join  .= " LEFT JOIN doc_ventes_commerciaux dvc ON dvc.ref_doc = d.ref_doc ";
		
	}
	// recherche 'Tous'
	$isJoin_sup = false;
	if ( $_SESSION['id_type_groupe'] != 0 )
	{
		$query_where 	.= "&& dt.id_type_groupe = ".$_SESSION['id_type_groupe'];
		$query_join_sup 	= " LEFT JOIN documents_types dt ON d.id_type_doc = dt.id_type_doc "; 
		$isJoin_sup = true;
		$query_join 	.= " LEFT JOIN documents_types_groupes dtg ON dt.id_type_groupe = dtg.id_type_groupe";
	}
	// Type de document
	if ($search['id_type_doc']) { 
		$query_where 	.= " && d.id_type_doc = '".$search['id_type_doc']."'";
	}
	// Etat du document
	if ($search['id_etat_doc']) { 
		$query_where 	.= " && d.id_etat_doc IN (".$search['id_etat_doc']." )";
	}
	// Mode de recherche
	foreach ($search['mode_recherche'] as $mode_recherche) {
		switch ($mode_recherche) {
		case "ref_article":
			$query_where .= " && ( dl.ref_article = '".$search['ref_article']."' OR art.ref_interne = '".$search['ref_article']."' )";
			$query_join  	.= " LEFT JOIN articles art ON art.ref_article = dl.ref_article ";
			break;
		case "lib_article":
			if ($search['lib_article']) {
				$libs = explode (" ", $search['lib_article']);
				$query_where 	.= " && ( ";
				for ($i=0; $i<count($libs); $i++) {
					$lib = trim($libs[$i]);
					$query_where 	.= " dl.lib_article LIKE '%".addslashes($lib)."%' "; 
					if ( isset($libs[$i+1]) ) { $query_where 	.= " && "; }
				}
				$query_where 	.= " ) ";
			}
			break;
		case "numero_serie":
			$query_where .= " && dls.numero_serie = '".$search['numero_serie']."' ";
			$query_join  .= " LEFT JOIN docs_lines_sn dls ON dls.ref_doc_line = dl.ref_doc_line ";
			break;
		case "code_barre":
			$query_where .= " && acb.code_barre = '".$search['code_barre']."' ";
			$query_join  .= " LEFT JOIN articles_codes_barres acb ON acb.ref_article = dl.ref_article ";
			break;
		case "ref_doc":
			$query_where .= " && d.ref_doc = '".$search['ref_doc']."' ";
			break;
		case "montant":
			$query_having .= " 
	HAVING  ( ( SELECT SUM(ROUND(qte * pu_ht * (1-remise/100) * (1+tva/100),".$TARIFS_NB_DECIMALES.")) montant
												FROM docs_lines dl
												WHERE d.ref_doc = dl.ref_doc && ISNULL(dl.ref_doc_line_parent) && visible = 1 ) <= '".($search['montant']+"0.01")."' &&
						 ( SELECT SUM(ROUND(qte * pu_ht * (1-remise/100) * (1+tva/100),".$TARIFS_NB_DECIMALES.")) montant
										FROM docs_lines dl
										WHERE d.ref_doc = dl.ref_doc && ISNULL(dl.ref_doc_line_parent) && visible = 1 ) >= '".($search['montant']-"0.01")."' 				
					)";
			break;
		case "date":
			if (isset($search['date_debut']) && $search['date_debut'] != "--") {
				$query_where .=  " && d.date_creation_doc >= '".($search['date_debut'])." 00:00:00' "; 
			}
			if (isset($search['date_fin']) && $search['date_fin'] != "--") {
				$query_where .=  " && d.date_creation_doc < '".($search['date_fin'])." 23:59:59' "; 
			}
			break;
		case "code_affaire":
			if (isset($_REQUEST['code_affaire'])) {
				$query_where .= " && d.code_affaire = '".$search['code_affaire']."' ";
			}
			break;
		}
	}

	// Recherche
	$query = "SELECT d.ref_doc, d.id_type_doc, dt.lib_type_doc, dt.id_type_groupe, d.id_etat_doc, d.code_affaire, de.lib_etat_doc, 
									 d.ref_contact, d.nom_contact, dl.ref_article, dl.lib_article, dl.pu_ht, dl.tva, 

										( SELECT SUM(ROUND(qte * pu_ht * (1-remise/100) * (1+tva/100),".$TARIFS_NB_DECIMALES."))
									 		FROM docs_lines dl
									 		WHERE d.ref_doc = dl.ref_doc && ISNULL(dl.ref_doc_line_parent) && visible = 1 ) as montant_ttc,
									 d.date_creation_doc as date_doc

						FROM documents d 
							LEFT JOIN documents_types dt ON d.id_type_doc = dt.id_type_doc 
							LEFT JOIN documents_etats de ON d.id_etat_doc = de.id_etat_doc 
							LEFT JOIN docs_lines dl ON d.ref_doc = dl.ref_doc 
							".$query_join."

						WHERE ".$query_where."
						GROUP BY d.ref_doc 
						".$query_having."
						ORDER BY ".$search['orderby']." ".$search['orderorder']."
						LIMIT ".$query_limit;
				
	$resultat = $bdd->query($query);
	while ($fiche = $resultat->fetchObject()) { $fiches[] = $fiche; }
	//echo nl2br ($query);
	unset ($fiche, $resultat, $query);
	
	// Comptage des résultats
	if ($isJoin_sup) { $query_join = $query_join_sup.$query_join; }
	$query = "SELECT d.ref_doc
						FROM documents d 
							LEFT JOIN docs_lines dl ON d.ref_doc = dl.ref_doc 
							".$query_join."
						WHERE ".$query_where."
						GROUP BY d.ref_doc 
						".$query_having." " ;
	$resultat = $bdd->query($query);
	while ($result = $resultat->fetchObject()) { $nb_fiches ++; }
	//echo "<br><hr>".nl2br ($query);
	unset ($result, $resultat, $query);
}



// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_documents_recherche_result_content.inc.php");
?>
