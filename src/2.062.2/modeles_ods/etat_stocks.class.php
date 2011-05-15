<?php
// Load library
require_once('../ressources/ods/ods.php');

// *************************************************************************************************************
// GENERATION DES RESULTATS DES COMMERCIAUX
// *************************************************************************************************************

class ods_etat_stocks{
	var $code_ods_modele = "etat_stocks";
	var $ods;
	var $liste;
	var $stock;					// stock a exporter
	var $id_stock;
	var $lib_stock;
	var $contenu;
	var $current_ref_art_categ;
        var $nb_entete_colonne;
	
public function ods_etat_stocks () {
	global $ODS_MODELES_DIR;
	global $COMMISSIONS;
	global $MONNAIE;
	global $GESTION_REF_INTERNE;

	$liste=$this->init();
	//$infos
	$this->contenu 	= $liste;
	//echo'<pre>';print_r($this->contenu);echo'<pre>';
	
	$tab = explode(",",$_REQUEST['id_stock']);
	
	if(isset($this->contenu[0]->stocks[$tab[0]]->id_stock)){
	$this->stock = new stock($this->contenu[0]->stocks[$tab[0]]->id_stock);
	$this->id_stock	= $this->stock->getId_stock();
	$this->lib_stock	= $this->stock->getLib_stock();
	}
	// ***************************************************
	// Initialisation des variables
	$this->nb_pages					= 1;
	$this->contenu_actuel 	= 0;					// Ligne du document en cours de traitement
	$this->contenu_end_page = array();		// Lignes de contenu terminant les diffï¿½rentes pages
	$this->page_actuelle		= 0;
	$this->content_printed	= 0;
        $this->nb_entete_colonne = 0;
	$this->current_ref_art_categ = "";
	
	include_once ($ODS_MODELES_DIR."config/".$this->code_ods_modele.".config.php");

	// ***************************************************

	$this->ods  = new ods();
	
	// Create table
	$this->table = new odsTable(utf8_encode('Etat stocks'));
	
	//taille des colonnes
	$this->create_stylecol('3 cm');
	$this->create_stylecol('6 cm');
	$this->create_stylecol('6 cm');
	$this->create_stylecol('4 cm');
	$this->create_stylecol('2 cm');
	$this->create_stylecol('2 cm');
	$this->create_stylecol('3 cm');
	$this->create_stylecol('3 cm');
	$this->create_titre();
	
	$this->create_entete();

	$this->create_corps();

	//Ajout de la table
	$this->ods->addTable($this->table);
	
	// Download the file
	$this->ods->downloadOdsFile("Etat du stock.ods");
}

public function create_titre() {
	//titre
	$titre = new odsStyleTableCell();
	$titre->setFontWeight('bold');
	$titre->setFontSize("18pt");
	
	// Titre
	$row = new odsTableRow();
	$cell = new odsTableCellString(utf8_encode("Etat du stock"), $titre);
	$cell->setNumberColumnsSpanned(4);
	$row->addCell( $cell );
	$this->table->addRow($row);
	$row = new odsTableRow();
	
	$cell = new odsTableCellString(utf8_encode("Stock : ".$this->lib_stock));
	$cell->setNumberColumnsSpanned(4);
	$row->addCell( $cell );
	$this->table->addRow($row);
	$row = new odsTableRow();
	
	$cell = new odsTableCellString(utf8_encode("Date : ".date("d/m/Y")));
	$cell->setNumberColumnsSpanned(4);
	$row->addCell( $cell );
	$this->table->addRow($row);
	$row = new odsTableRow();
	$this->table->addRow($row);
} 

public function create_stylecol($cm){
	//nb colonne de taille cm   
	$stylecol = new odsStyleTableColumn();
	$stylecol->setColumnWidth($cm);
	$col1 = new odsTableColumn($stylecol);
	$this->table->addTableColumn($col1);
	}

public function create_entete() {
	$row=$this->create_row();
	$this->create_cellgrey('Ref article',$row);
	$this->create_cellgrey('Lib article',$row);
	$this->create_cellgrey('Nom fabricant',$row);
	$this->create_cellgrey('Lib catégorie',$row);
	$this->create_cellgrey('Stock',$row);
        $this->nb_entete_colonne = 5;
	if($_REQUEST['emplacement_s']!=''){
	$this->create_cellgrey('Emplacement',$row);
        $this->nb_entete_colonne +=1;
        }
	if($_REQUEST['aff_pa']==1){
	$this->create_cellgrey('PA HT',$row);
        $this->nb_entete_colonne += 1;
        }
	if($GLOBALS['GESTION_REF_INTERNE']==1){
	$this->create_cellgrey('Ref interne',$row);
        $this->nb_entete_colonne += 1;
        }
	$this->create_cellgrey('Ref OEM',$row);
	$this->create_cellgrey('Code barre',$row);
        $this->nb_entete_colonne += 2;
        //Si Affichage des informations de traçabilité
        if($_REQUEST['aff_info_tracab']==1){
            $this->create_cellgrey('Lot ou SN',$row);
            $this->create_cellgrey('Qte',$row);
            //$this->nb_entete_colonne += 2;
        }
	$this->create_cellgrey('Prix public',$row);
        //$this->nb_entete_colonne += 1;
	if(!empty($this->contenu[0]->pv)){
	foreach($this->contenu[0]->pv as $prix){
			$this->create_cellgrey($prix->lib_tarif,$row);
		}	
	}
}

public function create_corps() {
	$lib_art_categ='';
	
	$this->totaux_qte = 0;
	$this->totaux_prix = 0;
	// ***************************************************
	// Contenu du tableau
        //_vardump($this->contenu);
	for ($i = $this->contenu_actuel; $i<count($this->contenu); $i++) {
            //echo $i;
		//si on change de catégorie
		if ($lib_art_categ != $this->contenu[$i]->lib_art_categ && $lib_art_categ !='') {
			$row=$this->create_row();
			$this->create_cellbold('Sous total : ',$row);
			$cell = new odsTableCellString(utf8_encode($lib_art_categ));
			$cell->setNumberColumnsSpanned(2);
			$row->addCell( $cell );
			$this->create_cell('Quantité total :',$row);
			$this->create_cellFloat($this->totaux_qte,$row);
			if($_REQUEST['aff_pa']==1){
			$this->create_cell('Prix total :',$row);
			$this->create_celleuro($this->totaux_prix,$row);
			}
			$this->totaux_qte = 0;
			$this->totaux_prix = 0;
			$row=$this->create_row();
		}
		
		
		//si on change de categorie on ajoute une ligne
		if ($lib_art_categ != $this->contenu[$i]->lib_art_categ) {
			$lib_art_categ=$this->contenu[$i]->lib_art_categ;
			$row=$this->create_row();
			$cell = new odsTableCellString(utf8_encode($this->contenu[$i]->lib_art_categ));
			$cell->setNumberColumnsSpanned(6);
			$row->addCell( $cell );
		}
		$row=$this->create_row();
		$this->create_cell($this->contenu[$i]->ref_article,$row);
		$this->create_cell($this->contenu[$i]->lib_article,$row);
		$this->create_cell($this->contenu[$i]->nom_constructeur,$row);
		$this->create_cell($this->contenu[$i]->lib_art_categ,$row);
                //Récuperer la quantite d'article en stock
                $qte_stock = 0;
                //Fait pour un seul stock
                if(!empty($this->contenu[$i]->stocks)){
                    foreach($this->contenu[$i]->stocks as $stock)
                    {
                        $qte_stock = $stock->qte;
                    }
                }

		if(isset($qte_stock)){
                    $this->totaux_qte+=$qte_stock;
                    if($_REQUEST['aff_pa']==1)
                    $this->totaux_prix+=$qte_stock*$this->contenu[$i]->paa_ht;
                    if($qte_stock >= 0)
                        $this->create_cellFloat($qte_stock,$row);
                    else{
                        $this->create_cellFloatRed($qte_stock,$row);
                    }
		}else
		{
		$this->create_cellFloat(0,$row);
		}
		if($_REQUEST['emplacement_s']!='')//Une colonne en plus
		$this->create_cell($this->contenu[$i]->emplacement,$row);
		if($_REQUEST['aff_pa']==1)//Une colonne en plus
		$this->create_celleuro($this->contenu[$i]->paa_ht,$row);
		if($GLOBALS['GESTION_REF_INTERNE']==1)//4 colonne en plus
		$this->create_cell($this->contenu[$i]->ref_interne,$row);
		$this->create_cell($this->contenu[$i]->ref_oem,$row);
		$this->create_cell($this->contenu[$i]->code_barre,$row);
		//$this->create_cell('',$row);
		if($_REQUEST['aff_info_tracab']==1){
                    $this->create_cell('',$row);
			$this->create_cell('',$row);

                }
		$this->create_celleuro($this->contenu[$i]->prix_public_ht,$row);
		
		foreach($this->contenu[$i]->pv as $prix){
			$this->create_cellFloat($prix->pu_ht,$row);
		}
		
		if($_REQUEST['aff_info_tracab']==1){
			$art = new article($this->contenu[$i]->ref_article);
			$art_stock_sn = $art->getStocks_arti_sn ();
			if(!empty($art_stock_sn[$this->id_stock]->sn)){
				foreach($art_stock_sn[$this->id_stock]->sn AS $sn => $qte){
					$row=$this->create_row();
					for($j=0;$j<$this->nb_entete_colonne;$j++)
					$this->create_cell('',$row);
					$this->create_cell($sn,$row);
					$this->create_cell($qte,$row);
				}
			}
                        $article_lot = $art->getLot();
                        //_vardump($article_lot);
		}
	if($i==count($this->contenu)-1){
		$row=$this->create_row();
		$this->create_cellbold('Sous total : ',$row);
		$cell = new odsTableCellString(utf8_encode($lib_art_categ));
		$cell->setNumberColumnsSpanned(2);
		$row->addCell( $cell );
		$this->create_cell('Quantité total :',$row);
		$this->create_cellFloat($this->totaux_qte,$row);
		if($_REQUEST['aff_pa']==1){
			$this->create_cell('Prix total :',$row);
			$this->create_celleuro($this->totaux_prix,$row);
			}
		}
	}
}
	public function create_cell($contenu, $row){
		$cell=$row->addCell( new odsTableCellString(utf8_encode($contenu)));
		return $cell;
	}
	public function create_cellbold($contenu, $row){
		$style = new odsStyleTableCell();
		$style->setFontWeight('bold');
		$cell=$row->addCell( new odsTableCellString(utf8_encode($contenu), $style));
		return $cell;
	}
	public function create_cellfloat($contenu, $row){
		$cell=$row->addCell( new odsTableCellFloat(utf8_encode($contenu)));
		return $cell;
	}
	public function create_cellfloatRed($contenu, $row){
		$style = new odsStyleTableCell();
		$style->setColor('#ff0000');
		$cell=$row->addCell( new odsTableCellFloat(utf8_encode($contenu),$style));
		return $cell;
	}
	
