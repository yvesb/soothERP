<?PHP 
// *************************************************************************************************************
// CLASSE PERMETTANT L'AJOUT D'UN DOCUMENT A UN PDF - MODELE STANDARD
// *************************************************************************************************************

class pdf_cou_standard {
	var $code_pdf_modele = "cou_standard";

	var $pdf;							// PDF destiné à contenir le document
	var $courrier;						// Courrier à imprimer
	var $contenu;						// Contenu du Courrier à imprimer
	var $contenu_line;

	
	var $ref_doc;
	var $lib_type_printed;
	var $date_creation;
	var $destinataires;
	var $expediteur;
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


/**
 * @param $pdf
 * @param $courrier
 * @return this
 */
public function pdf_cou_standard (&$pdf, $courrier) {
	global $PDF_MODELES_DIR;
	global $AFF_REMISES;
	global $DOC_STANDARD;

	$this->pdf 						= $pdf;
	$this->courrier					= $courrier;
	$this->ref_doc					= $courrier->getCode_courrier();
	
	$this->lib_type_printed			= $courrier->getLib_type_courrier();
	$this->contenu 					= $courrier->getContenu();
	$this->date_creation 			= $courrier->getDate_courrier();
	$this->st_lines = 0;
	
	include ($PDF_MODELES_DIR."config/".$this->code_pdf_modele.".config.php");

	// ***************************************************
	// Initialisation des variables
	$this->nb_pages	= 1;
	$this->contenu_actuel = 0;					// Ligne du document en cours de traitement
	$this->contenu_end_page = array();		// Lignes de contenu terminant les différentes pages
	$this->page_actuelle = 0;
	$this->content_printed = 0;

	// ***************************************************
	// Valeurs par défaut
	foreach ($DOC_STANDARD as $var => $valeur) {
		$this->{$var} = $valeur;
	}
	
	//Destinataire
	if(is_subclass_of($this->courrier, "Courrier")){
		$destinataires = $this->courrier->getDestinataires ();
		$this->dest_contact = new contact ($destinataires[0]->getRef_contact ());
		$adresses = $this->dest_contact->getAdresses();
		if (isset($adresses[0])){
                    $this->dest_adresse = new adresse ($adresses[0]->getRef_adresse ());
                }else{
                    echo "Adresse du destinataire non definie !";
                    exit;
                }
	} else {
		$this->dest_contact = new contact ($this->REF_CONTACT_ENTREPRISE);
		$adresses = $this->dest_contact->getAdresses();
		$this->dest_adresse = new adresse ($adresses[0]->getRef_adresse ());
	}
	
	//Emmeteur (defaut : entreprise)ucfirst 
	$this->em_contact = new contact ($this->REF_CONTACT_ENTREPRISE);
	$em_adresses = $this->em_contact->getAdresses();
	$this->em_adresse = new adresse ($em_adresses[0]->getRef_adresse ());
	
	//****************************************************
	// AJUSTEMENT DE LA TAILLE DES COLONNES 
	$this->LARGEUR_TOTALE_CORPS  = $this->MARGE_GAUCHE + 160;
	$this->pdf->SetLeftMargin($this->MARGE_GAUCHE);
	// ***************************************************
	// Comptage du nombre de page nécessaires
	$hauteur_totale = 0;
	$this->contenu_line = explode("<br>",$this->contenu);
	for ($i=0; $i<count($this->contenu_line); $i++) {

		// Hauteur de la ligne
		$this->hauteur_ligne = 5;

		// Vérification de la nécessité de changer de page
		$hauteur_totale += $this->hauteur_ligne;
		if ($hauteur_totale >= $this->CORPS_HAUTEUR_MAX) {
			
			$this->contenu_end_page[] = $old_index;
			$this->nb_pages ++;
			$hauteur_totale = 0;
		}

		// Archive de l'index de la ligne
		$old_index = $i;
	}
	return $this;
}


// Créé une nouvelle page du document PDF
/**
 * @return bool
 */
protected function create_pdf_page () {
	// Comptage du nombre de page
	$this->page_actuelle++;

	// Création d'une nouvelle page
	$this->pdf->AddPage();
	
	$this->pdf->Line(205, 105, 212, 105); //ligne de pli pour courrier
	
	$this->create_pdf_entete ();
	$this->create_pdf_adresse ();
	$this->create_pdf_objet ();
	$this->create_pdf_corps ();
	return true;
}

// Créé une nouvelle page du document PDF
/**
 * @return bool
 */
protected function create_pdf_page_txt () {
	// Comptage du nombre de page
	$this->page_actuelle++;

	// Création d'une nouvelle page
	$this->pdf->AddPage();
	
	$this->pdf->Line(205, 105, 212, 105); //ligne de pli pour courrier
	
	$this->create_pdf_corps ();

	while ($this->page_actuelle < $this->nb_pages) {
		$this->create_pdf_page_txt();
	}
	return true;
}

// Créé l'entete du document PDF
/**
 * @return bool
 */
protected function create_pdf_entete () {
	global $IMAGES_DIR;

	$hauteur = $this->MARGE_HAUT;
	// ***************************************************
	// LOGO
	$this->pdf->Image($IMAGES_DIR.$this->IMG_LOGO, $this->MARGE_GAUCHE - 5, $this->MARGE_HAUT, 80);

	return true;
}


// Créé l'adresse du PDF
/**
 * @return bool
 */
protected function create_pdf_adresse () {
	$decalage_gauche 	= 97;
	$decalage_haut		= 40;
	$hauteur	= 96;
	$largeur	= 45;
	$marge = 4;
		
	// ***************************************************
	// ADRESSE DESTINATAIRE
	$this->pdf->SetLeftMargin($decalage_gauche + $marge);
	$this->pdf->SetXY($decalage_gauche + $marge, $decalage_haut + $marge + 5);
	$this->pdf->SetFont('Arial', '', 10);
	$this->pdf->Cell (0,4.5, strtoupper($this->dest_contact->getNom ()), 0 , 2 , "L");
	$this->pdf->SetXY($decalage_gauche + $marge, $decalage_haut + $marge + 14);
	$this->pdf->SetFont('Arial', '', 9);
	$this->pdf->MultiCell (0,4.5, strtoupper($this->dest_adresse->getText_adresse ()),  2 , "L");
	//si on souhaite le nom de la ville avec la 1ere lettre en majuscule 
	// $format_ville = ucfirst ( strtolower($this->dest_adresse->getVille()) );    
	$format_ville = $this->dest_adresse->getVille() ;
	$this->pdf->Cell (0,4.5, $this->dest_adresse->getCode_Postal ().' '.$format_ville, 0 , 2 , "L");
	$this->pdf->Cell (0,4.5, $this->dest_adresse->getPays (), 0 , 2 , "L");
	
	return true;
}

// Créé l'objet & infos sup du PDF
/**
 * @return bool
 */
protected function create_pdf_objet () {
	// ***************************************************
	// Lieux & Date
	$this->pdf->SetXY($this->MARGE_GAUCHE, $this->OBJET_HAUTEUR_DEPART);
	$this->pdf->SetFont('Arial', 'B', 10);
	$this->pdf->Cell ($this->LARGEUR_TOTALE_CORPS, 5,"Le ".lmb_strftime('%A, %d %B %Y', "fr_FRA", strtotime($this->courrier->getDate_courrier())).",",0,2,"R");
	$format_ville = ucfirst ( strtolower($this->em_adresse->getVille()) );
	$this->pdf->Cell ($this->LARGEUR_TOTALE_CORPS, 5,html_entity_decode ("&#192;&nbsp;").$format_ville.",",0,2,"R");
	
	// ***************************************************
	// Référence courrier
	$this->pdf->SetXY($this->MARGE_GAUCHE, $this->OBJET_HAUTEUR_DEPART);
	$this->pdf->SetFont('Arial', '', 10);
	$ref = "";
	if(is_subclass_of($this->courrier, "Courrier")){
		$ref .= "Références : ";
		$ref_courrier = strval( $this->courrier->getId_courrier ());
		$ref .= $ref_courrier;
		if( $ref_courrier != "" ){ $ref .= " | "; }
		$ref .= $this->dest_contact->getRef_contact ();
		$this->pdf->Cell ($this->LARGEUR_TOTALE_CORPS, 5,$ref,0,1,"L");
	}
	
	// ***************************************************
	// Objet
	$this->pdf->SetXY($this->MARGE_GAUCHE, $this->OBJET_HAUTEUR_DEPART + 5 );
	$this->pdf->SetFont('Arial', 'B', 10);
	$this->pdf->Cell (12, 5,"Objet :",0,0,"L");
	$this->pdf->Cell (60, 5,$this->courrier->getObjet (),0,1,"L");
	
	return true;
	
}


// Créé le corps du PDF
/**
 * @return bool
 */
protected function create_pdf_corps () {

	$this->decalage_corps_actuel	= 0;

	// ***************************************************
	// Corps du courrier
	if( $this->page_actuelle != 1){
		$this->CORPS_HAUTEUR_DEPART = $this->MARGE_HAUT;
	}
	/*
	$this->createPdfCourrier_corps();
	*/
	$this->pdf->AliasNbPages();
	$this->pdf->SetAutoPageBreak(true,$this->PIEDS_HAUTEUR_MAX);
	$this->pdf->SetLeftMargin($this->MARGE_GAUCHE);
	$this->pdf->SetFont('Arial', 'I', 8);
	$this->decalage_corps_actuel	= 0;
	$this->pdf->SetXY($this->MARGE_GAUCHE, $this->CORPS_HAUTEUR_DEPART);
	$this->html2fpdf($this->contenu);
	$this->pdf->SetAutoPageBreak(false);
	return true;
}

/**
 * @return bool
 */
protected function createPdfCourrier_corps () {
	
	// ***************************************************
	// setup
	$this->pdf->SetXY($this->MARGE_GAUCHE, $this->CORPS_HAUTEUR_DEPART);
	$this->pdf->SetFont('Arial', 'I', 8);
	$this->decalage_corps_actuel	= 0;
	
	// ***************************************************
	// Contenu du courrier
	for ($i = $this->contenu_actuel; $i<count($this->contenu_line); $i++) {
		
		$line = $this->contenu_line[$i];
		
		$this->create_pdf_corps_line($line);
		$this->contenu_actuel = $i+1;

		// Controle de la fin du document
		if ($i == count($this->contenu_line)-1) {
			$this->content_printed= 1;
			break; 
		}

		// Controle de la nécessité de changer de page
		if (in_array($i, $this->contenu_end_page)) { break;	}
	}
	// Faire descendre le tableau jusqu'en bas du corps
	while ($this->decalage_corps_actuel <= $this->CORPS_HAUTEUR_MAX-1) {
		$this->decalage_corps_actuel += $this->hauteur_ligne;
		$this->pdf->SetXY($this->MARGE_GAUCHE, $this->CORPS_HAUTEUR_DEPART + $this->decalage_corps_actuel);
		$this->pdf->Cell($this->LARGEUR_TOTALE_CORPS, $this->hauteur_ligne, "", 0, 0, 'L');
	}
	return true;
}

/**
 * @param $line
 * @return bool
 */
protected function create_pdf_corps_line ($line) {
	// Positionnement au début de la ligne
	$this->pdf->SetXY($this->MARGE_GAUCHE, $this->CORPS_HAUTEUR_DEPART + $this->decalage_corps_actuel);
	// Style d'écriture par défaut
	$this->pdf->SetFont('Arial', '', 9);
	// decalage naturel
	$this->decalage_corps_actuel += $this->hauteur_ligne;
	// decalage Ln
	$largeur_line = $this->pdf->GetStringWidth($line);
	while ( $largeur_line > $this->LARGEUR_TOTALE_CORPS ){
		$this->decalage_corps_actuel += $this->hauteur_ligne;
		$largeur_line = $largeur_line /2;
	}
	// print
	$this->pdf->MultiCell($this->LARGEUR_TOTALE_CORPS, $this->hauteur_ligne, $line, 0, "L" );
	
	return true;
}

/**
 * @return bool
 */
protected function create_pdf_texte_corps_pieds () {
	// Ecrits entre le corps et pieds de page
	$this->pdf->SetXY($this->MARGE_GAUCHE, $this->CORPS_HAUTEUR_DEPART + $this->CORPS_HAUTEUR_MAX +1);
	$this->pdf->SetFont('Arial', 'I', 6);
	if(count($this->TEXTE_CORPS_PIEDS)>1){
		foreach ($this->TEXTE_CORPS_PIEDS as $texte) {
			$this->pdf->Cell ($this->LARGEUR_TOTALE_CORPS , 2.5, $texte, 0, 2, 'L', false);
		}
	}else{
		$this->pdf->MultiCell ($this->LARGEUR_TOTALE_CORPS , 2.5, $this->TEXTE_CORPS_PIEDS, '0', 'L', false);
	}
	return true;
}


/**
 * @return bool
 */
protected function create_pdf_pieds () {

	// ***************************************************
	// Numéro de page
	$this->pdf->SetXY($this->MARGE_GAUCHE, $this->PIEDS_HAUTEUR_DEPART+ $this->PIEDS_HAUTEUR_MAX - 6);
	$this->pdf->SetFont('Arial', 'I', 8);
	$page_lib = "Page ".$this->page_actuelle." / ".$this->nb_pages;
	$this->pdf->Cell ($this->LARGEUR_TOTALE_CORPS, 6, $page_lib, 0, 0, 'R');
	
	// ***************************************************
	// Ligne
	$this->pdf->Line($this->MARGE_GAUCHE, $this->PIEDS_HAUTEUR_DEPART+ $this->PIEDS_HAUTEUR_MAX, $this->LARGEUR_TOTALE_CORPS+$this->MARGE_GAUCHE, $this->PIEDS_HAUTEUR_DEPART+ $this->PIEDS_HAUTEUR_MAX);
	// ***************************************************
	// Informations entreprise
	$this->pdf->SetXY($this->MARGE_GAUCHE, $this->PIEDS_HAUTEUR_DEPART + $this->PIEDS_HAUTEUR_MAX + 1);
	$this->pdf->SetFont('Arial', 'I', 8);
	foreach ($this->PIEDS_GAUCHE as $texte) {
		$this->pdf->Cell ($this->LARGEUR_TOTALE_CORPS, 4.5, $texte, '0', 2, 'L');
	}

	$this->pdf->SetXY(0, $this->PIEDS_HAUTEUR_DEPART + $this->PIEDS_HAUTEUR_MAX + 1);
	foreach ($this->PIEDS_DROIT as $texte) {
		$this->pdf->Cell ($this->MARGE_GAUCHE + $this->LARGEUR_TOTALE_CORPS, 4.5, $texte, '0', 2, 'R');
	}
	return true;
}

	
	/**
	 * @return bool
	 */
	protected function create_pdf_texte_fin_doc () {
		$this->pdf->SetMargins($this->MARGE_GAUCHE, $this->MARGE_HAUT);
		$this->pdf->SetXY($this->MARGE_GAUCHE, $this->MARGE_HAUT);
		$this->pdf->SetFont('Arial', 'I', 9);
		$this->pdf->Write(3, "\n");
		$this->pdf->MultiCell(0, 3, str_replace("¤","€",str_replace("&#8211;","-",str_replace("&#8230;","...",str_replace("&#8217;", "'", $this->CG_VERSO)))));
	}
	
