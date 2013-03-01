<?php
// *************************************************************************************************************
// ACCUEIL COMPTA CLIENT
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");
if (isset($_REQUEST['niveau_relance_var'])){
    $niveau_relance_var = $_REQUEST['niveau_relance_var'];
}else{
    $niveau_relance_var = 12;
}
$relances = get_Factures_pour_niveau_relance($niveau_relance_var);
$editions_modes = getEdition_modes_actifs();
$reglements_modes = getReglements_modes();
//$categorie_client_var = $DEFAUT_ID_CLIENT_CATEG;

$categorie_client_var = 1;



$liste_niveaux_relance = getNiveaux_relance ($categorie_client_var) ;

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_compta_factures_client_contentieux.inc.php");

?>
