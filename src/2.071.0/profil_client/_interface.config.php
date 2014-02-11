<?php
// *************************************************************************************************************
// PARAMETRES GENERAUX DE CONFIGURATION DE L'INTERFACE "PROFIL CLIENT"
// *************************************************************************************************************
$_INTERFACE['ID_INTERFACE'] 	= 4;	// TABLE dans BD : 'interfaces'
$_INTERFACE['ID_PROFIL'] 			= 4;	// TABLE dans BD : 'interfaces'
$_INTERFACE['MUST_BE_LOGIN'] 	= 0;	// Valeur 0 ou 1
																		//Indique si il est nécessaire d'être logué pour accéder aux pages de l'interce
																		//Attention, certaines ont des besoins spécifique
																		//	SI $_INTERFACE['MUST_BE_LOGIN'] = 1 pour qu'une page soit accéssible à tout le monde
																		//		=> Utiliser $_PAGE['MUST_BE_LOGIN'] = 0 en début de page
																		//	SI $_INTERFACE['MUST_BE_LOGIN'] = 0 pour qu'une page nécessite d'être logger
																		//		=> Utiliser $_PAGE['MUST_BE_LOGIN'] = 1 en début de page																		

// *************************************************************************************************************
// PARAMETRES SPECIFIQUES DE CONFIGURATION DE L'INTERFACE "PROFIL CLIENT"
// *************************************************************************************************************

$_INTERFACE['APP_TARIFS'] = "TTC";


$ID_MAGASIN										= 2;	// TABLE dans BD : 'magasins'  =>  /!\ Il faut vérifier que ce magasin est un de type VPC !!!!
$ID_COMPTE_CAISSE_DESTINATION = 2;	// TABLE dans BD : 'comptes_caisses'
$ID_CATALOGUE_INTERFACE				= 1; 	// TABLE dans BD : 'catalogues_clients'

$CATALOGUE_RECHERCHE_SHOWED = 20;		// Nombre d'article à afficher lors d'une recherche
// **********************************************

$NOM_LOGO = "logo.jpg";

$AFF_CAT_VISITEUR				= 1; 			//Affichage du catalogue pour les visiteurs non identifiés
$AFF_CAT_PRIX_VISITEUR 	= 1;  		//Affichage du catalogue (par défaut) pour les visiteurs non identifiés
$AFF_CAT_CLIENT					= 1; 			//Affichage des prix pour les visiteurs  identifiés
$AFF_CAT_PRIX_CLIENT		= 1;			//Affichage des prix (par défaut) pour les visiteurs identifiés

$INSCRIPTION_ALLOWED		= 2; 			//Possibilité de s'incrire depuis le dossier
																	//
																	// 0 : inscription impossible
																	//			
																	// 1 : inscription d'un contact avec une validation par un collaborateur mais sans un mail de confirmation
																	// 3 : inscription d'un contact avec une validation par un collaborateur mais avec un mail de confirmation
																	//
																	// 2 : inscription d'un contact automatique sans mail de confirmation
																	// 4 : inscription d'un contact automatique avec mail de confirmation

$MODIFICATION_ALLOWED		= 2; 			//Possibilité de modifier son dossier
																	//
																	// 0 : modification impossible
																	//			
																	// 1 : modification d'un contact avec une validation par un collaborateur mais sans un mail de confirmation
																	// 3 : modification d'un contact avec une validation par un collaborateur mais avec un mail de confirmation
																	//
																	// 2 : modification d'un contact automatique sans mail de confirmation
																	// 4 : modification d'un contact automatique avec mail de confirmation


// **********************************************


//durée d'affichage des documents terminés
$DUREE_AFF_DOC_DEV = "7776000";	//durée d'affichage dans l'interface des devis clients
$DUREE_AFF_DOC_CDC = "8553600";	//durée d'affichage dans l'interface des commandes clients
$DUREE_AFF_DOC_FAC = "259200";	//durée d'affichage dans l'interface des factures clients

// **********************************************


//type de pdf affiché
$CODE_PDF_MODELE_DEV 	= "doc_dev_lmb";
$CODE__PDF_MODELE_CDC = "doc_cdc_lmb";
$CODE__PDF_MODELE_FAC = "doc_fac_lmb";


// **********************************************


$ID_MAIL_TEMPLATE = 1;					
$MAIL_ENVOI_INSCRIPTIONS = "";
//contenu des mail
$INSCRIPTION_VALIDATION_SUJET = "Inscription à notre site non";
$INSCRIPTION_VALIDATION_CONTENU = "Bonjour et bienvenue, 
Vous venez de vous inscrire sur notre site et n ous vous en remercions. pas

Afin de confirmer votre identité, veuillez cliquer sur le lien ci-dessous :";



$INSCRIPTION_VALIDATION_SUJET_FINAL = "Validation de votre inscription à notre site";
$INSCRIPTION_VALIDATION_CONTENU_FINAL = "Bonjour et bienvenue,
Vous venez de vous inscrire sur notre site et nous vous en remercions.
Veuillez trouver ci-dessous vos identifiants de connection.

Retenez bien ces informations:
";

$SUJET_MODIFICATION_VALIDATION = "Modification de vos informations personnelles sur notre site";
$CONTENU_MODIFICATION_VALIDATION = "Bonjour,
Vos informations personnelles ont été modifiées.

Afin de confirmer ces modifications, veuillez cliquer sur le lien ci-dessous :";



$SUJET_MODIFICATION_VALIDATION_FINAL = "Validation de la modification de vos informations personnelles sur notre site";
$CONTENU_MODIFICATION_VALIDATION_FINAL = "Bonjour,
La modification de vos informations personnelles a été validée.

Veuillez trouver ci-dessous vos identifiants de connection.

Retenez bien ces informations:
";


// **********************************************


//réglement_modes_valides
$REGLEMENTES_MODES_VALIDES = "2;3;4;5";
// TABLE dans BD 'reglements_modes' champs -> id_reglement_mode
// Les ids sont séparés par des ;
// Exemple  $REGLEMENTES_MODES_VALIDES = "2;3;4;5"; pour Chèque, Carte bancaire, Virement Bancaire, Lettre de Change



// **********************************************

//pages diverses
$QUISOMMESNOUS = "Contenu de la variable \$QUISOMMESNOUS";
$MENTIONSLEGALES = "Contenu de la variable \$MENTIONSLEGALES";
$CONDITIONSDEVENTES = "Contenu de la variable \$CONDITIONSDEVENTES";
$BAS_PAGE = "Contenu de la variable \$BAS_PAGE";

$COMPLEMENT_CHAMPS = array ();


?>
