<?php
// *************************************************************************************************************
// Tableau de bord des données clients
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


$liste_type_clients = array("piste"=>array("lib"=>"Clients non prospectés", "nb"=>0), "prospect"=>array("lib"=>"Clients prospectés", "nb"=>0),"client"=>array("lib"=>"Clients actifs", "nb"=>0), "ancien client"=>array("lib"=>"Anciens Clients", "nb"=>0));

foreach ($liste_type_clients as $key=>$client_type) {
	
	$query = "SELECT DISTINCT ac.ref_contact 								
						FROM annu_client ac
						LEFT JOIN clients_categories cc ON cc.id_client_categ = ac.id_client_categ
						LEFT JOIN annuaire a ON a.ref_contact = ac.ref_contact
						WHERE ac.type_client = '".$key."' && ISNULL(a.date_archivage) ";	
	$resultat = $bdd->query ($query);
	while ($contact_client = $resultat->fetchObject()) { $liste_type_clients[$key]["nb"] ++; }
}
//print_r($liste_type_clients);

if ($CLIENT_ID_PROFIL != 0) {
	include ($CONFIG_DIR."profil_".$_SESSION['profils'][$CLIENT_ID_PROFIL]->getCode_profil().".config.php");
	contact::load_profil_class($CLIENT_ID_PROFIL);
	$liste_categories_client = contact_client::charger_clients_categories ();
}

foreach($liste_categories_client as $lib ){
	$nb = 0;
	$query = "SELECT DISTINCT ac.ref_contact 								
						FROM annu_client ac
						LEFT JOIN clients_categories cc ON cc.id_client_categ = ac.id_client_categ
						LEFT JOIN annuaire a ON a.ref_contact = ac.ref_contact
						WHERE ac.id_client_categ = '".$lib->id_client_categ."' && ISNULL(a.date_archivage)  ";	
	$resultat = $bdd->query ($query);
	while ($contact_client = $resultat->fetchObject()) { $nb ++; }
	$lib->nombre_fiches = $nb;
}
// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_tableau_bord_ventes_tb3_contener.inc.php");

?>