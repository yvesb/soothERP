<?php
// *************************************************************************************************************
// GENERATION D'UN NOUVEAU CODE_AFFAIRE D'UN DOCUMENT 
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

global $bdd;

// Le préfixe des codes affaires
$prefixe = 'AFF';
// Le nombre de caractères à afficher après le préfixe
$nb_car = 5;

if(isset($_REQUEST['code_affaire'])){
	$code_affaire = $_REQUEST['code_affaire'];
}else{
	$code_affaire = "";
}
$query = "SELECT MAX(code_affaire) AS max FROM documents WHERE code_affaire LIKE '" . $prefixe . "%';";
$resultat = $bdd->query ($query);
if(!$doc = $resultat->fetchObject()) { 
	$nouveau_nombre = 1;
}else{
	if($doc->max == $code_affaire && $code_affaire != ""){
		echo $code_affaire;
		return;
	}
	$nouveau_nombre = substr($doc->max, strlen($prefixe)) + 1;
}

echo $prefixe . sprintf("%'0" . $nb_car . "s\n", $nouveau_nombre);

?>
