<?php
// *************************************************************************************************************
// RECHERCHE DES OPERATION D'UN COMPTE BANCAIRE
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


//chargement des comptes bancaires
$compte_bancaire	= new compte_bancaire($_REQUEST["id_compte_bancaire"]);


// *************************************************
// Données pour le formulaire && la requete
$form['date_fin'] = $search['date_fin'] = date("Y-m-d")." 23:59:59";
if (isset($_REQUEST['date_fin'])) {
	$form['date_fin'] = $_REQUEST['date_fin']." 23:59:59";
	$search['date_fin'] = $_REQUEST['date_fin']." 23:59:59";
}

$search['date_debut'] = $ENTREPRISE_DATE_CREATION;

$nb_fiches = 0;

// *************************************************
// Résultat de la recherche
$fiches = array();
if (isset($_REQUEST['print'])) {
	// Préparation de la requete
	$query_join 	= "";
	$query_where 	= " id_compte_bancaire = '".$_REQUEST["id_compte_bancaire"]."' && date_move < '".$search['date_fin']."' ";
	
	//on recherche la date de debut de la liste part rapport au dernier relevé 
	$liste_releves = $compte_bancaire->getReleves_compte ();
	foreach ($liste_releves as $releve) {
		if ($releve->date_releve >= $search['date_fin']) {$next_montant_reel = $releve->solde_reel;	$id_compte_bancaire_releve = $releve->id_compte_bancaire_releve; continue; }
		$search['date_debut'] = $releve->date_releve;
		$query_where 	.= " &&  date_move > '".$releve->date_releve."' ";
		break;
	}
	
	if (isset($id_compte_bancaire_releve)) {
		$releve_encours = $compte_bancaire->charger_compte_bancaire_releve ($id_compte_bancaire_releve);
	}

	$solde_haut_page = 0;
	// Recherche
	$query = "SELECT id_compte_bancaire_move, id_compte_bancaire, date_move,
									 lib_move, montant_move, commentaire_move
						FROM comptes_bancaires_moves
							".$query_join."
						WHERE ".$query_where." 
						GROUP BY id_compte_bancaire_move
						ORDER BY date_move DESC, lib_move ASC, id_compte_bancaire_move ASC
						";
	$resultat = $bdd->query($query);
	while ($fiche = $resultat->fetchObject()) { $fiches[] = $fiche; $solde_haut_page += $fiche->montant_move; }
	//echo nl2br ($query);
	unset ($fiche, $resultat, $query);
	
	
	$report_solde = 0;
	if ($search['date_debut']) {
		$report_solde = $compte_bancaire->solde_reel_releve ($search['date_debut']);
	}
	$solde_haut_page += $report_solde;
	
	
	ini_set("memory_limit","40M");
	// impression pdf du relevé du compte
	$code_pdf_modele = "releve_compte";
	$GLOBALS['PDF_OPTIONS']['HideToolbar'] = 0;
	$GLOBALS['PDF_OPTIONS']['AutoPrint'] = 1;
	
	//$infos
	$infos = array();
	$infos["lib_type_printed"] = "Relevé du compte ".$compte_bancaire->getLib_compte();
	$infos["dates"] = "du  ".Date_Us_To_Fr($search['date_debut'])." au ".Date_Us_To_Fr($search['date_fin']);
	$infos["report_solde"] = $report_solde;
	$infos["solde_haut_page"] = $solde_haut_page;

	
	include_once ($PDF_MODELES_DIR.$code_pdf_modele.".class.php");
	$class = "pdf_".$code_pdf_modele;
	$pdf = new $class;

	// Création
	$pdf->create_pdf($infos, $fiches);
	
	// Sortie
	$pdf->Output();
}


?>