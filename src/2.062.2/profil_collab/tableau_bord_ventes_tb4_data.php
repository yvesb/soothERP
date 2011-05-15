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


		$liste_type_clients = array("piste"=>array("lib"=>"Clients non prospectés", "nb"=>0), "prospect"=>array("lib"=>"Clients prospectés", "nb"=>0),"client"=>array("lib"=>"Clients actifs", "nb"=>0), "ancien client"=>array("lib"=>"Anciens Clients", "nb"=>0));
	

switch ($_REQUEST["type_data"]) {
	case "type_client":
	foreach ($liste_type_clients as $key=>$client_type) {
		
		$query = "SELECT DISTINCT ac.ref_contact 								
							FROM annu_client ac
							LEFT JOIN clients_categories cc ON cc.id_client_categ = ac.id_client_categ
							LEFT JOIN annuaire a ON a.ref_contact = ac.ref_contact
							WHERE ac.type_client = '".$key."' && ISNULL(a.date_archivage) ";	
		$resultat = $bdd->query ($query);
		while ($contact_client = $resultat->fetchObject()) { $liste_type_clients[$key]["nb"] ++; }
		
		$tmp[] = new pie_value($liste_type_clients[$key]["nb"], utf8_encode($liste_type_clients[$key]["lib"]));
	}
	
	$title = new title("");
	break;

	case "categ_client":
	
		if ($CLIENT_ID_PROFIL != 0) {
			include ($CONFIG_DIR."profil_".$_SESSION['profils'][$CLIENT_ID_PROFIL]->getCode_profil().".config.php");
			contact::load_profil_class($CLIENT_ID_PROFIL);
			$liste_categories_client = contact_client::charger_clients_categories ();
		}
		foreach($liste_categories_client as $lib ){
			if ($_REQUEST["id_client_categ"] != $lib->id_client_categ) { continue;}
			$title = new title(utf8_encode($lib->lib_client_categ));
		}
		
		foreach ($liste_type_clients as $key=>$client_type) {
			$nb = 0;
			$query = "SELECT DISTINCT ac.ref_contact 								
								FROM annu_client ac
								LEFT JOIN clients_categories cc ON cc.id_client_categ = ac.id_client_categ
								LEFT JOIN annuaire a ON a.ref_contact = ac.ref_contact
								WHERE ac.type_client = '".$key."' && ac.id_client_categ = '".$_REQUEST["id_client_categ"]."' && ISNULL(a.date_archivage)  ";	
			$resultat = $bdd->query ($query);
			while ($contact_client = $resultat->fetchObject()) { $liste_type_clients[$key]["nb"] ++; }
			$tmp[] = new pie_value($liste_type_clients[$key]["nb"], utf8_encode($liste_type_clients[$key]["lib"]));
		}
	break;
}


$pie = new pie();
$pie->start_angle(35)
    ->add_animation( new pie_fade() )
    ->add_animation( new pie_bounce(6) )
    ->colours(array("#97bf0d","#ab8cbc","#f29400","#8baed8","#ffed00"));
				
$pie->set_tooltip( '#label#<br>#val# (#percent#)' );
$pie->set_no_labels();
$pie->set_values( $tmp );

$chart = new open_flash_chart();
$chart->set_title( $title );
$chart->set_bg_colour( "#FFFFFF" );
$chart->add_element( $pie );
                    
echo $chart->toString();

?>