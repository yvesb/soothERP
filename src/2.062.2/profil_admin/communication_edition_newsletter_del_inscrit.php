<?php
// *************************************************************************************************************
// GESTION DES NEWSLETTER supression d'un inscrit
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


$newsletter = new newsletter ($_REQUEST['id_newsletter']);
$newsletter->del_newsletter_inscrit ($_REQUEST["email"]);

?>