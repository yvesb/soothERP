<?php
// *************************************************************************************************************
// IMPORT DES ARTICLES
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");



$import_article = array();
$import_article_code_barre = array();
$import_article_carac = array();
$import_article_composant = array();
$import_article_liaison = array();
$import_article_image = array();
$import_serveur = new import_serveur ($_REQUEST["ref_serveur"]);
$import_infos = $import_serveur->charger_import_infos (2);

$presentes_art_categ =	get_articles_categories();
//si import_infos est vide c'est le premier import effectué, on génére alors la liste des art_categ importée depuis les art_categ dans la base
if ($import_infos == "") {
	foreach ($presentes_art_categ as $art_categ_imported) {
		if (substr ($art_categ_imported->ref_art_categ, 4, 6) != $_SERVER['REF_SERVEUR']) {
			$import_infos .= $art_categ_imported->ref_art_categ.";0000-00-00\n";
		}
	}
} else {
//ou on ajoute à la liste les art_categ qui n'auraient pas encore été mises à jours
	foreach ($presentes_art_categ as $art_categ_imported) {
		if (!substr_count ($import_infos, $art_categ_imported->ref_art_categ) ) {
			if (substr ($art_categ_imported->ref_art_categ, 4, 6) != $_SERVER['REF_SERVEUR']) {
				$import_infos .= $art_categ_imported->ref_art_categ.";0000-00-00\n";
			}
		}
	}
}
//découpage des import_infos en tableau pour traiter plus facilement le contenu
$import_art_categ_liste = array();
$tmp_import_art_categ_liste = explode ("\n", $import_infos);
foreach ($tmp_import_art_categ_liste as $tmp) {
//echo $tmp."<br />";
	$tmp_array = explode (";", $tmp);
	if ($tmp_array[0] != "") {
		$import_art_categ_liste[$tmp_array[0]] = $tmp_array[1];
	}
}


	
	
$fichier = $import_serveur->getUrl_serveur_import().$ECHANGE_LMB_DIR."export_articles_send_data.php?ref_serveur=".$_SERVER['REF_SERVEUR']."&debut=".$_REQUEST["debut"]."&fin=".$_REQUEST["fin"]."&load_info=".$_REQUEST["load_info"];



$nombre_articles = $_REQUEST["nombre_articles"];
$ndebut = $_REQUEST["fin"];
$nfin = $_REQUEST["fin"]+$IMPORT_ARTICLE_LIMIT;
$load_info = $_REQUEST["load_info"];
if ($_REQUEST["fin"] > $nombre_articles && $_REQUEST["load_info"] == "articles") {
	$ndebut = 0;
	$nfin = $IMPORT_ARTICLE_LIMIT;
	$load_info = "compo";
}
if ($_REQUEST["fin"] > $nombre_articles && $_REQUEST["load_info"] == "compo") {
	$ndebut = 0;
	$nfin = 0;
	$load_info = "compo";
}

readfile($fichier);
    // Ma propre fonction de traitement des balises ouvrantes
    function fonctionBaliseOuvrante($parseur, $nomBalise, $tableauAttributs)
    {
        global $derniereBaliseRencontree;
        global $import_article;
        global $import_article_code_barre;
        global $import_article_carac;
        global $import_article_composant;
        global $import_article_liaison;
				global $import_article_image;

        $derniereBaliseRencontree = $nomBalise;
				
        switch ($nomBalise) {
            case "ARTICLE": 
                $import_article[] = $tableauAttributs;
                break;
            case "CODE_BARRE": 
                $import_article_code_barre[] = $tableauAttributs;
                break;
            case "CARAC": 
                $import_article_carac[] = $tableauAttributs;
                break;
            case "COMPOSANT": 
                $import_article_composant[] = $tableauAttributs;
                break;
            case "LIAISON": 
                $import_article_liaison[] = $tableauAttributs;
                break;
            case "IMAGE": 
                $import_article_image[] = $tableauAttributs;
                break;
        } 
    }
   
    // Fonction de traitement des balises fermantes
    function fonctionBaliseFermante($parseur, $nomBalise)
    {
        // On oublie la dernière balise rencontrée
        global $derniereBaliseRencontree;

        $derniereBaliseRencontree = "";
    }

    //Fonction de traitement du texte
    // qui est appelée par le "parseur"
    function fonctionTexte($parseur, $texte)
    {
    }

    // Création du parseur XML
    $parseurXML = xml_parser_create("ISO-8859-1");

    // Nom des fonctions à appeler
    // lorsque des balises ouvrantes ou fermantes sont rencontrées
    xml_set_element_handler($parseurXML, "fonctionBaliseOuvrante"
                                       , "fonctionBaliseFermante");

    // Nom de la fonction à appeler
    // lorsque du texte est rencontré
    xml_set_character_data_handler($parseurXML, "fonctionTexte");

    // Ouverture du fichier
    $fp = fopen($fichier, "r");
    if (!$fp) die("Impossible d'ouvrir le fichier XML");

    // Lecture ligne par ligne
    while ( $ligneXML = fgets($fp, 1024)) {
        // Analyse de la ligne
        // REM: feof($fp) retourne TRUE s'il s'agit de la dernière
        //      ligne du fichier.
        xml_parse($parseurXML, $ligneXML, feof($fp)) or
            die("Erreur XML");
    }
    
    xml_parser_free($parseurXML);
    fclose($fp);

