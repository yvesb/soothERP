<?php
// *************************************************************************************************************
// EDITION DE L'ARTICLE EN MODE VISUALISATION
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


if (isset($_REQUEST['ref_article'])) {	
	switch ($_REQUEST['step']) {
	
	//données de l'onglet options avancées
	case "0":
		// *************************************************
		// Controle des données fournies par le formulaire
		if (!isset($_REQUEST['lib_article'])) {
			$erreur = "Une variable nécessaire à la Modification de l'article n'est pas précisée.";
			alerte_dev($erreur);
		}
		$lib_ticket = '';
		if (isset($_REQUEST['lib_ticket'])) { $lib_ticket = $_REQUEST['lib_ticket']; }
		
		$infos_generales['lib_article'] 			= trim(str_replace("&curren;", "€", $_REQUEST['lib_article']));
		$infos_generales['lib_ticket']				= str_replace("&curren;", "€", $lib_ticket);
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
	
		$article = new article ($_REQUEST['ref_article']);
		$article-> modification_view_0 ($infos_generales);
		$article->maj_restriction($_REQUEST['is_achetable'], $_REQUEST['is_vendable']);
	break;


	
	//données des caractéristiques
	case "1":
		echo "STEP = 1 <br />";
		$caracs	=	array();
		for ($i = 0; $i < $_REQUEST['serialisation_carac']; $i++) {
			if (!($_REQUEST['caract_value_'.$i]) || ($_REQUEST['caract_value_'.$i]=="") ) { continue; }
			$carac = new stdclass;
			$carac->ref_carac	= $_REQUEST['ref_carac_'.$i];
			$carac->valeur		= $_REQUEST['caract_value_'.$i];  
			$caracs[] = $carac;
		}
		
		print_r($caracs);
		echo "FIN CARACS<br /><br />";
		
		// Article enfant
		if(isset($_REQUEST['ref_article_origine'])){
			$ref_article = $_REQUEST['ref_article_origine'];
			$article = new article ($ref_article);
			
			// Modification de l'article choisi
			for ($i=0; $i<count($caracs); $i++) {
				foreach($article->getCaracs() as $carac){
					if($carac->ref_carac == $caracs[$i]->ref_carac && $carac->variante== 0){
						$article-> del_carac($caracs[$i]->ref_carac);
						$article->add_carac ($caracs[$i]->ref_carac, $caracs[$i]->valeur);
					}
				} 
			}
			
			$article_parent = new article ($_REQUEST['ref_article']);
			// On modifie aussi l'article parent et les autres variantes
			if($_REQUEST['apply_change'] == 2){
				for ($i=0; $i<count($caracs); $i++) {
					foreach($article_parent->getCaracs() as $carac){
						if($carac->ref_carac == $caracs[$i]->ref_carac && $carac->variante== 0){
							$article_parent->del_carac($caracs[$i]->ref_carac);
							$article_parent->add_carac($caracs[$i]->ref_carac, $caracs[$i]->valeur);
						}
					}
				}
				
				// On modifie aussi les autres variantes
				foreach($article_parent->getVariante_slaves() as $slave){
					if($slave->ref_article_lie != $article->getRef_article()){
						$article_slave = new article($slave->ref_article_lie);
						
						for ($i=0; $i<count($caracs); $i++) {
							foreach($article_slave->getCaracs() as $carac){
								if($carac->ref_carac == $caracs[$i]->ref_carac && $carac->variante== 0){
									$article_slave->del_carac($carac->ref_carac);
									$article_slave->add_carac($caracs[$i]->ref_carac, $caracs[$i]->valeur);
								}
							}
						}
					}
				}
			}
			
		// Article parent
		}else{
			$ref_article = $_REQUEST['ref_article'];
			$article = new article ($ref_article);
			
			// Modification de l'article choisi
			$article->del_all_carac();
			for ($i=0; $i<count($caracs); $i++) {
				foreach($article->getCaracs() as $carac){
					if($carac->ref_carac == $caracs[$i]->ref_carac){
						echo "Ajout de la carac : " . $caracs[$i]->ref_carac . " pour l'article : " . $ref_article . "<br />";
						$article->add_carac ($caracs[$i]->ref_carac, $caracs[$i]->valeur);
					}
				} 
			}
			
			// On modifie aussi l'article parent et les autres variantes
			if($_REQUEST['apply_change'] == 2){
				// On modifie aussi les autres variantes
				foreach($article->getVariante_slaves() as $slave){
					if($slave->ref_article_lie != $article->getRef_article()){
						$article_slave = new article($slave->ref_article_lie);
						
						for ($i=0; $i<count($caracs); $i++) {
							foreach($article_slave->getCaracs() as $carac){
								if($carac->ref_carac == $caracs[$i]->ref_carac && $carac->variante== 0){
									echo "Ajout de la carac : " . $caracs[$i]->ref_carac . " pour l'article : " . $slave->ref_article_lie . "<br />";
									$article_slave->del_carac($carac->ref_carac);
									$article_slave->add_carac($caracs[$i]->ref_carac, $caracs[$i]->valeur);
								}
							}
						}
					}
				}
			}
		}
		
		// Cet article de par ses carac peut générer des variantes
		if (isset($_REQUEST['indentations_variantes'])) {
			$variantes	=	array();
			for ($i = 0; $i < $_REQUEST['indentations_variantes']; $i++) {
				if (!isset($_REQUEST['variante_valide_'.$i])) { continue; }
				$variante = new stdclass;
				$variante->caracs = array();
				foreach ($caracs as $tmp_carac) {
					if (!isset($_REQUEST['variante_carac_'.$tmp_carac->ref_carac.'_'.$i])) {continue;}
					$variante->caracs[$tmp_carac->ref_carac] = $_REQUEST['variante_carac_'.$tmp_carac->ref_carac.'_'.$i];
				}
				if (!count($variante->caracs)) {continue;}
				if (isset($_REQUEST['variante_codebarre_'.$i]) && $_REQUEST['variante_codebarre_'.$i] && $_REQUEST['variante_codebarre_'.$i] != "Code barre") {
					$variante->code_barre = $_REQUEST['variante_codebarre_'.$i];
				}
				$variantes[] = $variante;	
			}
			if (isset ($variantes) && count($variantes)) {
				$article->generer_variantes ($variantes);
			}
		}
	break;

	
	//données de  l'onglet informations principales
	case "2":
		
		$ref_constructeur = '';
		if (isset($_REQUEST['ref_constructeur'])) { $ref_constructeur = $_REQUEST['ref_constructeur']; }
		
		$ref_oem = '';
		if (isset($_REQUEST['ref_oem'])) { $ref_oem = $_REQUEST['ref_oem']; }
		
		$ref_interne = '';
		if (isset($_REQUEST['ref_interne'])) { $ref_interne = $_REQUEST['ref_interne']; }
		
		$infos_generales['desc_courte'] 			= trim($_REQUEST['desc_courte']);
		$infos_generales['ref_interne'] 			= $ref_interne;
		$infos_generales['ref_oem'] 					= $ref_oem;
		$infos_generales['ref_constructeur'] 	= $ref_constructeur;
		if (isset($_REQUEST['tags'])) {
			$infos_generales['tags'] 			= str_replace("'", "\'",trim($_REQUEST['tags']));
		}
		
		$article = new article ($_REQUEST['ref_article']);
		$article-> modification_view_1 ($infos_generales);
	break;
			
	//modeles		
	case "3":
		
		$infos_generales['modele']	=	$_REQUEST['modele'];
		$infos_modele = array();
			switch ($_REQUEST['modele']) {
			case "materiel":
				$infos_modele['poids']	=	$_REQUEST['poids'];
				$infos_modele['colisage']	=	$_REQUEST['colisage'];
				$infos_modele['duree_garantie']	=	$_REQUEST['dure_garantie'];
				$infos_modele['stocks_alertes']	=	array();
				
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
		
		
		$article = new article ($_REQUEST['ref_article']);
		$article-> modification_view_2 ($infos_generales, $infos_modele);
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
	
	
	}

}

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_catalogue_articles_view_valide.inc.php");

?>
