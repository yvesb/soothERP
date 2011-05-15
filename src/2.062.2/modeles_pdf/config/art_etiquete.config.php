<?PHP 
$CONFIGURATION=1;

// CODE NON PARAMETRABLE
global $DOCUMENTS_IMG_LOGO;
global $PIED_DE_PAGE_GAUCHE_0;
global $PIED_DE_PAGE_GAUCHE_1;
global $PIED_DE_PAGE_DROIT_0;
global $PIED_DE_PAGE_DROIT_1;

$ART_STANDARD['IMG_LOGO']	= $DOCUMENTS_IMG_LOGO;
$ART_STANDARD['FONT'] = 'Times';
$ART_STANDARD['TAILLE'] = 12;
$ART_STANDARD['R'] = 0;
$ART_STANDARD['G'] = 0;
$ART_STANDARD['B'] = 0;
$ART_STANDARD['MARGE_IMAGE_GAUCHE'] = 10;
$ART_STANDARD['MARGE_IMAGE_HAUT'] = 15;
$ART_STANDARD['MARGE_PIED_HAUTEUR'] = 140;
$ART_STANDARD['PIEDS_GAUCHE'][0]	= $PIED_DE_PAGE_GAUCHE_0;
$ART_STANDARD['PIEDS_GAUCHE'][1]	= $PIED_DE_PAGE_GAUCHE_1;
$ART_STANDARD['PIEDS_DROIT'][0]	= $PIED_DE_PAGE_DROIT_0;
$ART_STANDARD['PIEDS_DROIT'][1]	= $PIED_DE_PAGE_DROIT_1;
// format du pdf
$ART_STANDARD['MOD_PDF'] = 2; //mod 0 ou 2 si autre > forcera sur 2
$ART_STANDARD['FORMAT_PDF'][0] = 29; // Mod 0
$ART_STANDARD['FORMAT_PDF'][1] = 90; // Mod 0
$ART_STANDARD['FORMAT_PDF'][2] = 102; // Mod 2
$ART_STANDARD['FORMAT_PDF'][3] = 152; // Mod 2
$ART_STANDARD['MARGE_GAUCHE'] = 2;
$ART_STANDARD['MARGE_DROITE'] = 2;
$ART_STANDARD['MARGE_HAUT'] = 2;
$ART_STANDARD['MARGE_BAS'] = 2;
// orientation
$ART_STANDARD['ORIENTATION_PDF'] = 'L';
// couleur du libellé article
$ART_STANDARD['R_LIB_ARTICLE'] = 51;
$ART_STANDARD['G_LIB_ARTICLE'] = 51;
$ART_STANDARD['B_LIB_ARTICLE'] = 204;
// couleur du prix
$ART_STANDARD['R_PRIX'] = 0;
$ART_STANDARD['G_PRIX'] = 0;
$ART_STANDARD['B_PRIX'] = 0;
// emplacement du logo
$ART_STANDARD['CHEMIN_LOGO'] = $DOCUMENTS_IMG_LOGO;
// contenu du texte en pied de page
$ART_STANDARD['TEXTE_PIED'] = "";

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