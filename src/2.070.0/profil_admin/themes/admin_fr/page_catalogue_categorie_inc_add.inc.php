<div id="ajout_info_categ" >
<span class="sous_titre2">Ajouter une cat&eacute;gorie d'articles</span>
<div class="menu">&nbsp;</div>
<div  id="ajout_info_categ_content" style="overflow:auto; width:100%; height:100%;"  class="contactview_corps">
<div style="padding-left:10px; padding-right:10px; height:100%">
	<form method="post" action="catalogue_categorie_add.php" id="catalogue_ajout_categs" name="catalogue_ajout_categs" target="formFrame">
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
			<input name="lib_art_categ" id="lib_art_categ" type="text" class="classinput_xsize" value="" />
			</td>
		</tr>
		<tr>
			<td class="size_strict"><span class="labelled">Mod&eacute;le:</span>
			</td>
			<td>
			<select name="modele" id="modele" class="classinput_xsize">
			<?php
				foreach ($BDD_MODELES as $cle_list_modele=>$list_modele) {?>
				<option value="<?php echo htmlentities($cle_list_modele)?>"><?php echo htmlentities($list_modele)?></option>
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
			<textarea name="desc_art_categ" rows="5" class="classinput_xsize" id="desc_art_categ" type="text"></textarea>
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
								if ($DEFAUT_ID_TVA == $tva['id_tva']) {echo ' selected="selected"';};
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
								if (date("Y", mktime (date("m"),date("i"),date("s")+$DEFAUT_ARTICLE_LT, date("m"), date("d"), date("Y")))-date("Y") == $i) {echo ' selected="selected"';};
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
								if (date("m", mktime (date("m"),date("i"),date("s")+$DEFAUT_ARTICLE_LT, date("m"), date("d"), date("Y")))-date("m") == $i) {echo ' selected="selected"';};
						?>><?php echo $i;?></option>
						<?php 
					}
					?>
				</select> mois
				<input type="hidden" name="duree_dispo_jour" id="duree_dispo_jour" value="0" >
			</td>
		</tr>
		<tr>
			<td class="size_strict"><span class="labelled">Restriction:</span>
			</td>
			<td>
				<select name="restriction" id="restriction"  class="classinput_xsize">
					<option value="aucune">Aucune Restriction</option>
					<option value="achat">Restreindre à l'achat</option>
					<option value="vente">Restreindre à la vente</option>
				</select>

			</td>
		</tr>
	</table>
		<p style="text-align:center">
		<input type="image" name="bt_add_art_categs" id="bt_add_art_categs" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-ajouter.gif"/>
		</p>
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