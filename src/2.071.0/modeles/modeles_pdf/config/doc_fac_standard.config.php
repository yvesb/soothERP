<?php
$CONFIGURATION=0;

// CODE NON PARAMETRABLE
global $DOCUMENTS_IMG_LOGO;
$DOC_STANDARD['IMG_LOGO']	= $DOCUMENTS_IMG_LOGO;

$DOC_STANDARD['AFF_REMISES']	= $AFF_REMISES;
$DOC_STANDARD['AFF_PRIX']="true";

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
$DOC_STANDARD['PIEDS_DROIT'][0]	= $PIED_DE_PAGE_DROIT_0;
$DOC_STANDARD['PIEDS_DROIT'][1]	= $PIED_DE_PAGE_DROIT_1;



//variable//type de champ(parametre)//libéllé//commentaire [// option séparé par un @ exemple: valeur1@valeur2@valeur3 ]
// PARAMETRES MODIFIABLES
$DOC_STANDARD['LIB_NEG']="Facture d'avoir";//TXTE()// Libellé si total négatif // 
$DOC_STANDARD['TEXTE_CORPS_PIEDS']="Aucun escompte ne sera accordé pour paiement anticipé.\nTout retard de paiement engendre des pénalités exigibles le jour suivant, calculées sur la base du taux légal + 5%.\nRéserve de propriété applicable selon la loi n°80.335 du 12 mai 1980. En cas de litige, est seul compétent le tribunal du ressort du siège social de l'entreprise.";//TXTA()// Texte entre corps et pied de page// texte sur trois lignes
$DOC_STANDARD['REF_ARTICLE']="Article";//SLCT()// Affichage de la colonne référence //  //Aucune@Article@Interne@Oem
$DOC_STANDARD['TVA']="true";//CBOX()// Afficher la TVA des clients //
$DOC_STANDARD['AFF_CODE_BARRE']="true";//CBOX()// Afficher le code barre en entête// 
$DOC_STANDARD['AFF_DESC']="true";//CBOX()// Afficher la description courte // 
$DOC_STANDARD['AFF_CG']="";//CBOP()// Afficher au dos les conditions générales // 
$DOC_STANDARD['CG_VERSO']="";//TXTP()// Conditions générales : // 
$DOC_STANDARD['line_ech_max']=3;//SLCT()// Nombre de lignes d'echeances à afficher //  //0@1@2@3
$DOC_STANDARD['line_regl_max']=3;//SLCT()// Nombre de lignes de règlement à afficher //  //0@1@2@3
// FIN PARAMETRES MODIFIABLES
// CONFIGURATION PAR DEFAUT
// Portion de code recopiée dans la partie « paramètres modifiables » en cas de remise à 0 des paramètres.
/*
$DOC_STANDARD['LIB_NEG']="Facture d'avoir";//TXTE()// Libellé si total négatif // 
$DOC_STANDARD['TEXTE_CORPS_PIEDS']="Aucun escompte ne sera accordé pour paiement anticipé.\nTout retard de paiement engendre des pénalités exigibles le jour suivant, calculées sur la base du taux légal + 5%.\nRéserve de propriété applicable selon la loi n°80.335 du 12 mai 1980. En cas de litige, est seul compétent le tribunal du ressort du siège social de l'entreprise.";//TXTA()// Texte entre corps et pied de page// texte sur trois lignes
$DOC_STANDARD['REF_ARTICLE']="Article";//SLCT()// Affichage de la colonne référence //  //Aucune@Article@Interne@Oem
$DOC_STANDARD['AFF_CODE_BARRE']="true";//CBOX()// Afficher le code barre en entête// 
$DOC_STANDARD['AFF_DESC']="true";//CBOX()// Afficher la description courte // 
$DOC_STANDARD['AFF_CG']="";//CBOP()// Afficher au dos les conditions générales // 
$DOC_STANDARD['CG_VERSO']="";//TXTP()// Conditions générales : // 
*/
// FIN CONFIGURATION PAR DEFAUT
// INFORMATIONS SUR L’AUTEUR
/* 
*/
?>