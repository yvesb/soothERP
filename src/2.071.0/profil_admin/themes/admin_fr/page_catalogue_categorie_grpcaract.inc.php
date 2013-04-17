<div style="padding-left:10px; padding-right:10px; height:100%">
	<p class="bolder">Ajouter un groupe de caract&eacute;ristiques</p>
	
	<table>
		<tr class="smallheight">
			<td class="size_strict"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/>
			</td>
		</tr>	
		<tr>
			<td class="size_strict"><span class="labelled">Libell&eacute; </span>
			</td>
		</tr>
	</table>
	
	<div class="caract_table">
	<table>
		<tr class="smallheight">
			<td style="width:90%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/>
			</td>
			<td></td>
			<td></td>
		</tr>	
		<tr>
			<td>
				<form action="catalogue_categorie_grpcaract_add.php" method="post" id="catalogue_categorie_add_grpcaract" name="catalogue_categorie_add_grpcaract" target="formFrame" >
				<table>
					<tr class="smallheight">
						<td style="width:90%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/>
						</td>
						<td style="width:10%"></td>
					</tr>	
					<tr>
						<td>
							<input name="lib_carac_groupe_new" id="lib_carac_groupe_new" value=""  class="classinput_xsize"/>
							<input name="ref_art_categ" id="ref_art_categ" type="hidden" value="<?php echo $art_categ->getRef_art_categ(); ?>" />
						</td>
						<td>
							<input name="ajouter" id="ajouter" type="image" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-ajouter.gif" />
						</td>
					</tr>
				</table>
				</form>
			</td>
			<td style="width:55px">
			</td>
			<td style="width:12px">
			</td>
		</tr>
	</table>
	</div>
	<br />
	<?php 
	$exist_carac_groupes	=	$art_categ-> getCarac_groupes ();
	if ($exist_carac_groupes) {
	?>
	<p class="bolder">Liste des groupes de caract&eacute;ristiques de la cat&eacute;gories </p>
	
	<table>
		<tr class="smallheight">
			<td class="size_strict"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/>
			</td>
		</tr>	
		<tr>
			<td class="size_strict"><span class="labelled">Libell&eacute; </span>
			</td>
		</tr>
	</table>
	
	<?php 
	}
	$fleches_ascenseur=0;
	foreach ($exist_carac_groupes as $exist_carac_groupe) {
	?>
	<div class="caract_table" id="caract_table_<?php echo $exist_carac_groupe->ref_carac_groupe; ?>">

	<table>
		<tr class="smallheight">
			<td style="width:90%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
			<td></td>
			<td></td>
		</tr>	
		<tr>
			<td>
				<form action="catalogue_categorie_grpcaract_mod.php" method="post" id="catalogue_categorie_mod_grpcaract_<?php echo $exist_carac_groupe->ref_carac_groupe; ?>" name="catalogue_categorie_mod_grpcaract_<?php echo $exist_carac_groupe->ref_carac_groupe; ?>" target="formFrame"  >
				<table>
					<tr class="smallheight">
						<td style="width:90%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/>
						</td>
						<td style="width:10%"></td>
					</tr>	
					<tr>
						<td>
							<input name="lib_carac_groupe_<?php echo $exist_carac_groupe->ref_carac_groupe; ?>" id="lib_carac_groupe_<?php echo $exist_carac_groupe->ref_carac_groupe; ?>" value="<?php echo htmlentities($exist_carac_groupe->lib_carac_groupe)?>" class="classinput_xsize"/>
							<input name="ref_carac_groupe" id="ref_carac_groupe" type="hidden" value="<?php echo $exist_carac_groupe->ref_carac_groupe; ?>" />
							<input name="ref_art_categ" id="ref_art_categ" type="hidden" value="<?php echo $art_categ->getRef_art_categ(); ?>" />
						</td>
						<td>
							<input name="modifier_<?php echo $exist_carac_groupe->ref_carac_groupe; ?>" id="modifier_<?php echo $exist_carac_groupe->ref_carac_groupe; ?>" type="image" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-modifier.gif">
						</td>
					</tr>
				</table>
				</form>
			</td>
			<td style="width:55px;">
				<form method="post" action="catalogue_categorie_grpcaract_sup.php" id="catalogue_categorie_sup_grpcaract_<?php echo $exist_carac_groupe->ref_carac_groupe; ?>" name="catalogue_categorie_sup_grpcaract_<?php echo $exist_carac_groupe->ref_carac_groupe; ?>" target="formFrame">
				<input name="ref_carac_groupe" id="ref_carac_groupe" type="hidden" value="<?php echo $exist_carac_groupe->ref_carac_groupe; ?>" />
				<input name="ref_art_categ" id="ref_art_categ" type="hidden" value="<?php echo $art_categ->getRef_art_categ(); ?>" />
				</form>
				<a href="#" id="link_catalogue_categorie_sup_grpcaract_<?php echo $exist_carac_groupe->ref_carac_groupe; ?>"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/supprime.gif" border="0"></a>
				<script type="text/javascript">
				Event.observe("link_catalogue_categorie_sup_grpcaract_<?php echo $exist_carac_groupe->ref_carac_groupe; ?>", "click",  function(evt){Event.stop(evt); alerte.confirm_supprimer('catalogue_categorie_sup_grpcaract', 'catalogue_categorie_sup_grpcaract_<?php echo $exist_carac_groupe->ref_carac_groupe; ?>');}, false);
				</script>
			</td>
			<td style="width:12px">
				<table cellspacing="0">
					<tr>
						<td>
							<div id="up_arrow_<?php echo $exist_carac_groupe->ref_carac_groupe; ?>">
							<?php
							if ($fleches_ascenseur!=0) {
							?>
							<form action="catalogue_categorie_grpcaract_ordre.php" method="post" id="catalogue_categs_grpcaract_ordre_<?php echo $exist_carac_groupe->ref_carac_groupe; ?>" name="catalogue_categs_grpcaract_ordre_<?php echo $exist_carac_groupe->ref_carac_groupe; ?>" target="formFrame">

								<input name="ordre" id="ordre" type="hidden" value="<?php echo ($exist_carac_groupes[$fleches_ascenseur-1]->ordre)?>" />
								<input name="ordre_other" id="ordre_other" type="hidden" value="<?php echo ($exist_carac_groupe->ordre)?>" />
								<input name="ref_art_categ" id="ref_art_categ" type="hidden" value="<?php echo $art_categ->getRef_art_categ(); ?>" />
								
								<input name="modifier_ordre_<?php echo $exist_carac_groupe->ref_carac_groupe; ?>" id="modifier_ordre_<?php echo $exist_carac_groupe->ref_carac_groupe; ?>" type="image" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/up.gif">
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
						<div id="down_arrow_<?php echo $exist_carac_groupe->ref_carac_groupe; ?>">
							<?php
							if ($fleches_ascenseur!=count($exist_carac_groupes)-1) {
							?>
							<form action="catalogue_categorie_grpcaract_ordre.php" method="post" id="catalogue_categs_grpcaract_ordre_<?php echo $exist_carac_groupe->ref_carac_groupe; ?>" name="catalogue_categs_grpcaract_ordre_<?php echo $exist_carac_groupe->ref_carac_groupe; ?>" target="formFrame">

								<input name="ordre" id="ordre" type="hidden" value="<?php echo ($exist_carac_groupes[$fleches_ascenseur+1]->ordre)?>" />
								<input name="ordre_other" id="ordre_other" type="hidden" value="<?php echo ($exist_carac_groupe->ordre)?>" />
								<input name="ref_art_categ" id="ref_art_categ" type="hidden" value="<?php echo $art_categ->getRef_art_categ(); ?>" />
								
								<input name="modifier_ordre_<?php echo $exist_carac_groupe->ref_carac_groupe; ?>" id="modifier_ordre_<?php echo $exist_carac_groupe->ref_carac_groupe; ?>" type="image" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/down.gif">
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
	<br />
	<?php
	
	$fleches_ascenseur++;
	}
	?>
</div>