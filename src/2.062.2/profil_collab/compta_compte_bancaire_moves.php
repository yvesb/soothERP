<?php
// *************************************************************************************************************
// CONSULTATION DES OPERATIONS DE COMPTE BANCAIRE
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

if (!$_SESSION['user']->check_permission ("10",$_REQUEST["id_compte_bancaire"])) {
	//on indique l'interdiction et on stop le script
	echo "<br /><span style=\"font-weight:bolder;color:#FF0000;\">Vos droits  d'accés ne vous permettent pas de visualiser ce type de page</span>";
	exit();
}


//chargement des comptes bancaires
$comptes_bancaires	= compte_bancaire::charger_comptes_bancaires("" , 1);

$compte_bancaire	= new compte_bancaire($_REQUEST["id_compte_bancaire"]);

$compta_e = new compta_exercices ();

$compta_e->check_exercice();
//chargement des exercices
$liste_exercices	= $compta_e->charger_compta_exercices();

$id_exercice = $liste_exercices[0]->id_exercice;
if (isset($_REQUEST["id_exercice"])) {$id_exercice = $_REQUEST["id_exercice"];}
//chargement des relevés de l'exercice sélectionné
$liste_releves = compte_bancaire::charger_releves_compte_exercices ($id_exercice, $_REQUEST["id_compte_bancaire"]);

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_compta_compte_bancaire_moves.inc.php");

?>