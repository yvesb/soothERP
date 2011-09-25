<?php
// *************************************************************************************************************
// 
// *************************************************************************************************************

if(isset($NoHeader_caisse_panneau_recherche_article)){
	if(!isset($art_categs_racine_selected)){
		echo "La catégorie fille n'est pas spécifiée";
		exit; 
	}
}else{
	
	require ("_dir.inc.php");
	require ("_profil.inc.php");
	require ("_session.inc.php");

	if(!isset($_REQUEST["art_categs_racine_selected"])){
		echo "La catégorie fille n'est pas spécifiée";
		exit; 
	}
	$art_categs_racine_selected = $_REQUEST["art_categs_racine_selected"];
}

$art_categs_fille = get_child_obj_categories($art_categs_racine_selected, 0);


// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_caisse_panneau_recherche_article_sous_categs.inc.php");

?>