<?PHP 
// *************************************************************************************************************
// CLASSE DE GENERATION D'UN DOCUMENT PDF - MODELE STANDARD
// *************************************************************************************************************
require_once($PDF_MODELES_DIR."doc_standard.class.php");

class pdf_content_doc_fab_lmb extends pdf_content_doc_standard {
	var $code_pdf_modele = "doc_fab_lmb";

	var $texte_corps_pieds;



// Créé dans l'adresse du PDF
protected function create_pdf_adresse () {
	$decalage_gauche 	= 97;
	$decalage_haut		= 40;
	$hauteur	= 96;
	$largeur	= 45;
	$marge = 4;

	// ***************************************************
	// Code à Barre
	$this->pdf->Code39 ($decalage_gauche + $marge + 1, $decalage_haut +1, $this->ref_doc, 0.9, 7);

	// ***************************************************
	// article à fabriquer et numéros de série
	$this->pdf->SetLeftMargin($decalage_gauche + $marge);
	$this->pdf->RoundedRect ($decalage_gauche, $decalage_haut, $hauteur, $largeur, 4, 'D', '1234');

	if ($this->document->getRef_article() != "" ) {
		$this->pdf->SetXY($decalage_gauche + $marge, $decalage_haut + $marge + 7);
		$this->pdf->SetFont('Arial', '', 10);
		$article_to_fab = new article ($this->document->getRef_article());
		if ($article_to_fab->getRef_interne()) {
		$lib_article = $article_to_fab->getRef_interne()." ".$article_to_fab->getLib_article();
		} else {
		$lib_article = $this->document->getRef_article()." ".$article_to_fab->getLib_article();
		}
		$this->pdf->Write (4, $lib_article );
		
		$qte_fab = $this->document->getQte_fab();
		$this->pdf->SetXY($decalage_gauche + $marge, $decalage_haut + $marge + 12);
		$this->pdf->SetFont('Arial', '', 9);
		$this->pdf->Write (4, "Quantité: ".$qte_fab );
			
		$array_sn = $this->document->getFab_sn ();
		if (count($array_sn)) {
			$this->pdf->SetXY($decalage_gauche + $marge, $decalage_haut + $marge + 16);
			$this->pdf->SetFont('Arial', '', 9);
			$this->pdf->Write (4, "Numéros de série: " );
		}
		
		$fab_sn = implode(", ",$array_sn);
		$this->pdf->SetXY($decalage_gauche + $marge, $decalage_haut + $marge + 20);
		$this->pdf->SetFont('Arial', '', 9);
		$this->pdf->Write (4.5, $fab_sn);
	}
	
	return true;
}


}

?>