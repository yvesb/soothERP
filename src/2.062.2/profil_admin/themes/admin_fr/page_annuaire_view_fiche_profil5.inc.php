
<div class="profil_reduce">
<form method="post" action="annuaire_edition_profil_suppression.php" id="annu_edition_profil5_suppression" name="annu_edition_profil5_suppression" target="formFrame">
<input type="hidden" name="ref_contact" value="<?php echo $contact->getRef_contact()?>">
<input type="hidden" name="id_profil" value="<?php echo $id_profil?>">
</form>
<p class="sous_titre1">Informations fournisseur </p>
<div class="reduce_in_edit_mode">
<form method="post" action="annuaire_edition_profil.php" id="annu_edition_profil5" name="annu_edition_profil5" target="formFrame" style="display:none;">
<input type="hidden" name="ref_contact" value="<?php echo $contact->getRef_contact()?>">
<input type="hidden" name="id_profil" value="<?php echo $id_profil?>">
	<table class="minimizetable">
		<tr class="smallheight">
			<td class="size_strict"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
			<td><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
		</tr>	
		<tr>
			<td class="size_strict"><span class="labelled_ralonger">Cat&eacute;gorie de fournisseur:</span>
			</td>
			<td>
				<select  id="id_fournisseur_categ"  name="id_fournisseur_categ" class="classinput_xsize">
				<?php
				foreach ($liste_categories_fournisseur as $liste_categorie_fournisseur){
					?>
					<option value="<?php echo $liste_categorie_fournisseur->id_fournisseur_categ;?>" <?php if ($profils[$id_profil]->getId_fournisseur_categ () == $liste_categorie_fournisseur->id_fournisseur_categ) {echo 'selected="selected"'; $id_fournisseur_categ =  htmlentities($liste_categorie_fournisseur->id_fournisseur_categ);}?>>
					<?php echo htmlentities($liste_categorie_fournisseur->lib_fournisseur_categ)?></option>
					<?php 
				}?>
				</select>
			</td>
		</tr>
		<tr>
			<td class="size_strict"><span class="labelled_ralonger">Identifiant client:</span>
			</td>
			<td>
				<input name="code_client" id="code_client" type="text" class="classinput_xsize" value="<?php echo htmlentities($profils[$id_profil]->getCode_client ()) ?>" />
				</td>
		</tr>
		<tr>
			<td class="size_strict"><span class="labelled_ralonger">Conditions commerciales:</span>
			</td>
			<td>
				<textarea name="conditions_commerciales" id="conditions_commerciales" class="classinput_xsize"><?php echo htmlentities($profils[$id_profil]->getConditions_commerciales ()) ?></textarea>
			</td>
		</tr>
		<tr>
			<td class="size_strict"><span class="labelled_ralonger">Adresse d'exp&eacute;dition des marchandises:</span>
			</td>
			<td>
			<select  id="id_stock_livraison"  name="id_stock_livraison" class="classinput_xsize">
				<?php
				$lib_stock = "";
				foreach ($stocks_liste as $stock_liste){
					?>
					<option value="<?php echo $stock_liste->getId_stock();?>" <?php if ($stock_liste->getId_stock() == $profils[$id_profil]->getId_stock_livraison ()) { echo 'selected="selected"'; $lib_stock = htmlentities($stock_liste->getLib_stock());}?>>
					<?php echo htmlentities($stock_liste->getLib_stock()); ?></option>
					<?php 
				}
				?>
			</select>
			</td>
		</tr>
		<tr>
			<td class="size_strict">
			<span class="labelled_ralonger">Afficher Tarifs:</span>
			</td><td>
			<select id="app_tarifs" name="app_tarifs" class="classinput_xsize">
				<option value="">Automatique</option>
				<option value="HT" <?php if ($profils[$id_profil]->getApp_tarifs () == "HT") {echo 'selected="selected"';}?>>HT</option>
				<option value="TTC" <?php if ($profils[$id_profil]->getApp_tarifs () == "TTC") {echo 'selected="selected"';}?>>TTC</option>
				</select>
			</td>
		</tr>
		<tr>
			<td class="size_strict"><span class="labelled_ralonger">D&eacute;lai de livraison:</span>
			</td><td>
			<input name="delai_livraison" id="delai_livraison" type="text" class="classinput_xsize" value="<?php echo htmlentities($profils[$id_profil]->getDelai_livraison ()) ?>" />
			</td>
		</tr>
	</table>
	<p style="text-align:center">
