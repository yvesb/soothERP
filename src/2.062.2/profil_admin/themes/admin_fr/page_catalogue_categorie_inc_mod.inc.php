<span class="sous_titre2">Modification la cat&eacute;gorie d'articles <strong><?php echo htmlentities($art_categ->getLib_art_categ()); ?></strong>
</span>

<script type="text/javascript" language="javascript">
array_menu_m_categ_art	=	new Array();
array_menu_m_categ_art[0] 	=	new Array('info_gene', 'menu_art_categ_5');
array_menu_m_categ_art[1] 	=	new Array('formule_tarif', 'menu_art_categ_6');
array_menu_m_categ_art[2] 	=	new Array('carateristique_categorie', 'menu_art_categ_3');
//array_menu_m_categ_art[3] 	=	new Array('caract_art_categ', 'menu_art_categ_4');
//array_menu_m_categ_art[4] 	=	new Array('tva_art_categ', 'menu_art_categ_1');
array_menu_m_categ_art[5] 	=	new Array('taxes_art_categ', 'menu_art_categ_2');
</script>

<div>
	<ul id="menu_art_categ" class="menu">
		<li><a href="#" id="menu_art_categ_5" class="menu_select">Général</a></li>
		<li><a href="#" id="menu_art_categ_3" class="menu_unselect">Caract&eacute;ristiques</a></li>
		<li><a href="#" id="menu_art_categ_6" class="menu_unselect">Tarifs</a></li>
		<!--<li><a href="#" id="menu_art_categ_4" class="menu_unselect">Caract&eacute;ristiques</a></li>-->
		<li><a href="#" id="menu_art_categ_2" class="menu_unselect">Taxes</a></li>
	</ul>
	<script type="text/javascript">
Event.observe("menu_art_categ_5", "click",  function(evt){Event.stop(evt); view_menu_1( 'info_gene', 'menu_art_categ_5', array_menu_m_categ_art); set_tomax_height('info_gene' , -55);}, false);

Event.observe("menu_art_categ_6", "click",  function(evt){Event.stop(evt); view_menu_1( 'formule_tarif', 'menu_art_categ_6', array_menu_m_categ_art); set_tomax_height('formule_tarif' , -55);}, false);

Event.observe("menu_art_categ_3", "click",  function(evt){Event.stop(evt); view_menu_1( 'carateristique_categorie', 'menu_art_categ_3', array_menu_m_categ_art); set_tomax_height('carateristique_categorie' , -55);}, false);

//Event.observe("menu_art_categ_4", "click",  function(evt){Event.stop(evt); view_menu_1( 'caract_art_categ', 'menu_art_categ_4', array_menu_m_categ_art); set_tomax_height('caract_art_categ' , -55);}, false);

Event.observe("menu_art_categ_2", "click",  function(evt){Event.stop(evt); view_menu_1( 'taxes_art_categ', 'menu_art_categ_2', array_menu_m_categ_art); set_tomax_height('taxes_art_categ' , -55);}, false);
</script>
</div>
<div id="specontent_art_categ" class="contactview_corps">

<div id="formule_tarif" style="overflow:auto; display:none; width:100%; height:100%;"  class="menu_link_affichage">

<?php include $DIR.$_SESSION['theme']->getDir_theme()."page_catalogue_categorie_tarifs.inc.php" ?>
</div>

