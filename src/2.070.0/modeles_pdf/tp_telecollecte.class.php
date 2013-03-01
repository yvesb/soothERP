<?PHP 
// *************************************************************************************************************
// CLASSE DE GENERATION DE COMPTE RENDU DE CONTROLE DE CAISSE PDF - 
// *************************************************************************************************************


class pdf_tp_telecollecte extends PDF_etendu {
	var $code_pdf_modele = "tp_telecollecte";

	var $compte_tp;					// infos compte
	var $telecollecte;		
	var $lib_type_printed;
	var $text_contenu_telecollecte;
	var $explode_contenu_telecollecte;
	
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

public function create_pdf ($compte_tp, $id_compte_tp_telecollecte) {
	global $PDF_MODELES_DIR;
	global $TELECOLL;
	global $MONNAIE;
	
	$this->compte_tp	= $compte_tp;
	$this->telecollecte = $this->compte_tp->charger_telecollecte ($id_compte_tp_telecollecte);
	$this->lib_type_printed 	= "Télécollecte";
	
	
	include_once ($PDF_MODELES_DIR."config/".$this->code_pdf_modele.".config.php");

	// ***************************************************
	// Initialisation de l'objet PDF
	parent::__construct();

	// ***************************************************
	// Initialisation des variables
	$this->nb_pages					= 1;


	// ***************************************************
	// Valeurs par défaut
	foreach ($TELECOLL as $var => $valeur) {
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
	$this->Cell (36, 3, date_Us_to_Fr($this->telecollecte->date_telecollecte)." ".getTime_from_date($this->telecollecte->date_telecollecte), 0, 0, 'L');
	// ***************************************************
	// TITRE
	$this->SetXY($this->MARGE_GAUCHE, $this->MARGE_HAUT);
	$this->SetFont('Times', 'B', 22);
	$this->Cell ($this->LARGEUR_TOTALE_CORPS, 10, $this->lib_type_printed, 0, 0, 'C');



	//de caisse 
	$this->SetFont('Arial', 'B', 10);
	$this->SetXY($this->MARGE_GAUCHE , 25);
	$this->Cell (70, 3, ($this->compte_tp->getLib_tp()), 0, 0, 'L');
	
	
	// ***************************************************
	// tableau
	$this->SetFont('Arial', 'B', 8);
	
	$this->SetXY($this->MARGE_GAUCHE, 35);
	$this->Cell (40, 10, $this->ENTETE_DATE, 0, 0, 'L');
	$this->SetXY($this->MARGE_GAUCHE+40, 35);
	$this->Cell (40, 10, date_Us_to_Fr($this->telecollecte->date_telecollecte)." ".getTime_from_date($this->telecollecte->date_telecollecte), 0, 0, 'R');
	
	$this->SetXY($this->MARGE_GAUCHE, 40);
	$this->Cell (40, 10, $this->ENTETE_NB_OPE, 0, 0, 'L');
	$this->SetXY($this->MARGE_GAUCHE+40, 40);
	$this->Cell (40, 10, count($this->telecollecte->contenu), 0, 0, 'R');
	
	$this->SetXY($this->MARGE_GAUCHE, 45);
	$this->Cell (40, 10, $this->ENTETE_TT_TE, 0, 0, 'L');
	$this->SetXY($this->MARGE_GAUCHE+40, 45);
	$this->Cell (40, 10, number_format($this->telecollecte->montant_telecollecte, $TARIFS_NB_DECIMALES, ".", ""	)." ".$MONNAIE[0], 0, 0, 'R');
	
	$this->SetXY($this->MARGE_GAUCHE, 50);
	$this->Cell (40, 10, $this->ENTETE_TT_COM, 0, 0, 'L');
	$this->SetXY($this->MARGE_GAUCHE+40, 50);
	$this->Cell (40, 10, number_format($this->telecollecte->montant_commission, $TARIFS_NB_DECIMALES, ".", ""	)." ".$MONNAIE[0], 0, 0, 'R');
	
	$this->SetXY($this->MARGE_GAUCHE, 55);
	$this->Cell (40, 10, $this->ENTETE_TT_TRB, 0, 0, 'L');
	$this->SetXY($this->MARGE_GAUCHE+40, 55);
	$this->Cell (40, 10, number_format($this->telecollecte->montant_transfere, $TARIFS_NB_DECIMALES, ".", ""	)." ".$MONNAIE[0], 0, 0, 'R');
	
	$this->SetTextColor(0,0,0);
	
	$this->SetXY($this->MARGE_GAUCHE, 70);
	$this->MultiCell ($this->LARGEUR_TOTALE_CORPS, 15, $this->ENTETE_COM." ".$this->telecollecte->commentaire, 0, 'L');
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
	
	//liste des CB
	
			$this->SetXY($this->MARGE_GAUCHE, $this->y);
			$this->MultiCell ($this->LARGEUR_TOTALE_CORPS, 4, $this->ENTETE_CB, 0, 'L');
			$this->y = $this->y+5;
	
	if ($this->telecollecte->contenu) {
		foreach ($this->telecollecte->contenu as $contenu) {
			$tmp_date = "";
			
			$this->SetXY($this->MARGE_GAUCHE, $this->y);
			$this->Cell (35, 5, $contenu->montant." ".$MONNAIE[0],0 , 0, 'R');
			if ($contenu->date_reglement != "0000-00-00 00:00:00") {
				$this->SetXY($this->MARGE_GAUCHE+35, $this->y);
				$this->Cell (25, 5, " le ".date_Us_to_Fr($contenu->date_reglement)." ".getTime_from_date($contenu->date_reglement),0 , 0, 'L');
			}
			$this->y = $this->y+5;
			
		}
	} 
	
	

	return true;
}


}

?>