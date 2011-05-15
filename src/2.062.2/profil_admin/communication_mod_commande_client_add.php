<?php
// *************************************************************************************************************
// AJOUT D'UN MODELE PDF
// *************************************************************************************************************

require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");




//vérification des données reçues
if (!isset($_REQUEST["choix_source"])  || ($_REQUEST["choix_source"] != 1 && $_REQUEST["choix_source"] != 2)  ) {$GLOBALS['_ALERTES']['choisir_source'] = 1; }
if (isset($_REQUEST["choix_source"]) && $_REQUEST["choix_source"] == 1 ) {
  if ($_REQUEST["lib_modele"] == "") {$GLOBALS['_ALERTES']['indiquer_lib_modele'] = 1;}
  if (!isset($_REQUEST["id_pdf_modele"]) || $_REQUEST["id_pdf_modele"] == "") {$GLOBALS['_ALERTES']['choisir_id_pdf_modele'] = 1;}
}
if (isset($_REQUEST["choix_source"]) && $_REQUEST["choix_source"] == 2 ) {
  if ($_REQUEST["lib_modele"] == "") {$GLOBALS['_ALERTES']['indiquer_lib_modele'] = 1;}
  if (empty($_FILES['file_1']['tmp_name']) || empty($_FILES['file_2']['tmp_name'])) {$GLOBALS['_ALERTES']['indiquer_fichiers_source'] = 1;}
}

if (!count($GLOBALS['_ALERTES'])) {

  //création à partir d'un modele existant
  if (isset($_REQUEST["choix_source"]) && $_REQUEST["choix_source"] == 1 ) {

    //récupération du modele pdf choisi pour etre dupliqué
    $model_infos = charge_modele_pdf ($_REQUEST["id_pdf_modele"]);
    
    $query = "SELECT MAX(id_pdf_modele) indent FROM pdf_modeles  ";
    $resultat = $bdd->query($query);
    $tmp = $resultat->fetchObject();
    $indent = $tmp->indent+1;
    //creation du nouveau code_pdf_modele
    $class_name = preg_replace("#^\d+$#", "", $model_infos->code_pdf_modele).$indent;

    $config_name = $class_name;

    //verification de principe que ce nom n'existe pas
    $query = "SELECT  code_pdf_modele FROM pdf_modeles WHERE code_pdf_modele = '".$class_name."'  ";
    $resultat = $bdd->query($query);
   
    if (!$tmp = $resultat->fetchObject()) {
   
     	// on passe à la suite
    	// ouverture des fichiers
   		$old_config_file = file($PDF_MODELES_DIR."config/".$model_infos->code_pdf_modele.".config.php");
     	$old_class_file = file($PDF_MODELES_DIR.$model_infos->code_pdf_modele.".class.php");
   
     	// modification du nom de class dans les fichiers
     	$new_config_file = array();
	    $new_class_file = array();
	    foreach ($old_config_file as $old_config_line) {  
	        $new_config_file[] = str_replace($model_infos->code_pdf_modele, $class_name, $old_config_line);
	    }
     
      foreach ($old_class_file as $old_class_line) {
        $new_class_file[] = str_replace($model_infos->code_pdf_modele, $class_name, $old_class_line);
      }
      // enregistrement des nouveaux fichiers de class et config
      $new_class_id = fopen ($PDF_MODELES_DIR.$class_name.".class.php", "w");
      foreach ($new_class_file as $line) {
        fwrite($new_class_id, $line);
      }
      fclose($new_class_id);
     
      $new_config_id = fopen ($PDF_MODELES_DIR."config/".$class_name.".config.php", "w");
      foreach ($new_config_file as $line) {
        fwrite($new_config_id, $line);
      }
     
      fclose($new_config_id);
        
    } else {
      //on ne vas pas plus loin dans l'insertion
      $GLOBALS['_ALERTES']['exist_pdf_modele'];
    }
  }
  
 
  //création à partir d'un nouveau modele
  if (isset($_REQUEST["choix_source"]) && $_REQUEST["choix_source"] == 2 ) {
  	 
    if (!empty($_FILES['file_1']['tmp_name'])) {
        
      //copie du fichier
      if (  substr_count($_FILES["file_1"]["name"], ".config.php")) {
        $config_name = str_replace(".config.php","",$_FILES["file_1"]["name"] );
      } else if ( substr_count($_FILES["file_1"]["name"], ".class.php")) {
        $class_name = str_replace(".class.php","",$_FILES["file_1"]["name"] );
      } 
    }
    	  
  
    if (!empty($_FILES['file_2']['tmp_name'])) {
        
      //copie du fichier
      if (  substr_count($_FILES["file_2"]["name"], ".config.php")) {
        $config_name = str_replace(".config.php","",$_FILES["file_2"]["name"] );
      } else if ( substr_count($_FILES["file_2"]["name"], ".class.php")) {
        $class_name = str_replace(".class.php","",$_FILES["file_2"]["name"] );
      } 
    }
    //vérification de la   présence de ce modele dans la base

    $query = "SELECT  code_pdf_modele FROM pdf_modeles WHERE code_pdf_modele = '".$class_name."'  ";
    $resultat = $bdd->query($query);
    
    if (!$tmp = $resultat->fetchObject()) {
      //si le ce type de class n'as pas déjà été installée, alors on copie les fichiers
      if (!empty($_FILES['file_1']['tmp_name'])) {
    
        //copie du fichier
        if (  substr_count($_FILES["file_1"]["name"], ".config.php")) {
          $rc = copy ($_FILES['file_1']['tmp_name'], $PDF_MODELES_DIR."config/".$_FILES["file_1"]["name"]);
          
        } else if ( substr_count($_FILES["file_1"]["name"], ".class.php")) {
          
          copy ($_FILES['file_1']['tmp_name'], $PDF_MODELES_DIR.$_FILES["file_1"]["name"]);
        } 
        
      }
      if (!empty($_FILES['file_2']['tmp_name'])) {
   
        //copie du fichier
        if (  substr_count($_FILES["file_2"]["name"], ".config.php")) {
          copy ($_FILES['file_2']['tmp_name'], $PDF_MODELES_DIR."config/".$_FILES["file_2"]["name"]);
        } else if ( substr_count($_FILES["file_2"]["name"], ".class.php")) {
          copy ($_FILES['file_2']['tmp_name'], $PDF_MODELES_DIR.$_FILES["file_2"]["name"]);
        } 
      }
    } else {
      //on ne vas pas plus loin dans l'insertion
      $GLOBALS['_ALERTES']['exist_pdf_modele'] = 1;
    }
  
  }

  //les fichiers sont copiés , il n'y a pas d'erreur de class, on enregistre les infos dans la base
  if (isset($class_name) && isset($config_name) && ($class_name == $config_name) && !count($GLOBALS['_ALERTES'])) {
 
    $query = "INSERT INTO pdf_modeles (id_pdf_type, lib_modele, desc_modele , code_pdf_modele)
              VALUES ('8', '".addslashes($_REQUEST["lib_modele"])."', '".addslashes($_REQUEST["desc_modele"])."',
                      '".$class_name."' ) ";
    $bdd->exec ($query);
    $id_pdf_modele= $bdd->lastInsertId();
    $query = "INSERT INTO pdf_modeles_usage (id_pdf_modele,id_objet, `usage`)
              VALUES ('".$id_pdf_modele."','8', 'inactif' ) ";
    $bdd->exec ($query);
    
  }
}

  // *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_communication_mod_commande_client_add.inc.php");
?>  