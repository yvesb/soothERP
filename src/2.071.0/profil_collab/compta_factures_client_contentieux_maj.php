<?php
// *************************************************************************************************************
// ENVOI DE LA RELANCE
// *************************************************************************************************************

require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");
require_once ($DIR."/profil_client/_contact_client.class.php");


	if (!isset($_REQUEST['ref_client'])) {
		echo "La référence client n'est pas précisée";
		exit;
	}

	if (!isset($_REQUEST['id_edition_mode'])) {
		echo "Le mode d'édition n'est pas précisée";
		exit;
	}
	if (!isset($_REQUEST['id_niveau_relance'])) {
		echo "Le niveau de relance n'est pas précisée";
		exit;
	}        
	$ref_client      = $_REQUEST['ref_client'];
        $id_edition_mode = $_REQUEST['id_edition_mode'];
        $id_niveau_relance = $_REQUEST['id_niveau_relance'];

        generer_relance_client($ref_client,$id_niveau_relance,$id_edition_mode);
        $relances = get_Factures_pour_niveau_relance($id_niveau_relance);
        //$client = new contact_client($ref_client);

        $factures_relancees = $relances[$ref_client];        
        foreach($factures_relancees as $ref_doc => $infos){
            $facture = open_doc($ref_doc);
            //_vardump($facture);
            $niveau_sup = $facture->get_niveau_relance_sup();
            if($niveau_sup != false)
            $facture->maj_id_niveau_relance($niveau_sup);
        }

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_compta_factures_client_contentieux_maj.inc.php");
?>
