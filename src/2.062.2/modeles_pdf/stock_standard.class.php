<?php
// *************************************************************************************************************
// CLASSE DE GENERATION DE L'ETAT DES STOCKS PDF - 
// *************************************************************************************************************


class pdf_stock_standard extends PDF_etendu {
	var $code_pdf_modele = "stock_standard";
	var $nb_stock_supporter = 1;
	
	//variable transmise par la classe stock
	var $id_stocks;
	var $fiches;						
	var $params;
	
	var $nb_stocks;
	var $stocks;					
	var $date_impression;
	var $lib_doc_entete;
		
	var $nb_pages;
	var $contenu_actuel;
	var $contenu_end_page;
	var $page_actuelle;
	var $content_printed;

	/*
	 * @param $id_stocks	- tableau contenant les id des stocks à afficher
	 * @param $fiches 		- tableau contenant la liste des articles à afficher
	 * @param $infos 		- tableau de paramètre	
	 */
	public function create_pdf ($id_stocks, $fiches, $params) {
		global $PDF_MODELES_DIR;
		global $ETAT_STOCK;
		
		//**********************************************************
		//	TEST SI LE NOMBRE DE STOCKS EST SUPPORTE PAR LE MODEL  *
		//**********************************************************
		$this->nb_stocks = count($id_stocks);
		if($this->nb_stocks>$this->nb_stock_supporter){ 
			echo 'Le nombre de stocks à afficher est supérieur au nombre de stocks affichable par le model.';
			return false;
		}
		//*********************************
		// 	INITIALISATION DES VARIABLES  *
		//*********************************
		
		// ***************************************************
		// Inclusion des variables du fichier de configuration
		include_once ($PDF_MODELES_DIR."config/".$this->code_pdf_modele.".config.php");
		foreach ($ETAT_STOCK as $var => $valeur) {
			$this->{$var} = $valeur;
		}
		
		if($this->nb_stocks>1){
			$this->lib_doc_entete = $this->LIB_DOC_ENTETE_MUTLI;
		}else{
			$this->id_stock = $id_stocks[0];
			$this->lib_doc_entete = $this->LIB_DOC_ENTETE_UNIQUE;
		}
		$this->id_stocks = $id_stocks;
		$this->contenu 	= $fiches;
		$this->params 	= $params;
		
		$this->stocks = array();
		$this->date_impression 	= date("d/m/Y");
		
		
		
		// ***************************************************
		// Initialisation de l'objet PDF
		parent::__construct();
	
		// ***************************************************
		// Initialisation des variables
		$this->nb_pages			= 1;
		$this->contenu_actuel 	= 0;			// Ligne du document en cours de traitement
		$this->contenu_end_page = array();		// Lignes de contenu terminant les différentes pages
		$this->page_actuelle	= 0;
		$this->content_printed	= 0;
		$this->current_ref_art_categ = "";
		$this->totaux_articles 	= array();
		$this->totaux_pieces 	= array();
		$this->totaux_prix 		= 0;
		$this->totaux_generaux_articles = 0;
		$this->totaux_generaux_pieces 	= 0;
		$this->totaux_generaux_prix 	= 0;
		
		if(!isset($this->params['aff_pa'])){ $this->params['aff_pa'] = false; }
		foreach($id_stocks as $id_stock){
			$this->stocks[$id_stock] = new stock($id_stock);
			$this->totaux_articles[$id_stock] 	= 0;
			$this->totaux_pieces[$id_stock]		= 0;
		}
		
		//********************************
		//	CALCUL POUR LA MISE EN PAGE  *
		//********************************
		$this->calcul_largeur_colonne();
		$this->calcul_nb_page();
		
		// ***************************************************
		// Création de la première page                      *
		//****************************************************
		$this->create_pdf_page ();
		return $this;
	}
	
	
	//**********************************************************************
	//CALCUL DE LA LARGEUR DES DIFFERENTES COLONNE ET LA LARGEUR TOTAL
	protected function calcul_largeur_colonne(){
	
		// Affichage des colonnes prix ?
		if (!$this->params['aff_pa']) {
			$this->COL['LARGEUR']['LIB'] += $this->COL['LARGEUR']['PAU'];
			$this->COL['LARGEUR']['LIB'] += $this->COL['LARGEUR']['PT'];
			$this->COL['LARGEUR']['PAU'] = 0;
			$this->COL['LARGEUR']['PT'] = 0;
		}
	
		$this->LARGEUR_TOTALE_CORPS = 0;
		foreach($this->COL['LARGEUR'] as $larg){
			$this->LARGEUR_TOTALE_CORPS  += $larg; 
		}
		
	}
	
