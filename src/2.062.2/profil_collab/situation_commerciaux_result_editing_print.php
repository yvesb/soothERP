<?php
// *************************************************************************************************************
// AFFICHAGE DES Résultats commerciaux(partie document pdf)
// *************************************************************************************************************

$MUST_BE_LOGIN = 1;
require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

// *************************************************
// Données pour le formulaire && la requete


$form['page_to_show'] = $search['page_to_show'] = 1;
if (isset($_REQUEST['page_to_show'])) {
	$form['page_to_show'] = $_REQUEST['page_to_show'];
	$search['page_to_show'] = $_REQUEST['page_to_show'];
}

$form['fiches_par_page'] = $search['fiches_par_page'] = $COMPTA_EXTRAIT_COMPTE_SHOWED_FICHES;
if (isset($_REQUEST['fiches_par_page'])) {
	$form['fiches_par_page'] = $_REQUEST['fiches_par_page'];
	$search['fiches_par_page'] = $_REQUEST['fiches_par_page'];
}

$nb_fiches = 0;


$form['date_debut'] = "" ;
if (isset($_REQUEST['date_debut'])) {
	$form['date_debut'] = $_REQUEST['date_debut'];
	$search['date_debut'] = $_REQUEST['date_debut'];
}

$form['date_fin'] = "" ;
if (isset($_REQUEST['date_fin'])) {
	$form['date_fin'] = $_REQUEST['date_fin'];
	$search['date_fin'] = $_REQUEST['date_fin'];
}
$form['date_exercice"'] = "" ;
if (isset($_REQUEST['date_exercice']) && ($form['date_fin'] == "" && $form['date_debut'] == "")) {
	$form['date_exercice'] = explode(";",$_REQUEST['date_exercice']);
	$search['date_exercice'] = explode(";",$_REQUEST['date_exercice']);
	$form['date_debut'] = $search['date_debut'] = date_Us_to_Fr($search['date_exercice'][0]);
	$form['date_fin'] = $search['date_fin'] = date_Us_to_Fr($search['date_exercice'][1]);
}
//liste des commerciaux
$liste_commerciaux = charger_liste_commerciaux ();

$bool_affichage=false;
if(isset($_REQUEST['com']))
$affichage=$_REQUEST['com'];
else $bool_affichage=true;

// on retire les commerciaux non sélectionné en checkbox
$i=0;
if(!$bool_affichage)
foreach($liste_commerciaux as $commercial){
if(!in_array($commercial->ref_contact,$affichage))
unset($liste_commerciaux[''.$i.'']);
$i++;}


