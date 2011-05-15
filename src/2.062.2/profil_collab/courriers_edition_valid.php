<?php
// *************************************************************************************************************
// enregistrement du broullon de la newsletter
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

$ref_destinataire = $_REQUEST["ref_destinataire"];

$courrier = new CourrierEtendu($_REQUEST["id_courrier"]);
$courrier->setContenu($_REQUEST["contenu_courrier"]);
$courrier->setObjet($_REQUEST["objet_courrier"]);
$courrier->setId_type_courrier($_REQUEST["id_type_courrier"]);




// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************
include ($DIR.$_SESSION['theme']->getDir_theme()."page_courrier_edition_valid.inc.php");

?>