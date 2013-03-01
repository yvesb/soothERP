<?php

class pdf_commande_client extends PDF_etendu {
	var $code_pdf_modele = "commande_client";
	var $pdf;
	
	var $fiches;
	var $details_art;
	var $lib_type_printed;
	var $i;
	
	var $nb_pages;


	var $HAUTEUR_LINE_ARTICLE;
	var $LARGEUR_TOTALE_CORPS;

	var $MARGE_GAUCHE;
	var $MARGE_HAUT;
	
	public function create_pdf ($infos, $fiches,$details_art) {
	global $PDF_MODELES_DIR;
	global $COMMISSIONS;
	global $MONNAIE;
	
	$this->fiches				= $fiches;
	$this->details_art			= $details_art;
	$this->lib_type_printed 	= $infos["lib_type_printed"];
	$this->i = 0;
	
	
	include_once ($PDF_MODELES_DIR."config/".$this->code_pdf_modele.".config.php");

	// ***************************************************
	// Initialisation de l'objet PDF
	parent::__construct();

	// ***************************************************
	// Initialisation des variables
	$this->nb_pages					= 1;


	// ***************************************************
	// Valeurs par défaut
	foreach ($COMMISSIONS as $var => $valeur) {
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
	$this->AliasNbPages();
	$this->SetXY($this->MARGE_GAUCHE, $this->MARGE_HAUT);
	$this->Cell (0, 3, "page : ".$this->PageNo().'/{nb}', 0, 0, 'R');
	// ***************************************************
	// TITRE
	$this->SetXY($this->MARGE_GAUCHE, $this->MARGE_HAUT+5);
	$this->SetFont('Arial', 'B', 20);
	$this->Cell ($this->LARGEUR_TOTALE_CORPS,0, $this->lib_type_printed, 0, 0, 'C');



	
	$this->y +=5;
	return true;
}


// Créé le corps du PDF
protected function create_pdf_corps () {
	global $MONNAIE;
	global $TARIFS_NB_DECIMALES;



	$this->SetFont('Arial', '', 9);
	//définition du contenu
	
		$this->x = $this->MARGE_GAUCHE ;	
		$this->y +=5;

		
			$this->SetFont('Arial', 'B', 9);
			$this->Cell (20, 3, "Date", 0, 0, 'L');
			$this->Cell (50, 3, "Document", 0, 0, 'L');
			$this->Cell (70, 3, "Client", 0, 0, 'L');
			if (empty($fiche->date_livraison))
                        $this->Cell (20, 3, "", 0, 0, 'L');
                        else $this->Cell (20, 3, "A livrer le", 0, 0, 'L');
			$this->Cell (30, 3, "Montant TTC", 0, 0, 'R');
			
			//liste des documents
			foreach ($this->fiches as $fiche) {
			
				$this->x = $this->MARGE_GAUCHE ;		
				$this->y +=5;
				$this->SetFont('Arial', '', 9);
				
				$this->Cell (20, 3, date_Us_to_Fr(substr($fiche->date_doc,0,10)), 0, 0, 'L');
				$this->Cell (30, 3, $fiche->ref_doc, 0, 0, 'L');
				$this->Cell (1, 3, "(", 0, 0, 'L');
				if($fiche->lib_etat_doc=='En saisie')
				$this->SetTextColor(255,0,0);
				else $this->SetTextColor(0);
				if ($fiche->lib_etat_doc=='Prêt au départ')
                                $this->Cell (20, 3, $fiche->lib_etat_doc, 0, 0, 'L');
                                else $this->Cell (13, 3, $fiche->lib_etat_doc, 0, 0, 'L');
				$this->SetTextColor(0);
				$this->Cell (6, 3, ")", 0, 0, 'L');
				if ($fiche->lib_etat_doc=='Prêt au départ')
                                $this->Cell (63, 3, substr($fiche->nom_contact,0,45), 0, 0, 'L');
                                else $this->Cell (70, 3, substr($fiche->nom_contact,0,45), 0, 0, 'L');

				if (empty($fiche->date_livraison)){
                                $this->Cell (20, 3, '', 0, 0, 'L');
                                }else $this->Cell (20, 3, $fiche->date_livraison!='0000-00-00' ? date_Us_to_Fr($fiche->date_livraison):'', 0, 0, 'L');
                                
				$this->Cell (30, 3, number_format($fiche->montant_ttc, $TARIFS_NB_DECIMALES, ".", "" )." ".$MONNAIE[0], 0, 0, 'R');
						
			$this->x = $this->MARGE_GAUCHE ;		
			$this->y +=2;
			$this->Cell ($this->LARGEUR_TOTALE_CORPS, 3, "", "B", 0, 'C');
			
			$this->x = $this->MARGE_GAUCHE ;
			$this->y +=5;
			$this->SetFont('Arial', 'B', 6);
			$this->Cell (20, 3, "Réf article", 0, 0, 'L');
			$this->Cell (40, 3, "Libellé", 0, 0, 'L');
			$this->Cell (15, 3, "Commandé", 0, 0, 'R');
			$this->Cell (15, 3, "Livré", 0, 0, 'R');
			$this->Cell (20, 3, "Reliquat", 0, 0, 'R');
			$this->Cell (20, 3, "PU HT", 0, 0, 'R');	
			$this->Cell (20, 3, "PU TTC", 0, 0, 'R');
			$this->Cell (20, 3, "Rem.", 0, 0, 'R');
			$this->Cell (20, 3, "Prix total ", 0, 0, 'R');		
		
			$tab=array();
			//liste des articles par documents
			foreach($this->details_art as $article)
			{
			if($article->ref_doc == $fiche->ref_doc && $article->pu_ttc!=0){
				$tab[]=$article->ref_doc;
				$this->x = $this->MARGE_GAUCHE ;		
				$this->y +=5;
				$this->SetFont('Arial', '', 6);
				
				$this->Cell (20, 3, $article->ref_article, 0, 0, 'L');
				$this->Cell (40, 3, $article->lib_article, 0, 0, 'L');
				$this->Cell (15, 3, $article->qte, 0, 0, 'R');
				$this->Cell (15, 3, $article->qte_livree ? $article->qte_livree:'0', 0, 0, 'R');
				$this->Cell (20, 3, $article->qte-$article->qte_livree, 0, 0, 'R');
				$this->Cell (20, 3, $article->pu_ht?number_format($article->pu_ht, $TARIFS_NB_DECIMALES, ".", "" )." ".$MONNAIE[0]:'0.00'." ".$MONNAIE[0], 0, 0, 'R');
				$this->Cell (20, 3, number_format($article->pu_ttc, $TARIFS_NB_DECIMALES, ".", "" )." ".$MONNAIE[0], 0, 0, 'R');
				$this->Cell (20, 3, number_format($article->remise, $TARIFS_NB_DECIMALES, ".", "" )." ".$MONNAIE[0], 0, 0, 'R');
				$this->Cell (20, 3, number_format($article->pu_ttc*$article->qte, $TARIFS_NB_DECIMALES, ".", "" )." ".$MONNAIE[0], 0, 0, 'R');
				}
			}
				
				if(!in_array($fiche->ref_doc,$tab)){
				$this->x = $this->MARGE_GAUCHE ;		
				$this->y +=5;
				$this->SetFont('Arial', 'i', 6);
				
				$this->Cell (20, 3, 'Cette commande est vierge de contenu.', 0, 0, 'L');

				}
			
			$this->x = $this->MARGE_GAUCHE ;		
			$this->y +=6;
			$this->Cell ($this->LARGEUR_TOTALE_CORPS, 3, "", "B", 0, 'C');
	
			$this->x = $this->MARGE_GAUCHE ;		
			$this->y +=5;
		}
	
	return true;
	}

}

?>
