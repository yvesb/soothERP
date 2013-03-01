<?php
// *************************************************************************************************************
// LIBRAIRIE DE FONCTIONS POUR LA TABLE NEWSLETTERS_PROFILS
// *************************************************************************************************************



function create_newsletter_profil ($id_newsletter,$id_profil) {
	global $bdd;
	$query = "INSERT INTO newsletters_profils (id_newsletter, id_profil, criteres)
						VALUES (".$id_newsletter.",".$id_profil.",'')";
	$bdd->exec ($query);
	return true;
}

function delete_newsletter_profil ($id_newsletter) {
	global $bdd;
	$query = "DELETE FROM newsletters_profils 
						WHERE id_newsletter=".$id_newsletter;
	$bdd->exec ($query);
	return true;
}


function maj_newsletter_profil_critere ($id_newsletter, $id_profil, $criteres) {
	global $bdd;


	$query = "INSERT INTO newsletters_profils
						(id_newsletter, id_profil, criteres)
						VALUE (".$id_newsletter.", ".$id_profil.", '".$criteres."')";
	$bdd->exec ($query);
	
	return true;
}


function getNewsletter_Profils($id_newsletter) {
	global $bdd;
	
	$newsletter_profils = array ();
	$query = "SELECT id_profil
						FROM newsletters_profils
						WHERE id_newsletter = ".$id_newsletter;
	$resultat = $bdd->query ($query);
	while ($tmp = $resultat->fetchObject()) {
		$newsletter_profils[] = $tmp->id_profil;
	}
	
	return $newsletter_profils;
}


function getNewsletter_Profil_Criteres($id_newsletter,$id_profil) {
	global $bdd;
	$criteres = array();
	
	$query = "SELECT criteres
					 FROM newsletters_profils
					 WHERE id_newsletter = ".$id_newsletter." && id_profil = ".$id_profil;
	$resultat = $bdd->query ($query);
	while ($tmp = $resultat->fetchObject()) {
		$criteres = explode("//", $tmp->criteres);
	}
	
	return $criteres;
}





?>