	/**
	 * @return true
	 */
	public function writePdf(){
		//@FIXME rewrite construct
		// ***************************************************
		// Création de la première page
		$this->create_pdf_page ();
		// content printed w/ constructor
		return true;
	}
	
public function html2fpdf($html){
		$tab = array();
		$history = array();
		$nbligne = 0; 
		$html = strip_tags(htmlspecialchars_decode($html), '<span><br>');
	    $html = str_replace("\r\n", '', $html);
	    $html = str_replace("&nbsp;", " ", $html);
	    $html = str_replace("<br>", "#br#", $html,$nbligne);
	    $html = str_replace("background-color: rgb", "background-color: frgb", $html);
	    $tmp = explode('<', $html);
	    foreach ($tmp as $t) {
	    	if (substr_count($t, "span") == 0) {
	    		$this->pdf->Write(5, str_replace("#br#", "\n", $t));
				
				}
    		else if (strncmp("/span", $t, 5) == 0) {
    			$sty = array_pop($history);
  				foreach($sty as $s) {
	  				if (strncmp('rgb', $s, 3) == 0) {
							$this->pdf->SetTextColor(0, 0, 0);
						} else if (strncmp('frgb', $s, 4) == 0) {
							$this->pdf->SetFillColor(255, 255, 255);
						} else if ($s == 'bold') {
							$this->pdf->SetFont('', str_replace('B', '', $this->pdf->FontStyle));
						} else if ($s == 'italic') {
							$this->pdf->SetFont('', str_replace('I', '', $this->pdf->FontStyle));
						} else if ($s == 'underline') {
							$this->pdf->SetFont('', $this->pdf->FontStyle);
						}
  				}
  				$this->pdf->Write(5, str_replace("#br#", "\n", str_replace("/span>", "", $t)));
				
				
    		} else if (strncmp("span ", $t, 5) == 0) {
    			$t .= '#end#';
    			preg_match_all('/span\s*style\s*=\s*".*?:\s*(.*?);\s*"\s*>(.*?)#end#/', $t, $tab, PREG_SET_ORDER);
    			
    			$tmp1 = preg_split('/\s*;.*?:\s*/', $tab[0][1]);
				array_push($history, $tmp1);
				
				foreach ($tmp1 as $style) {
					if (strncmp('rgb', $style, 3) == 0) {
						eval('$this->pdf->'.str_replace('rgb', 'SetTextColor', $style).';'); //$tab[0][1]).';');
					} else if (strncmp('frgb', $style, 4) == 0) {
						eval('$this->pdf->'.str_replace('frgb', 'SetFillColor',  $style).';'); //$tab[0][1]).';');
					} else if ($style == 'bold') {
						$this->pdf->SetFont('', $this->pdf->FontStyle.((! substr_count($this->pdf->FontStyle, "B")) ? 'B': '').(($this->pdf->underline) ? 'U' : ''));
					} else if ($style == 'italic') {
						$this->pdf->SetFont('', $this->pdf->FontStyle.((! substr_count($this->pdf->FontStyle, "I")) ? 'I': '').(($this->pdf->underline) ? 'U' : ''));
					} else if ($style == 'underline') {
						$this->pdf->SetFont('', $this->pdf->FontStyle.'U');
					}
				}
				$this->pdf->Write(5, str_replace("#br#", "\n", $tab[0][2]));
    		}	
	    }	
			
	}
	
