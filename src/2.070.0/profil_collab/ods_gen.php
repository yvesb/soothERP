<?php
require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

if(isset($_POST['code_ods_modele'])){
	$code_ods_modele=$_POST['code_ods_modele'];
	include_once($ODS_MODELES_DIR.$code_ods_modele.".class.php");
	$class="ods_".$code_ods_modele;
	$ods = new $class();
	return $ods;

}

?>