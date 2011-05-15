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

<p class="titre">Gestion des caisses</p>
<div style="height:50px">
<table class="minimizetable">
<tr>
<td class="contactview_corps">
<div id="cat_client" style="padding-left:10px; padding-right:10px">

	<p>Choix du magasin </p>

	<select id="choix_id_magasin" name="choix_id_magasin" >
	<option value=""></option>
	<?php 
	foreach ($magasins_liste as $magasin_liste) {
		?>
		<option value="<?php echo $magasin_liste->id_magasin; ?>" <?php if ($magasin_liste->id_magasin == $id_magasin) {echo 'selected="selected"';}?>><?php echo htmlentities($magasin_liste->lib_magasin); ?></option>
		<?php 
	}
	?>
	</select>
	<br />
	<br />
<?php
if (isset($id_magasin)) {
	?>
	<p>Ajouter une caisse </p>
	
	
		<div>
			<table>
				<tr>
					<td style="width:95%">
						<table>
							<tr class="smallheight">
								<td style="width:25%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
								<td style="width:25%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
								<td style="width:25%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
								<td style="width:25%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
							</tr>	
							<tr>
								<td style="text-align:center">
								Libell&eacute;: 
								</td>
								<td style="text-align:center">Magasin: 
								</td>
								<td style="text-align:center">
								</td>
								<td style="text-align:center">
								</td>
							</tr>
						</table>
					</td>
					<td style="width:55px; text-align:center">
					
					</td>
				</tr>
			</table>
		</div>
		<div class="caract_table">
	
		<table>
		<tr>
			<td style="width:95%">
				<form action="compta_compte_caisse_add.php" method="post" id="compta_compte_caisse_add" name="compta_compte_caisse_add" target="formFrame" >
				<table>
					<tr class="smallheight">
								<td style="width:25%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
								<td style="width:25%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
								<td style="width:25%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
								<td style="width:25%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
					</tr>	
					<tr>
						<td style="text-align:center">
						<input name="lib_caisse" id="lib_caisse" type="text" value=""  class="classinput_xsize"  />
						</td>
						<td style="text-align:center">
						<select id="id_magasin" name="id_magasin"  class="classinput_xsize" >
							<option value=""></option>
							<?php 
							foreach ($magasins_liste as $magasin_liste) {
								?>
								<option value="<?php echo $magasin_liste->id_magasin; ?>" <?php if ($magasin_liste->id_magasin == $id_magasin) {echo 'selected="selected"';}?>><?php echo htmlentities($magasin_liste->lib_magasin); ?></option>
								<?php 
							}
							?>
						</select>
						</td>
						<td>
						</td>
						<td style="text-align:center">
						<input name="ajouter" id="ajouter" type="image" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-ajouter.gif" />
						</td>
					</tr>
				</table>
				</form>
			</td>
			<td>
			</td>
		</tr>
	</table>
	</div>
	<?php 
	if ($comptes_caisses) {
		?>
		<p>Caisses</p>
		
		<div>
			<table>
				<tr>
					<td style="width:95%">
						<table>
							<tr class="smallheight">
								<td style="width:25%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
								<td style="width:25%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
								<td style="width:25%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
								<td style="width:25%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
							</tr>	
							<tr>
								<td style="text-align:center">
								Libell&eacute;: 
								</td>
								<td style="text-align:center">Magasin: 
								</td>
								<td style="text-align:center">Actif:
								</td>
								<td style="text-align:center">
								</td>
							</tr>
						</table>
					</td>
					<td style="width:55px; text-align:center">
					
					</td>
				</tr>
			</table>
		</div>
		<?php
		
		$fleches_ascenseur=0;
		foreach ($comptes_caisses as $compte_caisse) {
			?>
			<div class="caract_table">
				<table>
				<tr>
					<td style="width:95%">
						<form action="compta_compte_caisse_mod.php" method="post" id="compta_compte_caisse_mod_<?php echo $compte_caisse->id_compte_caisse;?>" name="compta_compte_caisse_mod_<?php echo $compte_caisse->id_compte_caisse;?>" target="formFrame" >
						<table>
							<tr class="smallheight">
								<td style="width:25%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
								<td style="width:25%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
								<td style="width:25%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
								<td style="width:25%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
							</tr>	
							<tr>
								<td style="text-align:center">
								<input name="lib_caisse_<?php echo $compte_caisse->id_compte_caisse;?>" id="lib_caisse_<?php echo $compte_caisse->id_compte_caisse;?>" type="text" value="<?php echo htmlentities($compte_caisse->lib_caisse);?>"  class="classinput_xsize"  />
								</td>
								<td style="text-align:center">
								<select id="id_magasin_<?php echo $compte_caisse->id_compte_caisse;?>" name="id_magasin_<?php echo $compte_caisse->id_compte_caisse;?>"  class="classinput_xsize" >
									<option value=""></option>
									<?php 
									foreach ($magasins_liste as $magasin_liste) {
										?>
										<option value="<?php echo $magasin_liste->id_magasin; ?>" <?php if ($magasin_liste->id_magasin == $compte_caisse->id_magasin) {echo 'selected="selected"';}?>><?php echo htmlentities($magasin_liste->lib_magasin); ?></option>
										<?php 
									}
									?>
								</select>
								</td>
								<td style="text-align:center">
							<input type="checkbox" id="actif_<?php echo $compte_caisse->id_compte_caisse;?>" name="actif_<?php echo $compte_caisse->id_compte_caisse;?>" value="1" <?php if ($compte_caisse->actif) {echo 'checked="checked"';};?>/>
								<input id="id_compte_caisse" name="id_compte_caisse" value="<?php echo $compte_caisse->id_compte_caisse?>" type="hidden"/>
								</td>
								<td style="text-align:center">
						<input name="modifier_<?php echo $compte_caisse->id_compte_caisse;?>" id="modifier_<?php echo $compte_caisse->id_compte_caisse;?>" type="image" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-modifier.gif" />
								</td>
							</tr>
						</table>
						</form>
					</td>
					<td style="width:55px; text-align:center">
					<form method="post" action="compta_compte_caisse_sup.php" id="compta_compte_caisse_sup_<?php echo $compte_caisse->id_compte_caisse; ?>" name="compta_compte_caisse_sup_<?php echo $compte_caisse->id_compte_caisse; ?>" target="formFrame">
						<input id="id_magasin_<?php echo $compte_caisse->id_compte_caisse;?>" name="id_magasin_<?php echo $compte_caisse->id_compte_caisse;?>" value="<?php echo $compte_caisse->id_magasin?>" type="hidden"/>
						<input name="id_compte_caisse" id="id_compte_caisse" type="hidden" value="<?php echo $compte_caisse->id_compte_caisse; ?>" />
					</form>
					<a href="#" id="link_compta_compte_caisse_sup_<?php echo $compte_caisse->id_compte_caisse; ?>"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/supprime.gif" border="0"></a>
					<script type="text/javascript">
					Event.observe("link_compta_compte_caisse_sup_<?php echo $compte_caisse->id_compte_caisse; ?>", "click",  function(evt){Event.stop(evt); alerte.confirm_supprimer('compta_compte_caisse_sup', 'compta_compte_caisse_sup_<?php echo $compte_caisse->id_compte_caisse; ?>');}, false);
					</script>
					<table cellspacing="0">
						<tr>
							<td>
								<div id="up_arrow_<?php echo $compte_caisse->id_compte_caisse; ?>">
								<?php
								if ($fleches_ascenseur!=0) {
								?>
								<form action="compta_compte_caisse_ordre.php" method="post" id="compta_compte_caisse_ordre_<?php echo $compte_caisse->id_compte_caisse; ?>" name="compta_compte_caisse_ordre_<?php echo $compte_caisse->id_compte_caisse; ?>" target="formFrame">
									<input name="new_ordre" id="new_ordre" type="hidden" value="<?php echo ($compte_caisse->ordre)-1?>" />
									<input name="id_compte_caisse" id="id_compte_caisse" type="hidden" value="<?php echo $compte_caisse->id_compte_caisse; ?>" />
									
									<input id="id_magasin_<?php echo $compte_caisse->id_compte_caisse;?>" name="id_magasin_<?php echo $compte_caisse->id_compte_caisse;?>" value="<?php echo $compte_caisse->id_magasin?>" type="hidden"/>
									
									<input name="modifier_ordre_<?php echo $compte_caisse->id_compte_caisse; ?>" id="modifier_ordre_<?php echo $compte_caisse->id_compte_caisse; ?>" type="image" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/up.gif">
								</form>
								<?php
								} else {
								?>
								<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="1" height="1"/>
								<?php
								}
								?>
								</div>
							</td>
						</tr>
						<tr>
							<td>
							<div id="down_arrow_<?php echo $compte_caisse->id_compte_caisse; ?>">
								<?php
								if ($fleches_ascenseur!=count($comptes_caisses)-1) {
								?>
							<form action="compta_compte_caisse_ordre.php" method="post" id="compta_compte_caisse_ordre_<?php echo $compte_caisse->id_compte_caisse; ?>" name="compta_compte_caisse_ordre_<?php echo $compte_caisse->id_compte_caisse; ?>" target="formFrame">
									<input name="new_ordre" id="new_ordre" type="hidden" value="<?php echo ($compte_caisse->ordre)+1?>" />
									<input name="id_compte_caisse" id="id_compte_caisse" type="hidden" value="<?php echo $compte_caisse->id_compte_caisse; ?>" />
									
									<input id="id_magasin_<?php echo $compte_caisse->id_compte_caisse;?>" name="id_magasin_<?php echo $compte_caisse->id_compte_caisse;?>" value="<?php echo $compte_caisse->id_magasin?>" type="hidden"/>
									
									<input name="modifier_ordre_<?php echo $compte_caisse->id_compte_caisse; ?>" id="modifier_ordre_<?php echo $compte_caisse->id_compte_caisse; ?>" type="image" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/down.gif">
								</form>
								<?php
								} else {
								?>
								<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="1" height="1"/>							
								<?php
								}
								?>
								</div>
							</td>
						</tr>
					</table>
					</td>
				</tr>
			</table>
			</div>
			<?php 
			$fleches_ascenseur++;
			}
		?>
		<?php 
		}
}
?>

