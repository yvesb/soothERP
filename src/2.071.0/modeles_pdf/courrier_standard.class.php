<?PHP 

// *************************************************************************************************************
// FONCTIONS PERMETTANT LA GENERATION D'UN COURRIER PDF - MODELE STANDARD
// *************************************************************************************************************
// Ce script est appelé depuis _pdf.class.php->add_courrier_standard()
// $this 			réfère donc à un objet de la classe PDF
// $courrier	réfère au courrier que l'on intègre au PDF

function add_courrier_standard ($pdf, $courrier) {
	global $PDF_MODELES_DIR;

	if (!isset($courrier)) { 
		$erreur = "Aucun document transmit pour la création du PDF";
		alerte_dev ($erreur);
	}
	include_once ($PDF_MODELES_DIR."config/".$courrier->code_pdf_modele.".config.php");
}

class pdf_courrier_standard {
	
	var $code_pdf_modele = "courrier_standard";
	var $courrier;
	var $pdf;

	// format du pdf
	var $FORMAT_PDF;
	var $MOD_PDF;
	var $PDF_LARGEUR_MAX;
	var $PDF_HAUTEUR_MAX;
	var $PDF_LARGEUR_MIDLE;
	var $MARGE_GAUCHE;
	var $MARGE_DROITE;
	var $MARGE_HAUT;
	var $MARGE_BAS;
	//ENTETE
	var $ENTETE_HAUTEUR_DEPART;
	var $ENTETE_HAUTEUR_MAX;
	//COURRIER
	var $COURRIER_HAUTEUR_DEPART;
	var $TETE_HAUTEUR_MAX;
	var $CORPS_HAUTEUR_MAX;
	//COURRIER LABELS
	var $LBL_NOS_REFS;
	var $LBL_VOS_REFS;
	
	//PIED
	var $PIEDS_HAUTEUR_DEPART;
	var $PIEDS_HAUTEUR_MAX;
	// 
	var $emeteur;
	var $destinataire;
	
	// divers
	var $CHEMIN_LOGO;
	var $FONT_SIZES;
	var $COURRIER_W_CELL;

	public function pdf_courrier_standard(&$pdf, $courrier) {
		global $PDF_MODELES_DIR;
		include ($PDF_MODELES_DIR."config/".$this->code_pdf_modele.".config.php");
		$this->courrier = $courrier;
		$this->pdf = $pdf;
		
		// ***************************************************
		// Initialisation des variables
		$this->nb_pages			= 1;
		$this->contenu_actuel 	= 0;					// Ligne du document en cours de traitement
		$this->contenu_end_page = array();		// Lignes de contenu terminant les différentes pages
		$this->page_actuelle	= 0;
		$this->content_printed	= 0;
		
		// ***************************************************
		// Valeurs par défaut
		foreach ($COURRIER_STANDARD as $var => $valeur) {
			$this->{$var} = $valeur;
		}
		
		$this->setConfigValues();
	}
	
	/**
	 * Configure les valeurs de la page PDF a afficher
	 * @return bool
	 */
	private function setConfigValues(){
		global $IMAGES_DIR;
		
		
		// format du pdf
		$this->PDF_LARGEUR_MAX 	= $this->FORMAT_PDF[0]-$this->MARGE_GAUCHE - $this->MARGE_DROITE;
		$this->PDF_HAUTEUR_MAX 	= $this->FORMAT_PDF[1]-$this->MARGE_HAUT -$this->MARGE_BAS;
		$this->PDF_LARGEUR_MIDLE = $this->FORMAT_PDF[0] /2;
		
		$this->emeteur 		= $this->courrier->getExpediteur ();
		
		if(is_subclass_of($this->courrier, "CourrierEtendu")){
			$destinataires = $this->courrier->getDestinataires ();
			$this->destinataire = $destinataires[0];
		}
		
		// divers
		$this->CHEMIN_LOGO  = $IMAGES_DIR.$this->IMG_LOGO;
		$this->TAILLE_MAX_LOGO	= $this->PDF_LARGEUR_MAX * 0.2;
		$size = $this->getSize($this->CHEMIN_LOGO);
		$this->LOGO_W_SIZE = $size[0];
		$this->LOGO_H_SIZE = $size[1];
		$this->COURRIER_W_CELL = 5;
		
		//ENTETE
		$this->ENTETE_HAUTEUR_DEPART = $this->MARGE_HAUT + $this->LOGO_H_SIZE;
		$this->ENTETE_HAUTEUR_MAX = $this->ENTETE_HAUTEUR_DEPART + ($this->COURRIER_W_CELL *5);
		
		// texte
		$this->FONT_SIZES = Array(8,10,12,14,17);
		
		// courrier
		$this->COURRIER_HAUTEUR_DEPART = $this->ENTETE_HAUTEUR_MAX + $this->COURRIER_W_CELL ;
		$this->COURRIER_HAUTEUR_MAX = $this->COURRIER_HAUTEUR_DEPART + 90 ;
		/*
		//PIED
		$this->PIEDS_HAUTEUR_DEPART = $this->COURRIER_HAUTEUR_MAX + $this->COURRIER_HAUTEUR_MAX;
		$this->PIEDS_HAUTEUR_MAX = 20;
		*/
		return true;
	}
	
	/**
	 * @param $img
	 * @return tableau 'w / h' de l'image a afficher dans le PDF
	 */
	private function getSize($img){
		$size = getimagesize($img);
		while ( ($size[0] >= $this->TAILLE_MAX_LOGO) ){
			$size[0]=$size[0]*0.95;
			$size[1]=$size[1]*0.95;
		}
		return $size;
	}
	
