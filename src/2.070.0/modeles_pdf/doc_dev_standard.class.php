<?PHP 
// *************************************************************************************************************
// CLASSE PERMETTANT L'AJOUT D'UN DOCUMENT A UN PDF - MODELE STANDARD
// *************************************************************************************************************
require_once($PDF_MODELES_DIR."doc_standard.class.php");

class pdf_content_doc_dev_standard extends pdf_content_doc_standard{
	var $code_pdf_modele = "doc_dev_standard";

	
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
	
		$largeur_bloc_montant = 0;
		$largeur_bloc_tva = 0;
		if(!isset($this->AFF_PRIX) || $this->AFF_PRIX){
			// Bloc Montant Total
			$largeur_bloc_montant = 61;
			$largeur_col1_montant = 30;
			$largeur_col2_montant = 3;
			$largeur_col3_montant = $largeur_bloc_montant - $largeur_col1_montant - $largeur_col2_montant;
		
			$this->pdf->SetXY($this->MARGE_GAUCHE + $this->LARGEUR_TOTALE_CORPS - $largeur_bloc_montant, $this->PIEDS_HAUTEUR_DEPART);
			$this->pdf->SetFont('Arial', 'B', 10);
			$this->pdf->Cell ($largeur_bloc_montant, 6, "MONTANT TOTAL EN ".$MONNAIE[2], '1', 2, 'C');
		
			$this->pdf->Cell ($largeur_col1_montant, 7, "Montant HT", 'L', 0, 'L');
			$this->pdf->Cell ($largeur_col2_montant, 7, ":", '0', 0, 'C');
			$this->pdf->Cell ($largeur_col3_montant, 7, price_format ($this->montant_ht)."  ", '0', 2, 'R');
			$this->pdf->SetX ($this->MARGE_GAUCHE + $this->LARGEUR_TOTALE_CORPS - $largeur_bloc_montant);
		
			$this->pdf->Cell ($largeur_col1_montant, 7, "Montant TVA", 'L', 0, 'L');
			$this->pdf->Cell ($largeur_col2_montant, 7, ":", '0', 0, 'C');
			$this->pdf->Cell ($largeur_col3_montant, 7, price_format ($this->montant_tva)."  ", '0', 2, 'R');
			$this->pdf->SetX ($this->MARGE_GAUCHE + $this->LARGEUR_TOTALE_CORPS - $largeur_bloc_montant);
		
			$this->pdf->SetFont('Arial', 'B', 13);
			$this->pdf->Cell ($largeur_col1_montant, 12, "Montant TTC", 'LTB', 0, 'L');
			$this->pdf->Cell ($largeur_col2_montant, 12, ":", 'TB', 0, 'C');
			$this->pdf->Cell ($largeur_col3_montant, 12, price_format ($this->montant_ttc)."  ", 'TBR', 2, 'R');
			
					// Bloc TVA
			$largeur_bloc_tva = 40;
			$largeur_col1_tva = 20;
			$largeur_col2_tva = $largeur_bloc_tva - $largeur_col1_tva;
		
			$this->pdf->SetXY($this->MARGE_GAUCHE, $this->PIEDS_HAUTEUR_DEPART);
			$this->pdf->SetFont('Arial', 'B', 10);
			$this->pdf->Cell ($largeur_col1_tva, 6, "Taux TVA", '1', 0, 'C');
			$this->pdf->Cell ($largeur_col2_tva, 6, "Montant", '1', 2, 'C');
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
			
			//Affichage des reglements
			//nombre d'echeance max et pas de reglement dans un devis
			$reglements=$this->document->get_conditions_reglement($this->line_ech_max,0);
			$decalage = 0;
			foreach($reglements as $reglement) 
			{
				$this->pdf->SetXY($this->MARGE_GAUCHE + $largeur_bloc_tva, $this->PIEDS_HAUTEUR_DEPART+($decalage*3)+6);
				$this->pdf->SetFont('Arial', '', 7);
				$date_reglement = "";
				
				//Si aCCompte ou Arrhes
				if($reglement->type_reglement=="Acompte" || $reglement->type_reglement=="Arrhes")
				{
					if($reglement->pourcentage!="")
					{
						$this->pdf->Cell (25, 3, $reglement->type_reglement, '0', 0, 'L');
						$this->pdf->Cell (30, 3,$reglement->pourcentage."%", '0', 0, 'C');
						
						//Affichage du mode de reglement selectionné si il existe
						if($reglement->mode_reglement!="")
						{
							$this->pdf->Cell (17, 3,$reglement->montant, '0', 0, 'R');
							$this->pdf->Cell (6, 3,$reglement->mode_reglement, '0', 1, 'R');
						}
						else
							$this->pdf->Cell (17, 3,$reglement->montant, '0', 1, 'R');
					}
					else
					{
						$this->pdf->Cell (60, 3, $reglement->type_reglement, '0', 0, 'L');
						
						//Affichage du mode de reglement selectionné si il existe
						if($reglement->mode_reglement!="")
						{
							$this->pdf->Cell (12, 3,$reglement->montant, '0', 0, 'R');
							$this->pdf->Cell (6, 3,$reglement->mode_reglement, '0', 1, 'R');
						}
						else
							$this->pdf->Cell (12, 3,$reglement->montant, '0', 1, 'R');
					}
				}
				else if($reglement->type_reglement=="Echeance"||$reglement->type_reglement=="Solde")
				{
                                    // _vardump($reglement);
					if($reglement->pourcentage!="")
					{
                                             if(strpos ($reglement->jour,"facturation"))
                                                $this->pdf->Cell (25, 3, $reglement->type_reglement.$reglement->jour, '0', 0, 'L');
                                            else
                                            {
                                                //Si c'est une date
                                                if(!strpos($reglement->jour,"-"))
                                                {
                                                    $this->pdf->Cell (25, 3, $reglement->type_reglement." à ".$reglement->jour." jours", '0', 0, 'L');
                                                }
                                                 else
                                                 {
                                                    $this->pdf->Cell (25, 3, $reglement->type_reglement." le ".$reglement->jour, '0', 0, 'L');
                                                 }
                                            }
						$this->pdf->Cell (30, 3,$reglement->pourcentage."%", '0', 0, 'C');
						
						//Affichage du mode de reglement selectionné si il existe
						if($reglement->mode_reglement!="")
						{
							$this->pdf->Cell (17, 3,$reglement->montant, '0', 0, 'R');
							$this->pdf->Cell (6, 3,$reglement->mode_reglement, '0', 1, 'R');
						}
						else
						{
							$this->pdf->Cell (17, 3,$reglement->montant, '0', 1, 'R');
						}
					}
					else
					{
                                            if(strpos ($reglement->jour,"facturation"))
                                                $this->pdf->Cell (60, 3, $reglement->type_reglement.$reglement->jour, '0', 0, 'L');
                                            else
                                            {
                                                //Si c'est une date
                                                if(!strpos($reglement->jour,"-"))
                                                {
                                                    $this->pdf->Cell (25, 3, $reglement->type_reglement." à ".$reglement->jour." jours", '0', 0, 'L');
                                                }
                                                 else
                                                 {
                                                    $this->pdf->Cell (25, 3, $reglement->type_reglement." le ".$reglement->jour, '0', 0, 'L');
                                                 }
                                            }
						//Affichage du mode de reglement selectionné si il existe
						if($reglement->mode_reglement!="")
						{
							$this->pdf->Cell (12, 3,$reglement->montant, '0', 0, 'R');
							$this->pdf->Cell (6, 3,$reglement->mode_reglement, '0', 1, 'R');
						}
						else
						{
							$this->pdf->Cell (12, 3,$reglement->montant, '0', 1, 'R');
						}
					}
				}
				else if($reglement->type_reglement=="EcheanceResume")
				{
					$chaine="Solde en ".$reglement->echeance_restantes." fois du ".$reglement->date_solde_debut." au ".$reglement->date_solde_fin;
					$this->pdf->Cell ($this->LARGEUR_TOTALE_CORPS-$largeur_bloc_montant-$largeur_bloc_tva, 4, $chaine, '0', 0, 'L');
				}
				else if($reglement->type_reglement=="Reglement")
				{
					$this->pdf->Cell (57, 4, "Règlement le ".$reglement->date_reglement, '0', 0, 'L');
					$this->pdf->Cell (1, 4,$reglement->montant." ".$reglement->mode_reglement, '0', 0, 'L');
				}
				else if($reglement->type_reglement=="ReglementResume")
				{
					$this->pdf->Cell (57, 4, $reglement->nb_reglement_restant." autres règlements", '0', 0, 'L');
					$this->pdf->Cell (1, 4,$reglement->montant, '0', 0, 'L');
				}
				else
				{
					$chaine="Erreur";
					$this->pdf->Cell ($this->LARGEUR_TOTALE_CORPS-$largeur_bloc_montant-$largeur_bloc_tva, 4, $chaine, '0', 0, 'L');
				}
				$decalage ++;
			}
			
		}	
		// Bloc central
		$this->pdf->SetXY($this->MARGE_GAUCHE + $largeur_bloc_tva, $this->PIEDS_HAUTEUR_DEPART);
		$this->pdf->SetFont('Arial', 'B', 10);
		$this->pdf->Cell ($this->LARGEUR_TOTALE_CORPS-$largeur_bloc_montant-$largeur_bloc_tva, 6, "Conditions de règlement", '1', 0, 'C');
		$this->pdf->SetXY($this->MARGE_GAUCHE + $largeur_bloc_tva, $this->PIEDS_HAUTEUR_DEPART+26);
		$this->pdf->SetFont('Arial', '', 7);
		$this->pdf->Cell ($this->LARGEUR_TOTALE_CORPS-$largeur_bloc_montant-$largeur_bloc_tva, 0,"Mention manuscrite « Bon pour accord » + Tampon & Signature" , '0', 0, 'L');
		$this->pdf->SetXY($this->MARGE_GAUCHE + $largeur_bloc_tva, $this->PIEDS_HAUTEUR_DEPART+24);
		$this->pdf->Cell ($this->LARGEUR_TOTALE_CORPS-$largeur_bloc_montant-$largeur_bloc_tva, 8," " , '1', 0, 'L');
	}
	
}

?>