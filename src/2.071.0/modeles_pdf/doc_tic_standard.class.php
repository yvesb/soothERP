<?PHP 
// *************************************************************************************************************
// CLASSE PERMETTANT L'AJOUT D'UN DOCUMENT A UN PDF - MODELE STANDARD
// *************************************************************************************************************
require_once($PDF_MODELES_DIR."doc_standard.class.php");

class pdf_content_doc_tic_standard extends pdf_content_doc_standard{
	var $code_pdf_modele = "doc_tic_standard";


protected function calcul_hauteur(){
	// Taille marge du haut
	$hauteur = $this->MARGE_HAUT;
	// Taille en-tête paramétrable
	$hauteur += count( explode("\n",$this->TEXTE_ENTETE))*3;
	// Taille entre en-tête et corps
	$hauteur += 5*$this->HAUTEUR_LIGNE_DEFAUT;
	// Taille corps
	$hauteur += count($this->contenu)*$this->HAUTEUR_LINE_ARTICLE;
	// Taille pied
	$hauteur += 5*$this->HAUTEUR_LIGNE_DEFAUT + count($this->document->getReglements())*3;
	// Taille pied paramétrable
	$hauteur += count( explode("\n",$this->TEXTE_PIED))*3;
	// Taille marge du bas
	$hauteur += $this->MARGE_BAS;

	return $hauteur;
}


protected function create_pdf_page () {
	// Comptage du nombre de page
	$this->page_actuelle++;

	$this->FORMAT_PDF[0] = 80;
	$this->FORMAT_PDF[1] = $this->calcul_hauteur();

	// Création d'une nouvelle page
	$this->pdf->AddPage('P',$this->FORMAT_PDF);
	$this->calcul_hauteur();
	
	// ***************************************************
	// filigrane
	if (isset($GLOBALS['PDF_OPTIONS']['filigrane'])) {
	
	$this->pdf->SetTextColor(200,200,200);
	$this->pdf->SetFont('Arial', 'B',30);
	$this->pdf->Cell (0, 50, $GLOBALS['PDF_OPTIONS']['filigrane'], 0, 0, 'C');
	
	$this->pdf->SetTextColor(0,0,0);
	}
	
	$this->create_pdf_entete ();
	$this->create_pdf_adresse ();
	$this->create_pdf_corps ();
	$this->create_pdf_pieds ();
	
}


