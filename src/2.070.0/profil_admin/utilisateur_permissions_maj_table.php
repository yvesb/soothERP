<?php
// *************************************************************************************************************
// MODIFICATION DES DROITS D'UN COLLABORATEUR
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

$ref_user 			= $_REQUEST["ref_user"];
$id_permission 		= $_REQUEST["id_permission"];
$param_permissions 	= $_REQUEST["param_permissions"];
$id_profil 			= $_REQUEST["id_profil"];

global $bdd;

$query = "UPDATE users_permissions SET VALUE = '".$param_permissions."' WHERE id_permission = '".$id_permission."' ";
if(!$bdd->exec($query)){
	$query = "INSERT INTO users_permissions (ref_user, id_permission, value) VALUES ('".$ref_user."','".$id_permission."','".$param_permissions."') ";
	$bdd->exec($query);
};	

?>