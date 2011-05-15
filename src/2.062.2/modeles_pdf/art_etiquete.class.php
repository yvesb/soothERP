<?php
// *************************************************************************************************************
// CLASSE DE GENERATION D'UN DOCUMENT PDF - ARTICLE MODELE MODIFIE POUR ARTIREC
// *************************************************************************************************************

require_once($PDF_MODELES_DIR."art_standard.class.php");

/**
 * @author Administrateur
 *
 */
class pdf_art_etiquete extends pdf_art_standard {
	var $code_pdf_modele = "art_etiquete";

	// format du pdf
	var $FORMAT_PDF;
	var $actual_format;
	var $MOD_PDF;
	var $PDF_LARGEUR_MAX;
	var $PDF_HAUTEUR_MAX;
	var $MARGE_GAUCHE;
	var $MARGE_DROITE;
	var $MARGE_HAUT;
	var $MARGE_BAS;

	// orientation
	var $ORIENTATION_PDF;

	// logo
	var $TAILLE_MAX_LOGO;
	var $LOGO_H_SIZE;
	var $LOGO_W_SIZE;

	// article
	var $ARTICLE_X_LIB;
	var $ARTICLE_Y_LIB;
	var $ARTICLE_W_LIB;
	var $ARTICLE_H_DESC;
	var $ARTICLE_X_DESC;
	var $ARTICLE_Y_DESC;
	var $ARTICLE_H_PRIX;
	var $ARTICLE_X_PRIX;
	var $ARTICLE_Y_PRIX;
	var $ARTICLE_W_PRIX;
	var $ARTICLE_H_TVA;
	var $ARTICLE_X_TVA_1;
	var $ARTICLE_Y_TVA_1;
	var $ARTICLE_X_TVA_2;
	var $ARTICLE_Y_TVA_2;
	var $ARTICLE_H_BARCODE_BOX;
	var $ARTICLE_X_BARCODE_BOX;
	var $ARTICLE_Y_BARCODE_BOX;
	var $ARTICLE_H_BARCODE;
	var $ARTICLE_T_BARCODE;
	var $ARTICLE_X_BARCODE;
	var $ARTICLE_Y_BARCODE;
	var $ARTICLE_X_BARCODE_ALPHA;
	var $ARTICLE_Y_BARCODE_ALPHA;
	var $ARTICLE_DESC_FORMAT;
		
	// divers
	var $FONT_SIZES;
	var $TAUX_TVA;


