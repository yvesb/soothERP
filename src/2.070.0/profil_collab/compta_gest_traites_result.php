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

$where = array('1');
if(isset($_REQUEST["categ_client"]) && $_REQUEST["categ_client"])
    $where[] = "ac.id_client_categ = '".$_REQUEST["categ_client"]."'";
if(isset($_REQUEST["ref_contact"]) && $_REQUEST["ref_contact"])
    $where[] = "a.ref_contact = '".$_REQUEST["ref_contact"]."'";
if(isset($_REQUEST["num_compte"]) && $_REQUEST["num_compte"])
    $where[] = "cb.numero_compte LIKE '%".$_REQUEST["num_compte"]."%'";
$where[] = "cba.id_reglement_mode IN (18)";

$query = "SELECT cba.id_compte_bancaire_autorisation, a.nom, a2.nom AS nom_banque, cb.iban FROM comptes_bancaires_autorisations cba
            JOIN comptes_bancaires cb ON cba.id_compte_bancaire_src = cb.id_compte_bancaire
            JOIN annuaire a ON a.ref_contact = cb.ref_contact
            LEFT JOIN annuaire a2 ON a2.ref_contact = cb.ref_banque
            JOIN annu_client ac ON a.ref_contact = ac.ref_contact
            WHERE cba.id_reglement_mode = 18 AND ".implode(" AND ", $where);

//print_r($query); exit;
$resultat = $bdd->query ($query);
$results = array();
while ($tmp = $resultat->fetchObject()) { $results[] = $tmp; }


// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_compta_gest_traites_result.inc.php");

?>