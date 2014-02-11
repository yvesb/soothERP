<?php
// *************************************************************************************************************
// FORMULAIRE DE CONFIG DU PROFIL CLIENT
// *************************************************************************************************************

$_INTERFACE['MUST_BE_LOGIN'] = 1;
require("_dir.inc.php");
require ("_profil.inc.php");
require ("_session.inc.php");


$liste_magasins = charger_all_magasins();
$liste_catalogues =  catalogue_client::charger_liste_catalogues_clients();
$liste_mail_templates = charger_mail_templates(); 
$liste_pdfs_dev = charger_modeles_pdf_valides(1);
$liste_pdfs_cdc = charger_modeles_pdf_valides(2);
$liste_pdfs_fac = charger_modeles_pdf_valides(4);

$string_config_file = file_get_contents($DIR."profil_client/_interface.config.php");
require($DIR."profil_client/_interface.config.php");
$matches = array();
// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

?>
<div id="popup_search_contact" class="mini_moteur_doc" style="display:none;" ></div>
<br />
<form id="configure_interface" name="configure_interface" enctype="multipart/form-data" action="<?php echo $DIR; ?>profil_client/site_interfaces_config.generate.php" method="POST" target="formFrame">
  <input id="file_path" name="file_path" type="hidden" value="profil_client/_interface.config.php" /> 
  <table width="100%">
    <tr class="smallheight">
      <td style="width:35%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
      <td style="width:30%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
      <td style="width:25%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
    </tr>          
    <tr>
      <td class="lib_config">
        Choix du magasin : 
      </td>
      <td>
        <select id="select_magasin" name="select_magasin" class="classinput_xsize" >
        <?php foreach ($liste_magasins as $magasin) { ?>
          <option value="<?php echo $magasin->id_magasin; ?>" <?php if ($ID_MAGASIN == intval($magasin->id_magasin)) echo "selected";  ?>><?php echo $magasin->lib_magasin; ?></option>
        <?php } ?>
        </select>
      </td>
      <td class="infos_config">&nbsp;</td>
    </tr>
    <tr>
      <td class="lib_config">
        Choix des tarifs : 
      </td>
      <td>
        <select id="select_tarifs" name="select_tarifs" class="classinput_xsize" >
          <option value="HT" <?php if ($_INTERFACE['APP_TARIFS'] == "HT") echo "selected"; ?>>HT</option>
          <option value="TTC" <?php if ($_INTERFACE['APP_TARIFS'] == "TTC") echo "selected"; ?>>TTC</option>
        </select>
      </td>
      <td class="infos_config">&nbsp;</td>
    </tr>
    <tr>
      <td class="lib_config">
        Choix du catalogue : 
      </td>
      <td>
        <select id="select_catalogue" name="select_catalogue" class="classinput_xsize" >
        <?php foreach ($liste_catalogues as $catalogue) { ?>
          <option value="<?php echo $catalogue->id_catalogue_client; ?>" <?php if ($ID_CATALOGUE_INTERFACE == intval($catalogue->id_catalogue_client)) echo "selected";  ?>><?php echo $catalogue->lib_catalogue_client; ?></option>
        <?php } ?>
        </select>
      </td>
      <td class="infos_config">&nbsp;</td>
    </tr>
    <tr>
      <td class="lib_config">
        Choix du logo : 
      </td>
      <td>
        <input id="img_logo" name="img_logo" type="file" class="classinput_xsize" /> 
      </td>
      <td class="infos_config">&nbsp;</td>
    </tr>
    <tr>
      <td class="lib_config">
        Afficher le catalogue pour les visiteurs : 
      </td>
      <td>
        <input id="aff_cat_visiteur" name="aff_cat_visiteur" type="radio" value="0"  <?php if (preg_match('/\$AFF_CAT_VISITEUR = 0;/', $string_config_file)) echo "checked"?> /> Non. 
        <input id="aff_cat_visiteur" name="aff_cat_visiteur" type="radio" value="1"  <?php if (preg_match('/\$AFF_CAT_VISITEUR = 1;/', $string_config_file)) echo "checked"?> /> Oui. 
      </td>
      <td class="infos_config">&nbsp;</td>
    </tr>
    <tr>
      <td class="lib_config">
        Afficher les prix pour les visiteurs : 
      </td>
      <td>
        <input id="aff_cat_prix_visiteur" name="aff_cat_prix_visiteur" type="radio" value="0"  <?php if (preg_match('/\$AFF_CAT_PRIX_VISITEUR = 0;/', $string_config_file)) echo "checked"?> /> Non. 
        <input id="aff_cat_prix_visiteur" name="aff_cat_prix_visiteur" type="radio" value="1"  <?php if (preg_match('/\$AFF_CAT_PRIX_VISITEUR = 1;/', $string_config_file)) echo "checked"?> /> Oui. 
      </td>
      <td class="infos_config">&nbsp;</td>
    </tr>
    <tr>
      <td class="lib_config">
        Afficher le catalogue pour les clients : 
      </td>
      <td>
        <input id="aff_cat_client" name="aff_cat_client" type="radio" value="0"  <?php if (preg_match('/\$AFF_CAT_CLIENT = 0;/', $string_config_file)) echo "checked"?> /> Non. 
        <input id="aff_cat_client" name="aff_cat_client" type="radio" value="1"  <?php if (preg_match('/\$AFF_CAT_CLIENT = 1;/', $string_config_file)) echo "checked"?> /> Oui. 
      </td>
      <td class="infos_config">&nbsp;</td>
    </tr>
    <tr>
      <td class="lib_config">
        Afficher les prix pour les clients : 
      </td>
      <td>
        <input id="aff_cat_prix_client" name="aff_cat_prix_client" type="radio" value="0"  <?php if (preg_match('/\$AFF_CAT_PRIX_CLIENT = 0;/', $string_config_file)) echo "checked"?> /> Non. 
        <input id="aff_cat_prix_client" name="aff_cat_prix_client" type="radio" value="1"  <?php if (preg_match('/\$AFF_CAT_PRIX_CLIENT = 1;/', $string_config_file)) echo "checked"?> /> Oui. 
      </td>
      <td class="infos_config">&nbsp;</td>
    </tr>
    <tr>
      <td class="lib_config">
        Autoriser l'inscription depuis le dossier : 
      </td>
      <td>
        <input id="inscription_allowed" name="inscription_allowed" type="radio" value="0"  <?php if (preg_match('/\$INSCRIPTION_ALLOWED = 0;/', $string_config_file)) echo "checked"?> /> Non.
        <input id="inscription_allowed" name="inscription_allowed" type="radio" value="1"  <?php if (preg_match('/\$INSCRIPTION_ALLOWED = 1;/', $string_config_file)) echo "checked"?> /> Oui, avec validation.
        <input id="inscription_allowed" name="inscription_allowed" type="radio" value="2" <?php if (preg_match('/\$INSCRIPTION_ALLOWED = 2;/', $string_config_file)) echo "checked"?> /> Oui, sans validation.
      </td>
      <td class="infos_config">&nbsp;</td>
    </tr>
    <tr>
      <td class="lib_config">
        Autoriser la modification depuis le dossier : 
      </td>
      <td>
        <input id="modification_allowed" name="modification_allowed" type="radio" value="0"  <?php if (preg_match('/\$MODIFICATION_ALLOWED = 0;/', $string_config_file)) echo "checked"?> /> Non.
        <input id="modification_allowed" name="modification_allowed" type="radio" value="1"  <?php if (preg_match('/\$MODIFICATION_ALLOWED = 1;/', $string_config_file)) echo "checked"?> /> Oui, avec validation.
        <input id="modification_allowed" name="modification_allowed" type="radio" value="2"  <?php if (preg_match('/\$MODIFICATION_ALLOWED = 2;/', $string_config_file)) echo "checked"?> /> Oui, sans validation.
      </td>
      <td class="infos_config">&nbsp;</td>
    </tr>
    <tr>
      <td class="lib_config">
        Durée d'affichage des devis clients : 
      </td>
      <td>
        <input id="duree_aff_doc_dev" name="duree_aff_doc_dev" type="text" class="classinput_xsize" value="<?php preg_match("/.*?DUREE_AFF_DOC_DEV = \"(.*?)\";.*?/", $string_config_file, $matches); if(count($matches)>0) echo intval($matches[1])/3600/24; ?>"/>
      </td>
      <td class="infos_config">Jours</td>
    </tr>
    <tr>
      <td class="lib_config">
        Durée d'affichage des commandes clients : 
      </td>
      <td>
        <input id="duree_aff_doc_cdc" name="duree_aff_doc_cdc" type="text" class="classinput_xsize"  value="<?php preg_match("/.*?DUREE_AFF_DOC_CDC = \"(.*?)\";.*?/", $string_config_file, $matches); if(count($matches)>0) echo intval($matches[1])/3600/24; ?>"/>
      </td>
      <td class="infos_config">Jours</td>
    </tr>
    <tr>
      <td class="lib_config">
        Durée d'affichage des factures clients : 
      </td>
      <td>
        <input id="duree_aff_doc_fac" name="duree_aff_doc_fac" type="text" class="classinput_xsize"  value="<?php preg_match("/.*?DUREE_AFF_DOC_FAC = \"(.*?)\";.*?/", $string_config_file, $matches); if(count($matches)>0) echo intval($matches[1])/3600/24; ?>"/>
      </td>
      <td class="infos_config">Jours</td>
    </tr>
    <tr>
      <td class="lib_config">
        Choix du modèle de pdf pour les devis : 
      </td>
      <td>
        <select id="code_pdf_modele_dev" name="code_pdf_modele_dev" class="classinput_xsize" >
        <?php foreach ($liste_pdfs_dev as $pdf_dev) { ?>
          <option value="<?php echo $pdf_dev->code_pdf_modele; ?>" <?php if ($CODE_PDF_MODELE_DEV == $pdf_dev->code_pdf_modele) echo "selected";  ?>><?php echo $pdf_dev->lib_modele; ?></option>
        <?php } ?>
        </select>
      </td>
      <td class="infos_config">&nbsp;</td>
    </tr>
    <tr>
      <td class="lib_config">
        Choix du modèle de pdf pour les commandes : 
      </td>
      <td>
        <select id="code_pdf_modele_cdc" name="code_pdf_modele_cdc" class="classinput_xsize" >
        <?php foreach ($liste_pdfs_cdc as $pdf_cdc) { ?>
          <option value="<?php echo $pdf_cdc->code_pdf_modele; ?>" <?php if ($CODE__PDF_MODELE_CDC == $pdf_cdc->code_pdf_modele) echo "selected";  ?>><?php echo $pdf_cdc->lib_modele; ?></option>
        <?php } ?>
        </select>
      </td>
      <td class="infos_config">&nbsp;</td>
    </tr>
    <tr>
      <td class="lib_config">
        Choix du modèle de pdf pour les factures : 
      </td>
      <td>
        <select id="code_pdf_modele_fac" name="code_pdf_modele_fac" class="classinput_xsize" >
        <?php foreach ($liste_pdfs_fac as $pdf_fac) { ?>
          <option value="<?php echo $pdf_fac->code_pdf_modele; ?>" <?php if ($CODE__PDF_MODELE_FAC == $pdf_fac->code_pdf_modele) echo "selected";  ?>><?php echo $pdf_fac->lib_modele; ?></option>
        <?php } ?>
        </select>
      </td>
      <td class="infos_config">&nbsp;</td>
    </tr>
    <tr>
      <td class="lib_config">
        Choix de la template pour les emails : 
      </td>
      <td>
        <select id="select_mail_template" name="select_mail_template" class="classinput_xsize" >
        <?php foreach ($liste_mail_templates as $mail_template) { ?>
          <option value="<?php echo $mail_template->id_mail_template; ?>" <?php if (!empty($catalogue) && $ID_MAIL_TEMPLATE == intval($catalogue->id_catalogue_client)) echo "selected";  ?>><?php echo $mail_template->lib_mail_template; ?></option>
        <?php } ?>
        </select>
      </td>
      <td class="infos_config">&nbsp;</td>
    </tr>
    <tr>
      <td class="lib_config">
        Sujet du mail de validation d'inscription : 
      </td>
      <td>
        <input id="sujet_inscription_validation" name="sujet_inscription_validation" type="text" class="classinput_xsize" value="<?php preg_match("/.*?INSCRIPTION_VALIDATION_SUJET = \"(.*?)\";.*?/", $string_config_file, $matches); if(count($matches)>0) echo stripslashes($matches[1]); ?>"/>
      </td>
      <td class="infos_config">&nbsp;</td>
    </tr>
    <tr>
      <td class="lib_config">
        Contenu du mail de validation d'inscription : 
      </td>
      <td>
       <textarea id="contenu_inscription_validation" name="contenu_inscription_validation" class="classinput_xsize"><?php preg_match("/.*?INSCRIPTION_VALIDATION_CONTENU = \"(.*?)\";/sm", $string_config_file, $matches); if(count($matches)>0) echo stripslashes($matches[1]); ?></textarea>
      </td>
      <td class="infos_config">&nbsp;</td>
    </tr>
    <tr>
      <td class="lib_config">
        Sujet du mail de validation finale d'inscription : 
      </td>
      <td>
        <input id="sujet_inscription_validation_final" name="sujet_inscription_validation_final" type="text" class="classinput_xsize"  value="<?php preg_match("/.*?INSCRIPTION_VALIDATION_SUJET_FINAL = \"(.*?)\";.*?/", $string_config_file, $matches); if(count($matches)>0) echo stripslashes($matches[1]); ?>"/>
      </td>
      <td class="infos_config">&nbsp;</td>
    </tr>
    <tr>
      <td class="lib_config">
        Contenu du mail de validation finale d'inscription : 
      </td>
      <td>
        <textarea id="contenu_inscription_validation_final" name="contenu_inscription_validation_final" class="classinput_xsize" ><?php preg_match("/.*?INSCRIPTION_VALIDATION_CONTENU_FINAL = \"(.*?)\";.*?/sm", $string_config_file, $matches); if(count($matches)>0) echo stripslashes($matches[1]); ?></textarea>
      </td>
      <td class="infos_config">&nbsp;</td>
    </tr>
    <tr>
      <td class="lib_config">
        Sujet du mail de validation des modifications : 
      </td>
      <td>
        <input id="sujet_modification_validation" name="sujet_modification_validation" type="text" class="classinput_xsize"  value="<?php preg_match("/.*?SUJET_MODIFICATION_VALIDATION = \"(.*?)\";.*?/", $string_config_file, $matches); if(count($matches)>0) echo stripslashes($matches[1]); ?>"/>
      </td>
      <td class="infos_config">&nbsp;</td>
    </tr>
    <tr>
      <td class="lib_config">
        Contenu du mail de validation des modifications : 
      </td>
      <td>
        <textarea id="contenu_modification_validation" name="contenu_modification_validation" class="classinput_xsize" ><?php preg_match("/.*?CONTENU_MODIFICATION_VALIDATION = \"(.*?)\";.*?/sm", $string_config_file, $matches); if(count($matches)>0) echo stripslashes($matches[1]); ?></textarea>
      </td>
      <td class="infos_config">&nbsp;</td>
    </tr>
    <tr>
      <td class="lib_config">
        Sujet du mail de validation finale des modifications : 
      </td>
      <td>
        <input id="sujet_modification_validation_final" name="sujet_modification_validation_final" type="text" class="classinput_xsize"  value="<?php preg_match("/.*?SUJET_MODIFICATION_VALIDATION_FINAL = \"(.*?)\";.*?/", $string_config_file, $matches); if(count($matches)>0) echo stripslashes($matches[1]); ?>"/>
      </td>
      <td class="infos_config">&nbsp;</td>
    </tr>
    <tr>
      <td class="lib_config">
        Contenu du mail de validation finale des modifications : 
      </td>
      <td>
        <textarea id="contenu_modification_validation_final" name="contenu_modification_validation_final" class="classinput_xsize" ><?php preg_match("/.*?CONTENU_MODIFICATION_VALIDATION_FINAL = \"(.*?)\";.*?/sm", $string_config_file, $matches); if(count($matches)>0) echo stripslashes($matches[1]); ?></textarea>
      </td>
      <td class="infos_config">&nbsp;</td>
    </tr>
    <tr>
      <td class="lib_config">
        Adresses mail : 
      </td>
      <td>
        <textarea id="mail_envoi_inscriptions" name="mail_envoi_inscriptions" class="classinput_xsize" ><?php preg_match("/.*?MAIL_ENVOI_INSCRIPTIONS = \"(.*?)\";.*?/", $string_config_file, $matches); if(count($matches)>0) echo stripslashes($matches[1]); ?></textarea>
      </td>
      <td class="infos_config"><img id="search_contact" style="cursor:pointer;" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-rechercher.gif" /></td>
    </tr>
    <tr>
      <td class="lib_config">
        Qui sommes nous : 
      </td>
      <td>
        <textarea id="quisommesnous" name="quisommesnous" class="classinput_xsize" ><?php preg_match("/.*?QUISOMMESNOUS = \"(.*?)\";/sm", $string_config_file, $matches); if(count($matches)>0) echo stripslashes($matches[1]); ?></textarea>
      </td>
      <td class="infos_config">&nbsp;</td>
    </tr>
    <tr>
      <td class="lib_config">
        Mentions légales : 
      </td>
      <td>
        <textarea id="mentionslegales" name="mentionslegales" class="classinput_xsize" ><?php preg_match("/.*?MENTIONSLEGALES = \"(.*?)\";/sm", $string_config_file, $matches); if(count($matches)>0) echo stripslashes($matches[1]); ?></textarea>
      </td>
      <td class="infos_config">&nbsp;</td>
    </tr>
    <tr>
      <td class="lib_config">
        Conditions générales de ventes : 
      </td>
      <td>
        <textarea id="conditionsgeneralesdeventes" name="conditionsgeneralesdeventes" class="classinput_xsize" ><?php preg_match("/.*?CONDITIONSDEVENTES = \"(.*?)\";/sm", $string_config_file, $matches); if(count($matches)>0) echo stripslashes($matches[1]); ?></textarea>
      </td>
      <td class="infos_config">&nbsp;</td>
    </tr>
    <tr>
      <td class="lib_config">
        Pied de page : 
      </td>
      <td>
        <textarea id="bas_page" name="bas_page" class="classinput_xsize" ><?php preg_match("/.*?BAS_PAGE = \"(.*?)\";/sm", $string_config_file, $matches); if(count($matches)>0) echo stripslashes($matches[1]); ?></textarea>
      </td>
      <td class="infos_config">&nbsp;</td>
    </tr>
    <tr>
      <td class="lib_config">&nbsp;</td>
      <td>
        <input type="image" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-valider.gif" />
      </td>
      <td class="infos_config">&nbsp;</td>
    </tr>
  </table>
</form>
