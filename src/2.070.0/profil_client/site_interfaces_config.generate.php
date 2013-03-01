<?php
// *************************************************************************************************************
// CREATION DU FICHIER DE CONFIG DES INTERFACES
// *************************************************************************************************************


require("_dir.inc.php");
require ("_profil.inc.php");
require ("_session.inc.php");

  
if (!isset($_REQUEST["duree_aff_doc_dev"]) || !is_numeric($_REQUEST["duree_aff_doc_dev"])) {$GLOBALS['_ALERTES']['choisir_duree_aff_doc_dev'] = 1;}
if (!isset($_REQUEST["duree_aff_doc_cdc"]) || !is_numeric($_REQUEST["duree_aff_doc_cdc"])) {$GLOBALS['_ALERTES']['choisir_duree_aff_doc_cdc'] = 1;}
if (!isset($_REQUEST["duree_aff_doc_fac"]) || !is_numeric($_REQUEST["duree_aff_doc_fac"])) {$GLOBALS['_ALERTES']['choisir_duree_aff_doc_fac'] = 1;}
if (!isset($_REQUEST["mail_envoi_inscriptions"])) {$GLOBALS['_ALERTES']['choisir_mail_envoi_inscriptions'] = 1;}
//if (!isset($_FILES['img_logo']) || empty($_FILES['img_logo']['tmp_name'])) {$GLOBALS['_ALERTES']['choisir_img_logo'] = 1;}
if (!isset($_REQUEST['sujet_inscription_validation']) || strlen($_REQUEST['sujet_inscription_validation']) < 1) {$GLOBALS['_ALERTES']['choisir_sujet_inscription_validation'] = 1;}
if (!isset($_REQUEST['sujet_inscription_validation_final']) || strlen($_REQUEST['sujet_inscription_validation_final']) < 1) {$GLOBALS['_ALERTES']['choisir_sujet_inscription_validation_final'] = 1;}
if (!isset($_REQUEST['sujet_modification_validation']) || strlen($_REQUEST['sujet_modification_validation']) < 1) {$GLOBALS['_ALERTES']['choisir_sujet_modification_validation'] = 1;}
if (!isset($_REQUEST['sujet_modification_validation_final']) || strlen($_REQUEST['sujet_modification_validation_final']) < 1) {$GLOBALS['_ALERTES']['choisir_sujet_modification_validation_final'] = 1;}