	public function createPdfHeader() {
		// ***************************************************
		// LOGO
		$this->pdf->Image($this->CHEMIN_LOGO, $this->MARGE_GAUCHE, $this->MARGE_HAUT, $this->LOGO_W_SIZE);
		//DEPART
		//ligne 1
		// EMETEUR
		// NOM+ADRESSE
		$y = $this->ENTETE_HAUTEUR_DEPART;
		$this->pdf->SetFont('Arial', '', $this->FONT_SIZES[0]);
		$this->pdf->SetXY($this->MARGE_GAUCHE, $y);
		if(is_subclass_of($this->courrier, "CourrierEtendu")){
			$emeteur_ref_user = $this->emeteur->getRef_user ();
			$emeteur_ref_coord_user = $this->emeteur->getRef_coord_user ();
		}else{
			$emeteur_ref_user = "";
			$emeteur_ref_coord_user = "";
		}
		$this->pdf->Cell ('', $this->COURRIER_W_CELL, $emeteur_ref_user, 0, 2);
		$this->incY( $y );
		$this->pdf->Cell ('', $this->COURRIER_W_CELL, $emeteur_ref_coord_user, 0, 2);
		$this->incY( $y );
		//ligne 2
		// ***************************************************
		// Date du document
		$this->pdf->SetXY($this->PDF_LARGEUR_MIDLE, $y );
		$this->pdf->Cell ('', $this->COURRIER_W_CELL, date_Us_to_Fr($this->courrier->getDate_courrier ()));
		$this->incY( $y );
	} 
	
	
	
	public function createPdfCourrier_tete () {
		$y = $this->COURRIER_HAUTEUR_DEPART;
		// TYPE COURRIER
		$this->pdf->SetFont('Arial', 'B', $this->FONT_SIZES[1]);
		$this->pdf->SetXY($this->MARGE_GAUCHE, $y);
		$this->pdf->Cell ('', $this->COURRIER_W_CELL, $this->courrier->getLib_type_courrier (), 0, 0);
		$this->incY( $y );
		// REFS
		
		$this->pdf->SetXY($this->MARGE_GAUCHE, $y);
		$this->pdf->SetFont('Arial', 'B', $this->FONT_SIZES[0]);
		$this->pdf->Cell (12, $this->COURRIER_W_CELL,$this->LBL_NOS_REFS[0], 0, 0);
		$this->pdf->SetFont('Arial', '', $this->FONT_SIZES[0]);
		
		if(is_subclass_of($this->courrier, "CourrierEtendu")){
			$destinataire_ref_contact = $this->destinataire->getRef_contact ();
			$courrier_id_courrier = $this->courrier->getId_courrier ();
		}else{
			$destinataire_ref_contact = "";
			$courrier_id_courrier = "";
		}
		$this->pdf->Cell (60, $this->COURRIER_W_CELL,$this->LBL_NOS_REFS[1].
			$destinataire_ref_contact.
			$this->LBL_NOS_REFS[2].
			$courrier_id_courrier
			, 0, 0);
		
		/*$this->pdf->SetXY($this->PDF_LARGEUR_MIDLE, $y);
		$this->pdf->SetFont('Arial', 'B', $this->FONT_SIZES[0]);
		$this->pdf->Cell (10, $this->COURRIER_W_CELL,$this->LBL_VOS_REFS[0], 0, 0);*/
		$this->incY( $y );
		$this->pdf->SetXY($this->MARGE_GAUCHE, $y);
		$this->pdf->SetFont('Arial', 'B', $this->FONT_SIZES[0]);
		$this->pdf->Cell (12, $this->COURRIER_W_CELL,$this->LBL_OBJET);
		$this->pdf->SetFont('Arial', '', $this->FONT_SIZES[0]);
		$this->pdf->Cell (60, $this->COURRIER_W_CELL,$this->courrier->getObjet ());
		$this->incY( $y );
		$this->TETE_HAUTEUR_MAX = $y;
		
	}
	
	public function createPdfCourrier_corps () {
		$y = $this->TETE_HAUTEUR_MAX;
		$this->incY( $y );
		$this->pdf->SetXY($this->MARGE_GAUCHE, $y);
		$this->pdf->SetFont('Arial', '', $this->FONT_SIZES[0]);
		$this->html2fpdf($this->courrier->getContenu ());
	}
	
	public function createPdfFooter() {
		$this->pdf->SetFont('Arial', '', $this->FONT_SIZES[0]);
		// LIGNE DE PIED DE PAGE
		$this->pdf->SetXY(0, $this->PIEDS_HAUTEUR_DEPART );
		$this->pdf->Line (0, $this->PIEDS_HAUTEUR_DEPART + $this->PIEDS_HAUTEUR_MAX , $this->FORMAT_PDF[0], $this->PIEDS_HAUTEUR_DEPART + $this->PIEDS_HAUTEUR_MAX  );
		//pied de la page
		$this->pdf->SetXY($this->MARGE_GAUCHE, $this->PIEDS_HAUTEUR_DEPART + $this->PIEDS_HAUTEUR_MAX + 1);
		foreach ($this->PIEDS as $texte) {
			$this->pdf->Cell ('', 4.5, $texte, '0', 2, 'C');
		}
	}

	public function writePdf() {	
		// exec
		$this->pdf->AliasNbPages();
		$this->pdf->AddPage($this->ORIENTATION_PDF,$this->FORMAT_PDF);
		$this->pdf->SetXY(0,0);
		$this->pdf->rMargin = $this->MARGE_DROITE;
		$this->pdf->SetLeftMargin($this->MARGE_GAUCHE);
		$this->createPdfHeader();
		$this->createPdfCourrier_tete ();
		$this->createPdfCourrier_corps ();
		$this->createPdfFooter();
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
	
	private function incY( &$y ){
		$y = $y + $this->COURRIER_W_CELL;
	}
}

?>