foreach ($liste_commerciaux as $commercial) {

	$doc_fom_comm = substr($commercial->formule_comm, strpos($commercial->formule_comm, "(")+1 ,3); 
		
	$query_join 	= "";
	$query_where 	= " dvc.ref_contact = '".$commercial->ref_contact."' ";
	$query_group	= "";
	
	
	if ($search['date_debut']) {
		if ($query_where) { $query_where .= " &&  "; }
		$query_where .=  " d.date_creation_doc >= '".date_Fr_to_Us($search['date_debut'])." 00:00:00' "; 
	}
	if ($search['date_fin']) {
		if ($query_where) { $query_where .= " &&  "; }
		$query_where .=  " d.date_creation_doc <= '".date_Fr_to_Us($search['date_fin'])." 23:59:59' "; 
	}
	// *************************************************
	// Résultat de la recherche
	$commercial->ca = 0;
	$commercial->mg = 0;
	$commercial->comm = 0;
	$commercial->doc_fom_comm = $doc_fom_comm;
	$commercial->docs = array();
	switch ($doc_fom_comm) {
		case "CDC": 
				// Préparation de la requete
				// Recherche des documents
				$queryd = "SELECT dvc.ref_doc , dvc.part, d.date_creation_doc, d.ref_contact, a.nom
									FROM doc_ventes_commerciaux  dvc
										LEFT JOIN documents d ON d.ref_doc = dvc.ref_doc
										LEFT JOIN annuaire a ON a.ref_contact = d.ref_contact
									WHERE d.id_type_doc = '2' && d.id_etat_doc IN (9,10) &&  ".$query_where." 
									GROUP BY ref_doc
									";
				$resultatd = $bdd->query($queryd);
				while ($doc = $resultatd->fetchObject()) {
					$document = open_doc ($doc->ref_doc);
					$liste_contenu = $document->getContenu ();
					$doc->ca = 0;
					$doc->mg = 0;
					$doc->comm = 0;
					
					foreach ($liste_contenu as $contenu) {
						if ($contenu->ref_doc_line_parent != "" || $contenu->type_of_line != "article" || !$contenu->visible) {continue;}
						$tmp_article = new article ($contenu->ref_article);
						$doc->detail[]=$contenu;
						//on ajoute le pa de l'article dans la ligne
						$pa_article = $tmp_article->getPaa_ht ();
						if ( $tmp_article->getPrix_achat_ht ()) {
							$pa_article = $tmp_article->getPrix_achat_ht ();
						}
						$ca_article = (($contenu->pu_ht * $contenu->qte)-($contenu->pu_ht * $contenu->qte * $contenu->remise / 100))*($doc->part/100);
						$marge_article = ((($contenu->pu_ht * $contenu->qte)-($contenu->pu_ht * $contenu->qte * $contenu->remise / 100))-($pa_article * $contenu->qte))*($doc->part/100);
						$doc->ca += $ca_article;
						$doc->mg += $marge_article;
						if ($formule_art = article_formule_comm ($tmp_article->getRef_article(), $tmp_article->getRef_art_categ(), $commercial->id_commission_regle)) {
							$comm = new formule_comm($formule_art);
						} else {
							$comm = new formule_comm($commercial->formule_comm);
						}
						$doc->comm += $comm->calcul_commission ($ca_article, $marge_article) ;
					}
					$commercial->ca += $doc->ca;
					$commercial->mg += $doc->mg;
					$commercial->comm += $doc->comm;
					$commercial->docs[] = $doc; 
				}
		break;
		case "FAC": 
				// Préparation de la requete
				// Recherche des documents
				$queryd = "SELECT dvc.ref_doc , dvc.part, d.date_creation_doc, d.ref_contact, a.nom
									FROM doc_ventes_commerciaux  dvc
										LEFT JOIN documents d ON d.ref_doc = dvc.ref_doc
										LEFT JOIN annuaire a ON a.ref_contact = d.ref_contact
									WHERE d.id_type_doc = '4' && d.id_etat_doc IN (18, 19) &&  ".$query_where." 
									GROUP BY ref_doc
									";
				$resultatd = $bdd->query($queryd);
				while ($doc = $resultatd->fetchObject()) {
					$document = open_doc ($doc->ref_doc);
					$liste_contenu = $document->getContenu ();
					$doc->ca = 0;
					$doc->mg = 0;
					$doc->comm = 0;

					foreach ($liste_contenu as $contenu) {
						if ($contenu->ref_doc_line_parent != "" || $contenu->type_of_line != "article" || !$contenu->visible) {continue;}
						$tmp_article = new article ($contenu->ref_article);
						$doc->detail[]=$contenu;
						//on ajoute le pa de l'article dans la ligne
						$pa_article = $tmp_article->getPaa_ht ();
						if ( $tmp_article->getPrix_achat_ht ()) {
							$pa_article = $tmp_article->getPrix_achat_ht ();
						}
						$ca_article = (($contenu->pu_ht * $contenu->qte)-($contenu->pu_ht * $contenu->qte * $contenu->remise / 100))*($doc->part/100);
						$marge_article = ((($contenu->pu_ht * $contenu->qte)-($contenu->pu_ht * $contenu->qte * $contenu->remise / 100))-($pa_article * $contenu->qte))*($doc->part/100);
						$doc->ca += $ca_article;
						$doc->mg += $marge_article;
						
						if ($formule_art = article_formule_comm ($tmp_article->getRef_article(), $tmp_article->getRef_art_categ(), $commercial->id_commission_regle)) {
							$comm = new formule_comm($formule_art); 
						} else {
							$comm = new formule_comm($commercial->formule_comm); 
						}
						$doc->comm += $comm->calcul_commission ($ca_article, $marge_article) ;
						
						
					}
					$commercial->ca += $doc->ca;
					$commercial->mg += $doc->mg;
					$commercial->comm += $doc->comm;
					$commercial->docs[] = $doc; 
					
				}

		break;
		case "RGM": 
				// Préparation de la requete
				// Recherche des documents
				$queryd = "SELECT dvc.ref_doc , dvc.part, d.date_creation_doc, d.ref_contact, a.nom
									FROM doc_ventes_commerciaux  dvc
										LEFT JOIN documents d ON d.ref_doc = dvc.ref_doc
										LEFT JOIN annuaire a ON a.ref_contact = d.ref_contact
									WHERE d.id_type_doc = '4' && d.id_etat_doc = '19' &&  ".$query_where." 
									GROUP BY ref_doc
									";
				$resultatd = $bdd->query($queryd);
				while ($doc = $resultatd->fetchObject()) {
					$document = open_doc ($doc->ref_doc);
					$liste_contenu = $document->getContenu ();
					$doc->ca = 0;
					$doc->mg = 0;
					$doc->comm = 0;
					
					foreach ($liste_contenu as $contenu) {
						if ($contenu->ref_doc_line_parent != "" || $contenu->type_of_line != "article" || !$contenu->visible) {continue;}
						$tmp_article = new article ($contenu->ref_article);
						$doc->detail[]=$contenu;
						//on ajoute le pa de l'article dans la ligne
						$pa_article = $tmp_article->getPaa_ht ();
						if ( $tmp_article->getPrix_achat_ht ()) {
							$pa_article = $tmp_article->getPrix_achat_ht ();
						}
						$ca_article = (($contenu->pu_ht * $contenu->qte)-($contenu->pu_ht * $contenu->qte * $contenu->remise / 100))*($doc->part/100);
						$marge_article = ((($contenu->pu_ht * $contenu->qte)-($contenu->pu_ht * $contenu->qte * $contenu->remise / 100))-($pa_article * $contenu->qte))*($doc->part/100);
						if ($formule_art = article_formule_comm ($tmp_article->getRef_article(), $tmp_article->getRef_art_categ(), $commercial->id_commission_regle)) {
							$comm = new formule_comm($formule_art);
						} else {
							$comm = new formule_comm($commercial->formule_comm); 
						}
						
						$doc->ca += $ca_article;
						$doc->mg += $marge_article;
						$doc->comm += $comm->calcul_commission ($ca_article, $marge_article) ;
					}
					$commercial->ca += $doc->ca;
					$commercial->mg += $doc->mg;
					$commercial->comm += $doc->comm;
					$commercial->docs[] = $doc; 
				
				}
		break;
			
	
	}

} 



