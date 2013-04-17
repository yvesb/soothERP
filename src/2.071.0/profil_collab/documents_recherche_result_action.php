<?php
// *************************************************************************************************************
// ACTION GENEREE SUR FAC NON REGLEE
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

ini_set("memory_limit","40M");
if(isset($_REQUEST["fonction_generer"])){
	
	switch ($_REQUEST["fonction_generer"]) {
		case "print":{//********************************************
			$GLOBALS['PDF_OPTIONS']['HideToolbar'] = 0;
			$GLOBALS['PDF_OPTIONS']['AutoPrint'] = 0;
		
			$pdf = new PDF_etendu ();// Création du fichier
			
			foreach ($_REQUEST as $variable => $valeur) {
				if (substr ($variable, 0, 7) != "ref_doc") {continue;}
				$document = open_doc ($valeur);// Préférences et options
				$pdf->add_doc ("", $document);// Ajout du document au PDF
			}
			// Sortie
			$pdf->Output();
		break;}
		case "annuler_docs":{//**************************************
			foreach ($_REQUEST as $variable => $valeur) {
				if (substr ($variable, 0, 7) != "ref_doc") {continue;}
				// Ouverture et annulation du doc
				$document = open_doc ($valeur);
				$document->maj_etat_doc ($document->getID_ETAT_ANNULE());
			}
		break;}
		case "DEV_enAttente_to_refuse":{//**************************
			foreach ($_REQUEST as $variable => $valeur) {
				if (substr ($variable, 0, 7) != "ref_doc") {continue;}
				unset($GLOBALS['_OPTIONS']['CREATE_DOC']);
				// Ouverture et annulation du doc
				$document = open_doc ($valeur);
				$document->maj_etat_doc(5);//ETAT 5 = Refusé pour un doc de type DEV
			}
		break;}
		case "DEV_aRealiser_to_attenteReponseClient":{//************
			foreach ($_REQUEST as $variable => $valeur) {
				if (substr ($variable, 0, 7) != "ref_doc") {continue;}
				unset($GLOBALS['_OPTIONS']['CREATE_DOC']);
				// Ouverture et annulation du doc
				$document = open_doc ($valeur);
				$document->maj_etat_doc(3);//ETAT 3 = Attente réponse client pour un doc de type DEV
			}
		break;}
		case "CDC_enCours_generate_BLC_enSaisie":{//****************
			foreach ($_REQUEST as $variable => $valeur) {
				if (substr ($variable, 0, 7) != "ref_doc") {continue;}
				unset($GLOBALS['_OPTIONS']['CREATE_DOC']);
				// Ouverture et annulation du doc
				$document = open_doc ($valeur);
				$document->generer_bl_client();
			}
		break;}
		case "BLC_pretAuDepart_to_livrer":{//************************
			foreach ($_REQUEST as $variable => $valeur) {
				if (substr ($variable, 0, 7) != "ref_doc") {continue;}
				unset($GLOBALS['_OPTIONS']['CREATE_DOC']);
				// Ouverture et annulation du doc
				$document = open_doc ($valeur);
				$document->maj_etat_doc(15);//ETAT 15 = Livré pour un doc de type BLC
			}
		break;}
		case "BLC_enSaisie_to_pretAuDepart":{//**********************
			foreach ($_REQUEST as $variable => $valeur) {
				if (substr ($variable, 0, 7) != "ref_doc") {continue;}
				unset($GLOBALS['_OPTIONS']['CREATE_DOC']);
				// Ouverture et annulation du doc
				$document = open_doc ($valeur);
				$document->maj_etat_doc(13);//ETAT 13 = Prêt au départ pour un doc de type BLC
			}
		break;}		
		case "FAC_enSaisie_to_aRegler":{//***************************
			foreach ($_REQUEST as $variable => $valeur) {
				if (substr ($variable, 0, 7) != "ref_doc") {continue;}
				unset($GLOBALS['_OPTIONS']['CREATE_DOC']);
				// Ouverture et annulation du doc
				$document = open_doc ($valeur);
				$document->maj_etat_doc(18);//ETAT 15 = Livré pour un doc de type BLC
			}
		break;}
		default:{//**************************************************
			
		break;}
	}
	
}


?>
<?php 
foreach ($_ALERTES as $alerte => $value) {
	echo $alerte." => ".$value."<br>";
}
?>