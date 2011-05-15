<?php
// *************************************************************************************************************
// IMPORT FICHIER ANNUAIRE CSV ETAPE 2 (après correspondance des colonnes et des valeurs du fichier)
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


ini_set("memory_limit","40M");

$import_annuaire = new import_annuaire_csv(); 

$dao_csv_import_annu_ligne = new import_annuaire_csv_ligne();
$lignes = $dao_csv_import_annu_ligne->readAll();
if (!count($lignes)) {
	//import terminé ou aucun enregistrement à traiter
	$import_annuaire->maj_etape(3);
	header ("Location: ".$DIR."profil_".$_SESSION['profils'][$ID_PROFIL]->getCode_profil()."/modules/".$import_annuaire_csv['folder_name']."import_annuaire_csv_step3.php");
	exit();
}
$query = "SELECT id_colonne FROM csv_import_annu_cols WHERE champ_equivalent = 'nom'";
$resultat = $bdd->query ($query);
$array_retour = array();
while ($tmp = $resultat->fetchObject()) {
	$i=0;
	$query2 = "SELECT valeur FROM csv_import_annu_lines WHERE id_colonne = " . $tmp->id_colonne ; 
	$resultat2 = $bdd->query ($query2);
	while ($tmp2 = $resultat2->fetchObject()) {
		if (isset($array_retour[$i]["nom"])) {$array_retour[$i]["nom"] .= " ".$tmp2->valeur;} else {$array_retour[$i]["nom"] = $tmp2->valeur;}
		$i++;
	}
	unset ($query2, $resultat2, $tmp2);
}
$query = "SELECT id_colonne FROM csv_import_annu_cols WHERE champ_equivalent = 'email'";
$resultat = $bdd->query ($query);
while ($tmp = $resultat->fetchObject()) {
	$i=0;
	$query2 = "SELECT valeur FROM csv_import_annu_lines WHERE id_colonne = " . $tmp->id_colonne ; 
	$resultat2 = $bdd->query ($query2);
	while ($tmp2 = $resultat2->fetchObject()) {
		if (isset($array_retour[$i]["email"])) {$array_retour[$i]["email"] .= " ".$tmp2->valeur;} else {$array_retour[$i]["email"] = $tmp2->valeur;}
		$i++;
	}
	unset ($query2, $resultat2, $tmp2);
}
$count_nom_doublon = 0;
$count_email_doublon = 0;
$count_nom_vide = 0;
foreach ($array_retour as $ret) {
	$find_email = 0;
	if (!trim($ret["nom"])) {
		$count_nom_vide++;
	}	else {
		if (isset($ret["email"])) {
			$query_where 	= "";
			$query_where 	.= " ( email = '".trim($ret["email"])."' && email != '' )"; 
			
			$query = "SELECT email
								FROM coordonnees
								WHERE ".$query_where."
								LIMIT 0,1";
			$resultat = $bdd->query($query);
			if ($fiche = $resultat->fetchObject()) { 
				if (trim($fiche->email) == trim($ret["email"])  ) {
					if (trim($ret["email"]) != "") {$count_email_doublon ++; $find_email = 1;}
				}
			}
			unset ($query, $resultat, $fiche);
		}
		$libs = explode (" ", trim($ret["nom"]));
		
		$query_where 	= "";
                $comp = 0;
		for ($i=0; $i<count($libs); $i++) {
			$lib = trim($libs[$i]);
			if (isset($libs[$i + 1]))
				{
					$comp = 1;
					$query_where 	.= " nom LIKE '%".addslashes($lib)."%' ";
					$query_where 	.= " && ";
				}
			else
				{
					if ($comp == 1)
						$query_where 	.= " nom LIKE '%".addslashes($lib)."%' ";
					else
						$query_where 	.= " nom LIKE '".addslashes($lib)."' ";
			  	}
		}
		$query = "SELECT a.ref_contact, nom
							FROM annuaire a 
							WHERE ".$query_where."
							LIMIT 0,1";
		$resultat = $bdd->query($query);
		if ($fiche = $resultat->fetchObject()) { 
			if (!$find_email ) {
				$count_nom_doublon ++;
			} 
		}
		unset ($query, $resultat, $fiche);
	}
	
}

$total_avert = $count_nom_doublon+$count_email_doublon;
// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************
include ($DIR."profil_".$_SESSION['profils'][$ID_PROFIL]->getCode_profil()."/modules/".$import_annuaire_csv['folder_name']."themes/".$_SESSION['theme']->getCode_theme()."/page_import_annuaire_csv_step2.inc.php");

?>
