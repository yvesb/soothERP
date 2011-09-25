<?php
// *************************************************************************************************************
// FACTURES CLIENTS NON REGLEES
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require_once ($DIR."_session.inc.php");
require ($CONFIG_DIR."profil_".$_SESSION['profils'][$CLIENT_ID_PROFIL]->getCode_profil().".config.php");
contact::load_profil_class($CLIENT_ID_PROFIL);
if (!$_SESSION['user']->check_permission ("11")) {
	//on indique l'interdiction et on stop le script
	echo "<br /><span style=\"font-weight:bolder;color:#FF0000;\">Vos droits  d'accés ne vous permettent pas de visualiser ce type de page</span>";
	exit();
}
//infos de recherche 
$form['page_to_show'] = $search['page_to_show'] = 1;
if (isset($_REQUEST['page_to_show'])) {
	$form['page_to_show'] = $_REQUEST['page_to_show'];
	$search['page_to_show'] = $_REQUEST['page_to_show'];
}
$form['fiches_par_page'] =  $search['fiches_par_page'] = $COMPTA_FACTURE_TOPAY_SHOWED_FICHES;
if (isset($_REQUEST['fiches_par_page'])) {
	$form['fiches_par_page'] = $_REQUEST['fiches_par_page'];
	$search['fiches_par_page'] = $_REQUEST['fiches_par_page'];
}
$form['orderby'] = $search['orderby'] = "date_creation";
if (isset($_REQUEST['orderby'])) {
	$form['orderby'] = $_REQUEST['orderby'];
	$search['orderby'] = $_REQUEST['orderby'];
}
$form['orderorder'] = $search['orderorder'] = "ASC";
if (isset($_REQUEST['orderorder'])) {
	$form['orderorder'] = $_REQUEST['orderorder'];
	$search['orderorder'] = $_REQUEST['orderorder'];
}
$nb_fiches = 0;

//fin infos

$liste_categories_client = contact_client::charger_clients_categories ();

$categorie_client_var = $DEFAUT_ID_CLIENT_CATEG;

if (!isset($_REQUEST['id_client_categ']))
    $categ_client = NULL;
else
    $categ_client = json_decode($_REQUEST['id_client_categ']);
if (!isset($_REQUEST['id_niveau_relance']))
    $niveaux_relance = NULL;
else
    $niveaux_relance = json_decode($_REQUEST['id_niveau_relance']);
if (!isset($_REQUEST['id_mode_regmt']))
    $reglement_mode = NULL;
else
    $reglement_mode = json_decode($_REQUEST['id_mode_regmt']);


if(isset($_REQUEST['id_niveau_relance']) && $_REQUEST['id_niveau_relance']>0 ){$id_niveaux_relances = $_REQUEST['id_niveau_relance'];}
if(isset($_REQUEST['id_mode_regmt']) && $_REQUEST['id_mode_regmt']>0 ){$id_mode_regmt = $_REQUEST['id_mode_regmt'];}
/*if (!$nb_fiches) {
    $nb_fiches = count_niveau_factures_to_pay($categorie_client_var);
}*/
$niveau_relance_var = "";
$liste_niveaux_relance = getNiveaux_relance ($liste_categories_client[$categorie_client_var]->id_relance_modele) ;
foreach ($liste_niveaux_relance as $key => $niveau_relance) {
	$niveau_relance->count_fact = count_niveau_factures_to_pay($categorie_client_var, $niveau_relance->id_niveau_relance);
        if ($niveau_relance->count_fact == 0){
            unset ($liste_niveaux_relance[$key]);
            continue;
        }
        if ($niveau_relance_var == "") $niveau_relance_var = $niveau_relance->id_niveau_relance;
	if (isset($_REQUEST["id_niveau_relance"]) && $_REQUEST["id_niveau_relance"] == $niveau_relance->id_niveau_relance ) {
 	$nb_fiches = $niveau_relance->count_fact;
	}
}

//$non_defini = count_niveau_factures_to_pay($categorie_client_var);
/*if (isset($_REQUEST["id_niveau_relance"]) && ($_REQUEST["id_niveau_relance"] != "" || $non_defini) ) {
$niveau_relance_var = $_REQUEST["id_niveau_relance"];
}*/
//chargement des factures de $DEFAUT_ID_CLIENT_CATEG
$factures = array();
//$factures = get_factures_to_pay ($categorie_client_var, $niveau_relance_var);
//_vardump($factures);
//$factures_total = get_factures_to_pay_total ($categorie_client_var, $niveau_relance_var);

//Récuperation des variables
if (isset($_REQUEST["id_client_categ"])) {
$categorie_client_var = $_REQUEST["id_client_categ"];
}

