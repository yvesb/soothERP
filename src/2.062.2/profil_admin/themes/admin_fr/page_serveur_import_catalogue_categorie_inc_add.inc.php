<div id="ajout_info_categ" >
<span class="sous_titre2">Importer une cat&eacute;gorie d'articles</span>
<div  id="ajout_info_categ_content" style="overflow:auto; width:100%; height:100%;"  class="contactview_corps">
<div style="padding-left:10px; padding-right:10px; height:100%">
	<form method="post" action="serveur_import_catalogue_categorie_add.php" id="import_catalogue_ajout_categs" name="import_catalogue_ajout_categs" target="formFrame">
	<table class="minimizetable">
				<tr class="smallheight">
					<td class="size_strict"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
					<td><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
				</tr>	
		<tr>
			<td class="size_strict"><span class="labelled">Cat&eacute;gorie parent: </span>
			</td>
			<td>
			<input name="create_art_categs" id="create_art_categs" type="hidden" value="1" />
			<select name="ref_art_categ_parent" id="ref_art_categ_parent" class="classinput_xsize">
			<option value="">Racine</option>
			<?php
				$select_art_categ =	get_articles_categories();
				foreach ($select_art_categ  as $s_art_categ){
			?>
			<option value="<?php echo ($s_art_categ->ref_art_categ)?>" <?php if ($s_art_categ->ref_art_categ==$_REQUEST["ref_art_categ_parent"]) {echo 'selected="seleted"';}?>>
			<?php for ($i=0; $i<$s_art_categ->indentation; $i++) {?>
				--
			<?php }?><?php echo htmlentities($s_art_categ->lib_art_categ)?>
			</option>
			<?php
				}
			?>
			</select>
			</td>
		</tr>
		<tr>
			<td class="size_strict"><span class="labelled">Libell&eacute;:</span>
			</td>
			<td>
			<input name="ref_art_categ" id="ref_art_categ" type="hidden" value="<?php echo $_REQUEST["ref_art_categ"];?>" />
			<input name="lib_art_categ" id="lib_art_categ" type="text" class="classinput_xsize" value="<?php echo urldecode($_REQUEST["lib_art_categ"]);?>" />
			</td>
		</tr>
		<tr>
			<td class="size_strict"><span class="labelled">Mod&eacute;le:</span>
			</td>
			<td>
			<select name="modele" id="modele" class="classinput_xsize">
			<?php
				foreach ($BDD_MODELES as $cle_list_modele=>$list_modele) {?>
				<option value="<?php echo htmlentities($cle_list_modele)?>" <?php
							if ($_REQUEST["modele"] == $cle_list_modele) {echo ' selected="selected"';};
						?>><?php echo htmlentities($list_modele)?></option>
				<?php 
				}
			?>
			</select>
			</td>
		</tr>
		<tr>
			<td class="size_strict"><span class="labelled">Description:</span>
			</td>
			<td>
			<textarea name="desc_art_categ" rows="5" class="classinput_xsize" id="desc_art_categ" type="text"><?php echo utf8_decode($_REQUEST["desc_art_categ"]);?></textarea>
			</td>
		</tr>
		<tr>
			<td class="size_strict"><span class="labelled">Taux de TVA:</span>
			</td>
			<td>
				<select name="defaut_id_tva" id="defaut_id_tva"  class="classinput_xsize">
					<option value="">T.V.A. non applicable</option>
					<?php
					//liste des TVA par pays
					foreach ($tvas  as $tva){
						?>
						<option value="<?php echo $tva['id_tva'];?>" <?php
								if ($_REQUEST["defaut_id_tva"] == $tva['id_tva']) {echo ' selected="selected"';};
						?>>
						<?php echo htmlentities($tva['tva']);?>%</option>
						<?php 
					}
					?>
				</select>

			</td>
		</tr>
		<tr>
			<td class="size_strict"><span class="labelled" style="width:150px">Durée de vie des articles:</span>
			</td>
			<td>
			
				<select name="duree_dispo_an" id="duree_dispo_an"  class="classinput_nsize">
					<?php
					for ($i = 0; $i<=27; $i++){
						?>
						<option value="<?php echo $i;?>" <?php
								if (date("Y", mktime (date("m"),date("i"),date("s")+$_REQUEST["duree_dispo"], date("m"), date("d"), date("Y")))-date("Y") == $i) {echo ' selected="selected"';};
						?>>
						<?php echo $i;?></option>
						<?php 
					}
					?>
				</select> an(s)
				<select name="duree_dispo_mois" id="duree_dispo_mois"  class="classinput_nsize" >
					<?php
					for ($i = 0; $i<=12; $i++){
						?>
						<option value="<?php echo $i;?>" <?php
								if (date("m", mktime (date("m"),date("i"),date("s")+$_REQUEST["duree_dispo"], date("m"), date("d"), date("Y")))-date("m") == $i) {echo ' selected="selected"';};
						?>><?php echo $i;?></option>
						<?php 
					}
					?>
				</select> mois
				<select name="duree_dispo_jour" id="duree_dispo_jour"  class="classinput_nsize" >
					<?php
					for ($i = 0; $i<=30; $i++){
						?>
						<option value="<?php echo $i;?>" <?php
								if ( date("d", mktime (date("m"),date("i"),date("s")+$_REQUEST["duree_dispo"], date("m"), date("d"), date("Y")))-date("d") == $i) {echo ' selected="selected"';};
						?>><?php echo $i;?></option>
						<?php 
					}
					?>
				</select> jour(s)&nbsp;&nbsp;
			</td>
		</tr>
	</table>
	<p style="text-align:center">
	<input type="image" name="bt_add_art_categs_1" id="bt_add_art_categs_1" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-ajouter.gif"/>
	</p>
