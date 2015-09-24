<?php
//  ******************************************************
// CONFIG DES INTERFACES
//  ******************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

if (isset($_REQUEST['int_path']) && file_exists($CORE_DIR.$_REQUEST['int_path']."form_interface.config.php")) {
  include_once($CORE_DIR.$_REQUEST['int_path']."form_interface.config.php");
}

?>