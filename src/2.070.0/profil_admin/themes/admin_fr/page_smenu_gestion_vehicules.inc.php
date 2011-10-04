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
<script type="text/javascript" language="javascript">
tableau_smenu[0] = Array("smenu_gestion_modules", "smenu_gestion_modules.php" ,"true" ,"sub_content", "Gestion des Modules");
tableau_smenu[1] = Array("smenu_gestion_vehicules", "smenu_gestion_vehicules.php" ,"true" ,"sub_content", "Gestion des véhicules");
update_menu_arbo();
</script>

<div class="emarge">
<p class="titre">Gestion des v&eacute;hicules</p>

<div class="contactview_corps">

<table width="100%">
	<tr class="smallheight">
		<td style="width:35%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
		<td style="width:20%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
		<td style="width:35%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
	</tr>
	<tr>
		<td class="titre_config" colspan="3">Ajouter un v&eacute;hicule :</td>
	</tr>
	<tr>
		<td colspan="3"> </td>
	</tr>
	<tr>
		<td colspan="3" align="center">
			<form action="smenu_gestion_vehicules_add.php" method="post" id="smenu_gestion_vehicules_add" name="smenu_gestion_vehicules_add" target="formFrame">
			<table>
			<tr>
				<td>
					<span class="labelled">V&eacute;hicule :</span>
				</td>
								<td>
					<span class="labelled">Marque / Mod&egrave;le :</span>
				</td>
				<td>
					<span class="labelled">Attribution :</span>
				</td>
				
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>
					<input name="lib_vehicule" id="lib_vehicule" type="text" value="<?php if(isset($_REQUEST['lib_vehicule'])){echo $_REQUEST['lib_vehicule'];} else {echo '';}?>"  class="classinput_lsize"/>
				</td>
				<td>
					<input name="marque" id="marque" type="text" value="<?php if(isset($_REQUEST['marque'])){echo $_REQUEST['marque'];} else {echo '';}?>"  class="classinput_lsize"/>
				</td>
				<td>
					<input name="attribution" id="attribution" type="text" value="<?php if(isset($_REQUEST['attribution'])){echo $_REQUEST['attribution'];} else {echo '';}?>"  class="classinput_lsize"/>
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
		<td class="titre_config" colspan="3">Liste des v&eacute;hicules :</td>
	</tr>
	<tr>
		<td colspan="3"></td>
	</tr>
	<tr>
	
	<td colspan="3" align="center">
	<table border="0" cellpadding="0" cellspacing="0">
					<tr>
				<td class="infos_config" width="165px">
					<span>V&eacute;hicule </span>
				</td >
				<td class="infos_config" width="165px">
					<span>Marque / Mod&egrave;le </span>
				</td>
				<td class="infos_config" width="165px">
					<span>Attribution </span>
				</td>
				<td class="infos_config" width="180px">
					<span>Dernier &eacute;v&eacute;nement </span>
				</td>
				<td width="140px">
							&nbsp;
						</td>
				
				<td width="80px">&nbsp;</td>
				<td width="40px">&nbsp;</td>
				
				</tr>
			</table>
	</td>
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
							<input style="width:70%" id="lib_vehicule_<?php echo $vehicule->id_vehicule; ?>" name="lib_vehicule_<?php echo $vehicule->id_vehicule; ?>" value="<?php echo $vehicule->lib_vehicule; ?>" type="text" class="classinput_hsize" maxlength="70"  />
							<input type="hidden" name="id_vehicule" id="id_vehicule" value="<?php echo $vehicule->id_vehicule; ?>" />
						</td>
					
						<td width="165px">
							<input style="width:70%" id="marque_<?php echo $vehicule->id_vehicule; ?>" name="marque_<?php echo $vehicule->id_vehicule; ?>" value="<?php echo $vehicule->marque; ?>" type="text" class="classinput_hsize" maxlength="70"  />
						</td>
						<td width="165px">
							<input style="width:70%" id="attribution_<?php echo $vehicule->id_vehicule; ?>" name="attribution_<?php echo $vehicule->id_vehicule; ?>" value="<?php echo $vehicule->attribution; ?>" type="text" class="classinput_hsize" maxlength="70"  />
						</td>
						<td width="180px">
							<span style="width:90%" id="date_event" name="date_event" ><?php if($liste_evenements){echo convert_date_Us_to_Fr($date_dernier_evenement,'/')." - ".$lib_dernier_evenement;} else echo "Aucun évènement enregistré"?></span>
						</td>
						<td width="140px">
						<span style="text-decoration:underline; cursor:pointer" id="smenu_gestion_vehicules_histo_<?php echo $vehicule->id_vehicule; ?>" name="smenu_gestion_vehicules_histo_<?php echo $vehicule->id_vehicule; ?>">Consulter l'historique</span>
						</td>
						<td width="80px">
								<input name="modifier" id="modifier" type="image" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-modifier.gif" />

							&nbsp;
						</td>
						<td width="40px" align="right">
								<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/supprime.gif" id="supp_img_<?php echo $vehicule->id_vehicule; ?>" style="cursor:pointer"/>
							&nbsp;
						</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
					</tr>
				</table>

				<script type="text/javascript">
				Event.observe('supp_img_<?php echo $vehicule->id_vehicule; ?>', "click", function(evt){
					Event.stop(evt);
					$("titre_alert").innerHTML = "Confirmation";
					$("texte_alert").innerHTML = "Confirmer la suppression de ce véhicule";
					$("bouton_alert").innerHTML = '<input type="submit" name="bouton1" id="bouton1" value="Supprimer" /><input type="submit" id="bouton0" name="bouton0" value="Annuler" />';
				
					$("alert_pop_up_tab").style.display = "block";
					$("framealert").style.display = "block";
					$("alert_pop_up").style.display = "block";
					
					$("bouton0").onclick= function () {
					$("framealert").style.display = "none";
					$("alert_pop_up").style.display = "none";
					$("alert_pop_up_tab").style.display = "none";
					}
					$("bouton1").onclick= function () {
					$("framealert").style.display = "none";
					$("alert_pop_up").style.display = "none";
					$("alert_pop_up_tab").style.display = "none";
					page.verify("smenu_gestion_vehicule_del","smenu_gestion_vehicules_del.php?id_vehicule=<?php echo $vehicule->id_vehicule; ?>", "true", "formFrame");
					}
				});
				
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
