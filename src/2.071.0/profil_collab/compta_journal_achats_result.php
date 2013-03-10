<?php
// ***********************************************************************************************************
// journal des achats
// ***********************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

if (!$_SESSION['user']->check_permission ("13")) {
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


$form['ref_contact'] = "" ;
$search['ref_contact'] = "";
if (isset($_REQUEST['ref_contact']) && $_REQUEST['ref_contact'] != "") {
	$form['ref_contact'] = $_REQUEST['ref_contact'];
	$search['ref_contact'] = $_REQUEST['ref_contact'];
}

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

$form['numero_compte'] = "" ;
$search['numero_compte'] = "";
if (isset($_REQUEST['numero_compte']) && $_REQUEST['numero_compte'] != "") {
	$form['numero_compte'] = $_REQUEST['numero_compte'];
	$search['numero_compte'] = $_REQUEST['numero_compte'];
}


// *************************************************
// Résultat de la recherche
$fiches = array();
if (isset($_REQUEST['recherche'])) {
	// Préparation de la requete
	$query_join 	= "";
	$query_where 	= " cj.id_journal_parent = '2' ";
	$query_group	= "";
	
	$query_limit	= "";
	if (!isset($_REQUEST["print"])) {
		$query_limit	= "LIMIT ".(($search['page_to_show']-1)*$search['fiches_par_page']).", ".$search['fiches_par_page'];
	}
	
	
	$count_modes = 0;
	
	if ($search['numero_compte']) {
		if ($query_where) { $query_where .= " &&  "; }
		$query_where .=  " pc.numero_compte = '".$search['numero_compte']."' "; 
	}
	if ($search['ref_contact']) {
		if ($query_where) { $query_where .= " &&  "; }
		$query_where .=  " d.ref_contact = '".$search['ref_contact']."' "; 
	}
	if ($search['date_debut']) {
		if ($query_where) { $query_where .= " &&  "; }
		$query_where .=  " d.date_creation_doc >= '".date_Fr_to_Us($search['date_debut'])." 00:00:00' "; 
	}
	if ($search['date_fin']) {
		if ($query_where) { $query_where .= " &&  "; }
		$query_where .=  " d.date_creation_doc <= '".date_Fr_to_Us($search['date_fin'])." 23:59:59' "; 
	}
	

$nb_doc_aff = array();

 
 //recherche des documents
 $queryd = "SELECT cd.ref_doc 
						FROM compta_docs cd
							LEFT JOIN documents d ON d.ref_doc = cd.ref_doc
							LEFT JOIN annuaire a ON a.ref_contact = d.ref_contact
							LEFT JOIN plan_comptable pc ON pc.numero_compte = cd.numero_compte
							LEFT JOIN compta_journaux cj ON cj.id_journal = cd.id_journal
							
						WHERE ".$query_where." 
						GROUP BY ref_doc
						".$query_limit;
	$resultatd = $bdd->query($queryd);
	while ($doc = $resultatd->fetchObject()) {
		 //recherche des lignes comptable
		 $query = "SELECT  cd.ref_doc, cd.id_journal, cd.montant, cd.numero_compte,
												a.nom, a.ref_contact,
												d.date_creation_doc,
												pc.lib_compte,
												cj.lib_journal, cj.id_journal_parent
								FROM compta_docs cd
									LEFT JOIN documents d ON d.ref_doc = cd.ref_doc
									LEFT JOIN annuaire a ON a.ref_contact = d.ref_contact
									LEFT JOIN plan_comptable pc ON pc.numero_compte = cd.numero_compte
									LEFT JOIN compta_journaux cj ON cj.id_journal = cd.id_journal
									
								WHERE ".$query_where." && cd.ref_doc = '".$doc->ref_doc."'
								ORDER BY d.date_creation_doc DESC, cd.id_journal ASC
								";
			$resultat = $bdd->query($query);
			while ($fiche = $resultat->fetchObject()) {
				$fiches[] = $fiche; 
			}
			unset ($fiche, $resultat, $query);
			$nb_doc_aff[] = $doc;
	}
	unset ($queryd, $resultatd, $doc);
	
 $queryd = "SELECT cd.ref_doc 
						FROM compta_docs cd
							LEFT JOIN documents d ON d.ref_doc = cd.ref_doc
							LEFT JOIN annuaire a ON a.ref_contact = d.ref_contact
							LEFT JOIN plan_comptable pc ON pc.numero_compte = cd.numero_compte
							LEFT JOIN compta_journaux cj ON cj.id_journal = cd.id_journal
							
						WHERE ".$query_where." 
						GROUP BY ref_doc
						";
	$resultatd = $bdd->query($queryd);
	while ($doc = $resultatd->fetchObject()) {
		$nb_fiches++;
	}
	unset ($queryd, $resultatd, $doc);
	//calcul des toto par compte
	$synthese = array();
	$query = "SELECT  cd.ref_doc, SUM( cd.montant) as toto_montant, cd.numero_compte, cd.id_journal,
										pc.lib_compte,
										d.date_creation_doc
						FROM compta_docs cd
							LEFT JOIN documents d ON d.ref_doc = cd.ref_doc
							LEFT JOIN annuaire a ON a.ref_contact = d.ref_contact
							LEFT JOIN plan_comptable pc ON pc.numero_compte = cd.numero_compte
							LEFT JOIN compta_journaux cj ON cj.id_journal = cd.id_journal
						WHERE ".$query_where."
						GROUP BY cd.numero_compte
						ORDER BY d.date_creation_doc DESC, cd.id_journal ASC
						";
	$resultat = $bdd->query($query);
	while ($fiche = $resultat->fetchObject()) {
		$synthese[] = $fiche; 
	}
	unset ($fiche, $resultat, $query);
	
}

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************
if (isset($_REQUEST["print"])) {
	ini_set("memory_limit","40M");
	// impression pdf du grand livre
	$code_pdf_modele = "journaux";
	$GLOBALS['PDF_OPTIONS']['HideToolbar'] = 0;
	$GLOBALS['PDF_OPTIONS']['AutoPrint'] = 1;
	
	//$infos
	$infos = array();
	$lib = "Journal des achats";
	if (isset($_REQUEST['ref_contact']) && $_REQUEST['ref_contact'] != "") {
		$contact = new contact($_REQUEST['ref_contact']);
		if ($contact->getNom()) { $lib .=  " ".$contact->getNom();}
	}
	$infos["lib_type_printed"] = $lib;
	$infos["dates"] = "du  ".$search['date_debut']." au ".$search['date_fin'];
	$infos["contact"] = "Tier";
	$infos["montant"] = "Montant HT";
	
	include_once ($PDF_MODELES_DIR.$code_pdf_modele.".class.php");
	$class = "pdf_".$code_pdf_modele;
	$pdf = new $class;
	
	// Création
	$pdf->create_pdf($infos, $fiches, $synthese);
	
	// Sortie
	$pdf->Output();

} else {
	//affichage des résultats dans lmb
	include ($DIR.$_SESSION['theme']->getDir_theme()."page_compta_journal_achats_result.inc.php");
}
?>