	public function getFooter(){
		// ***************************************************
		// Numéro de page
		$footer = "";
		$x = $this->LARGEUR_TOTALE_CORPS+$this->MARGE_GAUCHE;
		$y = $this->PIEDS_HAUTEUR_DEPART+ $this->PIEDS_HAUTEUR_MAX;
		$footer .= '$this->SetXY('.$this->MARGE_GAUCHE.','.$y.'-6);';
		$footer .= '$this->SetFont("Arial", "I", 8);';
		$footer .= '$this->Cell('.$this->LARGEUR_TOTALE_CORPS.', 6, "Page ".$this->PageNo()." / {nb}", 0, 0, "R");';
		
		// ***************************************************
		// Ligne
		$footer .= '$this->Line('.$this->MARGE_GAUCHE.', '.$y.', '.$x.', '.$y.');';
		// ***************************************************
		$footer .= '
			$this->SetFont("Arial","I",8);
			$this->SetXY('.$this->MARGE_GAUCHE.', '.$y.'+1);
			$this->Cell (100, 4.5, "'.$this->PIEDS_GAUCHE[0].'", "0", 2, "L");
			$this->Cell (100, 4.5, "'.$this->PIEDS_GAUCHE[1].'", "0", 2, "L");
		
			$this->SetXY('.$this->MARGE_GAUCHE.'+70, '.$y.'+1);
			$this->Cell (100, 4.5, "'.$this->PIEDS_DROIT[0].'", "0", 2, "R");
			$this->Cell (100, 4.5, "'.$this->PIEDS_DROIT[1].'", "0", 2, "R");
			';
		
	return $footer;
	}
	
