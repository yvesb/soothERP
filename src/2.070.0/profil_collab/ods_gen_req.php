<?php

require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

if(isset($_POST['id_recherche'])){
	$id_recherche = $_POST['id_recherche'];
	$info_recherche=array();
	$result_recherche=array();
	$info_recherche=get_info_recherche($id_recherche);
	$req =get_requete($id_recherche);
	$result_recherche=charge_result_recherche($req);

	include_once("../modeles_ods/tab_result.class.php");
	$ods = new tab_result($result_recherche,$info_recherche);
	return $ods;
	
}
?>