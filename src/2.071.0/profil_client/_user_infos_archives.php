<?php

// *************************************************************************************************************
// INSCRIPTION DE L'UTILISATEUR CLIENT
// *************************************************************************************************************


require("_dir.inc.php");
require("_profil.inc.php");
require("_session.inc.php");


//$interface = new interfaces ($ID_INTERFACE);
if (isset($_REQUEST['id_type_doc']) && isset($_REQUEST['id_etat_doc']) && isset($_REQUEST['ref_contact'])){
  $docs_archives = get_liste_doc($_REQUEST['id_type_doc'], $_REQUEST['id_etat_doc'], $_REQUEST['ref_contact']);
}
  
// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_user_infos_archives.inc.php");
?>