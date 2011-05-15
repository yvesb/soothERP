<?php
// *************************************************************************************************************
// MAJ DU CONTACT D'UN DOCUMENT 
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ("_session.inc.php");

if (!isset($_REQUEST['ref_contact']) || $_REQUEST['ref_contact'] == "") {
	echo "La référence du contact n'est pas spécifiée";
	exit;
}
$client = new contact($_REQUEST['ref_contact']);

if (isset($_REQUEST['ref_doc']) && $_REQUEST['ref_doc'] != "") {
	//ouverture des infos du document
	$document = open_doc ($_REQUEST['ref_doc']);
	
	//maj ref_contact
	$document->maj_contact ($client->getRef_contact());
}

//strings pour le champs "client" dans le panel client
$lignes_nom = explode("\n", $client->getNom());
$ligne1 = "";
$ligne2 = "";
$ligne3 = "";

if($client->getLib_civ_court())
	{$ligne1 .= "(".$client->getLib_civ_court().") ";}
$ligne1 .= $lignes_nom[0];
if(count($lignes_nom)==2)
	{$ligne2 .= $lignes_nom[1];}
elseif(count($lignes_nom)>2)
	{$ligne2 .= $lignes_nom[1]." ...";}
if ($client->getAdresses()){
	$adresses = $client->getAdresses();
	$ligne3 .= $adresses[0]->getCode_postal()." ".$adresses[0]->getVille();
}

if($ligne2 == ""){
	$ligne2 = $ligne3;
	$ligne3 = "";
}

$grille_tarrifaire = null;
require_once ("../profil_client/_contact_client.class.php");
$query = "SELECT ac.ref_contact, ac.id_tarif, ac.app_tarifs, tl.lib_tarif, tl.desc_tarif
					FROM annu_client ac
					LEFT JOIN tarifs_listes tl ON tl.id_tarif = ac.id_tarif
					WHERE ac.ref_contact = '".$client->getRef_contact()."'";

$resultat = $bdd->query($query);

if(!$grille_tarrifaire = $resultat->fetchObject()){
	echo "Ce lient n'a pas de grille tarifaire spécidiée";
	exit;
}


//string pour le champs "statut" dans le panel client
$infos_client = $client->getProfil($CLIENT_ID_PROFIL);

unset($infos_client);

//string pour le champs Solde Compte dans le panel client
$solde_comptable = compta_exercices::solde_extrait_compte ($client->getRef_contact());

include ($DIR.$_SESSION['theme']->getDir_theme()."page_caisse_maj_client.inc.php");

?>