if (!count($GLOBALS['_ALERTES'])) {
  
		$string_file = file_get_contents($DIR.$_REQUEST['file_path']);
  $string_file = preg_replace('/\$_INTERFACE\[\'APP_TARIFS\'\] = "[A-Z]+";/', '\$_INTERFACE[\'APP_TARIFS\'] = "'.$_REQUEST['select_tarifs'].'";', $string_file);
  $string_file = preg_replace('/\$ID_MAGASIN = [0-9]+;/', '\$ID_MAGASIN = '.$_REQUEST['select_magasin'].';', $string_file);
  $string_file = preg_replace('/\$ID_CATALOGUE_INTERFACE = ([0-9]+);/', '\$ID_CATALOGUE_INTERFACE = '.$_REQUEST['select_catalogue'].';', $string_file);
	
	if (isset($_FILES['img_logo']) && !empty($_FILES['img_logo']['tmp_name'])) {
		
		$extension = strtolower(pathinfo($_FILES['img_logo']['name'], PATHINFO_EXTENSION));
		if (($extension != "jpg") && ($extension != "jpeg") && ($extension != "png") && ($extension != "gif")) {$GLOBALS['_ALERTES']['bad_extension'] = 1;}
		if (copy($_FILES['img_logo']['tmp_name'], $DIR."profil_client/themes/client_fr/images/".$_FILES['img_logo']['name'])) {
			//$GLOBALS['_ALERTES']['transfert_error'] = 1;
			$string_file = preg_replace('/\$NOM_LOGO = ".*?";/s', '\$NOM_LOGO = "'.$_FILES['img_logo']['name'].'";', $string_file);
		}
	}
  $string_file = preg_replace('/\$AFF_CAT_VISITEUR = [0-9]+;/', '\$AFF_CAT_VISITEUR = '.$_REQUEST['aff_cat_visiteur'].';', $string_file);
  $string_file = preg_replace('/\$AFF_CAT_PRIX_VISITEUR = [0-9]+;/', '\$AFF_CAT_PRIX_VISITEUR = '.$_REQUEST['aff_cat_prix_visiteur'].';', $string_file);
  $string_file = preg_replace('/\$AFF_CAT_CLIENT = [0-9]+;/', '\$AFF_CAT_CLIENT = '.$_REQUEST['aff_cat_client'].';', $string_file);
  $string_file = preg_replace('/\$AFF_CAT_PRIX_CLIENT = [0-9]+;/', '\$AFF_CAT_PRIX_CLIENT = '.$_REQUEST['aff_cat_prix_client'].';', $string_file);
  $string_file = preg_replace('/\$INSCRIPTION_ALLOWED = [0-9]+;/', '\$INSCRIPTION_ALLOWED = '.$_REQUEST['inscription_allowed'].';', $string_file);
  $string_file = preg_replace('/\$MODIFICATION_ALLOWED = [0-9]+;/', '\$MODIFICATION_ALLOWED = '.$_REQUEST['modification_allowed'].';', $string_file);
  $string_file = preg_replace('/\$ID_MAIL_TEMPLATE = [0-9]+;/', '\$ID_MAIL_TEMPLATE = '.$_REQUEST['select_mail_template'].';', $string_file);
  $string_file = preg_replace('/\$MAIL_ENVOI_INSCRIPTIONS = ".*?";/s', '\$MAIL_ENVOI_INSCRIPTIONS = "'.$_REQUEST['mail_envoi_inscriptions'].'";', $string_file);
  $string_file = preg_replace('/\$DUREE_AFF_DOC_DEV = "[0-9]+";/', '\$DUREE_AFF_DOC_DEV = "'.(intval($_REQUEST['duree_aff_doc_dev'])*3600*24).'";', $string_file);
  $string_file = preg_replace('/\$DUREE_AFF_DOC_CDC = "[0-9]+";/', '\$DUREE_AFF_DOC_CDC = "'.(intval($_REQUEST['duree_aff_doc_cdc'])*3600*24).'";', $string_file);
  $string_file = preg_replace('/\$DUREE_AFF_DOC_FAC = "[0-9]+";/', '\$DUREE_AFF_DOC_FAC = "'.(intval($_REQUEST['duree_aff_doc_fac'])*3600*24).'";', $string_file);
  $string_file = preg_replace('/\$CODE_PDF_MODELE_DEV = ".*?";/s', '\$CODE_PDF_MODELE_DEV = "'.$_REQUEST['code_pdf_modele_dev'].'";', $string_file);
  $string_file = preg_replace('/\$CODE__PDF_MODELE_CDC = ".*?";/s', '\$CODE__PDF_MODELE_CDC = "'.$_REQUEST['code_pdf_modele_cdc'].'";', $string_file);
  $string_file = preg_replace('/\$CODE__PDF_MODELE_FAC = ".*?";/s', '\$CODE__PDF_MODELE_FAC = "'.$_REQUEST['code_pdf_modele_fac'].'";', $string_file);
  $string_file = preg_replace('/\$INSCRIPTION_VALIDATION_SUJET = ".*?";/s', '\$INSCRIPTION_VALIDATION_SUJET = "'.addslashes($_REQUEST['sujet_inscription_validation']).'";', $string_file);
  $string_file = preg_replace('/\$INSCRIPTION_VALIDATION_CONTENU = ".*?";/sm', '\$INSCRIPTION_VALIDATION_CONTENU = "'.addslashes($_REQUEST['contenu_inscription_validation']).'";', $string_file);
  $string_file = preg_replace('/\$INSCRIPTION_VALIDATION_SUJET_FINAL = ".*?";/s', '\$INSCRIPTION_VALIDATION_SUJET_FINAL = "'.addslashes($_REQUEST['sujet_inscription_validation_final']).'";', $string_file);
  $string_file = preg_replace('/\$INSCRIPTION_VALIDATION_CONTENU_FINAL = ".*?";/sm', '\$INSCRIPTION_VALIDATION_CONTENU_FINAL = "'.addslashes($_REQUEST['contenu_inscription_validation_final']).'";', $string_file);
  $string_file = preg_replace('/\$SUJET_MODIFICATION_VALIDATION = ".*?";/s', '\$SUJET_MODIFICATION_VALIDATION = "'.addslashes($_REQUEST['sujet_modification_validation']).'";', $string_file);
  $string_file = preg_replace('/\$CONTENU_MODIFICATION_VALIDATION= ".*?";/sm', '\$CONTENU_MODIFICATION_VALIDATION = "'.addslashes($_REQUEST['contenu_modification_validation']).'";', $string_file);
  $string_file = preg_replace('/\$SUJET_MODIFICATION_VALIDATION_FINAL = ".*?";/s', '\$SUJET_MODIFICATION_VALIDATION_FINAL = "'.addslashes($_REQUEST['sujet_modification_validation_final']).'";', $string_file);
  $string_file = preg_replace('/\$CONTENU_MODIFICATION_VALIDATION_FINAL = ".*?";/sm', '\$CONTENU_MODIFICATION_VALIDATION_FINAL = "'.addslashes($_REQUEST['contenu_modification_validation_final']).'";', $string_file);
  $string_file = preg_replace('/\$QUISOMMESNOUS = ".*?";/sm', '\$QUISOMMESNOUS = "'.addslashes($_REQUEST['quisommesnous']).'";', $string_file);
  $string_file = preg_replace('/\$MENTIONSLEGALES = ".*?";/sm', '\$MENTIONSLEGALES = "'.addslashes($_REQUEST['mentionslegales']).'";', $string_file);
  $string_file = preg_replace('/\$CONDITIONSDEVENTES = ".*?";/sm', '\$CONDITIONSDEVENTES = "'.addslashes($_REQUEST['conditionsgeneralesdeventes']).'";', $string_file);
  $string_file = preg_replace('/\$BAS_PAGE = ".*?";/sm', '\$BAS_PAGE = "'.addslashes($_REQUEST['bas_page']).'";', $string_file);

  //echo $string_file;
  file_put_contents($DIR.$_REQUEST['file_path'], $string_file);
}

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

