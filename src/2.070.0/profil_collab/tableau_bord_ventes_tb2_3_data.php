<?php
// *************************************************************************************************************
// Tableau de bord des ventes test
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

require ($DIR.$_SESSION['theme']->getDir_theme()."_theme.config.php" );

require_once ($RESSOURCE_DIR."/php-ofc-library/open-flash-chart.php");

$tmp = array();
$date_debut = $_REQUEST["date_debut"];
$date_fin = $_REQUEST["date_fin"];


$CA_global = charger_doc_CA (array($date_debut." 00:00:00" , $date_fin." 23:59:59" ));

switch ($_REQUEST["type_data"]) {
	case "magasins":
	
	$liste_magasins = $_SESSION["magasins"];
	foreach($liste_magasins as $lib ){
		$CA_mod = charger_doc_CA (array($date_debut." 00:00:00" , $date_fin." 23:59:59" ), array("magasin"=>$lib->getId_magasin()));
		$lib->CA = $CA_mod;
		$CA_global -= $CA_mod;
		$tmp[] = new pie_value($CA_mod, utf8_encode($lib->getLib_magasin()));
	}
	break;

	case "categ_client":
		if ($CLIENT_ID_PROFIL != 0) {
			include ($CONFIG_DIR."profil_".$_SESSION['profils'][$CLIENT_ID_PROFIL]->getCode_profil().".config.php");
			contact::load_profil_class($CLIENT_ID_PROFIL);
			$liste_categories_client = contact_client::charger_clients_categories ();
		}
		foreach($liste_categories_client as $lib ){
			 $CA_mod= charger_doc_CA (array($date_debut." 00:00:00" , $date_fin." 23:59:59" ), array("categ_client"=>$lib->id_client_categ));
		$lib->CA = $CA_mod;
		$CA_global -= $CA_mod;
		$tmp[] = new pie_value($CA_mod, utf8_encode($lib->lib_client_categ));
		}
	break;
	case "categ_comm":
		if ($COMMERCIAL_ID_PROFIL != 0) {
			include ($CONFIG_DIR."profil_".$_SESSION['profils'][$COMMERCIAL_ID_PROFIL]->getCode_profil().".config.php");
			contact::load_profil_class($COMMERCIAL_ID_PROFIL);
			$liste_categories_commercial = contact_commercial::charger_commerciaux_categories ();
		}
		foreach($liste_categories_commercial as $lib ){
			 $CA_mod= charger_doc_CA (array($date_debut." 00:00:00" , $date_fin." 23:59:59" ), array("categ_comm"=>$lib->id_commercial_categ));
			$lib->CA = $CA_mod;
			$CA_global -= $CA_mod;
			$tmp[] = new pie_value($CA_mod, utf8_encode($lib->lib_commercial_categ));
		}
	break;
	case "art_categ":
		$list_art_categ = get_articles_categories();
		foreach($list_art_categ as $lib ){
			$CA_mod= charger_doc_CA (array($date_debut." 00:00:00" , $date_fin." 23:59:59" ), array("art_categ"=>$lib->ref_art_categ));
			$lib->CA = $CA_mod;
			$CA_global -= $CA_mod;
		}
		
		
		$tmplist_art_categ = $list_art_categ;
		foreach($list_art_categ as $k=>$lib ){
			$pass_ref_art_categ = "";
			foreach ($tmplist_art_categ as $tmp_art_categ) {
				if ($tmp_art_categ->ref_art_categ == $lib->ref_art_categ) {$pass_ref_art_categ = $lib->ref_art_categ; continue;}
				if (!$pass_ref_art_categ) {continue;}
				if ($lib->indentation >= $tmp_art_categ->indentation) {$pass_ref_art_categ = ""; break;}
				$list_art_categ [$k]->CA += $tmp_art_categ->CA;
			}
		}
		foreach($list_art_categ as $lib ){
			if (!$lib->indentation) {
			$tmp[] = new pie_value($lib->CA, utf8_encode($lib->lib_art_categ));
			}
		}
		
	break;
}

if ($CA_global) {
	$tmp[] = new pie_value($CA_global, utf8_encode("Non attribué"));
}

$title = new title("");

$pie = new pie();
$pie->start_angle(35)
    ->add_animation( new pie_fade() )
    ->add_animation( new pie_bounce(6) )
    ->colours(array("#97bf0d","#ab8cbc","#f29400","#8baed8","#ffed00"));
				
$pie->set_tooltip( '#label#<br>#val# '.$MONNAIE[4].' (#percent#)' );
$pie->set_no_labels();
$pie->set_values( $tmp );

$chart = new open_flash_chart();
$chart->set_title( $title );
$chart->set_bg_colour( "#FFFFFF" );
$chart->add_element( $pie );
                    
echo $chart->toString();

?>