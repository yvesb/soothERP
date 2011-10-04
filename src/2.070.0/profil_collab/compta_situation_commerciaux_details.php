<?php
// ***********************************************************************************************************
// situation des commerciaux
// ***********************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

if (!$_SESSION['user']->check_permission ("17")) {
	//on indique l'interdiction et on stop le script
	echo "<br /><span style=\"font-weight:bolder;color:#FF0000;\">Vos droits  d'accés ne vous permettent pas de visualiser ce type de page</span>";
	exit();
}

$compta_e = new compta_exercices ();
$liste_exercices	= $compta_e->charger_compta_exercices();
//on récupère la dte du dernier exercice cloturé
foreach ($liste_exercices as $exercice) {
	if (!$exercice->etat_exercice) {$last_date_before_cloture = $exercice->date_fin; break;}
}

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
	$search['date_debut'] = date_Us_to_Fr($search['date_exercice'][0]);
	$search['date_fin'] = date_Us_to_Fr($search['date_exercice'][1]);
}


 
//liste des commerciaux
$liste_commerciaux = charger_liste_commerciaux ();
if (!isset($_REQUEST["ref_contact"])) {exit();}
foreach ($liste_commerciaux as $commercial) {
	if ($commercial->ref_contact != $_REQUEST["ref_contact"]) {unset($commercial); continue;}
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
	$commercial->docs = array();
	switch ($doc_fom_comm) {
		case "CDC": 
				// Préparation de la requete
				// Recherche des documents
				$queryd = "SELECT dvc.ref_doc , dvc.part, d.date_creation_doc
									FROM doc_ventes_commerciaux  dvc
										LEFT JOIN documents d ON d.ref_doc = dvc.ref_doc
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
						//on ajoute le pa de l'article dans la ligne
						if(!empty($contenu->pa_ht)){
								$pa_article = $contenu->pa_ht ;
						} else {
								$pa_article = $tmp_article->getPaa_ht ();
								if ( $tmp_article->getPrix_achat_ht ()) {
										$pa_article = $tmp_article->getPrix_achat_ht ();
								}
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
				$queryd = "SELECT dvc.ref_doc , dvc.part, d.date_creation_doc
									FROM doc_ventes_commerciaux  dvc
										LEFT JOIN documents d ON d.ref_doc = dvc.ref_doc
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
						//on ajoute le pa de l'article dans la ligne
						if(!empty($contenu->pa_ht)){
								$pa_article = $contenu->pa_ht ;
						} else {
								$pa_article = $tmp_article->getPaa_ht ();
								if ( $tmp_article->getPrix_achat_ht ()) {
										$pa_article = $tmp_article->getPrix_achat_ht ();
								}
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
				$queryd = "SELECT dvc.ref_doc , dvc.part, d.date_creation_doc
									FROM doc_ventes_commerciaux  dvc
										LEFT JOIN documents d ON d.ref_doc = dvc.ref_doc
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
						//on ajoute le pa de l'article dans la ligne
						if(!empty($contenu->pa_ht)){
							$pa_article = $contenu->pa_ht ;
						} else {
							$pa_article = $tmp_article->getPaa_ht ();
							if ( $tmp_article->getPrix_achat_ht ()) {
								$pa_article = $tmp_article->getPrix_achat_ht ();
							}
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

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************
include ($DIR.$_SESSION['theme']->getDir_theme()."page_compta_situation_commerciaux_details.inc.php");

?>