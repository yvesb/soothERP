<?php
// *************************************************************************************************************
// RECHERCHE POUR MODIFICATION DU NUMERO DE COMPTE D'UNE CATEG ARTICLE
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

//recherche des comptes 

$form['indent'] = $search['indent'] = "indent";
if (isset($_REQUEST['indent'])) {
	$form['indent'] = $_REQUEST['indent'];
	$search['indent'] = $_REQUEST['indent'];
}
$form['retour_value_id'] = $search['retour_value_id'] = "";
if (isset($_REQUEST['retour_value_id'])) {
	$form['retour_value_id'] = $_REQUEST['retour_value_id'];
	$search['retour_value_id'] = $_REQUEST['retour_value_id'];
}
$form['retour_lib_id'] = $search['retour_lib_id'] = "";
if (isset($_REQUEST['retour_lib_id'])) {
	$form['retour_lib_id'] = $_REQUEST['retour_lib_id'];
	$search['retour_lib_id'] = $_REQUEST['retour_lib_id'];
}


$form['search_type'] = $search['search_type'] = "num";
if (isset($_REQUEST['search_type'])) {
	$form['search_type'] = $_REQUEST['search_type'];
	$search['search_type'] = $_REQUEST['search_type'];
}
$form['search_value'] = $search['search_value'] = "";
if (isset($_REQUEST['search_value'])) {
	$form['search_value'] = $_REQUEST['search_value'];
	$search['search_value'] = $_REQUEST['search_value'];
}
$result = array();
$query_where 	= "";
switch ($search['search_type']) {
	case "kw":
		if ($query_where) { $query_where .= " && "; }
		$query_where 	.= " lib_compte LIKE '%".$search['search_value']."%'";
	break;
	case "num":
		if ($query_where) { $query_where .= " && "; }
		$query_where 	.= " numero_compte LIKE '".$search['search_value']."%'";
	break;
	case "fav":
		if ($query_where) { $query_where .= " && "; }
		$query_where 	.= " favori = '".$search['search_value']."'";
	break;
}
	
	$query = "SELECT numero_compte, lib_compte, favori
						FROM plan_comptable
						WHERE ".$query_where." 
						ORDER BY numero_compte ASC";
	//echo $query;
	$resultat = $bdd->query ($query);
	while ($tmp = $resultat->fetchObject()) { $result[] = $tmp; }

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_compte_plan_comptable_search_result.inc.php");

?>