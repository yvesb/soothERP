<?php
// *************************************************************************************************************
// journal client
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");
if (!$_SESSION['user']->check_permission ("12")) {
	//on indique l'interdiction et on stop le script
	echo "<br /><span style=\"font-weight:bolder;color:#FF0000;\">Vos droits  d'accés ne vous permettent pas de visualiser ce type de page</span>";
	exit();
}

if(!$_REQUEST["piece_jointe"]) $pj = "NULL";
else $pj = "'".$_REQUEST["piece_jointe"]."'";

if(isset($_REQUEST["edit"])){
    $query="UPDATE comptes_bancaires_autorisations
                SET id_compte_bancaire_src='".$_REQUEST["compte_src"]."',
                id_compte_bancaire_dest = '".$_REQUEST["compte_dest"]."',
                id_piece_jointe_autorisation = $pj
                WHERE id_compte_bancaire_autorisation = ".$_REQUEST["id_prelevement"];
} else {
    $query = "INSERT INTO comptes_bancaires_autorisations
                (id_compte_bancaire_src, id_compte_bancaire_dest, id_reglement_mode, id_piece_jointe_autorisation)
                VALUES ('".$_REQUEST["compte_src"]."','".$_REQUEST["compte_dest"]."','".$_REQUEST["mode_regl"]."',$pj);";
}
$bdd->exec ($query);
if (!empty($_REQUEST['id_rgmnt_fav'])){
    $query = "UPDATE annu_client
              SET id_reglement_mode_favori ='".$_REQUEST["mode_regl"]."'
              WHERE ref_contact = ".$bdd->quote($_REQUEST["ref_client"]);
    $bdd->exec ($query);
}
?>