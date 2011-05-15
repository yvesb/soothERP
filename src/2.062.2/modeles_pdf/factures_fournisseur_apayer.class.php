<?PHP 
// *************************************************************************************************************
// CLASSE DE GENERATION DES FACTURES NON REGLEES PDF - 
// *************************************************************************************************************


class pdf_factures_fournisseur_apayer extends PDF_etendu {
	var $code_pdf_modele = "factures_fournisseur_apayer";

	var $factures;				// exercice 
	var $lib_fournisseur_categ;			// Lib de la catégorie de fournisseur
	var $lib_niveau_relance;			// Lib du niveau de relance

	var $nb_pages;
	var $contenu_actuel;
	var $contenu_end_page;
	var $page_actuelle;
	var $content_printed;


	var $HAUTEUR_LINE_ARTICLE;
	var $HAUTEUR_LINE_TAXE;
	var $HAUTEUR_LINE_INFORMATION;
	var $HAUTEUR_LINE_SOUSTOTAL;
	var $HAUTEUR_LINE_DESCRIPTION;
	var $HAUTEUR_LINE_VIDE;

	var $HAUTEUR_AFTER_LINE_ARTICLE;
	var $HAUTEUR_AFTER_LINE_TAXE;
	var $HAUTEUR_AFTER_LINE_INFORMATION;
	var $HAUTEUR_AFTER_LINE_SOUSTOTAL;
	var $HAUTEUR_AFTER_LINE_DESCRIPTION;
	var $HAUTEUR_AFTER_LINE_VIDE;

	var $ENTETE_COL_REF;
	var $ENTETE_COL_DES;
	var $ENTETE_COL_QTE;
	var $ENTETE_COL_PU;
	var $ENTETE_COL_PT;

	var $LARGEUR_COL_REF;
	var $LARGEUR_COL_LIB;
	var $LARGEUR_COL_QTE;
	var $LARGEUR_COL_PU;
	var $LARGEUR_COL_PT;

