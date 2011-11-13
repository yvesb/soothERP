<?PHP 
// *************************************************************************************************************
// CLASSE DE GENERATION D'UN DOCUMENT PDF - MODELE STANDARD DEVIS CLIENT
// *************************************************************************************************************
require_once($PDF_MODELES_DIR."doc_standard.class.php");

class pdf_content_doc_dev_lmb_trav extends pdf_content_doc_standard {
	var $code_pdf_modele = "doc_dev_lmb_trav";

	var $texte_corps_pieds;


// Créé une nouvelle page du document PDF
protected function create_pdf_page () {
	
	global $IMAGES_DIR;
	
	$this->pdfimg = "0";
	$this->page_actuelle++;
	$this->pdf->AddPage();
	// ***************************************************
	 //filigrane
	if (isset($GLOBALS['PDF_OPTIONS']['filigrane'])) {
	
	$this->pdf->SetTextColor(200,200,200);
	$this->pdf->SetXY($this->MARGE_GAUCHE, 145);
	$this->pdf->SetFont('Arial', 'B',35);
	$this->pdf->Cell (190, 6, $GLOBALS['PDF_OPTIONS']['filigrane'], 0, 0, 'C');
	
	$this->pdf->SetTextColor(0,0,0);
	}	
	$this->create_pdf_entete ();
	$this->create_pdf_adresse ();
	$this->create_pdf_corps ();
	$this->create_pdf_texte_corps_pieds ();
	$this->create_pdf_pieds ();
	
	
	foreach ($this->tvas as $tva => $montant_tva) {
		if ($tva == "5.5" && $this->page_actuelle == $this->nb_pages) {										// si la TVA pratiquée est à 5.5 %
		$this->page_actuelle++;									// ajout du formulaire TVA
		$this->pdf->AddPage();
		$this->pdf->Image($IMAGES_DIR.$this->FORMULAIRE_TVA_1, $this->MARGE_GAUCHE-10, $this->MARGE_HAUT-10, 200, 290);}}
		$this->pdfimg = "1";
		// ***************************************************
	 //filigrane
	if (isset($GLOBALS['PDF_OPTIONS']['filigrane'])) {
	
	$this->pdf->SetTextColor(200,200,200);
	$this->pdf->SetXY($this->MARGE_GAUCHE, 145);
	$this->pdf->SetFont('Arial', 'B',35);
	$this->pdf->Cell (190, 6, $GLOBALS['PDF_OPTIONS']['filigrane'], 0, 0, 'C');
	
	$this->pdf->SetTextColor(0,0,0);
	}	
	
	while ($this->page_actuelle < $this->nb_pages) {
		$this->create_pdf_page();
	}
}







// Créé l'entete du document PDF
protected function create_pdf_entete () {
	global $IMAGES_DIR;

	// ***************************************************
	// LOGO
	$this->pdf->Image($IMAGES_DIR.$this->IMG_LOGO, $this->MARGE_GAUCHE - 5, $this->MARGE_HAUT, 80);

	// ***************************************************
	// TITRE
	$this->pdf->SetXY(100, $this->MARGE_HAUT);
	$this->pdf->SetFont('Times', 'B', 25);
	$this->pdf->Cell (95, 10, strtoupper($this->lib_type_printed.' de travaux'), 0, 0, 'L');

	// ***************************************************
	// Référence du document
	$this->pdf->SetXY(101, 27);
	$this->pdf->SetFont('Arial', '', 8);
	$ref_doc_lib = "Référence";
	$this->pdf->Cell (13, 3, $ref_doc_lib, 0, 0, 'L');
	$this->pdf->Cell (3, 3, ":", 0, 0, 'L');
	$this->pdf->Cell (40, 3, $this->ref_doc, 0, 0, 'L');

	// ***************************************************
	// Date du document
	$this->pdf->SetXY(101, 31);
	$date_lib = "Date";
	$this->pdf->Cell (13, 3, $date_lib, 0, 0, 'L');
	$this->pdf->Cell (3, 3, ":", 0, 0, 'L');
	$this->pdf->Cell (40, 3, date_Us_to_Fr($this->date_creation), 0, 0, 'L');

	return true;
}


// Créé le corps du PDF
protected function create_pdf_corps () {
	global $AFF_REMISES;
	global $CORPS_HAUTEUR_DEPART;
	global $CORPS_HAUTEUR_MAX;

	$this->decalage_corps_actuel	= 0;
	
	// ***************************************************
	// Cadre de texte à rajouter
	                            			
		$this->pdf->SetXY($this->MARGE_GAUCHE, $this->NOTE_HAUTEUR_DEPART);    //affichage du cadre de texte
		$this->pdf->Cell (180,$this->NOTE_HAUTEUR_MAX, "", 1, 0, 'L'); 
		$this->pdf->SetXY($this->MARGE_GAUCHE, $this->NOTE_HAUTEUR_DEPART);
		$this->pdf->SetFont('Arial', 'B', 8);
		$note = $this->document->getDescription();
		$nb_lignes = 0;
		$decoup_note = explode('<br>', $note);	
		$retour_lignes = array();
			
			for ($i=0; $i<count($decoup_note);$i++) {
				$nb_lignes += ceil($this->pdf->GetStringWidth($decoup_note[$i]) / ($this->LARGEUR_TOTALE_CORPS-4));
					if ($nb_lignes > $this->NB_LIGNES_DESC) {    
							break;
					} else {
							$retour_lignes[] = $decoup_note[$i];
							$this->pdf->Cell (180,6, strip_tags($retour_lignes[$i]), 0, 2, 'L');
								}
			}	
			

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
	//$this->pdf->Cell ($this->LARGEUR_COL_REF, 6, $this->ENTETE_COL_REF, 1, 0, 'L');
	$this->pdf->Cell ($this->LARGEUR_COL_LIB, 6, $this->ENTETE_COL_DES, 1, 0, 'L');
	$this->pdf->Cell ($this->LARGEUR_COL_QTE, 6, $this->ENTETE_COL_QTE, 1, 0, 'C');
	$this->pdf->Cell ($this->LARGEUR_COL_PRI, 6, $this->ENTETE_COL_PU, 1, 0, 'C');
	//if ($AFF_REMISES) {
	//	$this->pdf->Cell ($this->LARGEUR_COL_REM, 6, $this->ENTETE_COL_REM, 1, 0, 'C');
	//}
	$this->pdf->Cell ($this->LARGEUR_COL_PRI, 6, $this->ENTETE_COL_PT, 1, 0, 'C');
	//$this->pdf->Cell ($this->LARGEUR_COL_TVA, 6, $this->ENTETE_COL_TVA, 1, 0, 'C');


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
	if (!isset($line->ref_interne)) 	{ $line->ref_interne = ""; 			}
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
	if ($this->app_tarifs == "TTC") {
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
			$line->lib_article .= "".$line->pt." ".$MONNAIE[0]." ".$this->app_tarifs;
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
	//if (!$line->ref_interne) {
	//$this->pdf->Cell($this->LARGEUR_COL_REF, $hauteur, $line->ref_article, $cadre, 0, 'L', $fill);
	//} else {
	//$this->pdf->Cell($this->LARGEUR_COL_REF, $hauteur, $line->ref_interne, $cadre, 0, 'L', $fill);
	//}
	$this->pdf->Cell($this->LARGEUR_COL_LIB, $hauteur, $line->lib_article, $cadre, 0, 'L', $fill);
	$this->pdf->Cell($this->LARGEUR_COL_QTE, $hauteur, $line->qte, $cadre, 0, 'C', $fill);
	$this->pdf->Cell($this->LARGEUR_COL_PRI, $hauteur, $line->pu, $cadre, 0, 'R', $fill);
	//if ($AFF_REMISES) {
	//	$this->pdf->Cell($this->LARGEUR_COL_REM, $hauteur, $line->remise, $cadre, 0, 'R', $fill);
	//}
	$this->pdf->Cell($this->LARGEUR_COL_PRI, $hauteur, $line->pt, $cadre, 0, 'R', $fill);
	//$this->pdf->Cell($this->LARGEUR_COL_TVA, $hauteur, $line->tva, $cadre, 0, 'C', $fill);


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
		$this->pdf->Cell ($this->LARGEUR_TOTALE_CORPS, 4.5, '', '0', 2, 'L');//$texte
	}

	$this->pdf->SetXY(0, $this->PIEDS_HAUTEUR_DEPART + $this->PIEDS_HAUTEUR_MAX + 1);
	foreach ($this->PIEDS_DROIT as $texte) {
		$this->pdf->Cell ($this->MARGE_GAUCHE + $this->LARGEUR_TOTALE_CORPS, 4.5, '', '0', 2, 'R');//$texte
	}

	// Bloc Montant Total
	$largeur_bloc_montant = 61;
	$largeur_col1_montant = 30;
	$largeur_col2_montant = 3;
	$largeur_col3_montant = $largeur_bloc_montant - $largeur_col1_montant - $largeur_col2_montant;

	$this->pdf->SetXY($this->MARGE_GAUCHE + $this->LARGEUR_TOTALE_CORPS - $largeur_bloc_montant, $this->PIEDS_HAUTEUR_DEPART);
	$this->pdf->SetFont('Arial', 'B', 10);
	$this->pdf->Cell ($largeur_bloc_montant, 8, "MONTANT TOTAL EN ".$MONNAIE[2], '1', 2, 'C');

	$this->pdf->Cell ($largeur_col1_montant, 7, "Montant HT", 'L', 0, 'L');
	$this->pdf->Cell ($largeur_col2_montant, 7, ":", '0', 0, 'C');
	$this->pdf->Cell ($largeur_col3_montant, 7, price_format ($this->montant_ht)."  ", '0', 2, 'R');
	$this->pdf->SetX ($this->MARGE_GAUCHE + $this->LARGEUR_TOTALE_CORPS - $largeur_bloc_montant);

	$this->pdf->Cell ($largeur_col1_montant, 7, "Montant TVA", 'L', 0, 'L');
	$this->pdf->Cell ($largeur_col2_montant, 7, ":", '0', 0, 'C');
	$this->pdf->Cell ($largeur_col3_montant, 7, price_format ($this->montant_tva)."  ", '0', 2, 'R');
	$this->pdf->SetX ($this->MARGE_GAUCHE + $this->LARGEUR_TOTALE_CORPS - $largeur_bloc_montant);

	$this->pdf->SetFont('Arial', 'B', 13);
	$this->pdf->Cell ($largeur_col1_montant, 10, "Montant TTC", 'LTB', 0, 'L');
	$this->pdf->Cell ($largeur_col2_montant, 10, ":", 'TB', 0, 'C');
	$this->pdf->Cell ($largeur_col3_montant, 10, price_format ($this->montant_ttc)."  ", 'TBR', 2, 'R');
	
	// Bloc TVA
	//$largeur_bloc_tva = 40;
	$largeur_col1_tva = 20;
	//$largeur_col2_tva = $largeur_bloc_tva - $largeur_col1_tva;

	$this->pdf->SetXY($this->MARGE_GAUCHE + $this->LARGEUR_TOTALE_CORPS-$largeur_bloc_montant-$largeur_col1_tva,$this->PIEDS_HAUTEUR_DEPART );
	$this->pdf->SetFont('Arial', 'B', 10);
	$this->pdf->Cell ($largeur_col1_tva, 8, "Taux TVA", '1', 2, 'C');  //ici c'est "taux tva"
	$this->pdf->Cell ($largeur_col1_tva, 24, "" , '1', 0, 'C');
	//$this->pdf->Cell ($largeur_col2_tva, 8, "Montant", '1', 2, 'C');
	$this->pdf->SetXY($this->MARGE_GAUCHE + $this->LARGEUR_TOTALE_CORPS-$largeur_bloc_montant-$largeur_col1_tva,$this->PIEDS_HAUTEUR_DEPART+5 );
	foreach ($this->tvas as $tva => $montant_tva) {
		if ($tva != "0") {
	$this->pdf->Cell ($largeur_col1_tva, 24, $tva."%" , '0', 0, 'C');
	$this->pdf->SetXY($this->MARGE_GAUCHE + $this->LARGEUR_TOTALE_CORPS-$largeur_bloc_montant-$largeur_col1_tva,$this->PIEDS_HAUTEUR_DEPART+10 );
		}
	}
	$this->pdf->SetX($this->MARGE_GAUCHE + $this->LARGEUR_TOTALE_CORPS-$largeur_bloc_montant-$largeur_col1_tva);
	
	$this->pdf->SetFont('Arial', '', 9);
	
	//foreach ($this->tvas as $tva => $montant_tva) {
	//	if (!$montant_tva) { continue; }
	//	$this->pdf->Cell ($largeur_col1_tva, 6, $tva." %", 'R', 0, 'C');
		//$this->pdf->Cell ($largeur_col2_tva, 6, price_format ($montant_tva)."  ", 'R', 2, 'R');
	//	$this->pdf->SetX($this->LARGEUR_TOTALE_CORPS-$largeur_bloc_montant-$largeur_col1_tva);
	//}
	//while ($this->pdf->getY() < $this->PIEDS_HAUTEUR_DEPART + $this->PIEDS_HAUTEUR_MAX) {
	//	$this->pdf->Cell ($largeur_col1_tva, 1, "", 'R', 0, 'C');
	//	$this->pdf->Cell ($largeur_col2_tva, 1, "", 'R', 2, 'C');
	//	$this->pdf->SetX($this->LARGEUR_TOTALE_CORPS-$largeur_bloc_montant-$largeur_col1_tva);
	//}
	
	// Bloc central
	// Bloc central
	$this->pdf->SetXY($this->MARGE_GAUCHE, $this->PIEDS_HAUTEUR_DEPART);
	$this->pdf->SetFont('Arial', '', 9);
	$this->pdf->Cell ($this->LARGEUR_TOTALE_CORPS-$largeur_bloc_montant-$largeur_col1_tva, 8,"Conditions de règlement..." , '1', 0, 'L');
	$this->pdf->SetXY($this->MARGE_GAUCHE, $this->PIEDS_HAUTEUR_DEPART+8);
	$this->pdf->SetFont('Arial', '', 7);
	$this->pdf->Cell ($this->LARGEUR_TOTALE_CORPS-$largeur_bloc_montant-$largeur_col1_tva, 6,"Mention manuscrite « Bon pour accord » + Tampon & Signature" , '0', 0, 'L');
	
}

}

?>
