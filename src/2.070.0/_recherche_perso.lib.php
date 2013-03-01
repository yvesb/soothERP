<?php
// *************************************************************************************************************
// FONCTION POUR LA RECHERCHERCHE PERSONNALISEE
// *************************************************************************************************************

function charge_recherche_type ($type) {
	global $bdd;
        if (!$type) { return false; }
	$liste_recherche_perso= array();
	// Sélection des informations générales
	$query = "SELECT id_recherche_perso, lib_recherche_perso, desc_recherche, requete
						FROM recherches_persos
						WHERE id_type_recherche=".$type."
						 ";
	$res = $bdd->query ($query);
	while ($r = $res->fetchObject()) { $liste_recherche_perso[] = $r;}
	return $liste_recherche_perso;
	}

function add_recherche_perso($idtype, $lib_recherche, $desc_recherche, $requete){
	global $bdd;
	
	//ajouter une recherche
	$query = "INSERT INTO recherches_persos (id_type_recherche, lib_recherche_perso, desc_recherche, requete )
						VALUES ('".$idtype."','".$lib_recherche."', '".$desc_recherche."', '".$requete."') ";
	$bdd->exec ($query);
}

function mod_recherche_perso($id_recherche, $lib_recherche, $desc_recherche, $requete){
	global $bdd;
	
	//mise a jour de la recherche
	$query = "UPDATE recherches_persos
					SET lib_recherche_perso ='$lib_recherche',
					desc_recherche ='$desc_recherche',
					requete ='$requete'
				WHERE id_recherche_perso = ".$id_recherche." ;";
	$bdd->exec ($query);
}

function sup_recherche_perso($id_recherche){
	global $bdd;
	
	//suppression de la recherche
	$query = "DELETE FROM recherches_persos
					WHERE id_recherche_perso = ".$id_recherche." ;";
	$bdd->exec ($query);
}

function get_info_recherche($id_recherche){
	global $bdd;
	$info_recherche_perso= array();
	$query = "SELECT id_recherche_perso, lib_recherche_perso, desc_recherche, requete
						FROM recherches_persos
						WHERE id_recherche_perso=".$id_recherche."
						 ";
	$res = $bdd->query ($query);
	while ($r = $res->fetchObject()) { $info_recherche_perso = $r;}
	return $info_recherche_perso;
}

function get_requete($id_recherche){
	global $bdd;
	
	//cherche la requete
	$query = "SELECT requete
						FROM recherches_persos
						WHERE id_recherche_perso=".$id_recherche."
						 ";
	$res = $bdd->query ($query);
	while ($r = $res->fetchObject()) { $req = $r;}
	return $req;
}

function charge_result_recherche($req){
	global $bdd;
	$liste= array();
	//effectue la requete
	$res = $bdd->query ($req->requete);
	while ($r = $res->fetchObject()) { $liste[] = $r;}
	return $liste;
}
?>