//include ($DIR.$_SESSION['theme']->getDir_theme()."page_site_interfaces_config.generate.inc.php");


?>

<?php

// *************************************************************************************************************
// ajout de modèle d'article pdf
// *************************************************************************************************************

// Variables nécessaires à l'affichage
$page_variables = array ();
check_page_variables ($page_variables);


//******************************************************************
// Variables communes d'affichage
//******************************************************************


// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

?>
<p>&nbsp;</p>
<p>Configuration des interfaces</p>
<p>&nbsp; </p>
<?php 
foreach ($_ALERTES as $alerte => $value) {
  echo $alerte." => ".$value."<br>";
}
?>
<script type="text/javascript">
var erreur=false;
var choisir_duree_aff_doc_dev = false;
var choisir_duree_aff_doc_cdc = false;
var choisir_duree_aff_doc_fac = false;
var choisir_mail_envoi_inscriptions = false;
var choisir_img_logo = false;
var choisir_sujet_inscription_validation = false;
var choisir_sujet_inscription_validation_final = false;
var choisir_sujet_modification_validation = false;
var choisir_sujet_modification_validation_final = false;
var bad_extension = false;
var transfert_error = false;
var texte_erreur = "";
<?php 
if (count($_ALERTES)>0) {
}
foreach ($_ALERTES as $alerte => $value) {
  if ($alerte=="choisir_duree_aff_doc_dev") {
    echo "choisir_duree_aff_doc_dev=true;";
    echo "erreur=true;\n";
  }
  if ($alerte=="choisir_duree_aff_doc_cdc") {
    echo "choisir_duree_aff_doc_cdc=true;";
    echo "erreur=true;\n";
  }
  if ($alerte=="choisir_duree_aff_doc_fac") {
    echo "choisir_duree_aff_doc_fac=true;";
    echo "erreur=true;\n";
  }
  if ($alerte=="choisir_mail_envoi_inscriptions") {
    echo "choisir_mail_envoi_inscriptions=true;";
    echo "erreur=true;\n";
  }
  if ($alerte=="choisir_img_logo") {
    echo "choisir_img_logo=true;";
    echo "erreur=true;\n";
  }
  if ($alerte=="choisir_sujet_inscription_validation") {
    echo "choisir_sujet_inscription_validation=true;";
    echo "erreur=true;\n";
  }
  if ($alerte=="choisir_sujet_inscription_validation_final") {
    echo "choisir_sujet_inscription_validation_final=true;";
    echo "erreur=true;\n";
  }
  if ($alerte=="choisir_sujet_modification_validation") {
    echo "choisir_sujet_modification_validation=true;";
    echo "erreur=true;\n";
  }
  if ($alerte=="choisir_sujet_modification_validation_final") {
    echo "choisir_sujet_modification_validation_final=true;";
    echo "erreur=true;\n";
  }
  if ($alerte=="bad_extension") {
    echo "bad_extension=true;";
    echo "erreur=true;\n";
  }
  if ($alerte=="transfert_error") {
    echo "transfert_error=true;";
    echo "erreur=true;\n";
  }
}

