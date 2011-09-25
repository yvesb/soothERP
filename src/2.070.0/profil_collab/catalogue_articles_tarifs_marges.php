<?php
// *************************************************************************************************************
// ACCUEIL DE L'UTILISATEUR ADMINISTRATEUR
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


// Controle
?>
<script type="text/javascript">
<?php



if ($_REQUEST["prix_a"]!= "" && is_numeric($_REQUEST["qte"]) ) {
$formule = new formule_tarif (urldecode($_REQUEST["formule"]));
$formule->calcul_tarif_article ($_REQUEST["qte"], $_REQUEST["prix_a"], $_REQUEST["prix_p"], $_REQUEST["tva"]);
$tarif = $formule->tarifs;
$aff_tarif = $formule->define_affichage_tarif($_REQUEST["qte"]);
	
	
	echo "$('".$_REQUEST["div_cible"]."').innerHTML =  'Marge HT: ".price_format($tarif["PU_HT"] - $_REQUEST["prix_a"] )." ".$MONNAIE[1]."';";
	if ($tarif["PU_HT"]) {
		echo "$('".$_REQUEST["div_cible"]."').innerHTML += '<br />Taux de marge: ".price_format(((($_REQUEST["prix_a"]*100) / $tarif["PU_HT"] )-100) * -1)."%' ;";
	}
}
		
// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************



?>
H_loading();</script>