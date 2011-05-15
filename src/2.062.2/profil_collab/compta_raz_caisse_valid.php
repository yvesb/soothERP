<?php
// *************************************************************************************************************
// RAZ de caisse
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

	
compte_caisse::del_compte_caisse_contenu ($_REQUEST["id_compte_caisse"], $ESP_E_ID_REGMT_MODE);
compte_caisse::del_compte_caisse_contenu ($_REQUEST["id_compte_caisse"], $CHQ_E_ID_REGMT_MODE);
compte_caisse::del_compte_caisse_contenu ($_REQUEST["id_compte_caisse"], $CB_E_ID_REGMT_MODE);
compte_caisse::create_compte_caisse_move ($_REQUEST["id_compte_caisse"], "5", "", $_REQUEST["montant_move"],"");

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_compta_raz_caisse_valid.inc.php");

?>