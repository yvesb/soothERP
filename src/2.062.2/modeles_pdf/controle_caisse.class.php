<?PHP 
// *************************************************************************************************************
// CLASSE DE GENERATION DE COMPTE RENDU DE CONTROLE DE CAISSE PDF - 
// *************************************************************************************************************


class pdf_controle_caisse extends PDF_etendu {
	var $code_pdf_modele = "controle_caisse";

	var $compte_caisse;					// infos compte
	var $controle;		
	var $lib_type_printed;
	var $text_contenu_controle;
	var $explode_contenu_controle;
	
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

public function create_pdf ($compte_caisse, $id_compte_caisse_controle) {
	global $PDF_MODELES_DIR;
	global $CTRL_CAIS;
	global $MONNAIE;
	
	$this->compte_caisse	= $compte_caisse;
	$this->controle = $this->compte_caisse->charger_controle_caisse ($id_compte_caisse_controle);
	$this->lib_type_printed 	= "Contrôle de caisse";
	
	
	include_once ($PDF_MODELES_DIR."config/".$this->code_pdf_modele.".config.php");

	// ***************************************************
	// Initialisation de l'objet PDF
	parent::__construct();

	// ***************************************************
	// Initialisation des variables
	$this->nb_pages					= 1;


	// ***************************************************
	// Valeurs par défaut
	foreach ($CTRL_CAIS as $var => $valeur) {
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
	$this->Cell (36, 3, date_Us_to_Fr($this->controle->date_controle)." ".getTime_from_date($this->controle->date_controle), 0, 0, 'L');
	// ***************************************************
	// TITRE
	$this->SetXY($this->MARGE_GAUCHE, $this->MARGE_HAUT);
	$this->SetFont('Times', 'B', 22);
	$this->Cell ($this->LARGEUR_TOTALE_CORPS, 10, $this->lib_type_printed, 0, 0, 'C');



	//de caisse 
	$this->SetFont('Arial', 'B', 10);
	$this->SetXY($this->MARGE_GAUCHE , 25);
	$this->Cell (70, 3, ($this->controle->lib_caisse), 0, 0, 'L');
	
	
	// ***************************************************
	// tableau
	$this->SetFont('Arial', 'B', 8);
	
	$this->SetXY($this->MARGE_GAUCHE, 30);
	$this->Cell (36, 10, "", 1, 0, 'L');
	$this->SetXY($this->MARGE_GAUCHE+36, 30);
	$this->Cell (36, 10, $this->ENTETE_ESP, 1, 0, 'C');
	$this->SetXY($this->MARGE_GAUCHE+72, 30);
	$this->Cell (36, 10, $this->ENTETE_CHQ, 1, 0, 'C');
	$this->SetXY($this->MARGE_GAUCHE+108, 30);
	$this->Cell (36, 10, $this->ENTETE_CB, 1, 0, 'C');
	$this->SetXY($this->MARGE_GAUCHE+144, 30);
	$this->Cell (36, 10, $this->ENTETE_TT, 1, 0, 'C');
	
	$this->SetXY($this->MARGE_GAUCHE, 40);
	$this->Cell (36, 10, $this->ENTETE_TT_THE, 1, 0, 'L');
	$this->SetXY($this->MARGE_GAUCHE+36, 40);
	$this->Cell (36, 10, number_format($this->controle->ESP->montant_theorique, $TARIFS_NB_DECIMALES, ".", ""	)." ".$MONNAIE[0], 1, 0, 'C');
	$this->SetXY($this->MARGE_GAUCHE+72, 40);
	$this->Cell (36, 10, number_format($this->controle->CHQ->montant_theorique, $TARIFS_NB_DECIMALES, ".", ""	)." ".$MONNAIE[0], 1, 0, 'C');
	$this->SetXY($this->MARGE_GAUCHE+108, 40);
	$this->Cell (36, 10, number_format($this->controle->CB->montant_theorique, $TARIFS_NB_DECIMALES, ".", ""	)." ".$MONNAIE[0], 1, 0, 'C');
	$this->SetXY($this->MARGE_GAUCHE+144, 40);
	$this->Cell (36, 10, number_format($this->controle->ESP->montant_theorique+$this->controle->CHQ->montant_theorique+$this->controle->CB->montant_theorique, $TARIFS_NB_DECIMALES, ".", ""	)." ".$MONNAIE[0], 1, 0, 'C');
	
	$this->SetXY($this->MARGE_GAUCHE, 50);
	$this->Cell (36, 10, $this->ENTETE_TT_CNT, 1, 0, 'L');
	$this->SetXY($this->MARGE_GAUCHE+36, 50);
	$this->Cell (36, 10, number_format($this->controle->ESP->montant_controle, $TARIFS_NB_DECIMALES, ".", ""	)." ".$MONNAIE[0], 1, 0, 'C');
	$this->SetXY($this->MARGE_GAUCHE+72, 50);
	$this->Cell (36, 10, number_format($this->controle->CHQ->montant_controle, $TARIFS_NB_DECIMALES, ".", ""	)." ".$MONNAIE[0], 1, 0, 'C');
	$this->SetXY($this->MARGE_GAUCHE+108, 50);
	$this->Cell (36, 10, number_format($this->controle->CB->montant_controle, $TARIFS_NB_DECIMALES, ".", ""	)." ".$MONNAIE[0], 1, 0, 'C');
	$this->SetXY($this->MARGE_GAUCHE+144, 50);
	$this->Cell (36, 10, number_format($this->controle->ESP->montant_controle+$this->controle->CHQ->montant_controle+$this->controle->CB->montant_controle, $TARIFS_NB_DECIMALES, ".", ""	)." ".$MONNAIE[0], 1, 0, 'C');
	
	$this->SetXY($this->MARGE_GAUCHE, 60);
	$this->Cell (36, 10, $this->ENTETE_TT_DIF, 1, 0, 'L');
	$this->SetTextColor(0,0,0);
	if ($this->controle->ESP->montant_controle - $this->controle->ESP->montant_theorique < 0) {$this->SetTextColor(254,0,0);}
	$this->SetXY($this->MARGE_GAUCHE+36, 60);
	$this->Cell (36, 10, number_format(($this->controle->ESP->montant_controle - $this->controle->ESP->montant_theorique ), $TARIFS_NB_DECIMALES, ".", ""	)." ".$MONNAIE[0], 1, 0, 'C');
	$this->SetTextColor(0,0,0);
	if ($this->controle->CHQ->montant_controle - $this->controle->CHQ->montant_theorique < 0) {$this->SetTextColor(254,0,0);}
	$this->SetXY($this->MARGE_GAUCHE+72, 60);
	$this->Cell (36, 10, number_format(($this->controle->CHQ->montant_controle - $this->controle->CHQ->montant_theorique ), $TARIFS_NB_DECIMALES, ".", ""	)." ".$MONNAIE[0], 1, 0, 'C');
	$this->SetTextColor(0,0,0);
	if ($this->controle->CB->montant_controle - $this->controle->CB->montant_theorique < 0) {$this->SetTextColor(254,0,0);}
	$this->SetXY($this->MARGE_GAUCHE+108, 60);
	$this->Cell (36, 10, number_format(($this->controle->CB->montant_controle - $this->controle->CB->montant_theorique ), $TARIFS_NB_DECIMALES, ".", ""	)." ".$MONNAIE[0], 1, 0, 'C');
	$this->SetTextColor(0,0,0);
	if (($this->controle->ESP->montant_controle+$this->controle->CHQ->montant_controle+$this->controle->CB->montant_controle)-($this->controle->ESP->montant_theorique+$this->controle->CHQ->montant_theorique+$this->controle->CB->montant_theorique) < 0) {$this->SetTextColor(254,0,0);}
	$this->SetXY($this->MARGE_GAUCHE+144, 60);
	$this->Cell (36, 10, number_format((($this->controle->ESP->montant_controle+$this->controle->CHQ->montant_controle+$this->controle->CB->montant_controle)-($this->controle->ESP->montant_theorique+$this->controle->CHQ->montant_theorique+$this->controle->CB->montant_theorique)), $TARIFS_NB_DECIMALES, ".", ""	)." ".$MONNAIE[0], 1, 0, 'C');
	
	
	$this->SetTextColor(0,0,0);
	
	$this->SetXY($this->MARGE_GAUCHE, 70);
	$this->MultiCell ($this->LARGEUR_TOTALE_CORPS, 15, $this->ENTETE_COM." ".$this->controle->commentaire, 0, 'L');
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
	
	//liste des espèces
	$esp_liste = explode("\n",$this->controle->ESP->infos_controle);
	
	$this->text_contenu_controle = $this->ENTETE_ESP." : ";
	if ($this->controle->ESP->controle) {
		foreach ($esp_liste as $esp_cont) {
			$tmp = explode(";", $esp_cont);
			if (isset($tmp[1])) {$this->text_contenu_controle .= " ".$tmp[1]."x".$tmp[0]." ".$MONNAIE[0]."; ";}
			
		}
	} else {
		$this->text_contenu_controle .= " non contrôlé";
	}
	
	
	$this->SetXY($this->MARGE_GAUCHE, $this->y);
	$this->MultiCell ($this->LARGEUR_TOTALE_CORPS, 4, $this->text_contenu_controle, 0, 'L');
	
	//liste des chèques
	$this->text_contenu_controle = "\n";
	
	$chq_liste = explode("\n",$this->controle->CHQ->infos_controle);
	for ($i = 0 ; $i < count($chq_liste); $i++) {
		if (isset($chq_liste[$i]) && (empty($chq_liste[$i]) || $chq_liste[$i] == "" || $chq_liste[$i] ==" ")) {unset($chq_liste[$i]);}
	}
	$this->text_contenu_controle .= $this->ENTETE_CHQ." : ";
	if ($this->controle->CHQ->controle) {
		$this->text_contenu_controle .= " (".count($chq_liste);
		$this->text_contenu_controle .= " opérations )";
		foreach ($chq_liste as $chq_cont) {
			$tmp = explode(";", $chq_cont);
			if (isset($tmp[0]) && $tmp[0] && isset($tmp[1]) && (empty($tmp[1]) || $tmp[1] == "" || $tmp[1] ==" ") ) {$this->text_contenu_controle .= " ".number_format($tmp[0], $TARIFS_NB_DECIMALES, ".", ""	)." ".$MONNAIE[0]." * ; "; continue;}
			if (isset($tmp[0]) && $tmp[0] && isset($tmp[1]) && $tmp[1]) {$this->text_contenu_controle .= " ".number_format($tmp[0], $TARIFS_NB_DECIMALES, ".", ""	)." ".$MONNAIE[0]."; "; continue;}
			
		}
	} else {
		$this->text_contenu_controle .= " non contrôlé";
	}
	
	
	
	$this->SetXY($this->MARGE_GAUCHE, $this->y);
	$this->MultiCell ($this->LARGEUR_TOTALE_CORPS, 4, $this->text_contenu_controle, 0, 'L');
	
	
	
	//liste des CB
	$this->text_contenu_controle = "\n";
	
	$cb_liste = explode("\n",$this->controle->CB->infos_controle);
	for ($i = 0 ; $i < count($cb_liste); $i++) {
		if (isset($cb_liste[$i]) && (empty($cb_liste[$i]) || $cb_liste[$i] == "" || $cb_liste[$i] ==" ")) {unset($cb_liste[$i]);}
	}
	$this->text_contenu_controle .= $this->ENTETE_CB." : ";
	if ($this->controle->CB->controle) {
		$this->text_contenu_controle .= " (".count($cb_liste);
		$this->text_contenu_controle .= " opérations )";
		foreach ($cb_liste as $cb_cont) {
			$tmp = explode(";", $cb_cont);
			if (isset($tmp[0]) && $tmp[0] && isset($tmp[1]) && (empty($tmp[1]) || $tmp[1] == "" || $tmp[1] ==" ")) {$this->text_contenu_controle .= " ".number_format($tmp[0], $TARIFS_NB_DECIMALES, ".", ""	)." ".$MONNAIE[0]." * ; "; continue;}
			if (isset($tmp[0]) && $tmp[0]) {$this->text_contenu_controle .= " ".number_format($tmp[0], $TARIFS_NB_DECIMALES, ".", ""	)." ".$MONNAIE[0]."; "; continue;}
			
		}
	} else {
		$this->text_contenu_controle .= " non contrôlé";
	}
	

	
	$this->SetXY($this->MARGE_GAUCHE, $this->y);
	$this->MultiCell ($this->LARGEUR_TOTALE_CORPS, 4, $this->text_contenu_controle, 0, 'L');
	
	
	

	return true;
}


}

?>