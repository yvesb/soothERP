<?php

// *************************************************************************************************************
// CLASSES A CHARGER POUR LA GESTION DES PROFILS D'UTILISATEUR
// *************************************************************************************************************

// Liste des profils autorisant une connexion.
$profils = array ("visiteur", "admin", "collab", "client", "commercial");

foreach ($profils as $code_profil) {
	if ($code_profil == "visiteur") { 
		require_once ($DIR."site/_user_".$code_profil.".class.php");
		continue; 
	}
	require_once ($DIR."profil_".$code_profil."/_user_".$code_profil.".class.php");
}


$VISITEUR_ID_PROFIL = 1;
$ADMIN_ID_PROFIL = 2;
$COLLAB_ID_PROFIL = 3;
$CLIENT_ID_PROFIL = 4;
$FOURNISSEUR_ID_PROFIL = 5;
$CONSTRUCTEUR_ID_PROFIL = 6;

$TRANSPORTEUR_ID_PROFIL = 0;
$BANQUE_ID_PROFIL = 0;
$COMMERCIAL_ID_PROFIL = 7;

?>