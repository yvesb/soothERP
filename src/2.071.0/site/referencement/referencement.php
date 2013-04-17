<?php
// *************************************************************************************************************
// AFFICHAGE DES INFORMATIONS DE RÉFÉRENCEMENT PAR PAGE
// *************************************************************************************************************

if (!isset($DIR)) {
	$_INTERFACE['MUST_BE_LOGIN'] = 0;

	require ("__dir.inc.php");
	require ($DIR."_session.inc.php");
}

$current_page = preg_replace("/(\/+)/i", "/", $_SERVER['SCRIPT_NAME']);


//on génére les informations par defaut

$defaut_title = "";
$defaut_keyword = "";
$defaut_description = "";

$tmp = get_reference(substr($current_page, 0, 64));

if (count($tmp)) {

		$defaut_title = $tmp[0]->titre;
		$defaut_keyword = $tmp[0]->meta_motscles;
		$defaut_description = $tmp[0]->meta_desc;
	
} else {
//si la page n'as pas été référencée on gère les paramétres par defaut
if ((isset($tmp[0]) && $tmp[0]->titre != "") || !count($tmp)) {
	//on récupère les informations par defaut
	$tmp_defaut = get_reference("defaut_referencement");
	if (count($tmp_defaut)) {
		$defaut_title 			= $tmp_defaut[0]->titre;
		$defaut_keyword 		= $tmp_defaut[0]->meta_motscles;
		$defaut_description = $tmp_defaut[0]->meta_desc;
	} else {
		// si les infos par defaut ne sont pas encore crées 
		// on récupère les informations du contact principal du site
		$contact_entreprise = new contact($REF_CONTACT_ENTREPRISE);
		$nom = str_replace ("\r", " ", str_replace("\n", " ",$contact_entreprise->getNom()));
		$defaut_title = $nom." ";
		
		$adresse = "";
		$code = "";
		$ville = "";
		$liste_adresse = $contact_entreprise->getAdresses();
		if (isset($liste_adresse[0])) {
			$adresse = str_replace ("\r", " ", str_replace("\n", " ",$liste_adresse[0]->getText_adresse()));
			$code = $liste_adresse[0]->getCode_postal();
			$ville = $liste_adresse[0]->getVille();
		}
		
		$defaut_keyword = $nom." ".$adresse." ".$code." ".$ville;
		$defaut_description = "Site internet de ".$nom.", ".$adresse." ".$code." ".$ville;
		//et on génére les infos par defaut
		add_reference ("defaut_referencement", $defaut_title, $defaut_description, $defaut_keyword);
	}
}
}
//si la page n'était pas référencée on l'entregistre vide
if (!count($tmp)) {
	add_reference ($current_page, "", "", "");
}


//affichage
?>
<title><?php echo $defaut_title;?></title>
<meta name="keywords" content="<?php echo str_replace("\n", " ", str_replace("\r", " ", $defaut_keyword));?>" />
<meta name="description" content="<?php echo str_replace("\n", " ", str_replace("\r", " ", $defaut_description));?>" />
<meta name="robots" content="index, follow" />





