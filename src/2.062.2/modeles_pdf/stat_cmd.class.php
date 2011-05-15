<?php

class pdf_stat_cmd {
	var $code_pdf_modele = "stat_cmd";
	var $pdf;
	var $ca_day;
	var $ca_week;
	var $ca_month;
	var $histo_ventes_m;
	var $sousTotaux;
		
	public function pdf_stat_cmd(&$pdf) {
		global $STAT_STANDARD;
		global $PDF_MODELES_DIR;
		
		include ($PDF_MODELES_DIR."config/".$this->code_pdf_modele.".config.php");
		
		foreach ($STAT_STANDARD as $var => $valeur) {
				$this->{$var} = $valeur;
		}
		$this->pdf = $pdf;
		$this->qte_cmd_loaded = false;
	}
	
	public function create_header() {		
		$this->pdf->lMargin = 15;
		$this->pdf->SetFont("Arial","B",15);
		$this->pdf->Ln(0);
		$this->pdf->Cell(70,10,"Quantité commandée par article",0,1,"L");
		$this->pdf->Ln(20);
	
	} 
	
	public function create_footer() {
		  	$this->pdf->SetTextColor(0);
			$this->pdf->SetY(190);
		    //Arial italic 8
		    $this->pdf->SetFont("Arial","I",8);
		    //Page number
		    $this->pdf->Cell(0,10,"Page ".$this->pdf->PageNo()."/{nb}",0,0,"C");
		    $this->pdf->Ln();
	}
	
	public function writePdf() {	
		$this->pdf->AliasNbPages();
		$this->pdf->SetAutoPageBreak(true,$this->MARGE_BAS);
		$this->pdf->AddPage("L"); //paysage
		$this->pdf->SetFont('Times','',12);
		$this->pdf->SetFillColor(0, 255, 0);
		$this->create_header();
		$this->TableauCA();
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
		
		//DEBUT de l'édition du tableau CA
		$this->pdf->SetFillColor(0,0,0);            //fond noir
	    $this->pdf->SetTextColor(255,255,255);      //texte blanc
	    $this->pdf->SetDrawColor(0,0,0);
	    $this->pdf->SetLineWidth(.3);
	    $this->pdf->SetFont('Arial','B','7');
				
		$this->create_entete();

		$this->create_lines_articles();
		
		
		//DEBUT ligne des totaux
		$this->pdf->SetFillColor(0,0,0);            //fond noir
	    $this->pdf->SetTextColor(255,255,255);      //texte blanc
	    
	    $this->pdf->Cell($this->LARGEUR_CELL_LIB,6,"Total Général",1,0,'L',1);
	    $qte_total = 0;
	 	for($y=$_REQUEST['annee_date_deb']; $y<=$_REQUEST['annee_date_fin'] ; ++$y ){
	    	
	    	if($y==$_REQUEST['annee_date_fin']){ $mois_max = $_REQUEST['mois_date_fin']; }
	    	else{ $mois_max = 12; }
	       	if($y==$_REQUEST['annee_date_deb']){ $mois_deb = $_REQUEST['mois_date_deb']; }
	    	else{ $mois_deb = 1; }
	    	//affichage des totaux par mois
	    	for($m=$mois_deb; $m<=$mois_max ; ++$m ){
	    		$qte = $this->get_qte_cmd($y,$m);
	    		$this->pdf->Cell($this->LARGEUR_CELL_MOIS,6,$qte,'LR',0,'R',1);
	    		$qte_total += $qte;
		   	}
	    }
		$this->pdf->Cell($this->LARGEUR_CELL_TOTAL,6,$qte_total,'LR',0,'R',1);
		$this->pdf->Ln();
	    //FIN ligne des totaux	
	    $this->create_footer();
		
	}
	
	//Création de l'entête du tableau
 	protected function create_entete(){
 		$this->pdf->SetFillColor(0,0,0);            //fond noir
	    $this->pdf->SetTextColor(255,255,255);      //texte blanc
	    $this->pdf->SetFont('Arial','B','7');
	    $this->pdf->Cell($this->LARGEUR_CELL_LIB,6,"Chiffre d'affaires",1,0,'L',1); //colonne libellé
	    for($y=$_REQUEST['annee_date_deb']; $y<=$_REQUEST['annee_date_fin'] ; ++$y ){
	    	
	    	if($y==$_REQUEST['annee_date_fin']){ $mois_max = $_REQUEST['mois_date_fin']; }
	    	else{ $mois_max = 12; }
	       	if($y==$_REQUEST['annee_date_deb']){ $mois_deb = $_REQUEST['mois_date_deb']; }
	    	else{ $mois_deb = 1; }
	    	//affichage des mois
	       	for($m=$mois_deb; $m<=$mois_max ; ++$m ){
	    		$this->pdf->Cell($this->LARGEUR_CELL_MOIS,6,$this->getLib_mois($m)."-".substr($y, -2),1,0,'C',1);
	    	}
	    }
	    $this->pdf->Cell($this->LARGEUR_CELL_TOTAL,6,"Total ",1,0,'C',1); //colonne total
		$this->pdf->Ln();
	
    }
    
    
	//creer les lignes de sous Totaux concernant les articles fils de la racine
	//et appelle create_line_categ pour chacun de leurs fils
	protected function create_lines_articles(){
	
		global $bdd;
			
		$query = "SELECT ref_article, lib_article
							FROM articles";
		$resultat = $bdd->query ($query);
		while ($var = $resultat->fetchObject()) {
			$article[$var->ref_article] = $var->lib_article;
		}
		
		foreach ($article as $ref_art => $lib_art) {  
		
				if($this->pdf->getY() > $this->HAUTEUR_FEUILLE - $this->MARGE_BAS - 37){	
					$this->create_footer();
					$this->create_header();
					$this->create_entete();
				}
				
				$this->pdf->SetTextColor(0);  //texte noir
				$this->pdf->SetFillColor(204);//fond gris
					
				$this->create_line_tableauCA($this, $ref_art ,$lib_art); //on affiche la ligne
				
		
		}
	}
	