<?php 
if ($exist_carac_groupes) {
	?>
	<p>Liste des groupes de caract&eacute;ristiques de la cat&eacute;gories </p>
	
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
	$indent_carac_groupe = 0;
	foreach ($exist_carac_groupes as $exist_carac_groupe) {
		?>
		<table>
		<tr class="smallheight">
			<td style="width:90%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
			<td></td>
			<td></td>
		</tr>	
		<tr>
			<td>
				<table>
					<tr class="smallheight">
						<td style="width:90%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/>
						</td>
						<td style="width:10%"></td>
					</tr>	
					<tr>
						<td>
							<input name="lib_carac_groupe_<?php echo $exist_carac_groupe["ref_carac_groupe"]; ?>" id="lib_carac_groupe_<?php echo $exist_carac_groupe["ref_carac_groupe"]; ?>" value="<?php echo urldecode($exist_carac_groupe["lib_carac_groupe"])?>" class="classinput_xsize"/>
							<input name="ordre_carac_groupe_<?php echo $exist_carac_groupe["ref_carac_groupe"]; ?>" id="ordre_carac_groupe_<?php echo $exist_carac_groupe["ref_carac_groupe"]; ?>" value="<?php echo $exist_carac_groupe["ordre"]?>" type="hidden" />
							<input name="ref_carac_groupe_<?php echo $indent_carac_groupe?>" id="ref_carac_groupe_<?php echo $indent_carac_groupe?>" type="hidden" value="<?php echo $exist_carac_groupe["ref_carac_groupe"]; ?>" />
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
	<?php
	$indent_carac_groupe ++;
	}
	?>
	<p style="text-align:center">
	<input type="image" name="bt_add_art_categs_2" id="bt_add_art_categs_2" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-ajouter.gif"/>
	</p>
	<?php
}
?>