$factures_total =0;
$nb_fiches =0;
$non_defini =0;
//Test
        global $bdd;
	global $DEFAUT_ID_CLIENT_CATEG;
	global $COMPTA_FACTURE_TOPAY_SHOWED_FICHES;


	$query_limit	=  (($search['page_to_show']-1)*$search['fiches_par_page']).", ".$search['fiches_par_page'];
	$query_where = "";
        if (!empty($reglement_mode)) {
            $query_where .= " && dech.id_mode_reglement IN (";
            $i = 0;
            while(isset($reglement_mode[$i])){
                if (isset($reglement_mode[$i + 1]))
                      $query_where .= $reglement_mode[$i++].', ';
                else
                      $query_where .= $reglement_mode[$i++];
            }
            $query_where .= ")";
        }
        if (!empty($categ_client)) {
            $query_where .= " && ac.id_client_categ IN (";
            $i = 0;
            while(isset($categ_client[$i])){
                if (isset($categ_client[$i + 1]))
                      $query_where .= $categ_client[$i++].', ';
                else
                      $query_where .= $categ_client[$i++];
            }
            $query_where .= ")";
        }
	if (!empty($niveaux_relance)) {
		$query_where .= " && df.id_niveau_relance IN (";
                $i = 0;
            while(isset($niveaux_relance[$i])){
                if (isset($niveaux_relance[$i + 1]))
                      $query_where .= $niveaux_relance[$i++].', ';
                else
                      $query_where .= $niveaux_relance[$i++];
            }
            $query_where .= ")";
	}
	$factures = array();
	$query = "SELECT DISTINCT d.ref_doc, d.ref_contact, d.nom_contact, d.id_type_doc, dt.lib_type_doc, d.id_etat_doc, de.lib_etat_doc,
									 d.date_creation_doc date_creation,
									 df.id_magasin , m.lib_magasin, m.abrev_magasin,
									 df.date_echeance, df.date_next_relance, fnr.id_niveau_relance, fnr.niveau_relance, fnr.lib_niveau_relance
						FROM documents d
							LEFT JOIN doc_fac df ON d.ref_doc = df.ref_doc
							LEFT JOIN annu_client ac ON ac.ref_contact = d.ref_contact
							LEFT JOIN factures_relances_niveaux fnr ON df.id_niveau_relance = fnr.id_niveau_relance
							LEFT JOIN documents_types dt ON d.id_type_doc = dt.id_type_doc
							LEFT JOIN documents_etats de ON d.id_etat_doc = de.id_etat_doc
							LEFT JOIN magasins m ON m.id_magasin = df.id_magasin
                                                        LEFT JOIN doc_echeanciers dech ON dech.ref_doc = d.ref_doc
						WHERE d.id_type_doc = 4 && d.id_etat_doc != 19 && d.id_etat_doc != 17 ".$query_where."
						ORDER BY fnr.id_niveau_relance ASC, ".$search['orderby']." ".$search['orderorder']."
						LIMIT ".$query_limit;
	$resultat = $bdd->query($query);
	while ($tmp = $resultat->fetchObject()) {

		$document = open_doc ($tmp->ref_doc);
		$tmp->montant_ttc = $document->getMontant_ttc();
                $tmp->montant_du = $document->getMontant_to_pay();
                $factures_total += $tmp->montant_du;
                $non_defini ++;
		$factures[] = $tmp;

	}
$query = "SELECT DISTINCT d.ref_doc
						FROM documents d
                                                        LEFT JOIN doc_fac df ON d.ref_doc = df.ref_doc
							LEFT JOIN annu_client ac ON ac.ref_contact = d.ref_contact
							LEFT JOIN factures_relances_niveaux fnr ON df.id_niveau_relance = fnr.id_niveau_relance
							LEFT JOIN documents_types dt ON d.id_type_doc = dt.id_type_doc
							LEFT JOIN documents_etats de ON d.id_etat_doc = de.id_etat_doc
							LEFT JOIN magasins m ON m.id_magasin = df.id_magasin
                                                        LEFT JOIN doc_echeanciers dech ON dech.ref_doc = d.ref_doc
						WHERE d.id_type_doc = 4 && d.id_etat_doc != 19 && d.id_etat_doc != 17 ".$query_where."";
	$resultat = $bdd->query($query);
	while ($result = $resultat->fetchObject()) { $nb_fiches += 1; }
	unset ($result, $resultat, $query);





