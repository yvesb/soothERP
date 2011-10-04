<?php

// *************************************************************************************************************
// CONFIG DES DONNEES d'affichage
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
tableau_smenu[0] = Array("smenu_site_internet", "smenu_site_internet.php" ,"true" ,"sub_content", "Interfaces");
tableau_smenu[1] = Array('site_interfaces_config','site_interfaces_config.php','true','sub_content', "Configuration des interfaces.");
update_menu_arbo();
</script>
<div class="emarge">
<p class="titre">Configuration des interfaces</p>

<div class="contactview_corps">
<form action="configuration_affichage_maj.php" enctype="multipart/form-data" method="POST"  id="configuration_affichage_maj" name="configuration_affichage_maj" target="formFrame" >

<table width="100%">
	<tr class="smallheight">
		<td style="width:35%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
		<td style="width:20%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
		<td style="width:35%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
	</tr>
	<tr>
		<td class="titre_config" colspan="3">Selectionner l'interface à configurer:		</td>
	</tr>
	<tr>
		<td colspan="3"> </td>
	</tr>
	<tr>
		<td class="lib_config">Interface: </td>
		<td>
		<select id="select_interface" name="select_interface" class="classinput_xsize" >
		<?php foreach ($liste_interfaces as $interface) {?>
          <option value="<?php echo $interface->dossier; ?>"><?php echo $interface->lib_interface; ?></option>
        <?php } ?>
		</select>
		</td>
		<td class="infos_config">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="3"> </td>
	</tr>
	
</table>
</form>
<div id="view_config_interface">

</div>
</div>
</div>
<SCRIPT type="text/javascript">
new Event.observe("select_interface", "change", function(evt){
  loadFormInterface($('select_interface').value);
}, false);

//on masque le chargement
H_loading();
</SCRIPT>