if ($_REQUEST["load_info"] == "articles") {
	foreach ($import_article as $article_import) {
		if (count($GLOBALS['_ALERTES'])) { $GLOBALS['_ALERTES'] = array();}
		if (count($GLOBALS['_INFOS'])) {$GLOBALS['_INFOS'] = array();}
		
	@ob_start();
		$article = new article ($article_import["REF_ARTICLE"]);
		
		echo "<br /><span style='font-weight:bolder'>".htmlspecialchars_decode($article_import["LIB_ARTICLE"])."</span><br />";
		
		if (!$article->getRef_article()) {
			//on cré l'article
			$stocks_alertes = array();
			$code_barre = array();
			foreach ($import_article_code_barre as $article_code_barre) {
				if ($article_import["REF_ARTICLE"] != $article_code_barre["REF_ARTICLE"]) { continue; }
				$code_barre[] = $article_code_barre["CODE_BARRE"];
			}
			
			
				$infos_generales['modele']	=	$article_import['MODELE'];
				$infos_modele = array();
					switch ($article_import['MODELE']) {
					case "materiel":
						$infos_modele['poids']	=	$article_import['POIDS'];
						$infos_modele['colisage']	=	$article_import['COLISAGE'];
						$infos_modele['duree_garantie']	=	$article_import['DUREE_GARANTIE'];
						$infos_modele['stocks_alertes']	=	$stocks_alertes;
						
						break;
					case "service":
						break;
			
					case "service_abo":
						$infos_modele['duree']	=	$article_import['DUREE'];
						$infos_modele['engagement']	=	$article_import['ENGAGEMENT'];
						$infos_modele['reconduction']	=	$article_import['RECONDUCTION'];
						$infos_modele['preavis']	=	$article_import['PREAVIS'];
						break;
					case "service_conso":
						$infos_modele['duree_validite'] = $article_import['DUREE_VALIDITE'];
						$infos_modele['nb_credits'] = $article_import['NB_CREDITS'];
						break;
					}	
						
						$ref_constructeur = '';
						if (isset($article_import['REF_CONSTRUCTEUR'])) { 
							$test_ref_constructeur = new contact ($article_import['REF_CONSTRUCTEUR']);
							if ($test_ref_constructeur->getRef_contact()) {
								$ref_constructeur = $article_import['REF_CONSTRUCTEUR'];
							}
							unset ($test_ref_constructeur);
						}
						$ref_oem = '';
						if (isset($article_import['REF_OEM'])) { $ref_oem = $article_import['REF_OEM']; }
						$ref_interne = '';
						if (isset($article_import['REF_INTERNE'])) { $ref_interne = $article_import['REF_INTERNE']; }
						$variante = '';
						if (isset($article_import['VARIANTE'])) { $variante = $article_import['VARIANTE']; }
						
			
				$infos_generales['ref_art_categ'] 		= $article_import['REF_ART_CATEG'];
				$infos_generales['lib_article'] 			= htmlspecialchars_decode( $article_import['LIB_ARTICLE']);
				$infos_generales['lib_ticket']				= htmlspecialchars_decode($article_import['LIB_TICKET']);
				$infos_generales['desc_courte'] 			= htmlspecialchars_decode($article_import['DESC_COURTE']);
				$infos_generales['desc_longue'] 			= htmlspecialchars_decode($article_import['DESC_LONGUE']);
				$infos_generales['ref_interne'] 			= $ref_interne;
				$infos_generales['ref_oem'] 					= $ref_oem;
				$infos_generales['ref_constructeur'] 	= $ref_constructeur;
				$infos_generales['variante'] 					= $variante;
				$infos_generales['id_valo'] 					= $article_import['ID_VALO'];
				$infos_generales['valo_indice'] 			= $article_import['VALO_INDICE'];
				$infos_generales['lot'] 							= $article_import['LOT'];
				$infos_generales['gestion_sn'] 				= $article_import['GESTION_SN'];
				$infos_generales['code_barre'] 				= $code_barre;
				$infos_generales['id_tva'] 						= $article_import['ID_TVA'];
				$infos_generales['tva'] 							= $article_import['TVA'];
				$infos_generales['prix_public_ht'] 		= $article_import['PRIX_PUBLIC_HT'];
				$infos_generales['prix_achat_ht'] 		= "";
				$infos_generales['paa_ht'] 		= "";
				
				$infos_generales['date_debut_dispo'] 	= $article_import['DATE_DEBUT_DISPO'];
				$infos_generales['date_fin_dispo'] 		= $article_import['DATE_FIN_DISPO'];
				
				
				$formules_tarifs	=	array();
	
				$caracs	=	array();
				foreach ($import_article_carac as $article_carac) {
					if ($article_import["REF_ARTICLE"] != $article_carac["REF_ARTICLE"]) { continue; }
					$carac = new stdclass;
					$carac->ref_carac	= $article_carac['REF_CARAC'];
					$carac->valeur		= $article_carac['VALEUR'];  
					$caracs[] = $carac;	
				}
				
				$liaisons	=	array();
				
				$composants	=	array();
				
				
				// *************************************************
				// Création de l'article
				$article->create ($infos_generales, $infos_modele, $caracs, $formules_tarifs, $composants, $liaisons, $article_import["REF_ARTICLE"]);
				
				
				//import des images
				foreach ($import_article_image as $article_image) {
					if ($article_import["REF_ARTICLE"] != $article_image["REF_ARTICLE"]) { continue; }
					
					$extension = substr($article_image["LIB_FILE"], strrpos($article_image["LIB_FILE"], "."));
					
					$file_upload = $article_image["LIB_FILE"];
					if (is_file($ARTICLES_IMAGES_DIR.$file_upload)) {$file_upload = md5(uniqid(rand(), true)).$extension; }
					
          if ( (copy ($import_serveur->getUrl_serveur_import().str_replace("../", "",$ARTICLES_IMAGES_DIR).$article_image["LIB_FILE"], $ARTICLES_IMAGES_DIR.$file_upload)) && ( copy ($import_serveur->getUrl_serveur_import().str_replace("../", "",$ARTICLES_MINI_IMAGES_DIR).$article_image["LIB_FILE"], $ARTICLES_MINI_IMAGES_DIR.$file_upload)) ) {
						$article->add_image ($file_upload);
					}
				}
				
		} else {
			//************************************************************************************************************
			//on met à  jour l'article
			
			
			
			$stocks_alertes = array();
			
				$infos_generales['modele']	=	$article_import['MODELE'];
				$infos_modele = array();
					switch ($article_import['MODELE']) {
					case "materiel":
						$infos_modele['poids']	=	$article_import['POIDS'];
						$infos_modele['colisage']	=	$article_import['COLISAGE'];
						$infos_modele['duree_garantie']	=	$article_import['DUREE_GARANTIE'];
						$infos_modele['stocks_alertes']	=	$stocks_alertes;
						
						break;
					case "service":
						break;
			
					case "service_abo":
						break;
					}	
						
						$ref_constructeur = '';
						if (isset($article_import['REF_CONSTRUCTEUR'])) {
						
							$test_ref_constructeur = new contact ($article_import['REF_CONSTRUCTEUR']);
							if ($test_ref_constructeur->getRef_contact()) {
								$ref_constructeur = $article_import['REF_CONSTRUCTEUR'];
							}
							unset ($test_ref_constructeur);
						}
						$ref_oem = '';
						if (isset($article_import['REF_OEM'])) { $ref_oem = $article_import['REF_OEM']; }
						$ref_interne = '';
						if (isset($article_import['REF_INTERNE'])) { $ref_interne = $article_import['REF_INTERNE']; }
						$variante = '';
						if (isset($article_import['VARIANTE'])) { $variante = $article_import['VARIANTE']; }
						
			
				$infos_generales['ref_art_categ'] 		= $article_import['REF_ART_CATEG'];
				$infos_generales['lib_article'] 			= htmlspecialchars_decode( $article_import['LIB_ARTICLE']);
				$infos_generales['lib_ticket']				= htmlspecialchars_decode($article_import['LIB_TICKET']);
				$infos_generales['desc_courte'] 			= htmlspecialchars_decode($article_import['DESC_COURTE']);
				$infos_generales['desc_longue'] 			= htmlspecialchars_decode($article_import['DESC_LONGUE']);
				$infos_generales['ref_interne'] 			= $ref_interne;
				$infos_generales['ref_oem'] 					= $ref_oem;
				$infos_generales['ref_constructeur'] 	= $ref_constructeur;
				$infos_generales['variante'] 					= $variante;
				$infos_generales['id_valo'] 					= $article_import['ID_VALO'];
				$infos_generales['valo_indice'] 			= $article_import['VALO_INDICE'];
				$infos_generales['lot'] 							= $article_import['LOT'];
				$infos_generales['gestion_sn'] 				= $article_import['GESTION_SN'];
	
				$infos_generales['id_tva'] 						= $article_import['ID_TVA'];
				$infos_generales['tva'] 							= $article_import['TVA'];
				$infos_generales['prix_public_ht'] 		= $article_import['PRIX_PUBLIC_HT'];
				
				$infos_generales['date_debut_dispo'] 	= $article_import['DATE_DEBUT_DISPO'];
				$infos_generales['date_fin_dispo'] 		= $article_import['DATE_FIN_DISPO'];
		
				$article->modification1 ($infos_generales);
				$article->modification2 ($infos_generales, $infos_modele);
				
				foreach ($GLOBALS['_ALERTES'] as $alerte => $value) {
					echo $alerte." => ".$value."<br />";
				}
				if (count($GLOBALS['_ALERTES'])) { $GLOBALS['_ALERTES'] = array();}
				
				//import des images
				$images	=	$article->getImages();
				foreach ($import_article_image as $article_image) {
					if ($article_import["REF_ARTICLE"] != $article_image["REF_ARTICLE"]) { continue; }
					$add_img = true;
					foreach ($images as $image) {
						if ($image->lib_file == $article_image["LIB_FILE"]) {$add_img = false;}
					}
					
					if ($add_img) { 
						$file_upload = $article_image["LIB_FILE"];
						if ( (copy ($import_serveur->getUrl_serveur_import().str_replace("../", "",$ARTICLES_IMAGES_DIR).$article_image["LIB_FILE"], $ARTICLES_IMAGES_DIR.$file_upload)) && ( copy ($import_serveur->getUrl_serveur_import().str_replace("../", "",$ARTICLES_MINI_IMAGES_DIR).$article_image["LIB_FILE"], $ARTICLES_MINI_IMAGES_DIR.$file_upload)) ) {
							$article->add_image ($file_upload);
						}
					}
				}
				
				
				//on vide pour mettre à jour les caracs
				$article->del_all_carac();
				
				foreach ($import_article_carac as $article_carac) {
					if ($article_import["REF_ARTICLE"] != $article_carac["REF_ARTICLE"]) { continue; }
					$article->add_carac ($article_carac['REF_CARAC'], $article_carac['VALEUR']);
					foreach ($GLOBALS['_ALERTES'] as $alerte => $value) {
						echo $alerte." => ".$value."<br />";
					}
					if (count($GLOBALS['_ALERTES'])) { $GLOBALS['_ALERTES'] = array();}
				}
				
				//import des codes barre
				foreach ($import_article_code_barre as $article_code_barre) {
					if ($article_import["REF_ARTICLE"] != $article_code_barre["REF_ARTICLE"]) { continue; }
					$article->add_code_barre ($article_code_barre["CODE_BARRE"]);
					foreach ($GLOBALS['_ALERTES'] as $alerte => $value) {
						echo $alerte." => ".$value."<br />";
					}
					if (count($GLOBALS['_ALERTES'])) { $GLOBALS['_ALERTES'] = array();}
				}
				
		}
		
					foreach ($GLOBALS['_ALERTES'] as $alerte => $value) {
						echo $alerte." => ".$value."<br />";
					}
					foreach ($GLOBALS['_INFOS'] as $info => $value) {
						echo $info."<br />";
					}
					if (count($GLOBALS['_ALERTES'])) { $GLOBALS['_ALERTES'] = array();}
	@ob_end_flush(); 
	
	}
}

