<?PHP 
// *************************************************************************************************************
// CLASSE DE GENERATION COMPTE RENDU DE depot DE CAISSE PDF - 
// *************************************************************************************************************


class pdf_depot_caisse extends PDF_etendu {
	var $code_pdf_modele = "depot_caisse";

	var $compte_caisse;					// infos compte
	var $depot;		
	var $lib_type_printed;
	var $text_contenu_depot;
	var $explode_contenu_depot;
	
	var $nb_pages;
	var $contenu_actuel;
	var $contenu_end_page;
	var $page_actuelle;
	var $content_printed;


	var $HAUTEUR_LINE_ARTICLE;
	var $LARGEUR_TOTALE_CORPS;

	var $ENTETE_COD_BNQ;
	var $ENTETE_COD_GUI;
	var $ENTETE_COD_NUM;
	var $ENTETE_CLE_RIB;
	var $ENTETE_IBAN;
	var $ENTETE_SWIFT;

	var $MARGE_GAUCHE;
	var $MARGE_HAUT;

public function create_pdf ($compte_caisse, $id_compte_caisse_depot) {
	global $PDF_MODELES_DIR;
	global $DPT_CAIS;
	global $MONNAIE;
	
	$this->compte_caisse	= $compte_caisse;
	$this->depot = $this->compte_caisse->charger_depot_caisse ($id_compte_caisse_depot);
	$this->lib_type_printed 	= "Remise en banque";
	
	
	include_once ($PDF_MODELES_DIR."config/".$this->code_pdf_modele.".config.php");

	// ***************************************************
	// Initialisation de l'objet PDF
	parent::__construct();

	// ***************************************************
	// Initialisation des variables
	$this->nb_pages					= 1;


	// ***************************************************
	// Valeurs par défaut
	foreach ($DPT_CAIS as $var => $valeur) {
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
	$this->SetXY($this->MARGE_GAUCHE + $this->LARGEUR_TOTALE_CORPS - 36 , $this->MARGE_HAUT);
	$this->Cell (36, 3, date_Us_to_Fr($this->depot->date_depot)." ".getTime_from_date($this->depot->date_depot), 0, 0, 'L');
	// ***************************************************
	// TITRE
	$this->SetXY($this->MARGE_GAUCHE, $this->MARGE_HAUT);
	$this->SetFont('Times', 'B', 22);
	$this->Cell ($this->LARGEUR_TOTALE_CORPS, 10, $this->lib_type_printed, 0, 0, 'C');

	//de caisse vers caisse
	$this->SetFont('Arial', 'B', 10);
	$this->SetXY($this->MARGE_GAUCHE , $this->MARGE_HAUT+15);
	$this->Cell (70, 3, ($this->depot->lib_caisse)." vers compte ".($this->depot->lib_compte).", ".($this->depot->nom)." n°".($this->depot->numero_compte), 0, 0, 'L');
	// ***************************************************
	// tableau
	$this->SetFont('Arial', 'B', 8);
	
	$this->SetXY($this->MARGE_GAUCHE, 40);
	$this->Cell (90, 15, "", 1, 0, 'L');
	
	
	//$this->SetXY($this->MARGE_GAUCHE+90, 40);
	//$this->Cell (45, 15, $this->ENTETE_TT, 1, 0, 'C');
	
	
	$this->SetXY($this->MARGE_GAUCHE, 55);
	$this->Cell (90, 15, $this->ENTETE_TT_CNT, 1, 0, 'L');
	
	$montant_tt_esp = 0;
	if(isset($this->depot->ESP->montant_depot )){$montant_tt_esp = $this->depot->ESP->montant_depot;
		$this->SetXY($this->MARGE_GAUCHE+90, 40);
		$this->Cell (90, 15, $this->ENTETE_ESP, 1, 0, 'C');
		$this->SetXY($this->MARGE_GAUCHE+90, 55);
		$this->Cell (90, 15, number_format($montant_tt_esp, $TARIFS_NB_DECIMALES, ".", ""	)." ".$MONNAIE[0], 1, 0, 'C');
	}
	
	$montant_tt_chq = 0;
	if(isset($this->depot->CHQ ) && count($this->depot->CHQ)){
		$this->SetXY($this->MARGE_GAUCHE+90, 40);
		$this->Cell (90, 15, $this->ENTETE_CHQ, 1, 0, 'C');
		$this->SetXY($this->MARGE_GAUCHE+90, 55);
		foreach ($this->depot->CHQ as $CHQ) {$montant_tt_chq += $CHQ->montant_depot;}
		$this->Cell (90, 15, number_format($montant_tt_chq, $TARIFS_NB_DECIMALES, ".", ""	)." ".$MONNAIE[0], 1, 0, 'C');
	}
	//$this->SetXY($this->MARGE_GAUCHE+90, 55);
	//$this->Cell (45, 15, number_format($montant_tt_esp+$montant_tt_chq, $TARIFS_NB_DECIMALES, ".", ""	)." ".$MONNAIE[0], 1, 0, 'C');
	
	
	$this->SetTextColor(0,0,0);
	
	$this->SetXY($this->MARGE_GAUCHE, 70);
	$this->MultiCell ($this->LARGEUR_TOTALE_CORPS, 15, $this->ENTETE_COM." ".$this->depot->commentaire, 0, 'L');
	
	$this->y = $this->y+5;
	$this->SetXY($this->MARGE_GAUCHE, $this->y);
	$this->Cell ($this->LARGEUR_TOTALE_CORPS, 5 , "", 'T', 0, 'C');
	$this->y = $this->y+5;
	
	return true;
}


// Créé le corps du PDF
protected function create_pdf_corps () {
	global $MONNAIE;
	global $TARIFS_NB_DECIMALES;



	$this->SetFont('Arial', '', 8);

	//définition du contenu
	
	if (isset($this->depot->ESP->infos_depot)) {
		//liste des espèces
		$esp_liste = explode("\n",$this->depot->ESP->infos_depot);
		$this->text_contenu_depot = $this->ENTETE_ESP." :  \n";
		if ($this->depot->num_remise) {
			$this->text_contenu_depot .= "Numéro de remise: ".$this->depot->num_remise."   \n";
		}
		
		foreach ($esp_liste as $esp_cont) {
			$tmp = explode(";", $esp_cont);
			if (isset($tmp[1])) {$this->text_contenu_depot .= " ".$tmp[1]."x".$tmp[0]." ".$MONNAIE[0]."; ";}
		}
		
		$this->SetXY($this->MARGE_GAUCHE, $this->y);
		
		$this->MultiCell ($this->LARGEUR_TOTALE_CORPS, 4, $this->text_contenu_depot, 0, 'L');
	}
	
	if(isset($this->depot->CHQ ) && count ($this->depot->CHQ)){
		//liste des chèques
		
		//$this->AddPage();
		$this->text_contenu_depot = $this->ENTETE_CHQ." : ";
		$this->text_contenu_depot .= " (".count($this->depot->CHQ);
		$this->text_contenu_depot .= " opérations )\n";
		if ($this->depot->num_remise) {
			$this->text_contenu_depot .= "Numéro de remise: ".$this->depot->num_remise."   \n";
		}
		
		$this->SetXY($this->MARGE_GAUCHE, $this->y);
		$this->MultiCell ($this->LARGEUR_TOTALE_CORPS, 4, $this->text_contenu_depot, 0, 'L');
		
		
		$this->SetFont('Arial', 'B', 8);
		$this->SetXY($this->MARGE_GAUCHE, $this->y);
		$this->Cell (5, 5, "", 1, 0, 'R');
		$this->Cell (60, 5, "Porteur", 1, 0, 'C');
		$this->Cell (45, 5, "Banque", 1, 0, 'C');
		$this->Cell (35, 5, "Numéro de chèque", 1, 0, 'C');
		$this->Cell (35, 5, "Montant", 1, 0, 'C');
		$this->y =$this->y +5;
		
		
		$this->SetFont('Arial', '', 8);
		$total_depot_cheque = 0;
		$i = 1;
		foreach ($this->depot->CHQ as $chq_cont) {
			$tmp = explode(";", $chq_cont->infos_depot);
			
			$this->SetXY($this->MARGE_GAUCHE, $this->y);
			$this->Cell (5, 5, $i, 1, 0, 'R');
			$this->Cell (60, 5, $tmp[3], 1, 0, 'L');
			$this->Cell (45, 5, $tmp[2], 1, 0, 'L');
			$this->Cell (35, 5, $tmp[1], 1, 0, 'L');
			$this->Cell (35, 5, number_format($chq_cont->montant_depot, $TARIFS_NB_DECIMALES, ".", ""	)." ".$MONNAIE[0], 1, 0, 'R');
			$this->y =$this->y +5;
			$total_depot_cheque += number_format($chq_cont->montant_depot, $TARIFS_NB_DECIMALES, ".", ""	);
			$i++;
		}
		
			$this->SetXY($this->MARGE_GAUCHE+$this->LARGEUR_TOTALE_CORPS-35, $this->y);
			$this->Cell (35, 5, "TOTAL: ".$total_depot_cheque." ".$MONNAIE[0], 1, 0, 'R');
	}

	return true;
}


}

?>