		/*public function getFooter() {
		// Information société
		$pied_y = $this->PIEDS_HAUTEUR_DEPART+$this->PIEDS_HAUTEUR_MAX;
		$pied = '
			$this->SetFont("Arial","I",8);
			$this->SetXY('.$this->MARGE_GAUCHE.', '.$pied_y.'-5);
			$this->Cell (100, 4.5, "'.$this->PIEDS_GAUCHE[0].'", "0", 2, "L");
			$this->Cell (100, 4.5, "'.$this->PIEDS_GAUCHE[1].'", "0", 2, "L");
		
			$this->SetXY('.$this->MARGE_GAUCHE.'+70, '.$pied_y.'-5);
			$this->Cell (100, 4.5, "'.$this->PIEDS_DROIT[0].'", "0", 2, "R");
			$this->Cell (100, 4.5, "'.$this->PIEDS_DROIT[1].'", "0", 2, "R");		
			';
		
		return $pied;	
		}*/
	
	/**
	 * @return bool
	 */
	public function getFooter2 () {

	// ***************************************************
	// Numéro de page
	$this->SetXY($this->MARGE_GAUCHE, $this->PIEDS_HAUTEUR_DEPART+ $this->PIEDS_HAUTEUR_MAX - 6);
	$this->SetFont('Arial', 'I', 8);
	$page_lib = "Page ".$this->page_actuelle." / ".$this->nb_pages;
	$this->Cell ($this->LARGEUR_TOTALE_CORPS, 6, $page_lib, 0, 0, 'R');
	
	// ***************************************************
	// Ligne
	$this->Line($this->MARGE_GAUCHE, $this->PIEDS_HAUTEUR_DEPART+ $this->PIEDS_HAUTEUR_MAX, $this->LARGEUR_TOTALE_CORPS+$this->MARGE_GAUCHE, $this->PIEDS_HAUTEUR_DEPART+ $this->PIEDS_HAUTEUR_MAX);
	// ***************************************************
	// Informations entreprise
	$this->SetXY($this->MARGE_GAUCHE, $this->PIEDS_HAUTEUR_DEPART + $this->PIEDS_HAUTEUR_MAX + 1);
	$this->SetFont('Arial', 'I', 8);
	foreach ($this->PIEDS_GAUCHE as $texte) {
		$this->Cell ($this->LARGEUR_TOTALE_CORPS, 4.5, $texte, '0', 2, 'L');
	}

	$this->SetXY(0, $this->PIEDS_HAUTEUR_DEPART + $this->PIEDS_HAUTEUR_MAX + 1);
	foreach ($this->PIEDS_DROIT as $texte) {
		$this->Cell ($this->MARGE_GAUCHE + $this->LARGEUR_TOTALE_CORPS, 4.5, $texte, '0', 2, 'R');
	}
	return true;
}


}

?>