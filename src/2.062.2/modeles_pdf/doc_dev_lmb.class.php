<?PHP 
// *************************************************************************************************************
// CLASSE DE GENERATION D'UN DOCUMENT PDF - MODELE STANDARD DEVIS CLIENT
// *************************************************************************************************************
require_once($PDF_MODELES_DIR."doc_standard.class.php");

class pdf_content_doc_dev_lmb extends pdf_content_doc_standard {
	var $code_pdf_modele = "doc_dev_lmb";

	var $texte_corps_pieds;


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
	$largeur_bloc_tva = 40;
	$largeur_col1_tva = 20;
	$largeur_col2_tva = $largeur_bloc_tva - $largeur_col1_tva;

	$this->pdf->SetXY($this->MARGE_GAUCHE, $this->PIEDS_HAUTEUR_DEPART);
	$this->pdf->SetFont('Arial', 'B', 10);
	$this->pdf->Cell ($largeur_col1_tva, 8, "Taux TVA", '1', 0, 'C');
	$this->pdf->Cell ($largeur_col2_tva, 8, "Montant", '1', 2, 'C');
	$this->pdf->SetX($this->MARGE_GAUCHE);
	$this->pdf->SetFont('Arial', '', 9);
	foreach ($this->tvas as $tva => $montant_tva) {
		if (!$montant_tva) { continue; }
		$this->pdf->Cell ($largeur_col1_tva, 6, $tva." %", 'R', 0, 'C');
		$this->pdf->Cell ($largeur_col2_tva, 6, price_format ($montant_tva)."  ", 'R', 2, 'R');
		$this->pdf->SetX($this->MARGE_GAUCHE);
	}
	while ($this->pdf->getY() < $this->PIEDS_HAUTEUR_DEPART + $this->PIEDS_HAUTEUR_MAX) {
		$this->pdf->Cell ($largeur_col1_tva, 1, "", 'R', 0, 'C');
		$this->pdf->Cell ($largeur_col2_tva, 1, "", 'R', 2, 'C');
		$this->pdf->SetX($this->MARGE_GAUCHE);
	}
	
	// Bloc central
	// Bloc central
	$this->pdf->SetXY($this->MARGE_GAUCHE + $largeur_bloc_tva, $this->PIEDS_HAUTEUR_DEPART);
	$this->pdf->SetFont('Arial', '', 9);
	$this->pdf->Cell ($this->LARGEUR_TOTALE_CORPS-$largeur_bloc_montant-$largeur_bloc_tva, 8,"Conditions de règlement..." , '1', 0, 'L');
	$this->pdf->SetXY($this->MARGE_GAUCHE + $largeur_bloc_tva, $this->PIEDS_HAUTEUR_DEPART+8);
	$this->pdf->SetFont('Arial', '', 7);
	$this->pdf->Cell ($this->LARGEUR_TOTALE_CORPS-$largeur_bloc_montant-$largeur_bloc_tva, 6,"Mention manuscrite « Bon pour accord » + Tampon & Signature" , '0', 0, 'L');
	
}

}

?>