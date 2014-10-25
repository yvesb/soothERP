<?php
// *************************************************************************************************************
// CLASSES REGISSANT LES INSCRIPTIONS ET LES MODIFICATIONS
// *************************************************************************************************************


//	Classe pour personnaliser les inscriptions : 
//	exemple : les messages envoyés (mails) à l'utilisateur pour le profil client 
class Inscription_profil_client extends Inscription_compte_user{
	
	function __construct($id_interface, $inscriptionAllowed = -1) {
		parent::__construct($id_interface, $inscriptionAllowed);
	}
}

//	Classe pour personnaliser les modification : 
//	exemple : les messages envoyés (mails) à l'utilisateur pour le profil client
class Modification_profil_client extends Modification_compte_user{
	
	function __construct($id_interface, $modificationAllowed = -1) {
		parent::__construct($id_interface, $modificationAllowed);
	}
}

?>