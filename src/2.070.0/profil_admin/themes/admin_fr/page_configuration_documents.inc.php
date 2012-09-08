<?php

// *************************************************************************************************************
// CONFIG DES DONNEES des documents
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
</script>
<div class="emarge">
<p class="titre">Configuration des documents </p>

<div class="contactview_corps">
<form action="configuration_documents_maj.php" enctype="multipart/form-data" method="POST"  id="configuration_documents_maj" name="configuration_documents_maj" target="formFrame" >

<table width="100%">
	<tr class="smallheight">
		<td style="width:35%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
		<td style="width:20%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
		<td style="width:35%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
	</tr>
	<tr>
		<td class="titre_config" colspan="3">Affichage des r&eacute;sultats dans les moteurs de recherche de documents:		</td>
	</tr>
	<tr>
		<td colspan="3"> </td>
	</tr>
	<tr>
		<td class="lib_config">Nombre de r&eacute;sultats affich&eacute;s par pages </td>
		<td>
		<input id="document_recherche_showed_fiches" name="document_recherche_showed_fiches" value="<?php echo  $DOCUMENT_RECHERCHE_SHOWED_FICHES; ?>" type="text" class="classinput_hsize" maxlength="70" /></td>
		<td class="infos_config">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="3"> </td>
	</tr>
	<tr>
		<td class="lib_config">Utilisation de remises dans les documents </td>
		<td>
		
		<input id="aff_remises" name="aff_remises" value="1" type="checkbox" <?php if ($AFF_REMISES) { ?>checked="checked"<?php } ?> />
		</td>
		<td class="infos_config">Permet d'effectuer une remise sur un ou plusieurs articles dans un document. </td>
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
new Event.observe("document_recherche_showed_fiches", "blur", function(evt){nummask(evt, "<?php echo  $DOCUMENT_RECHERCHE_SHOWED_FICHES; ?>", "X"); }, false);

//on masque le chargement
H_loading();
</SCRIPT>