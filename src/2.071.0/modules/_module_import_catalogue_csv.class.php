<?php
// *************************************************************************************************************
// CLASSE REGISSANT les import d'articles depuis un fichier CSV 
// *************************************************************************************************************


final class import_catalogue_csv {
	protected $ref_art_categ; // ref_art_categ à créer lors de l'import
	protected $etape;			//etape en cours de l'import
	protected $limite;		// limite des informations importée (1: fiches valides 2: fiches avertissements, 3: toutes les fiches
		

function __construct() {
	global $bdd;
	
	$query = "SELECT ref_art_categ, etape, limite FROM csv_import_catalogue_etape LIMIT 0,1";
	$resultat = $bdd->query ($query); 
	if (!$a = $resultat->fetchObject()) { return false;}
	$this->ref_art_categ = $a->ref_art_categ;
	$this->etape = $a->etape;
	$this->limite = $a->limite;
	
	return true;
}

//import des données en fiche contact
function import_colonne($contenu, $ref_art_categ) {
	global $bdd;
	global $DIR;
	
	$count_erreur = 0;
	$count_import = 0;

	 if (isset($GLOBALS['_INFOS']['count_import'])) {$count_import = $GLOBALS['_INFOS']['count_import'];}
	$count_total = 0;
	
	if (!count($contenu)) {
		$GLOBALS['_ALERTES']['import_fichier_vide'] = 1;
	}
	
	// *************************************************
	// Arret en cas d'erreur
	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}
	
	$line_1 = $contenu[0];
	$nb_col = count ($line_1);
	
	if ($nb_col > 255) {
		$GLOBALS['_ALERTES']['import_fichier_trop_de_colonnes'] = 1;
		return false;
	}
	
	$GLOBALS['_COLONNE'] = array();
	// creation des daos
	$dao_csv_import_catalogue_ligne = new import_catalogue_csv_ligne();
	$dao_csv_import_catalogue_cols = new import_catalogue_csv_colonne();
	
	// on efface les table
	$dao_csv_import_catalogue_ligne->erase();
	$dao_csv_import_catalogue_cols->erase();
	
	//
	$query = "TRUNCATE TABLE `csv_import_catalogue_etape`";
	$bdd->exec ($query);
	
	for($i=0; $i < $nb_col; $i++) {
		$colonne = new import_catalogue_csv_colonne();
		$colonne->__setLibelle($line_1[$i]);
		
		// ecriture en base
		$GLOBALS['_COLONNE'][] = $i+1;
		$dao_csv_import_catalogue_cols->write($colonne);	
	}
	
	
	
	// ecriture des ligne
	
	for($curseur_fichier=1; $curseur_fichier < count($contenu); $curseur_fichier++) {
		$count_total++;
		// on retire les crlf
		//$my_wonderful_string = str_replace("\r\n", "", $contenu[$curseur_fichier]);
		//$my_wonderful_string = trim($my_wonderful_string, " \r\n\0\x0B");
		$tmp_line =  $contenu[$curseur_fichier];
		if (count($tmp_line) > $nb_col) { $count_erreur ++; continue;}
		
		for($curseur_ligne=0; $curseur_ligne < $nb_col; $curseur_ligne++) {
//			$ligne = new bean_ligne();
			$ligne = new import_catalogue_csv_ligne();
			if (isset($tmp_line[$curseur_ligne])) {
				$ligne->__setValeur($tmp_line[$curseur_ligne]);
			} else {
				$ligne->__setValeur("");
			}
			$ligne->__setId_colonne($curseur_ligne+1);
			// ecriture en base
			$dao_csv_import_catalogue_ligne->write($ligne);	
		}
	}
	//création de l'information sur l'étape et le profil à créer pour les contacts importés
	$query = "INSERT INTO csv_import_catalogue_etape	 (ref_art_categ, etape, limite) VALUES (".num_or_null($ref_art_categ).", 1, 1)
						";
	$bdd->exec ($query);
	
	foreach ($GLOBALS['_ALERTES']  as $alerte => $value) {
		echo $alerte." => ".$value."<br>";
	}

	// print_r($infos_generales);
	// print_r($infos_profils);
	 $GLOBALS['_ALERTES'] = array();
		
	 $GLOBALS['_INFOS']['count_import'] = $count_import;
	 $GLOBALS['_INFOS']['count_erreur'] = $count_erreur;
}

//mise à jour de l'étape de l'import
public function maj_ref_art_categ ($ref_art_categ) {
	global $bdd;
	// maj dans la base
	$query = "UPDATE csv_import_catalogue_etape SET ref_art_categ = '".$ref_art_categ."' ";
	$bdd->exec ($query);
	return true;
}
//mise à jour de l'étape de l'import
public function maj_etape($etape) {
	global $bdd;
	// maj dans la base
	$query = "UPDATE csv_import_catalogue_etape SET etape = '".$etape."' ";
	$bdd->exec ($query);
	return true;
}
//mise à jour de la limite d'import
public function maj_limite($limite) {
	global $bdd;
	// maj dans la base
	$query = "UPDATE csv_import_catalogue_etape SET limite = '".$limite."' ";
	$bdd->exec ($query);
	return true;
}

