<?php
// *************************************************************************************************************
// IMPORT DES ARTICLES
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");




$import_annuaire_contact = array();
$import_annuaire_coord = array();
$import_annuaire_adresse = array();
$import_annuaire_site = array();
$import_annuaire_profil = array();
$import_serveur = new import_serveur ($_REQUEST["ref_serveur"]);

$fichier = $import_serveur->getUrl_serveur_import().$ECHANGE_LMB_DIR."export_annuaire_send_data.php?ref_serveur=".$_SERVER['REF_SERVEUR']."&id_annuaire_data=".$_REQUEST["id_annuaire_data"];

//readfile($fichier);
    // Ma propre fonction de traitement des balises ouvrantes
    function fonctionBaliseOuvrante($parseur, $nomBalise, $tableauAttributs)
    {
        global $derniereBaliseRencontree;
        global $import_annuaire_contact;
        global $import_annuaire_coord;
        global $import_annuaire_adresse;
        global $import_annuaire_site;
        global $import_annuaire_profil;

        $derniereBaliseRencontree = $nomBalise;
				
        switch ($nomBalise) {
            case "CONTACT": 
                $import_annuaire_contact[] = $tableauAttributs;
                break;
            case "COORDONNEES": 
                $import_annuaire_coord[] = $tableauAttributs;
                break;
            case "ADRESSES": 
                $import_annuaire_adresse[] = $tableauAttributs;
                break;
            case "SITES": 
                $import_annuaire_site[] = $tableauAttributs;
                break;
            case "PROFIL": 
                $import_annuaire_profil[] = $tableauAttributs;
                break;
        } 
    }
   
    // Fonction de traitement des balises fermantes
    function fonctionBaliseFermante($parseur, $nomBalise)
    {
        // On oublie la dernière balise rencontrée
        global $derniereBaliseRencontree;

        $derniereBaliseRencontree = "";
    }

    //Fonction de traitement du texte
    // qui est appelée par le "parseur"
    function fonctionTexte($parseur, $texte)
    {
    }

    // Création du parseur XML
    $parseurXML = xml_parser_create("ISO-8859-1");

    // Nom des fonctions à appeler
    // lorsque des balises ouvrantes ou fermantes sont rencontrées
    xml_set_element_handler($parseurXML, "fonctionBaliseOuvrante"
                                       , "fonctionBaliseFermante");

    // Nom de la fonction à appeler
    // lorsque du texte est rencontré
    xml_set_character_data_handler($parseurXML, "fonctionTexte");

    // Ouverture du fichier
    $fp = fopen($fichier, "r");
    if (!$fp) die("Impossible d'ouvrir le fichier XML");

    // Lecture ligne par ligne
    while ( $ligneXML = fgets($fp, 1024)) {
        // Analyse de la ligne
        // REM: feof($fp) retourne TRUE s'il s'agit de la dernière
        //      ligne du fichier.
        xml_parse($parseurXML, $ligneXML, feof($fp)) or
            die(xml_error_string (xml_get_error_code ($parseurXML))." ".xml_get_current_column_number ($parseurXML)." ".xml_get_current_line_number ($parseurXML)." ".substr($ligneXML, 0, xml_get_current_column_number ($parseurXML))." Erreur XML");
    }
    
    xml_parser_free($parseurXML);
    fclose($fp);
		
$count_import = 0;

