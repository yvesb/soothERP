<?php

// *************************************************************************************************************
// ONGLET 
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
<?php if (!isset($maj_doc)) {?>
  <a href="#" id="link_close_pop_up_histo_doc" style="float:right">
  <img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/supprime.gif" border="0">
  </a>
<script type="text/javascript">
Event.observe("link_close_pop_up_histo_doc", "click",  function(evt){Event.stop(evt); 
  $('mod_contenu_content').style.display = "none"; }, false);
</script>
<?php } ?>
<div style="<?php if (!isset($maj_doc)) { echo "margin-top:20px;height:330px;"; }?>overflow:auto;">
  <form action="<?php if (!isset($maj_doc)) { ?>documents_mod_contenu_add.php<?php } else { ?>documents_mod_contenu_maj.php<?php } ?>" enctype="multipart/form-data" method="POST" id="documents_mod_contenu_add" name="documents_mod_contenu_add" target="formFrame" >
  <table style="width:99%;">
    <tbody>
    <?php if (!isset($maj_doc)) {?>
      <tr>
        <td class="document_head_list" colspan="2" style="text-align:center;">Création d'un modèle de contenu</td>
      </tr>  
    <?php } ?>
      <tr>
        <td>Libelé du modèle : </td>
        <td><input id="lib_mod" name="lib_mod" type="text" class="classinput_xsize" value="<?php if (isset($maj_doc)) echo $document->getLibModele(); ?>" /></td>
      </tr>
      <tr>
        <td>Description du modèle : </td>
        <td><input id="desc_mod" name="desc_mod" type="text" class="classinput_xsize" value="<?php if (isset($maj_doc)) echo $document->getDescModele(); ?>" /></td>
      </tr>
      <tr>
        <td colspan="2">Choix des types de documents pour ce modèle : </td>
      </tr>
      <?php if (!isset($docs_types)) { $docs_types = $_SESSION['types_docs'];  } ?>
      <?php if (isset($maj_doc)) $types_checks = $document->getTypesDocs(); ?>
      <?php foreach($docs_types as $docs_type) {
        if ($docs_type->id_type_doc == 14) continue;
      ?>
      <tr>
        <td><?php echo $docs_type->lib_type_printed; ?> : </td>
        <td><input id="check_<?php echo $docs_type->id_type_doc; ?>" type="checkbox" value="<?php echo $docs_type->id_type_doc; ?>" class="classinput_xsize" <?php if (isset($types_checks) && in_array($docs_type->id_type_doc, $types_checks)) echo "CHECKED"; ?> /></td>
      </tr>
      <?php } ?>
      <tr>
        <td colspan="2" style="text-align:center;"><input name="valider" id="valider" type="image" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme();?>images/bt-valider.gif" /></td>
      </tr>
    </tbody>
  </table>
  <input id="types_docs" name="types_docs" type="hidden" value="<?php echo (isset($types_checks)) ? implode(";", $types_checks) : ";" ?>" />
  <input id="ref_doc" name="ref_doc" type="hidden" value="<?php echo $ref_doc; ?>" />
 </form>
</div>

<script type="text/javascript">
<?php foreach($docs_types as $docs_type) {
  if ($docs_type->id_type_doc == 14) continue; ?>
  Event.observe('check_<?php echo $docs_type->id_type_doc; ?>', "click" , function(evt){
    if (document.getElementById('check_<?php echo $docs_type->id_type_doc; ?>').checked == true)
      document.getElementById('types_docs').value += document.getElementById('check_<?php echo $docs_type->id_type_doc; ?>').value + ";";
    else
      document.getElementById('types_docs').value = document.getElementById('types_docs').value.replace(";<?php echo $docs_type->id_type_doc; ?>;", ";");
  } , false);
<?php }?>

  H_loading();
</script>

