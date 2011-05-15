<?php

// Load library
require_once('../ressources/ods/ods.php');

class ods_stat_standard {
	var $code_ods_modele = "stat_standard";
	var $ods;
	var $ca_day;
	var $ca_week;
	var $ca_month;
	var $histo_ventes_m;
	var $sousTotaux;
		
	public function ods_stat_standard() {
		global $ODS_MODELES_DIR;
		
		// Create Ods object
		$this->ods  = new ods();
		// Liste cmd non chargé
		$this->qte_cmd_loaded = false;

		// Create table
		$this->table = new odsTable('Statistique de vente');
		
		$this->create_titre();
		$this->create_stylecol("10cm");
		$this->TableauCA();
		
		//Ajout de la table
		$this->ods->addTable($this->table);
		
		// Download the file
		$this->ods->downloadOdsFile("Chiffre d'affaires par catégories d'articles.ods");
		
	}
	
	public function create_titre() {
		//titre
		$titre = new odsStyleTableCell();
		$titre->setFontWeight('bold');
		$titre->setFontSize("18pt");
		
		// Titre
		$row = new odsTableRow();
		$cell = new odsTableCellString(utf8_encode("Chiffre d'affaires par catégories d'articles"), $titre);
		$cell->setNumberColumnsSpanned(4);
		$row->addCell( $cell );
		$this->table->addRow($row);
		$row = new odsTableRow();
		$this->table->addRow($row);
	} 
	
	public function create_entete() {
		//Création de l'entête du tableau
		$fond_gris = new odsStyleTableCell();
		$fond_gris->setBackgroundColor('#999999');
	
		$this->table->addRow($row = new odsTableRow());
		$row->addCell( new odsTableCellString("Chiffre d'affaires", $fond_gris));
	
    for($y=$_REQUEST['annee_date_deb']; $y<=$_REQUEST['annee_date_fin'] ; ++$y ){
    	
    	if($y==$_REQUEST['annee_date_fin']){ $mois_max = $_REQUEST['mois_date_fin']; }
    	else{ $mois_max = 12; }
       	if($y==$_REQUEST['annee_date_deb']){ $mois_deb = $_REQUEST['mois_date_deb']; }
    	else{ $mois_deb = 1; }
		
    	//affichage des mois
       	for($m=$mois_deb; $m<=$mois_max ; ++$m ){
			$row->addCell( new odsTableCellString(utf8_encode($this->getLib_mois($m)."-".substr($y, -2)), $fond_gris));
	}
	}
	$row->addCell( new odsTableCellString(utf8_encode('Total'), $fond_gris));
	}
	
	public function create_cell($contenu, $row){
		$cell=$row->addCell( new odsTableCellString(utf8_encode($contenu)));
		return $cell;
	}
	
	public function create_celleuro($contenu, $row){
		$cell=$row->addCell( new odsTableCellCurrency(utf8_encode($contenu), 'EUR'));
		return $cell;
	}
	
	public function create_celleuroblue($contenu, $row){
		$fond_bleu = new odsStyleTableCell();
		$fond_bleu->setBackgroundColor('#CCFFFF');
		$cell=$row->addCell( new odsTableCellCurrency(utf8_encode($contenu), 'EUR', $fond_bleu));
		return $cell;
	}
	
	public function create_celleurogrey($contenu, $row){
		$fond_bleu = new odsStyleTableCell();
		$fond_bleu->setBackgroundColor('#999999');
		$cell=$row->addCell( new odsTableCellCurrency(utf8_encode($contenu), 'EUR', $fond_bleu));
		return $cell;
	}
	
	public function create_cellgrey($contenu, $row){
		$fond_gris = new odsStyleTableCell();
		$fond_gris->setBackgroundColor('#999999');
		$cell=$row->addCell( new odsTableCellString(utf8_encode($contenu), $fond_gris));
		return $cell;
	}
	
	public function create_cellblue($contenu, $row){
		$fond_bleu = new odsStyleTableCell();
		$fond_bleu->setBackgroundColor('#CCFFFF');
		$cell=$row->addCell( new odsTableCellString(utf8_encode($contenu), $fond_bleu));
		return $cell;
	}
	
	public function create_row(){
		$this->table->addRow($row = new odsTableRow());
		return $row;
	}
	
	public function create_stylecol($cm){
	//nb colonne de taille cm   
	$stylecol = new odsStyleTableColumn();
	$stylecol->setColumnWidth($cm);
	$col1 = new odsTableColumn($stylecol);
	$this->table->addTableColumn($col1);
	}
	
