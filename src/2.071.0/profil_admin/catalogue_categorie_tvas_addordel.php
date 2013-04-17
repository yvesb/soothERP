<?php
// *************************************************************************************************************
// ACCUEIL DE L'UTILISATEUR ADMINISTRATEUR
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");




if (isset($_REQUEST['ref_art_categ'])) {
	
	$art_categ = new art_categ ($_REQUEST['ref_art_categ']);
	
	$tvas = get_tvas($_REQUEST['tva_id_pays']);
	
// supprimer toutes les tva ayant le même pays
		foreach ($tvas  as $tva){
				
		$resu	=	$art_categ->supprimer_tva ($tva['id_tva']);
		
		}
//ajouter la TVA choisie si pas vide
		
		if ($_REQUEST['tva_'.$_REQUEST['tva_id_pays']]!="tva_non_applicable") {
			$art_categ->ajouter_tva ($_REQUEST['tva_'.$_REQUEST['tva_id_pays']]);
		}
	
}




// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

?>ok