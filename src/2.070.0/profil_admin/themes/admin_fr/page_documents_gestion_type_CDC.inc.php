<?php

// *************************************************************************************************************
// CONTROLE DU THEME
// *************************************************************************************************************

// Variables nécessaires à l'affichage
$page_variables = array ("_ALERTES");
check_page_variables ($page_variables);


//******************************************************************
// Variables communes d'affichage
//******************************************************************




// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

?>
<table  style="width:350px" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td>Depuis une commande client, permettre de :</td>
    <td style="text-align:center">&nbsp;</td>
    <td style="text-align:center">&nbsp;</td>
  </tr>
  <tr>
    <td>Générer une livraison</td>
    <td style="text-align:center">
	<input type="radio" name="CDC_genere" value="BLC" <?php if ($COMMANDE_CLIENT_AUTO_GENERE == "BLC") { ?> checked="checked"<?php }?>/>
	</td>
    <td style="text-align:center">
	</td>
  </tr>
  <tr>
    <td>Générer une facture</td>
    <td style="text-align:center">
	<input type="radio" name="CDC_genere" value="FAC" <?php if ($COMMANDE_CLIENT_AUTO_GENERE == "FAC") { ?> checked="checked"<?php }?>/>
	</td>
    <td style="text-align:center">
	</td>
  </tr>
</table>
<script type="text/javascript">

</script>
         