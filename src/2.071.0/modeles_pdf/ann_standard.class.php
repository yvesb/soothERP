<?php

class pdf_ann_standard {
	var $code_pdf_modele = "ann_standard";
	var $pdf;
	var $contact;
	
	public function pdf_ann_standard(&$pdf, $contact) {
		global $ANN_STANDARD;
		global $PDF_MODELES_DIR;
		
		include ($PDF_MODELES_DIR."config/".$this->code_pdf_modele.".config.php");
		
		foreach ($ANN_STANDARD as $var => $valeur) {
				$this->{$var} = $valeur;
		}
		
		$this->pdf = $pdf;
		$this->contact = $contact;
		
	}
	
		public function getHeader() {		
	
//$this->Image("'.$this->CHEMIN_LOGO.'", '.$this->MARGE_GAUCHE.'-15, '.$this->MARGE_HAUT.'-18, 70);
		return 
				'$this->SetFont("Arial","B",17);
				$this->SetXY('.$this->MARGE_GAUCHE.'-10, '.$this->MARGE_HAUT.');
				$this->Cell(100,10, "'.addslashes($this->contact->getNom ()).'", 0,0,"L");

				
				$this->Code39('.$this->MARGE_GAUCHE.'-10, '.$this->MARGE_HAUT.'+12, "'.$this->contact->getRef_contact ().'", 0.8, 5);
				$this->SetXY('.$this->MARGE_GAUCHE.'-10, '.$this->MARGE_HAUT.'+17);
				$this->SetFont("Arial","B",11);
				$this->Cell(50,7,"Référence : '.$this->contact->getRef_contact ().'",0,0,"L");
				

				';
	} 
	
	public function getFooter() {
		return '';
	}
	
