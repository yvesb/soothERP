<?php
// *************************************************************************************************************
// FONCTIONS PERMETTANT LA GENERATION D'UN COURRIER PDF - MODELE LMB
// *************************************************************************************************************
// Ce script est appelé depuis _pdf.class.php->add_courrier_lmb()
// $this 			réfère donc à un objet de la classe PDF
// $courrier	réfère au courrier que l'on intègre au PDF

function add_courrier_lmb ($pdf, $courrier){
	global $PDF_MODELES_DIR;

	if (!isset($courrier)) { 
		$erreur = "Aucun document transmit pour la création du PDF";
		alerte_dev ($erreur);
	}
	include_once ($PDF_MODELES_DIR."config/".$courrier->code_pdf_modele.".config.php");
}

class pdf_courrier_lmb{
	
	var $code_pdf_modele = "courrier_lmb";
	var $pdf;
	
	public function pdf_courrier_lmb(&$pdf) {
		global $PDF_MODELES_DIR;
		include ($PDF_MODELES_DIR."config/".$this->code_pdf_modele.".config.php");
		$this->pdf = $pdf;
	}
	
	public function getHeader() {		
	$this->pdf->lMargin = 15;
		return '$this->SetFont("Arial","B",15);
			$this->Ln(0);
		    $this->Cell(70,10,"COURRIER LMB",0,0,"L");
		    $this->Ln(20);';
	} 
	
	public function getFooter() {
		return '$this->SetY(-15);
		    //Arial italic 8
		    $this->SetFont("Arial","I",8);
		    //Page number
		    $this->Cell(0,10,"Page ".$this->PageNo()."/{nb}",0,0,"C");';
	}

	public function writePdf() {	
		$this->pdf->AliasNbPages();
		$this->pdf->SetAutoPageBreak(true,30);
		$this->pdf->AddPage("L"); //paysage
		$this->pdf->SetFont('Times','',12);
		$this->pdf->SetXY(25,50);
		$this->pdf->SetFillColor(0, 255, 0);
		
		$this->pdf->Ln();
		$this->pdf->Cell(40,10,"COURRIER LMB !");
		$this->pdf->Ln();
	}
}
?>