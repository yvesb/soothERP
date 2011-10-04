<?php
// *************************************************************************************************************
// ACCUEIL DE L'UTILISATEUR ADMINISTRATEUR
// *************************************************************************************************************

require ("_dir.inc.php");
require ("_profil.inc.php");
require ("_session.inc.php");
require ($CONFIG_DIR."profil_".$_SESSION['profils'][$COLLAB_ID_PROFIL]->getCode_profil().".config.php");

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

$periode[0]=date('d-m-Y');
$periode[1]=date('d-m-Y');
if(isset($_REQUEST['date_d'])&&isset($_REQUEST['date_f'])){
	$periode[0]=$_REQUEST['date_d'];
	$periode[1]=$_REQUEST['date_f'];
}

$magasin=$_SESSION['magasin']->getId_magasin();
if(isset($_REQUEST['magasins'])&&is_numeric($_REQUEST['magasins'])){
	$magasin=$_REQUEST['magasins'];
}

//- stats ca
$Ca=charger_stats($periode,$magasin);
$Magasins=charger_all_magasins();

function charger_stats ($periode, $magasin) {
    global $bdd;
	
    $query_select = "SELECT SUM(ROUND(dl.qte * dl.pu_ht * (1-dl.remise/100) ,2) * (1+dl.tva/100)) as montant_ht";
    $query_total = "SELECT count(*) as total";
    $query_where = "";
    if (isset($periode[1]) && $periode[1] && $periode[1] != "--") {
        $query_where .= "&& date_creation_doc <= '".date_Fr_to_Us($periode[1])."'";
    }
    if (isset($periode[0]) && $periode[0] && $periode[0] != "--") {
        $query_where .= " && date_creation_doc >= '".date_Fr_to_Us($periode[0])."' ";
    }
    $query_where .= " && df.id_magasin = '".$magasin."' ";
   
    $montant_CA = 0;
    $query_from	=" FROM  docs_lines dl
					LEFT JOIN documents d ON dl.ref_doc = d.ref_doc
					LEFT JOIN articles a ON a.ref_article = dl.ref_article
					LEFT JOIN documents_types dt ON d.id_type_doc = dt.id_type_doc
					LEFT JOIN documents_etats de ON d.id_etat_doc = de.id_etat_doc
					LEFT JOIN doc_fac df ON df.ref_doc = d.ref_doc
					LEFT JOIN annu_client ac ON ac.ref_contact = d.ref_contact
					LEFT JOIN doc_ventes_commerciaux dvc ON dvc.ref_doc = d.ref_doc
					LEFT JOIN annu_commercial aco ON aco.ref_contact = dvc.ref_contact
				WHERE dl.ref_doc_line_parent IS NULL && d.id_etat_doc IN (18,19)
							&& dl.visible = 1
							".$query_where."
				ORDER BY date_creation_doc DESC, d.id_type_doc ASC";

    $resultat = $bdd->query ($query_select.$query_from);
    while ($art = $resultat->fetchObject()) {
        $montant_CA += $art->montant_ht;
    }
    return round($montant_CA,2);
}

//- nb ticket et panier moyen
$NbTicket='SELECT count(*) as total '
		 .'FROM documents d '
		 .'LEFT JOIN doc_fac df ON df.ref_doc = d.ref_doc '
		 .'WHERE id_type_doc=4 '
		 .'AND id_etat_doc IN (18,19) ';
if (isset($periode[1]) && $periode[1] && $periode[1] != "--") {
	$NbTicket .= "AND date_creation_doc <= '".date_Fr_to_Us($periode[1])."'";
}
if (isset($periode[0]) && $periode[0] && $periode[0] != "--") {
	$NbTicket .= " AND date_creation_doc >= '".date_Fr_to_Us($periode[0])."' ";
}
$NbTicket .= " AND df.id_magasin = '".$magasin."' ";
$ticket = $bdd->query($NbTicket);
$ticket = $ticket->fetchObject();
$Nbticket=$ticket->total;
if($Nbticket>0) $PanierMoyen=round($Ca/$Nbticket,2); else $PanierMoyen=0;

include ($DIR.$_SESSION['theme']->getDir_theme()."page_popup_stats.inc.php");
?>