//import des données en fiche contact
function create($liste_ligne = array(), $filename) {
	global $DIR;
	global $bdd;
	global $DEFAUT_ID_PAYS;
	global $DEFAUT_ID_TVA;
	global $DEFAUT_ARTICLE_LT;
	global $CONSTRUCTEUR_ID_PROFIL;
	global $import_catalogue_csv;
	global $ARTICLES_IMAGES_DIR;
	global $ARTICLES_MINI_IMAGES_DIR;
	global $ARTICLE_IMAGE_MINIATURE_RATIO;

	$liste_export = Array();
        $j_ret = 0;
        $file_lines = file($filename);
        $max_id = count(explode(";", $file_lines[0]));
	$ratio = $ARTICLE_IMAGE_MINIATURE_RATIO;  
	$tarifs_liste = get_full_tarifs_listes ();
	$tvas = get_tvas ($DEFAUT_ID_PAYS);
	
	$art_categ_cree = array();
	$ref_constructeur_cree = array();
	
	$dao_csv_import_catalogue_cols = new import_catalogue_csv_colonne();
	$arraydao_csv_import_catalogue_cols = $dao_csv_import_catalogue_cols->readAll();
	$arrayValidColonne = array();
	$lastIdCols = 0;
	$firstIdCols = 0;
	
	foreach ($arraydao_csv_import_catalogue_cols as $import_catalogue_csv_colonne){
		if( trim($import_catalogue_csv_colonne->__getChamp_equivalent()) != ""){
			if($firstIdCols == 0){
				$firstIdCols = $import_catalogue_csv_colonne->__getId();
			}
			$arrayValidColonne[$import_catalogue_csv_colonne->__getId()] = $import_catalogue_csv_colonne->__getChamp_equivalent();
			$lastIdCols = $import_catalogue_csv_colonne->__getId();
		}
	}
	
	$dao_csv_import_catalogue_ligne = new import_catalogue_csv_ligne();
	$arraydao_csv_import_catalogue_ligne = $dao_csv_import_catalogue_ligne->readAll();
	
	$count_total = 0;
	$count_import = 0;
	if (isset($GLOBALS['_INFOS']['count_import'])) {$count_import = $GLOBALS['_INFOS']['count_import'];}
	$count_erreur = 0;
	foreach ($arraydao_csv_import_catalogue_ligne as $indexarraydao_csv_import_catalogue_ligne) {
		if (count($liste_ligne) && !in_array($indexarraydao_csv_import_catalogue_ligne->__getId(), $liste_ligne)) {continue;}
		
		$id_colonne = $indexarraydao_csv_import_catalogue_ligne->__getId_colonne();
		$id_valeur = $indexarraydao_csv_import_catalogue_ligne->__getValeurRenseignee();
		if($id_colonne == $firstIdCols){
		
		$stocks_alertes = array();
		$code_barre = array();
		$infos_modele = array();
		$infos_generales['modele']	=	"materiel";

		$infos_modele['poids']	=	'';
		$infos_modele['colisage']	=	'';
		$infos_modele['duree_garantie']	=	0;
		$infos_modele['stocks_alertes']	=	$stocks_alertes;
		
                // Infos spécifiques aux categs service par abonnement
                $infos_modele['duree'] = 0;
                $infos_modele['engagement'] = 0;
                $infos_modele['reconduction'] = 0;
                $infos_modele['preavis'] = 0;

		$infos_generales['ref_art_categ'] 		= $this->ref_art_categ;
		$infos_generales['lib_article'] 			= '';
		$infos_generales['lib_ticket']				= '';
		$infos_generales['desc_courte'] 			= '';
		$infos_generales['desc_longue'] 			= '';
		$infos_generales['ref_interne'] 			= '';
		$infos_generales['ref_oem'] 					= '';
		$infos_generales['ref_constructeur'] 	= '';
		$infos_generales['variante'] 					= 0;
		$infos_generales['id_valo'] 					= 1;
		$infos_generales['valo_indice'] 			= 1;
		$infos_generales['lot'] 							= 0;
		$infos_generales['gestion_sn'] 				= 0;
		$infos_generales['code_barre'] 				= $code_barre;
		$infos_generales['image'] 						= array();
		$infos_generales['id_tva'] 						= 0;
		$infos_generales['tva'] 							= 0;
		
		$art_categ_defaut = new art_categ ($this->ref_art_categ);
		
		
		foreach ($tvas as $tva) {
			if ($art_categ_defaut->getDefaut_id_tva () != $tva["id_tva"]) {continue;}
				$infos_generales['id_tva'] = $art_categ_defaut->getDefaut_id_tva () ;
				$infos_generales['tva'] = $tva["tva"] ;
			break;
		}
		
		$infos_generales['date_debut_dispo'] 	= date("Y-m-d");
		$infos_generales['date_fin_dispo'] 		= date("Y-m-d", mktime (date("m"),date("i"),date("s")+$art_categ_defaut->getDuree_dispo (), date("m"), date("d"), date("Y")));
		
		$infos_generales['prix_public_ht']	=	0;
		
		$infos_generales['prix_achat_ht']	= 0;
		$infos_generales['paa_ht']	= 0;
		$formules_tarifs	=	array();
		$qtes_tarifs	=	array();
		//tarif par defaut depuis l'art_categ
		$categ_formules = $art_categ_defaut->getFormules_tarifs ();
		if (is_array($categ_formules)) {
			foreach ($categ_formules as $cf) {
				$formule_tarif = new stdclass;
				$formule_tarif->id_tarif = $cf->id_tarif;
				$formule_tarif->indice_qte = 0;
				$formule_tarif->formule_tarif = $cf->formule_tarif;
				$formules_tarifs[] = $formule_tarif;	
			}
		}
		$caracs	=	array();
		$liaisons	=	array();
		$composants	=	array();
		}
		
		if(isset($arrayValidColonne[$id_colonne])){
		
			if($arrayValidColonne[$id_colonne] == "ref_art_categ" ){
				if ($id_valeur) {
					if ($id_valeur == "creer") {	
						//on vérifie que l'art_categ ne fait pas partie de celle déjà créer lors ce cet import
						$art_cc = 0;
						foreach ($art_categ_cree as $acc) {
							if ($acc[1] == $indexarraydao_csv_import_catalogue_ligne->__getValeur()) {
							$infos_generales['ref_art_categ'] = $acc[0] ; $art_cc = 1; break;}
						}
						if (!$art_cc) {
							// *************************************************
							// Création de la catégorie
							$art_categ = new art_categ ();
							$tva_id = ""; if ($DEFAUT_ID_TVA) {$tva_id = $DEFAUT_ID_TVA;}
						
							$art_categ->create ($indexarraydao_csv_import_catalogue_ligne->__getValeur(), "", "", "materiel", $tva_id, $DEFAUT_ARTICLE_LT);
							
							//mise à jour des autres valeurs
							// et on conserve pour la série en cour le fait d'avoir créé cette art_categ
							$art_categ_cree[] = array($art_categ->getRef_art_categ(), $indexarraydao_csv_import_catalogue_ligne->__getValeur());
							$indexarraydao_csv_import_catalogue_ligne->updateParLot($id_colonne, $indexarraydao_csv_import_catalogue_ligne->__getValeur(), $art_categ->getRef_art_categ());
							$infos_generales['ref_art_categ'] = $art_categ->getRef_art_categ() ;
						}
					} else {
						$infos_generales['ref_art_categ'] = $id_valeur ;
						$art_categ_tmp = new art_categ (trim($id_valeur));
						$infos_generales['modele'] = $art_categ_tmp->getModele();
						foreach ($tvas as $tva) {
							if ($art_categ_tmp->getDefaut_id_tva () != $tva["id_tva"]) {continue;}
								$infos_generales['id_tva'] = $art_categ_tmp->getDefaut_id_tva () ;
								$infos_generales['tva'] = $tva["tva"] ;
							break;
						}
						
						//tarif par defaut depuis l'art_categ
						$categ_formules = $art_categ_tmp->getFormules_tarifs ();
						if (is_array($categ_formules)) {
							foreach ($categ_formules as $cf) {
								$formule_tarif = new stdclass;
								$formule_tarif->id_tarif = $cf->id_tarif;
								$formule_tarif->indice_qte = 0;
								$formule_tarif->formule_tarif = $cf->formule_tarif;
								$formules_tarifs[] = $formule_tarif;	
							}
						}
						$infos_generales['date_fin_dispo'] =  (date("Y-m-d", mktime (date("m"),date("i"),date("s")+$art_categ_tmp->getDuree_dispo (), date("m"), date("d"), date("Y")))) ;
						
					}
				}
			}
			
			
			if($arrayValidColonne[$id_colonne] == "lib_article" ){
				if ($infos_generales['lib_article']) {
					$infos_generales['lib_article'] 		.= "\n".$id_valeur ;
				} else {
					$infos_generales['lib_article'] 		.= $id_valeur ;
				}
			}
			
			if($arrayValidColonne[$id_colonne] == "lib_ticket" ){
				$infos_generales['lib_ticket'] = $id_valeur ;
			}
			
			if($arrayValidColonne[$id_colonne] == "desc_courte" ){
				if ($infos_generales['desc_courte']) {
					$infos_generales['desc_courte'] 		.= "\n".$id_valeur ;
				} else {
					$infos_generales['desc_courte'] 		.= $id_valeur ;
				}
			}
			
			if($arrayValidColonne[$id_colonne] == "desc_longue" ){
				if ($infos_generales['desc_longue']) {
					$infos_generales['desc_longue'] 		.= "\n".$id_valeur ;
				} else {
					$infos_generales['desc_longue'] 		.= $id_valeur ;
				}
			}
			
			if($arrayValidColonne[$id_colonne] == "ref_interne" ){
				$infos_generales['ref_interne'] = $id_valeur ;
			}
			
			if($arrayValidColonne[$id_colonne] == "ref_oem" ){
				$infos_generales['ref_oem'] = $id_valeur ;
			}
			
			if($arrayValidColonne[$id_colonne] == "ref_constructeur" ){
				if ($id_valeur) {
					if ($id_valeur == "creer") {	
						//on vérifie que le contact ne fait pas partie de celle déjà créer lors ce cet import
						$c_cc = 0;
						foreach ($ref_constructeur_cree as $ccc) {
							if ($ccc[1] == $indexarraydao_csv_import_catalogue_ligne->__getValeur()) {
							$infos_generales['ref_constructeur'] = $ccc[0] ; $c_cc = 1; break;}
						}
						if (!$c_cc) {
							// *************************************************
							// Création du contact
							$contact = new contact ();
							$inf_const = array();
							$inf_const_profil = array();
							$inf_const['id_civilite']		= "5";
							$inf_const['nom'] 					= $indexarraydao_csv_import_catalogue_ligne->__getValeur();
							$inf_const['siret'] 				= "";
							$inf_const['tva_intra'] 		= "";
							$inf_const['id_categorie']	= "5";
							$inf_const['note'] 					= "";
							$inf_const['adresses']			= array();
							$inf_const['coordonnees']		= array();
							$inf_const['sites']					= array();
							$inf_const_profil[$CONSTRUCTEUR_ID_PROFIL]['id_profil'] = $CONSTRUCTEUR_ID_PROFIL;
							$inf_const_profil[$CONSTRUCTEUR_ID_PROFIL]['identifiant_revendeur'] = "";
							$inf_const_profil[$CONSTRUCTEUR_ID_PROFIL]['conditions_garantie'] = "";
							
							$contact->create ($inf_const, $inf_const_profil);
							//mise à jour des autres valeurs
							// et on conserve pour la série en cour le fait d'avoir créé cette art_categ
							$ref_constructeur_cree[] = array($contact->getRef_contact(), $indexarraydao_csv_import_catalogue_ligne->__getValeur());
							$indexarraydao_csv_import_catalogue_ligne->updateParLot($id_colonne, $indexarraydao_csv_import_catalogue_ligne->__getValeur(), $contact->getRef_contact());
							$infos_generales['ref_constructeur'] = $contact->getRef_contact() ;
						}
					} else {
						$infos_generales['ref_constructeur'] = $id_valeur ;
					}
				}
			}
			
			if($arrayValidColonne[$id_colonne] == "date_debut_dispo" && trim(date_Fr_to_Us($id_valeur)) != "--"){
				$infos_generales['date_debut_dispo'] = date_Fr_to_Us($id_valeur) ;
			}
			if($arrayValidColonne[$id_colonne] == "date_fin_dispo" && trim(date_Fr_to_Us($id_valeur)) != "--" ){
			
				$infos_generales['date_fin_dispo'] =  date_Fr_to_Us($id_valeur) ;
			}
			if($arrayValidColonne[$id_colonne] == "gestion_sn" ){
				$infos_generales['gestion_sn'] = $id_valeur ;
			}
			if($arrayValidColonne[$id_colonne] == "id_valo" ){
				$infos_generales['id_valo'] = $id_valeur ;
			}
			if($arrayValidColonne[$id_colonne] == "code_barre" ){
				$infos_generales['code_barre'][] = $id_valeur ;
			}
			
			
			if($arrayValidColonne[$id_colonne] == "poids" && $id_valeur &&  convert_numeric($id_valeur) ){
				$infos_modele['poids'] = convert_numeric($id_valeur);
			}
			if($arrayValidColonne[$id_colonne] == "colisage" && $id_valeur &&  convert_numeric($id_valeur) ){
				$infos_modele['colisage'] = convert_numeric($id_valeur);
			}
			if($arrayValidColonne[$id_colonne] == "duree_garantie" && $id_valeur && convert_numeric($id_valeur) ){
				$infos_modele['duree_garantie'] = convert_numeric($id_valeur);
			}
			
			if($arrayValidColonne[$id_colonne] == "image" && trim($id_valeur) ){
				$infos_generales['image'][] = $id_valeur ;
			}
			
			if($arrayValidColonne[$id_colonne] == "tva" && $id_valeur && convert_numeric($id_valeur) ){
				foreach ($tvas as $tva) {
					if (trim(convert_numeric($id_valeur)) != $tva["tva"]) {continue;}
					$infos_generales['id_tva'] = $tva["id_tva"];
					$infos_generales['tva'] = convert_numeric($id_valeur);
					break;
				}
			}
				
			if($arrayValidColonne[$id_colonne] == "prix_public_ht"  && $id_valeur && convert_numeric($id_valeur)){
				$infos_generales['prix_public_ht']	=	convert_numeric($id_valeur);
			}
			
			if($arrayValidColonne[$id_colonne] == "paa_ht"  && $id_valeur && convert_numeric($id_valeur)){
				$infos_generales['prix_achat_ht']	= $infos_generales['paa_ht']	=	convert_numeric($id_valeur);
			}
		
			if(substr_count($arrayValidColonne[$id_colonne], "id_tarif_qte_" )  && $id_valeur && convert_numeric($id_valeur)) {		
				$qtes_tarifs[substr($arrayValidColonne[$id_colonne], strrpos($arrayValidColonne[$id_colonne], "_")+1)]	= convert_numeric($id_valeur);
				foreach ($formules_tarifs as $formule_tarif) {
					if(substr($arrayValidColonne[$id_colonne], strrpos($arrayValidColonne[$id_colonne], "_")+1) == $tarif->id_tarif) {
						$formule_tarif->indice_qte = convert_numeric($id_valeur);
					}
				}
			}
			
			
			foreach ($tarifs_liste as $tarif) {
				if ($arrayValidColonne[$id_colonne] == "id_tarif_".$tarif->id_tarif && $id_valeur && convert_numeric($id_valeur)) {
					$formule_tarif = new stdclass;
					$formule_tarif->id_tarif = $tarif->id_tarif;
					$formule_tarif->indice_qte = 1;
					if (isset($qtes_tarifs[$tarif->id_tarif])) {
						$formule_tarif->indice_qte = $qtes_tarifs[$tarif->id_tarif];
					}
					$formule_tarif->formule_tarif = "PU_HT=".convert_numeric($id_valeur);
					$formules_tarifs[] = $formule_tarif;	
				}
			}
			
		}

		
		if($id_colonne == $lastIdCols){
		
			// *************************************************
			// Création du contact
			if (isset($infos_generales['lib_article']) && trim($infos_generales['lib_article']) ) {
				$nom_doublon = 0;
				$ref_interne_doublon = 0;
				//verification des doublon d'email et de nom
				// si on tente d'importer quand même les avertissements
				$libs = explode (" ", trim($infos_generales['lib_article']));
				
				$query_where 	= "";
                                $comp = 0;
				for ($i=0; $i<count($libs); $i++) {
					$lib = trim($libs[$i]);
                                        if (isset($libs[$i+1]))
                                        {
                                            $comp = 1;
                                            $query_where 	.= " lib_article LIKE '%".addslashes($lib)."%' ";
                                            $query_where 	.= " && ";
                                        }
					else
                                        {
                                            if ($comp == 1)
                                                $query_where 	.= " lib_article LIKE '%".addslashes($lib)."%' ";
                                            else
                                                $query_where 	.= " lib_article LIKE '".addslashes($lib)."' ";
                                        }
					
				}
				$query = "SELECT lib_article
									FROM articles a 
									WHERE ".$query_where."
									LIMIT 0,1";
				$resultat = $bdd->query($query);
				if ($fiche = $resultat->fetchObject()) {
					$nom_doublon = 1;
				}
				//on vérifie la ref car dans tout les cas on n'ecrassera pas une ref déjà présente
				if (isset($infos_generales['ref_interne']) && trim($infos_generales['ref_interne'])) {
					
					$query_where 	= "";
					$query_where 	.= " ref_interne = '".addslashes(trim($infos_generales['ref_interne']))."' && ref_interne != ''"; 
					
					$query = "SELECT ref_interne
										FROM articles 
										WHERE ".$query_where."
										LIMIT 0,1";
					$resultat = $bdd->query($query);
					if ($fiche = $resultat->fetchObject()) { 
						$ref_interne_doublon = 1;
						if (isset($infos_generales['ref_interne'])) {$infos_generales['ref_interne'] = "";}
					}
				}
				// on check en fonction de limite si on importe ou non l'article
				$can_import = 0;
				if ($this->limite == 3) {$can_import = 1;}
				if ($this->limite == 1 && !$nom_doublon) {$can_import = 1;}
				if ($this->limite == 2 && $nom_doublon) {$can_import = 1;}
				if ($can_import == 0)
                                    {
                                        $liste_export[] = $indexarraydao_csv_import_catalogue_ligne->__getId();
                                    }
				if ($can_import) {
					$article = new article ();
					if (($creation = $article->create ($infos_generales, $infos_modele, $caracs, $formules_tarifs, $composants, $liaisons)) == false)
                                            $liste_export[] = $indexarraydao_csv_import_catalogue_ligne->__getId();
                                        $count_import ++;
					//import des images 
					if ($article->getRef_article() && count($infos_generales['image'])) {
						foreach ($infos_generales['image'] as $image_article) {
							$tableau = @getimagesize($DIR.$import_catalogue_csv['import_images_folder'].$image_article);
							
							if ($tableau) { 
								$extension = substr($image_article, strrpos($image_article, "."));
								
								$file_upload = md5(uniqid(rand(), true)).$extension;
								if (is_file($ARTICLES_IMAGES_DIR.$file_upload)) {$file_upload = md5(uniqid(rand(), true)).$extension; }
								
								copy ($DIR.$import_catalogue_csv['import_images_folder'].$image_article, $ARTICLES_IMAGES_DIR.$file_upload); 
									// Générer la miniature 
								 // si notre image est de type jpeg 
								 if ($tableau[2] == 2) { 
										// on crée une image à partir de notre grande image à l'aide de la librairie GD 
										$src = imagecreatefromjpeg($ARTICLES_IMAGES_DIR.$file_upload); 
										// on teste si notre image est de type paysage ou portrait 
										if ($tableau[0] > $tableau[1]) { 
											if ($tableau[0] > $ratio) {
												$x_size = $ratio;
												$y_size = round(($ratio/$tableau[0])*$tableau[1]);
											} else {
												$x_size = $tableau[0];
												$y_size = $tableau[1];
											}
											 $im = imagecreatetruecolor($x_size, $y_size); 
											 imagecopyresampled($im, $src, 0, 0, 0, 0, $x_size, $y_size, $tableau[0], $tableau[1]); 
										} 
										else { 
											if ($tableau[1] > $ratio) {
												$x_size = round(($ratio/$tableau[1])*$tableau[0]);
												$y_size = $ratio;
											} else {
												$x_size = $tableau[0];
												$y_size = $tableau[1];
											}
											 $im = imagecreatetruecolor($x_size, $y_size); 
											 imagecopyresampled($im, $src, 0, 0, 0, 0, $x_size, $y_size, $tableau[0], $tableau[1]); 
										}
										// on copie notre fichier généré dans le répertoire des miniatures 
										imagejpeg ($im, $ARTICLES_MINI_IMAGES_DIR.$file_upload); 
								 } 
								 elseif ($tableau[2] == 3) { 
										$src = imagecreatefrompng($ARTICLES_IMAGES_DIR.$file_upload); 
										if ($tableau[0] > $tableau[1]) { 
											if ($tableau[0] > $ratio) {
												$x_size = $ratio;
												$y_size = round(($ratio/$tableau[0])*$tableau[1]);
											} else {
												$x_size = $tableau[0];
												$y_size = $tableau[1];
											}
											 $im = imagecreatetruecolor($x_size, $y_size); 
											 imagecopyresampled($im, $src, 0, 0, 0, 0, $x_size, $y_size, $tableau[0], $tableau[1]); 
												if ($val_alpha = imagecolorclosestalpha   ($src, 255, 255, 255, 127)) {
													if ($val_alpha <20) {
														$background_color = imagecolorallocate ($im, 255, 255, 255);
														$transparent_color = imagecolortransparent($im,$background_color); 
													} elseif ($val_alpha >200) {
														$background_color = imagecolorallocate ($im, 0, 0, 0);
														$transparent_color = imagecolortransparent($im,$background_color); 
													}
												}
										} 
										else { 
											if ($tableau[1] > $ratio) {
												$x_size = round(($ratio/$tableau[1])*$tableau[0]);
												$y_size = $ratio;
											} else {
												$x_size = $tableau[0];
												$y_size = $tableau[1];
											}
											 $im = imagecreatetruecolor($x_size, $y_size); 
											 imagecopyresampled($im, $src, 0, 0, 0, 0, $x_size, $y_size, $tableau[0], $tableau[1]); 
												if ($val_alpha = imagecolorclosestalpha   ($src, 255, 255, 255, 127)) {
													if ($val_alpha <20) {
														$background_color = imagecolorallocate ($im, 255, 255, 255);
														$transparent_color = imagecolortransparent($im,$background_color); 
													} elseif ($val_alpha >200) {
														$background_color = imagecolorallocate ($im, 0, 0, 0);
														$transparent_color = imagecolortransparent($im,$background_color); 
													}
												}
										}
										imagepng ($im, $ARTICLES_MINI_IMAGES_DIR.$file_upload); 
								 } 
								 elseif ($tableau[2] == 1) { 
										$src = imagecreatefromgif($ARTICLES_IMAGES_DIR.$file_upload); 
										echo $tableau[0]." ". $tableau[1];
										if ($tableau[0] > $tableau[1]) { 
											if ($tableau[0] > $ratio) {
												$x_size = $ratio;
												$y_size = round(($ratio/$tableau[0])*$tableau[1]);
											} else {
												$x_size = $tableau[0];
												$y_size = $tableau[1];
											}
										echo "<br />".$x_size." ". $y_size;
											 $im = imagecreatetruecolor($x_size, $y_size); 
											 imagecopyresampled($im, $src, 0, 0, 0, 0, $x_size, $y_size, $tableau[0], $tableau[1]); 
												if ($val_alpha = imagecolorclosestalpha   ($src, 255, 255, 255, 127)) {
													if ($val_alpha <20) {
														$background_color = imagecolorallocate ($im, 255, 255, 255);
														$transparent_color = imagecolortransparent($im,$background_color); 
													} elseif ($val_alpha >200) {
														$background_color = imagecolorallocate ($im, 0, 0, 0);
														$transparent_color = imagecolortransparent($im,$background_color); 
													}
												}
										} 
										else { 
											if ($tableau[1] > $ratio) {
												$x_size = round(($ratio/$tableau[1])*$tableau[0]);
												$y_size = $ratio;
											} else {
												$x_size = $tableau[0];
												$y_size = $tableau[1];
											}
											 $im = imagecreatetruecolor($x_size, $y_size); 
											 imagecopyresampled($im, $src, 0, 0, 0, 0, $x_size, $y_size, $tableau[0], $tableau[1]); 
												if ($val_alpha = imagecolorclosestalpha   ($src, 255, 255, 255, 127)) {
													if ($val_alpha <20) {
														$background_color = imagecolorallocate ($im, 255, 255, 255);
														$transparent_color = imagecolortransparent($im,$background_color); 
													} elseif ($val_alpha >200) {
														$background_color = imagecolorallocate ($im, 0, 0, 0);
														$transparent_color = imagecolortransparent($im,$background_color); 
													}
												}
										} 
										imagegif ($im, $ARTICLES_MINI_IMAGES_DIR.$file_upload); 
								 } 
								 
								 unlink($DIR.$import_catalogue_csv['import_images_folder'].$image_article); 
								 $article->add_image ($file_upload);
							}
						}
					}
				}
				
			}
			foreach ($GLOBALS['_ALERTES']  as $alerte => $value) {
				echo $alerte." => ".$value."<br>";
			}
			if(count($GLOBALS['_ALERTES'])) {
				$count_erreur ++;
			} else {
			}
			 $GLOBALS['_ALERTES'] = array();
		}
	}
	if (count($liste_ligne)) {
		$indexarraydao_csv_import_catalogue_ligne->supprimer($liste_ligne);
	}
	$GLOBALS['_INFOS']['count_import'] = $count_import;
	$GLOBALS['_INFOS']['count_erreur'] = $count_erreur;
        if (file_exists("retour_import.csv"))
            {
                if (!filesize("retour_import.csv"))
                    {
                        $fichier = file("import_cop.csv");
                        if (isset($fichier[0]))
                            {
                                $fd = fopen("retour_import.csv", "w");
                                fwrite($fd, $fichier[0]);
                                fclose($fd);
                            }
                    }
            }
        else
            {
                $fichier = file("import_cop.csv");
                if (isset($fichier[0]))
                    {
                        $fd = fopen("retour_import.csv", "w");
                        fwrite($fd, $fichier[0]);
                        fclose($fd);
                    }
            }
        $fd = fopen("retour_import.csv", "a");
        chmod("retour_import.csv", 0755);
        foreach($liste_export as $export_fail)
            fwrite($fd, $file_lines[ceil($export_fail / $max_id)]);
        fclose($fd);
}
 
