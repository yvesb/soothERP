<?php

// *************************************************************************************************************
// ENTETE MODELE DE CONTENU
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
<table width="99%" border="0" cellspacing="0" cellpadding="0">
  <tr class="">
    <td colspan="3">
    <div id="block_entete">
    <div style="width:100%;">
    
    </div>
    </div>
    </td>
  </tr>
  <tr>
    <td style="width:48%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1px"/></td>
    <td style="width:4%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1px"/></td>
    <td style="width:48%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1px"/></td>
  </tr>
  <tr>
    <td>
    <div id="block_contact">

    
    </div>
    
    <table cellpadding="0" cellspacing="0" border="0" style="width:550px" id="document_reglement_entete" class="document_box">
      <tr style=" line-height:20px; height:20px;" class="document_head_list">
        <td  style=" padding-left:3px;" class="doc_bold" >
        <img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/doc_extend.gif" border="0" id="extend_click" style="float:right; cursor:pointer" title="Agrandir">
          Modification d'un modèle de contenu

          
        </td>
      </tr>
      <tr>
        <td style=" height:135px">
        <div style="position:relative">
        <div style="position:absolute;OVERFLOW-Y: auto; OVERFLOW-X: auto; width:100%; display:block; height:135px; left:-1px; top:-1px; z-index:120" id="extend_liste" class="document_box"  >
        <?php $maj_doc = true; include($DIR.$_SESSION['theme']->getDir_theme()."page_documents_mod_contenu.inc.php"); ?>

        </div>
        </div>
        </td>
      </tr>
    </table>
          <script type="text/javascript">
        Event.observe("extend_click", "click", function(evt){Event.stop(evt);
          if ($("extend_liste").style.height == "135px") {
          $("extend_click").src = "<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/doc_reduire.gif";
          $("extend_click").title = "Réduire";
          $("extend_liste").style.width = "550px";
          $("extend_liste").style.height = "450px";
          } else {
          $("extend_click").src = "<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/doc_extend.gif";
          $("extend_click").title = "Agrandir";
          $("extend_liste").style.width = "100%";
          $("extend_liste").style.height = "135px";
          }
        }, false);
         
        </script>
    </td>
    <td>
    <table cellpadding="0" cellspacing="0" border="0" style="width:100%">
      <tr style=" line-height:20px; height:20px;" class="">
        <td colspan="3">&nbsp;
        
        </td>
      </tr>
    </table>
    </td>
    <td>
    <div id="block_reglement">
    <div style="width:100%;">

    </div>
    </div>
    </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>

<script type="text/javascript">
$("wait_calcul_content").style.display= "none";
//quantite_locked = false;<?php //if ($document->getQuantite_locked ()) {echo "true";} else {echo "false";} ?>;
//alert('<<<'+quantite_locked+'>>>');
<?php //if (!isset($load) && $document->getACCEPT_REGMT() != 1) {?>
//

//document_calcul_tarif ();
//on masque le chargement
H_loading();
<?php //} ?>
</script>