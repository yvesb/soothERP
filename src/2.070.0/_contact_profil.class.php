<?php
// *************************************************************************************************************
// CLASSE PERMETTANT LA GESTION D'UN CONTACT AYANT UN PROFIL  
// *************************************************************************************************************

abstract class contact_profil {
	private $ref_contact;
	
	public $profil_loaded = false;


function __construct ($ref_contact, $action) {
	$erreur = "La fonction _CONSTRUCT n'est pas définie dans la classe ".get_class($this);
	alerte_dev ($erreur);
}



// *************************************************************************************************************
// CREATION DES INFORMATIONS DU PROFIL   
// *************************************************************************************************************
function create_infos ($infos) {
	$erreur = "La fonction CREATE_INFOS n'est pas définie dans la classe ".get_class($this);
	alerte_dev ($erreur);
}


// *************************************************************************************************************
// MODIFICATION DES INFORMATIONS DU PROFIL   
// *************************************************************************************************************
function maj_infos ($infos) {
	$erreur = "La fonction MAJ_INFOS n'est pas définie dans la classe ".get_class($this);
	alerte_dev ($erreur);
}


// *************************************************************************************************************
// SUPPRESSION DES INFORMATIONS DU PROFIL  
// *************************************************************************************************************
function delete_infos () {
	$erreur = "La fonction DELETE_INFOS n'est pas définie dans la classe ".get_class($this);
	alerte_dev ($erreur);
}


// *************************************************************************************************************
// TRANSFERT DES INFORMATIONS DU PROFIL VERS UN AUTRE CONTACT 
// *************************************************************************************************************
function fusionne_infos ($ref_contact) {
	$erreur = "La fonction FUSIONNE_INFOS n'est pas définie dans la classe ".get_class($this);
	alerte_dev ($erreur);
}


}

?>