<?PHP 
// *************************************************************************************************************
// CLASSE DE GENERATION D'UN DOCUMENT PDF - MODELE STANDARD POUR TRM
// *************************************************************************************************************
require_once($PDF_MODELES_DIR."doc_standard.class.php");

class pdf_content_doc_trm_lmb extends pdf_content_doc_standard {
	var $code_pdf_modele = "doc_trm_lmb";

	var $texte_corps_pieds;

// Créé l'entete du document PDF
protected function create_pdf_entete () {
	global $IMAGES_DIR;

	$hauteur = $this->MARGE_HAUT;
	// ***************************************************
	// LOGO
	if(file_exists($IMAGES_DIR.$this->IMG_LOGO))
	$this->pdf->Image($IMAGES_DIR.$this->IMG_LOGO, $this->MARGE_GAUCHE - 5, $this->MARGE_HAUT, 80);

	// ***************************************************
	// TITRE
	$this->pdf->SetXY(90, $hauteur);
	$this->pdf->SetFont('Times', 'B', 25);
	if($this->montant_ht>=0 || empty($this->LIB_NEG)){
		$this->pdf->Cell (95, 10, $this->lib_type_printed, 0, 0, 'L');
	}else{
		$this->pdf->Cell (95, 10, $this->LIB_NEG, 0, 0, 'L');
	}

	// ***************************************************
	// Référence du document
	$hauteur += 9;
	$this->pdf->SetXY(101, $hauteur);
	$this->pdf->SetFont('Arial', '', 8);
	$ref_doc_lib = "Notre Référence";
	$this->pdf->Cell (22, 3, $ref_doc_lib, 0, 0, 'L');
	$this->pdf->Cell (3, 3, ":", 0, 0, 'L');
	$this->pdf->Cell (40, 3, $this->ref_doc, 0, 0, 'L');
	if(!empty($this->ref_doc_externe)){
		$hauteur += 4;
		$this->pdf->SetXY(101, $hauteur);
		$ref_doc_externe_lib = "Votre Référence";
		$this->pdf->Cell (22, 3, $ref_doc_externe_lib, 0, 0, 'L');
		$this->pdf->Cell (3, 3, ":", 0, 0, 'L');
		$this->pdf->Cell (40, 3, $this->ref_doc_externe, 0, 0, 'L');
	}

	// ***************************************************
	// Date du document
	$hauteur += 4;
	$this->pdf->SetXY(101, $hauteur);
	$date_lib = "Date";
	$this->pdf->Cell (22, 3, $date_lib, 0, 0, 'L');
	$this->pdf->Cell (3, 3, ":", 0, 0, 'L');
	$this->pdf->Cell (40, 3, date_Us_to_Fr($this->date_creation), 0, 0, 'L');

	$stock = new stock($this->document->getId_stock_source());
	$libstock = $stock->getLib_stock();
	if(!empty($libstock)) {
		$hauteur += 4;
		$this->pdf->SetXY(101, $hauteur);
		$date_lib = "Stock départ";
		$this->pdf->Cell (22, 3, $date_lib, 0, 0, 'L');
		$this->pdf->Cell (3, 3, ":", 0, 0, 'L');
		$this->pdf->Cell (40, 3, $libstock, 0, 0, 'L');
	}

	$stock = new stock($this->document->getId_stock_cible());
	$libstock = $stock->getLib_stock();
	if(!empty($libstock)) {
		$hauteur += 4;
		$this->pdf->SetXY(101, $hauteur);
		$date_lib = "Stock destination";
		$this->pdf->Cell (22, 3, $date_lib, 0, 0, 'L');
		$this->pdf->Cell (3, 3, ":", 0, 0, 'L');
		$this->pdf->Cell (40, 3, $libstock, 0, 0, 'L');
	}
	return true;
}

// Créé le corps du PDF
protected function create_pdf_corps () {
	global $AFF_REMISES;

	$this->decalage_corps_actuel	= 0;


	// ***************************************************
	// Numéro de page
	$this->pdf->SetXY(-45, $this->CORPS_HAUTEUR_DEPART - 6);
	$this->pdf->SetFont('Arial', 'I', 8);
	$page_lib = "Page ".$this->page_actuelle." / ".$this->nb_pages;
	$this->pdf->Cell (30, 6, $page_lib, 0, 0, 'R');

	
	// ***************************************************
	// Entete du tableau
	$entete_tableau_Y = $this->CORPS_HAUTEUR_DEPART + $this->decalage_corps_actuel;
	$this->pdf->SetXY($this->MARGE_GAUCHE, $entete_tableau_Y);
	$this->decalage_corps_actuel += 6;

	$this->pdf->SetFont('Arial', 'B', 10);
	if ($AFF_REMISES) {
			//$this->LARGEUR_COL_LIB = $this->LARGEUR_COL_LIB + $this->LARGEUR_COL_REM;
	}
	$this->pdf->Cell ($this->LARGEUR_COL_REF, 6, $this->ENTETE_COL_REF, 1, 0, 'L');
	$this->pdf->Cell ($this->LARGEUR_COL_LIB, 6, $this->ENTETE_COL_DES, 1, 0, 'L');
	$this->pdf->Cell ($this->LARGEUR_COL_QTE, 6, $this->ENTETE_COL_QTE, 1, 0, 'C');

	// ***************************************************
	// Contenu du tableau
	for ($i = $this->contenu_actuel; $i<count($this->contenu); $i++) {
		if (isset($this->contenu[$i]->visible) && !$this->contenu[$i]->visible) { continue; } // Ne pas afficher les lignes invisibles

		$line = $this->contenu[$i];
		$this->create_pdf_corps_line($line);
		$this->contenu_actuel = $i+1;

		// Controle de la fin du document
		if ($i == count($this->contenu)-1) {
			$this->content_printed= 1;
			break; 
		}

		// Controle de la nécessité de changer de page
		if (in_array($i, $this->contenu_end_page)) { break;	}
	}

	// Faire décendre le tableau jusqu'en bas du corps
	while ($this->decalage_corps_actuel <= $this->CORPS_HAUTEUR_MAX-1) {
		$line = new stdClass();
		$this->create_pdf_corps_line($line);
	}

	return true;
}



protected function create_pdf_corps_line ($line) {
	global $AFF_REMISES;
	global $MONNAIE;
	global $TARIFS_NB_DECIMALES;

	// ***************************************************
	// Valeurs par défaut
	if (!isset($line->type_of_line)) 	{ $line->type_of_line = "vide"; }
	if (!isset($line->ref_article)) 	{ $line->ref_article = ""; 			}
	if (!isset($line->lib_article)) 	{ $line->lib_article = ""; 			}
	if (!isset($line->desc_article))	{ $line->desc_article = ""; 		}
	if (!isset($line->qte)) 					{ $line->qte = ""; 							}
	if (!isset($line->pu_ht)) 				{ $line->pu_ht = ""; 						}
	if (!isset($line->remise)) 				{ $line->remise = ""; 					}
	if (!isset($line->tva)) 					{ $line->tva = ""; 							}
	$line->pu = $line->pt = "";

	$fill = 0;
	// Cadre
	$cadre = "LR"; // Gauche et droite

	// Positionnement au début de la ligne
	$this->pdf->SetXY($this->MARGE_GAUCHE, $this->CORPS_HAUTEUR_DEPART + $this->decalage_corps_actuel);
	// Style d'écriture par défaut
	$this->pdf->SetFont('Arial', '', 9);
	
	// Calcul du Prix unitaire et du Prix total
	$line->pu = $line->pu_ht;
	if ($this->app_tarifs == "TTC" && $line->type_of_line != "taxe") {
		$line->pu = ht2ttc($line->pu_ht, $line->tva);
	}
	$line->pt = round($line->pu * $line->qte * (1-$line->remise/100), $TARIFS_NB_DECIMALES);

	// Spécifités à l'affichage
	switch ($line->type_of_line) {
		case "article":
			if ($line->remise) { $line->remise = $line->remise." %"; }
			else { $line->remise = ""; }
			$line->pu = price_format ($line->pu);
			if (isset($this->st_lines)) {$this->st_lines += $line->pt;}
			$line->pt = price_format ($line->pt);
			break;
		case "taxe":
			$this->pdf->SetFont('Arial', 'I', 9);
			$line->lib_article	= "  dont taxe ".strtoupper($line->lib_article)." : ";
			$line->lib_article .= "".$line->pt;
			$line->ref_article = $line->qte = $line->pu = $line->remise = $line->pt = $line->tva = "";
			break;
		case "information":
			$this->pdf->SetFont('Arial', 'B', 9);
			$line->ref_article = $line->qte = $line->pu = $line->remise = $line->pt = $line->tva = "";
			break;
		case "soustotal":
		$this->pdf->SetFillColor(200,200,200);
		$fill = 1;
			$line->lib_article	= ($line->lib_article);
			$line->ref_article = " => Sous-total : ";
			$line->pt = price_format ($line->pu);
			if (isset($this->st_lines)) {$line->pt = price_format ($this->st_lines); $this->st_lines = 0;}
			$line->qte =  $line->remise = $line->pu = $line->tva = "";
			break;
		case "description":
			$this->pdf->SetFont('Arial', 'I', 9);
			$line->ref_article = $line->qte = $line->pu = $line->remise = $line->pt = $line->tva = "";
			break;
		case "vide":
			if ($this->decalage_corps_actuel >= $this->CORPS_HAUTEUR_MAX-1) {
				$cadre = "LRB";
			}
			$line->ref_article = $line->qte = $line->pu = $line->remise = $line->pt = $line->tva = "";
			break;
	}

	$hauteur = $this->{"HAUTEUR_LINE_".strtoupper($line->type_of_line)};
	$this->decalage_corps_actuel += $hauteur;

	// Affichage de la ligne de contenu
	$this->pdf->Cell($this->LARGEUR_COL_REF, $hauteur, $line->ref_article, $cadre, 0, 'L', $fill);
	$this->pdf->Cell($this->LARGEUR_COL_LIB, $hauteur, $line->lib_article, $cadre, 0, 'L', $fill);
	$this->pdf->Cell($this->LARGEUR_COL_QTE, $hauteur, $line->qte, $cadre, 0, 'C', $fill);


	return true;
}

protected function create_pdf_pieds () {
	global $MONNAIE;
	
	// Pieds de page
	$this->pdf->SetFont('Arial', 'I', 8);
	$this->pdf->SetXY($this->MARGE_GAUCHE, $this->PIEDS_HAUTEUR_DEPART);

	// Cadre de pieds de page
	$this->pdf->Cell ($this->LARGEUR_TOTALE_CORPS, $this->PIEDS_HAUTEUR_MAX, "", '1', 1, 'L');

	// Information société
	$this->pdf->SetXY($this->MARGE_GAUCHE, $this->PIEDS_HAUTEUR_DEPART + $this->PIEDS_HAUTEUR_MAX + 1);
	foreach ($this->PIEDS_GAUCHE as $texte) {
		$this->pdf->Cell ($this->LARGEUR_TOTALE_CORPS, 4.5, $texte, '0', 2, 'L');
	}

	$this->pdf->SetXY(0, $this->PIEDS_HAUTEUR_DEPART + $this->PIEDS_HAUTEUR_MAX + 1);
	foreach ($this->PIEDS_DROIT as $texte) {
		$this->pdf->Cell ($this->MARGE_GAUCHE + $this->LARGEUR_TOTALE_CORPS, 4.5, $texte, '0', 2, 'R');
	}

	// Bloc Montant Total
	$largeur_bloc_montant = 61;
	$largeur_col1_montant = 30;
	$largeur_col2_montant = 3;
	$largeur_col3_montant = $largeur_bloc_montant - $largeur_col1_montant - $largeur_col2_montant;

	
}

}

?>
