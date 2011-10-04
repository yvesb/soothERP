<?php

// *************************************************************************************************************
// CONTROLE DU THEME
// *************************************************************************************************************

// Variables nécessaires à l'affichage
$page_variables = array ("magasins_liste", "BDD_MODE_VENTE", "DEFAUT_MODE_VENTE", "stocks_liste", "tarifs_liste");
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
tableau_smenu[1] = Array('catalogue_magasin','catalogue_magasins.php',"true" ,"sub_content", "Points de vente");
update_menu_arbo();
</script>
<div class="emarge">

<p class="titre">Points de vente.  </p>
<div style="height:50px;">
<table class="minimizetable">
<tr>
<td class="contactview_corps">
<div id="magasins" style=" padding-left:10px; padding-right:10px">

	
	<p>Ajouter un magasin </p>
			<table>
		<tr>
			<td>
		<table>
			<tr class="smallheight">
						<td style="width:15%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
						<td style="width:16%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
						<td style="width:15%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
						<td style="width:16%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
						<td style="width:20%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
						<td style="width:15%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
						<td style="width:5%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
						<td></td>
			</tr>	
			<tr>
			<td ><span class="labelled">Libell&eacute;:</span>
			</td>
			<td ><span class="labelled">Enseigne:</span>
			</td>
			<td ><span class="labelled">Lieu de stockage:</span>
			</td>
			<td ><span class="labelled">Tarif:</span>
			</td>
			<td ><span class="labelled">Mode de vente:</span>
			</td>
			<td style="text-align:center" ><span class="labelled">Actif:</span>
			</td>
			<td>
			</td>
		</tr>
	</table>
