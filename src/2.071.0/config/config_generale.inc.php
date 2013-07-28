<?php
// *************************************************************************************************************
// CONFIGURATION GENERALE DE L'APPLICATION
// *************************************************************************************************************
$TIMEZONE = "Europe/Paris";
$INFO_LOCALE = array("fr_FRA", "fr_FR", "fra", "France", "French", "fr_FR.ISO8859-1");

$USE_PA_HT_FORCED = 0;
$TAXE_IN_PU = 1;
$GEST_TYPE_COORD = 0;
$AFFICHER_AIDE = 1;						// Affichage des infos-bulles.


// *************************************************************************************************************
// VALEURS PAR DEFAUT
// *************************************************************************************************************
$DEFAUT_PROFILS 	= array(1);		// Visiteur = 1 (au minimum). Client = 4 sera souvent utilisé.
$DEFAUT_INTERFACE = "site/"; // Interface par défaut de l'utilisateur
$DEFAUT_ID_THEME 		= 1;			// Thème utilisé pour les utilisateurs non profilés 
$DEFAUT_ID_PAYS 		= 77;			// Pays utilisé par défaut 
$DEFAUT_ID_LANG 		= 1;			// Langage utilisé par défaut 
$DEFAUT_MODE_VENTE	= "VAC";	// Mode de vente par défaut
$DEFAUT_ID_MAGASIN	= 1;			// Magasin par défaut
$DEFAUT_ID_STOCK_EXPE = 0;		// Stock pour les livraisons en VPC (sinon, livraison depuis le magasin réalisant la vente)


// *************************************************************************************************************
// PARAMETRES DE SECURITE
// *************************************************************************************************************
$SESSION_LT = 86400;										// Durée de vie de la session Système (24H)
$USER_SESSION_LT = 1800;									// Durée de vie de la session Utilisateur (00mn)
$MAX_FALSE_LOGIN = 3;	// Nombre d'échecs de connexion autorisés avant de bannir l'ip associée au login fautif
$FALSE_LOGIN_TIME_WINDOW = 86400;  // Durée pendant laquelle l'ip est bannie (en sec.)

// Identification
$MODE_IDENTIFICATION 	= "TEXTE";		// Défini si les utilisateurs s'identifient par un champs SELECT ou un champs TEXTE
$COOKIE_LOGIN_LT			= 7776000;		// Durée de vie du cookie enregistrant le LOGIN de connexion (90j)
$COOKIE_INTERFACE_LT	= 31536000;		// Durée de vie des cookies d'interfaces
$TMP_PANIER_LT				= 7776000;		// Durée de vie des infos tmp d'un panier d'interfaces
$COOKIE_SYSTEME_LT		= 31536000;		// Durée de vie des cookies systèmes


// *************************************************************************************************************
// CONFIGURATION GENERALE DE L'ANNUAIRE
// *************************************************************************************************************
// Création d'un compte utilisateur
$DELAI_USER_CREATION_INVITATION 	= 1296000; // Durée de vie de l'invitation à créer un compte utilisateur (15j)
$ANNUAIRE_RECHERCHE_SHOWED_FICHES = 50;
$CONTACT_NB_LAST_DOCS_SHOWED = 5;
$VIEW_BT_MAP = "1"; //voir le bouton carte
$VIEW_BT_ITI = "1"; //voir le bouton itinéraire
$ANNUAIRE_COMMUNICATION_SHOWED_COURRIERS = 10;


// *************************************************************************************************************
// CONFIGURATION GENERALE DU CATALOGUE
// *************************************************************************************************************
$DEFAUT_LEVEL_CATEG_AFFICHED = 2;					// Affichage des sous-catégories d'article dans les Select du moteur de recherche
$CATALOGUE_RECHERCHE_SHOWED_FICHES = 50;
$ARTICLE_NB_LAST_DOCS_SHOWED = 5;
$ARTICLE_NB_LAST_ADDED_SHOWED = 10;				//nombre d'articles dernièrement ajouté (profil constructeur)
$GESTION_SN 					= 1;								// Gestion des numéros de série
$GESTION_CONSTRUCTEUR	= 1;								// Gestion de la référence du constructeur et de la référence OEM
$GESTION_REF_INTERNE	= 1;								// Gestion de la référence interne
$GESTION_LIB_TICKET		= 0;								// Gestion des libellés de ticket
$GESTION_LOT					= 1;								// Gestion des lots
$GESTION_STOCK				= 1;								// Gestion des stocks
$ARTICLE_VARIANTE_NOM	= 1;								// Nom des Variantes d'un article (1:val val dans lib; 2 : carac et val dans lib; 3: carac et val dans desc).
$ARTICLE_QTE_NB_DEC = 2;
$ARTICLE_ABO_TIME	= 0;								// Les articles services par abonnement utilisent l'heure pour la gestion de l'abonnement

