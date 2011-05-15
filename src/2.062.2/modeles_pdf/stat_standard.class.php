<?php

class pdf_stat_standard {
	var $code_pdf_modele = "stat_standard";
	var $pdf;
	var $ca_day;
	var $ca_week;
	var $ca_month;
	var $histo_ventes_m;
	var $sousTotaux;
		
	public function pdf_stat_standard(&$pdf) {
		global $STAT_STANDARD;
		global $PDF_MODELES_DIR;
		
		include ($PDF_MODELES_DIR."config/".$this->code_pdf_modele.".config.php");
		
		foreach ($STAT_STANDARD as $var => $valeur) {
				$this->{$var} = $valeur;
		}
		$this->pdf = $pdf;
	}
	
	public function create_header() {		
		$this->pdf->lMargin = 15;
		$this->pdf->SetFont("Arial","B",15);
		$this->pdf->Ln(0);
		$this->pdf->Cell(70,10,"Chiffre d'affaires par catégories d'articles",0,0,"L");
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
	   
		$this->create_line_categ_racine();
		
		$this->sous_total_feuille();
		
		//DEBUT ligne des totaux
		$this->pdf->SetFillColor(0,0,0);            //fond noir
	    $this->pdf->SetTextColor(255,255,255);      //texte blanc
	    
	    $this->pdf->Cell($this->LARGEUR_CELL_LIB,6,"Total Général",1,0,'L',1);
	 	for($y=$_REQUEST['annee_date_deb']; $y<=$_REQUEST['annee_date_fin'] ; ++$y ){
	    	
	    	if($y==$_REQUEST['annee_date_fin']){ $mois_max = $_REQUEST['mois_date_fin']; }
	    	else{ $mois_max = 12; }
	       	if($y==$_REQUEST['annee_date_deb']){ $mois_deb = $_REQUEST['mois_date_deb']; }
	    	else{ $mois_deb = 1; }
	    	//affichage des totaux par mois
	    	for($m=$mois_deb; $m<=$mois_max ; ++$m ){
	    		if($m==12){ $m_fin=1; $y_fin=$y+1; }else{$m_fin=$m+1; $y_fin = $y ;}
	    		$this->pdf->Cell($this->LARGEUR_CELL_MOIS,6,price_format(charger_doc_CA (array((date("Y-m-d H:i:s", mktime(0,0,0,$m, 0, $y) ) ) , (date("Y-m-d H:i:s", mktime(23,59,59, $m_fin,0, $y_fin) ) )) ))." €",'LR',0,'R',1);
		   	}
	    }
		if($_REQUEST['mois_date_fin']==12){ $m_fin=1; $y_fin=$_REQUEST['annee_date_fin']+1; }else{$m_fin=$_REQUEST['mois_date_fin']+1; $y_fin = $_REQUEST['annee_date_fin'] ;}
		$this->pdf->Cell($this->LARGEUR_CELL_TOTAL,6,price_format(charger_doc_CA (array((date("Y-m-d H:i:s", mktime(0,0,0,$_REQUEST['mois_date_deb'], 1, $_REQUEST['annee_date_deb']) ) ) , (date("Y-m-d H:i:s", mktime(23,59,59, $m_fin ,0, $y_fin) ) )) ))." €",'LR',0,'R',1);
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
	protected function create_line_categ_racine(){
		$list_racine = get_art_categs_racine ();
		foreach ($list_racine as $categ) {  //on parcourt les catégories racines
		
			$type_data["art_categ"] = $categ->ref_art_categ;
			$cat = new art_categ($type_data["art_categ"]); 
			$liste_fils = '';
			$tab_fils = $this->get_direct_child_categories($liste_fils, $cat->getRef_art_categ()); //on attrape les fils de la catag racine courante
			
			if($this->pdf->getY() > $this->HAUTEUR_FEUILLE - $this->MARGE_BAS - 37){	
				$this->sous_total_feuille();
				$this->create_footer();
				$this->create_header();
				$this->create_entete();
				 
			}
			
			if ((isset($tab_fils)) && ($tab_fils != '')) {
				$this->pdf->SetTextColor(0);  //texte noir
				$this->pdf->SetFillColor(204);//fond gris
				//ligne total par categorie
				
				
				if(count($tab_fils)>1){
					$this->create_line_sous_total_tableauCA($this, $type_data , 'Total - '.$cat->getLib_art_categ(), true); //on affiche la ligne
					$this->pdf->Ln();
					// on écrit la ligne pour chaque fils
					foreach ($tab_fils as $fils) {  //on parcourt les fils
						if($fils != '' && $fils != $type_data["art_categ"]){ //test si non egal à la categorie parente
							//on écrit les fils 
							$this->create_line_categ($fils, '   ');
						}else if($fils != ''){
							$this->pdf->SetTextColor(0);  //texte noir
							$this->pdf->SetFillColor(255); //fond blanc
							$this->create_line_tableauCA($this, $type_data , '   '.$cat->getLib_art_categ());
							$this->pdf->Ln(); 
						}
					}
				}else{
					$this->create_line_sous_total_tableauCA($this, $type_data , 'Total - '.$cat->getLib_art_categ(), true); //on affiche la ligne
					$this->pdf->Ln();
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
		
		if($this->pdf->getY() > $this->HAUTEUR_FEUILLE - $this->MARGE_BAS - 37){	
			$this->sous_total_feuille();
			$this->create_footer();
			$this->create_header();
			$this->create_entete();
			  
		}
		
		if ((isset($tab_fils)) && ($tab_fils != '')) {
			$this->pdf->SetTextColor(0);  //texte noir
			$this->pdf->SetFillColor(235);//fond gris
			//ligne total par categorie
			if(count($tab_fils)>1){
				$this->create_line_sous_total_tableauCA($this, $type_data , $niveau.'Total - '.$cat->getLib_art_categ()); //on affiche la ligne
				$this->pdf->Ln();
				// on écrit la ligne pour chaque fils
				$niveau = $niveau.'   ';
				foreach ($tab_fils as $fils) {  //on parcourt les fils
					if($fils != '' && $fils != $categ){
						//on écrit les fils 
						$this->create_line_categ($fils, $niveau);
					}else if($fils != ''){
						$this->pdf->SetTextColor(0);  //texte noir
						$this->pdf->SetFillColor(255); //fond blanc
						$this->create_line_tableauCA($this, $type_data ,  $niveau.$cat->getLib_art_categ());
						$this->pdf->Ln(); 
					}
				}		
			}else{
				$this->pdf->SetTextColor(0);  //texte noir
				$this->pdf->SetFillColor(255); //fond blanc
				$this->create_line_tableauCA($this, $type_data ,  $niveau.$cat->getLib_art_categ());
				$this->pdf->Ln(); 
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
		
		$super->pdf->Cell($this->LARGEUR_CELL_LIB,6,$lib_art_categ,'LR',0,'L',1);   
	 	for($y=$_REQUEST['annee_date_deb']; $y<=$_REQUEST['annee_date_fin'] ; ++$y ){
    
	    	if($y==$_REQUEST['annee_date_fin']){ $mois_max = $_REQUEST['mois_date_fin']; }
	    	else{ $mois_max = 12; }
	 		if($y==$_REQUEST['annee_date_deb']){ $mois_deb = $_REQUEST['mois_date_deb']; }
    		else{ $mois_deb = 1; }
    		
    		for($m=$mois_deb; $m<=$mois_max ; ++$m ){
    			if($m==12){ $m_fin=1; $y_fin=$y+1; }else{$m_fin=$m+1; $y_fin = $y ;}
    			$ca = charger_doc_CA (array((date("Y-m-d H:i:s", mktime(0,0,0,$m, 1, $y) ) ) , (date("Y-m-d H:i:s", mktime(23,59,59, $m_fin,0, $y_fin) ) )),$type_data);
    			$super->pdf->Cell($this->LARGEUR_CELL_MOIS,6,price_format($ca) ." €",'LR',0,'R',1); 
    			                       
    		}
    		
	 	}
	 	//total
	 	if($_REQUEST['mois_date_fin']==12){ $m_fin=1; $y_fin=$_REQUEST['annee_date_fin']+1; }else{$m_fin=$_REQUEST['mois_date_fin']+1; $y_fin = $_REQUEST['annee_date_fin'] ;}
	 	$super->pdf->Cell($this->LARGEUR_CELL_TOTAL,6,price_format(charger_doc_CA (array((date("Y-m-d H:i:s", mktime(0,0,0,$_REQUEST['mois_date_deb'], 1, $_REQUEST['annee_date_deb']) ) ) , (date("Y-m-d H:i:s", mktime(23,59,59, $m_fin ,0, $y_fin) ) )) ,$type_data))." €",'LR',0,'R',1);
	
	 
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
		
		$super->pdf->Cell(42,6,$lib_art_categ,'LR',0,'L',1);   
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
    			$super->pdf->Cell($this->LARGEUR_CELL_MOIS,6,price_format($ca)." €",'LR',0,'R',1);    
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
	 	$super->pdf->Cell($this->LARGEUR_CELL_TOTAL,6,price_format($ca)." €",'LR',0,'R',1);
  	}//fin function create_line_sous_total_tableauCA
  	
  	
  	//Création du ligne de sous total 
	protected function sous_total_feuille(){
		//DEBUT totaux par feuille
		/*$this->pdf->SetFillColor(0,0,0);            //fond noir
	    $this->pdf->SetTextColor(255,255,255);      //texte blanc
	    
	    $this->pdf->Cell($this->LARGEUR_CELL_LIB,6,"Sous Total Feuille",1,0,'L',1);
	    $total = 0;
	    for($y=$_REQUEST['annee_date_deb']; $y<=$_REQUEST['annee_date_fin'] ; ++$y ){
	    	
	    	if($y==$_REQUEST['annee_date_fin']){ $mois_max = $_REQUEST['mois_date_fin']; }
	    	else{ $mois_max = 12; }
	       	if($y==$_REQUEST['annee_date_deb']){ $mois_deb = $_REQUEST['mois_date_deb']; }
	    	else{ $mois_deb = 1; }
	    	//affichage des mois
    		for($m=$mois_deb; $m<=$mois_max ; ++$m ){
	    		$this->pdf->Cell($this->LARGEUR_CELL_MOIS,6,price_format($this->sousTotaux[$m.' '.$y])." €",'LR',0,'R',1);
	    		$total += $this->sousTotaux[$m.' '.$y];
	    		$this->sousTotaux[$m.' '.$y] = 0;
    		}
    	}
	    $this->pdf->Cell($this->LARGEUR_CELL_TOTAL,6,price_format($total)." €",'LR',0,'R',1);
		$this->pdf->Ln();*/
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