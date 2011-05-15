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
<table  style="width:450px" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td>Lors de la validation d'un devis client :</td>
    <td style="text-align:center">&nbsp;automatique</td>
    <td style="text-align:center">&nbsp;optionnel</td>
  </tr>
  <tr>
    <td>Générer une commande client </td>
    <td style="text-align:center">
	<input type="checkbox" name="DEV_genere_CDC" id="DEV_genere_CDC" value="CDC" <?php if ($DEVIS_CLIENT_AUTO_GENERE == "CDC") { ?> checked="checked"<?php }?> />
	</td>
    <td style="text-align:center">
	<input type="checkbox" name="DEV_option_CDC" id="DEV_option_CDC" value="CDC" <?php if (in_array("CDC", $DEVIS_CLIENT_OPTION_GENERE)) { ?> checked="checked"<?php }?>/>
	</td>
  </tr>
  <tr>
    <td>Générer une livraison</td>
    <td style="text-align:center">
	<input type="checkbox" name="DEV_genere_BLC" id="DEV_genere_BLC" value="BLC" <?php if ($DEVIS_CLIENT_AUTO_GENERE == "BLC") { ?> checked="checked"<?php }?>/>
	</td>
    <td style="text-align:center">
	<input type="checkbox" name="DEV_option_BLC" id="DEV_option_BLC" value="BLC" <?php if (in_array("BLC", $DEVIS_CLIENT_OPTION_GENERE)) { ?> checked="checked"<?php }?>/>
	</td>
  </tr>
  <tr>
    <td>Générer une facture</td>
    <td style="text-align:center">
	<input type="checkbox" name="DEV_genere_FAC" id="DEV_genere_FAC" value="FAC" <?php if ($DEVIS_CLIENT_AUTO_GENERE == "FAC") { ?> checked="checked"<?php }?>/>
	</td>
    <td style="text-align:center">
	<input type="checkbox" name="DEV_option_FAC" id="DEV_option_FAC" value="FAC" <?php if (in_array("FAC", $DEVIS_CLIENT_OPTION_GENERE)) { ?> checked="checked"<?php }?>/>
	</td>
  </tr>
</table>
<script type="text/javascript">
 Event.observe('DEV_option_CDC', "click" , function(evt){
	 if ($("DEV_option_CDC").checked) {
		$("DEV_genere_CDC").checked="";
	 }
 } , false);

 Event.observe('DEV_genere_CDC', "click" , function(evt){
	 if ($("DEV_genere_CDC").checked) {
		$("DEV_genere_BLC").checked="";
		$("DEV_genere_FAC").checked="";
		$("DEV_option_CDC").checked="";
	 }
 } , false);
	 
 Event.observe('DEV_option_BLC', "click" , function(evt){
	 if ($("DEV_option_BLC").checked) {
		$("DEV_genere_BLC").checked="";
	 }
 } , false);

 Event.observe('DEV_genere_BLC', "click" , function(evt){
	 if ($("DEV_genere_BLC").checked) {
		$("DEV_genere_CDC").checked="";
		$("DEV_genere_FAC").checked="";
		$("DEV_option_BLC").checked="";
	 }
 } , false);
 
 Event.observe('DEV_option_FAC', "click" , function(evt){
	 if ($("DEV_option_FAC").checked) {
		$("DEV_genere_FAC").checked="";
	 }
 } , false);

 Event.observe('DEV_genere_FAC', "click" , function(evt){
	 if ($("DEV_genere_FAC").checked) {
		$("DEV_genere_CDC").checked="";
		$("DEV_genere_BLC").checked="";
		$("DEV_option_FAC").checked="";
	 }
 } , false);

</script>
         