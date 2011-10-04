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

$comptes_entreprise = compte_bancaire::charger_comptes_bancaires("" , 1);

$query = "SELECT * FROM comptes_bancaires_autorisations cba
            JOIN comptes_bancaires cb ON cba.id_compte_bancaire_src = cb.id_compte_bancaire
            JOIN annuaire a ON cb.ref_contact = a.ref_contact
            WHERE cba.id_compte_bancaire_autorisation = ".$_REQUEST["id_prelev"];

$resultat = $bdd->query ($query);
$current = $resultat->fetchObject();


// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_compta_gest_traitena_edit.inc.php");

?>