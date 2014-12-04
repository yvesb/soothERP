<?php

//  ******************************************************
// PARAMETRES GENERAUX DE CONFIGURATION DE L'INTERFACE "AGENDA"
//  ******************************************************
$_INTERFACE['ID_INTERFACE']  = 52; // TABLE dans BD : 'interfaces'
$_INTERFACE['ID_PROFIL']     = 3; // TABLE dans BD : 'interfaces'
$_INTERFACE['MUST_BE_LOGIN'] = 1; // Valeur 0 ou 1
//Indique si il est nécessaire d'être logué pour accéder aux pages de l'interce
//Attention, certaines ont des besoins spécifique
//	SI $_INTERFACE['MUST_BE_LOGIN'] = 1 pour qu'une page soit accéssible à tout le monde
//		=> Utiliser $_PAGE['MUST_BE_LOGIN'] = 0 en début de page
//	SI $_INTERFACE['MUST_BE_LOGIN'] = 0 pour qu'une page nécessite d'être logger
//		=> Utiliser $_PAGE['MUST_BE_LOGIN'] = 1 en début de page																		
//  ******************************************************
// PARAMETRES SPECIFIQUES DE CONFIGURATION DE L'INTERFACE "AGENDA"
//  ******************************************************

$event_DUREE_DEFAUT = "60"; //en minutes

?>