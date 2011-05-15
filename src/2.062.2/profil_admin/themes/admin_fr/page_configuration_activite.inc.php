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
tableau_smenu[0] = Array("smenu_entreprise", "smenu_entreprise.php" ,"true" ,"sub_content", "Entreprise");
tableau_smenu[1] = Array('configuration_activite','configuration_activite.php',"true" ,"sub_content", "Renseignements sur l'activité");
update_menu_arbo();
</script>
<div class="emarge">
<p class="titre">Renseignements sur l'activité de l'entreprise</p>

<div class="contactview_corps">
<form action="configuration_activite_maj.php" enctype="multipart/form-data" method="POST"  id="configuration_activite_maj" name="configuration_activite_maj" target="formFrame" >

<table width="100%">
	<tr class="smallheight">
		<td style="width:35%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
		<td style="width:20%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
		<td style="width:35%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
	</tr>
	<tr>
		<td class="titre_config" colspan="3">Votre activit&eacute;  :		</td>
	</tr>
	<tr>
		<td colspan="3"> </td>
	</tr>
	<tr>
		<td class="lib_config">Date de d&eacute;but d'activit&eacute; ou de cr&eacute;ation de votre entreprise </td>
		<td>
		<input id="entreprise_date_creation" name="entreprise_date_creation" value="<?php echo date_Us_to_Fr($ENTREPRISE_DATE_CREATION); ?>" type="text" class="classinput_hsize" maxlength="70" /></td>
		<td class="infos_config">Cette information nous permet de vous proposer la gestion de votre comptabilt&eacute; par exercice comptable. </td>
	</tr>
	<tr>
		<td colspan="3"> </td>
	</tr>
	<tr>
		<td class="lib_config">Pays dans lequel l'entreprise est implantée: </td>
		<td>
				<select id="defaut_id_pays"  name="defaut_id_pays" class="classinput_xsize">
					<?php
					$separe_listepays = 0;
					foreach ($listepays as $payslist){
						if ((!$separe_listepays) && (!$payslist->affichage)) { 
							$separe_listepays = 1; ?>
							<OPTGROUP disabled="disabled" label="__________________________________" ></OPTGROUP>
							<?php 		 
						}
						?>
						<option value="<?php echo $payslist->id_pays?>" <?php if ($DEFAUT_ID_PAYS == $payslist->id_pays) {echo 'selected="selected"';}?>>
						<?php echo htmlentities($payslist->pays)?></option>
						<?php 
					}
					?>
				</select>
		</td>
		<td class="infos_config">Cette information détermine notamment les taux de TVA utilisés </td>
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
new Event.observe("entreprise_date_creation", "blur", function(evt){datemask(evt); }, false);

//on masque le chargement
H_loading();
</SCRIPT>