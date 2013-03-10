<?PHP 
// *************************************************************************************************************
// CLASSE PERMETTANT L'AJOUT D'UN DOCUMENT A UN PDF - MODELE STANDARD
// *************************************************************************************************************
require_once($PDF_MODELES_DIR."doc_standard.class.php");

class pdf_content_doc_fac_standard extends pdf_content_doc_standard{
	var $code_pdf_modele = "doc_fac_standard";

	
	// Créé l'entete du document PDF
protected function create_pdf_entete () {
	global $IMAGES_DIR;

	$hauteur = $this->MARGE_HAUT;
	// ***************************************************
	// LOGO
	$this->pdf->Image($IMAGES_DIR.$this->IMG_LOGO, $this->MARGE_GAUCHE - 5, $this->MARGE_HAUT, 80);

	// ***************************************************
	// TITRE
	$this->pdf->SetXY(100, $hauteur);
	$this->pdf->SetFont('Times', 'B', 25);
        //Affichage si total négatif
        if ($this->document->getMontant_ttc() < -0.001)
            $this->pdf->Cell (95, 10, $this->LIB_NEG, 0, 0, 'L');
        else
            $this->pdf->Cell (95, 10, $this->lib_type_printed, 0, 0, 'L');

	// ***************************************************
	// Référence du document
	$hauteur += 12;
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
	

	if ($this->document->getId_niveau_relance ()) {
		$liste_niv_relance = $this->document->getNiveaux_relances ();
		foreach ($liste_niv_relance as $niv) {
			if (!$niv->impression || $niv->id_niveau_relance != $this->document->getId_niveau_relance ()) {continue;}
			// ***************************************************
			// niveau de relance
			$this->pdf->SetXY(117, 35);
			$this->pdf->Cell (40, 3, ($niv->lib_niveau_relance), 0, 0, 'L');

		}
	}

	return true;
}

// Créé l'adresse du PDF
protected function create_pdf_adresse () {
	global $bdd;
	$decalage_gauche 	= 97;
	$decalage_haut		= 40;
	$hauteur	= 96;
	$largeur	= 45;
	$marge = 4;

	// ***************************************************
	// Code à Barre
	if(!isset($this->AFF_CODE_BARRE) || $this->AFF_CODE_BARRE==true){
		$this->pdf->Code39 ($decalage_gauche + $marge + 1, $decalage_haut +1, $this->ref_doc, 0.9, 7);
	}
		
	// ***************************************************
	// ADRESSE
	$this->pdf->SetLeftMargin($decalage_gauche + $marge);
	$this->pdf->RoundedRect ($decalage_gauche, $decalage_haut, $hauteur, $largeur, 4, 'D', '1234');

	$this->pdf->SetXY($decalage_gauche + $marge, $decalage_haut + $marge + 7);
	$this->pdf->SetFont('Arial', '', 10);
	$this->pdf->Write (4, $this->nom_contact);

	$this->pdf->SetXY($decalage_gauche + $marge, $decalage_haut + $marge + 16);
	$this->pdf->SetFont('Arial', '', 9);
	$adresse = strtoupper($this->adresse_contact);
	$this->pdf->Write (4.5, $adresse);
	
	
	if($this->TVA)
	{
		//Affichage de la TVA du client
		$this->pdf->SetXY($decalage_gauche + $marge, $decalage_haut + $marge + 35);
		$this->pdf->SetFont('Arial', '', 9);
	
		//On recupère la reference client correspondant a la reference document et on controle si la ref_document est précisée
		if (!$this->ref_doc) { return false; }
		$query = "SELECT ref_contact FROM documents WHERE ref_doc = '".$this->ref_doc."' ";
		$resultat = $bdd->query ($query);
		if ((!is_object($resultat))||(!$docu = $resultat->fetchObject())) { return false; }
	
		// On récupère la TVA intra du client 
		$query = "SELECT tva_intra FROM annuaire WHERE ref_contact ='".$docu->ref_contact."' ";//ok
		$res="";
		$resultat = $bdd->query ($query);
		if (!$res = $resultat->fetchObject()) { return false; }
		$tva_intra = $res->tva_intra;
                if(!empty($tva_intra))
                    $this->pdf->Write (4.5, "T.V.A.: ".$tva_intra);
		return true;
	}
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
	}
	// Bloc central
	$this->pdf->SetXY($this->MARGE_GAUCHE + $largeur_bloc_tva, $this->PIEDS_HAUTEUR_DEPART);
	$this->pdf->SetFont('Arial', 'B', 10);
	$this->pdf->Cell ($this->LARGEUR_TOTALE_CORPS-$largeur_bloc_montant-$largeur_bloc_tva, 6,"Conditions de règlement" , '1', 0, 'C');
	
