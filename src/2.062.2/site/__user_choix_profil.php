<?php
// *************************************************************************************************************
// PAGE DE CHOIX DU PROFIL DE L'UTILISATEUR 
// *************************************************************************************************************

$_PAGE['MUST_BE_LOGIN'] = 1;

require ("__dir.inc.php");
require ($DIR."_session.inc.php");


// Choix du profil de l'utilisateur
if (isset ($_REQUEST['id_profil'])) {   
  // Redirection vers la page d'accueil de ce profil
  header("Location: ".$_ENV['CHEMIN_ABSOLU'].$_SESSION['interfaces'][$_SESSION['profils'][$_REQUEST['id_profil']]->getDefaut_id_interface()]->getDossier());
  exit();
}



// *************************************************************************************************************
// TRAITEMENTS 
// *************************************************************************************************************

// Liste des profils autorisés
$profils_allowed = $_SESSION['user']->getProfils_allowed();


if (count($profils_allowed) == 1) {
  header("Location: ".$_ENV['CHEMIN_ABSOLU'].$_SESSION['interfaces'][$_SESSION['profils'][key($profils_allowed)]->getDefaut_id_interface()]->getDossier());
  exit();
}

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************
include ($DIR.$_SESSION['theme']->getDir_theme()."page_user_choix_profil.inc.php");


?>





