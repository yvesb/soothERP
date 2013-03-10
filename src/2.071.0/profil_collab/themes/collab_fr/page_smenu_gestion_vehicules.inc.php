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
<p class="titre">Gestion des v&eacute;hicules</p>

<div class="contactview_corps">

<table width="100%">
	<tr class="smallheight">
		<td style="width:35%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
		<td style="width:20%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
		<td style="width:35%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
	</tr>
	

	
	<tr class="smallheight">
		<td style="width:35%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
		<td style="width:20%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
		<td style="width:35%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
	</tr>
	<tr>
		<td style="font-weight:bolder; " colspan="3">Liste des v&eacute;hicules :</td>
	</tr>
	<tr>
		<td colspan="3"></td>
	</tr>
		<tr>
		<td colspan="3"></td>
	</tr>
			<tr>
		<td colspan="3"></td>
	</tr>
	<tr>
	
	<td colspan="3" align="center">
	<table border="0" cellpadding="0" cellspacing="0">
					<tr>
				<td  width="165px">
					<span class="labelled">V&eacute;hicule </span>
				</td >
				<td  width="165px">
					<span class="labelled">Marque / Mod&egrave;le </span>
				</td>
				<td  width="165px">
					<span class="labelled">Attribution </span>
				</td>
				<td  width="220px">
					<span class="labelled">Dernier &eacute;v&eacute;nement </span>
				</td>
				<td width="140px">
							&nbsp;
						</td>
				
				
				</tr>
			</table>
	</td>
			</tr>
	<tr>
		<td colspan="3"></td>
	</tr>
	<tr>
		<td colspan="3"> </td>
	</tr>
	<?php
	foreach($liste_vehicules as $vehicule){
		$date_dernier_evenement = "";
		$lib_dernier_evenement = "";
		$where = "WHERE id_vehicule = '".$vehicule->id_vehicule."' ";
		$liste_evenements = charger_liste_evenements($where);
		if($liste_evenements){
		$date_dernier_evenement = $liste_evenements[0]->date_evenement;
		$lib_dernier_evenement = $liste_evenements[0]->lib_evenement;
		}
		?>
		<tr>
			<td colspan="3" align="center">
				<form action="smenu_gestion_vehicules_maj.php" enctype="multipart/form-data" method="POST" id="smenu_gestion_vehicules_maj_<?php echo $vehicule->id_vehicule; ?>" name="smenu_gestion_vehicules_maj_<?php echo $vehicule->id_vehicule; ?>" target="formFrame">
				<table border="0" cellpadding="0" cellspacing="0">
					<tr>
						
						<td width="165px">
							<span id="lib_vehicule_<?php echo $vehicule->id_vehicule; ?>" name="lib_vehicule_<?php echo $vehicule->id_vehicule; ?>"><?php echo $vehicule->lib_vehicule; ?></span>
							<input type="hidden" name="id_vehicule" id="id_vehicule" value="<?php echo $vehicule->id_vehicule; ?>" />
						</td>
					
						<td width="165px">
							<span id="marque_<?php echo $vehicule->id_vehicule; ?>" name="marque_<?php echo $vehicule->id_vehicule; ?>"><?php echo $vehicule->marque; ?></span>
						</td>
						<td width="165px">
							<span id="attribution_<?php echo $vehicule->id_vehicule; ?>" name="attribution_<?php echo $vehicule->id_vehicule; ?>"><?php echo $vehicule->attribution; ?></span>
						</td>
						<td width="220px">
							<span style="width:90%" id="date_event" name="date_event" ><?php if($liste_evenements){echo convert_date_Us_to_Fr($date_dernier_evenement,'/')." - ".$lib_dernier_evenement;} else echo "Aucun évènement enregistré"?></span>
						</td>
						<td width="140px">
						<span style="text-decoration:underline; cursor:pointer" id="smenu_gestion_vehicules_histo_<?php echo $vehicule->id_vehicule; ?>" name="smenu_gestion_vehicules_histo_<?php echo $vehicule->id_vehicule; ?>">Consulter l'historique</span>
						</td>

					</tr>
					<tr>
						<td>&nbsp;</td>
					</tr>
				</table>

				<script type="text/javascript">

				
				Event.observe("smenu_gestion_vehicules_histo_<?php echo $vehicule->id_vehicule; ?>", "click",  function(evt)
					{Event.stop(evt);
				    page.verify('smenu_gestion_vehicules_histo', 'smenu_gestion_vehicules_histo.php?id_vehicule=<?php echo $vehicule->id_vehicule; ?>' ,"true" ,"sub_content");}, false);
				//on masque le chargement
				H_loading();
				</script>

				</form>
			</td>
		</tr>
	<?php
	} ?>
	<tr>
		<td colspan="3"> </td>
	</tr>
</table>

</div>
</div>