	public function writePdf() {	
	
	
		$this->adresse = $this->contact->getAdresses ();
		$this->coordonnees = $this->contact->getCoordonnees ();
		$this->pdf->AliasNbPages();
		$this->pdf->AddPage();
		
		
		$this->pdf->SetXY(10,40);
		$this->pdf->SetFont('Arial','B',9);
		
		$this->pdf->SetDrawColor(200,200,200);
		$this->pdf->Cell(190,35,"",1,0); // cadre Informations Générales
		$this->pdf->SetDrawColor(0,0,0);
		
		$this->pdf->SetXY(15, 42);
		$this->pdf->SetTextColor(153, 204, 51);
		$this->pdf->SetFont('Arial','B',11);
		$this->pdf->Cell(40,5,"Informations Générales",0,2);
		$this->pdf->SetFont('Arial','B',9);
		$this->pdf->SetTextColor(0,0,0);
		
		$this->pdf->SetTextColor(200,200,200);
		$this->pdf->Cell(20,10,"Civilité :",0,0);
		$this->pdf->SetTextColor(0,0,0);
		$this->pdf->Cell(70,10,$this->contact->getLib_civ_court (),0,0);
		
		
		$this->pdf->SetTextColor(200,200,200);
		$this->pdf->Cell(30,10,"Tva Intra :",0,0);
		$this->pdf->SetTextColor(0,0,0);
		$this->pdf->Cell(60,10,$this->contact->getTva_intra (),0,0);
		
		$this->pdf->SetXY(15, 54);
		$this->pdf->SetTextColor(200,200,200);
		$this->pdf->Cell(20,10,"Type :",0,0);
		$this->pdf->SetTextColor(0,0,0);
		$this->pdf->Cell(70,10,$this->contact->getLib_Categorie (),0,0);
		
		
		$this->pdf->SetXY(15, 62);
		$this->pdf->SetTextColor(200,200,200);
		$this->pdf->Cell(20,10,"N°Siret :",0,0);
		$this->pdf->SetTextColor(0,0,0);
		$this->pdf->Cell(70,10,$this->contact->getSiret (),0,0);
		
		
		
		//pour obtenir la 1ere adresse
		                 
		
		$this->pdf->SetXY(10,80);
		
		$this->pdf->SetDrawColor(200,200,200);
		$this->pdf->Cell(90,55,"",1,2);    // cadre Adresse 1
		$this->pdf->SetDrawColor(0,0,0);
		
		$this->pdf->SetXY(15,82);
		$this->pdf->SetTextColor(153, 204, 51);
		$this->pdf->SetFont('Arial','B',11);
		$this->pdf->Cell(85,8,"Adresse",0,2);
		$this->pdf->SetFont('Arial','B',9);
		$this->pdf->SetTextColor(0,0,0);
		
		$this->pdf->SetTextColor(200,200,200);
		$this->pdf->Cell(25,6,"Adresse :",0,0);
		$this->pdf->SetTextColor(0,0,0);
		
		//$this->pdf->Cell(60,6,$add_livraison->getLib_adresse (),0,2);
		if (isset($this->adresse[0])) {
		$add1 = wordwrap($this->adresse[0]->getText_adresse(),35,"<br />\n");
		$tabadd1 = explode ("<br />",$add1);
		for ($i=0;$i<count($tabadd1);$i++) {
			$this->pdf->Cell(60,6,$tabadd1[$i],0,2);
			if ($i == 2) {break;}}
		}
		$this->pdf->SetXY(15,109);
		$this->pdf->SetTextColor(200,200,200);
		$this->pdf->Cell(25,8,"Code postal :",0,0);
		$this->pdf->SetTextColor(0,0,0);
		if (isset($this->adresse[0])) {
		$this->pdf->Cell(60,8,$this->adresse[0]->getCode_postal (),0,2);
		}
		
		$this->pdf->SetXY(15,117);
		$this->pdf->SetTextColor(200,200,200);
		$this->pdf->Cell(25,8,"Ville :",0,0);
		$this->pdf->SetTextColor(0,0,0);
		if (isset($this->adresse[0])) {
		$this->pdf->Cell(60,8,$this->adresse[0]->getVille (),0,2);}
		
		$this->pdf->SetXY(15,125);
		$this->pdf->SetTextColor(200,200,200);
		$this->pdf->Cell(25,8,"Pays :",0,0);
		$this->pdf->SetTextColor(0,0,0);
		if (isset($this->adresse[0])) {
		$this->pdf->Cell(60,8,$this->adresse[0]->getPays (),0,2);}
		
		$this->pdf->SetXY(110,80);
		
		
		if(!empty($this->coordonnees[0])){
			$this->pdf->SetDrawColor(200,200,200);
			$this->pdf->Cell(90,55,"",1,2);    // cadre Coordonnées
			$this->pdf->SetDrawColor(0,0,0);
			
			$this->pdf->SetXY(115,82);
			$this->pdf->SetTextColor(153, 204, 51);
			$this->pdf->SetFont('Arial','B',11);
			$libcoord = $this->coordonnees[0]->getLib_coord();
			if(isset($libcoord)) {
			$this->pdf->Cell(85,8,"Coordonnées (".$libcoord.")",0,2);
			unset($libcoord);
			}else{
			$this->pdf->Cell(85,8,"Coordonnées",0,2);
			}
			$this->pdf->SetFont('Arial','B',9);
			$this->pdf->SetTextColor(0,0,0);
			
			$this->pdf->SetTextColor(200,200,200);
			$this->pdf->Cell(22,8,"Téléphone :",0,0);
			$this->pdf->SetTextColor(0,0,0);
			if (isset($this->coordonnees[0])) {
			$this->pdf->Cell(65,8,$this->coordonnees [0]->getTel1 (),0,2);}
			
			$this->pdf->SetXY(115,98);
			$this->pdf->SetTextColor(200,200,200);
			$this->pdf->Cell(22,8,"Téléphone 2 :",0,0);
			$this->pdf->SetTextColor(0,0,0);
			if (isset($this->coordonnees[0])) {
			$this->pdf->Cell(65,8,$this->coordonnees [0]->getTel2 (),0,2);}
			
			$this->pdf->SetXY(115,106);
			$this->pdf->SetTextColor(200,200,200);
			$this->pdf->Cell(22,8,"Fax :",0,0);
			$this->pdf->SetTextColor(0,0,0);
			if (isset($this->coordonnees[0])) {
			$this->pdf->Cell(65,8,$this->coordonnees [0]->getFax (),0,2);}
			
			$this->pdf->SetXY(115,114);
			$this->pdf->SetTextColor(200,200,200);
			$this->pdf->Cell(22,8,"Email :",0,0);
			$this->pdf->SetTextColor(0,0,0);
			if (isset($this->coordonnees[0])) {
			$this->pdf->Cell(65,8,$this->coordonnees [0]->getEmail (),0,2);}
			
			$this->pdf->SetXY(115,122);
			$this->pdf->SetTextColor(200,200,200);
			$this->pdf->Cell(22,6,"Note :",0,0);
			$this->pdf->SetTextColor(0,0,0);
			if (isset($this->coordonnees[0])) {
			$note = wordwrap($this->coordonnees [0]->getNote (), 35, "<br />\n");
			$tabnote = explode ("<br />",$note);
			for ($i=0;$i<count($tabnote);$i++) {
				$this->pdf->Cell(65,6,$tabnote[$i],0,2);
				if ($i == 3) {break;}
			}
			}
		}
		
		if(isset($this->coordonnees[1])) {
        $this->pdf->SetXY(110,140);
		
		$this->pdf->SetDrawColor(200,200,200);
		$this->pdf->Cell(90,55,"",1,2);    // cadre Coordonnées 2
		$this->pdf->SetDrawColor(0,0,0);
		
		$this->pdf->SetXY(115,60+82);
		$this->pdf->SetTextColor(153, 204, 51);
		$this->pdf->SetFont('Arial','B',11);
		$libcoord = $this->coordonnees[1]->getLib_coord();
		if(isset($libcoord)) {
		$this->pdf->Cell(85,8,"Coordonnées (".$libcoord.")",0,2);
		}else{
		$this->pdf->Cell(85,8,"Coordonnées",0,2);
		}
		$this->pdf->SetFont('Arial','B',9);
		$this->pdf->SetTextColor(0,0,0);
		
		$this->pdf->SetTextColor(200,200,200);
		$this->pdf->Cell(22,8,"Téléphone :",0,0);
		$this->pdf->SetTextColor(0,0,0);
		if (isset($this->coordonnees[1])) {
		$this->pdf->Cell(65,8,$this->coordonnees [1]->getTel1 (),0,2);}
		
		$this->pdf->SetXY(115,60+98);
		$this->pdf->SetTextColor(200,200,200);
		$this->pdf->Cell(22,8,"Téléphone 2 :",0,0);
		$this->pdf->SetTextColor(0,0,0);
		if (isset($this->coordonnees[1])) {
		$this->pdf->Cell(65,8,$this->coordonnees [1]->getTel2 (),0,2);}
		
		$this->pdf->SetXY(115,60+106);
		$this->pdf->SetTextColor(200,200,200);
		$this->pdf->Cell(22,8,"Fax :",0,0);
		$this->pdf->SetTextColor(0,0,0);
		if (isset($this->coordonnees[1])) {
		$this->pdf->Cell(65,8,$this->coordonnees [1]->getFax (),0,2);}
		
		$this->pdf->SetXY(115,60+114);
		$this->pdf->SetTextColor(200,200,200);
		$this->pdf->Cell(22,8,"Email :",0,0);
		$this->pdf->SetTextColor(0,0,0);
		if (isset($this->coordonnees[1])) {
		$this->pdf->Cell(65,8,$this->coordonnees [1]->getEmail (),0,2);}
		
		$this->pdf->SetXY(115,60+122);
		$this->pdf->SetTextColor(200,200,200);
		$this->pdf->Cell(22,6,"Note :",0,0);
		$this->pdf->SetTextColor(0,0,0);
		if (isset($this->coordonnees[1])) {
		$note = wordwrap($this->coordonnees [1]->getNote (), 35, "<br />\n");
		$tabnote = explode ("<br />",$note);
		for ($i=0;$i<count($tabnote);$i++) {
			$this->pdf->Cell(65,6,$tabnote[$i],0,2);
			if ($i == 3) {break;}
		}
		}
		}
		
		//pour obtenir l'adresse 2
		
		
		$this->pdf->SetXY(10,140);
		
		$this->pdf->SetDrawColor(200,200,200);
		$this->pdf->Cell(90,55,"",1,2);    // cadre Adresse n°2
		$this->pdf->SetDrawColor(0,0,0);
		
		$this->pdf->SetXY(15,142);
		$this->pdf->SetTextColor(153, 204, 51);
		$this->pdf->SetFont('Arial','B',11);
		$this->pdf->Cell(85,8,"Adresse",0,2);
		$this->pdf->SetFont('Arial','B',9);
		$this->pdf->SetTextColor(0,0,0);
		
		$this->pdf->SetTextColor(200,200,200);
		$this->pdf->Cell(25,6,"Adresse :",0,0);
		$this->pdf->SetTextColor(0,0,0);
		//$this->pdf->Cell(60,6,$add_facturation->getLib_adresse (),0,2);
		if (isset($this->adresse[1])) {
		$add2 = wordwrap($this->adresse[1]->getText_adresse (),35,"<br />\n");
		$tabadd2 = explode ("<br />",$add2);
		for ($i=0;$i<count($tabadd2);$i++) {
			$this->pdf->Cell(60,6,$tabadd2[$i],0,2);
			if ($i == 2) {break;}}
			}

		$this->pdf->SetXY(15,169);
		$this->pdf->SetTextColor(200,200,200);
		$this->pdf->Cell(25,8,"Code postal :",0,0);
		$this->pdf->SetTextColor(0,0,0);
		if (isset($this->adresse[1])) {
		$this->pdf->Cell(60,8,$this->adresse[1]->getCode_postal (),0,2);}
		
		$this->pdf->SetXY(15,177);
		$this->pdf->SetTextColor(200,200,200);
		$this->pdf->Cell(25,8,"Ville :",0,0);
		$this->pdf->SetTextColor(0,0,0);
		if (isset($this->adresse[1])) {
		$this->pdf->Cell(60,8,$this->adresse[1]->getVille (),0,2);}
		
		$this->pdf->SetXY(15,185);
		$this->pdf->SetTextColor(200,200,200);
		$this->pdf->Cell(25,8,"Pays :",0,0);
		$this->pdf->SetTextColor(0,0,0);
		if (isset($this->adresse[1])) {
		$this->pdf->Cell(60,8,$this->adresse[1]->getPays (),0,2);}
		
		$this->pdf->SetXY(10,200);
		
		$this->pdf->SetDrawColor(200,200,200);
		$this->pdf->Cell(190,80,"",1,2);    // cadre Notes
		
		$this->pdf->Line(15, 220, 180, 220);
		$this->pdf->Line(15, 235, 180, 235);
		$this->pdf->Line(15, 250, 180, 250);
		$this->pdf->Line(15, 265, 180, 265);
		
		$this->pdf->SetDrawColor(0,0,0);
		
		$this->pdf->SetXY(15,205);
		$this->pdf->SetTextColor(153, 204, 51);
		$this->pdf->SetFont('Arial','B',11);
		$this->pdf->Cell(85,5,"NOTES",0,2);
		$this->pdf->SetFont('Arial','B',9);
		$this->pdf->SetTextColor(0,0,0);
		$note = $this->contact->getNote();
		if(isset($note)) {
		$this->pdf->SetXY(15,210);
		$this->pdf->write(15, $note);
        }
	}
}
?>