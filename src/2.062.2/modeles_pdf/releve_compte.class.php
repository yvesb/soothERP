<?PHP 
// *************************************************************************************************************
// CLASSE DE GENERATION COMPTE RENDU DE depot DE CAISSE PDF - 
// *************************************************************************************************************


class pdf_releve_compte extends PDF_etendu {
	var $code_pdf_modele = "releve_compte";

	var $dates;					
	var $lib_type_printed;
	var $contenu;
	var $report_solde;
	var $solde_haut_page;
	
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

public function create_pdf ($infos, $fiches) {
	global $PDF_MODELES_DIR;
	global $DPT_CAIS;
	global $MONNAIE;
	
	$this->dates = $infos["dates"];
	$this->lib_type_printed 	= $infos["lib_type_printed"];
	$this->contenu 	= $fiches;
	$this->report_solde = $infos["report_solde"];
	$this->solde_haut_page = $infos["solde_haut_page"];
	
	include_once ($PDF_MODELES_DIR."config/".$this->code_pdf_modele.".config.php");

	// ***************************************************
	// Initialisation de l'objet PDF
	parent::__construct();

	// ***************************************************
	// Initialisation des variables
	$this->nb_pages					= 1;


	// ***************************************************
	// Valeurs par défaut
	foreach ($RELEVE_COMPTE as $var => $valeur) {
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
	$this->SetXY($this->MARGE_GAUCHE + $this->LARGEUR_TOTALE_CORPS - 60 , $this->MARGE_HAUT);
	$this->Cell (36, 3, $this->dates , 0, 0, 'L');
	// ***************************************************
	// TITRE
	$this->SetXY($this->MARGE_GAUCHE, $this->MARGE_HAUT+4);
	$this->SetFont('Times', 'B', 22);
	$this->Cell ($this->LARGEUR_TOTALE_CORPS, 10, $this->lib_type_printed, 0, 0, 'C');
	
	$this->SetXY($this->MARGE_GAUCHE, 28);
	$this->SetFont('Arial', 'B', 10);
	$this->Cell ($this->LARGEUR_COL_DATE, 6, $this->ENTETE_COL_DATE, 1, 0, 'L');
	$this->Cell ($this->LARGEUR_COL_LIBELLE, 6, $this->ENTETE_COL_LIBELLE, 1, 0, 'L');
	$this->Cell ($this->LARGEUR_COL_DEBIT, 6, $this->ENTETE_COL_DEBIT, 1, 0, 'C');
	$this->Cell ($this->LARGEUR_COL_CREDIT, 6, $this->ENTETE_COL_CREDIT, 1, 0, 'C');
	$this->Cell ($this->LARGEUR_COL_SOLDE, 6, $this->ENTETE_COL_SOLDE, 1, 0, 'C');
	$this->y += 6;
	return true;
}


// Créé le corps du PDF
protected function create_pdf_corps () {
	global $MONNAIE;
	global $TARIFS_NB_DECIMALES;

	$this->SetFont('Arial', '', 8);

	//définition du contenu
	
	// ***************************************************
	// Contenu du tableau
	foreach ($this->contenu as $line ) {

		$this->SetXY($this->MARGE_GAUCHE, $this->y);
		$this->SetFont('Arial', 'B', 10);
		$this->Cell ($this->LARGEUR_COL_DATE, 6, Date_Us_to_Fr($line->date_move), 1, 0, 'L');
		$this->Cell ($this->LARGEUR_COL_LIBELLE, 6,$line->lib_move, 1, 0, 'L');
		if ($line->montant_move <0) {
			$this->Cell ($this->LARGEUR_COL_DEBIT, 6, price_format($line->montant_move), 1, 0, 'R');
			$this->Cell ($this->LARGEUR_COL_CREDIT, 6, "", 1, 0, 'C');
		} else {
			$this->Cell ($this->LARGEUR_COL_DEBIT, 6, "", 1, 0, 'C');
			$this->Cell ($this->LARGEUR_COL_CREDIT, 6, price_format($line->montant_move), 1, 0, 'R');
		}
		$this->Cell ($this->LARGEUR_COL_SOLDE, 6, price_format($this->solde_haut_page) , 1, 0, 'R');
		$this->solde_haut_page  -= $line->montant_move;
		$this->y += 6;
		
	}
	$this->SetXY($this->MARGE_GAUCHE, $this->y);
	$this->SetFont('Arial', 'B', 10);
	$this->Cell ($this->LARGEUR_COL_DATE, 6, "", 1, 0, 'L');
	$this->Cell ($this->LARGEUR_COL_LIBELLE, 6,"", 1, 0, 'L');
	$this->Cell ($this->LARGEUR_COL_DEBIT, 6, "", 1, 0, 'C');
	$this->Cell ($this->LARGEUR_COL_CREDIT, 6, $this->ENTETE_COL_REPORT, 1, 0, 'C');
	$this->Cell ($this->LARGEUR_COL_SOLDE, 6, $this->report_solde, 1, 0, 'C');
	
	return true;
}


}

?>