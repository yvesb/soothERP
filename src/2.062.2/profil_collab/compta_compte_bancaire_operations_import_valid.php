<?php
// *************************************************************************************************************
// IMPORT D'OPERATIONS
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


//chargement des comptes bancaires
$compte_bancaire	= new compte_bancaire($_REQUEST["id_compte_bancaire_ope"]);
$erreur = "";
$nb_erreur_1 = 0;
$nb_erreur_2 = 0;
$nb_erreur_3 = 0;
$count_nb_import = 0;
$date_maj_releve = date("Y-m-d");
$fichier = $_FILES['ope_ofx']['tmp_name'];
$break_read_line = false;
if (file_exists($fichier)) {
	$fp = file("$fichier");
	foreach ($fp as $line) {
		if (substr_count($line, "<CREDITCARDMSGSRSV1>")) {$break_read_line = true;}
		if (substr_count($line, "</CREDITCARDMSGSRSV1>")) {$break_read_line = false;}
		if ($break_read_line) { continue;}
		if (substr_count($line, "<STMTTRN>")) {
			$info = array(); 
			$info["trntype"] = ""; 
			$info["date_move"] = ""; 
			$info["montant_move"] = "";
			$info["fitid"] = "";
			$info["lib_move"] = "";
			$info["commentaire_move"] = "";
			$info["trninfo"] = "";
		}
		if (substr_count($line, "<TRNTYPE>"))	{ $info["trntype"] = trim(str_replace("<TRNTYPE>", "", $line)); }
		if (substr_count($line, "<DTPOSTED>")){ $info["date_move"] = trim(str_replace("<DTPOSTED>", "", $line)); }
		if (substr_count($line, "<TRNAMT>")) 	{ $info["montant_move"] = trim(str_replace("<TRNAMT>", "", $line)); }
		if (substr_count($line, "<FITID>"))		{ $info["fitid"] = trim(str_replace("<FITID>", "", $line)); }
		if (substr_count($line, "<NAME>") )		{ $info["lib_move"] = trim(str_replace("<NAME>", "", $line)); }
		if (substr_count($line, "<MEMO>") )		{ $info["commentaire_move"] = trim(str_replace("<MEMO>", "", str_replace("<MEMO>.", "", $line))); }
		if (substr_count($line, "<TRNTYPE>")) { $info["trntype"] = trim(str_replace("<TRNTYPE>", "", $line)); }
		if (substr_count($line, "</STMTTRN>")) {
			$info["date_move"] = (substr($info["date_move"],0,4)."-".substr($info["date_move"],4,2)."-".substr($info["date_move"],6,2));
			if ($compte_bancaire->add_compte_bancaire_move ($info["date_move"], $info["lib_move"], $info["montant_move"], $info["commentaire_move"], $info["fitid"], $info["trntype"], $info["trninfo"]) ) {
				$count_nb_import ++;
				if (strtotime($info["date_move"]) < strtotime($date_maj_releve)) {
					$date_maj_releve = $info["date_move"];
				}
			}
			if (isset($GLOBALS['_ALERTES']['operation_in_closed_exercice'])) {
				$nb_erreur_1 ++;
			}
			if (isset($GLOBALS['_ALERTES']['exist_fitid'])) {
				$nb_erreur_2 ++;
			}
			if (isset($GLOBALS['_ALERTES']['bad_operation_montant_move'])) {
				$nb_erreur_3 ++;
			}
			$GLOBALS['_ALERTES'] = array();
		}
	}
	$compte_bancaire->check_calcul_releve (date ("Y-m-d", mktime(0, 0, 0, date ("m", strtotime($date_maj_releve)) , date ("d", strtotime($date_maj_releve)), date ("Y", strtotime($date_maj_releve)) )));
} else { 
	$erreur =  "Fichier introuvable !<br>Importation stoppée.";
}

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_compta_compte_bancaire_operations_import_valid.inc.php");

?>