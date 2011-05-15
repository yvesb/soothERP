<?php

class pdf_list_contact_70x37_sans_bord {
	var $code_pdf_modele = "list_contact_70x37_sans_bord";
	var $pdf;
	var $contact;
	
	public function pdf_list_contact_70x37_sans_bord(&$pdf) {
		global $ANN_STANDARD;
		global $PDF_MODELES_DIR;
		
		include ($PDF_MODELES_DIR."config/".$this->code_pdf_modele.".config.php");
		
		foreach ($ANN_STANDARD as $var => $valeur) {
				$this->{$var} = $valeur;
		}
		
		$this->pdf = $pdf;
		
		
	}
	
	public function getHeader() {return '';	} 
	
	public function getFooter() {return '';	}
	
	public function writePdf() {
		global $bdd;
		$this->pdf->setMargins($this->MARGE_GAUCHE, $this->MARGE_HAUT);
		$this->pdf->SetFont($this->FONT,$this->STYLE, $this->TAILLE);
		
				// *************************************************************************************************************
			// TRAITEMENTS
			// *************************************************************************************************************
			
			$ANNUAIRE_CATEGORIES	=	get_categories();
			// *************************************************
			// Profils à afficher
			$profils = array();
			foreach ($_SESSION['profils'] as $profil) {
				if ($profil->getActif() == 0) { continue; }
				$profils[] = $profil;
			}
			unset ($profil);
			
			
			// *************************************************
			// Données pour le formulaire et la recherche
			
			$nb_fiches = 0;
			$form['orderby'] = $search['orderby'] = "nom";
			if (isset($_REQUEST['orderby'])) {
				$form['orderby'] = $_REQUEST['orderby'];
				$search['orderby'] = $_REQUEST['orderby'];
			}
			$form['orderorder'] = $search['orderorder'] = "DESC";
			if (isset($_REQUEST['orderorder'])) {
				$form['orderorder'] = $_REQUEST['orderorder'];
				$search['orderorder'] = $_REQUEST['orderorder'];
			}
			
			$form['nom'] = "";
			if (isset($_REQUEST['nom'])) {
				$form['nom'] = trim(urldecode($_REQUEST['nom']));
				$search['nom'] = trim(urldecode($_REQUEST['nom']));
			}
			
			$form['id_categorie'] = "";
			if (isset($_REQUEST['id_categorie']) && $_REQUEST['id_categorie']) {
				$form['id_categorie'] = trim(urldecode($_REQUEST['id_categorie']));
				$search['id_categorie'] = trim(urldecode($_REQUEST['id_categorie']));
			}
			
			$form['id_profil'] = 0;
			$form['id_client_categ'] = "";
			$form['type_client'] = "";
			if (isset($_REQUEST['id_profil'])) {
				$form['id_profil'] = $_REQUEST['id_profil'];
				$search['id_profil'] = $_REQUEST['id_profil'];
				
				/*if ($CLIENT_ID_PROFIL == $_REQUEST['id_profil']) {
				
					if (isset($_REQUEST['id_client_categ'])) {
						$form['id_client_categ'] = $_REQUEST['id_client_categ'];
						$search['id_client_categ'] = $_REQUEST['id_client_categ'];
					}
					if (isset($_REQUEST['type_client'])) {
						$form['type_client'] = $_REQUEST['type_client'];
						$search['type_client'] = $_REQUEST['type_client'];
					}
					
				}*/
			}
			
			
			$form['code_postal'] = "";
			if (isset($_REQUEST['code_postal'])) {
				$form['code_postal'] = urldecode($_REQUEST['code_postal']);
				$search['code_postal'] = urldecode($_REQUEST['code_postal']);
			}
			$form['ville'] = 0;
			if (isset($_REQUEST['ville'])) {
				$form['ville'] = urldecode($_REQUEST['ville']);
				$search['ville'] = urldecode($_REQUEST['ville']);
			}
			$form['tel'] = "";
			if (isset($_REQUEST['tel'])) {
				$form['tel'] = urldecode($_REQUEST['tel']);
				$search['tel'] = urldecode($_REQUEST['tel']);
			}
			$form['email'] = "";
			if (isset($_REQUEST['email'])) {
				$form['email'] = urldecode($_REQUEST['email']);
				$search['email'] = urldecode($_REQUEST['email']);
			}
			$form['url'] = "";
			if (isset($_REQUEST['url'])) {
				$form['url'] = urldecode($_REQUEST['url']);
				$search['url'] = urldecode($_REQUEST['url']);
			}
			
			// Recherche dans les archives && $_REQUEST['archive']
			$form['archive'] = $search['archive'] = false;
			if (isset($_REQUEST['archive'])) {
				$form['archive'] = true;
				$search['archive'] = true;
			}
			
			
			// *************************************************
			// Résultat de la recherche
			$fiches = array();
			if (isset($_REQUEST['recherche'])) {
				// Préparation de la requete
				$query_select 	= "";
				$query_join 	= "";
				$query_join_count 	= "";
				$query_where 	= "";
				//$query_limit	= (($search['page_to_show']-1)*$search['fiches_par_page']).", ".$search['fiches_par_page'];
			
				// Nom
				if ($search['nom']) {
					$libs = explode (" ", $search['nom']);
					$query_where 	.= " ( ";
					for ($i=0; $i<count($libs); $i++) {
						$lib = trim($libs[$i]);
						$query_where 	.= " nom LIKE '%".addslashes($lib)."%' "; 
						if ( isset($libs[$i+1]) ) { $query_where 	.= " && "; }
					}
					$query_where 	.= " ) ";
				}
				//id_categorie
				if (isset($search['id_categorie'])) {
					if ($query_where) { $query_where .= " && "; }
					$query_where	.= "id_categorie = '".addslashes($search['id_categorie'])."'";
				}
				// Profils
				if ($search['id_profil']) { 
					if($search['id_profil'] != 'ALL'){
						$query_join 	.= " LEFT JOIN annuaire_profils ap ON a.ref_contact = ap.ref_contact "; 
						$query_join_count 	.= " LEFT JOIN annuaire_profils ap ON a.ref_contact = ap.ref_contact "; 
						if ($query_where) { $query_where .= " && "; }
						$query_where 	.= "ap.id_profil = '".$search['id_profil']."'";
					}
					if ((isset($search['id_client_categ']) || isset($search['type_client']) )  && ($search['id_client_categ'] || $search['type_client'])) { 
						$query_join 	.= " LEFT JOIN annu_client anc ON a.ref_contact = anc.ref_contact "; 
						$query_join_count .= " LEFT JOIN annu_client anc ON a.ref_contact = anc.ref_contact "; 
					}
					if (isset($search['id_client_categ']) && $search['id_client_categ']) { 
						if ($query_where) { $query_where .= " && "; }
						$query_where 	.= " anc.id_client_categ = '".$search['id_client_categ']."'";
					}
					
					if (isset($search['type_client']) && $search['type_client']) { 
						if ($query_where) { $query_where .= " && "; }
						$query_where 	.= " anc.type_client = '".$search['type_client']."'";
					}
					
				}
				//adresse
				if ($search['ville']) {
					if ($query_where) { $query_where .= " && "; }
					$query_where	.= "ad.ville LIKE '%".addslashes($search['ville'])."%'";
				}
				elseif ($search['code_postal']) {
					if ($query_where) { $query_where .= " && "; }
					$query_where	.= "ad.code_postal LIKE '".$search['code_postal']."%'";
				}
				if ($search['ville'] || $search['code_postal']) {
					$query_join_count 	.= " LEFT JOIN adresses ad ON a.ref_contact = ad.ref_contact  ";
				}
				// Coordonnées
				if ($search['tel']) {
					if ($query_where) { $query_where .= " && "; }
					$query_where .= "(tel1 LIKE '%".$search['tel']."%' || tel2 LIKE '%".$search['tel']."%' || fax LIKE '%".$search['tel']."%')";
				}
				if ($search['email']) {
					if ($query_where) { $query_where .= " && "; }
					$query_where	.= "email LIKE '%".$search['email']."%'"; 
				}
				if ($search['tel'] || $search['email']) {
					$query_join_count 	.= " LEFT JOIN coordonnees co ON a.ref_contact = co.ref_contact ";
				}
				// Site
				if ($search['url']) {
					if ($query_where) { $query_where .= " && "; }
					$query_where	.= "url LIKE '%".$search['url']."%'"; 
					$query_join_count 	.= " LEFT JOIN sites_web si ON a.ref_contact = si.ref_contact ";
				}
			
				// Recherche dans les archives
				if (!$search['archive']) {
					if ($query_where) { $query_where .= " && "; }
					$query_where	.= "date_archivage IS NULL "; 
				}
			
				if (!$query_where) { 
					$query_where = 1; 
				}
				
			
				// Recherche
				$query = "SELECT a.ref_contact, nom, lib_civ_court, id_categorie, 
												 text_adresse, ad.code_postal, ad.ville, ad.ordre, 
												 tel1, tel2, fax,  co.ordre,
												 email, url, si.ordre
												 ".$query_select."
									FROM annuaire a 
										LEFT JOIN civilites c ON a.id_civilite = c.id_civilite 
										LEFT JOIN adresses ad ON a.ref_contact = ad.ref_contact 
										LEFT JOIN coordonnees co ON a.ref_contact = co.ref_contact && co.ordre = 1
										LEFT JOIN sites_web si ON a.ref_contact = si.ref_contact 
										".$query_join."
									WHERE ".$query_where." 
									GROUP BY a.ref_contact
									ORDER BY ".$search['orderby']." ".$search['orderorder'].", ad.ordre ASC, co.ordre ASC, si.ordre ASC
									 ";
				$resultat = $bdd->query($query);
				$nbAdresses = 0;
				while ($fiche = $resultat->fetchObject()) { 
					//**********************************
					// ECRITURE D'UNE ADRESSE	
					if($nbAdresses%24 == 0){ $this->pdf->AddPage(); $nbAdresses = 0; }
					$this->pdf->setMargins($nbAdresses%3*70+5, $this->MARGE_HAUT, 210-$nbAdresses%3*70-65);
					$this->pdf->setXY($nbAdresses%3*70+4,floor($nbAdresses/3)*37.125+$this->MARGE_HAUT);
					$nbLigne = 0; 
					
					$nom_complet = $fiche->lib_civ_court.' '.str_replace("\r"," ",str_replace("\n"," ",$fiche->nom));
					$width = $this->pdf->GetStringWidth($nom_complet);
					
					if($width < 65 ){
						$this->pdf->cell(0, 5, $nom_complet ,  0, 2, 'L');
						$nbLigne += 1; 
					}else{
						$pos_coupure = strlen($nom_complet) -1;
						while($this->pdf->GetStringWidth(substr($nom_complet,0,$pos_coupure)) >=65){
							--$pos_coupure;
						}
						while(substr($nom_complet,$pos_coupure,1) != ' ' AND $pos_coupure >0){
							--$pos_coupure;
						}
						$this->pdf->cell(0, 5, substr($nom_complet,0,$pos_coupure) ,  0, 2, 'L');
						$this->pdf->cell(0, 5, substr($nom_complet,$pos_coupure,strlen($nom_complet)-1) ,  0, 2, 'L');
						$nbLigne += 2; 
					}
					//attention conserver le format ci-dessus (Attrape le passage à la ligne)
					/*$text = explode('\n',$fiche->text_adresse);
					
					foreach($text AS $t){
						$this->pdf->cell(7, 5, $t,  0, 2, 'L');
					}*/
					
					/*$this->pdf->setX($nbAdresses%3*70+5);
					$nbLigne += 1 + substr_count($fiche->text_adresse, '
') + substr_count($fiche->text_adresse, '\n');
					
					$text = explode('\n',$fiche->text_adresse);
					foreach($text AS $t){
						$ligne = explode('
',$t);
						foreach($ligne AS $l){
								if($this->pdf->GetStringWidth($l) >=65){
									$nbLigne += floor($this->pdf->GetStringWidth($l)/65);
								}
						}
					}*/
					$this->pdf->setXY($this->pdf->getX()+1,$this->pdf->getY());
					$this->pdf->write(5,$fiche->text_adresse);
					//$this->pdf->setXY($nbAdresses%3*70+5,floor($nbAdresses/3)*37.125+5+$nbLigne*5);
					$this->pdf->setXY($nbAdresses%3*70+5,$this->pdf->getY()+5);
					$this->pdf->cell(0, 5, $fiche->code_postal." ".$fiche->ville,  0, 2, 'L');
					++$nbAdresses;
					
				}
			}

	}
	
	
	
}
?>