</td>
</tr>
</table>
	<div class="caract_table">
	<table>
		<tr class="smallheight">
			<td>
				<form action="catalogue_magasins_add.php" method="post" id="catalogue_magasins_add" name="catalogue_magasins_add" target="formFrame" >
				<table>
					<tr class="smallheight">
						<td style="width:15%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
						<td style="width:15%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
						<td style="width:15%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
						<td style="width:15%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
						<td style="width:15%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
						<td style="width:15%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
						<td style="width:5%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
					</tr>	
					<tr>
						<td>
						<input name="lib_magasin" id="lib_magasin" type="text" value=""  class="classinput_lsize"/>
						<input name="ajout_magasin" id="ajout_magasin" type="hidden" value="1"/>
						<div style="width:84%; text-align:right">
						Abrév: 
						<input name="abrev_magasin" id="abrev_magasin" type="text" value=""  class="classinput_nsize" size="4"/>
						</div>
						</td>
						<td>
							<select id="id_mag_enseigne" name="id_mag_enseigne" class="classinput_lsize">
								<option value="" ></option>
							<?php 
							foreach ($liste_enseignes as $enseigne) {
								?>
								<option value="<?php echo $enseigne->id_mag_enseigne; ?>" ><?php echo $enseigne->lib_enseigne; ?>
								</option>
								<?php 
							}
							?>
							</select>
							
						</td>
						<td>
							<select id="id_stock" name="id_stock" class="classinput_lsize">
							<?php 
							foreach ($stocks_liste as $stock_liste) {
							?>
								<option value="<?php echo $stock_liste->getId_stock(); ?>"><?php echo htmlentities($stock_liste->getLib_stock()); ?>
								</option>
							<?php 
							}
							?>
							</select>
							
						</td>
						<td>	
							<select id="id_tarif" name="id_tarif" class="classinput_lsize">
							<?php 
							foreach ($tarifs_liste as $tarif_liste) {
								?>
								<option value="<?php echo $tarif_liste->id_tarif; ?>"><?php echo htmlentities($tarif_liste->lib_tarif); ?>
								</option>
								<?php 
							}
							?>
							</select>
							
						</td>
						<td>
							<select id="mode_vente" name="mode_vente" class="classinput_lsize">
							<?php 
							foreach ($BDD_MODE_VENTE as $mode_vente) {
							?>
								<option value="<?php echo htmlentities($mode_vente); ?>" <?php if ($DEFAUT_MODE_VENTE==$mode_vente) {echo 'selected="selected"';}?>><?php echo htmlentities($mode_vente); ?>
							<?php 
							}
							?>
							</select>
							
						</td>
						<td style="text-align:center">
						<input name="actif"  type="checkbox" id="actif" value="" checked="checked" />
							
						</td>
						<td>
							<p style="text-align:right">
							<input name="ajouter" id="ajouter" type="image" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-ajouter.gif" />
							</p>
						</td>

					</tr>
				</table>
				</form>
			</td>
		</tr>
	</table>
	</div>
	<br />
	<?php 
	if ($magasins_liste) {
	?>
	<p>Liste des magasins </p>

		<table>
		<tr>
			<td>
		<table>
			<tr class="smallheight">
						<td style="width:18%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
						<td style="width:15%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
						<td style="width:16%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
						<td style="width:15%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
						<td style="width:16%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
						<td style="width:15%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
						<td style="width:5%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
						<td></td>
			</tr>	
			<tr>
			<td ><span class="labelled">Libell&eacute;:</span>
			</td>
			<td ><span class="labelled">Enseigne:</span>
			</td>
			<td ><span class="labelled">Lieu de stockage:</span>
			</td>
			<td ><span class="labelled">Tarif:</span>
			</td>
			<td ><span class="labelled">Mode de vente:</span>
			</td>
			<td ><span class="labelled">Actif:</span>
			</td>
			<td>
			</td>
		</tr>
	</table>
</td>
</tr>
</table>
	<?php 
	}
	foreach ($magasins_liste as $magasin_liste) {
	?>
	<div class="caract_table" id="magasin_table_<?php echo $magasin_liste->id_magasin; ?>">

		<table>
		<tr>
			<td>
				<form action="catalogue_magasins_mod.php" method="post" id="catalogue_magasins_mod_<?php echo $magasin_liste->id_magasin; ?>" name="catalogue_magasins_mod_<?php echo $magasin_liste->id_magasin; ?>" target="formFrame" >
				<table>
					
					<tr class="smallheight">
						<td style=""><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
						<td style="width:15%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
						<td style="width:15%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
						<td style="width:15%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
						<td style="width:15%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
						<td style="width:15%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
						<td style="width:15%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
						<td style="width:5%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
					</tr>	
					<tr>
						<td style="text-align:center">
						<?php if(count($magasins_liste ) == 1) {?>
						<input name="defaut_magasin_<?php echo $magasin_liste->id_magasin; ?>"  type="hidden" id="defaut_magasin_<?php echo $magasin_liste->id_magasin; ?>" value="1"  />
						<?php } else { ?>
						<input name="defaut_magasin_<?php echo $magasin_liste->id_magasin; ?>"  type="checkbox" id="defaut_magasin_<?php echo $magasin_liste->id_magasin; ?>" value="1" <?php if ( $DEFAUT_ID_MAGASIN == $magasin_liste->id_magasin) { echo 'checked="checked"';} ?>  alt="Magasin par défaut" title="Magasin par défaut" />
						<?php }?>
						</td>
						<td>
						<input id="lib_magasin_<?php echo $magasin_liste->id_magasin; ?>" name="lib_magasin_<?php echo $magasin_liste->id_magasin; ?>" type="text" value="<?php echo htmlentities($magasin_liste->lib_magasin); ?>"  class="classinput_lsize"/>
			<input name="id_magasin" id="id_magasin" type="hidden" value="<?php echo $magasin_liste->id_magasin; ?>" />
						<div style="width:84%; text-align:right">
						Abrév: 
						<input name="abrev_magasin_<?php echo $magasin_liste->id_magasin; ?>" id="abrev_magasin_<?php echo $magasin_liste->id_magasin; ?>" type="text" value="<?php echo htmlentities($magasin_liste->abrev_magasin); ?>"  class="classinput_nsize" size="4"/>
						</div>
							
						</td>
						<td>
							<select id="id_mag_enseigne_<?php echo $magasin_liste->id_magasin; ?>" name="id_mag_enseigne_<?php echo $magasin_liste->id_magasin; ?>" class="classinput_lsize">
								<option value="" ></option>
							<?php 
							foreach ($liste_enseignes as $enseigne) {
								?>
								<option value="<?php echo $enseigne->id_mag_enseigne; ?>" <?php if ($enseigne->id_mag_enseigne == $magasin_liste->id_mag_enseigne){echo 'selected="selected"';}?> ><?php echo $enseigne->lib_enseigne; ?>
								</option>
								<?php 
							}
							?>
							</select>
							
						</td>
						<td>
							<select id="id_stock_<?php echo $magasin_liste->id_magasin; ?>" name="id_stock_<?php echo $magasin_liste->id_magasin; ?>" class="classinput_lsize">
							<?php 
							foreach ($stocks_liste as $stock_liste) {
								?>
								<option value="<?php echo $stock_liste->getId_stock(); ?>" <?php if ($stock_liste->getId_stock() == $magasin_liste->id_stock){echo 'selected="selected"';}?>><?php echo htmlentities($stock_liste->getLib_stock()); ?>
								</option>
								<?php 
							}
							?>
							</select>
							
						</td>
						<td>	
							<select id="id_tarif_<?php echo $magasin_liste->id_magasin; ?>" name="id_tarif_<?php echo $magasin_liste->id_magasin; ?>" class="classinput_lsize">
							<?php 
							foreach ($tarifs_liste as $tarif_liste) {
							?>
								<option value="<?php echo $tarif_liste->id_tarif; ?>" <?php if ($tarif_liste->id_tarif==$magasin_liste->id_tarif){echo 'selected="selected"';}?>><?php echo htmlentities($tarif_liste->lib_tarif); ?>
								</option>
							<?php 
							}
							?>
							</select>
							
						</td>
						<td>
							<select id="mode_vente_<?php echo $magasin_liste->id_magasin; ?>" name="mode_vente_<?php echo $magasin_liste->id_magasin; ?>" class="classinput_lsize">
							<?php 
							foreach ($BDD_MODE_VENTE as $mode_vente) {
							?>
								<option value="<?php echo htmlentities($mode_vente); ?>" <?php if ($mode_vente==$magasin_liste->mode_vente){echo 'selected="selected"';}?>><?php echo htmlentities($mode_vente); ?>
							<?php 
							}
							?>
							</select>
							
						</td>
						<td style="text-align:center">
						<input id="actif_<?php echo $magasin_liste->id_magasin; ?>" name="actif_<?php echo $magasin_liste->id_magasin; ?>" value="<?php echo htmlentities($magasin_liste->actif); ?>" type="checkbox"  <?php if($magasin_liste->actif==1){echo 'checked="checked"';}?>/>
						</td>
						<td>
							<p style="text-align:right">
								<input name="modifier" id="modifier" type="image" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-modifier.gif" />
							</p>
						</td>
					</tr>
				</table>
				</form>
			</td>
		</tr>
	</table>
	</div>
	<br />
	<?php
	
	}
	?>
</div>
</td>
</tr>
</table>
<SCRIPT type="text/javascript">
new Form.EventObserver('catalogue_magasins_add', function(element, value){formChanged();});

<?php 
	foreach ($magasins_liste as $magasin_liste) {
?>
new Form.EventObserver('catalogue_magasins_mod_<?php echo $magasin_liste->id_magasin; ?>', function(element, value){formChanged();});
<?php
	}
?>

//on masque le chargement
H_loading();
</SCRIPT>
</div>
</div>