function getRef_art_categ () {
	return $this->ref_art_categ;
}
 
function getEtape () {
	return $this->etape;
}
 
function getLimite () {
	return $this->limite;
}


}


// ******
// repartition des colonnes
// ******


final class import_catalogue_csv_colonne{

	private $id;
	private $libelle;
	private $champ_equivalent;
	

function __construct() {
	return true;
}

/**
 * @return unknown_type
 */
public function __getId() {
	return $this->id;
}

/**
 * @param $id
 * @return unknown_type
 */
public function __setId($id) {
	$this->id = $id;
}

/**
 * @return unknown_type
 */
public function __getLibelle() {
	return $this->libelle;
}

/**
 * @param $libelle
 * @return unknown_type
 */
public function __setLibelle($libelle) {
	$this->libelle = $libelle;
}

/**
 * @return unknown_type
 */
public function __getChamp_equivalent() {
	return $this->champ_equivalent;
}

/**
 * @param $champ_equivalent
 * @return unknown_type
 */
public function __setChamp_equivalent($champ_equivalent) {
	$this->champ_equivalent = $champ_equivalent;
}

//effacement table
public function erase() {
	global $bdd;
	$query = "ALTER TABLE `csv_import_catalogue_lines` DROP FOREIGN KEY `csv_import_catalogue_lines_ibfk_1`";
	$bdd->exec ($query);
	$query = "TRUNCATE TABLE `csv_import_catalogue_cols`";
	$bdd->exec ($query);
	$query = "ALTER TABLE `csv_import_catalogue_lines` ADD CONSTRAINT `csv_import_catalogue_lines_ibfk_1` FOREIGN KEY (`id_colonne`) REFERENCES `csv_import_catalogue_cols` (`id_colonne`) ON DELETE CASCADE ON UPDATE CASCADE";
	$bdd->exec ($query);
	$bdd->commit();
	return true;
}

//ecriture
public function write($pimport_catalogue_csv_ligne) {
	global $bdd;
	// Insertion dans la base
	$query = "INSERT INTO csv_import_catalogue_cols (lib_colonne, champ_equivalent)
						VALUES (	'".addslashes(trim($pimport_catalogue_csv_ligne->__getLibelle()))."',
								 	'".addslashes(trim($pimport_catalogue_csv_ligne->__getChamp_equivalent()))."') ";
	$bdd->exec ($query);
	$bdd->commit();
	return true;
}

//update
public function update($pId, $pValue) {
	global $bdd;
	// lecture dans la base
	$query = "UPDATE csv_import_catalogue_cols SET champ_equivalent = '".$pValue."' WHERE id_colonne = '" .$pId. "'"; 
	
	$bdd->exec ($query);
	$bdd->commit();
	return true;
}



//lecture
public function read($pId) {
	global $bdd;
	// lecture dans la base
	$query = "SELECT * FROM csv_import_catalogue_cols where id_colonne = '" .$pId. "'"; 
	
	$colonne_array = array();
	$colonne = new import_catalogue_csv_colonne();
	$resultat = $bdd->query ($query);
	while ($tmp = $resultat->fetchObject()) { $colonne_array[] = $tmp; }
	$colonne->__setId($colonne_array[0]->id_colonne);
	$colonne->__setLibelle($colonne_array[0]->lib_colonne);
	$colonne->__setChamp_equivalent($colonne_array[0]->champ_equivalent);

	return $colonne;
}

//lecture total
public function readAll() {
	global $bdd;
	// lecture dans la base
	$query = "SELECT * FROM csv_import_catalogue_cols"; 
	
	$array_retour = array();
	$colonne_array = array();
	
	$resultat = $bdd->query ($query);
	while ($tmp = $resultat->fetchObject()) {
		$colonne = new import_catalogue_csv_colonne(); 
		$colonne->__setId($tmp->id_colonne);
		$colonne->__setLibelle($tmp->lib_colonne);
		$colonne->__setChamp_equivalent($tmp->champ_equivalent);
		$array_retour[] = $colonne;
	}
	return $array_retour;
}


}