	/**
	 * Configure les valeurs de la page PDF a afficher
	 * @return bool
	 */
	private function setConfigValues(){
		global $IMAGES_DIR;
		// pdf
		if( ($this->MOD_PDF != 0) && ($this->MOD_PDF != 2) ) {
			$this->MOD_PDF = 2;
		}
		$i = 0 + $this->MOD_PDF;
		$this->actual_format[0] = $this->FORMAT_PDF[$i];
		$this->PDF_HAUTEUR_MAX = $this->FORMAT_PDF[$i]-$this->MARGE_HAUT - $this->MARGE_BAS;
		$i++;
		$this->actual_format[1] = $this->FORMAT_PDF[$i];
		$this->PDF_LARGEUR_MAX = $this->FORMAT_PDF[$i]-$this->MARGE_GAUCHE -$this->MARGE_DROITE;
		// logo
		$img = $IMAGES_DIR.$this->CHEMIN_LOGO;
		$this->TAILLE_MAX_LOGO	= $this->PDF_LARGEUR_MAX * 0.3;
		$size = $this->getSize($img);
		$this->LOGO_W_SIZE = $size[0];
		$this->LOGO_H_SIZE = $size[1];
		// texte
		if($this->MOD_PDF == 2){
			$this->FONT_SIZES = Array(8,10,12,14,17);
		}else{
			$this->FONT_SIZES = Array(2,4,5,6,8);
		}
		// article
		$this->ARTICLE_X_LIB = $this->LOGO_W_SIZE+1;
		$this->ARTICLE_Y_LIB = $this->MARGE_HAUT;
		$this->ARTICLE_W_LIB = $this->LOGO_H_SIZE;
		$this->ARTICLE_H_DESC = $this->PDF_HAUTEUR_MAX * 0.25;
		$this->ARTICLE_X_DESC = $this->MARGE_GAUCHE;
		$this->ARTICLE_Y_DESC = $this->ARTICLE_W_LIB + $this->MOD_PDF +2;
		$this->ARTICLE_H_PRIX = $this->PDF_HAUTEUR_MAX * 0.15;
		$this->ARTICLE_X_PRIX = $this->MARGE_GAUCHE;
		$this->ARTICLE_Y_PRIX = $this->PDF_HAUTEUR_MAX - $this->ARTICLE_H_PRIX;
		$this->ARTICLE_W_PRIX[0] = $this->PDF_LARGEUR_MAX * 0.35;
		$this->ARTICLE_W_PRIX[1] = $this->PDF_LARGEUR_MAX * 0.28;
		$this->ARTICLE_W_PRIX[2] = $this->PDF_LARGEUR_MAX * 0.37;
		$this->ARTICLE_H_TVA = $this->ARTICLE_H_PRIX * 0.5;
		$this->ARTICLE_X_TVA_1 = $this->ARTICLE_X_PRIX + $this->ARTICLE_W_PRIX[0];
		$this->ARTICLE_Y_TVA_1 = $this->ARTICLE_Y_PRIX + $this->MOD_PDF;
		$this->ARTICLE_X_TVA_2 = $this->ARTICLE_X_PRIX + $this->ARTICLE_W_PRIX[0];
		$this->ARTICLE_Y_TVA_2 = $this->ARTICLE_Y_PRIX + $this->ARTICLE_H_TVA - $this->MOD_PDF;
		$this->ARTICLE_H_BARCODE_BOX = $this->ARTICLE_H_TVA;
		$this->ARTICLE_X_BARCODE_BOX = $this->ARTICLE_X_TVA_1 + $this->ARTICLE_W_PRIX[1];
		$this->ARTICLE_Y_BARCODE_BOX = $this->ARTICLE_Y_PRIX;
		$this->ARTICLE_H_BARCODE = $this->ARTICLE_H_TVA;
		$this->ARTICLE_X_BARCODE = $this->ARTICLE_X_BARCODE_BOX;
		$this->ARTICLE_Y_BARCODE = $this->ARTICLE_Y_BARCODE_BOX+1;
		$this->ARTICLE_T_BARCODE = 0.6;
		$this->ARTICLE_X_BARCODE_ALPHA = $this->ARTICLE_X_BARCODE_BOX;
		$this->ARTICLE_Y_BARCODE_ALPHA = $this->ARTICLE_Y_BARCODE + $this->ARTICLE_H_BARCODE;	
		// tva
		$this->TAUX_TVA[0] = 0;
		$this->TAUX_TVA[1] = 5.5;
		$this->TAUX_TVA[2] = 19.6;

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

	/**
	 * 0=DESC_CHAR_MAX, 1=Total char de la description, 2=Description coupé à DESC_CHAR_MAX
	 * @param $desc
	 * @param $tab
	 * @return bool
	 */
	private function getDescFormated($desc,&$tab){
		if( isset($desc) && strlen($desc) > 0){
			$tab[0] = strlen($desc); //nb de char de la description
			$tab[1] = $this->pdf->GetStringWidth($desc); //taille du texte en Mm
			$tab[2] = substr_count ($desc,"<br>"); //Nb de retours a la ligne
			$tab[3] = $this->pdf->GetStringWidth('_'); //taille du _ en Mm
			$tab[4] = floor( $this->ARTICLE_H_DESC / $tab[3]);
			$max_ln = $tab[4]-1;//nb de lignes affiché maximum
			$char_max_ln = floor( $this->PDF_LARGEUR_MAX / $tab[3]) ; //nombre de charactere affiché max par lignes
			
			$exploded_desc = explode("<br>",$desc);
			$desc_char_tt = strlen($desc);
			$desc_nb_ln_tt = count($exploded_desc);
			$formated_max_char = 0; $ln=0; $i=0;
			$ln_count_char = Array();
			while ( ($ln < $max_ln) && ($i < $desc_nb_ln_tt) ){
				$end_ln = strlen ($exploded_desc[$i]);
				$ln_count_char[] = $formated_max_char;
				while ( ( $end_ln >= $char_max_ln ) && ( $ln < $max_ln)) {
					$formated_max_char += $char_max_ln;
					$sub_desc = substr ($exploded_desc[$i], $char_max_ln, $end_ln);
					$end_ln = strlen ($sub_desc);
					$ln_count_char[] = $formated_max_char;
					$ln++;
				}
				$ln++; $i++; $formated_max_char += $end_ln;
				
			}
			
			if ( $tab[2] > $max_ln ) {
				$tab[10] = substr  ( $desc  , 0  , $formated_max_char-5 ). '[...]'; //coupe la descrition sur la taille max
			}else{
				$tab[10] = $desc;
			}

			//dev 	v0.02
			//var_dump ($ln_count_char);//affichage dans le pdf
			return true;
		} else {
			return false;
		}
	}
	
	public function html2fpdf($html,$maxligne){
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
	
	/* (non-PHPdoc)
	 * @see modeles_pdf/pdf_art_standard#writePdf()
	 */
	public function writePdf(){
		// configure la page PDF
		$this->setConfigValues();
		// exec
		$this->pdf->AliasNbPages();
		$this->pdf->AddPage($this->ORIENTATION_PDF,$this->actual_format);
		$this->pdf->SetXY($this->ARTICLE_X_DESC,$this->ARTICLE_Y_DESC);
		$this->pdf->rMargin = $this->MARGE_DROITE;
		$this->pdf->SetLeftMargin($this->MARGE_GAUCHE);
		$this->pdf->SetFont('Arial','',$this->FONT_SIZES[3]);
		if( $this->getDescFormated($this->article->getDesc_longue(),$this->ARTICLE_DESC_FORMAT ) ){
			$this->pdf->SetFont('Arial','',$this->FONT_SIZES[2]);
			$this->html2fpdf($this->ARTICLE_DESC_FORMAT[10],10);
		} else {
			$this->pdf->SetFont('Arial','',$this->FONT_SIZES[3]);
			$this->pdf->Write($this->ARTICLE_H_DESC, addslashes($this->article->getDesc_courte())."\n");
		}
	}

	/* (non-PHPdoc)
	 * @see modeles_pdf/pdf_art_standard#getHeader()
	 */
	public function getHeader(){
		global $bdd;
		global $IMAGES_DIR;
		$entete = '
				$this->Image("'.$IMAGES_DIR.$this->CHEMIN_LOGO.'", '.$this->MARGE_GAUCHE.', '.$this->MARGE_HAUT.', '.$this->LOGO_W_SIZE.');
				$this->SetFont("Arial","B",'.$this->FONT_SIZES[4].');
			    $this->SetTextColor('.$this->R_LIB_ARTICLE.','.$this->G_LIB_ARTICLE.','.$this->B_LIB_ARTICLE.');
			 	$this->SetXY('.$this->ARTICLE_X_LIB.','.$this->ARTICLE_Y_LIB.');
				$this->MultiCell('.$this->PDF_LARGEUR_MAX.'-'.$this->LOGO_W_SIZE.','
				.$this->ARTICLE_W_LIB.',"'
				.addslashes($this->article->getLib_article()).'",1,"L");
				';	

				$liste_tarifs = $this->article->getTarifs ();
				$prix_u_ht = 0;
				foreach ($liste_tarifs as $tarifs) {
					if ($tarifs->id_tarif == $_SESSION['magasin']->getId_tarif()) {
						$prix_u_ht = $tarifs->pu_ht;
					}
				}
				$query = "SELECT	av.abrev_valo
							FROM articles_valorisations av
							WHERE av.id_valo = '".$this->article->getId_valo()."' ";
				$resultat = $bdd->query ($query);
				if (!$valo = $resultat->fetchObject()) { return false; }
				// formatage strings pied
				$string_ht = " Prix: ".$prix_u_ht;
				$string_valo = "(/".$valo->abrev_valo.")";
				$string_tva_1 = price_format($prix_u_ht * (1+($this->TAUX_TVA[1] / 100)))." € TTC (TVA:".strval($this->TAUX_TVA[1])."%)";
				$string_tva_2 = price_format($prix_u_ht * (1+($this->TAUX_TVA[2] / 100)))." € TTC (TVA:".strval($this->TAUX_TVA[2])."%)";
				
				$entete .= '$this->SetXY('.$this->ARTICLE_X_PRIX.','.$this->ARTICLE_Y_PRIX.');
							$this->SetTextColor('.$this->R_PRIX.','.$this->G_PRIX.','.$this->B_PRIX.');
							$this->SetFont("Arial","B",'.$this->FONT_SIZES[3].');
							$this->Cell('.$this->ARTICLE_W_PRIX[0].','.$this->ARTICLE_H_PRIX.',"'.$string_ht."€ HT ".$string_valo.'","LBT",0);
							$this->SetFont("Arial","",'.$this->FONT_SIZES[1].');
							$this->Cell('.$this->ARTICLE_W_PRIX[1].','.$this->ARTICLE_H_PRIX.',"","BT",0,"C");
							$this->SetFont("Arial","",'.$this->FONT_SIZES[0].');
							$this->SetXY('.$this->ARTICLE_X_TVA_1.','.$this->ARTICLE_Y_TVA_1.');
							$this->Write('.$this->ARTICLE_H_TVA.',"'.$string_tva_1.'");
							$this->SetXY('.$this->ARTICLE_X_TVA_2.','.$this->ARTICLE_Y_TVA_2.');
							$this->Write('.$this->ARTICLE_H_TVA.',"'.$string_tva_2.'");
				';

				$string_barcode = 	'
									$this->Code39('.$this->ARTICLE_X_BARCODE.','.$this->ARTICLE_Y_BARCODE.
									', "'.$this->article->getRef_article ().'", '.$this->ARTICLE_T_BARCODE.', '.$this->ARTICLE_H_BARCODE.');
									$this->SetXY('.$this->ARTICLE_X_BARCODE_ALPHA.','.$this->ARTICLE_Y_BARCODE_ALPHA.');
									$this->Cell('.$this->ARTICLE_W_PRIX[2].','.$this->ARTICLE_H_BARCODE.',"'.$this->article->getRef_article ().'",0,0,"L"); 
									';
				$string_barcode .= 	'
								$this->SetXY('.$this->ARTICLE_X_BARCODE_BOX.','.$this->ARTICLE_Y_BARCODE_BOX.');
								$this->Cell('.$this->ARTICLE_W_PRIX[2].','.$this->ARTICLE_H_PRIX.',"","BTR",0,"C"); 
								';
				$entete .= $string_barcode;
				
				return $entete;
	}

	/* (non-PHPdoc)
	 * @see modeles_pdf/pdf_art_standard#getFooter()
	 */
	public function getFooter(){
		/*
		 global $IMAGES_DIR;
		 // Information société
		 $pied = '
			$this->SetFont("Arial","I",8);
			$this->SetXY('.$this->MARGE_GAUCHE.', '.$this->MARGE_PIED_HAUTEUR.'-5);
			$this->Cell (100, 4.5, "'.$this->PIEDS_GAUCHE[0].'", "0", 2, "L");
			$this->Cell (100, 4.5, "'.$this->PIEDS_GAUCHE[1].'", "0", 2, "L");

			$this->SetXY('.$this->MARGE_GAUCHE.'+70, '.$this->MARGE_PIED_HAUTEUR.'-5);
			$this->Cell (100, 4.5, "'.$this->PIEDS_DROIT[0].'", "0", 2, "R");
			$this->Cell (100, 4.5, "'.$this->PIEDS_DROIT[1].'", "0", 2, "R");
			';

			return $pied;
			*/
		return NULL;
	}
}
?>