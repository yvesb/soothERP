<?php
// *************************************************************************************************************
// ARTICLE GESTION DES REF EXTERNES FOURNISSEURS
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

//**************************************
// Controle

if (!isset($_REQUEST['ref_article'])) {
	echo "La référence de l'article n'est pas précisée";
	exit;
}

$article = new article ($_REQUEST['ref_article']);
if (!$article->getRef_article()) {
	echo "La référence de l'article est inconnue";		exit;

}
//chargement des ref_externes
$ref_externes	=	$article->getRef_externes();
foreach ($ref_externes as $ref_ext) {
	if ($ref_ext->ref_fournisseur == $_REQUEST["ref_fournisseur"] && string2ref($ref_ext->ref_article_externe) == string2ref($_REQUEST["ref_article_externe"])) {
		$this_ref = $ref_ext;
	}
}



// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_catalogue_articles_view_ref_externes_mod.inc.php");

?>