$DEFAUT_GARANTIE			= 12;								// Durée de la garantie par défaut
$DEFAUT_ARTICLE_LT 		= 2*365*24*3600;		// Durée de vie d'un article, par défaut
$DEFAUT_ID_VALO = "1";				// Valorisation par defaut
$DEFAUT_INDICE_VALORISATION = 1;					// Indice de valorisation par defaut
$DEFAUT_GESTION_SN 		= 0;
$DEFAUT_LOT				 		= 0;
$ASSUJETTI_TVA				= 1;								// entreprise soumis à la tva
$DEFAUT_ID_TVA				= 2;								// Taux de TVA par défaut pour les catégories d'articles
$DELAI_ARTICLE_IS_NEW	= 2592000;					// Délai pendant lequel un article est considéré comme nouveau. (30j)

$ARTICLE_NB_LAST_STOCK_MOVE_SHOWED = 10;
$STOCK_MOVE_RECHERCHE_SHOWED = 50;
$ARTICLE_IMAGE_MINIATURE_RATIO = 150; //ratio de déduction des images d'articles pour la miniature
$STOCK_NB_DECIMALES_MAX = 2;


// *************************************************************************************************************
// CONFIGURATION GENERALE DES TARIFS
// *************************************************************************************************************
$MONNAIE	= array("€", "&euro;", "EUR", "euro", "euros", array(500,200,100,50,20,10,5,2,1,0.5,0.2,0.1,0.05,0.02,0.01));		// Symbol, Symbol XHTML, Abreviation, complet, complet au pluriel.
$USE_FORMULES					= 1;								// utilisation du générateur de formule (sinon, tarifs définis arbitrairements)
$USE_COTATIONS				= 0;
$DEFAUT_ARRONDI				= "PRO"; 						// Par défaut, l'arrondi est PRO, SUP, ou INF
$DEFAUT_ARRONDI_PAS		= 0.05;							// Nombre de décimales par défaut pour l'arrondi d'un article
$DEFAUT_APP_TARIFS_CLIENT 			= "TTC";	// Affichage des tarifs HT ou TTC par défaut pour les clients
$DEFAUT_APP_TARIFS_FOURNISSEUR	= "HT";		// Affichage des tarifs HT ou TTC par défaut pour les fournisseurs
$TARIFS_NB_DECIMALES = 2;									// Nombre de décimales affichées pour les tarifs
$PRICES_DECIMAL_SEPARATOR = ".";
$PRICES_MILLIER_SEPARATOR = " ";
$TYPES_DEVISES = array();
$TYPES_DEVISES["Euro"] = array("€", "&euro;", "EUR", "euro", "euros", array(500,200,100,50,20,10,5,2,1,0.5,0.2,0.1,0.05,0.02,0.01));
$TYPES_DEVISES["Francs Suisses"] = array("CHF", "CHF", "CHF", "CHF", "CHF", array(1000,200,100,50,20,10,5,2,1,0.5,0.2,0.1,0.05));
$TYPES_DEVISES["Livre Sterling"] = array("£", "&pound;", "GBP", "livre", "livres", array(50,20,10,5,2,1,0.5,0.25,0.2,0.1,0.05,0.02,0.01));
$TYPES_DEVISES["Dollars"] = array("$", "$", "USD", "dollar", "dollars", array(100,50,20,10,5,2,1,0.5,0.25,0.1,0.05,0.01));
$TYPES_DEVISES["Francs CFA"] = array("FCFA", "FCFA", "FCFA", "Franc CFA", "Francs CFA", array(10000,5000,2000,100,500,200));
$TYPES_DEVISES["Francs CFP"] = array("XPF", "XPF", "F CFP", "Franc CFP", "Francs CFP", array(10000,5000,1000,500,100,50,20,10,5,2,1));

$CALCUL_VAA = "1"; //PA utilisé pour calcul de Valeur d'Achat Actuelle
$CHOIX_CALCUL_VAA = array("1"=>"Le prix d'achat le plus faible entre tous les fournisseurs" ,"2"=>"Le prix d'achat moyen" ,"3"=>"Le prix d'achat le plus fort entre tous les fournisseurs");

$DUREE_VALIDITE_PAF = 90; //durée validité PA fournisseur

$CALCUL_VAS = "1"; //PA utilisé pour calcul de Valeur d'Achat Stockée
$CHOIX_CALCUL_VAS = array("1"=>"Prix moyen pondéré", "2"=>"Dernier prix d'achat", "3"=>"Valeur d'achat actuelle" );

$MAJ_PV = "2"; //maj du prix de vente
$CHOIX_MAJ_PV = array("1"=>"A la demande", "2"=>"A chaque variation du prix d'achat ou du prix public", "3"=>"Chaque jour", "4"=>"Chaque semaine", "5"=>"Chaque mois", "6"=>"Chaque trimestre", "7"=>"Chaque année" );


