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
<script type="text/javascript">
</script>
<div class="emarge">
<?php

foreach ($livraison_zones as $zone) {
	?>
	<div style=" border-bottom:1px solid #999999" id="add_zone_mode_liv_aff_<?php echo $zone->id_livraison_zone;?>_<?php echo $livraison_mode->getId_livraison_mode();?>">
	
	
				<form method="post" action="livraison_modes_zone_sup.php" id="livraison_modes_zone_sup_<?php echo $zone->id_livraison_zone;?>_<?php echo $livraison_mode->getId_livraison_mode(); ?>" name="livraison_modes_zone_sup_<?php echo $zone->id_livraison_zone;?>_<?php echo $livraison_mode->getId_livraison_mode(); ?>" target="formFrame">
					<input name="id_livraison_mode" type="hidden" value="<?php echo $livraison_mode->getId_livraison_mode(); ?>" />
					<input name="id_livraison_zone" type="hidden" value="<?php echo $zone->id_livraison_zone; ?>" />
				</form>
				<a href="#" id="link_livraison_modes_zone_sup_<?php echo $zone->id_livraison_zone;?>_<?php echo $livraison_mode->getId_livraison_mode(); ?>" style="float:right" ><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/supprime.gif" border="0"></a>
				<script type="text/javascript">
				Event.observe("link_livraison_modes_zone_sup_<?php echo $zone->id_livraison_zone;?>_<?php echo $livraison_mode->getId_livraison_mode(); ?>", "click",  function(evt){Event.stop(evt); alerte.confirm_supprimer('livraison_modes_zone_sup', 'livraison_modes_zone_sup_<?php echo $zone->id_livraison_zone;?>_<?php echo $livraison_mode->getId_livraison_mode(); ?>');}, false);
				</script>
				
				
	<form method="post" action="livraison_modes_zone_mod.php" id="livraison_modes_zone_mod_<?php echo $zone->id_livraison_zone;?>_<?php echo $livraison_mode->getId_livraison_mode(); ?>" name="livraison_modes_zone_mod_<?php echo $zone->id_livraison_zone;?>_<?php echo $livraison_mode->getId_livraison_mode(); ?>" target="formFrame">
	
	<input name="id_livraison_zone"  type="hidden" value="<?php echo $zone->id_livraison_zone;?>" />
	<input name="id_livraison_mode"  type="hidden" value="<?php echo $livraison_mode->getId_livraison_mode();?>" />
	<table style="width:100%">
		<tr class="smallheight">
			<td style="width:40%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
			<td style="width:40%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
			<td style="width:20%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
		</tr>
		<tr >
			<td >
			Liste des codes postaux:
	
			</td>
			<td >
			Pays:
			</td>
			<td >
			</td>
		</tr>
		<tr >
			<td >
			<textarea name="zone_liste_cp_<?php echo $zone->id_livraison_zone;?>_<?php echo $livraison_mode->getId_livraison_mode();?>" id="zone_liste_cp_<?php echo $zone->id_livraison_zone;?>_<?php echo $livraison_mode->getId_livraison_mode();?>" class="classinput_xsize" ><?php echo $zone->liste_cp;?></textarea>
			</td>
			<td >
			<select  id="zone_id_pays_<?php echo $zone->id_livraison_zone;?>_<?php echo $livraison_mode->getId_livraison_mode();?>"  name="zone_id_pays_<?php echo $zone->id_livraison_zone;?>_<?php echo $livraison_mode->getId_livraison_mode();?>" class="classinput_xsize">
			<?php
				$separe_listepays = 0;
				foreach ($listepays as $payslist){
					if ((!$separe_listepays) && (!$payslist->affichage)) { 
						$separe_listepays = 1; ?>
						<OPTGROUP disabled="disabled" label="__________________________________" ></OPTGROUP>
						<?php 		 
					}
					?>
					<option value="<?php echo $payslist->id_pays?>" <?php if ($zone->id_pays == $payslist->id_pays) {echo 'selected="selected"';}?>>
					<?php echo htmlentities($payslist->pays)?></option>
					<?php 
				}
				?>
			</select>
			</td>
			<td >
				<input name="modifier_<?php echo $zone->id_livraison_zone;?>_<?php echo $livraison_mode->getId_livraison_mode();?>" id="modifier_<?php echo $zone->id_livraison_zone;?>_<?php echo $livraison_mode->getId_livraison_mode();?>" type="image" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-modifier.gif" />
			</td>
		</tr>
	</table>
	</form>
	</div>
	<?php
	
}
?>

<div style="display:none" id="add_zone_mode_liv_aff_<?php echo $livraison_mode->getId_livraison_mode();?>">

<form method="post" action="livraison_modes_zone_add.php" id="livraison_modes_zone_add_<?php echo $livraison_mode->getId_livraison_mode(); ?>" name="livraison_modes_zone_add_<?php echo $livraison_mode->getId_livraison_mode(); ?>" target="formFrame">

<input name="id_livraison_mode"  type="hidden" value="<?php echo $livraison_mode->getId_livraison_mode();?>" />
<table style="width:100%">
	<tr class="smallheight">
		<td style="width:40%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
		<td style="width:40%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
		<td style="width:20%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
	</tr>
	<tr >
		<td >
		Liste des codes postaux (séparés par ;) :

		</td>
		<td >
		Pays:
		</td>
		<td >
		</td>
	</tr>
	<tr >
		<td >
		<textarea name="zone_liste_cp_<?php echo $livraison_mode->getId_livraison_mode();?>" id="zone_liste_cp_<?php echo $livraison_mode->getId_livraison_mode();?>" class="classinput_xsize"></textarea>
		</td>
		<td >
		<select  id="zone_id_pays_<?php echo $livraison_mode->getId_livraison_mode();?>"  name="zone_id_pays_<?php echo $livraison_mode->getId_livraison_mode();?>" class="classinput_xsize">
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
		<td >
			<input name="ajouter_<?php echo $livraison_mode->getId_livraison_mode();?>" id="ajouter_<?php echo $livraison_mode->getId_livraison_mode();?>" type="image" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-ajouter.gif" />
		</td>
	</tr>
</table>
</form>
</div>

<div id="add_loc_liv_mode_liv_<?php echo $livraison_mode->getId_livraison_mode();?>" style="cursor:pointer"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/ajouter.gif" /> <span style="font-weight:bolder">Ajouter une zone</span></div>
					
<script type="text/javascript">
Event.observe('add_loc_liv_mode_liv_<?php echo $livraison_mode->getId_livraison_mode();?>', 'click',  function(){
	$("add_zone_mode_liv_aff_<?php echo $livraison_mode->getId_livraison_mode();?>").show();
}, false);
</script>

</div>

<SCRIPT type="text/javascript">

//on masque le chargement
H_loading();
</SCRIPT>