	//Tableau coloré
	public function TableauCA(){

		//intialisation des sous totaux
		for($y=$_REQUEST['annee_date_deb']; $y<=$_REQUEST['annee_date_fin'] ; ++$y ){
	    	
	    	if($y==$_REQUEST['annee_date_fin']){ $mois_max = $_REQUEST['mois_date_fin']; }
	    	else{ $mois_max = 12; }
	       	if($y==$_REQUEST['annee_date_deb']){ $mois_deb = $_REQUEST['mois_date_deb']; }
	    	else{ $mois_deb = 1; }
	    	//affichage des mois
    		for($m=$mois_deb; $m<=$mois_max ; ++$m ){
    			$this->sousTotaux[$m.' '.$y] = 0;                     
    		}
		}		
						
		$this->create_entete();
	   
		$this->create_line_categ_racine();
				
		//DEBUT ligne des totaux
	    
		$row=$this->create_row();
		$this->create_cellgrey("Total Général",$row);
	 	for($y=$_REQUEST['annee_date_deb']; $y<=$_REQUEST['annee_date_fin'] ; ++$y ){
	    	
	    	if($y==$_REQUEST['annee_date_fin']){ $mois_max = $_REQUEST['mois_date_fin']; }
	    	else{ $mois_max = 12; }
	       	if($y==$_REQUEST['annee_date_deb']){ $mois_deb = $_REQUEST['mois_date_deb']; }
	    	else{ $mois_deb = 1; }
	    	//affichage des totaux par mois
	    	for($m=$mois_deb; $m<=$mois_max ; ++$m ){
	    		if($m==12){ $m_fin=1; $y_fin=$y+1; }else{$m_fin=$m+1; $y_fin = $y ;}
	    		$soustotal=(charger_doc_CA (array((date("Y-m-d H:i:s", mktime(0,0,0,$m, 0, $y) ) ) , (date("Y-m-d H:i:s", mktime(23,59,59, $m_fin,0, $y_fin) ) )) ));
				$this->create_celleurogrey($soustotal,$row);
		   	}
	    }
		if($_REQUEST['mois_date_fin']==12){ $m_fin=1; $y_fin=$_REQUEST['annee_date_fin']+1; }else{$m_fin=$_REQUEST['mois_date_fin']+1; $y_fin = $_REQUEST['annee_date_fin'] ;}
		$total=(charger_doc_CA (array((date("Y-m-d H:i:s", mktime(0,0,0,$_REQUEST['mois_date_deb'], 1, $_REQUEST['annee_date_deb']) ) ) , (date("Y-m-d H:i:s", mktime(23,59,59, $m_fin ,0, $y_fin) ) )) ));
		$this->create_celleurogrey($total,$row);
	    //FIN ligne des totaux	
	   
		
	}    
    
	//creer les lignes de sous Totaux concernant les articles fils de la racine
	//et appelle create_line_categ pour chacun de leurs fils
	protected function create_line_categ_racine(){
		$list_racine = get_art_categs_racine ();
		foreach ($list_racine as $categ) {  //on parcourt les catégories racines
			$type_data["art_categ"] = $categ->ref_art_categ;
			$cat = new art_categ($type_data["art_categ"]); 
			$liste_fils = '';
			$tab_fils = $this->get_direct_child_categories($liste_fils, $cat->getRef_art_categ()); //on attrape les fils de la catag racine courante
			
			if ((isset($tab_fils)) && ($tab_fils != '')) {
				//ligne total par categorie
				
				if(count($tab_fils)>1){
					$this->create_line_sous_total_tableauCA($this, $type_data , 'Total - '.$cat->getLib_art_categ(), true); //on affiche la ligne
					// on écrit la ligne pour chaque fils
					foreach ($tab_fils as $fils) {  //on parcourt les fils
						if($fils != '' && $fils != $type_data["art_categ"]){ //test si non egal à la categorie parente
							//on écrit les fils 
							$this->create_line_categ($fils, '   ');
						}else if($fils != ''){
							$this->create_line_tableauCA($this, $type_data , '   '.$cat->getLib_art_categ());
						}
					}
				}else{
					$this->create_line_sous_total_tableauCA($this, $type_data , 'Total - '.$cat->getLib_art_categ(), true); //on affiche la ligne
					// on écrit la ligne pour chaque fils
				}		
				
			}
		}
	}
	