// *************************************************************************************************************
// CONFIGURATION GENERALE DES DOCUMENTS
// *************************************************************************************************************
$DOCUMENT_RECHERCHE_SHOWED_FICHES = 20;
$DOCUMENT_RECHERCHE_MONTANT_TOTAL = 1;
$AFF_REMISES	= 1;
$DOCUMENTS_ARTICLES_LINES_GENERER = 50; //nombre de lignes d'articles pour les documents générés lors de l'inactivation d'un stock
$DOC_AFF_QTE_SN = 20; //nombre de sn affiché par ligne d'article
$FACTURE_IMMEDIATE	= 1; //facturer par défaut les BLC
$SEND_FAX2MAIL = 0;
$FAX2MAIL_NUM = "";
$FAX2MAIL_SER = "";
$FAX2MAIL_PASS = "";
$CDC_ALERTES_STOCK_DISPO = 0;
$CATALOGUE_ARTICLE_CMDE_SHOWED = 50;

// La variable suivante $_SERVER['REF_DOC'] est ajoutée pour pouvoir modifier le format du nom des documents.
// Elle est initialisée ici par la valeur de la variable $_SERVER['REF_SERVEUR'] pour compatibilité avec LMB officiel.
// L'initialisation peut utilement être remplacée, par exemple, par $_SERVER['REF_DOC']=date("Y") pour un nom de document plus conventionnel, du type FAC-2011-xxxxx

$_SERVER['REF_DOC']=$_SERVER['REF_SERVEUR'];

// *************************************************************************************************************
// CONFIGURATION GESTION DES CAISSES
// *************************************************************************************************************
$CAISSES_MOVES_SHOWED_FICHES = 20;
$CAISSES_CONTROLE_SHOWED_FICHES	= 25;

// *************************************************************************************************************
// CONFIGURATION GESTION COMPTA
// *************************************************************************************************************
$COMPTA_EXTRAIT_COMPTE_SHOWED_FICHES = 50;
$COMPTE_OPERATIONS_RECHERCHE_SHOWED_FICHES = 50;
$COMPTA_FACTURE_TOPAY_SHOWED_FICHES = 50;
$DEFAUT_COMPTE_TVA_ACHAT = "4456";
$DEFAUT_COMPTE_TVA_VENTE = "4457";
$DEFAUT_COMPTE_HT_ACHAT = "60";
$DEFAUT_COMPTE_HT_VENTE = "70";
$DEFAUT_COMPTE_TIERS_ACHAT = "40";
$DEFAUT_COMPTE_TIERS_VENTE = "41";
$DEFAUT_COMPTE_CAISSES = "531";
$DEFAUT_COMPTE_BANQUES = "512101";
$DEFAUT_COMPTE_VIREMENTS_INTERNES = "58";
$DEFAUT_ID_JOURNAL_BANQUES = "9";
$DEFAUT_ID_JOURNAL_CAISSES = "10";
$E_RAPPROCHEMENT = 15;

// *************************************************************************************************************
// CONFIGURATION DES IMPORT/EXPORT DE DONNÉES
// *************************************************************************************************************
$EXPORT_CATALOGUE = 1; //0 ou 1 autorise ou non l'export des données du catalogue et de l'infrastructure du catalogue
$IMPORT_ARTICLE_LIMIT = 200; // nombre d'article exporté par le fichier xml

// *************************************************************************************************************
$DOCUMENTS_IMG_LOGO = "entete_doc_pdf.jpg";
// CONFIGURATION DES BAS DE PAGE DE DOCUMENTS PDF
// *************************************************************************************************************
$PIED_DE_PAGE_GAUCHE_0 = "Votre nom - Votre adresse Votre code postal VOTRE VILLE";
$PIED_DE_PAGE_GAUCHE_1 = "Siret: ";
$PIED_DE_PAGE_DROIT_0 = "Site Internet: ";
$PIED_DE_PAGE_DROIT_1 = "Email: ";

// *************************************************************************************************************
// CONFIGURATION DES INFORMATIONS DE L'ENTREPRISE
// *************************************************************************************************************
$GESTION_COMM_COMMERCIAUX = 0;
$ENTREPRISE_DATE_CREATION = "2009-01-01";		//date de creation de l'entreprise

// *************************************************************************************************************
// CONFIGURATION DES DELAIS DES COMMANDES EN COURS
// *************************************************************************************************************
$DELAI_COMMANDE_CLIENT_RECENTE = "1";
$DELAI_COMMANDE_CLIENT_RETARD = "17";
$DELAI_COMMANDE_FOURNISSEUR_RECENTE = "2";
$DELAI_COMMANDE_FOURNISSEUR_RETARD = "10";
$DELAI_DEVIS_CLIENT_RECENT = "3";
$ID_MAIL_TEMPLATE_INVITATION_INSCRIPTION = 1;
$DELAI_DEVIS_CLIENT_RETARD = "10";

$NB_VILLES_AFFICHEES = 50;
$COMPTA_GEST_PRELEVEMENTS = false;

// *************************************************************************************************************
// CONFIGURATION DE l'AFFICHAGE DES NEWS SOOTH ERP
// *************************************************************************************************************
$AFFICHAGE_NEWS = false;

?>