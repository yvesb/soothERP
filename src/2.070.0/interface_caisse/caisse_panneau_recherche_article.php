<?php
// *************************************************************************************************************
// PANNEAU AFFICHE EN BAS DE L'INTERFACE DE CAISSE
// *************************************************************************************************************

require ("_dir.inc.php");
require ("_profil.inc.php");
require ("_session.inc.php");

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************


/*
if(!isset($_REQUEST["art_page_to_show_s"])){
	echo "art_page_to_show_s n'est pas spécifié";
	exit; 
}
$art_page_to_show_s = $_REQUEST["art_page_to_show_s"];

if(!isset($_REQUEST["categ_sous_page_to_show_s"])){
	echo "categ_sous_page_to_show_s n'est pas spécifié";
	exit; 
}
$categ_sous_page_to_show_s = $_REQUEST["categ_sous_page_to_show_s"];

if(!isset($_REQUEST["categ_racine_page_to_show_s"])){
	echo "categ_racine_page_to_show_s n'est pas spécifié";
	exit; 
}
$categ_racine_page_to_show_s = $_REQUEST["categ_racine_page_to_show_s"];
*/

$art_categs_racine = array();
//$art_categs_fille = array();

$art_categs_racine = get_child_obj_categories("", 0);

/*
$ref_art_categ_racine_selected = "";

if(!(isset($_REQUEST["art_lib_s"]) && $_REQUEST["art_lib_s"]!="")){
	$ref_art_categ_fille_selected = "";
	
	if(isset($_REQUEST["categ_ref_selected_s"]) && $_REQUEST["categ_ref_selected_s"]!=""){
		$art_categ_tmp = new art_categ($_REQUEST["categ_ref_selected_s"]);
		
		if($art_categ_tmp->getRef_art_categ_parent() == ""){
			$ref_art_categ_racine_selected =  $art_categ_tmp->getRef_art_categ();
		}else{
			$ref_art_categ_racine_selected = $art_categ_tmp->getRef_art_categ_parent();
			$ref_art_categ_fille_selected = $art_categ_tmp->getRef_art_categ();
		}
		unset($art_categ_tmp);
	}
	
	if ($ref_art_categ_racine_selected != "")
	{	$art_categs_fille = get_child_obj_categories($ref_art_categ_racine_selected, 0);}
}
*/

if(isset($_REQUEST["select_racine_art_categs"]) && $_REQUEST["select_racine_art_categs"] == 1){
	$art_categs_racine_selected = $art_categs_racine[0][0]->getRef_art_categ();
	$NoHeader_caisse_panneau_recherche_article = true;
	$NoHeader_caisse_panneau_recherche_articles_result = true;
}else{
	$art_categs_racine_selected = "";
	$NoHeader_caisse_panneau_recherche_article = false;
	$NoHeader_caisse_panneau_recherche_articles_result = false;
        $t_articles = article::_getArticles_fav();
}

include ($DIR.$_SESSION['theme']->getDir_theme()."page_caisse_panneau_recherche_article.inc.php");

?>