<?php

// *************************************************************************************************************
// CONTROLE DU THEME
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


<div class="emarge">
<p class="titre">Historique des v&eacute;hicules</p>

<div class="contactview_corps">

<table width="100%">
	<tr class="smallheight">
		<td style="width:35%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
		<td style="width:20%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
		<td style="width:35%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
	</tr>
	<tr>
		<td style="font-weight:bolder; " colspan="3">Ajout d'un &eacute;v&eacute;nements pour le v&eacute;hicule <?php echo $vehicule->lib_vehicule;?> ( <?php echo $vehicule->marque;?> )</td>
	</tr>
	<tr>
		<td colspan="3">&nbsp; </td>
	</tr>
	<tr>
		<td colspan="3" align="center">
			<form action="smenu_gestion_vehicules_evenement_add.php" method="post" id="smenu_gestion_vehicules_evenement_add" name="smenu_gestion_vehicules_evenement_add" target="formFrame">
			<table>
			<tr>
				<td>
					<span class="labelled">Date (JJ/MM/AAAA):</span>
					<input type="hidden" name="id_vehicule" id="id_vehicule" value="<?php echo $vehicule->id_vehicule; ?>" />
				</td>
								<td>
					<span class="labelled">Ev&eacute;nement :</span>
				</td>
				<td>
					<span class="labelled">Co&ucirc;t :</span>
				</td>
				
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>
					<input name="date_evenement" id="date_evenement" type="text" value="<?php if(isset($_REQUEST['date_evenement'])){echo convert_date_Us_to_Fr($_REQUEST['date_evenement'],'/');} else {echo '';}?>"  class="classinput_lsize"/>
				</td>
				<td>
					<input name="lib_evenement" id="lib_evenement" type="text" value="<?php if(isset($_REQUEST['lib_evenement'])){echo $_REQUEST['lib_evenement'];} else {echo '';}?>"  class="classinput_lsize"/>
				</td>
				<td>
					<input name="cout" id="cout" type="text" value="<?php if(isset($_REQUEST['cout'])){echo $_REQUEST['cout'];} else {echo '';}?>"  class="classinput_lsize"/>
				</td>
				<td>
					<input name="ajouter" id="ajouter" type="image" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-ajouter.gif" />
				</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
			</tr>
			</table>
			</form>
		</td>
		
	</tr>
	<tr class="smallheight">
		<td style="width:35%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
		<td style="width:20%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
		<td style="width:35%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
	</tr>
	
	
	
	<tr>
		<td colspan="3"> </td>
	</tr>

</table>

</div>
</div>

<SCRIPT type="text/javascript">


</SCRIPT>
