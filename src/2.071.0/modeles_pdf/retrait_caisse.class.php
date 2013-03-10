<?PHP 
// *************************************************************************************************************
// CLASSE DE GENERATION COMPTE RENDU DE retrait DE CAISSE PDF - 
// *************************************************************************************************************


class pdf_retrait_caisse extends PDF_etendu {
	var $code_pdf_modele = "retrait_caisse";

	var $compte_caisse;					// infos compte
	var $retrait;		
	var $lib_type_printed;
	var $text_contenu_retrait;
	var $explode_contenu_retrait;
	
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

public function create_pdf ($compte_caisse, $id_compte_caisse_retrait) {
	global $PDF_MODELES_DIR;
	global $RTT_CAIS;
	global $MONNAIE;
	
	$this->compte_caisse	= $compte_caisse;
	$this->retrait = $this->compte_caisse->charger_retrait_caisse ($id_compte_caisse_retrait);
	$this->lib_type_printed 	= "Retrait bancaire";
	
	
	include_once ($PDF_MODELES_DIR."config/".$this->code_pdf_modele.".config.php");

	// ***************************************************
	// Initialisation de l'objet PDF
	parent::__construct();

	// ***************************************************
	// Initialisation des variables
	$this->nb_pages					= 1;


	// ***************************************************
	// Valeurs par défaut
	foreach ($RTT_CAIS as $var => $valeur) {
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
	$this->Cell (36, 3, date_Us_to_Fr($this->retrait->date_retrait)." ".getTime_from_date($this->retrait->date_retrait), 0, 0, 'L');
	// ***************************************************
	// TITRE
	$this->SetXY($this->MARGE_GAUCHE, $this->MARGE_HAUT);
	$this->SetFont('Times', 'B', 22);
	$this->Cell ($this->LARGEUR_TOTALE_CORPS, 10, $this->lib_type_printed, 0, 0, 'C');

	//de caisse vers caisse
	$this->SetFont('Arial', 'B', 10);
	$this->SetXY($this->MARGE_GAUCHE , $this->MARGE_HAUT+15);
	$this->Cell (70, 3, ($this->retrait->lib_compte).", ".($this->retrait->nom)." n°".($this->retrait->numero_compte)." vers caisse ".($this->retrait->lib_caisse), 0, 0, 'L');
	// ***************************************************
	// tableau
	$this->SetFont('Arial', 'B', 8);
	
	$this->SetXY($this->MARGE_GAUCHE, 40);
	$this->Cell (60, 15, "", 1, 0, 'L');
	$this->Cell (60, 15, $this->ENTETE_ESP, 1, 0, 'C');
	$this->Cell (60, 15, $this->ENTETE_TT, 1, 0, 'C');
	
	
	$this->SetXY($this->MARGE_GAUCHE, 55);
	$this->Cell (60, 15, $this->ENTETE_TT_CNT, 1, 0, 'L');
	$this->Cell (60, 15, number_format($this->retrait->ESP->montant_retrait, $TARIFS_NB_DECIMALES, ".", ""	)." ".$MONNAIE[0], 1, 0, 'C');
	$this->Cell (60, 15, number_format($this->retrait->ESP->montant_retrait, $TARIFS_NB_DECIMALES, ".", ""	)." ".$MONNAIE[0], 1, 0, 'C');
	
	
	$this->SetTextColor(0,0,0);
	
	$this->SetXY($this->MARGE_GAUCHE, 70);
	$this->MultiCell ($this->LARGEUR_TOTALE_CORPS, 15, $this->ENTETE_COM." ".$this->retrait->commentaire, 0, 'L');
	
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
	$esp_liste = explode("\n",$this->retrait->ESP->infos_retrait);
	$this->text_contenu_retrait = $this->ENTETE_ESP." :  \n";
	
	foreach ($esp_liste as $esp_cont) {
		$tmp = explode(";", $esp_cont);
		if (isset($tmp[1])) {$this->text_contenu_retrait .= " ".$tmp[1]."x".$tmp[0]." ".$MONNAIE[0]."; ";}
	}
	
	$this->SetXY($this->MARGE_GAUCHE, $this->y);
	
	$this->MultiCell ($this->LARGEUR_TOTALE_CORPS, 4, $this->text_contenu_retrait, 0, 'L');
	
	

	return true;
}




}

?>