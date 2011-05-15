<?php
// *************************************************************************************************************
// HISTORIQUE DES VEHICULES
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

$id_vehicule = "";
$lib_evenement = "";
$date_debut="";
$date_fin = "";
$cout = "";
$ecart = "";

	$id_vehicule = $_REQUEST['id_vehicule'];
	if(!empty($_REQUEST['lib_evenement'])){
	$lib_evenement = urldecode($_REQUEST['lib_evenement']);
	}
	if(!empty($_REQUEST['date_debut'])){
	$date_debut = date_Fr_to_Us($_REQUEST['date_debut']);
	}
	if(!empty($_REQUEST['date_fin'])){
	$date_fin = date_Fr_to_Us($_REQUEST['date_fin']);
	}
	if(!empty($_REQUEST['cout'])){
	$cout = $_REQUEST['cout'];
	}
	if(!empty($_REQUEST['ecart'])){
		$ecart = $_REQUEST['ecart'];
	}




global $bdd;
$where = "";
	$where.= "WHERE id_vehicule = '".$id_vehicule."' ";
$query = "SELECT * FROM mod_vehicules WHERE id_vehicule = '".$id_vehicule."' ORDER BY lib_vehicule ASC";
$resultat = $bdd->query ($query);
$vehicule = $resultat->fetchObject();
if(isset($lib_evenement) || isset($date_debut) || isset($date_fin) || isset($cout) || isset($ecart)){


	if(!empty($lib_evenement)){
		$where.= "AND lib_evenement LIKE '%".$lib_evenement."%' ";
	}
if(!empty($date_debut)){
		$where.= "AND date_evenement >= '".$date_debut."' ";
	}
if(!empty($date_fin)){
		$where.= "AND date_evenement <= '".$date_fin."' ";
	}
if(!empty($cout)){
	if(!empty($ecart)){
	$cout_min="";
	$cout_max="";
	$cout_min = $cout - $ecart;
	$cout_max = $cout + $ecart;
		$where.= "AND cout >= '".$cout_min."' ";
		$where.= "AND cout <= '".$cout_max."' ";
	} else {
		$where.="AND cout =".$cout." ";
	}
	}
$liste_evenements = charger_liste_evenements($where);
}

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_smenu_gestion_vehicules_histo.inc.php");

?>