<?php

// *************************************************************************************************************
// CONFIG DES OPTIONS
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
<script type="text/javascript">
tableau_smenu[0] = Array("smenu_entreprise", "smenu_entreprise.php" ,"true" ,"sub_content", "Entreprise");
tableau_smenu[1] = Array('configuration_entreprise_options','configuration_entreprise_options.php',"true" ,"sub_content", "Options");
update_menu_arbo();
</script>
<div class="emarge">
<p class="titre">Options</p>

<div class="contactview_corps">
<form action="configuration_entreprise_options_maj.php" enctype="multipart/form-data" method="POST"  id="configuration_entreprise_options_maj" name="configuration_entreprise_options_maj" target="formFrame" >

<table width="100%">
	<tr class="smallheight">
		<td style="width:35%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
		<td style="width:20%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
		<td style="width:35%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
	</tr>
	<tr>
		<td class="titre_config" colspan="3">Options:		</td>
	</tr>
	<tr>
		<td colspan="3"> </td>
	</tr>
	<tr>
		<td class="lib_config">Afficher le bouton plan pour un contact </td>
		<td>
		<input id="view_bt_map" name="view_bt_map" value="<?php echo ($VIEW_BT_MAP); ?>" type="checkbox" <?php if ($VIEW_BT_MAP){ ?> checked="checked"<?php } ?> /></td>
		<td class="infos_config">Lien d'affichage du plan pour l'adresse d'un contact </td>
	</tr>
	<tr>
		<td colspan="3"> </td>
	</tr>
	<tr>
		<td class="lib_config">Afficher le bouton itinéraire pour un contact </td>
		<td>
		<input id="view_bt_iti" name="view_bt_iti" value="<?php echo ($VIEW_BT_ITI); ?>" type="checkbox"  <?php if ($VIEW_BT_ITI){ ?> checked="checked"<?php } ?> /></td>
		<td class="infos_config">Lien d'affichage de l'itinéraire depuis le magasin en cours vers l'adresse d'un contact </td>
	</tr>
	<tr>
		<td colspan="3"> </td>
	</tr>
	<tr>
		<td colspan="3"> </td>
	</tr>
</table>
<p style="text-align:center">
	<input name="valider" id="valider" type="image" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-valider.gif" />
</p>
</form>

</div>
</div>
<SCRIPT type="text/javascript">

//on masque le chargement
H_loading();
</SCRIPT>