	// Créé l'entete du document PDF
protected function create_pdf_entete () {
	$hauteur = 0;
	
	// ***************************************************
	// MARGE DU HAUT
	$hauteur += $this->MARGE_HAUT;
	$this->pdf->SetXY($this->LARGEUR_RETRAIT, $hauteur);
	
	// ***************************************************
	// TEXTE EN EN-TETE
	$this->pdf->SetXY($this->LARGEUR_RETRAIT, $this->MARGE_HAUT);
	$this->pdf->SetFont('Arial', '', 8);
	if(is_array($this->TEXTE_ENTETE)){
		foreach ($this->TEXTE_ENTETE as $texte) {
			$this->pdf->Cell ($this->LARGEUR_LIGNE, 0, $texte, 0, 0, 'C');
		}
	}else{
		$this->pdf->MultiCell ($this->LARGEUR_LIGNE, 3, $this->TEXTE_ENTETE, 0, 'C');
	}
	
	$hauteur = $this->pdf->GetY();
	
	// ***************************************************
	// ESPACE
	$hauteur += 3;
	$this->pdf->SetXY($this->LARGEUR_RETRAIT, $hauteur);
	
	// ***************************************************
	// SEPARATION
	$this->pdf->SetXY($this->LARGEUR_RETRAIT, $hauteur);
	$this->pdf->SetFont('Arial', '', 8);
	$this->pdf->Cell ($this->LARGEUR_LIGNE, 0, "---------------------------------------------------------------------------", 0, 0, 'C');

	// ***************************************************
	// REFERENCE DU DOCUMENT
	$hauteur += 3;
	$this->pdf->SetXY($this->LARGEUR_RETRAIT, $hauteur);
	$this->pdf->SetFont('Arial', '', 8);
	$ref_doc_lib = "Ticket n°";
	$this->pdf->Cell ($this->LARGEUR_LIGNE, 0, $ref_doc_lib." : $this->ref_doc", 0, 0, 'C');

	// ***************************************************
	// DATE & HEURE
	$hauteur += 3;
	$this->pdf->SetXY($this->LARGEUR_RETRAIT, $hauteur);
	$this->pdf->SetFont('Arial', '', 8);
	$this->pdf->Cell ($this->LARGEUR_LIGNE, 0, date("d-m-Y H:i"), 0, 0, 'C');
	
	// ***************************************************
	// SEPARATION
	$hauteur += 3;
	$this->pdf->SetXY($this->LARGEUR_RETRAIT, $hauteur);
	$this->pdf->SetFont('Arial', '', 8);
	$this->pdf->Cell ($this->LARGEUR_LIGNE, 0, "---------------------------------------------------------------------------", 0, 0, 'C');
	
	// ***************************************************
	// DESIGNATION - QTE - TOTAL (EN-TETE)
	$hauteur += 3;
	$this->pdf->SetXY($this->LARGEUR_RETRAIT, $hauteur);
	$this->pdf->SetFont('Arial', '', 8);
	
	// ***************************************************
	// DESIGNATION
	$this->pdf->SetFont('Arial', 'B', 8);
	$this->pdf->Cell ($this->LARGEUR_COL_LIB, 0, $this->ENTETE_COL_LIB, 0, 0, 'L');
	
	$this->pdf->SetXY($this->LARGEUR_RETRAIT + $this->LARGEUR_COL_LIB, $hauteur);
	
	// ***************************************************
	// QTE
	$this->pdf->SetFont('Arial', 'B', 8);
	$this->pdf->Cell ($this->LARGEUR_COL_QTE, 0, $this->ENTETE_COL_QTE, 0, 0, 'C');
	
	$this->pdf->SetXY($this->LARGEUR_RETRAIT + $this->LARGEUR_COL_LIB + $this->LARGEUR_COL_QTE, $hauteur);
	
	// ***************************************************	
	// TOTAL
	$this->pdf->SetFont('Arial', 'B', 8);
	$this->pdf->Cell ($this->LARGEUR_COL_PT, 0, $this->ENTETE_COL_PT, 0, 0, 'R');
	
	return true;

}


protected function create_pdf_adresse () {}


// Créé le corps du PDF
protected function create_pdf_corps () {
	global $AFF_REMISES;

	$this->decalage_corps_actuel	= $this->pdf->getY();

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
	

	return true;
}


protected function create_pdf_corps_line ($line) {
	global $AFF_REMISES;
	global $MONNAIE;
	global $TARIFS_NB_DECIMALES;

	// ***************************************************
	// Valeurs par défaut
	if (!isset($line->type_of_line)) 	{ $line->type_of_line = "vide"; 	}
	if (!isset($line->lib_article)) 	{ $line->lib_article = ""; 			}
	if (!isset($line->qte)) 			{ $line->qte = ""; 					}
	if (!isset($line->pu_ht)) 			{ $line->pu_ht = ""; 				}
	if (!isset($line->remise)) 			{ $line->remise = ""; 				}
	if (!isset($line->tva)) 			{ $line->tva = ""; 					}
	$line->pu = $line->pt = "";
	
	// Calcul du Prix unitaire et du Prix total
	$line->pu = $line->pu_ht;
	if ($this->app_tarifs == "TTC" && $line->type_of_line != "taxe") {
		$line->pu = ht2ttc($line->pu_ht, $line->tva);
	}
	$line->pt = round($line->pu * $line->qte * (1-$line->remise/100), $TARIFS_NB_DECIMALES);

	// Spécifités à l'affichage
	switch ($line->type_of_line) {
		case "article":
			$this->pdf->SetFont('Arial', '', 8);
			if ($line->remise) { $line->remise = $line->remise; }
			else { $line->remise = ""; }
			$line->pu = price_format ($line->pu);
			if (isset($this->st_lines)) {$this->st_lines += $line->pt;}
			$line->pt = price_format ($line->pt);
		break;
		case "taxe":
			$this->pdf->SetFont('Arial', 'I', 8);
			$line->lib_article	= "  dont taxe ".strtoupper($line->lib_article)." : ";
			$line->lib_article .= "".price_format ($line->pt);
			$line->ref_article = $line->qte = $line->pu = $line->remise = $line->pt = $line->tva = "";
		break;
		case "information":
			$this->pdf->SetFont('Arial', 'B', 8);
			$line->ref_article = $line->qte = $line->pu = $line->remise = $line->pt = $line->tva = "";
		break;
		case "soustotal":
			$this->pdf->SetFont('Arial', 'BI', 8);
			$line->lib_article	= ($line->lib_article);
			$line->ref_article = " => Sous-total : ";
			$line->pt = price_format ($line->pu);
			if (isset($this->st_lines)) {$line->pt = price_format ($this->st_lines); $this->st_lines = 0;}
			$line->qte =  $line->remise = $line->pu = $line->tva = "";
		break;
		case "description":
			$this->pdf->SetFont('Arial', 'I', 8);
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
	$this->pdf->SetXY($this->LARGEUR_RETRAIT, $this->decalage_corps_actuel);
	
	// Affichage de la ligne de contenu
	$this->pdf->Cell($this->LARGEUR_COL_LIB, 0, $line->lib_article, 0, 0, 'L');
	$this->pdf->Cell($this->LARGEUR_COL_QTE, 0, $line->qte, 0, 0, 'C');
		if(!isset($this->AFF_PRIX) || $this->AFF_PRIX){
		$this->pdf->Cell($this->LARGEUR_COL_PT, 0, $line->pt, 0, 0, 'R');
		}

	return true;
}


protected function create_pdf_pieds () {
	global $MONNAIE;
	global $bdd;
	
	$largeur_bloc_montant = 0;
	$largeur_bloc_tva = 0;
	if(!isset($this->AFF_PRIX) || $this->AFF_PRIX){
		// Bloc Montant Total
		$largeur_bloc_montant = 61;
		$largeur_col1_montant = 30;
		$largeur_col2_montant = 3;
		$largeur_col3_montant = $largeur_bloc_montant - $largeur_col1_montant - $largeur_col2_montant;

	}
 
	$hauteur = $this->pdf->GetY();
	// ***************************************************
	// SEPARATION
	$hauteur += 3;
	$this->pdf->SetXY($this->LARGEUR_RETRAIT, $hauteur);
	$this->pdf->SetFont('Arial', '', 8);
	$this->pdf->Cell ($this->LARGEUR_LIGNE, 0, "---------------------------------------------------------------------------", 0, 0, 'C');
	
	// ***************************************************
	// TOTAL - TOTAL(PRIX)
	$hauteur += 3;
	$this->pdf->SetXY($this->LARGEUR_RETRAIT, $hauteur);
	$this->pdf->SetFont('Arial', '', 8);
	
	// ***************************************************
	// TOTAL
	$this->pdf->SetFont('Arial', 'B', 8);
	$this->pdf->Cell ($this->LARGEUR_LIGNE-$this->LARGEUR_COL_PT, 0, "TOTAL (".$MONNAIE[2].")", 0, 0, 'L');
	
	$this->pdf->SetXY($this->LARGEUR_RETRAIT + ($this->LARGEUR_LIGNE-$this->LARGEUR_COL_PT), $hauteur);
	
	// ***************************************************
	// TOTAL(PRIX)
	$this->pdf->SetFont('Arial', 'B', 8);
	$this->pdf->Cell ($this->LARGEUR_COL_PT, 0, price_format ($this->montant_ttc), 0, 0, 'R');
	
	// ***************************************************
	// TVA - TVA(PRIX)
	$hauteur += 3;
	$this->pdf->SetXY($this->LARGEUR_RETRAIT, $hauteur);
	$this->pdf->SetFont('Arial', '', 8);
	
	// ***************************************************
	// TVA
	$this->pdf->SetFont('Arial', '', 8);
	$this->pdf->Cell ($this->LARGEUR_LIGNE-$this->LARGEUR_COL_PT, 0, "Dont TVA", 0, 0, 'L');
	
	$this->pdf->SetXY($this->LARGEUR_RETRAIT + ($this->LARGEUR_LIGNE-$this->LARGEUR_COL_PT), $hauteur);
	
	// ***************************************************
	// TVA(PRIX)
	$this->pdf->SetFont('Arial', '', 8);
	$this->pdf->Cell ($this->LARGEUR_COL_PT, 0, price_format ($this->montant_ttc - $this->montant_ht), 0, 0, 'R');
	
	// ***************************************************
	// MOYEN DE PAIEMENT - MOYEN DE PAIEMENT(PRIX)
	$hauteur += 3;
	$this->pdf->SetXY($this->LARGEUR_RETRAIT, $hauteur);
	$this->pdf->SetFont('Arial', '', 8);
	
	// MOYEN DE PAIEMENT
	//chargement des reglements
	$reglements = $this->document->getReglements ();
	
	//reglements
	$this->pdf->setLeftMargin($this->LARGEUR_RETRAIT);
	foreach($reglements as $reglement) {
		
		$lib_reglement_mode = $reglement->lib_reglement_mode;
		if ($this->pdf->GetStringWidth($lib_reglement_mode) >= 20) {
		while ($this->pdf->GetStringWidth($lib_reglement_mode."...") >= 20) {
			$lib_reglement_mode = substr ($lib_reglement_mode, 0, -1);
		}
		$lib_reglement_mode = $lib_reglement_mode."...";
		}
		$this->pdf->Cell ($this->LARGEUR_RETRAIT, 3, $lib_reglement_mode, '0', 0, 'L');
		
		$this->pdf->Cell ($this->LARGEUR_LIGNE-$this->LARGEUR_RETRAIT, 3, price_format ($reglement->montant_reglement), 0, 1, 'R');
		
	}
		
	$this->pdf->SetXY($this->LARGEUR_RETRAIT + ($this->LARGEUR_LIGNE-$this->LARGEUR_COL_PT), $hauteur);
	
	// ***************************************************
	// MOYEN DE PAIEMENT(PRIX)
	
	// ***************************************************
	// SEPARATION
	$hauteur += 3*count($reglements);
	$this->pdf->SetXY($this->LARGEUR_RETRAIT, $hauteur);
	$this->pdf->SetFont('Arial', '', 8);
	$this->pdf->Cell ($this->LARGEUR_LIGNE, 0, "---------------------------------------------------------------------------", 0, 0, 'C');
	
	// ***************************************************
	// ESPACE
	$hauteur += 3;
	$this->pdf->SetXY($this->LARGEUR_RETRAIT, $hauteur);
	
	// ***************************************************
	// TEXTE EN PIED DE PAGE
	$this->pdf->SetFont('Arial', '', 8);
	if(is_array($this->TEXTE_PIED)){
		foreach ($this->TEXTE_PIED as $texte) {
			$this->pdf->Cell ($this->LARGEUR_LIGNE, 0, $texte, 0, 0, 'C');
		}
	}else{
		$this->pdf->MultiCell ($this->LARGEUR_LIGNE, 3, $this->TEXTE_PIED, 0, 'C');
	}
	
	$hauteur = $this->pdf->GetY();
	$var =$this->pdf->GetY();

	// ***************************************************
	// MARGE DU BAS
	$hauteur += $this->MARGE_BAS;
	$this->pdf->SetXY($this->LARGEUR_RETRAIT, $hauteur);

}
	
	
}

?>
