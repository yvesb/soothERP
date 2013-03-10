<?php
// *************************************************************************************************************
// [ADMINISTRATEUR] AFFICHAGE D'UNE FICHE D'ADRESSE
// *************************************************************************************************************



require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");
require ($DIR.$_SESSION['theme']->getDir_theme()."_theme.config.php");

// *************************************************************************************************************
// TRAITEMENTS
// *************************************************************************************************************


// Controle de l'adresse du magasin en cours (dpart)
if (!isset($_SESSION['magasin'])) {
	echo "La rfrence de l'adresse du magasin en cours n'est pas prcise";
	exit;
}

$adresse_depart = new adresse ($_SESSION['magasin']->getRef_adr_stock());
if (!$adresse_depart->getRef_adresse()) {
	echo "La rfrence de l'adresse du magasin en cours est inconnue";		
	exit;
}

// Controle de l'adresse du contact (arrive)
if (!isset($_REQUEST['ref_adresse'])) {
	echo "La rfrence de l'adresse du contact n'est pas prcise";
	exit;
}

$adresse_arrivee = new adresse ($_REQUEST['ref_adresse']);
if (!$adresse_arrivee->getRef_adresse()) {
	echo "La rfrence de l'adresse du contact est inconnue";		
	exit;
}
	
// Adresse complète du dpart de l'itinaire (adresse, code postal, ville)
$adresse_complete_depart = str_replace("\n", " ", $adresse_depart->getText_adresse())." ".$adresse_depart->getCode_postal()." ".$adresse_depart->getVille();

// Adresse complète du dpart de l'itinaire (adresse, code postal, ville)
$adresse_complete_arrivee = str_replace("\n", " ", $adresse_arrivee->getText_adresse())." ".$adresse_arrivee->getCode_postal()." ".$adresse_arrivee->getVille();									
?>
<html>
	<head>
		<meta http-equiv="Pragma" content="no-cache">
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<title>Votre Itinraire</title>
	</head>
<body>
<form method="post" action="http://www.lundimatin.fr/outils/map/itineraire.php" enctype="application/x-www-form-urlencoded" name="view_plan" id="view_plan">
<input type="hidden" value="<?php echo $adresse_complete_depart;?>" name="adresse_origine"/>
<input type="hidden" value="<?php echo $adresse_complete_arrivee;?>" name="adresse_destination"/>
</form>
<script type="text/javascript">
document.getElementById("view_plan").submit();
</script>
<html>
<body>