	/*	$super : pointeur vers la class courante ($this)
	 * 	$ref_art : reference de l'article
	 *  $lib_art : libellé de la categorie d'article
	 *  Requière $_REQUEST['annee_date_deb'], $_REQUEST['mois_date_deb'], $_REQUEST['mois_date_fin'] et $_REQUEST['annee_date_fin']
	 */
	protected function create_line_tableauCA($super, $ref_art , $lib_art){
		
		$qte_total = 0;
		for($y=$_REQUEST['annee_date_deb']; $y<=$_REQUEST['annee_date_fin'] ; ++$y ){
    
	    	if($y==$_REQUEST['annee_date_fin']){ $mois_max = $_REQUEST['mois_date_fin']; }
	    	else{ $mois_max = 12; }
	 		if($y==$_REQUEST['annee_date_deb']){ $mois_deb = $_REQUEST['mois_date_deb']; }
    		else{ $mois_deb = 1; }
    		
    		for($m=$mois_deb; $m<=$mois_max ; ++$m ){
    			$qte[$y][$m] = $this->get_qte_cmd_mensuel($ref_art,$y,$m);
    			$qte_total += $qte[$y][$m] ;                  
    		}
    		
	 	}
		
	 	if($qte_total != 0){
			$super->pdf->Cell($this->LARGEUR_CELL_LIB,6,$lib_art,'LR',0,'L',1);   
			
		 	foreach($qte as $annee){
		 		foreach($annee as $mois){
	    			$this->pdf->SetFillColor(255,255,255);          
		  			$this->pdf->SetTextColor(0);    
	    			$super->pdf->Cell($this->LARGEUR_CELL_MOIS,6,$mois,'LR',0,'R',1); 
	  			           
	    		}
	    		
		 	}
		 	//total
		 	$this->pdf->SetTextColor(0);  //texte noir
			$this->pdf->SetFillColor(204);//fond gris
		 	$super->pdf->Cell($this->LARGEUR_CELL_TOTAL,6,$qte_total,'LR',1,'R',1);
	 	}
	
	 
	}

		

  	
  	
  
	
	//**************************************************
	// FONCTION DE RECUPERATION DES INFORMATIONS
	
	protected function charger_qte_cmd(){
		//creer un tableau contenant la quantité commander par mois et par categorie d'article
		global $bdd;
		
		$query = "SELECT dl.ref_article, doc.date_creation_doc as date, dl.ref_article, dl.qte
						FROM doc_cdc dc
							LEFT JOIN documents doc ON doc.ref_doc = dc.ref_doc
							LEFT JOIN docs_lines dl ON dl.ref_doc = dc.ref_doc
						WHERE doc.id_etat_doc = 10 OR doc.id_etat_doc = 9";
		$resultat = $bdd->query ($query);

		while ($line = $resultat->fetchObject()) { 
			$line->date = date_parse($line->date);
			
			if(empty($this->qte_cmd[$line->ref_article][$line->date['year']][$line->date['month']])){
				$this->qte_cmd[$line->ref_article][$line->date['year']][$line->date['month']] = 0;
			}
			$this->qte_cmd[$line->ref_article][$line->date['year']][$line->date['month']] += $line->qte;
		}
		
		$this->qte_cmd_loaded = true;
	}
	
	protected function get_qte_cmd_mensuel($ref_article, $annee, $mois){
		//retourne la quantité
		if(!$this->qte_cmd_loaded){ $this->charger_qte_cmd(); }
		if(empty($this->qte_cmd[$ref_article][$annee][$mois])){ return 0; }
		return $this->qte_cmd[$ref_article][$annee][$mois];
	} 
	
	protected function get_qte_cmd($annee_deb, $mois_deb){
		//retourne la quantité
		if(!$this->qte_cmd_loaded){ $this->charger_qte_cmd(); }
		if(empty($this->qte_cmd)){ return 0; }
		
		$res = 0;
		foreach($this->qte_cmd as $line){
			if(!empty($line[$annee_deb][$mois_deb])){ $res += $line[$annee_deb][$mois_deb]; }
		}
			
		return $res;
		
	} 
	
	
	
	//************************************************
	// FONCTION DIVERSE
  	
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