</div>
</td>
</tr>
</table>

<SCRIPT type="text/javascript">
Event.observe("choix_id_magasin", "change", function(evt){ if ($("choix_id_magasin").value != "") { page.traitecontent('compta_compte_caisse','compta_compte_caisse.php?id_magasin='+$("choix_id_magasin").value,'true','sub_content');} }, false);	
<?php
if (isset($id_magasin)) {
	?>
	new Form.EventObserver('compta_compte_caisse_add', function(){formChanged();});
	<?php
	foreach ($comptes_caisses as $compte_caisse) {
		?>
		Event.observe($("actif_<?php echo $compte_caisse->id_compte_caisse;?>"), "click", function(evt){
			if ($("actif_<?php echo $compte_caisse->id_compte_caisse;?>").checked) {
				set_active_compte_caisse("<?php echo $compte_caisse->id_compte_caisse;?>");
			} else {
				set_desactive_compte_caisse("<?php echo $compte_caisse->id_compte_caisse;?>");
			}
		});
		
		
		
		new Form.EventObserver('compta_compte_caisse_mod_<?php echo $compte_caisse->id_compte_caisse; ?>', function(){formChanged();});
		<?php 
		}
}
?>


//on masque le chargement
H_loading();
</SCRIPT>
</div>
</div>