	//**********************************************************************
	//CALCUL DU NOMBRE DE PAGES NECESSAIRES
	protected function calcul_nb_page(){
	
		// ***************************************************
		// Comptage du nombre de page nécessaires
		$hauteur_totale = 0;
		for ($i=0; $i<count($this->contenu); $i++) {
	
			//si on change de categorie on ajoute une ligne
			if ($this->current_ref_art_categ != $this->contenu[$i]->ref_art_categ) {
				if ($this->current_ref_art_categ != "") {
					$hauteur_ligne  = $this->HAUTEUR_LINE_TOTAUX_CATEGORIE + $this->HAUTEUR_LINE_VIDE;
					$hauteur_totale += $hauteur_ligne;
				}
				$hauteur_ligne  = $this->HAUTEUR_LINE_CATEGORIE;
				$hauteur_totale += $hauteur_ligne;
				$this->current_ref_art_categ = $this->contenu[$i]->ref_art_categ;
			}
			// Hauteur de la ligne
			$hauteur_ligne = $this->HAUTEUR_LINE_ARTICLE;
	
			// Vérification de la nécessité de changer de page
			$hauteur_totale += $hauteur_ligne;
			if ($hauteur_totale >= $this->CORPS_HAUTEUR_MAX) {
				
				$this->contenu_end_page[] = $old_index;
				$this->nb_pages ++;
				$hauteur_totale = 0;
			}
	
			// Archive de l'index de la ligne
			$old_index = $i;
		}
		$this->current_ref_art_categ = "";
	}
	
	//******************************************
	// Créé une nouvelle page du document PDF
	protected function create_pdf_page () {
		// Comptage du nombre de page
		$this->page_actuelle++;
	
		// Création d'une nouvelle page
		$this->AddPage('L');
		$this->create_pdf_entete ();
		$this->create_pdf_corps ();
		$this->create_pdf_pieds ();
	
		while ($this->page_actuelle < $this->nb_pages) {
			$this->create_pdf_page();
		}
	}
	
	//******************************************
	// Créer l'entete du document PDF
	protected function create_pdf_entete () {
		global $IMAGES_DIR;
	
		// ***************************************************
		// LOGO
		// pas de logo
	
		// ***************************************************
		// TITRE
		$this->SetXY($this->MARGE_GAUCHE, $this->MARGE_HAUT);
		$this->SetFont('Times', 'B', 25);
		$this->Cell (95, 10, $this->lib_doc_entete, 0, 0, 'L');
	
		// ***************************************************
		// Référence du stock
		$this->SetXY($this->MARGE_GAUCHE+1, 27);
		$this->SetFont('Arial', '', 8);
		$stock_lib = "Stock";
		$this->Cell (13, 3, $stock_lib, 0, 0, 'L');
		$this->Cell (3, 3, ":", 0, 0, 'L');
		foreach( $this->stocks as $stock){
			$this->Cell (40, 3, $stock->getLib_stock(), 0, 0, 'L');
		}
	
		// ***************************************************
		// Date du document
		$this->SetXY($this->MARGE_GAUCHE+1, 31);
		$date_lib = "Date";
		$this->Cell (13, 3, $date_lib, 0, 0, 'L');
		$this->Cell (3, 3, ":", 0, 0, 'L');
		$this->Cell (40, 3, $this->date_impression, 0, 0, 'L');
	
		// ***************************************************
		// Numï¿½ro de page
		$this->SetXY(297-$this->MARGE_GAUCHE-30, 31);
		$this->SetFont('Arial', 'I', 8);
		$page_lib = "Page ".$this->page_actuelle." / ".$this->nb_pages;
		$this->Cell (30, 3, $page_lib, 0, 0, 'R');

		return true;
	}
	