	public function create_cellspan($contenu, $row, $nb){
		$cell = new odsTableCellString(utf8_encode($contenu));
		$cell->setNumberColumnsSpanned($nb);
		$row->addCell( $cell );
		return $cell;
	}
	
	public function create_row(){
		$this->table->addRow($row = new odsTableRow());
		return $row;
	}
	
	public function create_celleuro($contenu, $row){
		$cell=$row->addCell( new odsTableCellCurrency(utf8_encode($contenu), 'EUR'));
		return $cell;
	}
	
	public function create_cellgrey($contenu, $row){
		$fond_gris = new odsStyleTableCell();
		$fond_gris->setBackgroundColor('#999999');
		$cell=$row->addCell( new odsTableCellString(utf8_encode($contenu), $fond_gris));
		return $cell;
	}
	
public function init(){
global $bdd;
// *************************************************
// Données pour le formulaire && la requete
$form['page_to_show'] = $search['page_to_show'] = 1;
if (isset($_REQUEST['page_to_show'])) {
	$form['page_to_show'] = $_REQUEST['page_to_show'];
	$search['page_to_show'] = $_REQUEST['page_to_show'];
}

$form['orderby'] = $search['orderby'] = "lib_article";
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


$form['ref_art_categ'] = "";
if (isset($_REQUEST['ref_art_categ'])) {
	$form['ref_art_categ'] = $_REQUEST['ref_art_categ'];
	$search['ref_art_categ'] = $_REQUEST['ref_art_categ'];
}
$form['ref_constructeur'] = "";
if (isset($_REQUEST['ref_constructeur'])) {
	$form['ref_constructeur'] = $_REQUEST['ref_constructeur'];
	$search['ref_constructeur'] = $_REQUEST['ref_constructeur'];
}

$form['aff_pa'] = $search['aff_pa'] = 0;
if ($_REQUEST['aff_pa']) {
	$form['aff_pa'] = 1;
	$search['aff_pa'] = 1;
}

$form['emplacement_s'] = "";
if (isset($_REQUEST['emplacement_s'])) {
	$form['emplacement_s'] = $_REQUEST['emplacement_s'];
	$search['emplacement_s'] = $_REQUEST['emplacement_s'];
}

$form['in_stock'] = $search['in_stock'] = 0;
if (isset($_REQUEST['in_stock']) && $_REQUEST['in_stock']) {
	$form['in_stock'] = $_REQUEST['in_stock'];
	$search['in_stock'] = $_REQUEST['in_stock'];
}
	
// *************************************************
// Stock affichés
$form['id_stock'] = array();
if (isset($_REQUEST['id_stock'])) {
	$form['id_stock'] = explode(",", $_REQUEST['id_stock']);
	$search['id_stock'] = explode(",", $_REQUEST['id_stock']);
}



// *************************************************
// Résultat de la recherche
$fiches = array();

	// Préparation de la requete
	$query_select = "";
	$query_join 	= "";
	$query_where 	= " dispo = 1 && a.lot != '2' && a.modele = 'materiel' ";
	$query_group	= "";

	// Catégorie
	if ($search['ref_art_categ']) { 
		$query_where 	.= " && a.ref_art_categ = '".$search['ref_art_categ']."'";
	}
	// Constructeur
	if ($search['ref_constructeur']) { 
		$query_where 	.= " && a.ref_constructeur = '".$search['ref_constructeur']."'";
	}
	// Prix d'achat
	if ($search['aff_pa']) {
		$query_select 	.= ",  a.prix_achat_ht, a.paa_ht ";
	}

		// Emplacement
	if ($search['emplacement_s']) { 
	$query_select 	.= ", asa.emplacement";
	$query_join 	.= " LEFT JOIN articles_stocks_alertes asa ON a.ref_article = asa.ref_article";
	$query_where 	.= " && lower(asa.emplacement) LIKE lower('%".$search['emplacement_s']."%')";
	}
	
        // Sélection des stocks disponibles
        $where_stock = "";
        $where_instock = "";
        if ($search['id_stock'] && $search['id_stock'][0] != "") {
                $where_stock .= " && (";
                $i = 0;
                foreach ($search['id_stock'] as $stock) {
                        if ($i != 0) { $where_stock .= " || ";}
                        $where_stock .= " sa.id_stock = '".$stock."'";
                        if ($i != 0) { $where_instock .= " || ";}
                        $where_instock .= " sa.id_stock = '".$stock."'";
                        $i ++;
                }
                $where_stock .= " ) ";
        }
		
	// stock non null
	if ($search['in_stock'] == 1) {
		$query_join 	.= " LEFT JOIN stocks_articles sa ON a.ref_article = sa.ref_article";
		$query_where 	.=  " && sa.qte < 0 ".$where_stock." ";
		$query_group	.= "GROUP BY a.ref_article, sa.ref_article ";
	}
	// stock positif
	if ($search['in_stock'] == 2) {
		$query_join 	.= " LEFT JOIN stocks_articles sa ON a.ref_article = sa.ref_article";
		$query_where 	.=  " && sa.qte > 0 ".$where_stock." ";
		$query_group	.= "GROUP BY a.ref_article, sa.ref_article ";
	}
	// Ajustement pour faire fonctionner le comptage
	$count_query_join 	= $query_join;

	if ($query_where) { $query_where .= " && "; }
	$query_where 	.= " a.variante != 2";
	
	// Recherche
	$query = "SELECT a.ref_article, a.ref_oem, a.ref_interne, a.lib_article, 
									 a.ref_constructeur, ann.nom nom_constructeur, a.dispo, a.date_fin_dispo, a.modele, a.lot, 
									 ac.lib_art_categ, t.tva, ia.lib_file, a.prix_public_ht, acb.code_barre
									 ".$query_select."

						FROM articles a
							LEFT JOIN tvas t ON t.id_tva = a.id_tva
							LEFT JOIN annuaire ann ON a.ref_constructeur = ann.ref_contact 
							LEFT JOIN art_categs ac ON a.ref_art_categ = ac.ref_art_categ 
							LEFT JOIN articles_images ai ON ai.ref_article = a.ref_article && ai.ordre = 1
							LEFT JOIN images_articles ia ON ia.id_image= ai.id_image
							LEFT JOIN articles_codes_barres acb ON a.ref_article= acb.ref_article
							".$query_join."
						WHERE ".$query_where."
						".$query_group."
						ORDER BY lib_art_categ";
	$resultat = $bdd->query($query);
	while ($fiche = $resultat->fetchObject()) {
	
		$fiche->stocks = array();
		$query = "SELECT sa.id_stock, sa.qte,  asa.seuil_alerte
							FROM stocks_articles sa
								LEFT JOIN articles_stocks_alertes asa ON sa.id_stock = asa.id_stock && asa.ref_article = '".$fiche->ref_article."'
							WHERE sa.ref_article = '".$fiche->ref_article."' ".$where_stock;
							//echo $query;
		$resultat2 = $bdd->query ($query);
		while ($var = $resultat2->fetchObject()) { $fiche->stocks[$var->id_stock] = $var; }

		$fiche->pv = array();
		$query = "SELECT at.id_tarif, at.pu_ht, tl.lib_tarif
							FROM articles_tarifs at
								LEFT JOIN tarifs_listes tl ON at.id_tarif = tl.id_tarif
							WHERE at.ref_article = '".$fiche->ref_article."' ";
							//echo $query;
		$resultat3 = $bdd->query ($query);
		while ($var = $resultat3->fetchObject()) { $fiche->pv[$var->id_tarif] = $var; }
		
		$fiches[] = $fiche; 
	}
	unset ($fiche, $resultat, $query);

	// Comptage des résultats
	$query = "SELECT a.ref_article
						FROM articles a 
							".$count_query_join."
						WHERE ".$query_where."
						GROUP BY a.ref_article ";
	$resultat = $bdd->query($query); 
	while ($result = $resultat->fetchObject()) { $nb_fiches += 1;  }
	unset ($result, $resultat, $query);

	return $fiches;
	}

}
?>