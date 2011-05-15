<?php
// *************************************************************************************************************
// CATALOGUE CLIENT PANIER RESUME
// *************************************************************************************************************


require("_dir.inc.php");
require ("_profil.inc.php");
require ("_session.inc.php");


$type_of_line = "article";
if (isset($_REQUEST['type_of_line'])) {$type_of_line = $_REQUEST['type_of_line'];}
$qte = 1;
if (isset($_REQUEST['qte_article']) && is_numeric($_REQUEST['qte_article'])) {$qte = $_REQUEST['qte_article'];}



interface_add_line_panier ($_REQUEST['ref_article'], $qte); 

$liste_contenu = $_SESSION["panier_interface_".$_INTERFACE['ID_INTERFACE']]["contenu"];

foreach ($_ALERTES as $alerte => $value) {
	echo $alerte." => ".$value."<br>";
}
// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_catalogue_panier_resume.inc.php");

?>