<?php
// *************************************************************************************************************
// CHARGEMENT D'UN TICKET DE CAISSE 
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ("_session.inc.php");

if(!isset($_REQUEST['ref_ticket'])){
	echo "La référence du ticket n'est pas spécifiée";
	exit;

}
$document = open_doc($_REQUEST['ref_ticket']);

$document->maj_etat_doc(59);

$lignes = array();

foreach ($document->getContenu() as $ligne){
	if($ligne->ref_doc_line_parent == null)
	{$lignes[] = $ligne;}
}

//strings pour le champs "client" dans le panel client
$lignes_nom = explode("\n", $document->getNom_contact());
$ligne1 = $lignes_nom[0];
$ligne2 = "";
$ligne3 = "";

if(count($lignes_nom)==2)
	{$ligne2 .= $lignes_nom[1];}
elseif(count($lignes_nom)>2)
	{$ligne2 .= $lignes_nom[1]." ...";}
if ($document->getCode_postal_contact()){
	$ligne3 .= $document->getCode_postal_contact()." ";
}
if ($document->getVille_contact()){
	$ligne3 .= $document->getVille_contact();
}
if($ligne2 == ""){
	$ligne2 = $ligne3;
	$ligne3 = "";
}

if($ligne1 == "" && $ligne2 == "" && $ligne3 == ""){
	$ligne1 = "Client non identifié";
}

$grille_tarrifaire = null;
require_once ("../profil_client/_contact_client.class.php");
if($document->getRef_contact() != ""){
	$query = "SELECT ac.ref_contact, ac.id_tarif, ac.app_tarifs, tl.lib_tarif, tl.desc_tarif
						FROM annu_client ac
						LEFT JOIN tarifs_listes tl ON tl.id_tarif = ac.id_tarif
						WHERE ac.ref_contact = '".$document->getRef_contact()."'";
	
	$resultat = $bdd->query($query);
	
	if(!$grille_tarrifaire = $resultat->fetchObject()){
		echo "Ce lient n'a pas de grille tarifaire spécidiée";
		$lib_grille_tarrifaire = $_SESSION['magasin']->getLib_tarif();
		exit;
	}else
		$lib_grille_tarrifaire = !empty($grille_tarrifaire->lib_tarif) ? $grille_tarrifaire->lib_tarif : $_SESSION['magasin']->getLib_tarif();
}else{
	$lib_grille_tarrifaire = $_SESSION['magasin']->getLib_tarif();
}

$montant_to_pay = $document->getMontant_to_pay();


include ($DIR.$_SESSION['theme']->getDir_theme()."page_caisse_charger_ticket.inc.php");

?>