/*
        if (!empty($id_mode_regmt)) {
            $where = " && dech.id_mode_reglement = '".$id_mode_regmt."' ";
        }
        if (!empty($categorie_client_var)) {
            $where = " && ac.id_client_categ = '".$categorie_client_var."' ";
        }
	if (!empty($_REQUEST['id_niveau_relance'])) {
		$where .= " && df.id_niveau_relance = '".$_REQUEST['id_niveau_relance']."' ";
	} else {
		$where .= " && df.id_niveau_relance IS NULL";
	}
	$factures = array();
	$query = "SELECT d.ref_doc, d.ref_contact, d.nom_contact, d.id_type_doc, dt.lib_type_doc, d.id_etat_doc, de.lib_etat_doc,
									 d.date_creation_doc date_creation,
									 df.id_magasin , m.lib_magasin, m.abrev_magasin,
									 df.date_echeance, df.date_next_relance, fnr.id_niveau_relance, fnr.niveau_relance, fnr.lib_niveau_relance
						FROM documents d
							LEFT JOIN doc_fac df ON d.ref_doc = df.ref_doc
							LEFT JOIN annu_client ac ON ac.ref_contact = d.ref_contact
							LEFT JOIN factures_relances_niveaux fnr ON df.id_niveau_relance = fnr.id_niveau_relance
							LEFT JOIN documents_types dt ON d.id_type_doc = dt.id_type_doc
							LEFT JOIN documents_etats de ON d.id_etat_doc = de.id_etat_doc
							LEFT JOIN magasins m ON m.id_magasin = df.id_magasin
                                                        LEFT JOIN doc_echeanciers dech ON dech.ref_doc = d.ref_doc
						WHERE d.id_type_doc = 4 && d.id_etat_doc != 17 && d.id_etat_doc != 19 ".$where."
						ORDER BY fnr.id_niveau_relance ASC, ".$search['orderby']." ".$search['orderorder']."
						LIMIT ".$query_limit;
	$resultat = $bdd->query($query);
	while ($tmp = $resultat->fetchObject()) {

		$document = open_doc ($tmp->ref_doc);
		$tmp->montant_ttc = $document->getMontant_ttc();
                $factures_total += $tmp->montant_ttc;
                $tmp->montant_du = $document->getMontant_to_pay();
                $nb_fiches ++;
                $non_defini ++;
		$factures[] = $tmp;

	}*/


// *************************************************************************************************************
// AFFICHAGE
// -*************************************************************************************************************

// Soit action == NULL -> Recherche -> Affichage factures
// Soit action == print -> Impression -> Génération pdf

if (empty($_REQUEST['action'])){
    $categ_client_json = $_REQUEST['id_client_categ'];
    $niveaux_relance_json = $_REQUEST['id_niveau_relance'];
    $reglement_mode_json = $_REQUEST['id_mode_regmt'];
    include ($DIR.$_SESSION['theme']->getDir_theme()."page_compta_factures_client_nonreglees_liste.inc.php");
}
else{
   $form['page_to_show'] = $search['page_to_show'] = 1;

$form['orderby'] = $search['orderby'] = "date_creation";
if (isset($_REQUEST['orderby'])) {
	$form['orderby'] = $_REQUEST['orderby'];
	$search['orderby'] = $_REQUEST['orderby'];
}
$form['orderorder'] = $search['orderorder'] = "ASC";
if (isset($_REQUEST['orderorder'])) {
	$form['orderorder'] = $_REQUEST['orderorder'];
	$search['orderorder'] = $_REQUEST['orderorder'];
}
$nb_fiches = 0;

//fin infos

$categorie_client_var = "";
$lib_client_categ = "";
$lib_niveau_relance = "";
// chargement de la class du profil
contact::load_profil_class($CLIENT_ID_PROFIL);
$form['fiches_par_page'] = $search['fiches_par_page'] = $nb_fiches;

$niveau_relance_var = "";
//deux cas de figure soit on imprime les résultat (comme sur la page) soit les documents factures
$GLOBALS['PDF_OPTIONS']['HideToolbar'] = 0;
$GLOBALS['PDF_OPTIONS']['AutoPrint'] = 0;

if (isset($_REQUEST["print_fact"])) {
	$pdf = new PDF_etendu ();
	//on liste les documents pour les imprimer
	foreach ($factures as $facture) {
	$GLOBALS['_OPTIONS']['CREATE_DOC']['no_charge_all_sn'] = 1;
		$document = open_doc ($facture->ref_doc);
		// Ajout du document au PDF
		$pdf->add_doc ("", $document);
	}
} else {
	//on affiche les resultats comme sur le listing des factures non réglées
	include_once ($PDF_MODELES_DIR."factures_apayer.class.php");
	$class = "pdf_factures_apayer";
	$pdf = new $class;
        $pdf->create_pdf($factures, $lib_client_categ, $lib_niveau_relance);
}
// Sortie
$pdf->Output();
}
?>