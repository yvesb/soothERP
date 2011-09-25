<?php
// *************************************************************************************************************
// CREATION DE L'ARTICLE
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");



if (isset($_REQUEST['create_article'])) {	
	// *************************************************
	// Controle des données fournies par le formulaire
	if (!isset($_REQUEST['ref_art_categ']) || !isset($_REQUEST['modele']) || !isset($_REQUEST['lib_article'])) {
		$erreur = "Une variable nécessaire à la création de l'article n'est pas précisée.";
		alerte_dev($erreur);
	}

$stocks_alertes = array();
foreach ($_REQUEST as $variable => $valeur) {
	if (substr ($variable, 0, 6) != "stock_") { continue; }
	$i = count($stocks_alertes);
	$id_stock = substr ($variable, 6, strlen($variable));
	$stock_a = new stdclass;
	$stock_a->id_stock 			= $id_stock;
	$stock_a->seuil_alerte 	= $valeur;
	$stock_a->emplacement 	= $_REQUEST['emplacement_stock_'.$id_stock];
	$stocks_alertes[$i]			=	$stock_a;

}


$taxes_applicables = array();
foreach ($_REQUEST as $variable => $valeur) {
	if (substr ($variable, 0, 9) != "taxe_chk_") { continue; }
	$i = count($taxes_applicables);
	$taxes_a = new stdclass;
	$taxes_a->id_taxe 			= substr ($variable, 9, strlen($variable));
	$taxes_a->code_taxe 		= $valeur;
	$taxes_a->info_calcul 	= "";
	if (isset($_REQUEST["taxe_info_calcul_".substr ($variable, 9, strlen($variable))])) {
		$taxes_a->info_calcul 	= $_REQUEST["taxe_info_calcul_".substr ($variable, 9, strlen($variable))];
	}
	$taxes_a->montant_taxe 	= "";
	if (isset($_REQUEST["taxe_".substr ($variable, 9, strlen($variable))])) {
		$taxes_a->montant_taxe 	= $_REQUEST["taxe_".substr ($variable, 9, strlen($variable))];
	}
	$taxes_applicables[$i]	=	$taxes_a;
}


$code_barre = array();
foreach ($_REQUEST as $variable => $valeur) {
	if (substr ($variable, 0, 10) != "code_barre") { continue; }
	$code_barre[] = $valeur;
}


	$infos_generales['modele']	=	$_REQUEST['modele'];
	$infos_modele = array();
		switch ($_REQUEST['modele']) {
		case "materiel":
			$infos_modele['poids']	=	$_REQUEST['poids'];
			$infos_modele['colisage']	=	$_REQUEST['colisage'];
			$infos_modele['duree_garantie']	=	$_REQUEST['dure_garantie'];
			$infos_modele['stocks_alertes']	=	$stocks_alertes;
			break;
		case "service":
			break;

		case "service_abo": 
			$duree_abo_mois				=	$_REQUEST['duree_abo_mois'];
			$duree_abo_jour				=	$_REQUEST['duree_abo_jour'];
			$duree_abo = (($duree_abo_mois*30)+($duree_abo_jour))*24*3600;
			
			$preavis_abo_mois				=	$_REQUEST['preavis_abo_mois'];
			$preavis_abo_jour				=	$_REQUEST['preavis_abo_jour'];
			$preavis_abo = (($preavis_abo_mois*30)+($preavis_abo_jour))*24*3600;
	
			$infos_modele['duree']	=	$duree_abo;
			$infos_modele['engagement']	=	$_REQUEST['engagement'];
			$infos_modele['reconduction']	=	$_REQUEST['reconduction'];
			$infos_modele['preavis']	=	$preavis_abo;
			break;

		case "service_conso": 
			$duree_validite_mois				=	$_REQUEST['duree_validite_mois'];
			$duree_validite_jour				=	$_REQUEST['duree_validite_jour'];
			$duree_validite = (($duree_validite_mois*30)+($duree_validite_jour))*24*3600;
			$infos_modele['duree_validite']	=	$duree_validite;
			$infos_modele['nb_credits']	=	$_REQUEST['nb_credits'];
		break;
		}	
			
		$ref_constructeur = '';
		if (isset($_REQUEST['ref_constructeur'])) { $ref_constructeur = $_REQUEST['ref_constructeur']; }
		$ref_oem = '';
		if (isset($_REQUEST['ref_oem'])) { $ref_oem = $_REQUEST['ref_oem']; }
		$ref_interne = '';
		if (isset($_REQUEST['ref_interne'])) { $ref_interne = $_REQUEST['ref_interne']; }
		$lib_ticket = '';
		if (isset($_REQUEST['lib_ticket'])) { $lib_ticket = $_REQUEST['lib_ticket']; }
		$variante = '';
		if (isset($_REQUEST['variante'])) { $variante = $_REQUEST['variante']; }
		$lot = 0;
		if (isset($_REQUEST['lot'])) { $lot = $_REQUEST['lot']; }
		$gestion_sns = 0;
		if (isset($_REQUEST['gestion_sn'])) { $gestion_sns = $_REQUEST['gestion_sn']; }
			

	$infos_generales['ref_art_categ']                       = $_REQUEST['ref_art_categ'];
	$infos_generales['lib_article'] 			= trim($_REQUEST['lib_article']);
	$infos_generales['lib_ticket']				= $lib_ticket;
	$infos_generales['desc_courte'] 			= trim($_REQUEST['desc_courte']);
	$infos_generales['desc_longue'] 			= trim($_REQUEST['desc_longue']);
	$infos_generales['tags']				= trim(str_replace("'", "\'", $_REQUEST['tags']));
	$infos_generales['ref_interne'] 			= $ref_interne;
	$infos_generales['ref_oem'] 				= $ref_oem;
	$infos_generales['ref_constructeur']                    = $ref_constructeur;
	$infos_generales['variante'] 				= $variante;
	$infos_generales['id_valo'] 				= $_REQUEST['id_valo'];
	$infos_generales['valo_indice'] 			= $_REQUEST['valo_indice'];
	$infos_generales['lot'] 				= $lot;
	$infos_generales['gestion_sn'] 				= $gestion_sns;
	$infos_generales['code_barre'] 				= $code_barre;
	$infos_generales['id_tva'] 				= $_REQUEST['id_tva'];
	$infos_generales['tva'] 				= $_REQUEST['tarif_tva'];
	
	$infos_generales['date_debut_dispo']                    = date_Fr_to_Us($_REQUEST['date_debut_dispo']);
	$infos_generales['date_fin_dispo']                      = date_Fr_to_Us($_REQUEST['date_fin_dispo']);
	
	switch ($_REQUEST['taxation_pp']) {
		case "HT":
			$infos_generales['prix_public_ht']	=	str_replace(",", ".", $_REQUEST['prix_public_ht']);			
			break;
		case "TTC":
			$infos_generales['prix_public_ht']	=	str_replace(",", ".", $_REQUEST['prix_public_ht'])/ (1+$_REQUEST['tarif_tva']/100);
			break;
	}
	
	$infos_generales['prix_achat_ht']	= $_REQUEST['prix_achat_ht'];			
	
	switch ($_REQUEST['taxation_paa']) {
		case "HT":
			$infos_generales['paa_ht']	=	str_replace(",", ".", $_REQUEST['paa_ht']);			
			break;
		case "TTC":
			$infos_generales['paa_ht']	=	str_replace(",", ".", $_REQUEST['paa_ht'])/ (1+$_REQUEST['tarif_tva']/100);
			break;
	}
	
	$formules_tarifs	=	array();
	
	for ($i = 0; $i < $_REQUEST['nb_liste_tarif']; $i++) {
		$formule_tarif = new stdclass;
		$formule_tarif->id_tarif = $_REQUEST['id_tarif_'.$i.'_0'];
		$formule_tarif->indice_qte = 0;
		$formule_tarif->formule_tarif = $_REQUEST['formule_tarif_'.$i.'_0'];
		$formules_tarifs[] = $formule_tarif;	
	}
	for ($j = 1; $j < $_REQUEST['nb_ligne_prix']; $j++) {
		if (!isset($_REQUEST['qte_tarif_'.$j]) || !$_REQUEST['qte_tarif_'.$j]>0) { continue; }
		for ($i = 0; $i < $_REQUEST['nb_liste_tarif']; $i++) {
			if ($_REQUEST['formule_cree_'.$i.'_'.$j]!="0") {
			echo  $_REQUEST['id_tarif_'.$i.'_'.$j]."<br />";
				$formule_tarif = new stdclass;
				$formule_tarif->id_tarif = $_REQUEST['id_tarif_'.$i.'_'.$j];
				$formule_tarif->indice_qte = $_REQUEST['qte_tarif_'.$j];
				$formule_tarif->formule_tarif = $_REQUEST['formule_tarif_'.$i.'_'.$j];
				$formules_tarifs[] = $formule_tarif;	
			} 
		}	
	}
		
	$caracs	=	array();
	for ($i = 0; $i < $_REQUEST['serialisation_carac']; $i++) {
		if (!($_REQUEST['caract_value_'.$i]) || ($_REQUEST['caract_value_'.$i]=="")) { continue; }
		$carac = new stdclass;
		$carac->ref_carac	= $_REQUEST['ref_carac_'.$i];
    $carac->valeur		= $_REQUEST['caract_value_'.$i];  
    $caracs[] = $carac;	
	}
	
	
	//gestion de la création d'articles variantes
	//cette article de par ses carac peut générer des variantes
	if (isset($_REQUEST['indentations_variantes'])) {
		$variantes	=	array();
		for ($i = 0; $i < $_REQUEST['indentations_variantes']; $i++) {
			if (!isset($_REQUEST['variante_valide_'.$i])) { continue; }
			$variante = new stdclass;
			$variante->caracs = array();
			foreach ($caracs as $tmp_carac) {
				if (!isset($_REQUEST['variante_carac_'.$tmp_carac->ref_carac.'_'.$i])) {continue;}
				$variante->caracs[$tmp_carac->ref_carac]	= $_REQUEST['variante_carac_'.$tmp_carac->ref_carac.'_'.$i];
			}
			if (!count($variante->caracs)) {continue;}
			if (isset($_REQUEST['variante_codebarre_'.$i]) && $_REQUEST['variante_codebarre_'.$i] && $_REQUEST['variante_codebarre_'.$i] != "Code barre") {
				$variante->code_barre = $_REQUEST['variante_codebarre_'.$i];
			}
			$variantes[] = $variante;	
			unset($variante);
		}
		
		if (count($variantes)) {
			//cet article sera le maitre des variantes
			$infos_generales['variante'] 					= "2";
			//RAZ d'infos plus utiles
			$infos_generales['code_barre'] 				= array();
		} else {
			$GLOBALS['_ALERTES']['no_variantes_selected'] = 1;
		}
	}
	
	
	
	$liaisons_vers	=	array();
	$liaisons_depuis	=	array();
	for ($i = 0; $i < $_REQUEST['serialisation_liaison']; $i++) {
		if (!isset($_REQUEST['ref_article_A_'.$i]) || !isset($_REQUEST['ref_article_B_'.$i]))  { continue; }
		if(	$_REQUEST['ref_article_A_'.$i] == "REF_NOUVEL_ARTICLE" &&
				$_REQUEST['ref_article_B_'.$i] != ""){
			$liais = new stdclass;
			$liais->ref_article	= $_REQUEST['ref_article_B_'.$i];
	    $liais->id_type_liaison	= $_REQUEST['id_liaison_type_'.$i];
	    $liais->ratio = $_REQUEST['ratio_'.$i];
	    $liaisons_depuis[] = $liais;
		}elseif(	$_REQUEST['ref_article_A_'.$i] != "" &&
							$_REQUEST['ref_article_B_'.$i] == "REF_NOUVEL_ARTICLE"){
			$liais = new stdclass;
			$liais->ref_article	= $_REQUEST['ref_article_A_'.$i];
	    $liais->id_type_liaison	= $_REQUEST['id_liaison_type_'.$i];
	    $liais->ratio = $_REQUEST['ratio_'.$i];
	    $liaisons_vers[] = $liais;
		}
	}
	
	$composants	=	array();
	$composants_serie = explode(",", $_REQUEST['liste_composant']);
	$composant_niveau=1;
	$composant_ordre=1;
	for ($i = 0; $i < count($composants_serie); $i++) {
		if (isset($_REQUEST['composant_niveau_'.$composants_serie[$i]])) { 
		$composant_niveau	=	$composant_niveau+1;
		}	elseif (isset($_REQUEST['ref_article_composant_'.$composants_serie[$i]])) {
		$compo = new stdclass;
		$compo->ref_article	= $_REQUEST['ref_article_composant_'.$composants_serie[$i]];
    $compo->qte	= $_REQUEST['qte_composant_'.$composants_serie[$i]];  
    $compo->niveau	= $composant_niveau;
    $compo->ordre	= $composant_ordre;
		$composant_ordre++;
    $composants[] = $compo;
		unset($compo);
		}
	}
	
	
	if (count($_ALERTES) == 0) {
		// *************************************************
		// Création de l'article
		$article = new article ();
		$article->create ($infos_generales, $infos_modele, $caracs, $formules_tarifs, $composants, $liaisons_vers, "", $_REQUEST['is_achetable'], $_REQUEST['is_vendable']);
		
		foreach ($liaisons_depuis as $liaison_depuis){
			$tmp_article = new article($liaison_depuis->ref_article);
			$tmp_article->add_liaison($article->getRef_article(), $liaison_depuis->id_type_liaison, $liaison_depuis->ratio);
			unset($tmp_article);
		}
	}
	if (count($_ALERTES) == 0) {
		
		// $ratio force la taille soit en hauteur soit en largeur 
		$ratio = $ARTICLE_IMAGE_MINIATURE_RATIO;  
		
		// on teste si le formulaire permettant d'uploader un fichier a été soumis  
		if ($article->getRef_article()) {
			for ($i = 1; $i <= $_REQUEST["increment_images"] ; $i++) {
				if (!isset($_FILES['image_'.$i]) || !isset($_REQUEST["url_img_".$i])) { continue; }
				// on teste si le champ permettant de soumettre un fichier est vide ou non 
				if (empty($_FILES['image_'.$i]['tmp_name']) && $_REQUEST["url_img_".$i] == "") { 
					 // si oui, on affiche un petit message d'erreur 
					 $erreur = 'Aucun fichier envoyé.'; 
				} 
				else { 
					 // on examine le fichier uploadé 
					 if (empty($_FILES['image_'.$i]['tmp_name']) && $_REQUEST["url_img_".$i] != "" && strlen($_REQUEST["url_img_".$i]) < 256){
						 $tableau = @getimagesize($_REQUEST["url_img_".$i]);  
					 } else {
						 $tableau = @getimagesize($_FILES['image_'.$i]['tmp_name']); 
					 }
					 
					 if ($tableau == FALSE) { 
							// si le fichier uploadé n'est pas une image, on efface le fichier uploadé et on affiche un petit message d'erreur 
							if (!empty($_FILES['image_'.$i]['tmp_name'])) {unlink($_FILES['image_'.$i]['tmp_name']); }
							$erreur = 'Votre fichier n\'est pas une image.'; 
					 } 
					 else { 
							// on teste le type de notre image : gif, jpeg ou png 
							if ($tableau[2] == 1 || $tableau[2] == 2 || $tableau[2] == 3) { 
								 // si on a déjà un fichier qui porte le même nom que le fichier que l'on tente d'uploader, on modifie le nom du fichier que l'on upload 
								 if (!empty($_FILES['image_'.$i]['tmp_name'])) {
								 $extension = substr($_FILES["image_".$i]["name"], strrpos($_FILES["image_".$i]["name"], "."));
								 } else {
								 $extension = substr($_REQUEST["url_img_".$i], strrpos($_REQUEST["url_img_".$i], "."));
								 }
								 $file_upload = md5(uniqid(rand(), true)).$extension;
								 if (is_file($ARTICLES_IMAGES_DIR.$file_upload)) {$file_upload = md5(uniqid(rand(), true)).$extension; }
								 
			
								 // on copie le fichier que l'on vient d'uploader dans le répertoire des images de grande taille 
								 if (!empty($_FILES['image_'.$i]['tmp_name'])) {
									copy ($_FILES['image_'.$i]['tmp_name'], $ARTICLES_IMAGES_DIR.$file_upload); 
								 } else {
									copy ($_REQUEST["url_img_".$i], $ARTICLES_IMAGES_DIR.$file_upload); 
								 }
			
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
										imagegif ($im, $ARTICLES_MINI_IMAGES_DIR.$file_upload); 
								 } 
							} 
							else { 
								 // si notre image n'est pas de type jpeg ou png, on supprime le fichier uploadé et on affiche un petit message d'erreur 
								 unlink($_FILES['image_'.$i]['tmp_name']); 
								 $erreur = 'Votre image est d\'un format non supporté.'; 
							} 
					 } 
				}  
			if (isset($file_upload)) {
				$article->add_image ($file_upload);
				unset($file_upload);
			}
			}  
		}
		
	}
	if (isset ($variantes) && count($variantes)) {
		$article->generer_variantes ($variantes);
	}
	
	foreach ($taxes_applicables as $taxe_app) {
		if ($taxe_app->montant_taxe) {
			$article->maj_montant_taxe ($taxe_app->id_taxe, $taxe_app->montant_taxe);
		} else {
			$article->add_taxe ($taxe_app->id_taxe, $taxe_app->code_taxe, $taxe_app->info_calcul);
		}
	}
	
}

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_catalogue_articles_create.inc.php");

?>