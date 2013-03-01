<?php
// *************************************************************************************************************
// IMPORT DU CATALOGUE
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");



$import_annuaire_data_dispo = array();
$import_serveur = new import_serveur ($_REQUEST["ref_serveur"]);

$fichier = $import_serveur->getUrl_serveur_import().$ECHANGE_LMB_DIR."export_annuaire_dispo_data.php?ref_serveur=".$_SERVER['REF_SERVEUR'];
//readfile($fichier);
    // Ma propre fonction de traitement des balises ouvrantes
    function fonctionBaliseOuvrante($parseur, $nomBalise, $tableauAttributs)
    {
        global $derniereBaliseRencontree;
        global $import_annuaire_data_dispo;

        $derniereBaliseRencontree = $nomBalise;
				
        switch ($nomBalise) {
            case "ANNUAIRE_DATA": 
                $import_annuaire_data_dispo[] = $tableauAttributs;
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


//print_r($import_annuaire_data_dispo);

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_serveur_import_data_3.inc.php");

?>