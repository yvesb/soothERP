<?PHP 
// *************************************************************************************************************
// CLASSE PERMETTANT L'AJOUT D'UN DOCUMENT A UN PDF - MODELE STANDARD
// *************************************************************************************************************

class pdf_content_doc_standard {
	var $code_pdf_modele = "doc_standard";

	var $pdf;								// PDF destiné à contenir le document
	var $document;					// Document à imprimer
	var $contenu;						// Contenu du document à imprimer

	var $tvas;
	var $montant_ht;
	var $montant_tva;
	var $montant_ttc;
	var $app_tarifs;
	var $ref_doc;
	var $lib_type_printed;
	var $date_creation;
	var $nom_contact;
	var $adresse_contact;
	var $st_lines;

	var $nb_pages;
	var $contenu_actuel;
	var $contenu_end_page;
	var $page_actuelle;
	var $content_printed;

	var $AFF_REMISES;

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
	var $ENTETE_COL_REM;
	var $ENTETE_COL_PT;
	var $ENTETE_COL_TVA;

	var $LARGEUR_COL_REF;
	var $LARGEUR_COL_LIB;
	var $LARGEUR_COL_QTE;
	var $LARGEUR_COL_PRI;
	var $LARGEUR_COL_REM;
	var $LARGEUR_COL_TVA;

