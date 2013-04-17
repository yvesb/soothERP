<?PHP 
// *************************************************************************************************************
// GENERATION DU RAPPEL DES COMMISSIONNEMENTS
// *************************************************************************************************************


class pdf_commissions extends PDF_etendu {
	var $code_pdf_modele = "commissions";

	var $commerciaux;				
	var $lib_type_printed;
	var $dates;
	var $details;
	var $i;
	
	var $nb_pages;


	var $HAUTEUR_LINE_ARTICLE;
	var $LARGEUR_TOTALE_CORPS;

	var $MARGE_GAUCHE;
	var $MARGE_HAUT;

public function create_pdf ($infos, $liste_commerciaux) {
	global $PDF_MODELES_DIR;
	global $COMMISSIONS;
	global $MONNAIE;
	
	$this->commerciaux				= $liste_commerciaux;
	$this->lib_type_printed 	= $infos["lib_type_printed"];
	$this->dates 							= $infos["dates"];
	$this->details 						= $infos["details"];
	$this->i = 0;
	
	
	include_once ($PDF_MODELES_DIR."config/".$this->code_pdf_modele.".config.php");

	// ***************************************************
	// Initialisation de l'objet PDF
	parent::__construct();

	// ***************************************************
	// Initialisation des variables
	$this->nb_pages					= 1;


	// ***************************************************
	// Valeurs par défaut
	foreach ($COMMISSIONS as $var => $valeur) {
		$this->{$var} = $valeur;
	}

	// Création de la première page
	$this->create_pdf_page ();
	return $this;
}


// Créé une nouvelle page du document PDF
protected function create_pdf_page () {
	// Comptage du nombre de page
	$this->page_actuelle++;
	$this->SetAutoPageBreak(true,2*$this->MARGE_GAUCHE);;
	// Création d'une nouvelle page
	$this->AddPage();
	$this->Header() ;
	$this->create_pdf_corps ();

}


// Créé l'entete du document PDF
public function Header() {
	global $MONNAIE;
	global $TARIFS_NB_DECIMALES;

	$this->SetFont('Arial', 'B', 8);
	
	$this->SetXY($this->MARGE_GAUCHE, $this->MARGE_HAUT);
	$this->Cell (36, 3, "page : ".$this->PageNo(), 0, 0, 'L');
	// ***************************************************
	// TITRE
	$this->SetXY($this->MARGE_GAUCHE, $this->MARGE_HAUT);
	$this->SetFont('Arial', 'B', 20);
	$this->Cell ($this->LARGEUR_TOTALE_CORPS, 10, $this->lib_type_printed, 0, 0, 'C');

	if ($this->details == 1) {
		$this->SetFont('Arial', 'B', 10);
		$this->SetXY($this->MARGE_GAUCHE , $this->MARGE_HAUT+15);
		$this->Cell ($this->LARGEUR_TOTALE_CORPS, 3, "Tableau synthètique ".$this->dates, 0, 0, 'C');
		$this->x = $this->MARGE_GAUCHE ;	
		$this->y +=5;
		$this->Cell ($this->LARGEUR_TOTALE_CORPS, 3, "", "B", 0, 'C');
	}
	
	$this->y +=5;
	return true;
}


// Créé le corps du PDF
protected function create_pdf_corps () {
	global $MONNAIE;
	global $TARIFS_NB_DECIMALES;



	$this->SetFont('Arial', '', 9);
	//définition du contenu
	
		$this->x = $this->MARGE_GAUCHE ;	
	//liste des commerciaux
	foreach ($this->commerciaux as $commercial) {
	
	preg_match('#([0-9\.]*)%CA\+([0-9\.]*)%Mg#i', str_replace(",", ".", $commercial->formule_comm), $result);

	$text_fom_comm = $result[1]."% du Chifre d'affaire plus ".$result[2]."% de la Marge acquit " ;
	switch ($commercial->doc_fom_comm) {
		case "CDC": 
		$text_fom_comm .= "à la commande";
		break;
		case "FAC": 
		$text_fom_comm .= "à la facturation";
		break;
		case "RGM": 
		$text_fom_comm .= "à la facturation acquitée";
		break;
	}
		if ($this->details == 2) {
			if ($this->i != 0) {$this->AddPage(); }
			$this->i = 1;
			$this->SetFont('Arial', 'B', 10);
			$this->SetXY($this->MARGE_GAUCHE , $this->MARGE_HAUT+15);
			$this->Cell ($this->LARGEUR_TOTALE_CORPS, 3, $commercial->nom." ".$this->dates, 0, 0, 'C');
			$this->x = $this->MARGE_GAUCHE ;
			$this->y +=6;
			$this->SetFont('Arial', '', 9);
			$this->Cell ($this->LARGEUR_TOTALE_CORPS, 3, $text_fom_comm, 0, 0, 'C');
			$this->x = $this->MARGE_GAUCHE ;
			$this->y +=6;
		}
		$this->y +=6;
		
		if ($this->details == 1) {
			$this->y +=2;
			$this->SetFont('Arial', 'B', 10);
			$this->Cell (90, 3, "".$commercial->nom, 0, 0, 'L');
			$this->x = $this->MARGE_GAUCHE ;		
			$this->y +=8;
			$this->SetFont('Arial', '', 9);
			$this->Cell (90, 3, $text_fom_comm, 0, 0, 'L');
			$this->x = $this->MARGE_GAUCHE ;		
			$this->y +=8;
		}
		
	$this->SetFont('Arial', '', 9);
		$this->Cell (15, 3, "", 0, 0, 'L');
		$this->Cell (60, 3, "Chiffre d'affaire généré:	 ", 0, 0, 'L');
		$this->Cell (30, 3, number_format($commercial->ca, $TARIFS_NB_DECIMALES, ".", ""	)." ".$MONNAIE[0], 0, 0, 'R');
		
		$this->x = $this->MARGE_GAUCHE ;		
		$this->y +=6;		
		$this->Cell (15, 3, "", 0, 0, 'L');
		$this->Cell (60, 3, "Marge générée:	 ", 0, 0, 'L');
		$this->Cell (30, 3, number_format($commercial->mg, $TARIFS_NB_DECIMALES, ".", ""	)." ".$MONNAIE[0], 0, 0, 'R');
		
		$this->x = $this->MARGE_GAUCHE ;		
		$this->y +=6;
		
			$this->SetFont('Arial', 'B', 10);
		$this->Cell (15, 3, "", 0, 0, 'L');
		$this->Cell (60, 3, "TOTAL COMMISSIONS:	", 0, 0, 'L');
		$this->Cell (30, 3, number_format($commercial->comm, $TARIFS_NB_DECIMALES, ".", ""	)." ".$MONNAIE[0], 0, 0, 'R');
		
		$this->x = $this->MARGE_GAUCHE ;		
		$this->y +=6;
		$this->Cell ($this->LARGEUR_TOTALE_CORPS, 3, "", "B", 0, 'C');

		$this->x = $this->MARGE_GAUCHE ;		
		$this->y +=5;
		
		if ($this->details == 2) {
			
			$this->SetFont('Arial', 'B', 9);
			$this->Cell (20, 3, "Date", 0, 0, 'L');
			$this->Cell (30, 3, "Document", 0, 0, 'L');
			$this->Cell (45, 3, "Client", 0, 0, 'L');
			$this->Cell (25, 3, "CA", 0, 0, 'R');
			$this->Cell (25, 3, "Marge", 0, 0, 'R');
			$this->Cell (25, 3, "Commission", 0, 0, 'R');
			foreach ($commercial->docs as $docu) {
				$this->x = $this->MARGE_GAUCHE ;		
				$this->y +=5;
				$this->SetFont('Arial', '', 9);
				
					while ($this->GetStringWidth($docu->nom) >= 44) {
						$docu->nom = substr($docu->nom, 0, -1);
					}
				$this->Cell (20, 3, date_Us_to_Fr($docu->date_creation_doc), 0, 0, 'L');
				$this->Cell (30, 3, $docu->ref_doc, 0, 0, 'L');
				$this->Cell (45, 3, $docu->nom, 0, 0, 'L');
				$this->Cell (25, 3, number_format($docu->ca, $TARIFS_NB_DECIMALES, ".", ""	)." ".$MONNAIE[0], 0, 0, 'R');
				$this->Cell (25, 3, number_format($docu->mg, $TARIFS_NB_DECIMALES, ".", ""	)." ".$MONNAIE[0], 0, 0, 'R');
				$this->Cell (25, 3, number_format($docu->comm, $TARIFS_NB_DECIMALES, ".", ""	)." ".$MONNAIE[0], 0, 0, 'R');
				
			}
			
			$this->x = $this->MARGE_GAUCHE ;		
			$this->y +=6;
			$this->Cell ($this->LARGEUR_TOTALE_CORPS, 3, "", "B", 0, 'C');
	
			$this->x = $this->MARGE_GAUCHE ;		
			$this->y +=5;
		}
	
	}
	return true;
}

}

?>