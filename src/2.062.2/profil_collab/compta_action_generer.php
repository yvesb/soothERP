<?php
// *************************************************************************************************************
// ACTION GENEREE SUR BLC NON FACTURES
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


foreach ($_REQUEST as $variable => $valeur) {

	if (substr ($variable, 0, 7) != "ref_doc") {continue;}
	// ouverture des infos du document et mise à jour
	$document = open_doc ($valeur);
	if (isset($_REQUEST["fonction_generer"])) {
		switch ($_REQUEST["fonction_generer"]) {
			case "generer_fa_client":
				$GLOBALS['_OPTIONS'] = array();
				$document->generer_fa_client ();
			break;
			case "generer_fa_fournisseur":
			$document->generer_fa_fournisseur ();
			break;
		}
	}
}

?>
<?php 
foreach ($_ALERTES as $alerte => $value) {
	echo $alerte." => ".$value."<br>";
}
?>