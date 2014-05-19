<?PHP 
$CONFIGURATION=0;

// CODE NON PARAMETRABLE
global $DOCUMENTS_IMG_LOGO;

$ANN_STANDARD['CHEMIN_LOGO']	= $DOCUMENTS_IMG_LOGO;

$ANN_STANDARD['FONT'] = 'Times';
$ANN_STANDARD['TAILLE'] = 12;
$ANN_STANDARD['R'] = 0;
$ANN_STANDARD['G'] = 0;
$ANN_STANDARD['B'] = 0;

$ANN_STANDARD['MARGE_GAUCHE'] = 20;
$ANN_STANDARD['MARGE_HAUT'] = 15;


/*$DOC_STANDARD['IMG_LOGO']	= $DOCUMENTS_IMG_LOGO;

$DOC_STANDARD['AFF_REMISES']	= $AFF_REMISES;

$DOC_STANDARD['HAUTEUR_LINE_ARTICLE']			= 5;
$DOC_STANDARD['HAUTEUR_LINE_TAXE']				= 5;
$DOC_STANDARD['HAUTEUR_LINE_INFORMATION']	= 5;
$DOC_STANDARD['HAUTEUR_LINE_SOUSTOTAL']		= 5;
$DOC_STANDARD['HAUTEUR_LINE_DESCRIPTION']	= 5;
$DOC_STANDARD['HAUTEUR_LINE_VIDE']				= 1;

$DOC_STANDARD['HAUTEUR_AFTER_LINE_ARTICLE']			= 0;
$DOC_STANDARD['HAUTEUR_AFTER_LINE_TAXE']				= 0;
$DOC_STANDARD['HAUTEUR_AFTER_LINE_INFORMATION']	= 0;
$DOC_STANDARD['HAUTEUR_AFTER_LINE_SOUSTOTAL']		= 0;
$DOC_STANDARD['HAUTEUR_AFTER_LINE_DESCRIPTION']	= 0;

$DOC_STANDARD['ENTETE_COL_REF'] = "Référence";
$DOC_STANDARD['ENTETE_COL_DES'] = "Désignation";
$DOC_STANDARD['ENTETE_COL_QTE'] = "Qté";
$DOC_STANDARD['ENTETE_COL_PU']  = "PU ".$this->app_tarifs;
$DOC_STANDARD['ENTETE_COL_REM'] = "Rem.";
$DOC_STANDARD['ENTETE_COL_PT']  = "Montant";
$DOC_STANDARD['ENTETE_COL_TVA'] = "TVA";

$DOC_STANDARD['LARGEUR_COL_REF'] = 30;
$DOC_STANDARD['LARGEUR_COL_LIB'] = 75;
$DOC_STANDARD['LARGEUR_COL_QTE'] = 10;
$DOC_STANDARD['LARGEUR_COL_PRI'] = 20;
$DOC_STANDARD['LARGEUR_COL_REM'] = 15;
$DOC_STANDARD['LARGEUR_COL_TVA'] = 10;

// ***************************************************
// POSITION DES BLOCS
$DOC_STANDARD['MARGE_GAUCHE'] = 15;
$DOC_STANDARD['MARGE_HAUT']		= 15;

// CORPS DU DOCUMENT
$DOC_STANDARD['CORPS_HAUTEUR_DEPART']	= 100;
$DOC_STANDARD['CORPS_HAUTEUR_MAX']		= 130;

// PIEDS DE PAGE
$DOC_STANDARD['PIEDS_HAUTEUR_DEPART']	= 240;
$DOC_STANDARD['PIEDS_HAUTEUR_MAX']		= 32;


// ***************************************************
// TEXTES DE PIEDS DE PAGE
global $PIED_DE_PAGE_GAUCHE_0;
global $PIED_DE_PAGE_GAUCHE_1;
global $PIED_DE_PAGE_DROIT_0;
global $PIED_DE_PAGE_DROIT_1;
$DOC_STANDARD['PIEDS_GAUCHE'][0]	= $PIED_DE_PAGE_GAUCHE_0;
$DOC_STANDARD['PIEDS_GAUCHE'][1]	= $PIED_DE_PAGE_GAUCHE_1;
$DOC_STANDARD['PIEDS_DROIT'][0]	=  $PIED_DE_PAGE_DROIT_0;
$DOC_STANDARD['PIEDS_DROIT'][1]	= $PIED_DE_PAGE_DROIT_1;

//variable//type de champ(parametre)//libéllé//commentaire
// PARAMETRES MODIFIABLES
$DOC_STANDARD['TEXTE_CORPS_PIEDS'][0]="Le client reconnait avoir procédé à la vérification d'usage des marchandises livrées.";//TXTE()// Texte entre corps et pied de page//ligne n°1
$DOC_STANDARD['TEXTE_CORPS_PIEDS'][1]="A défaut de mention sur le bon de livraison, aucune réclamation ne sera admise après réception de la marchandise, sauf en cas de vice caché.";//TXTE()// Texte entre corps et pied de page//ligne n°2
$DOC_STANDARD['TEXTE_CORPS_PIEDS'][2]="Réserve de propriété applicable selon la loi n°80.335 du 12 mai 1980.";//TXTE()// Texte entre corps et pied de page//ligne n°3
// FIN PARAMETRES MODIFIABLES
// CONFIGURATION PAR DEFAUT
// Portion de code recopiée dans la partie « paramètres modifiables » en cas de remise à 0 des paramètres.
/*
$DOC_STANDARD['TEXTE_CORPS_PIEDS'][0]="Le client reconnait avoir procédé à la vérification d'usage des marchandises livrées.";//TXTE()// Texte entre corps et pied de page//ligne n°1
$DOC_STANDARD['TEXTE_CORPS_PIEDS'][1]="A défaut de mention sur le bon de livraison, aucune réclamation ne sera admise après réception de la marchandise, sauf en cas de vis caché.";//TXTE()// Texte entre corps et pied de page//ligne n°2
$DOC_STANDARD['TEXTE_CORPS_PIEDS'][2]="Réserve de propriété applicable selon la loi n°80.335 du 12 mai 1980.";//TXTE()// Texte entre corps et pied de page//ligne n°3
*/
// FIN CONFIGURATION PAR DEFAUT
// INFORMATIONS SUR L’AUTEUR
/* 
*/
?>