	// Bloc partie acquitement
	$this->pdf->SetXY($this->MARGE_GAUCHE + $largeur_bloc_tva, $this->PIEDS_HAUTEUR_DEPART+6);
	$this->pdf->SetFont('Arial', '', 9);
	
	//chargement des reglements
	$reglements = $this->document->getReglements ();
	//$acquittee =0;

	if (abs($this->document->getMontant_to_pay ()) < 0.01 ) {
		$last_reglement = "0000-00-00";
		foreach($reglements as $reglement) {
			if ( $last_reglement < $reglement->date_reglement ){$last_reglement = $reglement->date_reglement;}
		}
		$this->pdf->Cell ($this->LARGEUR_TOTALE_CORPS-$largeur_bloc_montant-$largeur_bloc_tva, 5, "Facture acquittée le ".date_Us_to_Fr($last_reglement), '1', 0, 'L');
                //$acquittee=1;

        } else {
		$this->pdf->Cell ($this->LARGEUR_TOTALE_CORPS-$largeur_bloc_montant-$largeur_bloc_tva, 5, "Facture à régler", '1', 0, 'L');
	}

	//Affichage des regleme,nts//nombre d'echeance max et de reglement max
	$reglements=$this->document->get_conditions_reglement($this->line_ech_max,$this->line_regl_max);
	
	$decalage = 0;
	$nb_reglement=0;
	$i=0;
	$this->pdf->setLeftMargin($this->MARGE_GAUCHE + $largeur_bloc_tva);
	$this->pdf->SetXY($this->MARGE_GAUCHE + $largeur_bloc_tva, $this->PIEDS_HAUTEUR_DEPART+11);
        //_vardump($reglements);
	foreach($reglements as $reglement) 
	{
		$this->pdf->SetFont('Arial', '', 7);
		$date_reglement = "";
				
		//Si aCCompte ou Arrhes
		if(($reglement->type_reglement=="Acompte" || $reglement->type_reglement=="Arrhes")&&(abs($this->document->getMontant_to_pay ()) > 0.01 ))
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
                        $i++;
		}
		else if(($reglement->type_reglement=="Echeance"||$reglement->type_reglement=="Solde")&&(abs($this->document->getMontant_to_pay ()) > 0.01 ))
		{
			if($reglement->pourcentage!="")
			{
                             if(strpos ($reglement->jour,"facturation"))
				$this->pdf->Cell (25, 3, $reglement->type_reglement." ".$reglement->jour, '0', 0, 'L');
                            else
                            {
                                $this->pdf->Cell (25, 3, $reglement->type_reglement." le ".$reglement->jour, '0', 0, 'L');
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
                                $this->pdf->Cell (60, 3, $reglement->type_reglement." à ".$reglement->jour." jours", '0', 0, 'L');
				
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
			$i++;
		}
		else if(($reglement->type_reglement=="EcheanceResume")&&(abs($this->document->getMontant_to_pay ()) > 0.01 ))
		{
			$chaine="Solde en ".$reglement->echeance_restantes." fois du ".$reglement->date_solde_debut." au ".$reglement->date_solde_fin;
			$this->pdf->Cell ($this->LARGEUR_TOTALE_CORPS-$largeur_bloc_montant-$largeur_bloc_tva, 4, $chaine, '0', 1, 'L');
		}
		else if($reglement->type_reglement=="Reglement")
		{
                        if($nb_reglement==0) // pour le premier reglement
                        {
			if($i!=0)
				$this->pdf->Cell (79, 1, "", 'T', 1, 'L');
				$this->pdf->Cell (57, 3, "Règlement le ".$reglement->date_reglement, '0', 0, 'L');
				$this->pdf->Cell (15, 3,$reglement->montant, '0', 0, 'R');
				$this->pdf->Cell (6, 3,$reglement->mode_reglement, '0', 1, 'R');
						
				//$this->pdf->setY($this->pdf->getY()+1);
				$nb_reglement++;
			}
			else
			{
				$this->pdf->Cell (57, 3, "Règlement le ".$reglement->date_reglement, '0', 0, 'L');
				$this->pdf->Cell (15, 3,$reglement->montant, '0', 0, 'R');
				$this->pdf->Cell (6, 3,$reglement->mode_reglement, '0', 1, 'R');
			}
		}
		else if($reglement->type_reglement=="ReglementResume")
		{
			$this->pdf->Cell (57, 3, $reglement->nb_reglement_restant." autres règlements", '0', 0, 'L');
			$this->pdf->Cell (15, 3,$reglement->montant, '0', 1, 'R');
		}
		else
		{
			$decalage--;
		}
		$decalage ++;
	}
}
	
	
}

?>