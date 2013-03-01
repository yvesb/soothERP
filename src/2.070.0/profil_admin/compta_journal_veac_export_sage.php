<?php
// ***********************************************************************************************************
// export journal des ventes et achats format EDI
// ***********************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


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

// *************************************************
// Résultat de la recherche
$fiches = array();
if (isset($_REQUEST['recherche'])) {
	// Préparation de la requete
	
	// Recherche des FAC
	$query_join 	= "";
	$query_where 	= "  cj.id_journal_parent = '1' ";
	$query_group	= "";
	$query_limit	= "";
	
	$count_modes = 0;
	
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
												d.date_creation_doc, df.date_echeance, d.id_type_doc, 
												pc.lib_compte,
												cj.lib_journal, cj.id_journal_parent
								FROM compta_docs cd
									LEFT JOIN documents d ON d.ref_doc = cd.ref_doc
									LEFT JOIN doc_faf df ON d.ref_doc = df.ref_doc
									LEFT JOIN annuaire a ON a.ref_contact = d.ref_contact
									LEFT JOIN plan_comptable pc ON pc.numero_compte = cd.numero_compte
									LEFT JOIN compta_journaux cj ON cj.id_journal = cd.id_journal
									
								WHERE ".$query_where." && cd.ref_doc = '".$doc->ref_doc."'
								ORDER BY d.date_creation_doc DESC, cd.id_journal ASC
								";
						//echo nl2br($query);
			$resultat = $bdd->query($query);
			while ($fiche = $resultat->fetchObject()) {
				$fiches[] = $fiche; 
			}
			unset ($fiche, $resultat, $query);
	}
	unset ($queryd, $resultatd, $doc);
	
	
	// Recherche des FAF
	$query_join 	= "";
	$query_where 	= "  cj.id_journal_parent = '2' ";
	$query_group	= "";
	$query_limit	= "";
	
	$count_modes = 0;
	
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
												d.date_creation_doc, df.date_echeance, d.id_type_doc, 
												pc.lib_compte,
												cj.lib_journal, cj.id_journal_parent
								FROM compta_docs cd
									LEFT JOIN documents d ON d.ref_doc = cd.ref_doc
									LEFT JOIN doc_faf df ON d.ref_doc = df.ref_doc
									LEFT JOIN annuaire a ON a.ref_contact = d.ref_contact
									LEFT JOIN plan_comptable pc ON pc.numero_compte = cd.numero_compte
									LEFT JOIN compta_journaux cj ON cj.id_journal = cd.id_journal
									
								WHERE ".$query_where." && cd.ref_doc = '".$doc->ref_doc."'
								ORDER BY d.date_creation_doc DESC, cd.id_journal ASC
								";
						//echo nl2br($query);
			$resultat = $bdd->query($query);
			while ($fiche = $resultat->fetchObject()) {
				$fiches[] = $fiche; 
			}
			unset ($fiche, $resultat, $query);
	}
	unset ($queryd, $resultatd, $doc);
	
	
	
}

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

	$complement_nom_fichier = "";
	if ($search['date_debut']) {
		$complement_nom_fichier .=  "-".$search['date_debut']; 
	}
	if ($search['date_fin']) {
		$complement_nom_fichier .=  "-".$search['date_fin']; 
	}
	header('Pragma: public'); 
	header('Expires: 0'); 
	header('Cache-Control: must-revalidate, post-check=0, pre-check=0'); 
	header('Content-Type: application/force-download'); 
	header('Content-Type: application/octet-stream'); 
	header('Content-Type: application/download'); 
	header('Content-Type: text/plain; name="ECRITURES'.$complement_nom_fichier.'.edi"');
	header('Content-Disposition: attachment; filename=ECRITURES'.$complement_nom_fichier.'.edi;'); 
	$i = 1;
	
	foreach ($fiches as $fiche) {
		if ($fiche->montant == 0) {continue;}
		$montant_int = 0;
		if ($fiche->montant > 0) {$montant_int = 1;}
		
		if ($fiche->id_type_doc == "4") {
			$DorC= ($montant_int % 2)? 'C' : 'D';
			$journal_exp = "VE";
			$type_fact = "FA";
			if ($fiche->id_journal == "5") {$DorC= ($montant_int % 2)? 'D' : 'C';}
		}
		if ($fiche->id_type_doc == "8") {
			$DorC= ($montant_int % 2)? 'D' : 'C';
			$journal_exp = "AC";
			$type_fact = "FF";
			if ($fiche->id_journal == "8") {$DorC= ($montant_int % 2)? 'C' : 'D';}
		}
		
		echo $journal_exp.date("dmy",strtotime($fiche->date_creation_doc)).str_pad($fiche->numero_compte, 6, "0", STR_PAD_RIGHT).substr($fiche->ref_doc,0,3).substr($fiche->ref_doc,11,16).str_pad(str_replace(";","",substr($fiche->lib_compte,0,35)),35, " ", STR_PAD_RIGHT).$DorC.str_pad(abs(number_format($fiche->montant, $TARIFS_NB_DECIMALES, ".", ""	)),14, "0", STR_PAD_LEFT)."\n";
		
		$i++;
	}
?>