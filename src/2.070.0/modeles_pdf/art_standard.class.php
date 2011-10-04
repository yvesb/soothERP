<?php

class pdf_art_standard {
	var $code_pdf_modele = "art_standard";
	var $pdf;
	var $article;
	var $imgs;
	
	public function pdf_art_standard(&$pdf, $article) {
		global $ART_STANDARD;
		global $PDF_MODELES_DIR;
		
		include ($PDF_MODELES_DIR."config/".$this->code_pdf_modele.".config.php");
		
		foreach ($ART_STANDARD as $var => $valeur) {
				$this->{$var} = $valeur;
		}
		$this->pdf = $pdf;
		$this->article = $article;
		$this->imgs = $article->getImagesLocation();
		
	}
	
	public function getHeader(){
	global $IMAGES_DIR;
	global $ARTICLES_MINI_IMAGES_DIR;
		
		$this->garantie = $this->article->getDuree_garantie ();
		if (!isset($this->garantie)) {
			$this->garantie = 'Néant';
		}
		$this->tabcodebarre = $this->article->getCodes_barres () ;
		
		$entete = '
				$this->Image("'.$IMAGES_DIR.$this->CHEMIN_LOGO.'", '.$this->MARGE_GAUCHE.'-10, '.$this->MARGE_HAUT.'-10, 70);
				$this->SetFont("Arial","B",17);
			  $this->SetTextColor('.$this->R_LIB_ARTICLE.','.$this->G_LIB_ARTICLE.','.$this->B_LIB_ARTICLE.');
				$this->SetXY(120,15);
				$this->MultiCell(80,6,"'.addslashes($this->article->getLib_article()).'",0,"L");
				$this->SetTextColor(0,0,0);
				$this->SetXY(120,30);
				$this->SetFont("Arial","B",11);
				$this->Cell(15,15,"Réf. Produit :     '.$this->article->getRef_article ().'",0,1);
				$this->SetXY(120,40);
				$this->SetFont("Arial","B",11);
				$this->Cell(15,15,"Code Fabricant :     '.$this->article->getRef_constructeur ().'",0,1);
				$this->SetXY(120,50);
				$this->SetFont("Arial","B",11);
				$this->Cell(15,15,"Code interne :     '.$this->article->getRef_interne ().'",0,1);
				$this->SetXY('.$this->MARGE_GAUCHE.'+120,60);
				$this->SetFont("Arial","B",11);';
				
				
		if ((is_array($this->tabcodebarre)) && isset ($this->tabcodebarre[0])) {
		
			$entete .= '$this->Code39('.$this->MARGE_GAUCHE.'+120,65, "'.$this->tabcodebarre[0]->code_barre.'", 0.5, 15);
				$this->SetXY('.$this->MARGE_GAUCHE.'+120,75);	$this->Cell(15,15,"'.$this->tabcodebarre[0]->code_barre.'",0,0,"L"); ';
		}
		
				
				
				
				
		if ((is_array($this->imgs)) && isset ($this->imgs[0][0])) {
			
			$entete .= '
				$this->SetXY('.$this->MARGE_IMAGE_GAUCHE.'-5,'.$this->MARGE_IMAGE_HAUT.'-10);
				$this->Cell(70,70,"",1,0);
				$this->Image("'.$ARTICLES_MINI_IMAGES_DIR.$this->imgs[0][0].'",'.$this->MARGE_IMAGE_GAUCHE.','.$this->MARGE_IMAGE_HAUT.'-5,60);
				$this->SetXY('.$this->MARGE_IMAGE_GAUCHE.'-5,'.$this->MARGE_IMAGE_HAUT.'+85);
				$this->SetFont("Arial","B",7);
				$this->Cell(10,10,"* Photo non contractuelle",0,0);';
		}
		
		if (isset ($this->imgs[1][0])) {
			
			$entete .= '	
				$this->SetXY('.$this->MARGE_IMAGE_GAUCHE.'-5,'.$this->MARGE_IMAGE_HAUT.'+65);
				$this->Cell(17.5,17.5,"",1,0);
				$this->Image("'.$ARTICLES_MINI_IMAGES_DIR.$this->imgs[1][0].'",'.$this->MARGE_IMAGE_GAUCHE.'-3,'.$this->MARGE_IMAGE_HAUT.'+67,14);';
		} elseif (isset ($this->imgs[0][0])) {	
			$entete .= '		
				$this->SetXY('.$this->MARGE_IMAGE_GAUCHE.'-5,'.$this->MARGE_IMAGE_HAUT.'+65);
				$this->Cell(17.5,17.5,"",1,0);
				$this->Image("'.$ARTICLES_MINI_IMAGES_DIR.$this->imgs[0][0].'",'.$this->MARGE_IMAGE_GAUCHE.'-3,'.$this->MARGE_IMAGE_HAUT.'+67,14);';
				}
				
		if (isset ($this->imgs[2][0])) {
			$entete .= '			
				$this->SetXY('.$this->MARGE_IMAGE_GAUCHE.'+17.5,'.$this->MARGE_IMAGE_HAUT.'+65);
				$this->Cell(17.5,17.5,"",1,0);
				$this->Image("'.$ARTICLES_MINI_IMAGES_DIR.$this->imgs[2][0].'",'.$this->MARGE_IMAGE_GAUCHE.'+19,'.$this->MARGE_IMAGE_HAUT.'+67,14);';
		} elseif (isset ($this->imgs[0][0])) {
			$entete .= '	
				$this->SetXY('.$this->MARGE_IMAGE_GAUCHE.'+17.5,'.$this->MARGE_IMAGE_HAUT.'+65);
				$this->Cell(17.5,17.5,"",1,0);
				$this->Image("'.$ARTICLES_MINI_IMAGES_DIR.$this->imgs[0][0].'",'.$this->MARGE_IMAGE_GAUCHE.'+19,'.$this->MARGE_IMAGE_HAUT.'+67,14);';
		}
				
				
		$liste_tarifs = $this->article->getTarifs ();
		$prix_u_ht = 0;
		foreach ($liste_tarifs as $tarifs) {
			if ($tarifs->id_tarif == $_SESSION['magasin']->getId_tarif()) {
				$prix_u_ht = $tarifs->pu_ht; break;
			}
		}

		
		$entete .= '$this->SetXY('.$this->MARGE_IMAGE_GAUCHE.'-5,'.$this->MARGE_IMAGE_HAUT.'+105);
				$this->SetTextColor('.$this->R_PRIX.','.$this->G_PRIX.','.$this->B_PRIX.');
				$this->SetFont("Arial","B",24);
				$this->Cell(15,15,"'.price_format($prix_u_ht * (1+($this->article->getTva () / 100))).' € TTC",0,1);
				$this->SetTextColor(0,0,0);
				$this->SetXY('.$this->MARGE_IMAGE_GAUCHE.'-5,'.$this->MARGE_IMAGE_HAUT.'+120);
				$this->SetFont("Arial","B",13);
				$this->Cell(15,15,"Garantie :           '.$this->garantie.' mois",0,1);
				';
				
		return $entete;
	} 
	
	public function getFooter(){
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
	}
	
	public function writePdf(){
		
		$this->pdf->AliasNbPages();
		
		$this->pdf->AddPage();
		$this->pdf->SetFont('Arial','',12);
		$this->pdf->SetXY(10,$this->MARGE_IMAGE_HAUT-10);

		//$this->pdf->Write(5, addslashes($this->article->getDesc_courte())."\n");
		$this->pdf->rMargin = 100;	
		
		$this->html2fpdf($this->article->getDesc_longue(), 0, 'L');
		
	}
	
	 function html2fpdf($html){
	
		$tab = array();
		$history = array();
		$html = strip_tags(htmlspecialchars_decode($html), '<span><br>');
	    $html = str_replace("\r\n", '', $html);
	    $html = str_replace("&nbsp;", " ", $html);
	    $html = str_replace("<br>", "#br#", $html);
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
	
}
?>