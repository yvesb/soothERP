<?PHP 
// *************************************************************************************************************
// CLASSE DE GENERATION DE L'ETAT DES STOCKS PDF - 
// *************************************************************************************************************


class pdf_stock_etat extends PDF_etendu {
	var $code_pdf_modele = "stock_etat";
	
	var $nb_stock_supporter = 1;

	var $stock;					// stock ï¿½ imprimer
	var $fiches;						// Contenu du document ï¿½ imprimer
	var $id_stock;
	var $lib_stock;
	var $date_impression;
	var $infos;
	var $lib_type_printed;
	var $aff_prix;

	var $nb_pages;
	var $contenu_actuel;
	var $contenu_end_page;
	var $page_actuelle;
	var $content_printed;


	var $HAUTEUR_LINE_ARTICLE;
	var $HAUTEUR_LINE_TAXE;
	var $HAUTEUR_LINE_INFORMATION;
	var $HAUTEUR_LINE_SOUSTOTAL;
	var $HAUTEUR_LINE_DESCRIPTION;
	var $HAUTEUR_LINE_VIDE;

	var $HAUTEUR_AFTER_LINE_ARTICLE;
	var $HAUTEUR_AFTER_LINE_TAXE;
	var $HAUTEUR_AFTER_LINE_INFORMATION;
	var $HAUTEUR_AFTER_LINE_SOUSTOTAL;
	var $HAUTEUR_AFTER_LINE_DESCRIPTION;
	var $HAUTEUR_AFTER_LINE_VIDE;

	var $ENTETE_COL_REF;
	var $ENTETE_COL_DES;
	var $ENTETE_COL_QTE;
	var $ENTETE_COL_PU;
	var $ENTETE_COL_PT;

	var $LARGEUR_COL_REF;
	var $LARGEUR_COL_LIB;
	var $LARGEUR_COL_QTE;
	var $LARGEUR_COL_PU;
	var $LARGEUR_COL_PT;

