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

	if (isset($_REQUEST["tpexport"]) && $_REQUEST["tpexport"] == "vente") {
		$complement_nom_fichier .=  "vente"; 
	} else {
		$complement_nom_fichier .=  "achat"; 
	}
	
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
	
	
	$comptes_plan_general	= compta_plan_general::charger_comptes_plan_general();
	$contact_entreprise = new contact($REF_CONTACT_ENTREPRISE);
	$nom_entreprise = str_replace (CHR(13), " " ,str_replace (CHR(10), " " , $contact_entreprise->getNom()));
	//entete
	echo $nom_entreprise."\n";
	echo date("dmY",strtotime($search['date_debut']))."\n";
	echo date("dmY",strtotime($search['date_fin']))."\n";
	//comptes_plan
	$liste_cpt_clients = array();
	//chargement des comptes pour clients
	$query_cli = "SELECT 
									ac.defaut_numero_compte,
									cc.defaut_numero_compte as categ_defaut_numero_compte			
									
						FROM annu_client ac
						LEFT JOIN clients_categories cc ON cc.id_client_categ = ac.id_client_categ
						LEFT JOIN plan_comptable pc ON pc.numero_compte = ac.defaut_numero_compte
						";	
	$resultat_cli = $bdd->query ($query_cli);
	while ($contact_client = $resultat_cli->fetchObject()) {
		
		$defaut_numero_compte = $contact_client->defaut_numero_compte;
		//remplissage du numéro de compte achat par soit celui de la categorie client
		if (!$defaut_numero_compte) {
		$defaut_numero_compte = $contact_client->categ_defaut_numero_compte;
		}
		//soit par celui par defaut
		if (!$defaut_numero_compte) {
		$defaut_numero_compte = $DEFAUT_COMPTE_TIERS_VENTE;
		}
		$liste_cpt_clients[$defaut_numero_compte] = $defaut_numero_compte;
	}
	$liste_cpt_fourn = array();
	//chargement des comptes pour fournisseurs
	$query_fou = "SELECT af.defaut_numero_compte,
									fc.defaut_numero_compte as categ_defaut_numero_compte					
					FROM annu_fournisseur af
						LEFT JOIN fournisseurs_categories fc ON fc.id_fournisseur_categ = af.id_fournisseur_categ
						LEFT JOIN plan_comptable pc ON pc.numero_compte = fc.defaut_numero_compte
						";	
	$resultat_fou = $bdd->query ($query_fou);
	while ($contact_fournisseur = $resultat_fou->fetchObject()) {
		
		$defaut_numero_compte = $contact_fournisseur->defaut_numero_compte;
		//remplissage du numéro de compte achat par soit celui de la categorie client
		if (!$defaut_numero_compte) {
		$defaut_numero_compte = $contact_fournisseur->categ_defaut_numero_compte;
		}
		//soit par celui par defaut
		if (!$defaut_numero_compte) {
		$defaut_numero_compte = $DEFAUT_COMPTE_TIERS_ACHAT;
		}
		$liste_cpt_fourn[$defaut_numero_compte] = $defaut_numero_compte;
	}
	//C;10;CAPITAL ET RESERVE;G
	foreach ($comptes_plan_general as $plan_entreprise) {
		$typ_ctp = "G";
		if (isset($liste_cpt_fourn[$plan_entreprise->numero_compte])) {		$typ_ctp = "F";}
		if (isset($liste_cpt_clients[$plan_entreprise->numero_compte])) {		$typ_ctp = "C";}
		echo "C;".$plan_entreprise->numero_compte.";".str_replace(";","",$plan_entreprise->lib_compte).";".$typ_ctp."\n";
	}
	
	//ecritures
	foreach ($fiches as $fiche) {
		if ($fiche->montant == 0) {continue;}
		$montant_int = 0;
		if ($fiche->montant > 0) {$montant_int = 1;}
		
		if ($fiche->id_type_doc == "4" && isset($_REQUEST["tpexport"]) && $_REQUEST["tpexport"] == "vente") {
			$DorC= ($montant_int % 2)? 'C' : 'D';
			$journal_exp = "VE";
			$type_fact = "FA";
			if ($fiche->id_journal == "5") {$DorC= ($montant_int % 2)? 'D' : 'C';}
		echo "E;".$fiche->numero_compte.";".date("dmY",strtotime($fiche->date_creation_doc)).";".$journal_exp.";".substr($fiche->ref_doc,0,3).substr($fiche->ref_doc,11,16)."; ;".str_replace(";","",substr($fiche->lib_compte,0,40)).";".$DorC.";".abs(number_format($fiche->montant, $TARIFS_NB_DECIMALES, ".", ""	)).";;\n";
		
		$i++;
		}
		if ($fiche->id_type_doc == "8" && isset($_REQUEST["tpexport"]) && $_REQUEST["tpexport"] == "achat") {
			$DorC= ($montant_int % 2)? 'D' : 'C';
			$journal_exp = "AC";
			$type_fact = "FF";
			if ($fiche->id_journal == "8") {$DorC= ($montant_int % 2)? 'C' : 'D';}
		echo "E;".$fiche->numero_compte.";".date("dmY",strtotime($fiche->date_creation_doc)).";".$journal_exp.";".substr($fiche->ref_doc,0,3).substr($fiche->ref_doc,11,16)."; ;".str_replace(";","",substr($fiche->lib_compte,0,40)).";".$DorC.";".abs(number_format($fiche->montant, $TARIFS_NB_DECIMALES, ".", ""	)).";;\n";
		
		$i++;
		}
		
		
	}
?>