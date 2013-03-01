<span class="sous_titre2">Création d'une cat&eacute;gorie </span>



<script type="text/javascript" language="javascript">
</script>

<div id="specontent_art_categ" class="contactview_corps">



<div id="info_gene" style="overflow:auto; width:100%; height:100%;"  class="menu_link_affichage">
<div id="modifier_art_categ" style="padding-left:10px; padding-right:10px; height:100%">
	<form method="post" action="catalogues_clients_edition_avance_dir_add.php" id="catalogues_clients_edition_avance_dir_add" name="catalogues_clients_edition_avance_dir_add" target="formFrame">
	<table class="minimizetable">
				<tr class="smallheight">
					<td class="size_strict"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
					<td><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
				</tr>	
		<tr>
			<td class="size_strict"><span class="labelled">Cat&eacute;gorie parent: </span>
			</td>
			<td>
			<input name="id_catalogue_client" id="id_catalogue_client" type="hidden" value="<?php echo $_REQUEST["id_catalogue_client"]; ?>" />
			<select name="id_catalogue_dir_parent" id="id_catalogue_dir_parent" class="classinput_lsize">
			<option value="">Racine</option>
			<?php
			foreach ($list_catalogue_dir  as $catalogue_dir){
				?>
				<option value="<?php echo ($catalogue_dir->id_catalogue_client_dir)?>" <?php if ($catalogue_dir->id_catalogue_client_dir== $_REQUEST["id_catalogue_client_dir_parent"]) {echo 'selected="seleted"';}?>>
				<?php for ($i=0; $i<$catalogue_dir->indentation; $i++) {?>
					--
				<?php }?><?php echo htmlentities($catalogue_dir->lib_catalogue_client_dir)?>
				</option>
				<?php
			}
			?>
			</select>
			</td>
		</tr>
		<tr>
			<td class="size_strict"><span class="labelled">Cat&eacute;gorie d'origine: </span>
			</td>
			<td>
			<select name="ref_art_categ" id="ref_art_categ" class="classinput_lsize">
			<?php
				foreach ($select_art_categ  as $s_art_categ){
				if (isset($s_art_categ->lib_art_categ)) {
					?>
					<option value="<?php echo ($s_art_categ->ref_art_categ)?>" >
					<?php for ($i=0; $i<$s_art_categ->indentation; $i++) {?>
						--
					<?php }?><?php  echo htmlentities($s_art_categ->lib_art_categ);?>
					</option>
					<?php
				}
			}
			?>
			</select>
			</td>
		</tr>
		<tr>
			<td class="size_strict"><span class="labelled">Libell&eacute;:</span>
			</td>
			<td>
			<input name="lib_catalogue_client_dir" id="lib_catalogue_client_dir" type="text" class="classinput_xsize" value="" />
			</td>
		</tr>
	</table>
		<p style="text-align:center">
			<input type="image" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-ajouter.gif" name="bt_add_art_categs" id="bt_add_art_categs"/>
		</p>
	</form>
</div>


</div>


<SCRIPT type="text/javascript">

function setheight_catalogue_categorie_inc_mod(){
set_tomax_height("specontent_art_categ" , -55);
set_tomax_height("info_gene" , -55);
}
Event.observe(window, "resize", setheight_catalogue_categorie_inc_mod, false);
setheight_catalogue_categorie_inc_mod();

//on masque le chargement
H_loading();
</SCRIPT>
</div>