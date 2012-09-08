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
  <a href="#" id="link_close_pop_up_infos" style="float:right">
  <img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/supprime.gif" border="0">
  </a>
<script type="text/javascript">
Event.observe("link_close_pop_up_infos", "click",  function(evt){Event.stop(evt); 
  $('popup_more_infos').style.display = "none"; }, false);
</script>
<div style="margin-top:20px;height:330px;overflow:auto;">
  <table style="width:99%;">
    <tbody>
      <tr>
        <td class="document_head_list" colspan="2" style="text-align:center;">Informations sur le contact</td>
      </tr>  
    <?php //foreach($ins[0]->infos as $key => $val) { ?>
      <tr>
        <td><?php //echo $key; ?></td>
        <td><?php //echo $val; ?></td>  
      </tr>
    <?php // }?>
      <tr>
        <td>Adresse de facturation : </td>  
        <td>Adresse de livraison : </td> 
      </tr>
      <tr>
        <td><?php echo getCivilite($ins[0][0]->infos['civilite'])." ".$ins[0][0]->infos['nom']; ?></td>  
        <td><?php echo getCivilite($ins[0][0]->infos['civilite'])." ".$ins[0][0]->infos['nom']; ?></td> 
      </tr>
      <tr>
        <td><?php echo $ins[0][0]->infos['adresse_adresse']; ?></td>  
        <td><?php echo $ins[0][0]->infos['livraison_adresse']; ?></td>
      </tr>
      <tr>
        <td><?php echo $ins[0][0]->infos['adresse_code']." ".$ins[0][0]->infos['adresse_ville']; ?></td>
        <td><?php echo $ins[0][0]->infos['livraison_code']." ".$ins[0][0]->infos['livraison_ville']; ?></td>  
      </tr>
      <tr>
        <td>Téléphone : </td>
        <td>Fax : </td>
      </tr>
      <tr>
        <td><?php echo $ins[0][0]->infos['coordonnee_tel1']; ?></td>  
        <td><?php echo $ins[0][0]->infos['coordonnee_fax']; ?></td>
      </tr>
      <tr>
        <td><?php echo $ins[0][0]->infos['coordonnee_tel2']; ?></td>  
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>Siret : </td>
        <td><?php echo $ins[0][0]->infos['siret']; ?></td>  
      </tr>
            <tr>
        <td>Email : </td>
        <td><?php  echo $ins[0][0]->infos['admin_emaila']; ?></td>  
      </tr>
      <tr>
        <td><?php echo $listelibprofils[$ins[0][0]->infos['profils_inscription']]; ?></td>
        <td><?php echo $listelibannucat[$ins[0][0]->infos['id_categorie']]; ?></td>  
      </tr>
      <tr>
        <td>TVA Intra : </td>
        <td><?php echo $ins[0][0]->infos['tva_intra']; ?></td>  
      </tr>
    </tbody>
  </table>
</div>

<script type="text/javascript">

  H_loading();
</script>

