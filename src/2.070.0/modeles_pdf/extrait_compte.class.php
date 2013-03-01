<?PHP 
// *************************************************************************************************************
// CLASSE DE GENERATION DE L'ETAT DES STOCKS PDF - 
// *************************************************************************************************************


class pdf_extrait_compte extends PDF_etendu {
	var $code_pdf_modele = "extrait_compte";

	var $exercice;				// exercice 
	var $grand_livre;			// Contenu du de l'extrait à imprimer
	var $ref_contact;			// Ref_contact de l'extrait à afficher

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


public function create_pdf ($exercice, $grand_livre, $ref_contact) {
	global $PDF_MODELES_DIR;
	global $ETAT_STOCK;
	global $CLIENT_ID_PROFIL;
	global $FOURNISSEUR_ID_PROFIL;
	
	$this->exercice	= $exercice;
	$this->id_exercice	= $exercice->getId_exercice();
	$this->lib_exercice	= $exercice->getLib_exercice();
	$this->contenu 	= $grand_livre;
	$this->date_impression 	= date("d/m/Y");
	
	
	$contact = new contact ($ref_contact);
	$profils 	= $contact->getProfils();
	$lib_printed = "Extrait de compte de";
	if (isset($profils[$CLIENT_ID_PROFIL])){
		$lib_printed .= " ".$_SESSION['profils'][$CLIENT_ID_PROFIL]->getLib_profil();
	}
	if (isset($profils[$FOURNISSEUR_ID_PROFIL] )){
		$lib_printed .= " ".$_SESSION['profils'][$FOURNISSEUR_ID_PROFIL]->getLib_profil();
	}
	
	$this->lib_type_printed 	= $lib_printed;
	
	$this->nom_contact = $contact->getNom();
	
	
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
	$this->montant_en_credit = 0;
	$this->montant_en_debit = 0;
	$this->montant_total_credit = 0;
	$this->montant_total_debit = 0;
	$this->montant_total_solde = 0;

	// ***************************************************
	// Valeurs par défaut
	foreach ($EXTRAIT_COMPTE as $var => $valeur) {
		$this->{$var} = $valeur;
	}


	$this->LARGEUR_TOTALE_CORPS  = $this->LARGEUR_COL_DATE + $this->LARGEUR_COL_LIB;
	$this->LARGEUR_TOTALE_CORPS += $this->LARGEUR_COL_DEBIT + $this->LARGEUR_COL_LT;
	$this->LARGEUR_TOTALE_CORPS += $this->LARGEUR_COL_CREDIT + $this->LARGEUR_COL_SOLDE;


	// ***************************************************
	// Comptage du nombre de page nécessaires
	$hauteur_totale = 0;
	for ($i=0; $i<count($this->contenu); $i++) {

		// Hauteur de la ligne
		$hauteur_ligne = $this->HAUTEUR_LINE_EXTRAIT;

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
	// Référence exercice
	$this->SetXY($this->MARGE_GAUCHE+1, 27);
	$this->SetFont('Arial', '', 8);
	$exercice_lib = "Exercice";
	$this->Cell (13, 3, $exercice_lib, 0, 0, 'L');
	$this->Cell (3, 3, ":", 0, 0, 'L');
	$this->Cell (40, 3, $this->lib_exercice, 0, 0, 'L');

	// ***************************************************
	// Contact exercice
	$this->SetXY($this->MARGE_GAUCHE+1, 31);
	$this->SetFont('Arial', '', 8);
	$this->Cell (13, 3, $this->nom_contact, 0, 0, 'L');

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
	$this->Cell ($this->LARGEUR_COL_DATE, 6, $this->ENTETE_COL_DATE, 1, 0, 'L');
	$this->Cell ($this->LARGEUR_COL_LIB, 6, $this->ENTETE_COL_LIB, 1, 0, 'L');
	$this->Cell ($this->LARGEUR_COL_DEBIT, 6, $this->ENTETE_COL_DEBIT, 1, 0, 'C');
	$this->Cell ($this->LARGEUR_COL_LT, 6, $this->ENTETE_COL_LT, 1, 0, 'C');
	$this->Cell ($this->LARGEUR_COL_CREDIT, 6, $this->ENTETE_COL_CREDIT, 1, 0, 'C');
	$this->Cell ($this->LARGEUR_COL_SOLDE, 6, $this->ENTETE_COL_SOLDE, 1, 0, 'C');



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
		//affichage de la ligne de total
		$cadre = "LRBT";
		$hauteur = $this->HAUTEUR_LINE_EXTRAIT;
		$this->SetXY($this->MARGE_GAUCHE, $this->CORPS_HAUTEUR_DEPART + $this->decalage_corps_actuel);
		$this->SetFont('Arial', 'B', 10);
		$lib_toto = "TOTAL DU COMPTE ".$this->nom_contact;
		if ($this->GetStringWidth($lib_toto) >= ($this->LARGEUR_COL_LIB+$this->LARGEUR_COL_DATE)-1) {
			while ($this->GetStringWidth("...".$lib_toto) >= ($this->LARGEUR_COL_LIB+$this->LARGEUR_COL_DATE)-1) {
				$lib_toto = substr ($lib_toto, 0, -1);
			}
			$lib_toto = $lib_toto."...";
		}
		$this->Cell($this->LARGEUR_COL_DATE+$this->LARGEUR_COL_LIB, $hauteur, $lib_toto, $cadre, 0, 'L');
		$this->Cell($this->LARGEUR_COL_DEBIT, $hauteur, price_format($this->montant_total_debit), $cadre, 0, 'R');
		$this->Cell($this->LARGEUR_COL_LT, $hauteur, "", $cadre, 0, 'R');
		$this->Cell($this->LARGEUR_COL_CREDIT, $hauteur, price_format($this->montant_total_credit), $cadre, 0, 'R');
		$this->Cell($this->LARGEUR_COL_SOLDE, $hauteur, price_format($this->montant_total_solde), $cadre, 0, 'R');
	}			

	// Faire descendre le tableau jusqu'en bas du corps
	while ($this->decalage_corps_actuel <= $this->CORPS_HAUTEUR_MAX-1) {
		$hauteur = $this->HAUTEUR_LINE_EXTRAIT;
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
	
	$hauteur = $this->HAUTEUR_LINE_EXTRAIT;
	$this->decalage_corps_actuel += $hauteur;

	// Spécifités à l'affichage
			$cadre = "LRBT";
			$tmp_lib = "";
			//date
			if (isset($line->date)) {
				$tmp_lib = date_Us_to_Fr($line->date);
			}
			$this->Cell($this->LARGEUR_COL_DATE, $hauteur, $tmp_lib, $cadre, 0, 'L');
			
			//lib
			if (isset($line->id_exercice_ran)) {
				$this->Cell($this->LARGEUR_COL_LIB, $hauteur, "Report", $cadre, 0, 'L');
			}
			if (isset($line->ref_doc) && !is_array($line->ref_doc) ) {
				$tmp_lib = $line->lib_type_doc." ".$line->ref_doc." (".$line->lib_etat_doc.")";
				 
				$this->Cell($this->LARGEUR_COL_LIB, $hauteur, $tmp_lib, $cadre, 0, 'L');
			}
			if (isset($line->ref_reglement)) { 
				$tmp_lib = "Règlement ".$line->lib_reglement_mode;
				if (isset($line->nchq_s) && $line->nchq_s != "") {$tmp_lib = $tmp_lib." n°".$line->nchq_s;}
				if (isset($line->nchq_e) && $line->nchq_e != "") {$tmp_lib = $tmp_lib." n°".$line->nchq_e;}
				$this->Cell($this->LARGEUR_COL_LIB, $hauteur, $tmp_lib, $cadre, 0, 'L');
			}
			
			//debit
			if (isset($line->ref_doc) && !is_array($line->ref_doc) && (($line->id_type_doc == 4 && $line->montant_ttc >= 0) || ($line->id_type_doc == 8 && $line->montant_ttc < 0))) {
				$this->montant_en_debit = abs(number_format($line->montant_ttc, $TARIFS_NB_DECIMALES, ".", ""	));
			} 
			if (isset($line->ref_reglement) && $line->type_reglement == "sortant") {
				$this->montant_en_debit = abs(number_format($line->montant_ttc, $TARIFS_NB_DECIMALES, ".", ""	));
			} 
			if (isset($line->montant_ran) && $line->montant_ran < 0) {
				$this->montant_en_debit = abs(number_format($line->montant_ran, $TARIFS_NB_DECIMALES, ".", ""	));
			} 
			$this->montant_total_debit += $this->montant_en_debit;
			if ($this->montant_en_debit != 0) {
				$this->Cell($this->LARGEUR_COL_DEBIT, $hauteur, price_format($this->montant_en_debit), $cadre, 0, 'R');
			}else {
				$this->Cell($this->LARGEUR_COL_DEBIT, $hauteur, "", $cadre, 0, 'R');
			}
			
			//lettrage
			$tmp_lettrage = "--";
			if (isset($line->date)) {
				$tmp_lettrage = $line->lettrage;
			}
			$this->Cell($this->LARGEUR_COL_LT, $hauteur, $tmp_lettrage, $cadre, 0, 'C');
			
			//credit
			if (isset($line->ref_doc) && !is_array($line->ref_doc) && (($line->id_type_doc == 4 && $line->montant_ttc < 0) || ($line->id_type_doc == 8 && $line->montant_ttc >= 0)) ) { 
				$this->montant_en_credit = abs(number_format($line->montant_ttc, $TARIFS_NB_DECIMALES, ".", ""	));
			} 
			
			if (isset($line->ref_reglement) && $line->type_reglement == "entrant") { 
				$this->montant_en_credit = abs(number_format($line->montant_ttc, $TARIFS_NB_DECIMALES, ".", ""	));
			} 
			if (isset($line->montant_ran) && $line->montant_ran > 0) {
				$this->montant_en_credit = abs(number_format($line->montant_ran, $TARIFS_NB_DECIMALES, ".", ""	));
			} 
			$this->montant_total_credit += $this->montant_en_credit;
			if ($this->montant_en_credit != 0) {
				$this->Cell($this->LARGEUR_COL_CREDIT, $hauteur, price_format($this->montant_en_credit), $cadre, 0, 'R');
			} else {
				$this->Cell($this->LARGEUR_COL_CREDIT, $hauteur, "", $cadre, 0, 'R');
			}
			
			//solde
			$this->montant_total_solde = $this->montant_total_solde + $this->montant_en_credit - $this->montant_en_debit;
			$this->Cell($this->LARGEUR_COL_SOLDE, $hauteur,  price_format($this->montant_total_solde)." ".$MONNAIE[0], $cadre, 0, 'R');


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