	var $MARGE_GAUCHE;
	var $MARGE_HAUT;
	var $CORPS_HAUTEUR_DEPART;
	var $CORPS_HAUTEUR_MAX;
	var $PIEDS_HAUTEUR_DEPART;
	var $PIEDS_HAUTEUR_MAX;


public function create_pdf ($id_stock, $fiches, $infos) {
	global $PDF_MODELES_DIR;
	global $ETAT_STOCK;
	
	//**********************************************************
	//	TEST SI LE NOMBRE DE STOCKS EST SUPPORTE PAR LE MODEL  *
	//**********************************************************
	$this->nb_stocks = count($id_stock);
	if($this->nb_stocks > $this->nb_stock_supporter){ 
		echo 'Le nombre de stocks à afficher est supérieur au nombre de stocks affichable par le model.';
		return false;
	}
	
	$this->stock	= new stock($id_stock[0]);
	$this->id_stock	= $this->stock->getId_stock();
	$this->lib_stock	= $this->stock->getLib_stock();
	$this->contenu 	= $fiches;
	$this->infos 		= $infos;
	$this->date_impression 	= date("d/m/Y");
	$this->lib_type_printed 	= "Etat du stock";
	
	$this->aff_prix = $infos["aff_pa"];
	if (isset($_REQUEST["aff_info_tracab"]) && ($_REQUEST["aff_info_tracab"] == 1)){
		$this->aff_info_tracab = $_REQUEST["aff_info_tracab"];
	}else{
		$this->aff_info_tracab = 0;
	}
	
	include_once ($PDF_MODELES_DIR."config/".$this->code_pdf_modele.".config.php");

	// ***************************************************
	// Initialisation de l'objet PDF
	parent::__construct();

	// ***************************************************
	// Initialisation des variables
	$this->nb_pages					= 1;
	$this->contenu_actuel 	= 0;					// Ligne du document en cours de traitement
	$this->contenu_end_page = array();		// Lignes de contenu terminant les diffï¿½rentes pages
	$this->page_actuelle		= 0;
	$this->content_printed	= 0;
	$this->current_ref_art_categ = "";
	$this->totaux_articles = 0;
	$this->totaux_pieces = 0;
	$this->totaux_prix = 0;
	$this->totaux_generaux_articles = 0;
	$this->totaux_generaux_pieces = 0;
	$this->totaux_generaux_prix = 0;

	// ***************************************************
	// Valeurs par dï¿½faut
	foreach ($ETAT_STOCK as $var => $valeur) {
		$this->{$var} = $valeur;
	}

	// Affichage des colonnes prix ?
	if (!$this->aff_prix) {
		$this->LARGEUR_COL_LIB += $this->LARGEUR_COL_PU;
		$this->LARGEUR_COL_LIB += $this->LARGEUR_COL_PT;
		$this->LARGEUR_COL_PU = 0;
		$this->LARGEUR_COL_PT = 0;
	}

	$this->LARGEUR_TOTALE_CORPS  = $this->LARGEUR_COL_REF + $this->LARGEUR_COL_LIB;
	$this->LARGEUR_TOTALE_CORPS += $this->LARGEUR_COL_QTE + $this->LARGEUR_COL_PU;
	$this->LARGEUR_TOTALE_CORPS += $this->LARGEUR_COL_PT;

        //********************
        //ajout des sn
        
        if($this->aff_info_tracab){
            $copy_contenu = array();
            for ($i=0; $i<count($this->contenu); $i++) {
                    $copy_contenu[] = $this->contenu[$i];
                    if(!empty($this->contenu[$i]->ref_article)){
                            $art = new article($this->contenu[$i]->ref_article);
                            $art_stock_sn = $art->getStocks_arti_sn ();
                            if(!empty($art_stock_sn[$this->id_stock]->sn)){
                                    foreach($art_stock_sn[$this->id_stock]->sn AS $sn => $qte){
                                            $line = new stdClass();

                                            $line->ref_article = "";
                                            $line->ref_oem = "";
                                             $line->ref_interne = "";
                                            $line->ref_art_categ = $this->contenu[$i]->ref_art_categ;
                                            $line->lib_article = "";
                                            $line->ref_constructeur = "";
                                            $line->lib_art_categ = "";
                                            $line->ref_art_categ_parent = "";
                                            $line->stocks = "";

                                            $line->type_of_line = "sn";
                                            $line->sn = $sn;
                                            $line->qte = $qte;

                                            $copy_contenu[] = $line;

                                    }
                            }
                    }

            }
            $this->contenu = $copy_contenu;
        }
        
	// ***************************************************
	// Comptage du nombre de page nï¿½cessaires
	$hauteur_totale = 0;
	for ($i=0; $i<count($this->contenu); $i++) {

		//si on change de categorie on ajout une ligne
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
                if(isset($this->contenu[$i]->type_of_line) && $this->contenu[$i]->type_of_line == "sn"){
                    $hauteur_ligne = $this->HAUTEUR_LINE_SN;
                }else{
                    $hauteur_ligne = $this->HAUTEUR_LINE_ARTICLE;
                }
		// Vï¿½rification de la nï¿½cessitï¿½ de changer de page
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
	// ***************************************************
	// Crï¿½ation de la premiï¿½re page
	$this->create_pdf_page ();


	return $this;
}


// Crï¿½ï¿½ une nouvelle page du document PDF
protected function create_pdf_page () {
	// Comptage du nombre de page
	$this->page_actuelle++;

	// Crï¿½ation d'une nouvelle page
	$this->AddPage();
	$this->create_pdf_entete ();
	$this->create_pdf_corps ();
	$this->create_pdf_texte_corps_pieds ();
	$this->create_pdf_pieds ();

	while ($this->page_actuelle < $this->nb_pages) {
		$this->create_pdf_page();
	}
}


// Crï¿½ï¿½ l'entete du document PDF
protected function create_pdf_entete () {
	global $IMAGES_DIR;

	// ***************************************************
	// LOGO
	//$this->Image($IMAGES_DIR.$this->IMG_LOGO, $this->MARGE_GAUCHE - 5, $this->MARGE_HAUT, 80);

	// ***************************************************
	// TITRE
	$this->SetXY($this->MARGE_GAUCHE, $this->MARGE_HAUT);
	$this->SetFont('Times', 'B', 25);
	$this->Cell (95, 10, $this->lib_type_printed, 0, 0, 'L');

	// ***************************************************
	// Rï¿½fï¿½rence du stock
	$this->SetXY($this->MARGE_GAUCHE+1, 27);
	$this->SetFont('Arial', '', 8);
	$stock_lib = "Stock";
	$this->Cell (13, 3, $stock_lib, 0, 0, 'L');
	$this->Cell (3, 3, ":", 0, 0, 'L');
	$this->Cell (40, 3, $this->lib_stock, 0, 0, 'L');

	// ***************************************************
	// Date du document
	$this->SetXY($this->MARGE_GAUCHE+1, 31);
	$date_lib = "Date";
	$this->Cell (13, 3, $date_lib, 0, 0, 'L');
	$this->Cell (3, 3, ":", 0, 0, 'L');
	$this->Cell (40, 3, $this->date_impression, 0, 0, 'L');

	return true;
}





// Crï¿½ï¿½ le corps du PDF
protected function create_pdf_corps () {

	$this->decalage_corps_actuel	= 0;


	// ***************************************************
	// Numï¿½ro de page
	$this->SetXY(-45, $this->CORPS_HAUTEUR_DEPART - 6);
	$this->SetFont('Arial', 'I', 8);
	$page_lib = "Page ".$this->page_actuelle." / ".$this->nb_pages;
	$this->Cell (30, 6, $page_lib, 0, 0, 'R');

	
	// ***************************************************
	// Entete du tableau
	$entete_tableau_Y = $this->CORPS_HAUTEUR_DEPART + $this->decalage_corps_actuel;
	$this->SetXY($this->MARGE_GAUCHE, $entete_tableau_Y);
	$this->decalage_corps_actuel += 6;
//
//	$this->SetFont('Arial', 'B', 10);
//	$this->Cell ($this->LARGEUR_COL_REF, 6, $this->ENTETE_COL_REF, 1, 0, 'L');
//	$this->Cell ($this->LARGEUR_COL_LIB, 6, $this->ENTETE_COL_DES, 1, 0, 'L');
//	$this->Cell ($this->LARGEUR_COL_QTE, 6, $this->ENTETE_COL_QTE, 1, 0, 'C');
//	if ($this->aff_prix) {
//		$this->Cell ($this->LARGEUR_COL_PU, 6, $this->ENTETE_COL_PU, 1, 0, 'C');
//		$this->Cell ($this->LARGEUR_COL_PT, 6, $this->ENTETE_COL_PT, 1, 0, 'C');
//	}



	// ***************************************************
	// Contenu du tableau
	for ($i = $this->contenu_actuel; $i<count($this->contenu); $i++) {
		//si on change de categorie on change de page
            if(!empty($this->contenu[$i]->ref_article)){
		if ($this->current_ref_art_categ != $this->contenu[$i]->ref_art_categ) {

			if ($this->current_ref_art_categ != "") {
				$line = new stdClass();
				$line->type_of_line = "totaux_categorie";
				$this->create_pdf_corps_line($line);
				$line = new stdClass();
				$line->type_of_line = "vide";
				$this->create_pdf_corps_line($line);
			$this->totaux_articles = 0;
			$this->totaux_pieces = 0;
			$this->totaux_prix = 0;
			}
			
			$line = new stdClass();
			$line->type_of_line = "categorie";
			$line->lib_art_categ = $this->contenu[$i]->lib_art_categ;
			if ($this->GetStringWidth($line->lib_art_categ) >= ($this->LARGEUR_COL_LIB+$this->LARGEUR_COL_REF)-$this->MARGE_GAUCHE-1) {
			while ($this->GetStringWidth("...".$line->lib_art_categ) >= ($this->LARGEUR_COL_LIB+$this->LARGEUR_COL_REF)-$this->MARGE_GAUCHE-1) {
				$line->lib_art_categ = substr ($line->lib_art_categ, 1);
			}
			$line->lib_art_categ = "...".$line->lib_art_categ;
			}
			$this->create_pdf_corps_line($line);
			
			$this->current_ref_art_categ = $this->contenu[$i]->ref_art_categ;
		}
                $line = $this->contenu[$i];

                $line->type_of_line = "article";
                if (isset($this->contenu[$i]->qte[$this->id_stock])) {
                        $line->qte = $this->contenu[$i]->qte[$this->id_stock];
                } else {
                        $line->qte = 0;
                }

                $this->create_pdf_corps_line($line);
            }else{
                //gestion des sn
                $this->create_pdf_corps_line($this->contenu[$i]);
            }
		
           

            $this->contenu_actuel = $i+1;

            // Controle de la fin du document
            if ($i == count($this->contenu)-1) {
                    $this->content_printed= 1;
                    break;
            }

            // Controle de la nï¿½cessitï¿½ de changer de page
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

	// Faire dï¿½cendre le tableau jusqu'en bas du corps
	while ($this->decalage_corps_actuel <= $this->CORPS_HAUTEUR_MAX-1) {
		$line = new stdClass();
		$this->create_pdf_corps_line($line);
	}

	return true;
}



protected function create_pdf_corps_line ($line) {
	global $MONNAIE;

	// ***************************************************
	// Valeurs par dï¿½faut
	if (!isset($line->type_of_line)) 	{ $line->type_of_line = "vide"; 	}
	if (!isset($line->ref_article)) 	{ $line->ref_article = ""; 			}
	if (!isset($line->lib_article)) 	{ $line->lib_article = ""; 			}
	if (!isset($line->qte)) 			{ $line->qte = ""; 					}
	if (!isset($line->pu)) 				{ $line->pu = ""; 					}
	if (!isset($line->pt)) 				{ $line->pt = ""; 					}

	
	$line->qte = qte_format($line->qte);
	
	// Cadre
	$cadre = 0; // Gauche et droite

	// Positionnement au dï¿½but de la ligne
	$this->SetXY($this->MARGE_GAUCHE, $this->CORPS_HAUTEUR_DEPART + $this->decalage_corps_actuel);
	// Style d'ï¿½criture par dï¿½faut
	$this->SetFont('Arial', '', 9);
	
	$pt_float = 0;
	// Calcul du Prix unitaire et du Prix total
	if ($this->aff_prix && isset($line->prix_achat_ht) && $line->prix_achat_ht ) {
		$line->pu = $line->prix_achat_ht;
		$line->pt = $line->prix_achat_ht * $line->qte;
		$pt_float = floatval ($line->prix_achat_ht * $line->qte);
	} else if ($this->aff_prix && isset($line->paa_ht)) {
		$line->pu = $line->paa_ht;
		$line->pt = $line->paa_ht * $line->qte;
		$pt_float = floatval ($line->paa_ht * $line->qte);
	}

	$hauteur = $this->{"HAUTEUR_LINE_".strtoupper($line->type_of_line)};
	$this->decalage_corps_actuel += $hauteur;

	// Spï¿½cifitï¿½s ï¿½ l'affichage
	switch ($line->type_of_line) {
		case "article":
			// Traitement pour les lignes trops longues
			if ($this->GetStringWidth($line->lib_article) >= $this->LARGEUR_COL_LIB-1) {
			while ($this->GetStringWidth($line->lib_article."...") >= $this->LARGEUR_COL_LIB-1) {
				$line->lib_article = substr ($line->lib_article, 0, -1);
			}
			$line->lib_article = $line->lib_article."...";
			}
				$cadre = "LRTB";
		
			// Affichage de la ligne de contenu
			
			if (!$line->ref_interne) {
			$this->Cell($this->LARGEUR_COL_REF, $hauteur, $line->ref_article, $cadre, 0, 'L');
			} else {
			$this->Cell($this->LARGEUR_COL_REF, $hauteur, $line->ref_interne, $cadre, 0, 'L');
			}
			$this->Cell($this->LARGEUR_COL_LIB, $hauteur, $line->lib_article, $cadre, 0, 'L');
			$this->Cell($this->LARGEUR_COL_QTE, $hauteur, qte_format($line->qte), $cadre, 0, 'C');
			if ($this->aff_prix) {
				$this->Cell($this->LARGEUR_COL_PU, $hauteur, price_format($line->pu), $cadre, 0, 'R');
				$this->Cell($this->LARGEUR_COL_PT, $hauteur, price_format($line->pt), $cadre, 0, 'R');
				$this->totaux_prix += $pt_float;
				$this->totaux_generaux_prix += $pt_float;
			}
			$this->totaux_articles ++;
			$this->totaux_generaux_articles ++;
			if ($line->qte >= 0) {
				$this->totaux_pieces += $line->qte;
				$this->totaux_generaux_pieces += $line->qte;
			}

			break;
		case "categorie":
			$this->SetFont('Arial', 'B', 10);
				$cadre = "LRBT";
			$this->Cell($this->LARGEUR_TOTALE_CORPS, $hauteur, $line->lib_art_categ, $cadre, 0, 'L');
			break;
		case "totaux_categorie":
			$this->SetFont('Arial', 'I', 9);
				$cadre = "LRBT";
				if ($this->aff_prix) {
				$texte_totaux = "".$this->totaux_articles." articles (".qte_format($this->totaux_pieces)." pièces) ".price_format($this->totaux_prix)." ".$MONNAIE[0]." HT";
				} else {
				$texte_totaux = "".$this->totaux_articles." articles (".qte_format($this->totaux_pieces)." pièces) ";
				}
				
			$this->Cell($this->LARGEUR_TOTALE_CORPS, $hauteur, $texte_totaux, $cadre, 0, 'R');
			break;
		case "totaux_generaux":
			$this->SetFont('Arial', 'I', 9);
				$cadre = "LRBT";
				if ($this->aff_prix) {
				$texte_totaux = "TOTAL GENERAL: ".$this->totaux_generaux_articles." articles (".qte_format($this->totaux_generaux_pieces)." pièces) ".price_format($this->totaux_generaux_prix)." ".$MONNAIE[0]." HT";
				} else {
				$texte_totaux = "TOTAL GENERAL: ".$this->totaux_generaux_articles." articles (".qte_format($this->totaux_generaux_pieces)." pièces) ";
				}
				
			$this->Cell($this->LARGEUR_TOTALE_CORPS, $hauteur, $texte_totaux, $cadre, 0, 'R');
			break;
		case "vide":
			if ($this->decalage_corps_actuel >= $this->CORPS_HAUTEUR_MAX-1) {
				$cadre = 0;
			}
			$this->Cell($this->LARGEUR_TOTALE_CORPS, $hauteur, "", $cadre, 0, 'L');
			break;
		case "sn":
			$cadre = "LR";
			$this->SetFont('Arial', 'I', 9);
			$this->Cell($this->LARGEUR_COL_REF, $hauteur, '', $cadre, 0, 'L');
			$this->Cell($this->LARGEUR_COL_LIB, $hauteur, '   '.$line->sn, "R", 0, 'L');
			$this->Cell($this->LARGEUR_COL_QTE, $hauteur,  qte_format($line->qte), "LR", 0, 'C');
			
			if ($this->aff_prix) {
				$this->Cell($this->LARGEUR_COL_PU , $hauteur,'', $cadre, 0, 'R');
				$this->Cell($this->LARGEUR_COL_PT , $hauteur,'', $cadre, 0, 'R');	
			}
			break;
	}


	return true;
}


protected function create_pdf_texte_corps_pieds () {

}


protected function create_pdf_pieds () {
	global $MONNAIE;

	// Information sociï¿½tï¿½
	$this->SetXY($this->MARGE_GAUCHE, $this->PIEDS_HAUTEUR_DEPART + $this->PIEDS_HAUTEUR_MAX + 1);
	foreach ($this->PIEDS_GAUCHE as $texte) {
		$this->Cell ($this->LARGEUR_TOTALE_CORPS, 4.5, $texte, '0', 2, 'L');
	}

	$this->SetXY(0, $this->PIEDS_HAUTEUR_DEPART + $this->PIEDS_HAUTEUR_MAX + 1);
	foreach ($this->PIEDS_DROIT as $texte) {
		$this->Cell ($this->MARGE_GAUCHE + $this->LARGEUR_TOTALE_CORPS, 4.5, $texte, '0', 2, 'R');
	}
}

}

?>