?>
if (erreur) {
  
  if (choisir_duree_aff_doc_dev) {
    window.parent.document.getElementById("duree_aff_doc_dev").className="alerteform_xsize";
    texte_erreur += "Vous devez choisir une durée d'affichage pour les devis.<br/>";
  } else {
    window.parent.document.getElementById("duree_aff_doc_dev").className="classinput_xsize";
  }
  if (choisir_duree_aff_doc_cdc) {
    window.parent.document.getElementById("duree_aff_doc_cdc").className="alerteform_xsize";
    texte_erreur += "Vous devez choisir une durée d'affichage pour les commandes.<br/>";
  } else {
    window.parent.document.getElementById("duree_aff_doc_cdc").className="classinput_xsize";
  }
  if (choisir_duree_aff_doc_fac) {
    window.parent.document.getElementById("duree_aff_doc_fac").className="alerteform_xsize";
    texte_erreur += "Vous devez choisir une durée d'affichage pour les factures.<br/>";
  } else {
    window.parent.document.getElementById("duree_aff_doc_fac").className="classinput_xsize";
  }
  if (choisir_mail_envoi_inscriptions) {
    window.parent.document.getElementById("mail_envoi_inscriptions").className="alerteform_xsize";
    texte_erreur += "Vous devez indiquer des adresses mails.<br/>";
  } else {
    window.parent.document.getElementById("mail_envoi_inscriptions").className="classinput_xsize";
  }
  if (choisir_img_logo) {
    window.parent.document.getElementById("img_logo").className="alerteform_xsize";
    texte_erreur += "Vous devez indiquer une image.<br/>";
  } else {
    window.parent.document.getElementById("img_logo").className="classinput_xsize";
  }
  if (bad_extension) {
    window.parent.document.getElementById("img_logo").className="alerteform_xsize";
    texte_erreur += "Vous devez sélectionner un format d'image valide.<br/>";
  } else {
	window.parent.document.getElementById("img_logo").className="classinput_xsize";
  }
  if (transfert_error) {
	    window.parent.document.getElementById("img_logo").className="alerteform_xsize";
	    texte_erreur += "Erreur lors du transfert de l'image.<br/>";
  } else {
	    window.parent.document.getElementById("img_logo").className="classinput_xsize";
  }
  if (choisir_sujet_inscription_validation) {
    window.parent.document.getElementById("sujet_inscription_validation").className="alerteform_nsize";
    texte_erreur += "Vous devez indiquer un sujet pour le mail de validation d'inscription.<br/>";
  } else {
    window.parent.document.getElementById("sujet_inscription_validation").className="classinput_nsize";
  }
  if (choisir_sujet_inscription_validation_final) {
    window.parent.document.getElementById("sujet_inscription_validation_final").className="alerteform_nsize";
    texte_erreur += "Vous devez indiquer un sujet pour le mail de validation finale d'inscription.<br/>";
  } else {
    window.parent.document.getElementById("sujet_inscription_validation_final").className="classinput_nsize";
  }
  if (choisir_sujet_modification_validation) {
    window.parent.document.getElementById("sujet_modification_validation").className="alerteform_nsize";
    texte_erreur += "Vous devez indiquer un sujet pour le mail de validation des modification.<br/>";
  } else {
    window.parent.document.getElementById("sujet_modification_validation").className="classinput_nsize";
  }
  if (choisir_sujet_modification_validation_final) {
    window.parent.document.getElementById("sujet_modification_validation_final").className="alerteform_nsize";
    texte_erreur += "Vous devez indiquer un sujet pour le mail de validation finale des modification.<br/>";
  } else {
    window.parent.document.getElementById("sujet_modification_validation_final").className="classinput_nsize";
  }
  window.parent.alerte.alerte_erreur ('Erreur de saisie', texte_erreur,'<input type="submit" id="bouton0" name="bouton0" value="Ok" />');

}
else
{

window.parent.changed = false;
window.parent.page.traitecontent('Site_interfaces_config','site_interfaces_config.php','true','sub_content');
window.parent.alerte.alerte_erreur ('Configuration effectuée', 'La configuration de l\'interface à été effectuée avec succès.','<input type="submit" id="bouton0" name="bouton0" value="Ok" />');

}

</script>