<?PHP 
// *************************************************************************************************************
// CLASSE DE GENERATION DE GRANDS LIVRES PDF - 
// *************************************************************************************************************


class pdf_journaux extends PDF_etendu {
	var $code_pdf_modele = "journaux";

	var $journaux;			// informations sur le type de grand livre à imprimer
	var $fiches;					// Contenu du document à imprimer
	var $synthese;				// Contenu des informations de synthese des comtpes pour la période
	var $contact;
	var $montant;
	var $date_impression;
	var $infos;
	var $lib_type_printed;
	var $previous_ref_doc;


	var $nb_pages;
	var $nb_pages_synthese;
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

	var $ENTETE_COL_DAT;
	var $ENTETE_COL_REF;
	var $ENTETE_COL_TTC;
	var $ENTETE_COL_CON;
	var $ENTETE_COL_LIB;
	var $ENTETE_COL_CMT;
	var $ENTETE_COL_HT;
	var $ENTETE_COL_TVA;

	var $LARGEUR_COL_DAT;
	var $LARGEUR_COL_REF;
	var $LARGEUR_COL_TTC;
	var $LARGEUR_COL_CON;
	var $LARGEUR_COL_LIB;
	var $LARGEUR_COL_CMT;
	var $LARGEUR_COL_P;

