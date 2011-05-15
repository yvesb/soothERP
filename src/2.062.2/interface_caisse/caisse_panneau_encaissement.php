<?php
// *************************************************************************************************************
// PANNEAU AFFICHE EN BAS DE L'INTERFACE DE CAISSE
// *************************************************************************************************************

require ("_dir.inc.php");
require ("_profil.inc.php");
require ("_session.inc.php");


$enCompte = false;
$ref_contact = "";

if (!isset($_REQUEST['ref_ticket'])) {
	echo "La référence du ticket n'est pas spécifié";
	exit;
}
$ticket = open_doc($_REQUEST['ref_ticket']);

if (isset($_REQUEST['ref_contact']) && $_REQUEST['ref_contact'] != "") {

	$ref_contact = $_REQUEST['ref_contact'];
	$client = new contact($ref_contact);

	$profils = $client->getProfils();

	$id_profil = 4; //4 = profil client
	if ($profils[$id_profil]->getFactures_par_mois() > 0) {$enCompte =  true;}
	//getFactures_par_mois == 0 -> Facture immédiate
	else {$enCompte =  false;}
	
	unset($client, $profils, $id_profil);
}
$comptes_tpes	= compte_tpe::charger_comptes_tpes($_SESSION['magasin']->getId_magasin ());
$ticket->get_infos_facturation(1);
$liste_factures = $ticket->factures_to_pay;
$liste_avoir_to_use = $ticket->avoirs_to_use;
unset($ticket);

include ($DIR.$_SESSION['theme']->getDir_theme()."page_caisse_panneau_encaissement.inc.php");

?>