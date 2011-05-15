<?php
// *************************************************************************************************************
// EDITION D'UN REGLEMENT
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


if (isset($_REQUEST["ref_reglement"])) {

	if (isset($_REQUEST["ref_doc"]) && $_REQUEST["ref_doc"] != "") {
		$ref_doc = $_REQUEST["ref_doc"];
	}
	if (isset($_REQUEST["ref_contact"]) && $_REQUEST["ref_contact"] != "") {
		$ref_contact = $_REQUEST["ref_contact"];
	}
	//maj de la tache
	$reglement = new reglement ($_REQUEST["ref_reglement"]);
	$lettrages = $reglement->getLettrages ();
	
	$reglements_infos = get_infos_reglement_type ($reglement->getId_reglement_mode(), $_REQUEST["ref_reglement"]);
}


//function de présentation des types renvoyer par $reglement->getId_reglement_mode()
function format_info($type,$val){
    switch($type){
        case 'numero_cheque' :
            $info['lib'] = 'Num&eacute;ro de ch&egrave;que';
            $info['val'] = $val;
            break;
        case 'info_banque' :
            $info['lib'] = 'Banque';
            $info['val'] = $val;
            break;
        case 'id_compte_caisse_move':
            $caisse = new compte_caisse(load_caisse_move($val)); //FIXME
            $info['lib'] = 'Caisse';
            $info['val'] = $caisse->getLib_caisse();
            break;
        case 'info_compte':
            $info['lib'] = 'Porteur';
            $info['val'] = $val;
            break;
        case 'id_compte_bancaire_dest':
            $compte_bancaire = new compte_bancaire($val);
            $info['lib'] = 'Compte bancaire';
            $info['val'] = $compte_bancaire->getLib_compte();
            break;
        default:
            $info['lib'] = '';
            $info['val'] = '';
            break;
    }
    return $info;
}

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_compta_reglements_edition.inc.php");

?>