<input type="image" name="profsubmit<?php echo $id_profil?>" id="profsubmit<?php echo $id_profil?>"  src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-valider.gif"/>
</p>
	</form>
	
	<table class="minimizetable"  id="start_visible_profil<?php echo $id_profil?>">
		<tr class="smallheight">
			<td class="size_strict"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
			<td><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
		</tr>	
		<tr>
			<td class="size_strict"><span class="labelled_ralonger">Cat&eacute;gorie de fournisseur :</span>
			</td>
			<td>
			<a href="#" id="show5_id_fournisseur_categ" class="modif_select1">
			<?php
			foreach ($liste_categories_fournisseur as $liste_categorie_fournisseur){
				if ($profils[$id_profil]->getId_fournisseur_categ () == $liste_categorie_fournisseur->id_fournisseur_categ) {?>
				<?php echo htmlentities($liste_categorie_fournisseur->lib_fournisseur_categ)?>
				<?php 
				}
			}
			?>
			</a>
			</td>
		</tr>
		<tr>
			<td class="size_strict"><span class="labelled_ralonger">Identifiant client:</span>
			</td>
			<td>
			<a href="#" id="show5_code_client" class="modif_input1">
			<?php echo  htmlentities($profils[$id_profil]->getCode_client ())?></a>
			</td>
		</tr>
		<tr>
			<td class="size_strict"><span class="labelled_ralonger">Conditions commerciales:</span>
			</td>
			<td>
			<a href="#" id="show5_conditions_commerciales" class="modif_input1"><?php echo  nl2br(htmlentities($profils[$id_profil]->getConditions_commerciales ()))?></a>
			</td>
		</tr>
		<tr>
			<td class="size_strict"><span class="labelled_ralonger">Adresse d'exp&eacute;dition des marchandises::</span>
			</td>
			<td>
			<a href="#" id="show5_lib_stock" class="modif_input1"><?php echo  $lib_stock;?></a>
			</td>
		</tr>
		<tr>
			<td class="size_strict"><span class="labelled_ralonger">Tarifs:</span>
			</td>
			<td>
			<a href="#" id="show5_app_tarifs" class="modif_input1"><?php echo  htmlentities($profils[$id_profil]->getApp_tarifs ())?></a>
			</td>
		</tr>
		<tr>
			<td class="size_strict"><span class="labelled_ralonger">D&eacute;lai de livraison:</span>
			</td>
			<td>
			<a href="#" id="show5_delai_livraison" class="modif_input1"><?php echo  htmlentities($profils[$id_profil]->getDelai_livraison ())?></a>
			</td>
		</tr>
		<tr>
			<td colspan="2" style="text-align:center">
			 <img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-modifier.gif" style="cursor:pointer" id="modifier_profil<?php echo $id_profil?>" />
			</td>
		</tr>
	</table>

<script type="text/javascript" language="javascript">

Event.observe("modifier_profil<?php echo $id_profil?>", "click",  function(evt){
	Event.stop(evt); 
	$('annu_edition_profil<?php echo $id_profil?>').toggle();
	$('start_visible_profil<?php echo $id_profil?>').toggle();
}, false);


Event.observe("show5_delai_livraison", "click",  function(evt){Event.stop(evt); show_edit_form('annu_edition_profil<?php echo $id_profil?>', 'start_visible_profil<?php echo $id_profil?>','delai_livraison');}, false);

Event.observe("show5_lib_stock", "click",  function(evt){Event.stop(evt); show_edit_form('annu_edition_profil<?php echo $id_profil?>', 'start_visible_profil<?php echo $id_profil?>','conditions_commerciales');}, false);

Event.observe("show5_conditions_commerciales", "click",  function(evt){Event.stop(evt); show_edit_form('annu_edition_profil<?php echo $id_profil?>', 'start_visible_profil<?php echo $id_profil?>','conditions_commerciales');}, false);

Event.observe("show5_code_client", "click",  function(evt){Event.stop(evt); show_edit_form('annu_edition_profil<?php echo $id_profil?>', 'start_visible_profil<?php echo $id_profil?>','code_client');}, false);

Event.observe("show5_app_tarifs", "click",  function(evt){Event.stop(evt); show_edit_form('annu_edition_profil<?php echo $id_profil?>', 'start_visible_profil<?php echo $id_profil?>','app_tarifs');}, false);

Event.observe("show5_id_fournisseur_categ", "click",  function(evt){Event.stop(evt); show_edit_form('annu_edition_profil<?php echo $id_profil?>', 'start_visible_profil<?php echo $id_profil?>','id_fournisseur_categ');}, false);

new Form.EventObserver('annu_edition_profil<?php echo $id_profil?>', function(element, value){formChanged();});

//affichage de la liste des boutons des documents fournisseurs
$("liste_document_fournisseur").show();

//on masque le chargement
H_loading();

</script>
</div>
</div>