<?php 
if ($exist_caracs) {
	?>		
	<p>Liste des  caract&eacute;ristiques<br />
	<?php 
	$indent_carac = 0;
	foreach ($exist_caracs as $exist_carac) {
		?>		
		<div class="caract_table" id="caract_table_<?php echo $exist_carac["ref_carac"]; ?>">
		<table>
		<tr class="smallheight">
		<td>
			<table>
				<tr class="smallheight">
					<td style="width:25%;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
					<td style="width:25%;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
					<td style="width:25%;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
					<td style="width:25%;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
				</tr>
				<tr>
					<td><span class="labelled_nowidth">Libell&eacute;:</span>
							<input name="ref_caracs_<?php echo $indent_carac?>" id="ref_caracs_<?php echo $indent_carac?>" type="hidden" value="<?php echo $exist_carac["ref_carac"]; ?>" />	
							<input name="ordre_carac_<?php echo $exist_carac["ref_carac"]; ?>" id="ordre_carac_<?php echo $exist_carac["ref_carac"]; ?>" value="<?php echo $exist_carac["ordre"]?>" type="hidden" />			</td>
					<td><span class="labelled_nowidth">Unit&eacute;: </span></td>
					<td><span class="labelled_nowidth">Crit&egrave;re de recherche: </span></td>
					<td><span class="labelled_nowidth">Affichage:</span></td>
				</tr>
				<tr>
					<td><input name="lib_carac_<?php echo $exist_carac["ref_carac"]; ?>" id="lib_carac_<?php echo $exist_carac["ref_carac"]; ?>" value="<?php echo urldecode($exist_carac["lib_carac"]); ?>"  class="classinput_xsize"/></td>
					<td><span class="labelled_nowidth">
						<input name="unite_<?php echo $exist_carac["ref_carac"]; ?>" id="unite_<?php echo $exist_carac["ref_carac"]; ?>" type="text" value="<?php echo urldecode($exist_carac["unite"]); ?>" class="classinput_xsize" />
					</span></td>
					<td><select name="moteur_recherche_<?php echo $exist_carac["ref_carac"]; ?>" id="moteur_recherche_<?php echo $exist_carac["ref_carac"]; ?>"  class="classinput_xsize">
							<option value="0" <?php if ($exist_carac["moteur_recherche"]==0) {echo 'selected="selected"';}?>>Non</option>
							<option value="1" <?php if ($exist_carac["moteur_recherche"]==1) {echo 'selected="selected"';}?>>Simple</option>
							<option value="2" <?php if ($exist_carac["moteur_recherche"]==2) {echo 'selected="selected"';}?>>Avanc&eacute;</option>
					</select></td>
					<td><select name="affichage_<?php echo $exist_carac["ref_carac"]; ?>" id="affichage_<?php echo $exist_carac["ref_carac"]; ?>"  class="classinput_xsize">
							<option value="1" <?php if ($exist_carac["affichage"]==1) {echo 'selected="selected"';}?>>Normal</option>
							<option value="2" <?php if ($exist_carac["affichage"]==2) {echo 'selected="selected"';}?>>Prioritaire</option>
					</select></td>
				</tr>
				<tr>
					<td><span class="labelled_nowidth">Valeur par d&eacute;faut:</span></td>
					<td><span class="labelled_nowidth">Valeurs autoris&eacute;es:</span></td>
					<td><span class="labelled_nowidth">Groupe:</span></td>
					<td><span class="labelled_nowidth">Variante:</span></td>
				</tr>
				<tr>
					<td><input name="default_value_<?php echo $exist_carac["ref_carac"]; ?>" id="default_value_<?php echo $exist_carac["ref_carac"]; ?>" type="text" value="<?php echo urldecode($exist_carac["default_value"]); ?>" class="classinput_xsize" /></td>
					<td><input name="allowed_values_<?php echo $exist_carac["ref_carac"]; ?>" type="text" class="classinput_xsize" id="allowed_values_<?php echo $exist_carac["ref_carac"]; ?>" value="<?php echo urldecode($exist_carac["allowed_values"]); ?>" /></td>
					<td><select name="ref_carac_groupe_<?php echo $exist_carac["ref_carac"]; ?>" id="ref_carac_groupe_<?php echo $exist_carac["ref_carac"]; ?>"  class="classinput_xsize">
							<option value="">Aucun</option>
							<?php 
		foreach ($exist_carac_groupes as $exist_carac_groupe) {
		?>
							<option value="<?php echo $exist_carac_groupe["ref_carac_groupe"]; ?>" <?php if ($exist_carac_groupe["ref_carac_groupe"]==$exist_carac["ref_carac_groupe"]) {echo 'selected="selected"';}?>><?php echo urldecode($exist_carac_groupe["lib_carac_groupe"])?></option>
							<?php
		
		}
		?>
					</select></td>
					<td>
							<input type="checkbox" name="variante_<?php echo $exist_carac["ref_carac"]; ?>" id="variante_<?php echo $exist_carac["ref_carac"]; ?>" value="1" <?php if ($exist_carac["variante"]==1) {echo 'checked="checked"';}?> />				</td>
				</tr>
			</table>
		</td>
		</tr>
		</table>
		</div>
		<br />
		</p>
		<?php
		$indent_carac ++;
	}
	?>
	<p style="text-align:center">
	<input type="image" name="bt_add_art_categs_3" id="bt_add_art_categs_3" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-ajouter.gif"/>
	</p>
	<?php
}
?>
	</form>
	</div>
</div>


<SCRIPT type="text/javascript">
function setheight_catalogue_categorie_inc_add(){
	set_tomax_height("ajout_info_categ_content" , -55);
}

Event.observe(window, "resize", setheight_catalogue_categorie_inc_add, false);

setheight_catalogue_categorie_inc_add();
//on masque le chargement
H_loading();
</SCRIPT>