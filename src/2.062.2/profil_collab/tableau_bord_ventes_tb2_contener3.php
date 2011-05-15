<?php
// *************************************************************************************************************
// Tableau de bord des ventes analyse ca
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

$date_debut = ($_REQUEST["date_debut"]);
$date_fin = ($_REQUEST["date_fin"]);
$type_data = ($_REQUEST["type"]);

$CA_global = charger_doc_CA (array($date_debut." 00:00:00" , $date_fin." 23:59:59" ));

switch ($type_data) {
	case "magasins":
		$liste_magasins = $_SESSION["magasins"];
		foreach($liste_magasins as $lib ){
			 $lib->CA= charger_doc_CA (array($date_debut." 00:00:00" , $date_fin." 23:59:59" ), array("magasin"=>$lib->getId_magasin()));
		$CA_global -= $lib->CA;
		}
	break;
	case "categ_client":
		if ($CLIENT_ID_PROFIL != 0) {
			include ($CONFIG_DIR."profil_".$_SESSION['profils'][$CLIENT_ID_PROFIL]->getCode_profil().".config.php");
			contact::load_profil_class($CLIENT_ID_PROFIL);
			$liste_categories_client = contact_client::charger_clients_categories ();
		}
		foreach($liste_categories_client as $lib ){
			 $lib->CA= charger_doc_CA (array($date_debut." 00:00:00" , $date_fin." 23:59:59" ), array("categ_client"=>$lib->id_client_categ));
		$CA_global -= $lib->CA;
		}
	break;
	case "categ_comm":
		if ($COMMERCIAL_ID_PROFIL != 0) {
			include ($CONFIG_DIR."profil_".$_SESSION['profils'][$COMMERCIAL_ID_PROFIL]->getCode_profil().".config.php");
			contact::load_profil_class($COMMERCIAL_ID_PROFIL);
			$liste_categories_commercial = contact_commercial::charger_commerciaux_categories ();
		}
		foreach($liste_categories_commercial as $lib ){
			 $lib->CA= charger_doc_CA (array($date_debut." 00:00:00" , $date_fin." 23:59:59" ), array("categ_comm"=>$lib->id_commercial_categ));
		$CA_global -= $lib->CA;
		}
	break;
	case "art_categ":
		$list_art_categ = get_articles_categories();
		
		foreach($list_art_categ as $lib ){
			$lib->CA= charger_doc_CA (array($date_debut." 00:00:00" , $date_fin." 23:59:59" ), array("art_categ"=>$lib->ref_art_categ));
			$CA_global -= $lib->CA;
		}
		
	break;

}
// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_tableau_bord_ventes_tb2_contener3.inc.php");

?>