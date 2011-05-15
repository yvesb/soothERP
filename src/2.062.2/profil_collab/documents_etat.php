<?php
// *************************************************************************************************************
// AFFICAHE DANS UN SELECT DES ETATS D'UN DOCUMENT EN FONCTION DU TYPE DE DOCU (moteur de recherche document)
// *************************************************************************************************************



require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

if (array_key_exists("doc_type", $_REQUEST)) {
  $tomorrow = 0;//60*60*24; // en nb de secondes
  header("Cache-Control: max-age=$tomorrow");
  print_plain();
}
else {
  print "Usage : $_SERVER[PHP_SELF]?cat=un-nom";
}

function print_plain() {
  header("Content-type: text/html; charset=windows-1252");
  get_etat(urldecode ($_REQUEST["doc_type"]));
  
}

?>