	var $MARGE_GAUCHE;
	var $MARGE_HAUT;
	var $CORPS_HAUTEUR_DEPART;
	var $CORPS_HAUTEUR_MAX;
	var $PIEDS_HAUTEUR_DEPART;
	var $PIEDS_HAUTEUR_MAX;


public function pdf_content_doc_standard (&$pdf, $document) {
	global $PDF_MODELES_DIR;
	global $AFF_REMISES;
	global $DOC_STANDARD;

	$this->pdf 						= $pdf;
	$this->document					= $document;
	$this->ref_doc					= $document->getRef_doc();
	if(method_exists($document, 'getRef_doc_externe')){
		$this->ref_doc_externe	= $document->getRef_doc_externe();
	}
	$this->lib_type_printed			= $document->getLib_type_printed();
	$this->contenu 					= $document->getContenu();
	$this->tvas 					= $document->getTVAs();
	$this->montant_ht 				= $document->getMontant_ht();
	$this->montant_tva 				= $document->getMontant_tva();
	$this->montant_ttc 				= $document->getMontant_ttc();
	$this->app_tarifs 				= $document->getApp_tarifs();
	$this->date_creation 			= $document->getDate_creation();
	$this->nom_contact 				= $document->getNom_contact();
	$this->adresse_contact 			= $document->getAdresse_contact();
	$this->st_lines = 0;
        if (!strcmp(strtolower($this->lib_type_printed), "inventaire"))
            $this->stock                       = $document->getLib_stock();
        else
            $this->stock                        = "";
	//_vardump($document);
	include ($PDF_MODELES_DIR."config/".$this->code_pdf_modele.".config.php");

	// ***************************************************
	// Initialisation des variables
	$this->nb_pages					= 1;
	$this->contenu_actuel 	= 0;					// Ligne du document en cours de traitement
	$this->contenu_end_page = array();		// Lignes de contenu terminant les différentes pages
	$this->page_actuelle		= 0;
	$this->content_printed	= 0;

	// ***************************************************
	// Valeurs par défaut
	foreach ($DOC_STANDARD as $var => $valeur) {
		$this->{$var} = $valeur;
	}

	
	//****************************************************
	// AJUSTEMENT DE LA TAILLE DES COLONNES 
	if(!empty($this->REF_ARTICLE) && $this->REF_ARTICLE=="Aucune"){
		$this->LARGEUR_COL_LIB += $this->LARGEUR_COL_REF;
		$this->LARGEUR_COL_REF = 0;
	}
	if(isset($this->AFF_PRIX) && !$this->AFF_PRIX){
		$this->LARGEUR_COL_QTE += $this->LARGEUR_COL_TVA;
		$this->LARGEUR_COL_LIB += 2*$this->LARGEUR_COL_PRI + $this->LARGEUR_COL_REM;
		$this->LARGEUR_COL_TVA = 0;
		$this->LARGEUR_COL_REM = 0;
		$this->LARGEUR_COL_PRI = 0;
	}else if(!$this->AFF_REMISES) {
		// Affichage de la colonne Remise ?
		$this->LARGEUR_COL_LIB += $this->LARGEUR_COL_REM;
		$this->LARGEUR_COL_REM = 0;
	}

	$this->LARGEUR_TOTALE_CORPS  = $this->LARGEUR_COL_REF + $this->LARGEUR_COL_LIB;
	$this->LARGEUR_TOTALE_CORPS += $this->LARGEUR_COL_QTE + $this->LARGEUR_COL_PRI * 2;
	$this->LARGEUR_TOTALE_CORPS += $this->LARGEUR_COL_REM + $this->LARGEUR_COL_TVA;



	//transformation des lignes de contenu (découpage des textes trop long, assimilation des descriptions comme simples lignes
	$new_contenu_decoupe = array();
	$this->pdf->SetFont('Arial', 'B', 9);
	for ($i=0; $i<count($this->contenu); $i++) {
		if ((isset($this->contenu[$i]->visible) && $this->contenu[$i]->visible) ) {
			if ($this->pdf->GetStringWidth($this->contenu[$i]->lib_article) >= $this->LARGEUR_COL_LIB-1) {
				$line_lenght = 0;
				$list_ligne = array();
				//on stock temporairerement le lib
				$tmp_lib = $this->contenu[$i]->lib_article;
				while ($this->pdf->GetStringWidth($tmp_lib) >= $this->LARGEUR_COL_LIB-1) {
					$tmp_lib = substr($tmp_lib, 0, -1);
				}
				if (substr_count($tmp_lib, " ")) {
					while (substr($tmp_lib, -1) != " "){$tmp_lib = substr($tmp_lib, 0, -1);}
				}
				//on obtient la longueur de la ligne
				$line_lenght = strlen($tmp_lib);
				$list_ligne = str_split ( $this->contenu[$i]->lib_article, $line_lenght);
				if (count($list_ligne) > 2) {
					$dernier = array_pop($list_ligne);
					$list_ligne[count($list_ligne)-1] = $list_ligne[count($list_ligne)-1].$dernier;
				}
				
				foreach ($list_ligne as $key=>$value) {
					$depasse = "";
					$tmp_value = $value = $list_ligne[$key];
					if ($key == 0) {continue;}    
					if ($key == (count($list_ligne)-1) && strlen($value) <=  $line_lenght) {continue;}
					if (isset($list_ligne[$key+1])) {
						$tmp_value = $value.$list_ligne[$key+1];
						$value = $value.$list_ligne[$key+1];
					}
					while ($this->pdf->GetStringWidth($tmp_value) >= $this->LARGEUR_COL_LIB-1) {
						$tmp_value = substr($tmp_value, 0, -1);
					}
					if (substr_count($tmp_value, " ")) {
						while (substr($tmp_value, -1) != " ") {
							$tmp_value = substr($tmp_value, 0, -1);
						}
					}
					$depasse = substr($value, strlen($tmp_value));
					$value = substr($value, 0, strlen($tmp_value)-1);            
					$list_ligne[$key+1] = $depasse;    
					$list_ligne[$key] = $value;
				} 
				$cmp = 0;
				foreach ($list_ligne as $ligne) {
					if ($cmp == 0) {
						$this->contenu[$i]->lib_article = $ligne;
						$new_contenu_decoupe[] = $this->contenu[$i];	
					} else {
						// ajout de'autant de ligne que necessaire au lib (
						$line = new stdClass();
						$line->type_of_line = "description";
						$line->lib_article = $ligne;
						$new_contenu_decoupe[] = $line;
					}
					$cmp ++;
				}
			} else {
				$new_contenu_decoupe[] = $this->contenu[$i];
			}
		}
		// Ajout de la description si besoin
		if((!isset($this->AFF_DESC) || $this->AFF_DESC==true) || $this->contenu[$i]->type_of_line != "article"){
			if ($this->contenu[$i]->desc_article && (isset($this->contenu[$i]->visible) && $this->contenu[$i]->visible) ) {
				$desc_lines = explode ("\n", $this->contenu[$i]->desc_article);
				$tmp_lines_desc = array();
				for ($j=0; $j<count($desc_lines); $j++) {
					if ($this->pdf->GetStringWidth($desc_lines[$j]) >= $this->LARGEUR_COL_LIB-1) {
						$line_lenght = 0;
						$list_ligne = array();
						//on stock temporairerement le lib
						$tmp_lib = $desc_lines[$j];
						while ($this->pdf->GetStringWidth($tmp_lib) >= $this->LARGEUR_COL_LIB-1) {
							$tmp_lib = substr($tmp_lib, 0, -1);
						}
						if (substr_count($tmp_lib, " ")) {
							while (substr($tmp_lib, -1) != " "){$tmp_lib = substr($tmp_lib, 0, -1);}
						}
						//on obtient la longueur de la ligne
						$line_lenght = strlen($tmp_lib);
						$list_ligne = str_split ($desc_lines[$j], $line_lenght);
						if (count($list_ligne) > 2) {
								$dernier = array_pop($list_ligne);
								$list_ligne[count($list_ligne)-1] = $list_ligne[count($list_ligne)-1].$dernier;
						}
						
						foreach ($list_ligne as $key=>$value) {
							$depasse = "";
							$tmp_value = $value = $list_ligne[$key];
							if ($key == 0) {continue;}    
							if ($key == (count($list_ligne)-1) && strlen($value) <=  $line_lenght) {continue;}
							if (isset($list_ligne[$key+1])) {
								$tmp_value = $value.$list_ligne[$key+1];
								$value = $value.$list_ligne[$key+1];
							}
							while ($this->pdf->GetStringWidth($tmp_value) >= $this->LARGEUR_COL_LIB-1) {
								$tmp_value = substr($tmp_value, 0, -1);
							}
							if (substr_count($tmp_value, " ")) {
								while (substr($tmp_value, -1) != " ") {
									$tmp_value = substr($tmp_value, 0, -1);
								}
							}
							$depasse = substr($value, strlen($tmp_value));
							$value = substr($value, 0, strlen($tmp_value)-1);            
							$list_ligne[$key+1] = $depasse;    
							$list_ligne[$key] = $value;
						} 
						foreach ($list_ligne as $ligne) {
							$tmp_lines_desc[] = $ligne;
						}
					} else {
						$tmp_lines_desc[] = $desc_lines[$j];
					}
				}
				foreach ($tmp_lines_desc as $desc_line) {
					$line = new stdClass();
					$line->type_of_line = "description";
					$line->lib_article = $desc_line;
					$new_contenu_decoupe[] = $line;
				}
			}
		}
		if(!empty($this->AFF_SN) && $this->AFF_SN==true ){
			if(isset($this->contenu[$i]->sn) && is_array($this->contenu[$i]->sn)) {
				foreach ($this->contenu[$i]->sn as $sn_line) {
				$line = new stdClass();
				$line->type_of_line = "description";
				$line->lib_article = $sn_line->numero_serie;
				$new_contenu_decoupe[] = $line;
				}
			}
		}
	
	}
	$this->contenu = $new_contenu_decoupe;

	// ***************************************************
	// Comptage du nombre de page nécessaires
	$hauteur_totale = 0;
	$old_index = 0;
	if(!empty($this->AFF_CG) && $this->AFF_CG){
		$this->nb_pages ++;
	}
	for ($i=0; $i<count($this->contenu); $i++) {
		// Ne pas compter les lignes invisibles
		if (isset($this->contenu[$i]->visible) && !$this->contenu[$i]->visible) { continue; }
		
		// Hauteur de la ligne
		$hauteur_ligne = $this->{"HAUTEUR_LINE_".strtoupper($this->contenu[$i]->type_of_line)};


		// Vérification de la nécessité de changer de page
		$hauteur_totale += $hauteur_ligne;
		if ($hauteur_totale + 6 >= $this->CORPS_HAUTEUR_MAX) {
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
	$this->pdf->AddPage();
	
	// ***************************************************
	// filigrane
	if (isset($GLOBALS['PDF_OPTIONS']['filigrane'])) {
	
	$this->pdf->SetTextColor(200,200,200);
	$this->pdf->SetXY($this->MARGE_GAUCHE, 145);
	$this->pdf->SetFont('Arial', 'B',35);
	$this->pdf->Cell (190, 6, $GLOBALS['PDF_OPTIONS']['filigrane'], 0, 0, 'C');
	
	$this->pdf->SetTextColor(0,0,0);
	}
	
	$this->pdf->Line(205, 105, 212, 105); //ligne de pli pour courrier
	
	$this->create_pdf_entete ();
	$this->create_pdf_adresse ();
	$this->create_pdf_corps ();
	$this->create_pdf_texte_corps_pieds ();
	$this->create_pdf_pieds ();

	if ($this->page_actuelle < $this->nb_pages) {
		if(!empty($this->AFF_CG) && $this->AFF_CG && $this->page_actuelle == $this->nb_pages -1){
			$this->create_pdf_page_cg();
		}else{
			$this->create_pdf_page();
		}
	} 
}


// Créé l'entete du document PDF
protected function create_pdf_entete () {
	global $IMAGES_DIR;

	$hauteur = $this->MARGE_HAUT;
	// ***************************************************
	// LOGO
	$this->pdf->Image($IMAGES_DIR.$this->IMG_LOGO, $this->MARGE_GAUCHE - 5, $this->MARGE_HAUT, 80);

	// ***************************************************
	// TITRE
	$this->pdf->SetXY(100, $hauteur);
	$this->pdf->SetFont('Times', 'B', 25);
	if($this->montant_ht>=0 || empty($this->LIB_NEG)){
		$this->pdf->Cell (95, 10, $this->lib_type_printed, 0, 0, 'L');
	}else{
		$this->pdf->Cell (95, 10, $this->LIB_NEG, 0, 0, 'L');
	}

	// ***************************************************
	// Référence du document
	$hauteur += 12;
	$this->pdf->SetXY(101, $hauteur);
	$this->pdf->SetFont('Arial', '', 8);
	$ref_doc_lib = "Notre Référence";
	$this->pdf->Cell (22, 3, $ref_doc_lib, 0, 0, 'L');
	$this->pdf->Cell (3, 3, ":", 0, 0, 'L');
	$this->pdf->Cell (40, 3, $this->ref_doc, 0, 0, 'L');
	if(!empty($this->ref_doc_externe)){
		$hauteur += 4;
		$this->pdf->SetXY(101, $hauteur);
		$ref_doc_externe_lib = "Votre Référence";
		$this->pdf->Cell (22, 3, $ref_doc_externe_lib, 0, 0, 'L');
		$this->pdf->Cell (3, 3, ":", 0, 0, 'L');
		$this->pdf->Cell (40, 3, $this->ref_doc_externe, 0, 0, 'L');
	}

	// ***************************************************
	// Date du document
	$hauteur += 4;
	$this->pdf->SetXY(101, $hauteur);
	$date_lib = "Date";
	$this->pdf->Cell (22, 3, $date_lib, 0, 0, 'L');
	$this->pdf->Cell (3, 3, ":", 0, 0, 'L');
	$this->pdf->Cell (40, 3, date_Us_to_Fr($this->date_creation), 0, 0, 'L');
        if ($this->stock != "")
            {
                 $hauteur += 4;
                 $this->pdf->SetXY(101, $hauteur);
                 $this->pdf->Cell (22, 3, "Stock", 0, 0, 'L');
                 $this->pdf->Cell (3, 3, ":", 0, 0, 'L');
                 $this->pdf->Cell (40, 3, $this->stock, 0, 0, 'L');
            }
	return true;
}


// Créé l'adresse du PDF
protected function create_pdf_adresse () {
	$decalage_gauche 	= 97;
	$decalage_haut		= 40;
	$hauteur	= 96;
	$largeur	= 45;
	$marge = 4;

	// ***************************************************
	// Code à Barre
	if(!isset($this->AFF_CODE_BARRE) || $this->AFF_CODE_BARRE==true){
		$this->pdf->Code39 ($decalage_gauche + $marge + 1, $decalage_haut +1, $this->ref_doc, 0.9, 7);
	}
		
	// ***************************************************
	// ADRESSE
	$this->pdf->SetLeftMargin($decalage_gauche + $marge);
	$this->pdf->RoundedRect ($decalage_gauche, $decalage_haut, $hauteur, $largeur, 4, 'D', '1234');

	$this->pdf->SetXY($decalage_gauche + $marge, $decalage_haut + $marge + 7);
	$this->pdf->SetFont('Arial', '', 10);
	$this->pdf->Write (4, $this->nom_contact);

	$this->pdf->SetXY($decalage_gauche + $marge, $decalage_haut + $marge + 16);
	$this->pdf->SetFont('Arial', '', 9);
	$adresse = strtoupper($this->adresse_contact);
	$this->pdf->Write (4.5, $adresse);

	return true;
}


// Créé le corps du PDF
protected function create_pdf_corps () {
	global $AFF_REMISES;

	$this->decalage_corps_actuel	= 0;

	// ***************************************************
	// Numéro de page
	$this->pdf->SetXY(-45, $this->CORPS_HAUTEUR_DEPART - 6);
	$this->pdf->SetFont('Arial', 'I', 8);
	$page_lib = "Page ".$this->page_actuelle." / ".$this->nb_pages;
	$this->pdf->Cell (30, 6, $page_lib, 0, 0, 'R');

	
	//***************************************************
	// Entete du tableau
	$entete_tableau_Y = $this->CORPS_HAUTEUR_DEPART + $this->decalage_corps_actuel;
	$this->pdf->SetXY($this->MARGE_GAUCHE, $entete_tableau_Y);
	$this->decalage_corps_actuel += 6;

	$this->pdf->SetFont('Arial', 'B', 10);
	if(!isset($this->REF_ARTICLE) || $this->REF_ARTICLE!="Aucune"){
		$this->pdf->Cell ($this->LARGEUR_COL_REF, 6, $this->ENTETE_COL_REF, 1, 0, 'L');
	}
	$this->pdf->Cell ($this->LARGEUR_COL_LIB, 6, $this->ENTETE_COL_DES, 1, 0, 'L');
	$this->pdf->Cell ($this->LARGEUR_COL_QTE, 6, $this->ENTETE_COL_QTE, 1, 0, 'C');
	if(!isset($this->AFF_PRIX) || $this->AFF_PRIX){
		$this->pdf->Cell ($this->LARGEUR_COL_PRI, 6, $this->ENTETE_COL_PU, 1, 0, 'C');
		if ($AFF_REMISES) {
			$this->pdf->Cell ($this->LARGEUR_COL_REM, 6, $this->ENTETE_COL_REM, 1, 0, 'C');
		}
		$this->pdf->Cell ($this->LARGEUR_COL_PRI, 6, $this->ENTETE_COL_PT, 1, 0, 'C');
		$this->pdf->Cell ($this->LARGEUR_COL_TVA, 6, $this->ENTETE_COL_TVA, 1, 0, 'C');
	}

	// ***************************************************
	// Contenu du tableau
	for ($i = $this->contenu_actuel; $i<count($this->contenu); $i++) {
		if (isset($this->contenu[$i]->visible) && !$this->contenu[$i]->visible) { continue; } // Ne pas afficher les lignes invisibles

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

	// Faire décendre le tableau jusqu'en bas du corps
	while ($this->decalage_corps_actuel <= $this->CORPS_HAUTEUR_MAX-1) {
		$line = new stdClass();
		$this->create_pdf_corps_line($line);
	}

	return true;
}



protected function create_pdf_corps_line ($line) {
	global $AFF_REMISES;
	global $MONNAIE;
	global $TARIFS_NB_DECIMALES;

	// ***************************************************
	// Valeurs par défaut
	if (!isset($line->type_of_line)) 	{ $line->type_of_line = "vide"; 	}
	if (!isset($line->ref_article)) 	{ $line->ref_article = ""; 			}
	if (!isset($line->ref_oem))			{ $line->ref_oem = ""; 				}
	if (!isset($line->ref_interne)) 	{ $line->ref_interne = ""; 			}
	if (!isset($line->lib_article)) 	{ $line->lib_article = ""; 			}
	if (!isset($line->desc_article))	{ $line->desc_article = ""; 		}
	if (!isset($line->qte)) 			{ $line->qte = ""; 					}
	if (!isset($line->pu_ht)) 			{ $line->pu_ht = ""; 				}
	if (!isset($line->remise)) 			{ $line->remise = ""; 				}
	if (!isset($line->tva)) 			{ $line->tva = ""; 					}
	$line->pu = $line->pt = "";

	$fill = 0;
	// Cadre
	$cadre = "LR"; // Gauche et droite

	// Positionnement au début de la ligne
	$this->pdf->SetXY($this->MARGE_GAUCHE, $this->CORPS_HAUTEUR_DEPART + $this->decalage_corps_actuel);
	// Style d'écriture par défaut
	$this->pdf->SetFont('Arial', '', 9);
	
	// Calcul du Prix unitaire et du Prix total
	$line->pu = $line->pu_ht;
	if ($this->app_tarifs == "TTC" && $line->type_of_line != "taxe") {
		$line->pu = ht2ttc($line->pu_ht, $line->tva);
	}
	$line->pt = round($line->pu * $line->qte * (1-$line->remise/100), $TARIFS_NB_DECIMALES);

	// Spécifités à l'affichage
	switch ($line->type_of_line) {
		case "article":
			if ($line->remise) { $line->remise = $line->remise." %"; }
			else { $line->remise = ""; }
			$line->pu = price_format ($line->pu);
			if (isset($this->st_lines)) {$this->st_lines += $line->pt;}
			$line->pt = price_format ($line->pt);
		break;
		case "taxe":
			$this->pdf->SetFont('Arial', 'I', 9);
			$line->lib_article	= "  dont taxe ".strtoupper($line->lib_article)." : ";
			$line->lib_article .= "".price_format ($line->pt);
			$line->ref_article = $line->qte = $line->pu = $line->remise = $line->pt = $line->tva = "";
		break;
		case "information":
			$this->pdf->SetFont('Arial', 'B', 9);
			$line->ref_article = $line->qte = $line->pu = $line->remise = $line->pt = $line->tva = "";
		break;
		case "soustotal":
		
		$this->pdf->SetFillColor(200,200,200);
		$fill = 1;
			$line->lib_article	= ($line->lib_article);
			$line->ref_article = " => Sous-total : ";
			$line->pt = price_format ($line->pu);
			if (isset($this->st_lines)) {$line->pt = price_format ($this->st_lines); $this->st_lines = 0;}
			$line->qte =  $line->remise = $line->pu = $line->tva = "";
		break;
		case "description":
			$this->pdf->SetFont('Arial', 'I', 9);
			$line->ref_article = $line->qte = $line->pu = $line->remise = $line->pt = $line->tva = "";
		break;
		case "vide":
			if ($this->decalage_corps_actuel >= $this->CORPS_HAUTEUR_MAX-1) {
				$cadre = "LRB";
			}
			$line->ref_article = $line->qte = $line->pu = $line->remise = $line->pt = $line->tva = "";
		break;
	}

	$hauteur = $this->{"HAUTEUR_LINE_".strtoupper($line->type_of_line)};
	$this->decalage_corps_actuel += $hauteur;

	if(isset($this->REF_ARTICLE)){
		switch($this->REF_ARTICLE){
			case 'Aucune' :
				$ref_article = "";
			break;
			case 'Interne' :
				if (!$line->ref_interne) {
					$ref_article = $line->ref_article;
				} else {
					$ref_article = $line->ref_interne;
				}
			break;
			case 'Oem' :
				if (!$line->ref_oem) {
					$ref_article = $line->ref_article;
				} else {
					$ref_article = $line->ref_oem;
				}
			break;
			default :
				$ref_article = $line->ref_article;
			break;
		}
	}else{
		$ref_article = $line->ref_article;
	}

	// Affichage de la ligne de contenu
	if(empty($this->REF_ARTICLE) || $this->REF_ARTICLE!="Aucune"){
		$this->pdf->Cell($this->LARGEUR_COL_REF, $hauteur, $ref_article, $cadre, 0, 'L', $fill);
	}
	$this->pdf->Cell($this->LARGEUR_COL_LIB, $hauteur, $line->lib_article, $cadre, 0, 'L', $fill);
	$this->pdf->Cell($this->LARGEUR_COL_QTE, $hauteur, $line->qte, $cadre, 0, 'C', $fill);
	if(!isset($this->AFF_PRIX) || $this->AFF_PRIX){
		$this->pdf->Cell($this->LARGEUR_COL_PRI, $hauteur, $line->pu, $cadre, 0, 'R', $fill);
		if ($AFF_REMISES) {
			$this->pdf->Cell($this->LARGEUR_COL_REM, $hauteur, $line->remise, $cadre, 0, 'R', $fill);
		}
		$this->pdf->Cell($this->LARGEUR_COL_PRI, $hauteur, $line->pt, $cadre, 0, 'R', $fill);
		$this->pdf->Cell($this->LARGEUR_COL_TVA, $hauteur, $line->tva, $cadre, 0, 'C', $fill);
	}

	return true;
}


protected function create_pdf_texte_corps_pieds () {
	// Ecrits entre le corps et pieds de page
	$this->pdf->SetXY($this->MARGE_GAUCHE, $this->CORPS_HAUTEUR_DEPART + $this->CORPS_HAUTEUR_MAX +1);
	$this->pdf->SetFont('Arial', 'I', 6);
	if(is_array($this->TEXTE_CORPS_PIEDS)){
		foreach ($this->TEXTE_CORPS_PIEDS as $texte) {
			$this->pdf->Cell ($this->LARGEUR_TOTALE_CORPS , 2.5, $texte, 0, 2, 'L', false);
		}
	}else{
		$this->pdf->MultiCell ($this->LARGEUR_TOTALE_CORPS , 2.5, $this->TEXTE_CORPS_PIEDS, '0', 'L', false);
	}
}


protected function create_pdf_pieds () {
	global $MONNAIE;

	//Cadre
	$this->pdf->SetFont('Arial', 'I', 8);
	$this->pdf->SetXY($this->MARGE_GAUCHE, $this->PIEDS_HAUTEUR_DEPART);
	$this->pdf->Cell ($this->LARGEUR_TOTALE_CORPS, $this->PIEDS_HAUTEUR_MAX, "", '1', 1, 'L');

	// Information société
	$this->pdf->SetXY($this->MARGE_GAUCHE, $this->PIEDS_HAUTEUR_DEPART + $this->PIEDS_HAUTEUR_MAX + 1);
	foreach ($this->PIEDS_GAUCHE as $texte) {
		$this->pdf->Cell ($this->LARGEUR_TOTALE_CORPS, 4.5, $texte, '0', 2, 'L');
	}

	$this->pdf->SetXY(0, $this->PIEDS_HAUTEUR_DEPART + $this->PIEDS_HAUTEUR_MAX + 1);
	foreach ($this->PIEDS_DROIT as $texte) {
		$this->pdf->Cell ($this->MARGE_GAUCHE + $this->LARGEUR_TOTALE_CORPS, 4.5, $texte, '0', 2, 'R');
	}
	
	$largeur_bloc_montant = 0;
	$largeur_bloc_tva = 0;
	if(!isset($this->AFF_PRIX) || $this->AFF_PRIX){
		// Bloc Montant Total
		$largeur_bloc_montant = 61;
		$largeur_col1_montant = 30;
		$largeur_col2_montant = 3;
		$largeur_col3_montant = $largeur_bloc_montant - $largeur_col1_montant - $largeur_col2_montant;
	
		$this->pdf->SetXY($this->MARGE_GAUCHE + $this->LARGEUR_TOTALE_CORPS - $largeur_bloc_montant, $this->PIEDS_HAUTEUR_DEPART);
		$this->pdf->SetFont('Arial', 'B', 10);
		$this->pdf->Cell ($largeur_bloc_montant, 8, "MONTANT TOTAL EN ".$MONNAIE[2], '1', 2, 'C');
	
		$this->pdf->Cell ($largeur_col1_montant, 7, "Montant HT", 'L', 0, 'L');
		$this->pdf->Cell ($largeur_col2_montant, 7, ":", '0', 0, 'C');
		$this->pdf->Cell ($largeur_col3_montant, 7, price_format ($this->montant_ht)."  ", '0', 2, 'R');
		$this->pdf->SetX ($this->MARGE_GAUCHE + $this->LARGEUR_TOTALE_CORPS - $largeur_bloc_montant);
	
		$this->pdf->Cell ($largeur_col1_montant, 7, "Montant TVA", 'L', 0, 'L');
		$this->pdf->Cell ($largeur_col2_montant, 7, ":", '0', 0, 'C');
		$this->pdf->Cell ($largeur_col3_montant, 7, price_format ($this->montant_tva)."  ", '0', 2, 'R');
		$this->pdf->SetX ($this->MARGE_GAUCHE + $this->LARGEUR_TOTALE_CORPS - $largeur_bloc_montant);
	
		$this->pdf->SetFont('Arial', 'B', 13);
		$this->pdf->Cell ($largeur_col1_montant, 10, "Montant TTC", 'LTB', 0, 'L');
		$this->pdf->Cell ($largeur_col2_montant, 10, ":", 'TB', 0, 'C');
		$this->pdf->Cell ($largeur_col3_montant, 10, price_format ($this->montant_ttc)."  ", 'TBR', 2, 'R');
		
		// Bloc TVA
		$largeur_bloc_tva = 40;
		$largeur_col1_tva = 20;
		$largeur_col2_tva = $largeur_bloc_tva - $largeur_col1_tva;
	
		$this->pdf->SetXY($this->MARGE_GAUCHE, $this->PIEDS_HAUTEUR_DEPART);
		$this->pdf->SetFont('Arial', 'B', 10);
		$this->pdf->Cell ($largeur_col1_tva, 8, "Taux TVA", '1', 0, 'C');
		$this->pdf->Cell ($largeur_col2_tva, 8, "Montant", '1', 2, 'C');
		$this->pdf->SetX($this->MARGE_GAUCHE);
		$this->pdf->SetFont('Arial', '', 9);
		foreach ($this->tvas as $tva => $montant_tva) {
			if (!$montant_tva) { continue; }
			$this->pdf->Cell ($largeur_col1_tva, 6, $tva." %", 'R', 0, 'C');
			$this->pdf->Cell ($largeur_col2_tva, 6, price_format ($montant_tva)."  ", 'R', 2, 'R');
			$this->pdf->SetX($this->MARGE_GAUCHE);
		}
		while ($this->pdf->getY() < $this->PIEDS_HAUTEUR_DEPART + $this->PIEDS_HAUTEUR_MAX) {
			$this->pdf->Cell ($largeur_col1_tva, 1, "", 'R', 0, 'C');
			$this->pdf->Cell ($largeur_col2_tva, 1, "", 'R', 2, 'C');
			$this->pdf->SetX($this->MARGE_GAUCHE);
		}
	}
	// Bloc central
	$this->pdf->SetXY($this->MARGE_GAUCHE + $largeur_bloc_tva, $this->PIEDS_HAUTEUR_DEPART);
	$this->pdf->SetFont('Arial', 'B', 10);
	$this->pdf->Cell ($this->LARGEUR_TOTALE_CORPS-$largeur_bloc_montant-$largeur_bloc_tva, 8, "Conditions de règlement", '1', 0, 'C');
}

	protected function create_pdf_page_cg () {
		// Comptage du nombre de page
		$this->page_actuelle++;
	
		// Création d'une nouvelle page
		$this->pdf->AddPage();
		
	
		$this->create_pdf_texte_fin_doc();
		
	}
	
	protected function create_pdf_texte_fin_doc () {
		$this->pdf->SetMargins($this->MARGE_GAUCHE, $this->MARGE_HAUT);
		$this->pdf->SetXY($this->MARGE_GAUCHE, $this->MARGE_HAUT);
		$this->pdf->SetFont('Arial', 'I', 9);
		$this->pdf->Write(3, "\n");
		$this->pdf->MultiCell(0, 3, str_replace("¤","€",str_replace("&#8211;","-",str_replace("&#8230;","...",str_replace("&#8217;", "'", $this->CG_VERSO)))));
		
		
	}


}

?>