	var $MARGE_GAUCHE;
	var $MARGE_HAUT;
	var $CORPS_HAUTEUR_DEPART;
	var $CORPS_HAUTEUR_MAX;
	var $PIEDS_HAUTEUR_DEPART;
	var $PIEDS_HAUTEUR_MAX;


public function create_pdf ($factures, $lib_fournisseur_categ, $lib_niveau_relance) {
	global $PDF_MODELES_DIR;
	
	$this->lib_fournisseur_categ	= $lib_fournisseur_categ;
	$this->lib_niveau_relance	= $lib_niveau_relance;
	$this->contenu 	= $factures;
	$this->date_impression 	= date("d/m/Y");
	
	
	$lib_printed = "Factures Fournisseurs non réglées";
	
	$this->lib_type_printed 	= $lib_printed;
	
	
	include_once ($PDF_MODELES_DIR."config/".$this->code_pdf_modele.".config.php");

	// ***************************************************
	// Initialisation de l'objet PDF
	parent::__construct();

	// ***************************************************
	// Initialisation des variables
	$this->nb_pages					= 1;
	$this->contenu_actuel 	= 0;					// Ligne du document en cours de traitement
	$this->contenu_end_page = array();		// Lignes de contenu terminant les différentes pages
	$this->page_actuelle		= 0;
	$this->content_printed	= 0;

	// ***************************************************
	// Valeurs par défaut
	foreach ($EXTRAIT_COMPTE as $var => $valeur) {
		$this->{$var} = $valeur;
	}


	$this->LARGEUR_TOTALE_CORPS  = $this->LARGEUR_COL_REF + $this->LARGEUR_COL_CLIENT;
	$this->LARGEUR_TOTALE_CORPS += $this->LARGEUR_COL_CREATION + $this->LARGEUR_COL_ECHEANCE;
	$this->LARGEUR_TOTALE_CORPS += $this->LARGEUR_COL_MONTANT;



	// ***************************************************
	// Comptage du nombre de page nécessaires
	$hauteur_totale = 0;
	for ($i=0; $i<count($this->contenu); $i++) {

		// Hauteur de la ligne
		$hauteur_ligne = $this->HAUTEUR_LINE_FACTURE;

		// Vérification de la nécessité de changer de page
		$hauteur_totale += $hauteur_ligne;
		if ($hauteur_totale >= $this->CORPS_HAUTEUR_MAX) {
			
			$this->contenu_end_page[] = $old_index;
			$this->nb_pages ++;
			$hauteur_totale = 0;
		}

		// Archive de l'index de la ligne
		$old_index = $i;
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
	$this->create_pdf_corps ();
	$this->create_pdf_texte_corps_pieds ();
	$this->create_pdf_pieds ();

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
	$this->SetFont('Times', 'B', 25);
	$this->Cell (95, 10, $this->lib_type_printed, 0, 0, 'L');

	// ***************************************************
	// Catégorie de fournisseur
	$this->SetXY($this->MARGE_GAUCHE+1, 27);
	$this->SetFont('Arial', '', 8);
	$this->Cell (13, 3, "Catégorie", 0, 0, 'L');
	$this->Cell (3, 3, ":", 0, 0, 'L');
	$this->Cell (13, 3, $this->lib_fournisseur_categ, 0, 0, 'L');
	
	// ***************************************************
	// Niveau de relance
	$this->SetXY($this->MARGE_GAUCHE+1, 31);
	$this->Cell (13, 3, "Relance", 0, 0, 'L');
	$this->Cell (3, 3, ":", 0, 0, 'L');
	$this->SetFont('Arial', '', 8);
	$this->Cell (40, 3, $this->lib_niveau_relance, 0, 0, 'L');

	
	// ***************************************************
	// Date du document
	$this->SetXY($this->MARGE_GAUCHE+1, 35);
	$date_lib = "Date";
	$this->Cell (13, 3, $date_lib, 0, 0, 'L');
	$this->Cell (3, 3, ":", 0, 0, 'L');
	$this->Cell (40, 3, $this->date_impression, 0, 0, 'L');

	return true;
}





// Créé le corps du PDF
protected function create_pdf_corps () {

	$this->decalage_corps_actuel	= 0;


	// ***************************************************
	// Numéro de page
	$this->SetXY(-45, $this->CORPS_HAUTEUR_DEPART - 6);
	$this->SetFont('Arial', 'I', 8);
	$page_lib = "Page ".$this->page_actuelle." / ".$this->nb_pages;
	$this->Cell (30, 6, $page_lib, 0, 0, 'R');

	
	// ***************************************************
	// Entete du tableau
	$entete_tableau_Y = $this->CORPS_HAUTEUR_DEPART + $this->decalage_corps_actuel;
	$this->SetXY($this->MARGE_GAUCHE, $entete_tableau_Y);
	$this->decalage_corps_actuel += 6;
	$this->SetFont('Arial', 'B', 10);
	$this->Cell ($this->LARGEUR_COL_REF, 6, $this->ENTETE_COL_REF, 1, 0, 'L');
	$this->Cell ($this->LARGEUR_COL_CLIENT, 6, $this->ENTETE_COL_CLIENT, 1, 0, 'L');
	$this->Cell ($this->LARGEUR_COL_CREATION, 6, $this->ENTETE_COL_CREATION, 1, 0, 'C');
	$this->Cell ($this->LARGEUR_COL_ECHEANCE, 6, $this->ENTETE_COL_ECHEANCE, 1, 0, 'C');
	$this->Cell ($this->LARGEUR_COL_MONTANT, 6, $this->ENTETE_COL_MONTANT, 1, 0, 'R');



	// ***************************************************
	// Contenu du tableau
	for ($i = $this->contenu_actuel; $i<count($this->contenu); $i++) {
		
		$line = $this->contenu[$i];
		
		$this->create_pdf_corps_line($line);
		$this->contenu_actuel = $i+1;

		// Controle de la fin du document
		if ($i == count($this->contenu)-1) {
			$this->content_printed= 1;
			break; 
		}

		// Controle de la nécessité de changer de page
		if (in_array($i, $this->contenu_end_page)) { break;	}
	}
	
	if ($this->page_actuelle == $this->nb_pages) {
		
	}			

	// Faire descendre le tableau jusqu'en bas du corps
	while ($this->decalage_corps_actuel <= $this->CORPS_HAUTEUR_MAX-1) {
		$hauteur = $this->HAUTEUR_LINE_FACTURE;
		$this->decalage_corps_actuel += $hauteur;
		$this->SetXY($this->MARGE_GAUCHE, $this->CORPS_HAUTEUR_DEPART + $this->decalage_corps_actuel);
		$this->Cell($this->LARGEUR_TOTALE_CORPS, $hauteur, "", 0, 0, 'L');
	}

	return true;
}



protected function create_pdf_corps_line ($line) {
	global $MONNAIE;
	global $TARIFS_NB_DECIMALES;

	// Cadre
	$cadre = 0; // Gauche et droite

	$this->montant_en_credit = "";
	$this->montant_en_debit = "";
	
	// Positionnement au début de la ligne
	$this->SetXY($this->MARGE_GAUCHE, $this->CORPS_HAUTEUR_DEPART + $this->decalage_corps_actuel);
	// Style d'écriture par défaut
	$this->SetFont('Arial', '', 9);
	
	$hauteur = $this->HAUTEUR_LINE_FACTURE;
	$this->decalage_corps_actuel += $hauteur;

	// Spécifités à l'affichage
			$cadre = "LRBT";
			
			//ref
			$this->Cell($this->LARGEUR_COL_REF, $hauteur, $line->ref_doc, $cadre, 0, 'L');
			
			//fournisseur
			$this->Cell($this->LARGEUR_COL_CLIENT, $hauteur, substr($line->nom_contact, 0 , 32), $cadre, 0, 'L');
			
			
			//creation
			$this->Cell($this->LARGEUR_COL_CREATION, $hauteur, date_Us_to_Fr($line->date_creation), $cadre, 0, 'C');
			//echeance
			$this->Cell($this->LARGEUR_COL_ECHEANCE, $hauteur, date_Us_to_Fr($line->date_echeance), $cadre, 0, 'C');
			
			
			//montant
			$this->Cell($this->LARGEUR_COL_MONTANT, $hauteur, price_format($line->montant_ttc)." ".$MONNAIE[0], $cadre, 0, 'R');


	return true;
}


protected function create_pdf_texte_corps_pieds () {

}


protected function create_pdf_pieds () {
	global $MONNAIE;

	// Information société
	$this->SetXY($this->MARGE_GAUCHE, $this->PIEDS_HAUTEUR_DEPART + $this->PIEDS_HAUTEUR_MAX + 1);
	foreach ($this->PIEDS_GAUCHE as $texte) {
		$this->Cell ($this->LARGEUR_TOTALE_CORPS, 4.5, $texte, '0', 2, 'L');
	}

	$this->SetXY(0, $this->PIEDS_HAUTEUR_DEPART + $this->PIEDS_HAUTEUR_MAX + 1);
	foreach ($this->PIEDS_DROIT as $texte) {
		$this->Cell ($this->MARGE_GAUCHE + $this->LARGEUR_TOTALE_CORPS, 4.5, $texte, '0', 2, 'R');
	}
}

}

?>