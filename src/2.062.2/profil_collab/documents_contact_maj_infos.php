<?php
// *************************************************************************************************************
// MAJ DES INFOS CONTACT D'UN DOCUMENT 
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


if (isset($_REQUEST['ref_doc'])) {

// ouverture des infos du document et mise à jour
	$document = open_doc ($_REQUEST['ref_doc']);


	switch ($_REQUEST['id_info_content']) {
		case "nom_contact":
			$document->maj_nom_contact (str_replace("&curren;", "€", str_replace("%u20AC", "€", urldecode($_REQUEST['info_content']))));
			break;
		case "adresse_contact":
			$document->maj_text_adresse_contact (str_replace("&curren;", "€", str_replace("%u20AC", "€", urldecode($_REQUEST['info_content']))));
			break;
		case "code_postal_contact":
			$document->maj_text_code_postal_contact (str_replace("&curren;", "€", str_replace("%u20AC", "€", urldecode($_REQUEST['info_content']))));
			break;
		case "ville_contact":
			$document->maj_text_ville_contact (str_replace("&curren;", "€", str_replace("%u20AC", "€", urldecode($_REQUEST['info_content']))));
			break;
		case "id_pays_contact":
			$document->maj_text_id_pays_contact (str_replace("&curren;", "€", str_replace("%u20AC", "€", urldecode($_REQUEST['info_content']))));
			break;
		case "adresse_livraison":
			$document->maj_text_adresse_livraison (str_replace("&curren;", "€", str_replace("%u20AC", "€", urldecode($_REQUEST['info_content']))));
			break;
		case "code_postal_livraison":
			$document->maj_text_code_postal_livraison (str_replace("&curren;", "€", str_replace("%u20AC", "€", urldecode($_REQUEST['info_content']))));
			break;
		case "ville_livraison":
			$document->maj_text_ville_livraison (str_replace("&curren;", "€", str_replace("%u20AC", "€", urldecode($_REQUEST['info_content']))));
			break;
		case "id_pays_livraison":
			$document->maj_text_id_pays_livraison (str_replace("&curren;", "€", str_replace("%u20AC", "€", urldecode($_REQUEST['info_content']))));
			break;
	}
	
	
}


?>k!