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
tableau_smenu[0] = Array("smenu_affichage", "smenu_affichage.php" ,"true" ,"sub_content", "Affichage");
tableau_smenu[1] = Array('configuration_affichage','configuration_affichage.php','true','sub_content', "Configuration de l'affichage des résultats de recherche.");
update_menu_arbo();
</script>
<div class="emarge">
<p class="titre">Configuration de l'affichage des résultats de recherche.</p>

<div class="contactview_corps">
<form action="configuration_affichage_maj.php" enctype="multipart/form-data" method="POST"  id="configuration_affichage_maj" name="configuration_affichage_maj" target="formFrame" >

<table width="100%">
	<tr class="smallheight">
		<td style="width:35%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
		<td style="width:20%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
		<td style="width:35%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
	</tr>
	<tr>
		<td class="titre_config" colspan="3">Affichage des r&eacute;sultats dans les moteurs de recherche de l'annuaire:		</td>
	</tr>
	<tr>
		<td colspan="3"> </td>
	</tr>
	<tr>
		<td class="lib_config">Nombre de r&eacute;sultats affich&eacute;s par page </td>
		<td>
		<input id="annuaire_recherche_showed_fiches" name="annuaire_recherche_showed_fiches" value="<?php echo  $ANNUAIRE_RECHERCHE_SHOWED_FICHES; ?>" type="text" class="classinput_hsize" maxlength="70" /></td>
		<td class="infos_config">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="3"> </td>
	</tr>
	<tr>
		<td class="titre_config" colspan="3">Affichage des r&eacute;sultats des recherches d'articles:		</td>
	</tr>
	<tr>
		<td colspan="3"> </td>
	</tr>
	<tr>
		<td class="lib_config">Nombre de r&eacute;sultats affich&eacute;s par page </td>
		<td>
		<input id="catalogue_recherche_showed_fiches" name="catalogue_recherche_showed_fiches" value="<?php echo  $CATALOGUE_RECHERCHE_SHOWED_FICHES; ?>" type="text" class="classinput_hsize" maxlength="70" /></td>
		<td class="infos_config">dans les moteurs de recherche du catalogue</td>
	</tr>
	<tr>
		<td colspan="3"> </td>
	</tr>
	<tr>
		<td class="lib_config">Nombre de r&eacute;sultats affich&eacute;s par page </td>
		<td>
		<input id="stock_move_recherche_showed" name="stock_move_recherche_showed" value="<?php echo  $STOCK_MOVE_RECHERCHE_SHOWED; ?>" type="text" class="classinput_hsize" maxlength="70" /></td>
		<td class="infos_config">dans les mouvements de stocks </td>
	</tr>
	<tr>
		<td colspan="3"> </td>
	</tr>
	<tr>
		<td class="titre_config" colspan="3">Affichage des r&eacute;sultats dans les moteurs de recherche de documents:		</td>
	</tr>
	<tr>
		<td colspan="3"> </td>
	</tr>
	<tr>
		<td class="lib_config">Nombre de r&eacute;sultats affich&eacute;s par page </td>
		<td>
		<input id="document_recherche_showed_fiches" name="document_recherche_showed_fiches" value="<?php echo  $DOCUMENT_RECHERCHE_SHOWED_FICHES; ?>" type="text" class="classinput_hsize" maxlength="70" /></td>
		<td class="infos_config">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="3"> </td>
	</tr>
	<tr>
		<td class="lib_config">Afficher le montant total par page de résultat </td>
		<td>
		<input id="document_recherche_montant_total" name="document_recherche_montant_total" value="<?php echo  $DOCUMENT_RECHERCHE_MONTANT_TOTAL; ?>" type="checkbox" <?php if ($DOCUMENT_RECHERCHE_MONTANT_TOTAL) {?>checked="checked"<?php } ?>  /></td>
		<td class="infos_config">&nbsp;</td>
	</tr>
</table>
<p style="text-align:center">
	<input name="valider" id="valider" type="image" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-valider.gif" />
</p>
</form>

</div>
</div>
<SCRIPT type="text/javascript">
new Event.observe("annuaire_recherche_showed_fiches", "blur", function(evt){nummask(evt, "<?php echo  $ANNUAIRE_RECHERCHE_SHOWED_FICHES; ?>", "X"); }, false);

//on masque le chargement
H_loading();
</SCRIPT>