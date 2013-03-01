<?php
  // **********************************************************
  //   Création d'un modèle de contenu à partir d'un document
  // **********************************************************

  require ("_dir.inc.php");
  require ("_profil.inc.php");
  require ($DIR."_session.inc.php");
  require_once ($DIR."documents/_doc_mod.class.php");

  $ref = '';
  if (isset($_REQUEST['ref_doc']) && isset($_REQUEST['types_docs']) && isset($_REQUEST['lib_mod']) && isset($_REQUEST['desc_mod'])) {
  	$document = open_doc ($_REQUEST['ref_doc']);
    $document->majTypesDocs($_REQUEST['types_docs']);
    $document->majLibModele($_REQUEST['lib_mod']);
    $document->majDescModele($_REQUEST['desc_mod']);
  }
  
  // **********************************************************
  //                           Affichage
  // **********************************************************
  
  include ($DIR.$_SESSION['theme']->getDir_theme()."page_documents_mod_contenu_maj.inc.php");
  
?>