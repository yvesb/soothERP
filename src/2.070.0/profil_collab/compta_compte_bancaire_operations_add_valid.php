<?php
// *************************************************************************************************************
// AJOUT D'UNE OPERATION
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


//chargement des comptes bancaires
$compte_bancaire	= new compte_bancaire($_REQUEST["id_compte_bancaire_ope"]);

if (isset($_REQUEST["indentation_add_ope"])) {

	for ($i=0; $i<=$_REQUEST["indentation_add_ope"] ; $i++) {
		if ($_REQUEST["montant_move_".$i] && is_numeric($_REQUEST["montant_move_".$i]) && $_REQUEST["montant_move_".$i] != "0.00") {
			if ($_SESSION['date_compta_closed'] > date_Fr_to_US($_REQUEST["date_move_".$i])) {
				$GLOBALS['_ALERTES']['operation_in_closed_exercice'][] = $i;
			}
			if (!checkdate ((int)substr($_REQUEST["date_move_".$i], 3, 2)   ,(int)substr($_REQUEST["date_move_".$i], 0, 2)  ,(int)substr($_REQUEST["date_move_".$i], 6, 4) ) && $_REQUEST["date_move_".$i]) {
				$GLOBALS['_ALERTES']['bad_date_move'] = 1;
			} 
		}
	}
	if (!count($GLOBALS['_ALERTES'])) {
		for ($i=0; $i<=$_REQUEST["indentation_add_ope"] ; $i++) {
			if ($_REQUEST["montant_move_".$i] && is_numeric($_REQUEST["montant_move_".$i]) && $_REQUEST["montant_move_".$i] != "0.00") {
				if ($compte_bancaire->add_compte_bancaire_move (date_Fr_to_Us($_REQUEST["date_move_".$i]), $_REQUEST["lib_move_".$i], $_REQUEST["montant_move_".$i], "")){
				$compte_bancaire->check_calcul_releve (date_Fr_to_Us($_REQUEST["date_move_".$i]));
				}
			}
		}
	}
}
// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_compta_compte_bancaire_operations_add_valid.inc.php");

?>