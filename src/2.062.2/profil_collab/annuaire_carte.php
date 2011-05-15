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


// Controle de l'adresse du contact
if (!isset($_REQUEST['ref_adresse'])) {
	echo "La rfrence de l'adresse du contact n'est pas prcise";
	exit;
}

$adresse = new adresse ($_REQUEST['ref_adresse']);
if (!$adresse->getRef_adresse()) {
	echo "La rfrence de l'adresse du contact est inconnue";		
	exit;
}

// Adresse complète du contact (adresse, code postal, ville)
$adresse_complete = str_replace("\n", " ", $adresse->getText_adresse())." ".$adresse->getCode_postal()." ".$adresse->getVille();														
?>
<html>
	<head>
		<meta http-equiv="Pragma" content="no-cache">
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<title>Plan</title>
	</head>
<body>
<form method="post" action="http://www.lundimatin.fr/outils/map/carte.php" enctype="application/x-www-form-urlencoded" name="view_plan" id="view_plan">
<input type="hidden" value="<?php echo $adresse_complete;?>" name="adresse_origine"/>
</form>
<script type="text/javascript">
document.getElementById("view_plan").submit();
</script>
<html>
<body>