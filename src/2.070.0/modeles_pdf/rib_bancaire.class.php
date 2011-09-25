<?PHP 
// *************************************************************************************************************
// CLASSE DE GENERATION DE RIB BANCAIRE PDF - 
// *************************************************************************************************************


class pdf_rib_bancaire extends PDF_etendu {
	var $code_pdf_modele = "rib_bancaire";

	var $compte_banque;					// infos compte
	var $contact_entreprise;		// info entreprise
	var $contact_banque;				//infos contact banque
	var $adresse_entreprise;
	var $adresse_banque;
	var $lib_type_printed;
	
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

public function create_pdf ($compte_banque) {
	global $PDF_MODELES_DIR;
	global $REF_CONTACT_ENTREPRISE;
	global $RIB_BNQ;
	
	$this->compte_banque	= $compte_banque;
	$this->contact_entreprise	= new contact ($REF_CONTACT_ENTREPRISE);
	$this->contact_banque	=  new contact ($this->compte_banque->getRef_banque());
	$this->adresse_entreprise = $this->contact_entreprise->getAdresses();
	$this->adresse_banque = $this->contact_banque->getAdresses();
	
	$this->lib_type_printed 	= "Relevé d'Identité Bancaire";
	
	
	include_once ($PDF_MODELES_DIR."config/".$this->code_pdf_modele.".config.php");

	// ***************************************************
	// Initialisation de l'objet PDF
	parent::__construct();

	// ***************************************************
	// Initialisation des variables
	$this->nb_pages					= 1;


	// ***************************************************
	// Valeurs par défaut
	foreach ($RIB_BNQ as $var => $valeur) {
		$this->{$var} = $valeur;
	}


	// ***************************************************
	// Création de la première page
	$this->create_pdf_page ();


	return $this;
}


// Créé une nouvelle page du document PDF
protected function create_pdf_page () {
	// Comptage du nombre de page
	$this->page_actuelle++;

	// Création d'une nouvelle page
	$this->AddPage();
	$this->create_pdf_entete ();

	while ($this->page_actuelle < $this->nb_pages) {
		$this->create_pdf_page();
	}
}


// Créé l'entete du document PDF
protected function create_pdf_entete () {
	global $IMAGES_DIR;

	// ***************************************************
	// LOGO
	//$this->Image($IMAGES_DIR.$this->IMG_LOGO, $this->MARGE_GAUCHE - 5, $this->MARGE_HAUT, 80);

	// ***************************************************
	// TITRE
	$this->SetXY($this->MARGE_GAUCHE, $this->MARGE_HAUT);
	$this->SetFont('Times', 'B', 22);
	$this->Cell ($this->LARGEUR_TOTALE_CORPS, 10, $this->lib_type_printed, 0, 0, 'C');

	// ***************************************************
	// coordonnées entreprise
	$this->SetXY($this->MARGE_GAUCHE+1, 27);
	$this->SetFont('Arial', '', 10);
	$this->MultiCell (85, 4, $this->contact_entreprise->getNom(), 0, 'L');
	$this->SetXY($this->MARGE_GAUCHE+1, 37);
	if (isset($this->adresse_entreprise[0])) {
		$this->MultiCell (80, 4, $this->adresse_entreprise[0]->getText_adresse ()."\n".$this->adresse_entreprise[0]->getCode_postal ()." ".$this->adresse_entreprise[0]->getVille (), 0, 'L');
	}
	// ***************************************************
	// tableau
	$this->SetXY($this->MARGE_GAUCHE, 49);
	$this->Cell (90, 35, "", 1, 0, 'L');
	$this->SetXY($this->MARGE_GAUCHE+90, 49);
	$this->Cell (90, 35, "", 1, 0, 'L');
	$this->SetXY($this->MARGE_GAUCHE, 84);
	$this->Cell ($this->LARGEUR_TOTALE_CORPS, 10, "", 1, 0, 'L');
	
	// ***************************************************
	// coordonnées bancaires
	$this->SetXY($this->MARGE_GAUCHE+1, 50);
	$this->Cell (60, 4, "DOMICILIATION BANCAIRE :", 0, 0, 'L');
	$this->SetXY($this->MARGE_GAUCHE+1, 55);
	$this->MultiCell (85, 4, $this->contact_banque->getNom(), 0, 'L');
	$this->SetXY($this->MARGE_GAUCHE+1, 65);
	if (isset($this->adresse_banque[0])) {
	$this->MultiCell (80, 4, $this->adresse_banque[0]->getText_adresse ()."\n".$this->adresse_banque[0]->getCode_postal ()." ".$this->adresse_banque[0]->getVille (), 0, 'L');
	}
	
	
	// ***************************************************
	// infos bancaires
	$this->SetXY($this->MARGE_GAUCHE+91, 50);
	$this->Cell (35, 4, $this->ENTETE_COD_BNQ, 0, 0, 'L');
	$this->SetXY($this->MARGE_GAUCHE+125, 50);
	$this->Cell (55, 4, $this->compte_banque->getCode_banque(), 0, 0, 'L');
	$this->SetXY($this->MARGE_GAUCHE+91, 55);
	$this->Cell (35, 4, $this->ENTETE_COD_GUI, 0, 0, 'L');
	$this->SetXY($this->MARGE_GAUCHE+125, 55);
	$this->Cell (55, 4, $this->compte_banque->getCode_guichet(), 0, 0, 'L');
	$this->SetXY($this->MARGE_GAUCHE+91, 60);
	$this->Cell (35, 4, $this->ENTETE_COD_NUM, 0, 0, 'L');
	$this->SetXY($this->MARGE_GAUCHE+125, 60);
	$this->Cell (55, 4, $this->compte_banque->getNumero_compte(), 0, 0, 'L');
	$this->SetXY($this->MARGE_GAUCHE+91, 65);
	$this->Cell (35, 4, $this->ENTETE_CLE_RIB, 0, 0, 'L');
	$this->SetXY($this->MARGE_GAUCHE+125, 65);
	$this->Cell (55, 4, $this->compte_banque->getCle_rib(), 0, 0, 'L');
	
	$this->SetXY($this->MARGE_GAUCHE+1, 85);
	$this->Cell (85, 4, $this->ENTETE_IBAN, 0, 0, 'R');
	$this->SetXY($this->MARGE_GAUCHE+95, 85);
	$this->Cell (85, 4, $this->compte_banque->getIban(), 0, 0, 'L');
	$this->SetXY($this->MARGE_GAUCHE+1, 90);
	$this->Cell (85, 4, $this->ENTETE_SWIFT, 0, 0, 'R');
	$this->SetXY($this->MARGE_GAUCHE+95, 90);
	$this->Cell (85, 4, $this->compte_banque->getSwift(), 0, 0, 'L');
	
	
	return true;
}


}

?>