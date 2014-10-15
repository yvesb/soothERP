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

$req=urldecode($_REQUEST["req"]);
$temp = preg_split("[\|]",$req);
$tabs= array();


foreach ($temp as $temporaire) {
	$te= preg_split("[\,]",$temporaire);
	array_push($tabs, $te);
}


	foreach ( $tabs as $tab) {
		if ($tab[0]!="") {
			$formule = new formule_tarif (urldecode($tab[0]));
			$formule->calcul_tarif_article ($tab[1], $_REQUEST["prix_a"], $_REQUEST["prix_p"], $_REQUEST["tva"]);
			$tarif = $formule->tarifs;
			$aff_tarif = $formule->define_affichage_tarif($tab[1]);
		
		
		
			$debut 	= strpos($aff_tarif, "_") + 1;
			$fin = strlen ($aff_tarif);
			$taxation 	= substr($aff_tarif, $debut, $fin);
			
			if ($tab[1]>1) {
				echo "shoot_price_if_noformule('".$tab[2]."', '".price_format($tarif[$aff_tarif])." ".$MONNAIE[1]." ".$taxation." (".price_format(($tarif[$aff_tarif]*$tab[1])).")');";
			} else {
				echo "shoot_price_if_noformule('".$tab[2]."', '".price_format($tarif[$aff_tarif])." ".$MONNAIE[1]." ".$taxation."');";
			}
		}
	}

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************



?>
H_loading();</script>