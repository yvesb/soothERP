<?php
// *************************************************************************************************************
// MAJ LINE_QTE D'UNE LIGNE D'UN DOCUMENT
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

if (!isset($_REQUEST['ref_article'])) {
	echo "La référence des l'article n'est pas spécifiée";
	exit;
}
$ref_article = $_REQUEST['ref_article'];

if (!isset($_REQUEST['ref_doc_line'])) {
	echo "La référence de la ligne du document n'est pas spécifiée";
	exit;
}
$ref_doc_line = $_REQUEST['ref_doc_line'];
	
if (!isset($_REQUEST['cible'])) {
	echo "La cible n'est pas spécifiée";
	exit;
}
$cible = $_REQUEST['cible'];

$article = new article($ref_article);
$id_valo = $article->getId_valo();
$indice_valo = $article->getValo_indice();


switch ($id_valo) {
	case 9: //SURFACE
		include ($DIR.$_SESSION['theme']->getDir_theme()."page_documents_line_calcul_qte_surface.inc.php");
		break;
	case 10: //VOLUME m3
		include ($DIR.$_SESSION['theme']->getDir_theme()."page_documents_line_calcul_qte_volume.inc.php");
		break;
	case 11: //VOLUME L
		include ($DIR.$_SESSION['theme']->getDir_theme()."page_documents_line_calcul_qte_volume.inc.php");
		break;
	default:{ //GENERIQUE
		$tab = $article->getColisage();
		if(count($tab)>0){
			$collisages = explode(";",$tab);
			include ($DIR.$_SESSION['theme']->getDir_theme()."page_documents_line_calcul_qte.inc.php");
		}else{
			echo "<br/>Le collisage n'est pas renseigné pour cet article.";
			
		}
		break;}
}
?>