<?php

// *************************************************************************************************************
// FONCTIONS PERMETTANT L'EDITION DE DOCUMENTS, FICHIERS, ETC. 
// *************************************************************************************************************


function edit_doc ($id_edition_mode, $document) {
	echo "IMPRESSION !!";
}

function getEdition_modes_actifs(){
	
	global $bdd;
	
	$return = array();
	
	$query = "SELECT id_edition_mode, lib_edition_mode, code_edition_mode
						FROM editions_modes
						WHERE actif = 1
						ORDER BY id_edition_mode ASC";
	
	$resultat = $bdd->query($query);
	while($mode = $resultat->fetchObject()){
		$return[] = $mode;
	}
	return $return;
}

?>