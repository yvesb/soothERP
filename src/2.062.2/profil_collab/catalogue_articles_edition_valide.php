<?php
// *************************************************************************************************************
// CREATION DE L'ARTICLE
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


if (isset($_REQUEST['ref_article'])) {	
	switch ($_REQUEST['step']) {
	
	//données de la description d'article
	case "0":
		// *************************************************
		// Controle des données fournies par le formulaire
		if (!isset($_REQUEST['lib_article'])) {
			$erreur = "Une variable nécessaire à la Modification de l'article n'est pas précisée.";
			alerte_dev($erreur);
		}
				
		$ref_constructeur = '';
		if (isset($_REQUEST['ref_constructeur'])) { $ref_constructeur = $_REQUEST['ref_constructeur']; }
		
		$ref_oem = '';
		if (isset($_REQUEST['ref_oem'])) { $ref_oem = $_REQUEST['ref_oem']; }
		
		$ref_interne = '';
		if (isset($_REQUEST['ref_interne'])) { $ref_interne = $_REQUEST['ref_interne']; }		
		$lib_ticket = '';
		if (isset($_REQUEST['lib_ticket'])) { $lib_ticket = $_REQUEST['lib_ticket']; }
		
		$infos_generales['lib_article'] 			= trim($_REQUEST['lib_article']);
		$infos_generales['lib_ticket']				= $lib_ticket;
		$infos_generales['desc_courte'] 			= trim($_REQUEST['desc_courte']);
		$infos_generales['desc_longue'] 			= trim($_REQUEST['desc_longue']);
		$infos_generales['ref_interne'] 			= $ref_interne;
		$infos_generales['ref_oem'] 					= $ref_oem;
		$infos_generales['ref_constructeur'] 	= $ref_constructeur;
	
		$article = new article ($_REQUEST['ref_article']);
		$article-> modification1 ($infos_generales);
	break;


	
	//données des caractéristiques
	case "1":
		$caracs	=	array();
		for ($i = 0; $i < $_REQUEST['serialisation_carac']; $i++) {
			if (!($_REQUEST['caract_value_'.$i]) || ($_REQUEST['caract_value_'.$i]=="") ) { continue; }
			$carac = new stdclass;
			$carac->ref_carac	= $_REQUEST['ref_carac_'.$i];
			$carac->valeur		= $_REQUEST['caract_value_'.$i];  
			$caracs[] = $carac;	
		}
		
		$article = new article ($_REQUEST['ref_article']);
		$article-> del_all_carac ();
		
		for ($i=0; $i<count($caracs); $i++) {
			$article->add_carac ($caracs[$i]->ref_carac, $caracs[$i]->valeur); 
		}
	break;

	
	//données de la gestion d'article
	case "2":
		
		$variante = '';
		if (isset($_REQUEST['variante'])) { $variante = $_REQUEST['variante']; }
		$lot = 0;
		if (isset($_REQUEST['lot'])) { $lot = $_REQUEST['lot']; }
		$gestion_sns = 0;
		if (isset($_REQUEST['gestion_sn'])) { $gestion_sns = $_REQUEST['gestion_sn']; }
	
		$infos_generales['variante'] 					= $variante;
		$infos_generales['id_valo'] 					= $_REQUEST['id_valo'];
		$infos_generales['valo_indice'] 			= $_REQUEST['valo_indice'];
		$infos_generales['lot'] 							= $lot;
		$infos_generales['gestion_sn'] 				= $gestion_sns;
		
		$infos_generales['date_debut_dispo'] 	= date_Fr_to_Us($_REQUEST['date_debut_dispo']);
		$infos_generales['date_fin_dispo'] 		= date_Fr_to_Us($_REQUEST['date_fin_dispo']);
		
		
		$stocks_alertes = array();
		foreach ($_REQUEST as $variable => $valeur) {
			if (substr ($variable, 0, 6) != "stock_") { continue; }
			$i = count($stocks_alertes);
			$stock_a = new stdclass;
			$stock_a->id_stock 			= substr ($variable, 6, strlen($variable));
			$stock_a->seuil_alerte 	= $valeur;
			$stocks_alertes[$i]			=	$stock_a;
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
				break;

			case "service_conso": 
				break;
			}	
		
		
		$article = new article ($_REQUEST['ref_article']);
		$article-> modification2 ($infos_generales, $infos_modele);
	break;
			
	//grille tarifaire		
	case "3":
		
		$article = new article ($_REQUEST['ref_article']);
		$prix = array();
		switch ($_REQUEST['taxation_pp']) {
			case "HT":
				$prix['prix_public_ht']	=	str_replace(",", ".", $_REQUEST['prix_public_ht']);			
				break;
			case "TTC":
				$prix['prix_public_ht']	=	str_replace(",", ".", $_REQUEST['prix_public_ht'])/ (1+$_REQUEST['tarif_tva']/100);
				break;
		}
		
		switch ($_REQUEST['taxation_pa']) {
			case "HT":
				$prix['prix_achat_ht']	=	str_replace(",", ".", $_REQUEST['prix_achat_ht']);			
				break;
			case "TTC":
				$prix['prix_achat_ht']	=	str_replace(",", ".", $_REQUEST['prix_achat_ht'])/ (1+$_REQUEST['tarif_tva']/100);
				break;
		}
		
		switch ($_REQUEST['taxation_paa']) {
			case "HT":
				$prix['paa_ht']	=	str_replace(",", ".", $_REQUEST['paa_ht']);			
				break;
			case "TTC":
				$prix['paa_ht']	=	str_replace(",", ".", $_REQUEST['paa_ht'])/ (1+$_REQUEST['tarif_tva']/100);
				break;
		}
		
		$prix['id_tva'] 	= $_REQUEST['id_tva'];
		$prix['tva'] 			= $_REQUEST['tarif_tva'];
		
		$article->maj_tva ($prix['id_tva']);
		
		$article->maj_prix_achat_actuel_ht ($prix['paa_ht']);
		if ($CALCUL_VAS != "3"  && $article->getIs_in_stock()) {
			$article->maj_prix_achat_ht ($prix['prix_achat_ht']);
		}
		$article->maj_prix_public_ht ($prix['prix_public_ht']);
		
		
		if (isset($_REQUEST['promo'])) {
			$article->maj_promo ($_REQUEST['promo']);
		} else {
			$article->maj_promo (0);
		}
		
//		$formules_tarifs	=	array();
//		
//		for ($j = 1; $j < $_REQUEST['nb_ligne_prix']; $j++) {
//			if (!isset($_REQUEST['qte_tarif_'.$j]) || !$_REQUEST['qte_tarif_'.$j]>0) { continue; }
//			for ($i = 0; $i < $_REQUEST['nb_liste_tarif']; $i++) {
//				if ($_REQUEST['formule_cree_'.$i.'_'.$j]!="0" || ($_REQUEST['qte_tarif_'.$j] != $_REQUEST['qte_tarif_old_'.$j])) {
//					// si c'est une nouvelle formule 
//					if ( $_REQUEST['qte_tarif_old_'.$j] == "newqte" && $_REQUEST['formule_cree_'.$i.'_'.$j]=="1") {
//			$article->add_formule_tarif ($_REQUEST['id_tarif_'.$i.'_'.$j], $_REQUEST['qte_tarif_'.$j], $_REQUEST['formule_tarif_'.$i.'_'.$j]);
//					// si c'est une ancienne formule mais la quantité à changé 
//					} elseif (($_REQUEST['formule_cree_'.$i.'_'.$j]=="2" && ($_REQUEST['qte_tarif_'.$j] != $_REQUEST['qte_tarif_old_'.$j])) || ($_REQUEST['formule_cree_'.$i.'_'.$j]=="1" && $_REQUEST['formule_exist_'.$i.'_'.$j]=="1")){
//			$article->delete_formule_tarif ($_REQUEST['id_tarif_'.$i.'_'.$j], $_REQUEST['qte_tarif_old_'.$j]);
//			$article->add_formule_tarif ($_REQUEST['id_tarif_'.$i.'_'.$j], $_REQUEST['qte_tarif_'.$j], $_REQUEST['formule_tarif_'.$i.'_'.$j]);
//					// si c'est une formule modifiée 
//					} elseif ($_REQUEST['formule_cree_'.$i.'_'.$j]=="1" && $_REQUEST['formule_exist_'.$i.'_'.$j]=="0"){
//			$article->add_formule_tarif ($_REQUEST['id_tarif_'.$i.'_'.$j], $_REQUEST['qte_tarif_'.$j], $_REQUEST['formule_tarif_'.$i.'_'.$j]);
//					}
//				
//				}
//			}	
//		}
	
	break;
			
	// mise à jour des composants
	case "4":
		$composants_serie = explode(",", $_REQUEST['liste_composant']);
		$composant_niveau=1;
		$composant_ordre=1;
		$niveau_vide = true;
		$article = new article ($_REQUEST['ref_article']);
		
		for ($i = 0; $i < count($composants_serie); $i++) {
			if (isset($_REQUEST['composant_niveau_'.$composants_serie[$i]])) { 
			if (!$niveau_vide){
			$composant_niveau++;
			$niveau_vide = true;
			}
			}	
			elseif (isset($_REQUEST['ref_article_composant_'.$composants_serie[$i]])) {
			$niveau_vide = false;
				if ($_REQUEST['modif_composant_'.$composants_serie[$i]]=="2") {
					$article->add_composant ($_REQUEST['ref_article_composant_'.$composants_serie[$i]], $_REQUEST['qte_composant_'.$composants_serie[$i]], $composant_niveau, $composant_ordre);
					
				}
				if ($_REQUEST['modif_composant_'.$composants_serie[$i]]=="1") {
					$article->maj_composant ($_REQUEST['ref_lot_contenu_'.$composants_serie[$i]], $_REQUEST['qte_composant_'.$composants_serie[$i]], $composant_niveau);
				}
				
				if ($_REQUEST['modif_ordre_composant_'.$composants_serie[$i]]=="1") {
					$article->maj_composant ($_REQUEST['ref_lot_contenu_'.$composants_serie[$i]], $_REQUEST['qte_composant_'.$composants_serie[$i]], $composant_niveau);
					$article->composant_maj_ordre ($_REQUEST['ref_lot_contenu_'.$composants_serie[$i]], $composant_ordre);
				}
				
			$composant_ordre++;
			}
		}
		
		
	break;
	
	//images
	case "5":
		$article = new article ($_REQUEST['ref_article']);
	break;
			
			
			
//les liaisons sont mise à jour à la volée
	
	case "8":
		$article = new article ($_REQUEST['ref_article']);
		$article->call_maj_all_tarifs();
	break;
	
	}

}

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_catalogue_articles_edition_valide.inc.php");

?>
