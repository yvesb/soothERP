<?php
// *************************************************************************************************************
// IMPORT DU CATALOGUE
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


$import_art_categs = array();
$import_art_categs_carac_groupe = array();
$import_art_categs_carac = array();
$import_serveur = new import_serveur ($_REQUEST["ref_serveur"]);

$fichier = $import_serveur->getUrl_serveur_import().$ECHANGE_LMB_DIR."export_catalogue_send_data.php?ref_serveur=".$_SERVER['REF_SERVEUR'];
//readfile($fichier);
    // Ma propre fonction de traitement des balises ouvrantes
    function fonctionBaliseOuvrante($parseur, $nomBalise, $tableauAttributs)
    {
        global $derniereBaliseRencontree;
        global $import_art_categs;
        global $import_art_categs_carac_groupe;
        global $import_art_categs_carac;

        $derniereBaliseRencontree = $nomBalise;
				
        switch ($nomBalise) {
            case "CATEGORIE": 
                $import_art_categs[] = $tableauAttributs;
                break;
            case "CARAC_GROUPE": 
                $import_art_categs_carac_groupe[] = $tableauAttributs;
                break;
            case "CARAC": 
                $import_art_categs_carac[] = $tableauAttributs;
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
            die("Erreur XML");
    }
    
    xml_parser_free($parseurXML);
    fclose($fp);


	$list_art_categ =	import_order_by_parent ($categs, $import_art_categs, "REF_ART_CATEG", "REF_ART_CATEG_PARENT", "", "");
//print_r($import_art_categs_carac);
	$presentes_art_categ =	get_articles_categories();
// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_serveur_import_data_1.inc.php");

?>