if ($_REQUEST["load_info"] == "compo") {
	@ob_start();
				echo "<br /><hr /><br />IMPORT DES COMPOSANTS ET LIAISONS <br /><br /><hr />";
	@ob_end_flush(); 
	
	
	//on refait le tour des articles importés pour insérer les liaisons et composants
	foreach ($import_article as $article_import) {
		if (count($GLOBALS['_ALERTES'])) { $GLOBALS['_ALERTES'] = array();}
		if (count($GLOBALS['_INFOS'])) {$GLOBALS['_INFOS'] = array();}
	
		$article = new article ($article_import["REF_ARTICLE"]);
		if ($article->getRef_article()) {
				
			@ob_start();

			echo "<br /><span style='font-weight:bolder'>".htmlspecialchars_decode($article_import["LIB_ARTICLE"])."</span><br />";
			
			//on vide les composants et liaisons pour pouvoir les mettre à jour une fois les articles importés (afin d'avoir les ref_articles toutes importées
			$article->del_all_composants();
			$article->del_all_liaisons();
			
			foreach ($import_article_liaison as $article_liaison) {
				if ($article_import["REF_ARTICLE"] != $article_liaison["REF_ARTICLE"]) { continue; }
				$article->add_liaison ($article_liaison['REF_ARTICLE_LIE'], $article_liaison['ID_LIAISON_TYPE']);
				echo "mise à jour des liaisons <br />";
				foreach ($GLOBALS['_ALERTES'] as $alerte => $value) {
					echo $alerte." => ".$value."<br />";
				}
				if (count($GLOBALS['_ALERTES'])) { $GLOBALS['_ALERTES'] = array();}
			}
			
			foreach ($import_article_composant as $article_composant) {
				if ($article_import["REF_ARTICLE"] != $article_composant["REF_ARTICLE"]) { continue; }
				$article->add_composant ($article_composant['REF_ARTICLE_COMPOSANT'], $article_composant['QTE'], $article_composant['NIVEAU'], $article_composant['ORDRE']);
				echo "mise à jour des composants <br />";
				foreach ($GLOBALS['_ALERTES'] as $alerte => $value) {
					echo $alerte." => ".$value."<br />";
				}
				if (count($GLOBALS['_ALERTES'])) { $GLOBALS['_ALERTES'] = array();}
			}
			
				foreach ($GLOBALS['_INFOS'] as $info => $value) {
					echo $info."<br />";
				}
			@ob_end_flush(); 
		//on met à jour la date de maj de l'art_categ
		if (isset($import_art_categ_liste[$article->getRef_art_categ()])) {
			$import_art_categ_liste[$article->getRef_art_categ()] = date("Y-m-d H:i:s", time());
		}
		}
	}
	
//on reconstitue la liste des art_categ mises à jour
$import_infos_modifiées = "";
foreach ($import_art_categ_liste as $ref => $value) {
	$import_infos_modifiées .= $ref.";".$value."\n";
}

$import_serveur->maj_import_infos (2, $import_infos_modifiées);
}

//htmlspecialchars_decode
// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_serveur_import_data_2_maj.inc.php");

?>