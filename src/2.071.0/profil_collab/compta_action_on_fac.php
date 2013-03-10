<?php
// *************************************************************************************************************
// ACTION GENEREE SUR FAC NON REGLEE
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

ini_set("memory_limit","40M");

if (isset($_REQUEST["fonction_generer"]) && is_numeric($_REQUEST["fonction_generer"])) {
	foreach ($_REQUEST as $variable => $valeur) {
		if (substr ($variable, 0, 7) != "ref_doc") {continue;}
		// ouverture des infos du document et mise à jour
		$document = open_doc ($valeur);
			if ($_REQUEST["fonction_generer"] == 0) {
				$document->maj_id_niveau_relance ("");
			}else { 
				$document->maj_id_niveau_relance ($_REQUEST['fonction_generer']);
			}
		
	}
} else if (isset($_REQUEST["fonction_generer"]) && $_REQUEST["fonction_generer"] == "print") {
	$GLOBALS['PDF_OPTIONS']['HideToolbar'] = 0;
	$GLOBALS['PDF_OPTIONS']['AutoPrint'] = 0;

	// Création du fichier
	$pdf = new PDF_etendu ();
	
	foreach ($_REQUEST as $variable => $valeur) {
		if (substr ($variable, 0, 7) != "ref_doc") {continue;}
		// Préférences et options
		$document = open_doc ($valeur);
	
		// Ajout du document au PDF
		$pdf->add_doc ("", $document);

	}
	
	// Sortie
	$pdf->Output();
}

?>
<?php 
foreach ($_ALERTES as $alerte => $value) {
	echo $alerte." => ".$value."<br>";
}
?>