	protected function create_pdf_corps () {
	
		$this->decalage_corps_actuel	= 0;
		
		// ***************************************************
		// Contenu du tableau
		for ($i = $this->contenu_actuel; $i<count($this->contenu); $i++) {
			//si on change de categorie on change de page
			if ($this->current_ref_art_categ != $this->contenu[$i]->ref_art_categ) {
	
				if ($this->current_ref_art_categ != "") {
					$line = new stdClass();
					$line->type_of_line = "totaux_categorie";
					$this->create_pdf_corps_line($line);
					$line = new stdClass();
					$line->type_of_line = "vide";
					$this->create_pdf_corps_line($line);
				/*$this->totaux_articles[$id_stock] = 0;
				$this->totaux_pieces[$this->id_stock] = 0;
				$this->totaux_prix = 0;*/
				}
				
				$line = new stdClass();
				$line->type_of_line = "categorie";
				$line->lib_art_categ = $this->contenu[$i]->lib_art_categ;
				if ($this->GetStringWidth($line->lib_art_categ) >= ($this->COL['LARGEUR']['LIB']+$this->COL['LARGEUR']['REF'])-$this->MARGE_GAUCHE-1) {
				while ($this->GetStringWidth("...".$line->lib_art_categ) >= ($this->COL['LARGEUR']['LIB']+$this->COL['LARGEUR']['REF'])-$this->MARGE_GAUCHE-1) {
					$line->lib_art_categ = substr ($line->lib_art_categ, 1);
				}
				$line->lib_art_categ = "...".$line->lib_art_categ;
				}
				$this->create_pdf_corps_line($line);
				
				$this->current_ref_art_categ = $this->contenu[$i]->ref_art_categ;
			}
			
			$line = $this->contenu[$i];
					
			$line->type_of_line = "article";
			if (isset($this->contenu[$i]->qte)) {
				$line->qte = $this->contenu[$i]->qte;
			} else {
				$line->qte = 0;
			}
			$this->create_pdf_corps_line($line);
			/*if($this->aff_info_tracab){
				$art = new article($line->ref_article);
				$art_stock_sn = $art->getStocks_arti_sn ();
				if(!empty($art_stock_sn[$this->id_stock]->sn)){
					foreach($art_stock_sn[$this->id_stock]->sn AS $sn => $qte){
						$line = new stdClass();
						$line->type_of_line = "sn";
						$line->sn = $sn;
						$line->qte = $qte;
						$this->create_pdf_corps_line($line);
									
					}
				}
			}*/
			$this->contenu_actuel = $i+1;
	
			// Controle de la fin du document
			if ($i == count($this->contenu)-1) {
				$this->content_printed= 1;
				break; 
			}
	
			// Controle de la nécessité de changer de page
			if (in_array($i, $this->contenu_end_page)) { break;	}
		}
		
		if ($this->page_actuelle == $this->nb_pages) {
			$line = new stdClass();
			$line->type_of_line = "totaux_categorie";
			$this->create_pdf_corps_line($line);
			$line = new stdClass();
			$line->type_of_line = "vide";
			$this->create_pdf_corps_line($line);
			$line = new stdClass();
			$line->type_of_line = "totaux_generaux";
			$this->create_pdf_corps_line($line);
		}			
	
		// Faire déscendre le tableau jusqu'en bas du corps
		while ($this->decalage_corps_actuel <= $this->CORPS_HAUTEUR_MAX-1) {
			$line = new stdClass();
			$this->create_pdf_corps_line($line);
		}
	
		return true;
	}
	
