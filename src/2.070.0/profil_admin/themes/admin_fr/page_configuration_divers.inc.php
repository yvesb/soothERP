<?php

// *************************************************************************************************************
// CONFIG DES DONNEES du logiciel
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
tableau_smenu[0] = Array("smenu_secusys", "smenu_secusys.php" ,"true" ,"sub_content", "Sécurité du système");
tableau_smenu[1] = Array('Configuration','configuration_divers.php' ,"true" ,"sub_content", "Définir la durée des sessions");
update_menu_arbo();
</script>
<div class="emarge">
<p class="titre">Définir la durée des sessions</p>

<div class="contactview_corps">
<form action="configuration_divers_maj.php" enctype="multipart/form-data" method="POST"  id="configuration_divers_maj" name="configuration_divers_maj" target="formFrame" >

<table width="100%">
	<tr class="smallheight">
		<td style="width:35%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
		<td style="width:20%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
		<td style="width:35%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
	</tr>
	<tr>
		<td class="titre_config" colspan="3">Param&egrave;tres de s&eacute;curit&eacute; :		</td>
	</tr>
	<tr>
		<td colspan="3"> </td>
	</tr>
	<tr>
		<td class="lib_config">Dur&eacute;e de session des informations syst&egrave;me </td>
		<td>
		<input id="session_lt" name="session_lt" value="<?php echo  $SESSION_LT/3600; ?>" type="text" class="classinput_hsize" maxlength="70" />	 en heures	</td>
		<td class="infos_config">Dur&eacute;e durant laquelle les donn&eacute;es de l'application sont conserv&eacute;es en m&eacute;moire par le serveur </td>
	</tr>
	<tr>
		<td colspan="3"> </td>
	</tr>
	<tr>
		<td class="lib_config">Dur&eacute;e de session des utilisateurs </td>
		<td><input id="user_session_lt" name="user_session_lt" value="<?php echo  ($USER_SESSION_LT/60); ?>" type="text" class="classinput_hsize" maxlength="70" /> en minutes</td>
		<td class="infos_config">Dur&eacute;e durant laquelle un utilisateur reste connect&eacute; &agrave; l'application sans l'utiliser </td>
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
new Event.observe("session_lt", "blur", function(evt){nummask(evt, "<?php echo  $SESSION_LT/3600; ?>", "X"); }, false);
new Event.observe("user_session_lt", "blur", function(evt){nummask(evt, "<?php echo  $USER_SESSION_LT/60; ?>", "X"); }, false);

//on masque le chargement
H_loading();
</SCRIPT>