foreach ($import_annuaire_contact as $annuaire_contact) {
	if (count($GLOBALS['_ALERTES'])) { $GLOBALS['_ALERTES'] = array();}
	if (count($GLOBALS['_INFOS'])) {$GLOBALS['_INFOS'] = array();}
	
@ob_start();
	$contact = new contact ($annuaire_contact["REF_CONTACT"]);
	
	if (!$contact->getRef_contact()) {
	
		$infos_generales['ref_contact'] = $annuaire_contact["REF_CONTACT"];
		$infos_generales['id_civilite'] = $annuaire_contact["ID_CIVILITE"];
		$infos_generales['nom'] 				= htmlspecialchars_decode($annuaire_contact["NOM"]);
		$infos_generales['id_categorie']= $annuaire_contact["ID_CATEGORIE"];
		$infos_generales['note'] 				= htmlspecialchars_decode($annuaire_contact["NOTE"]);
		$infos_generales['siret'] 				= htmlspecialchars_decode($annuaire_contact["SIRET"]);
		$infos_generales['tva_intra'] 				= htmlspecialchars_decode($annuaire_contact["TVA_INTRA"]);
		$infos_generales['adresses']		= array();
		$infos_generales['coordonnees']	= array();
		$infos_generales['sites']				= array();
		
		foreach ($import_annuaire_adresse as $annuaire_adresse) {
			if($annuaire_contact["REF_CONTACT"] != $annuaire_adresse["REF_CONTACT"]) {continue;}
			$infos_generales['adresses'][] = array('lib_adresse' => htmlspecialchars_decode($annuaire_adresse["LIB_ADRESSE"]), 'text_adresse' => htmlspecialchars_decode($annuaire_adresse["TEXT_ADRESSE"]), 'code_postal' => $annuaire_adresse["CODE_POSTAL"], 'ville' =>  $annuaire_adresse["VILLE"], 'id_pays' => $annuaire_adresse["ID_PAYS"], 'note' => htmlspecialchars_decode($annuaire_adresse["NOTE"]), 'ref_adresse' =>$annuaire_adresse["REF_ADRESSE"]);
		}
	
		foreach ($import_annuaire_coord as $annuaire_coord) {
			if($annuaire_contact["REF_CONTACT"] != $annuaire_coord["REF_CONTACT"]) {continue;}
			$email_user_creation = 0;
			$infos_generales['coordonnees'][]	= array('lib_coord' => htmlspecialchars_decode($annuaire_coord["LIB_COORD"]), 'tel1' => $annuaire_coord["TEL1"], 'tel2' => $annuaire_coord["TEL2"], 'fax' => $annuaire_coord["FAX"], 'email' => $annuaire_coord["EMAIL"], 'note' => htmlspecialchars_decode($annuaire_coord["NOTE"]), 'ref_coord_parent' => NULL, 'email_user_creation' => $email_user_creation, 'ref_coord' => $annuaire_coord["REF_COORD"] );
		}
		
		foreach ($import_annuaire_site as $annuaire_site) {
			if($annuaire_contact["REF_CONTACT"] != $annuaire_site["REF_CONTACT"]) {continue;}
			$infos_generales['sites'][] = array('lib_site_web' => htmlspecialchars_decode($annuaire_site["LIB_SITE_WEB"]), 'url' => htmlspecialchars_decode($annuaire_site["URL"]), 'login' => $annuaire_site["LOGIN"], 'pass' => $annuaire_site["PASS"], 'note' => htmlspecialchars_decode($annuaire_site["NOTE"]), 'ref_site' => $annuaire_site["REF_SITE"] );
		}
		
		$infos_profils = array();
		foreach ($import_annuaire_profil as $annuaire_profil) {
			if (!isset($_SESSION['profils'][$annuaire_profil["ID_PROFIL"]])) { continue; }
			$infos_profils[$annuaire_profil["ID_PROFIL"]]['id_profil'] = $annuaire_profil["ID_PROFIL"];
			switch ($annuaire_profil["ID_PROFIL"]) {
			
				case "2":
					$infos_profils[$annuaire_profil["ID_PROFIL"]]['type_admin'] =  $annuaire_profil['TYPE_ADMIN'];
				break;
				
				case "3":
					$infos_profils[$annuaire_profil["ID_PROFIL"]]['numero_secu'] 					=  $annuaire_profil['NUMERO_SECU'];
					$infos_profils[$annuaire_profil["ID_PROFIL"]]['date_naissance'] 			=  $annuaire_profil['DATE_NAISSANCE'];
					$infos_profils[$annuaire_profil["ID_PROFIL"]]['lieu_naissance'] 			=  $annuaire_profil['LIEU_NAISSANCE'];
					$infos_profils[$annuaire_profil["ID_PROFIL"]]['id_pays_nationalite'] 	=  $annuaire_profil['ID_PAYS_NATIONALITE'];
					$infos_profils[$annuaire_profil["ID_PROFIL"]]['situation_famille'] 		=  $annuaire_profil['SITUATION_FAMILLE'];
					$infos_profils[$annuaire_profil["ID_PROFIL"]]['nbre_enfants'] 				=  $annuaire_profil['NBRE_ENFANTS'];
				break;
				
				case "4":
					contact::load_profil_class(4);
					$liste_categories_client = contact_client::charger_clients_categories ();
					
					$id_client_categ = NULL;
					foreach ($liste_categories_client as $liste_categorie_client){
						if($annuaire_profil['ID_CLIENT_CATEG'] == $liste_categorie_client->id_client_categ) {$id_client_categ = $annuaire_profil['ID_CLIENT_CATEG'];}
					}
					$infos_profils[$annuaire_profil["ID_PROFIL"]]['id_client_categ'] 			=  $id_client_categ;
					$liste_tarifs = get_full_tarifs_listes ();
					$id_tarif = NULL;
					foreach($liste_tarifs as $tarif) {
						if ($tarif->id_tarif == $annuaire_profil['ID_TARIF']) {$id_tarif = $annuaire_profil['ID_TARIF'];}
					}
					$infos_profils[$annuaire_profil["ID_PROFIL"]]['id_tarif'] 						=  $id_tarif;
					$infos_profils[$annuaire_profil["ID_PROFIL"]]['ref_adr_livraison'] 		=  $annuaire_profil['REF_ADR_LIVRAISON'];
					$infos_profils[$annuaire_profil["ID_PROFIL"]]['ref_adr_facturation'] 	=  $annuaire_profil['REF_ADR_FACTURATION'];
					$infos_profils[$annuaire_profil["ID_PROFIL"]]['app_tarifs'] 					=  $annuaire_profil['APP_TARIFS'];
					$infos_profils[$annuaire_profil["ID_PROFIL"]]['facturation_periodique'] 		=  $annuaire_profil['FACTURES_PAR_MOIS'];
					$infos_profils[$annuaire_profil["ID_PROFIL"]]['encours']					 		=  $annuaire_profil['ENCOURS'];
					$infos_profils[$annuaire_profil["ID_PROFIL"]]['delai_reglement'] 			=  $annuaire_profil['DELAI_REGLEMENT'];
				break;
				
				case "5":
					contact::load_profil_class(5);
					$liste_categories_fournisseur = contact_fournisseur::charger_fournisseurs_categories ();
					
					$id_fournisseur_categ = NULL;
					foreach ($liste_categories_fournisseur as $liste_categorie_fournisseur){
						if($annuaire_profil['ID_FOURNISSEUR_CATEG'] == $liste_categorie_fournisseur->id_fournisseur_categ) {$id_fournisseur_categ = $annuaire_profil['ID_FOURNISSEUR_CATEG'];}
					}
					$infos_profils[$annuaire_profil["ID_PROFIL"]]['code_client'] 							=  $annuaire_profil['CODE_CLIENT'];
					$infos_profils[$annuaire_profil["ID_PROFIL"]]['conditions_commerciales'] 	=  htmlspecialchars_decode($annuaire_profil['CONDITIONS_COMMERCIALES']);
					$infos_profils[$annuaire_profil["ID_PROFIL"]]['id_fournisseur_categ'] 		=  $id_fournisseur_categ;
					$id_stock_livraison = NULL;
					if (isset($_SESSION['stocks'][$annuaire_profil['ID_STOCK_LIVRAISON']])){ $id_stock_livraison = $annuaire_profil['ID_STOCK_LIVRAISON'];}
					$infos_profils[$annuaire_profil["ID_PROFIL"]]['id_stock_livraison'] 			=  $id_stock_livraison;
					$infos_profils[$annuaire_profil["ID_PROFIL"]]['delai_livraison'] 					=  $annuaire_profil['DELAI_LIVRAISON'];
				break;
				
				case "6":
					$infos_profils[$annuaire_profil["ID_PROFIL"]]['identifiant_revendeur'] 	=  $annuaire_profil['IDENTIFIANT_REVENDEUR'];
					$infos_profils[$annuaire_profil["ID_PROFIL"]]['conditions_garantie'] 		=  htmlspecialchars_decode($annuaire_profil['CONDITIONS_GARANTIE']);
				break;
			}
		}
		
		// *************************************************
		// Création du contact
		$contact->create ($infos_generales, $infos_profils);
		
		$count_import++;
		
		$profils 	= $contact->getProfils();
		//chargement de la class contact_collab
		if(isset($profils[$COLLAB_ID_PROFIL]) && isset($annuaire_profil['COLLAB_FONCTIONS'])) {
			//groupes de collaborateurs
			$liste_fonctions_collab = charger_fonctions ($COLLAB_ID_PROFIL);
			$collab_fonctions = explode(";", $annuaire_profil['COLLAB_FONCTIONS']);
			//on parcours les groupes pour retrouver les categories de collaborateurs cochées
			foreach ($liste_fonctions_collab as $liste_fonction_collab) {
				foreach ($collab_fonctions as $collab_fonction) {
					if ($collab_fonction == $liste_fonction_collab->id_fonction) {
					$profils[$COLLAB_ID_PROFIL]->add_fonction ($liste_fonction_collab->id_fonction);
					}
				}
			}
			
		}
		
					foreach ($GLOBALS['_ALERTES'] as $alerte => $value) {
						echo $alerte." => ".$value."<br />";
					}
	}

}


//htmlspecialchars_decode
// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_serveur_import_data_3_maj.inc.php");

?>