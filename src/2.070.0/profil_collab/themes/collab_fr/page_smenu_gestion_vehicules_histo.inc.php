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
		<td style="font-weight:bolder; " colspan="3">Consultation de l'historique du v&eacute;hicule <?php echo $vehicule->lib_vehicule;?> ( <?php echo $vehicule->marque;?> )</td>
	</tr>
	<tr>
		<td colspan="3">&nbsp; </td>
	</tr>
	
		
	<tr>
		<td colspan="2" style="padding-left:50px;">
			<form action="smenu_gestion_vehicules_histo_recherche.php" method="post" id="smenu_gestion_vehicules_histo_recherche" name="smenu_gestion_vehicules_histo_recherche" target="formFrame">
			<table>
			<tr>
			<td>
			<span id="">Libell&eacute;</span>
			</td>
			<td>
			<input type="text" name="libelle" id="libelle" value="<?php echo $lib_evenement;?>" class="classinput_xsize" />
			<input type="hidden" name="id_vehicule" id="id_vehicule" value="<?php echo $vehicule->id_vehicule; ?>" />
			</td>
			<td></td>
			</tr>
			<tr>
			<td style="text-align:right">du&nbsp;</td>
			<td>
			
			<input type="text" name="date_debut" id="date_debut" value="<?php if(!empty($date_debut)) echo convert_date_Us_to_Fr($date_debut,"/");?>" class="classinput_nsize" size="12" />
			au&nbsp;&nbsp;&nbsp; 
			<input type="text" name="date_fin" id="date_fin" value="<?php if(!empty($date_fin)) echo convert_date_Us_to_Fr($date_fin,"/");?>" class="classinput_nsize" size="12" />
			</td>
			<td></td>
			</tr>
			<tr>
			<td style="text-align:right">Co&ucirc;t&nbsp;</td>
			<td>
			
			<input type="text" name="cout" id="cout" value="<?php echo $cout;?>" class="classinput_nsize" size="12" />
			&agrave; +/-
			<input type="text" name="ecart" id="ecart" value="<?php echo $ecart;?>" class="classinput_nsize" size="12" />
			</td>
			<td><?php echo $MONNAIE[1];?></td>
			</tr>
			<tr>
			<td></td>
			<td style="text-align:right">
			<input name="submit" type="image"  src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-rechercher.gif"  style="float:left" />
			</td>
			</tr>
			</table>
			</form>
		</td>
		<td>
		<table>
		<tr></tr>
		<tr>
		<td>&nbsp;</td>
		</tr>
		<tr><td><span class="titre_smenu_page" id="osmenu_gestion_vehicules_ajout_evenement" > <img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/extend.GIF" align="absmiddle" />&nbsp;Ajouter un &eacute;v&eacute;nement</span><br /><br /></td></tr>
		</table>
		</td>
	</tr>
	<tr class="smallheight">
		<td style="width:35%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
		<td style="width:20%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
		<td style="width:35%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
	</tr>
	<tr>
		<td colspan="3">&nbsp; </td>
	</tr>
	<tr>
		<td style="font-weight:bolder; " colspan="3">Liste des &eacute;v&eacute;nements :</td>
	</tr>
	<tr>
		<td colspan="3"></td>
	</tr>
	<tr>
	
	<td colspan="3" align="center">
	<table border="0" cellpadding="0" cellspacing="0">
					<tr>
				<td width="165px">
					<span style="color:#312673">Date </span>
				</td >
				<td  width="165px">
					<span style="color:#312673">Ev&eacute;nement </span>
				</td>
				<td  width="80px">
					<span style="color:#312673">Co&ucirc;t </span>
				</td>
				<td width="160px"></td>
				<td width="40px"></td>
				
				</tr>
			</table>
	</td>
			</tr>
	<tr>
		<td colspan="3"> </td>
	</tr>

		<tr>
			<td colspan="3" align="center">
							</td>
		</tr>
		<?php
		$total = 0;
	foreach($liste_evenements as $evenement){
		$total += $evenement->cout;
		?>
	<tr>
		<td colspan="3" align="center">
		<form action="smenu_gestion_vehicules_evenements_maj.php" enctype="multipart/form-data" method="POST" id="smenu_gestion_vehicules_evenements_maj_<?php echo $evenement->id_evenement; ?>" name="smenu_gestion_vehicules_evenement_maj_<?php echo $evenement->id_evenement; ?>" target="formFrame"> 
			<table border="0" cellpadding="0" cellspacing="0">
					<tr>
				<td  width="165px">
				<input type="text" name="date_evenement_<?php echo $evenement->id_evenement;?>" id="date_evenement_<?php echo $evenement->id_evenement;?>" value="<?php echo (convert_date_Us_to_Fr($evenement->date_evenement, "/" )); ?>" class="classinput_nsize" size="12" style="text-align:center"/>
				<input type="hidden" name="id_evenement" id="id_evenement" value="<?php echo $evenement->id_evenement; ?>" />
				</td >
				<td  width="165px">
					<input type="text" name="lib_evenement_<?php echo $evenement->id_evenement;?>" id="lib_evenement_<?php echo $evenement->id_evenement;?>" value="<?php echo $evenement->lib_evenement; ?>" class="classinput_nsize" size="12" style="width:80%"/>
					<input type="hidden" name="id_evenement" id="id_evenement" value="<?php echo $evenement->id_evenement; ?>" />
				</td>
				<td  width="80px" align="right">
					<input type="text" name="cout_<?php echo $evenement->id_evenement;?>" id="cout_<?php echo $evenement->id_evenement;?>" value="<?php echo (number_format($evenement->cout, $TARIFS_NB_DECIMALES, ".", ""	)); ?>" class="classinput_nsize" size="12" style="text-align:right"/>
					<input type="hidden" name="id_evenement" id="id_evenement" value="<?php echo $evenement->id_evenement; ?>" />
				</td>
				<td width="160px" align="right">
								<input name="modifier" id="modifier" type="image" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-modifier.gif" />

							&nbsp;
						</td>
						<td width="40px" align="right">
								<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/supprime.gif" id="supp_img_<?php echo $evenement->id_evenement; ?>" style="cursor:pointer"/>
								<input type="hidden" name="id_vehicule" id="id_vehicule" value="<?php echo $vehicule->id_vehicule; ?>" />
							&nbsp;
						</td>
				</tr>
				
				<script type="text/javascript">
				Event.observe('supp_img_<?php echo $evenement->id_evenement; ?>', "click", function(evt){
					Event.stop(evt);
					$("titre_alert").innerHTML = "Confirmation";
					$("texte_alert").innerHTML = "Confirmer la suppression de cet événement";
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
					page.verify("smenu_gestion_vehicules_evenements_del","smenu_gestion_vehicules_evenements_del.php?id_evenement=<?php echo $evenement->id_evenement; ?>", "true", "formFrame");
					}
				});
				
				//on masque le chargement
				H_loading();
				</script>
			</table>
			</form>
		</td>
	</tr>
	<?php } ?>
	<tr><td colspan="3"> </td></tr>
	<tr><td colspan="3"> </td></tr>
	<tr><td colspan="3"> </td></tr>
	<tr>
	<td></td>
	<td colspan="2"> Co&ucirc;t total des &eacute;v&eacute;nements affich&eacute;s : <?php echo (number_format($total, $TARIFS_NB_DECIMALES, ".", ""	)." ".$MONNAIE[1]);?> </td></tr>
	<tr><td colspan="3"> </td></tr>
</table>

</div>
</div>

<SCRIPT type="text/javascript">

Event.observe("osmenu_gestion_vehicules_ajout_evenement", "click",  function(evt){Event.stop(evt); page.verify('smenu_gestion_vehicules_ajout_evenement', 'smenu_gestion_vehicules_ajout_evenement.php?id_vehicule=<?php echo $vehicule->id_vehicule;?>' ,"true" ,"sub_content");}, false);
//on masque le chargement
H_loading();
</SCRIPT>