ini_set("memory_limit","40M");
	// impression pdf du grand livre
		
if (!isset($_REQUEST["code_pdf_modele"])) {
		$_REQUEST["code_pdf_modele"] = get_code_pdf_modele_res_com();
		}
	//$infos
	
	$code_pdf_modele = $_REQUEST["code_pdf_modele"];
	$infos = array();
	$lib = "RESULTATS COMMERCIAUX";
	$infos["lib_type_printed"] = $lib;
	$infos["dates"] = "du  ".$search['date_debut']." au ".$search['date_fin'];
	
	$infos["details"] = $_REQUEST["print"];
	
	if(isset($_REQUEST["impress"])){
	$GLOBALS['PDF_OPTIONS']['HideToolbar'] = 0;
	$GLOBALS['PDF_OPTIONS']['AutoPrint'] = 1;
	
	include_once ($PDF_MODELES_DIR.$code_pdf_modele.".class.php");
	$class = "pdf_".$code_pdf_modele;
	$pdf = new $class;
		// Création
	$pdf->create_pdf($infos, $liste_commerciaux);
	
	// Sortie
	
	$pdf->Output();
	
	} else {
	$GLOBALS['PDF_OPTIONS']['HideToolbar'] = 0;
	$GLOBALS['PDF_OPTIONS']['AutoPrint'] = 0;
	
	include_once ($PDF_MODELES_DIR.$code_pdf_modele.".class.php");
	$class = "pdf_".$code_pdf_modele;
	$pdf = new $class;
	
		// Création
	$pdf->create_pdf($infos, $liste_commerciaux);
	
	// Sortie
	
	$pdf->Output();
	}

//}

?>