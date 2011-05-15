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

        $relances = get_Factures_pour_niveau_relance($id_niveau_relance,$ref_client);
        //$client = new contact_client($ref_client);

        $factures_relancees = $relances[$ref_client];
        $ref_doc_url = "";
        foreach($factures_relancees as $ref_doc => $infos){
            if ($ref_doc_url != ""){ $ref_doc_url .= "&"; }
            $ref_doc_url .= "ref_doc[]=$ref_doc";
            $facture = open_doc($ref_doc);
            //_vardump($facture);
            $niveau_sup = $facture->get_niveau_relance_sup();
        }


        switch ($id_niveau_relance){
            case 2:
                $ref_doc_url .= "&sujet=RELANCE";
            case 3:
            case 4:
            case 5:
            case 6:
            case 7:
            case 8:
            case 9:
            case 10:
            case 11:
                break;
        }
        $modele = new msg_modele_relance_client(3);
        $modele->initvars($ref_client, $id_niveau_relance);
        $message = urlencode($modele->get_html());

        switch ($id_edition_mode){
            case 1:
                //Création du courrier de relance
                $d = new DateTime();
                $courrier = CourrierEtendu::newCourrierEtendu(1, 24, Courrier::ETAT_EN_REDAC(), $d->format("Y-m-d H:i:s"), "Relance", htmlspecialchars_decode($modele->get_html()), $ref_client, $_SESSION['user']);

                $url = "documents_editing_print.php?$ref_doc_url&courrier=".$courrier->getId_courrier();
                $target = "_blank";
                break;
            case 2:
                $url = "documents_contact_email_send_doc.php?$ref_doc_url&message=$message&encode=1";
                $target = "formFrame";
                break;
        }
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

include ($DIR.$_SESSION['theme']->getDir_theme()."page_compta_factures_client_a_relancer_maj.inc.php");
?>
