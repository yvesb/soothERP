<?php
// *************************************************************************************************************
// PANNEAU AFFICHE EN BAS DE L'INTERFACE DE CAISSE
// *************************************************************************************************************

require ("_dir.inc.php");
require ("_profil.inc.php");
require ("_session.inc.php");

$comptes_caisses	= compte_caisse::charger_comptes_caisses($_SESSION['magasin']->getId_magasin (), true);
$magasin = $_SESSION['magasin'];

include ($DIR.$_SESSION['theme']->getDir_theme()."page_caisse_panneau_choix_caisse.inc.php");

?>