	protected function create_pdf_pieds () {
		global $MONNAIE;
	
		// Information société
		$this->SetXY($this->MARGE_GAUCHE, $this->PIEDS_HAUTEUR_DEPART + $this->PIEDS_HAUTEUR_MAX + 1);
		foreach ($this->PIEDS_GAUCHE as $texte) {
			$this->Cell ($this->LARGEUR_TOTALE_CORPS, 4.5, $texte, '0', 2, 'L');
		}
	
		$this->SetXY(0, $this->PIEDS_HAUTEUR_DEPART + $this->PIEDS_HAUTEUR_MAX + 1);
		foreach ($this->PIEDS_DROIT as $texte) {
			$this->Cell ($this->MARGE_GAUCHE + $this->LARGEUR_TOTALE_CORPS, 4.5, $texte, '0', 2, 'R');
		}
	}
	
	
	//************************************************
	//	FONCTION D'AFFICHAGE DES LIGNES				 *
	//************************************************
	protected function create_pdf_corps_line ($line) {
		global $MONNAIE;
	
		// ***************************************************
		// Valeurs par défaut
		if (!isset($line->type_of_line)) 	{ $line->type_of_line = "vide"; 	}
		
		// Positionnement au début de la ligne
		$this->SetXY($this->MARGE_GAUCHE, $this->CORPS_HAUTEUR_DEPART + $this->decalage_corps_actuel);
		$hauteur = $this->{"HAUTEUR_LINE_".strtoupper($line->type_of_line)};
		$this->decalage_corps_actuel += $hauteur;
	
		
		// Spécifités à l'affichage
		switch ($line->type_of_line) {
			case "article":
				$this->create_pdf_corps_line_article($line, $hauteur);	
				break;
			case "sn":
				$this->create_pdf_corps_line_sn($line, $hauteur);	
				break;
			case "categorie":
				$this->create_pdf_corps_line_categorie($line, $hauteur);	
				break;
			case "totaux_categorie":
				$this->create_pdf_corps_line_totaux_categorie($line, $hauteur);	
				break;
			case "totaux_generaux":
				$this->create_pdf_corps_line_totaux_generaux($line, $hauteur);	
				break;
			case "vide":
				$this->create_pdf_corps_line_vide($line, $hauteur);	
				break;
		}
		return true;
	}
	
	protected function create_pdf_corps_line_article($line, $hauteur){
		global $ARTICLE_QTE_NB_DEC;
		if (!isset($line->ref_article)) 	{ return false;	}
		if (!isset($line->lib_article)) 	{ $line->lib_article = ""; 	}
		if (!isset($line->qte)) 			{ $line->qte = ""; 			}
		if (!isset($line->pu)) 				{ $line->pu = ""; 			}
		
		$line->qte[$this->id_stock] = round($line->qte[$this->id_stock],$ARTICLE_QTE_NB_DEC);
		if ($this->params['aff_pa']) {
			$line->paa_ht = price_format($line->paa_ht);
		$line->pt = price_format($line->paa_ht*$line->qte[$this->id_stock]);
		}


		
		$article = new article($line->ref_article);
		//*****************************
		//traitement des données
		//*****************************
		
		//choix de la ref_article
		$ref_article = "";
		if(isset($this->REF_ARTICLE)){
			switch($this->REF_ARTICLE){
				case 'Aucune' :
					$ref_article = "";
				break;
				case 'Interne' :
					$ref_article = $article->getRef_interne();
				break;
				case 'Oem' :
					$ref_article =  $article->getRef_oem();
				break;
				default :
					$ref_article = $line->ref_article;
				break;
			}
		}
		
		// Traitement pour des lib article trop long
		if ($this->GetStringWidth($line->lib_article) >= $this->COL['LARGEUR']['LIB']-1) {
			do{
				$line->lib_article = substr ($line->lib_article, 0, -4)."...";
			}while ($this->GetStringWidth($line->lib_article."...") >= $this->COL['LARGEUR']['LIB']-1);
		}
			
			
		//********************************	
		//Affichage
		//********************************
		
		//variable de configuration de l'affichage
		$this->SetFont('Arial', '', 9);
		$cadre = "LRBT";
		
		//affichage
		
		$this->Cell($this->COL['LARGEUR']['REF'], $hauteur, $ref_article, $cadre, 0, 'L');
		$this->Cell($this->COL['LARGEUR']['LIB'], $hauteur, $line->lib_article, $cadre, 0, 'L');
		if ($this->params['aff_pa']) {
			$this->Cell($this->COL['LARGEUR']['PAU'], $hauteur, $line->paa_ht, $cadre, 0, 'R'); // prix d'achat unitaire
		}
		$this->Cell($this->COL['LARGEUR']['QTE'], $hauteur, $line->qte[$this->id_stock], $cadre, 0, 'R');
		if ($this->params['aff_pa']) {
			$this->Cell($this->COL['LARGEUR']['PT'], $hauteur,$line->pt, $cadre, 0, 'R');
		}
		$this->totaux_articles[$this->id_stock] ++;
		$this->totaux_generaux_articles ++;
		if ($line->qte[$this->id_stock] >= 0) {
			$this->totaux_pieces[$this->id_stock] += $line->qte[$this->id_stock];
			$this->totaux_generaux_pieces += $line->qte[$this->id_stock];
		}
	}
	