// *******
// répartition des lignes
// *******


final class import_catalogue_csv_ligne{

	private $id;
	private $id_colonne;
	private $valeur;
	private $valeur_equivalente;
	

function __construct() {
	return true;
}

public function __getId() {
	return $this->id;
}

public function __setId($id) {
	$this->id = $id;
}

public function __getId_colonne() {
	return $this->id_colonne;
}

public function __setId_colonne($id_colonne) {
	$this->id_colonne = $id_colonne;
}

public function __getValeur() {
	return $this->valeur;
}

public function __setValeur($valeur) {
	$this->valeur = $valeur;
}

public function __getValeur_equivalente() {
	return $this->valeur_equivalente;
}

public function __setValeur_equivalente($valeur_equivalente) {
	$this->valeur_equivalente = $valeur_equivalente;
}

public function __getValeurRenseignee() {
	if(isset($this->valeur_equivalente) && $this->valeur_equivalente != "" ){
		return $this->valeur_equivalente;
	}else{
		return $this->valeur;
	}
}
//effacement table
function erase() {
	global $bdd;
	// Insertion dans la base
	$query = "TRUNCATE TABLE `csv_import_catalogue_lines`";
	$bdd->exec ($query);
	$bdd->commit();
	return true;
}

//ecriture
function write(import_catalogue_csv_ligne   $pimport_catalogue_csv_ligne) {
	global $bdd;
	// Insertion dans la base
	$query = "INSERT INTO csv_import_catalogue_lines (id_colonne, valeur, valeur_equivalente)
						VALUES (	'".trim($pimport_catalogue_csv_ligne->__getId_colonne())."',
									'".addslashes(trim($pimport_catalogue_csv_ligne->__getValeur()))."',
								 	'".addslashes(trim($pimport_catalogue_csv_ligne->__getValeur_equivalente()))."') ";
	$bdd->exec ($query);
	return true;
}

//supression de lignes
function supprimer($liste_ligne) {
	global $bdd;
	// Insertion dans la base
	$query = "DELETE FROM  csv_import_catalogue_lines WHERE id_ligne IN (".implode(",",$liste_ligne).")  ";
	$bdd->exec ($query);
	return true;
}

//lecture unitaire
function read($pId) {
	global $bdd;
	// lecture dans la base
	$query = "SELECT * FROM csv_import_catalogue_lines where id_ligne = '" .$pId. "'"; 
	
	$ligne_array = array();
	$ligne = new import_catalogue_csv_ligne();
	$resultat = $bdd->query ($query);
	while ($tmp = $resultat->fetchObject()) { $ligne_array[] = $tmp; }
	$ligne->__setId($ligne_array[0]->id_ligne);
	$ligne->__setId_colonne($ligne_array[0]->id_colonne);
	$ligne->__setValeur($ligne_array[0]->valeur);
	$ligne->__setValeur_equivalente($ligne_array[0]->valeur_equivalente);
	return $ligne;
}

//update
public function update($pId, $pValue) {
	global $bdd;
	
	$query = "UPDATE csv_import_catalogue_lines SET valeur_equivalente = '".trim($pValue)."' WHERE id_ligne = '" .$pId. "'"; 
	$bdd->exec ($query);
	
	return true;
}

//update par lot
public function updateParLot($pIdColonne, $pValeur, $pValeurEquivalente) {
	global $bdd;
	
	$query = "UPDATE csv_import_catalogue_lines SET valeur_equivalente = '".trim($pValeurEquivalente)."' WHERE id_colonne = '" .$pIdColonne. "' AND valeur = '".trim($pValeur)."'";
	echo $query."<br />";
	$bdd->exec ($query);
	
	return true;
}


//lecture total
function readAll() {
	global $bdd;
	$query = "SELECT * FROM csv_import_catalogue_lines"; 
	
	$array_retour = array();
	$ligne_array = array();
	
	$resultat = $bdd->query ($query);
	while ($tmp = $resultat->fetchObject()) {
		$ligne = new import_catalogue_csv_ligne(); 
		$ligne->__setId($tmp->id_ligne);
		$ligne->__setId_colonne($tmp->id_colonne);
		$ligne->__setValeur($tmp->valeur);
		$ligne->__setValeur_equivalente($tmp->valeur_equivalente);
		$array_retour[] = $ligne;
	}
	return $array_retour;
}


//lecture total suivant un id_colonne
function readAllColonne($pIdColonne) {
	global $bdd;
	// lecture dans la base
	$query = "SELECT valeur, id_ligne FROM csv_import_catalogue_lines WHERE id_colonne = " . $pIdColonne." GROUP BY valeur" ; 
	
	$array_retour = array();
	$resultat = $bdd->query ($query);
	
	while ($tmp = $resultat->fetchObject()) {
		$ligne = new import_catalogue_csv_ligne(); 
		$ligne->__setId($tmp->id_ligne);
		$ligne->__setValeur($tmp->valeur);
		$array_retour[] = $ligne;
	}
	return $array_retour;
}
}

?>