	protected function create_line_categ($categ, $niveau = ''){
		$type_data["art_categ"] = $categ;
		$cat = new art_categ($categ); 
		$liste_fils = '';
		$tab_fils = $this->get_direct_child_categories($liste_fils, $cat->getRef_art_categ()); //on attrape les fils de la catag racine courante
				
		if ((isset($tab_fils)) && ($tab_fils != '')) {
			//ligne total par categorie
			if(count($tab_fils)>1){	
				$this->create_line_sous_total_tableauCA($this, $type_data , $niveau.'Total - '.$cat->getLib_art_categ()); //on affiche la ligne
				// on écrit la ligne pour chaque fils
				$niveau = $niveau.'   ';
				foreach ($tab_fils as $fils) {  //on parcourt les fils
					if($fils != '' && $fils != $categ){
						//on écrit les fils 
						$this->create_line_categ($fils, $niveau);
					}else if($fils != ''){
						$this->create_line_tableauCA($this, $type_data ,  $niveau.$cat->getLib_art_categ()); 
					}
				}		
			}else{
				$this->create_line_tableauCA($this, $type_data ,  $niveau.$cat->getLib_art_categ());
			}		
		}
	}
	
	
	/*	$super : pointeur vers la class courante ($this)
	 * 	$type_data : categorie d'article 
	 *  $lib_art_categ : libellé de la categorie d'article
	 *  $cell_width : tableau contenant la taille des cellules libellé, mois et total respectivement $this->LARGEUR_CELL_LIB, $this->LARGEUR_CELL_MOIS et $this->LARGEUR_CELL_TOTAL.
	 *  Requière $_REQUEST['annee_date_deb'], $_REQUEST['mois_date_deb'], $_REQUEST['mois_date_fin'] et $_REQUEST['annee_date_fin']
	 */
	protected function create_line_tableauCA($super, $type_data , $lib_art_categ){
		$soustotal=0;
		$row=$this->create_row();
		$this->create_cell($lib_art_categ,$row);
	 	for($y=$_REQUEST['annee_date_deb']; $y<=$_REQUEST['annee_date_fin'] ; ++$y ){
    
	    	if($y==$_REQUEST['annee_date_fin']){ $mois_max = $_REQUEST['mois_date_fin']; }
	    	else{ $mois_max = 12; }
	 		if($y==$_REQUEST['annee_date_deb']){ $mois_deb = $_REQUEST['mois_date_deb']; }
    		else{ $mois_deb = 1; }
    		
    		for($m=$mois_deb; $m<=$mois_max ; ++$m ){
    			if($m==12){ $m_fin=1; $y_fin=$y+1; }else{$m_fin=$m+1; $y_fin = $y ;}
    			$ca = charger_doc_CA (array((date("Y-m-d H:i:s", mktime(0,0,0,$m, 1, $y) ) ) , (date("Y-m-d H:i:s", mktime(23,59,59, $m_fin,0, $y_fin) ) )),$type_data);
				$this->create_celleuro($ca,$row); 
    			$soustotal=$soustotal+$ca;                      
    		}
    		
	 	}
	 	//total
	 	if($_REQUEST['mois_date_fin']==12){ $m_fin=1; $y_fin=$_REQUEST['annee_date_fin']+1; }else{$m_fin=$_REQUEST['mois_date_fin']+1; $y_fin = $_REQUEST['annee_date_fin'] ;}
		$this->create_celleuro($soustotal,$row);
	
	}

		
	/*	$super : pointeur vers la class courante ($this)
	 * 	$tab_fils : tableau indexé de 0 à n contenant la référence vers les fils de la categorie d'article
	 * 	$type_data : référence categorie d'article 
	 *  $lib_art_categ : libellé de la categorie d'article
	 *  $cell_width : tableau contenant la taille des cellules libellé, mois et total respectivement $this->LARGEUR_CELL_LIB, $this->LARGEUR_CELL_MOIS et $this->LARGEUR_CELL_TOTAL.
	 *  $_REQUEST : $_REQUEST --- Requière $_REQUEST['annee_date_deb'], $_REQUEST['mois_date_deb'], $_REQUEST['mois_date_fin'] et $_REQUEST['annee_date_fin']
	 */
	protected function create_line_sous_total_tableauCA($super, $type_data , $lib_art_categ, $addSousTotal = false){
		$liste_fils = '';
		$cat = new art_categ($type_data['art_categ']);
		$tab_fils = get_child_categories($liste_fils, $cat->getRef_art_categ()); //on attrape les fils de la catag racine courante
		
		$row=$this->create_row();
		$this->create_cellblue($lib_art_categ,$row);
		
	 	for($y=$_REQUEST['annee_date_deb']; $y<=$_REQUEST['annee_date_fin'] ; ++$y ){
    
	    	if($y==$_REQUEST['annee_date_fin']){ $mois_max = $_REQUEST['mois_date_fin']; }
	    	else{ $mois_max = 12; }
	 		if($y==$_REQUEST['annee_date_deb']){ $mois_deb = $_REQUEST['mois_date_deb']; }
    		else{ $mois_deb = 1; }
    		
    		$i = 0;
    		for($m=$mois_deb; $m<=$mois_max ; ++$m ){
    			if($m==12){ $m_fin=1; $y_fin=$y+1; }else{$m_fin=$m+1; $y_fin = $y ;}
    			$ca = 0;
    			foreach ($tab_fils as $fils) {  //on parcourt les fils
					//on écrit les fils 
					$fi = new art_categ ($fils); 
					$type_data["art_categ"] = $fils;
					$ca += charger_doc_CA (array((date("Y-m-d H:i:s", mktime(0,0,0,$m, 1, $y) ) ) , (date("Y-m-d H:i:s", mktime(23,59,59, $m_fin,0, $y_fin) ) )) ,$type_data);			
    			}
    			if($addSousTotal){
    				$this->sousTotaux[$m.' '.$y] += $ca;
    			}
    			$this->create_celleuroblue($ca,$row);  
    			++$i;                      
    		}
    		
	 	}
	 	//total
	 	$ca = 0;
	 	if($_REQUEST['mois_date_fin']==12){ $m_fin=1; $y_fin=$_REQUEST['annee_date_fin']+1; }else{$m_fin=$_REQUEST['mois_date_fin']+1; $y_fin = $_REQUEST['annee_date_fin'] ;}
	 	foreach ($tab_fils as $fils) {  //on parcourt les fils
			//on écrit les fils 
			$fi = new art_categ ($fils); 
			$type_data["art_categ"] = $fils;
			$ca += charger_doc_CA (array((date("Y-m-d H:i:s", mktime(0,0,0,$_REQUEST['mois_date_deb'],1 , $_REQUEST['annee_date_deb']) ) ) , (date("Y-m-d H:i:s", mktime(23,59,59, $m_fin ,0, $y_fin) ) )) ,$type_data);
    	}
	 	$this->create_celleuroblue($ca, $row); 
  	}//fin function create_line_sous_total_tableauCA
  	
  	
  	//Création du ligne de sous total 
	protected function sous_total_feuille(){
		//DEBUT totaux par feuille
		/*$this->ods->SetFillColor(0,0,0);            //fond noir
	    $this->ods->SetTextColor(255,255,255);      //texte blanc
	    
	    $this->ods->Cell($this->LARGEUR_CELL_LIB,6,"Sous Total Feuille",1,0,'L',1);
	    $total = 0;
	    for($y=$_REQUEST['annee_date_deb']; $y<=$_REQUEST['annee_date_fin'] ; ++$y ){
	    	
	    	if($y==$_REQUEST['annee_date_fin']){ $mois_max = $_REQUEST['mois_date_fin']; }
	    	else{ $mois_max = 12; }
	       	if($y==$_REQUEST['annee_date_deb']){ $mois_deb = $_REQUEST['mois_date_deb']; }
	    	else{ $mois_deb = 1; }
	    	//affichage des mois
    		for($m=$mois_deb; $m<=$mois_max ; ++$m ){
	    		$this->ods->Cell($this->LARGEUR_CELL_MOIS,6,price_format($this->sousTotaux[$m.' '.$y])." €",'LR',0,'R',1);
	    		$total += $this->sousTotaux[$m.' '.$y];
	    		$this->sousTotaux[$m.' '.$y] = 0;
    		}
    	}
	    $this->ods->Cell($this->LARGEUR_CELL_TOTAL,6,price_format($total)." €",'LR',0,'R',1);
		$this->ods->Ln();*/
	    //FIN totaux par feuille	
	   
	}
  	
	protected function getLib_mois($i){
		switch ($i){
			case 1 : return "janvier"; break;
			case 2 : return "février"; break;
			case 3 : return "mars"; break;
			case 4 : return "avril"; break;
			case 5 : return "mai"; break;
			case 6 : return "juin"; break;
			case 7 : return "juillet"; break;
			case 8 : return "août"; break;
			case 9 : return "septembre"; break;
			case 10 : return "octobre"; break;
			case 11 : return "novembre"; break;
			case 12 : return "décembre"; break;
			default : return false; 
		}
	}
	
	protected function get_direct_child_categories($categs, $ref_art_categ = "") {
	global $bdd;
	
	$categs[] = $ref_art_categ;
	
	$query = "SELECT ref_art_categ, ref_art_categ_parent
						FROM art_categs
						WHERE ref_art_categ_parent = '".$ref_art_categ."' 
						";
	$resultat = $bdd->query ($query);
	while ($var = $resultat->fetchObject()) {
		if ($var->ref_art_categ ) {
			$categs[] = $var->ref_art_categ;
		}
	}

	return $categs;
}

}
?>