<div id="info_gene" style="overflow:auto; width:100%; height:100%;"  class="menu_link_affichage">
<div id="modifier_art_categ" style="padding-left:10px; padding-right:10px; height:100%">
	<form method="post" action="catalogue_categorie_mod.php" id="catalogue_modif_categs" name="catalogue_modif_categs" target="formFrame">
	<a href="#" style="float:right;<?php if ($art_categ->getId_modele_spe ()) {echo " display:none;";} ?>" id="link_modifier_art_categ"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/supprime.gif" border="0"></a>
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
			<input name="ref_art_categ" id="ref_art_categ" type="hidden" value="<?php echo $art_categ->getRef_art_categ(); ?>" />
			
			<select name="ref_art_categ_parent" id="ref_art_categ_parent" class="classinput_lsize" <?php if ($art_categ->getId_modele_spe ()) {echo "style='display:none;'";} ?>>
			<option value="">Racine</option>
			<?php
				$lib_art_categ_select = "";
				$select_art_categ =	get_articles_categories($art_categ->getRef_art_categ());
				foreach ($select_art_categ  as $s_art_categ){
			?>
			<option value="<?php echo ($s_art_categ->ref_art_categ)?>" <?php if ($s_art_categ->ref_art_categ==$art_categ->getRef_art_categ_parent()) {echo 'selected="seleted"'; $lib_art_categ_select = $s_art_categ->lib_art_categ;}?>>
			<?php for ($i=0; $i<$s_art_categ->indentation; $i++) {?>
				--
			<?php }?><?php echo htmlentities($s_art_categ->lib_art_categ)?>
			</option>
			<?php
				}
			?>
			</select>
			<?php if ($art_categ->getId_modele_spe ()) {echo $lib_art_categ_select;} ?>
			<a href="#" class="infobulle" onclick="return false;">
			<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/quest.gif" width="13" height="13" />
			<iframe frameborder="0" scrolling="no" src="about:_blank"></iframe>
			<span>
			<p class="infotext">Pour d&eacute;placer une cat&eacute;gorie et ses sous-cat&eacute;gories s&eacute;lectionnez la cat&eacute;gorie parent cible </p>
			</span></a></td>
		</tr>
		<tr>
			<td class="size_strict"><span class="labelled">Libell&eacute;:</span>
			</td>
			<td>
			<input name="lib_art_categ" id="lib_art_categ" type="text" class="classinput_xsize" value="<?php echo htmlentities($art_categ->getLib_art_categ()); ?>" />
			</td>
		</tr>
		<tr>
			<td class="size_strict"><span class="labelled">Mod&eacute;le:</span>
			</td>
			<td>
			<select name="modele" id="modele" class="classinput_xsize" <?php if ($art_categ->getId_modele_spe ()) {echo "style='display:none;'";} ?>>
			<?php
			$modele_select = "";
			foreach ($BDD_MODELES as $cle_list_modele=>$list_modele) {?>
			<option value="<?php echo htmlentities($cle_list_modele)?>" <?php 
			if ($art_categ->getModele ()==$cle_list_modele) {echo 'selected="selected"'; $modele_select = $list_modele;} ?>><?php echo htmlentities($list_modele)?></option>
			<?php }?>
			</select>
			<?php if ($art_categ->getId_modele_spe ()) {echo $modele_select;} ?>
			</td>
		</tr>
		<tr>
			<td class="size_strict">
			</td>
			<td>
			<?php 
			if ($art_categ->getId_modele_spe ()) {echo $art_categ->getLib_modele_spe ();} ?>
			</td>
		</tr>
		<tr>
			<td class="size_strict"><span class="labelled">Description:</span>
			</td>
			<td>
			<textarea name="desc_art_categ" rows="5" class="classinput_xsize" id="desc_art_categ" type="text"><?php echo ($art_categ->getDesc_art_categ()); ?></textarea>
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
					if ($art_categ->getDefaut_id_tva()==$tva['id_tva']) {echo ' selected="selected"';};
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
								if (floor($art_categ->getDuree_dispo()/ (365*24*3600)) == $i) {echo ' selected="selected"';}
						?>>
						<?php echo $i;?></option>
						<?php 
					}
								$reste = $art_categ->getDuree_dispo()- (floor($art_categ->getDuree_dispo()/ (365*24*3600))*(365*24*3600));
					?> 
				</select> an(s) <?php ?>
				<select name="duree_dispo_mois" id="duree_dispo_mois"  class="classinput_nsize" >
					<?php
					$i = 0;
					for ($i = 0; $i<=12; $i++){
						?>
						<option value="<?php echo $i;?>" <?php
								if (floor($reste/ (30*24*3600)) == $i) {echo ' selected="selected"';}
						?>><?php echo $i;?></option>
						<?php 
					}
					$reste = $reste - (floor($reste/ (30*24*3600)) * (30*24*3600));
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
					<option value="aucune" <?php if(!($art_categ->isRestrict_to_achats() || $art_categ->isRestrict_to_ventes())){ echo "selected='selected'";}?> >
						Aucune Restriction
					</option>
					<option value="achat" <?php if($art_categ->isRestrict_to_achats() ){ echo "selected='selected'";}?> >
						Restreindre à l'achat
					</option>
					<option value="vente"  <?php if($art_categ->isRestrict_to_ventes() ){ echo "selected='selected'";}?> >
						Restreindre à la vente
					</option>
				</select>

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
	<form method="post" action="catalogue_categorie_sup.php" id="catalogue_supprim_categs" name="catalogue_supprim_categs" target="formFrame" onsubmit="alerte.confirm_supprimer('catalogue_supprim_categs', 'catalogue_supprim_categs'); return false;">
	<table>
			<td colspan="2">
				<p style="text-align:left">Vous avez demandé <strong> la suppression de la catégorie d'articles "<?php echo ($art_categ->getLib_art_categ()); ?>"</strong>
				<br />
				Vous devez stipuler la catégorie d'articles de remplacement pour : <br />
				- Les sous-catégories de "<?php echo ($art_categ->getLib_art_categ()); ?>"<br />
				- Les articles (y compris les articles archivés) de cette catégorie
				</p>
			</td>
		</tr>
	</table>
	<table>
		<tr class="smallheight">
			<td ><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
			<td><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
		</tr>	
		<tr>
		<tr>
			<td ><span class="labelled_extend">Catégorie de remplacement: </span>
			</td>
			<td>
			<input name="ref_art_categ" id="ref_art_categ" type="hidden" value="<?php echo htmlentities($art_categ->getRef_art_categ()); ?>" />
			<select name="ref_art_categ_parent" id="ref_art_categ_parent" class="classinput_lsize">
			
			
			<?php
				$select_art_categ =	get_articles_categories($art_categ->getRef_art_categ());
				foreach ($select_art_categ  as $s_art_categ){
					?>
					<option value="<?php echo ($s_art_categ->ref_art_categ)?>" <?php if ($s_art_categ->ref_art_categ==$art_categ->getRef_art_categ_parent()) {echo 'selected="seleted"';}?>>
					<?php
						for ($i=0; $i<$s_art_categ->indentation; $i++) {?>
						--
						<?php 
						}
					?><?php echo htmlentities($s_art_categ->lib_art_categ)?>
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








<!--<div id="tva_art_categ" class="menu_link_affichage" style="overflow:auto; display:none; width:100%; height:100%;">
<div style="padding-left:10px; padding-right:10px; height:100%">
<form action="catalogue_categorie_tvas_addordel.php" method="post" target="formFrame">
<input name="ref_art_categ" id="ref_art_categ" type="hidden" value="<?php // echo $art_categ->getRef_art_categ(); ?>" style="padding:15px;" />
<select name="tva_id_pays" id="tva_id_pays" >
<?php // liste des pays ayant des tva
//		foreach ($tvas_pays  as $tva_pays){
?>
	<option value="<?php // echo $tva_pays["id_pays"];?>" <?php // if ($tva_pays["id_pays"]==$DEFAUT_ID_PAYS){echo 'selected="selected"';}?>><?php // echo htmlentities($tva_pays["pays"]);?></option>
<?php 
//		}
?>
</select>
<div id="tvas_list_content">
	<?php // include $DIR.$_SESSION['theme']->getDir_theme()."page_catalogue_categorie_tvas_list.inc.php" ?>
</div>
</form>
<script type="text/javascript">
// Event.observe('tva_id_pays', 'change',  function(){page.traitecontent('categ_tvas_list_content','catalogue_categorie_tvas_list.php?ref_art_categs=<?php // echo $art_categ->getRef_art_categ(); ?>&id_pays='+$('tva_id_pays').value,true,'tvas_list_content');}, false);
</script>
</div>
</div>-->



<div id="taxes_art_categ" style="display:none;overflow:auto; width:100%; height:100%;" class="menu_link_affichage">
<div style="padding-left:10px; padding-right:10px; height:100%"><br />

<span class="bolder">Taxes</span>
<form action="catalogue_categorie_taxes_addordel.php" method="post" target="formFrame">
<input name="ref_art_categ" id="ref_art_categ" type="hidden" value="<?php echo $art_categ->getRef_art_categ(); ?>" />
<!--<select name="taxe_id_pays" id="taxe_id_pays" >
<?php
// liste des pays ayant des tva
//		foreach ($taxes_pays  as $taxe_pays){
?>
	<option value="<?php //echo $taxe_pays["id_pays"];?>" <?php //if ($taxe_pays["id_pays"]==$DEFAUT_ID_PAYS){echo 'selected="selected"';}?>><?php //echo htmlentities($taxe_pays["pays"]);?></option>
<?php 
//		}
?>
</select>-->
<br />
<input type="hidden" name="taxe_id_pays" id="taxe_id_pays" value="<?php if (isset($taxes['0']["id_pays"])) {echo htmlentities($taxes['0']["id_pays"]);} ?>" />
<p style="font-weight:bolder"><?php if (isset($taxes['0']["pays"])) {echo htmlentities($taxes['0']["pays"]);} ?></p>
<div id="taxes_list_content">
<?php 
if (isset($taxes['0']["id_pays"])) {
	?>
	<?php include $DIR.$_SESSION['theme']->getDir_theme()."page_catalogue_categorie_taxes_list.inc.php" ?>
	<?php 
}
?>
</div>
</form>
<script type="text/javascript">
//Event.observe('taxe_id_pays', 'change',  function(){page.traitecontent('categ_taxes_list_content','catalogue_categorie_taxes_list.php?ref_art_categs=<?php echo $art_categ->getRef_art_categ(); ?>&id_pays='+$('taxe_id_pays').value,true,'taxes_list_content');}, false);
</script>
</div>
</div>







<div id="carateristique_categorie"  style="display:none; overflow:auto; width:100%; height:100%;" class="menu_link_affichage">
<div id="grp_caract_art_categ"> 
	<?php include $DIR.$_SESSION['theme']->getDir_theme()."page_catalogue_categorie_grpcaract.inc.php" ?>
</div>

<div id="caract_art_categ" >
	<?php include $DIR.$_SESSION['theme']->getDir_theme()."page_catalogue_categorie_caract.inc.php" ?>
</div>
</div>


<SCRIPT type="text/javascript">

function setheight_catalogue_categorie_inc_mod(){
set_tomax_height("specontent_art_categ" , -55);
set_tomax_height("info_gene" , -55);
//set_tomax_height("tva_art_categ" , -55);
set_tomax_height("taxes_art_categ" , -55);
set_tomax_height("formule_tarif" , -55);
set_tomax_height("carateristique_categorie" , -55);
}
Event.observe(window, "resize", setheight_catalogue_categorie_inc_mod, false);
setheight_catalogue_categorie_inc_mod();

//on masque le chargement
H_loading();
</SCRIPT>
</div>
