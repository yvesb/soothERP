<?php
require_once ("_interface.config.php");
require_once ($DIR."_session.inc.php");
require_once ("_inscription_profil_client.class.php");
require ($CONFIG_DIR."profil_".$_SESSION['profils'][$CLIENT_ID_PROFIL]->getCode_profil().".config.php");
?>