	var $MARGE_GAUCHE;
	var $MARGE_HAUT;
	var $CORPS_HAUTEUR_DEPART;
	var $CORPS_HAUTEUR_MAX;
	var $PIEDS_HAUTEUR_DEPART;
	var $PIEDS_HAUTEUR_MAX;


public function create_pdf ($infos, $fiches, $synthese) {
	global $PDF_MODELES_DIR;
	global $JOURNAUX;
	
	$this->infos	= $infos;
	$this->lib_type_printed	= $infos["lib_type_printed"];
	$this->contenu 	= $fiches;
	$this->synthese 	= $synthese;
	$this->contact 	= $infos["contact"];
	$this->montant 	= $infos["montant"];
	$this->date_impression 	= $infos["dates"];
	$this->previous_ref_doc = "";
	
	include_once ($PDF_MODELES_DIR."config/".$this->code_pdf_modele.".config.php");

	// ***************************************************
	// Initialisation de l'objet PDF
	parent::__construct();

	// ***************************************************
	// Initialisation des variables
	$this->nb_pages					= 1;
	$this->nb_pages_synthese= 1;
	$this->contenu_actuel 	= 0;					// Ligne du document en cours de traitement
	$this->contenu_end_page = array();		// Lignes de contenu terminant les différentes pages
	$this->contenu_end_page_synthese = array();	
	$this->page_actuelle		= 0;
	$this->content_printed	= 0;
	
	
	// ***************************************************
	// Valeurs par défaut
	foreach ($JOURNAUX as $var => $valeur) {
		$this->{$var} = $valeur;
	}

	$this->ENTETE_COL_COM = $this->contact;
	$this->ENTETE_COL_P = $this->montant;
	
	
	$this->LARGEUR_TOTALE_CORPS  = $this->LARGEUR_COL_DAT + $this->LARGEUR_COL_REF;
	$this->LARGEUR_TOTALE_CORPS += $this->LARGEUR_COL_TTC + $this->LARGEUR_COL_COM;
	$this->LARGEUR_TOTALE_CORPS += $this->LARGEUR_COL_LIB + $this->LARGEUR_COL_CMT;
	$this->LARGEUR_TOTALE_CORPS += $this->LARGEUR_COL_P;


	// ***************************************************
	// Comptage du nombre de page nécessaires
	$hauteur_totale = 0;
	for ($i=0; $i<count($this->contenu); $i++) {

		// Hauteur de la ligne
		$hauteur_ligne = $this->HAUTEUR_LINE_ARTICLE;

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
	// Comptage du nombre de page nécessaires à la synthèse
	$hauteur_totale = 0;
	for ($i=0; $i<count($this->synthese); $i++) {

		// Hauteur de la ligne
		$hauteur_ligne = $this->HAUTEUR_LINE_ARTICLE;

		// Vérification de la nécessité de changer de page
		$hauteur_totale += $hauteur_ligne;
		if ($hauteur_totale >= $this->CORPS_HAUTEUR_MAX) {
			
			$this->contenu_end_page_synthese[] = $old_index;
			$this->nb_pages_synthese ++;
			$hauteur_totale = 0;
		}

		// Archive de l'index de la ligne
		$old_index = $i;
	}


	// ***************************************************
	// Création de la première page de contenu
	$this->create_pdf_page ();

	$this->contenu_actuel = 0;
	// ***************************************************
	// Création de la première page de contenu de synthese
	$this->create_pdf_page_synthese ();
	
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


// Créé une nouvelle page de synthese du document PDF
protected function create_pdf_page_synthese () {
	// Comptage du nombre de page
	$this->page_actuelle++;

	// Création d'une nouvelle page
	$this->AddPage();
	$this->create_pdf_entete_synthese ();
	$this->create_pdf_corps_synthese ();
	$this->create_pdf_texte_corps_pieds ();
	$this->create_pdf_pieds ();

	while ($this->page_actuelle < ($this->nb_pages + $this->nb_pages_synthese)) {
		$this->create_pdf_page_synthese();
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
	// période
	$this->SetXY($this->MARGE_GAUCHE+1, 27);
	$this->SetFont('Arial', '', 8);
	$date_lib = "Période ";
	$this->Cell (13, 3, $date_lib, 0, 0, 'L');
	$this->Cell (3, 3, ":", 0, 0, 'L');
	$this->Cell (40, 3, $this->date_impression, 0, 0, 'L');

	return true;
}

// Créé l'entete synthese du document PDF
protected function create_pdf_entete_synthese () {
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
	// période
	$this->SetXY($this->MARGE_GAUCHE+1, 27);
	$this->SetFont('Arial', 'B', 10);
	$this->Cell (13, 3, "Synthèse de la période en cours ", 0, 0, 'L');
	// ***************************************************
	// période
	$this->SetXY($this->MARGE_GAUCHE+1, 31);
	$this->SetFont('Arial', '', 8);
	$date_lib = "Période ";
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
	$page_lib = "Page ".$this->page_actuelle." / ".($this->nb_pages + $this->nb_pages_synthese);
	$this->Cell (30, 6, $page_lib, 0, 0, 'R');

	
	// ***************************************************
	// Entete du tableau
	$entete_tableau_Y = $this->CORPS_HAUTEUR_DEPART + $this->decalage_corps_actuel;
	$this->SetXY($this->MARGE_GAUCHE, $entete_tableau_Y);
	$this->decalage_corps_actuel += 6;

	$this->SetFont('Arial', 'B', 9);
	$this->Cell ($this->LARGEUR_COL_DAT, 6, $this->ENTETE_COL_DAT, 1, 0, 'C');
	$this->Cell ($this->LARGEUR_COL_REF, 6, $this->ENTETE_COL_REF, 1, 0, 'C');
	$this->Cell ($this->LARGEUR_COL_COM, 6, $this->ENTETE_COL_COM, 1, 0, 'L');
	$this->Cell ($this->LARGEUR_COL_TTC, 6, $this->ENTETE_COL_TTC, 1, 0, 'C');
	$this->Cell ($this->LARGEUR_COL_P, 6, $this->ENTETE_COL_P, 1, 0, 'C');
	$this->Cell ($this->LARGEUR_COL_CMT, 6, $this->ENTETE_COL_CMT, 1, 0, 'C');
	$this->Cell ($this->LARGEUR_COL_LIB, 6, $this->ENTETE_COL_LIB, 1, 0, 'C');


	// ***************************************************
	// Contenu du tableau
	for ($i = $this->contenu_actuel; $i<count($this->contenu); $i++) {
		
		$this->create_pdf_corps_line($this->contenu[$i]);
		$this->contenu_actuel = $i+1;

		// Controle de la fin du document
		if ($i == count($this->contenu)-1) {
			$this->content_printed= 1;
			break; 
		}

		// Controle de la nécessité de changer de page
		if (in_array($i, $this->contenu_end_page)) { break;	}
	}
	
	// Faire décendre le tableau jusqu'en bas du corps
	while ($this->decalage_corps_actuel <= $this->CORPS_HAUTEUR_MAX-1) {
		$line = new stdClass();
		$line->type_of_line = "vide";
		$this->create_pdf_corps_line($line);
	}

	return true;
}

// Créé le corps du PDF
protected function create_pdf_corps_synthese () {

	$this->decalage_corps_actuel	= 0;


	// ***************************************************
	// Numéro de page
	$this->SetXY(-45, $this->CORPS_HAUTEUR_DEPART - 6);
	$this->SetFont('Arial', 'I', 8);
	$page_lib = "Page ".$this->page_actuelle." / ".($this->nb_pages + $this->nb_pages_synthese);
	$this->Cell (30, 6, $page_lib, 0, 0, 'R');

	
	// ***************************************************
	// Entete du tableau
	$entete_tableau_Y = $this->CORPS_HAUTEUR_DEPART + $this->decalage_corps_actuel;
	$this->SetXY($this->MARGE_GAUCHE, $entete_tableau_Y);
	$this->decalage_corps_actuel += 6;

	$this->SetFont('Arial', 'B', 9);
	$this->Cell ($this->LARGEUR_COL_DAT + $this->LARGEUR_COL_REF + $this->LARGEUR_COL_TTC + $this->LARGEUR_COL_COM + $this->LARGEUR_COL_LIB, 6, "", 1, 0, 'C');
	$this->Cell ($this->LARGEUR_COL_CMT, 6, $this->ENTETE_COL_CMT, 1, 0, 'C');
	$this->Cell ($this->LARGEUR_COL_P, 6, $this->ENTETE_COL_P, 1, 0, 'C');


	// ***************************************************
	// Contenu du tableau
	for ($i = $this->contenu_actuel; $i<count($this->synthese); $i++) {
		
		$this->create_pdf_corps_line_synthese($this->synthese[$i]);
		$this->contenu_actuel = $i+1;

		// Controle de la fin du document
		if ($i == count($this->synthese)-1) {
			$this->content_printed= 1;
			break; 
		}

		// Controle de la nécessité de changer de page
		if (in_array($i, $this->contenu_end_page_synthese)) { break;	}
	}
	
	// Faire décendre le tableau jusqu'en bas du corps
	while ($this->decalage_corps_actuel <= $this->CORPS_HAUTEUR_MAX-1) {
		$line = new stdClass();
		$line->type_of_line = "vide";
		$this->create_pdf_corps_line_synthese($line);
	}

	return true;
}



protected function create_pdf_corps_line ($line) {
	global $MONNAIE;
	global $TARIFS_NB_DECIMALES;

	// ***************************************************
	// Valeurs par défaut
		// Cadre
		$cadre = 0; // Gauche et droite
	if (!isset($line->type_of_line)) 	{
	
		// Positionnement au début de la ligne
		$this->SetXY($this->MARGE_GAUCHE, $this->CORPS_HAUTEUR_DEPART + $this->decalage_corps_actuel);
		// Style d'écriture par défaut
		$this->SetFont('Arial', '', 9);
		
		$hauteur = $this->HAUTEUR_LINE_ARTICLE;
		$this->decalage_corps_actuel += $hauteur;
	
		// Spécifités à l'affichage

		// Traitement pour les lignes trops longues
		if ($this->GetStringWidth($line->nom) >= $this->LARGEUR_COL_LIB-1) {
		while ($this->GetStringWidth($line->nom."...") >= $this->LARGEUR_COL_LIB-1) {
			$line->nom = substr ($line->nom, 0, -1);
		}
		$line->nom = $line->nom."...";
		}
		if (isset ($line->lib_compte) ) {
			if ($this->GetStringWidth($line->lib_compte) >= $this->LARGEUR_COL_LIB-1) {
			while ($this->GetStringWidth($line->lib_compte."...") >= $this->LARGEUR_COL_LIB-1) {
				$line->lib_compte = substr ($line->lib_compte, 0, -1);
			}
			$line->lib_compte = $line->lib_compte."...";
			}
		}
			$cadre = "LRBT";
	
		if ($this->previous_ref_doc == $line->ref_doc) {
			$line->date_creation_doc = "";
			$line->ref_doc = "";
			$line->nom = "";
		} else {
			$this->previous_ref_doc = $line->ref_doc;
		}
		// Affichage de la ligne de contenu
		$this->Cell($this->LARGEUR_COL_DAT, $hauteur, date_Us_to_Fr($line->date_creation_doc), $cadre, 0, 'C');
		$this->Cell($this->LARGEUR_COL_REF, $hauteur, $line->ref_doc, $cadre, 0, 'C');
		$this->Cell($this->LARGEUR_COL_COM, $hauteur, $line->nom, $cadre, 0, 'L');
		$this->Cell($this->LARGEUR_COL_TTC, $hauteur, $line->lib_journal, $cadre, 0, 'C');
		if (isset ($line->montant) ) {
		$this->Cell($this->LARGEUR_COL_P, $hauteur, number_format($line->montant, $TARIFS_NB_DECIMALES, ".", ""	)." ".$MONNAIE[0], $cadre, 0, 'R');
		}
		$this->Cell($this->LARGEUR_COL_CMT, $hauteur, $line->numero_compte, $cadre, 0, 'L');
		if (isset ($line->lib_compte) ) {
		$this->Cell($this->LARGEUR_COL_LIB, $hauteur, $line->lib_compte, $cadre, 0, 'L');
		}


	} else {
		//ligne vide
		$hauteur = $this->HAUTEUR_LINE_VIDE;
		if ($this->decalage_corps_actuel >= $this->CORPS_HAUTEUR_MAX-1) {
			$cadre = 0;
		}
		$this->Cell($this->LARGEUR_TOTALE_CORPS, $hauteur, "", $cadre, 0, 'L');
	$this->decalage_corps_actuel += $hauteur;
	}

	return true;
}


protected function create_pdf_corps_line_synthese ($line) {
	global $MONNAIE;
	global $TARIFS_NB_DECIMALES;

	// ***************************************************
	// Valeurs par défaut
		// Cadre
		$cadre = 0; // Gauche et droite
	if (!isset($line->type_of_line)) 	{
	
		// Positionnement au début de la ligne
		$this->SetXY($this->MARGE_GAUCHE, $this->CORPS_HAUTEUR_DEPART + $this->decalage_corps_actuel);
		// Style d'écriture par défaut
		$this->SetFont('Arial', '', 9);
		
		$hauteur = $this->HAUTEUR_LINE_ARTICLE;
		$this->decalage_corps_actuel += $hauteur;
	
$cadre = "LRBT";
	
		// Affichage de la ligne de contenu
		$this->SetFont('Arial', 'B', 9);
		$this->Cell($this->LARGEUR_COL_DAT + $this->LARGEUR_COL_REF + $this->LARGEUR_COL_TTC + $this->LARGEUR_COL_COM + $this->LARGEUR_COL_LIB, $hauteur, "Synthèse du compte", $cadre, 0, 'L');
		
		$this->SetFont('Arial', '', 9);
		$this->Cell($this->LARGEUR_COL_CMT, $hauteur, $line->numero_compte, $cadre, 0, 'L');
		if (isset ($line->toto_montant) ) {
		$this->Cell($this->LARGEUR_COL_P, $hauteur, number_format($line->toto_montant, $TARIFS_NB_DECIMALES, ".", ""	)." ".$MONNAIE[0], $cadre, 0, 'R');
		}


	} else {
		//ligne vide
		$hauteur = $this->HAUTEUR_LINE_VIDE;
		if ($this->decalage_corps_actuel >= $this->CORPS_HAUTEUR_MAX-1) {
			$cadre = 0;
		}
		$this->Cell($this->LARGEUR_TOTALE_CORPS, $hauteur, "", $cadre, 0, 'L');
	$this->decalage_corps_actuel += $hauteur;
	}

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