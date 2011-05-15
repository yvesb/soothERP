<?php
// *************************************************************************************************************
// ACCUEIL GESTION COMPTES BANCAIRES
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

if (!$_SESSION['user']->check_permission ("10",$_REQUEST["id_compte_bancaire"])) {
	//on indique l'interdiction et on stop le script
	echo "<br /><span style=\"font-weight:bolder;color:#FF0000;\">Vos droits  d'accés ne vous permettent pas de visualiser ce type de page</span>";
	exit();
}

//infos pour mini moteur de recherche contact
$profils_mini = array();
foreach ($_SESSION['profils'] as $profil) {
	if ($profil->getActif() != 1) { continue; }
	$profils_mini[] = $profil;
}
unset ($profil);
foreach ($_SESSION['profils'] as $profil) {
	if ($profil->getActif() != 2 ) { continue; }
	$profils_mini[] = $profil;
}
unset ($profil);

//solde en cours de chaque compte
$compte_bancaire	= new compte_bancaire($_REQUEST["id_compte_bancaire"]);
$Solde_compte_bancaire = $compte_bancaire->solde_calcule_releve (date("Y-m-d"));

$liste_releves = $compte_bancaire->getReleves_compte ();
$last_operation = $compte_bancaire->charger_last_releve($_REQUEST["id_compte_bancaire"]);

//gestion affichage stat et histogramme

$solde_30 = array();
$max_solde_30 = 1;
for ($i=29; $i>=0; $i--) {
	$tmp_solde =$compte_bancaire->solde_calcule_releve (date("Y-m-d", mktime(date("H" ,time()), date("i" ,time()), date("s" ,time()), date("m" ,time()) , date ("d", time())-$i, date ("Y", time()) ) ));
	if (abs($tmp_solde) > $max_solde_30) { $max_solde_30 = number_format(abs($tmp_solde), $TARIFS_NB_DECIMALES, ".", ""	);}
	$solde_30[] = $tmp_solde;
}
$max_solde_30 = max_valeur ($max_solde_30);

$degrader_30_pos = rainbowDegrader(30, array('0','120','0'), array('0','254','0'));
$degrader_30_neg = rainbowDegrader(30, array('120','0','0'), array('254','0','0'));

$solde_12 = array();
$max_solde_12 = 1;
for ($i=10; $i>=0; $i--) {
	$tmp_solde =$compte_bancaire->solde_calcule_releve (date("Y-m-d", mktime(0, 0, 0, date("m" ,time())-$i , 0, date ("Y", time()) ) ));

	if (abs($tmp_solde) > $max_solde_12) { $max_solde_12 = number_format(abs($tmp_solde), $TARIFS_NB_DECIMALES, ".", ""	);}
	$solde_12[] = $tmp_solde;
}
if (abs($Solde_compte_bancaire) > $max_solde_12) { $max_solde_12 = number_format(abs($Solde_compte_bancaire), $TARIFS_NB_DECIMALES, ".", ""	);}
$solde_12[] = $Solde_compte_bancaire;

$max_solde_12 = max_valeur ($max_solde_12);


$degrader_12 = rainbowDegrader(12, array('240','191','58'), array('0','74','153'));

$degrader_12_pos = rainbowDegrader(12, array('240','191','58'), array('0','74','153'));
$degrader_12_neg = rainbowDegrader(12, array('58','240','191'), array('153','74','0'));
// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_compta_compte_bancaire_gestion2.inc.php");

?>