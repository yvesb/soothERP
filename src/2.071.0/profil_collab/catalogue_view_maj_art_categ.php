<?php
// *************************************************************************************************************
// CREATION DE L'ARTICLE
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

if (isset($_REQUEST['mod_ref_article'])) {	

	$article = new article ($_REQUEST['mod_ref_article']);
	
	$stocks_alertes = array();
//	foreach ($_REQUEST as $variable => $valeur) {
//		if (substr ($variable, 0, 8) != "m_stock_") { continue; }
//		$i = count($stocks_alertes);
//		$stock_a = new stdclass;
//		$stock_a->id_stock 			= substr ($variable, 8, strlen($variable));
//		$stock_a->seuil_alerte 	= $valeur;
//		$stocks_alertes[$i]			=	$stock_a;
//	}
	
	
	$infos_modele = array();
	$infos_modele['modele']	=	$_REQUEST['mod_modele'];
		switch ($_REQUEST['mod_modele']) {
		case "materiel":
			$infos_modele['poids']	=	$_REQUEST['m_poids'];
			$infos_modele['colisage']	=	$_REQUEST['m_colisage'];
			$infos_modele['duree_garantie']	=	$_REQUEST['m_dure_garantie'];
			$infos_modele['stocks_alertes']	=	$stocks_alertes;
			
			break;
		case "service":
			break;

		case "service_abo":
			$duree_abo_mois				=	$_REQUEST['m_duree_abo_mois'];
			$duree_abo_jour				=	$_REQUEST['m_duree_abo_jour'];
			$duree_abo = (($duree_abo_mois*30)+($duree_abo_jour))*24*3600;
			
			$preavis_abo_mois				=	$_REQUEST['m_preavis_abo_mois'];
			$preavis_abo_jour				=	$_REQUEST['m_preavis_abo_jour'];
			$preavis_abo = (($preavis_abo_mois*30)+($preavis_abo_jour))*24*3600;
	
			$infos_modele['duree']	=	$duree_abo;
			$infos_modele['engagement']	=	$_REQUEST['m_engagement'];
			$infos_modele['reconduction']	=	$_REQUEST['m_reconduction'];
			$infos_modele['preavis']	=	$preavis_abo;
			break;

		case "service_conso": 
			$duree_validite_mois				=	$_REQUEST['m_duree_validite_mois'];
			$duree_validite_jour				=	$_REQUEST['m_duree_validite_jour'];
			$duree_validite = (($duree_validite_mois*30)+($duree_validite_jour))*24*3600;
			$infos_modele['duree_validite']	=	$duree_validite;
			$infos_modele['nb_credits']	=	$_REQUEST['nb_credits'];
		break;
		}	
	
	
	$article-> maj_categorie ($_REQUEST['mod_ref_art_categ'], $infos_modele);
	
}

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_catalogue_articles_view_maj_art_categ.inc.php");

?>
