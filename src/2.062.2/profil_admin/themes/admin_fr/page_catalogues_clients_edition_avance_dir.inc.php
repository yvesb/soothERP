<span class="sous_titre2">Modification la cat&eacute;gorie <strong><?php echo htmlentities($catalogue_client_dir->lib_catalogue_client_dir); ?></strong>
</span>



<script type="text/javascript" language="javascript">
</script>

<div id="specontent_art_categ" class="contactview_corps">



<div id="info_gene" style="overflow:auto; width:100%; height:100%;"  class="menu_link_affichage">
<div id="modifier_art_categ" style="padding-left:10px; padding-right:10px; height:100%">
	<form method="post" action="catalogues_clients_edition_avance_dir_mod.php" id="catalogues_clients_edition_avance_dir_mod" name="catalogues_clients_edition_avance_dir_mod" target="formFrame">
	<a href="#" style="float:right;" id="link_modifier_art_categ"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/supprime.gif" border="0"></a>
	<script type="text/javascript">
	Event.observe("link_modifier_art_categ", "click",  function(evt){Event.stop(evt); Element.toggle('modifier_art_categ');	Element.toggle('sup_art_categ');}, false);
	</script>
	<table class="minimizetable">
				<tr class="smallheight">
					<td class="size_strict"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
					<td><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
				</tr>	
		<tr>
			<td class="size_strict"><span class="labelled">Cat&eacute;gorie parent: </span>
			</td>
			<td>
			<input name="id_catalogue_client" id="id_catalogue_client" type="hidden" value="<?php echo $catalogue_client_dir->id_catalogue_client; ?>" />
			<input name="id_catalogue_client_dir" id="id_catalogue_client_dir" type="hidden" value="<?php echo $catalogue_client_dir->id_catalogue_client_dir; ?>" />
			<select name="id_catalogue_dir_parent" id="id_catalogue_dir_parent" class="classinput_lsize">
			<option value="">Racine</option>
			<?php
			foreach ($list_catalogue_dir  as $catalogue_dir){
				?>
				<option value="<?php echo ($catalogue_dir->id_catalogue_client_dir)?>" <?php if ($catalogue_dir->id_catalogue_client_dir==$catalogue_client_dir->id_catalogue_dir_parent) {echo 'selected="seleted"';}?>>
				<?php for ($i=0; $i<$catalogue_dir->indentation; $i++) {?>
					--
				<?php }?><?php echo htmlentities($catalogue_dir->lib_catalogue_client_dir)?>
				</option>
				<?php
			}
			?>
			</select>
			<a href="#" class="infobulle" onclick="return false;">
			<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/quest.gif" width="13" height="13" />
			<iframe frameborder="0" scrolling="no" src="about:_blank"></iframe>
			<span>
			<p class="infotext">Pour d&eacute;placer une cat&eacute;gorie et ses sous-cat&eacute;gories s&eacute;lectionnez la cat&eacute;gorie parent cible </p>
			</span></a></td>
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
					<option value="<?php echo ($s_art_categ->ref_art_categ)?>" <?php if ($s_art_categ->ref_art_categ == $catalogue_client_dir->ref_art_categ) {echo 'selected="seleted"';}?>>
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
			<input name="lib_catalogue_client_dir" id="lib_catalogue_client_dir" type="text" class="classinput_xsize" value="<?php echo htmlentities($catalogue_client_dir->lib_catalogue_client_dir); ?>" />
			</td>
		</tr>
	</table>
		<p style="text-align:center">
			<input type="image" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-valider.gif" name="bt_mob_art_categs" id="bt_mob_art_categs"/>
		</p>
	</form>
</div>

<div id="sup_art_categ" style="display:none; width:100%; height:100%;">
<div style="padding-left:10px; padding-right:10px; height:100%">
	<form method="post" action="catalogues_clients_edition_avance_dir_sup.php" id="catalogues_clients_edition_avance_dir_sup" name="catalogues_clients_edition_avance_dir_sup" target="formFrame" onsubmit="alerte.confirm_supprimer('catalogues_clients_edition_avance_dir_sup', 'catalogues_clients_edition_avance_dir_sup'); return false;">
	<table>
			<td colspan="2">
				<p style="text-align:center">Vous vous appr&eacute;tez &agrave; <strong>supprimer la cat&eacute;gorie d'articles <?php echo htmlentities($catalogue_client_dir->lib_catalogue_client_dir); ?></strong>
						<br />
				Avant de confirmer la suppression veuillez indiquer la cat&eacute;gorie qui recevra les sous-cat&eacute;gories de <?php echo htmlentities($catalogue_client_dir->lib_catalogue_client_dir); ?> lors de la supression de cette derni&egrave;re. </p>
				<p>D&eacute;placer les sous cat&eacute;gories de <?php echo htmlentities($catalogue_client_dir->lib_catalogue_client_dir); ?></p>
				</td>
		</tr>
	</table>
	<table>
		<tr class="smallheight">
			<td class="size_strict"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
			<td><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
		</tr>	
		<tr>
		<tr>
			<td class="size_strict"><span class="labelled">dans </span>
			</td>
			<td>
			<input name="id_catalogue_client" id="id_catalogue_client" type="hidden" value="<?php echo $catalogue_client_dir->id_catalogue_client; ?>" />
			<input name="id_catalogue_client_dir" id="id_catalogue_client_dir" type="hidden" value="<?php echo htmlentities($catalogue_client_dir->id_catalogue_client_dir); ?>" />
			<select name="id_catalogue_dir_parent" id="id_catalogue_dir_parent" class="classinput_lsize">
			<option value="">Racine</option>
			<?php
				foreach ($list_catalogue_dir  as $catalogue_dir){
			?>
			<option value="<?php echo ($catalogue_dir->id_catalogue_client_dir)?>" <?php if ($catalogue_dir->ref_art_categ==$catalogue_client_dir->id_catalogue_client_dir) {echo 'selected="seleted"';}?>>
			<?php for ($i=0; $i<$catalogue_dir->indentation; $i++) {?>
				--
			<?php }?><?php echo htmlentities($catalogue_dir->lib_catalogue_client_dir)?>
			</option>
			<?php
				}
			?>
			</select>
			<a href="#" class="infobulle" onclick="return false;">
			<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/quest.gif" width="13" height="13" />
			<iframe frameborder="0" scrolling="no" src="about:_blank"></iframe>
			<span>
			<p class="infotext">Pour d&eacute;placer les ses sous-cat&eacute;gories s&eacute;lectionnez la cat&eacute;gorie cible </p>
			</span></a></td>
		</tr>
	</table>
		<p style="text-align:center">
			<input type="submit" name="bt_sup_art_categs" id="bt_sup_art_categs" value="Confirmer la supression"/>
			<input type="reset" name="bt_stopsup_art_categs" id="bt_stopsup_art_categs" value="Annuler"  onclick="Element.toggle('modifier_art_categ');	Element.toggle('sup_art_categ');	"/>
		</p>
	</form>
</div>

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