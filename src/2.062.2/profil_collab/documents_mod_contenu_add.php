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
    $doc_mod = new doc_mod();
    $doc_mod->setAppTarifs($document->getApp_tarifs());
    $doc_mod->setTypesDocs(explode(";", $_REQUEST['types_docs']));
    $doc_mod->setLibModele($_REQUEST['lib_mod']);
    $doc_mod->setDescModele($_REQUEST['desc_mod']);
    $doc_mod->create_doc();
    $document->copie_content($doc_mod);
    $doc_mod->link_from_doc_set_active($document->getRef_doc(), 0);
    $ref = $doc_mod->getRef_doc();
  }/* else {
    
  }*/
  
  // **********************************************************
  //                           Affichage
  // **********************************************************
  
  include ($DIR.$_SESSION['theme']->getDir_theme()."page_documents_mod_contenu_add.inc.php");
  
?>