	protected function create_pdf_corps_line_sn($line, $hauteur){
		
	}
	protected function create_pdf_corps_line_categorie($line, $hauteur){
		$this->SetFont('Arial', 'B', 10);
		$cadre = "LRBT";
		$this->Cell($this->LARGEUR_TOTALE_CORPS, $hauteur, $line->lib_art_categ, $cadre, 0, 'L');
		// ***************************************************
		// Entete du tableau
		$entete_tableau_Y = $this->CORPS_HAUTEUR_DEPART + $this->decalage_corps_actuel;
		$this->SetXY($this->MARGE_GAUCHE, $entete_tableau_Y);
		$this->decalage_corps_actuel += 6;
		//
		$this->SetFont('Arial', 'B', 10);
		$this->Cell ($this->COL['LARGEUR']['REF'], 6, $this->COL['ENTETE']['REF'], 1, 0, 'L');
		$this->Cell ($this->COL['LARGEUR']['LIB'], 6, $this->COL['ENTETE']['DES'], 1, 0, 'L');
		if ($this->params['aff_pa']) {
			$this->Cell ($this->COL['LARGEUR']['PAU'], 6, $this->COL['ENTETE']['PAU'], 1, 0, 'L');
		}
		$this->Cell ($this->COL['LARGEUR']['QTE'], 6, $this->COL['ENTETE']['QTE'], 1, 0, 'C');
		if ($this->params['aff_pa']) {
			$this->Cell ($this->COL['LARGEUR']['PT'], 6, $this->COL['ENTETE']['PT'], 1, 0, 'C');
		}
	}
	
	protected function create_pdf_corps_line_totaux_categorie($line, $hauteur){
		/*global $MONNAIE;
		$this->SetFont('Arial', 'I', 9);
		$cadre = "LRBT";
		if ($this->params['aff_pa']) {
		$texte_totaux = "".$this->totaux_articles[$this->id_stock]." articles (".$this->totaux_pieces[$this->id_stock]." pièces) ".price_format($this->totaux_prix)." ".$MONNAIE[0]." HT";
		} else {
		$texte_totaux = "".$this->totaux_articles[$this->id_stock]." articles (".$this->totaux_pieces[$this->id_stock]." pièces) ";
		}
		
		$this->Cell($this->LARGEUR_TOTALE_CORPS, $hauteur, $texte_totaux, $cadre, 0, 'R');*/
	}
	
	protected function create_pdf_corps_line_totaux_generaux($line, $hauteur){
		/*	global $MONNAIE;
		$this->SetFont('Arial', 'I', 9);
		$cadre = "LRBT";
		if ($this->params['aff_pa']) {
		$texte_totaux = "TOTAL GENERAL: ".$this->totaux_generaux_articles." articles (".$this->totaux_generaux_pieces." pièces) ".price_format($this->totaux_generaux_prix)." ".$MONNAIE[0]." HT";
		} else {
		$texte_totaux = "TOTAL GENERAL: ".$this->totaux_generaux_articles." articles (".$this->totaux_generaux_pieces." pièces) ";
		}
		
		$this->Cell($this->LARGEUR_TOTALE_CORPS, $hauteur, $texte_totaux, $cadre, 0, 'R');*/
	}
	
	protected function create_pdf_corps_line_vide($line, $hauteur){
		if ($this->decalage_corps_actuel >= $this->CORPS_HAUTEUR_MAX-1) {
					$cadre = 0;
					$this->Cell($this->LARGEUR_TOTALE_CORPS, $hauteur, "", $cadre, 0, 'L');
		}
		
	}
}
