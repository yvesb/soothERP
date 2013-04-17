<?php

// *************************************************************************************************************
// CONFIG DES DONNEES du catalogue
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
tableau_smenu[0] = Array("smenu_catalogue", "smenu_catalogue.php" ,"true" ,"sub_content", "Catalogue");
tableau_smenu[1] = Array('configuration_catalogue','configuration_catalogue.php' ,"true" ,"sub_content", "Paramètres généraux du catalogue");
update_menu_arbo();
</script>
<div class="emarge">
<p class="titre">Paramètres généraux du catalogue </p>

<div class="contactview_corps">
<form action="configuration_catalogue_maj.php" enctype="multipart/form-data" method="POST"  id="configuration_catalogue_maj" name="configuration_catalogue_maj" target="formFrame" >

<table width="100%">
	<tr class="smallheight">
		<td style="width:35%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
		<td style="width:30%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
		<td style="width:35%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
	</tr>
	<tr>
		<td class="titre_config" colspan="3">D&eacute;finition des articles: </td>
	</tr>
	<tr>
		<td colspan="3"> </td>
	</tr>
	<tr>
		<td class="lib_config">Gestion des Stocks </td>
		<td>
		<input id="gestion_stock" name="gestion_stock" value="1" type="checkbox" <?php if ($GESTION_STOCK) { ?>checked="checked"<?php } ?> />
		</td>
		<td class="infos_config">les stocks sont-ils gérés? </td>
	</tr>
	<tr>
		<td colspan="3"> </td>
	</tr>
	<tr>
		<td colspan="3"> </td>
	</tr>
	<tr>
		<td class="lib_config">Gestion des identifiant de traçabilité: </td>
		<td>
		<input id="gestion_sn" name="gestion_sn" value="1" type="checkbox" <?php if ($GESTION_SN) { ?>checked="checked"<?php } ?> />
		</td>
		<td class="infos_config">les articles du type mat&eacute;riel g&egrave;rent les num&eacute;ros de s&eacute;rie ou de lot </td>
	</tr>
	<tr>
		<td colspan="3"> </td>
	</tr>
	<tr>
		<td class="lib_config">Gestion des constructeurs</td>
		<td>
		<input id="gestion_constructeur" name="gestion_constructeur" value="1" type="checkbox" <?php if ($GESTION_CONSTRUCTEUR) { ?>checked="checked"<?php } ?> />
		</td>
		<td class="infos_config">les articles peuvent se voir attribuer un constructeur ainsi qu'une r&eacute;f&eacute;rence constructeur </td>
	</tr>
	<tr>
		<td colspan="3"> </td>
	</tr>
	<tr>
		<td class="lib_config">Gestion des r&eacute;f&eacute;rences internes </td>
		<td>
		<input id="gestion_ref_interne" name="gestion_ref_interne" value="1" type="checkbox" <?php if ($GESTION_REF_INTERNE) { ?>checked="checked"<?php } ?> />
		</td>
		<td class="infos_config">les articles peuvent se voir attribuer une r&eacute;f&eacute;rence d'article autre que celle cr&eacute;&eacute;e par le logiciel </td>
	</tr>
	<tr>
		<td colspan="3"> </td>
	</tr>
	<tr>
		<td class="lib_config">Afficher heures et minutes des abonnements </td>
		<td>
		<input id="article_abo_time" name="article_abo_time" value="1" type="checkbox" <?php if ($ARTICLE_ABO_TIME) { ?>checked="checked"<?php } ?> />
		</td>
		<td class="infos_config">les articles services par abonnement utilisent les heures et les minutes dans leur gestion</td>
	</tr>
		<tr>
	<td colspan="3"> </td>
	</tr>
	<tr>
		<td class="lib_config">Nombre de décimale pour la quantité d'une article : </td>
		<td>
			<input id="article_qte_nb_dec" name="article_qte_nb_dec" value="<?php echo  $ARTICLE_QTE_NB_DEC; ?>" type="text" class="classinput_hsize" maxlength="70" /> 
		</td>
		<td class="infos_config"></td>
	</tr>
	<tr>
	<tr>
		<td colspan="3"> </td>
	</tr>
	<tr>
		<td class="titre_config" colspan="3">Valeurs &agrave; la cr&eacute;ation des articles: </td>
	</tr>
	<tr>
		<td colspan="3"> </td>
	</tr>
	<tr>
		<td class="lib_config">Durée de garantie des articles par d&eacute;faut </td>
		<td>
		<input id="defaut_garantie" name="defaut_garantie" value="<?php echo  $DEFAUT_GARANTIE; ?>" type="text" class="classinput_hsize" maxlength="70" /> 
		 mois</td>
		<td class="infos_config">valeur modifiable pour chaque article </td>
	</tr>
	<tr>
		<td colspan="3"> </td>
	</tr>
	<tr>
		<td class="lib_config">Durée de vie des articles</td>
		<td>
		<input id="defaut_article_lt" name="defaut_article_lt" value="<?php echo  $DEFAUT_ARTICLE_LT/(24*3600); ?>" type="text" class="classinput_hsize" maxlength="70" /> 
		 jours</td>
		<td class="infos_config">valeur modifiable pour chaque article </td>
	</tr>
	<tr>
		<td colspan="3"> </td>
	</tr>
	<tr>
		<td class="lib_config">Mode de valorisation des articles</td>
		<td>
		<select name="defaut_id_valo" id="defaut_id_valo" class="classinput_hsize">
				<?php 
				$prev_grp = "";
				foreach (get_valorisations() as $valorisation) {
					if ($valorisation->groupe != $prev_grp) {
						?>
						<optgroup disabled="disabled" label="<?php echo $valorisation->groupe;?>"></optgroup>
						<?php 
						$prev_grp = $valorisation->groupe;
					}
					?>
					<option value="<?php echo $valorisation->id_valo;?>" <?php 
				if ($DEFAUT_ID_VALO == $valorisation->id_valo) {echo 'selected="selected"';} ?>><?php echo $valorisation->lib_valo;?></option>
					<?php 
				}
				?>
			</select>
		 </td>
		<td class="infos_config">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="3"> </td>
	</tr>
	<tr>
		<td class="lib_config">Valeur de la valorisation</td>
		<td>
		<input id="defaut_indice_valorisation" name="defaut_indice_valorisation" value="<?php echo  $DEFAUT_INDICE_VALORISATION; ?>" type="text" class="classinput_hsize" maxlength="70" /> 
		 </td>
		<td class="infos_config">valeur modifiable pour chaque article </td>
	</tr>
	<tr>
		<td colspan="3"> </td>
	</tr>
	<tr>
		<td class="lib_config">L'article g&egrave;re les identifiants de traçabilité:</td>
		<td>
		
		<select name="defaut_gestion_sn" id="defaut_gestion_sn" class="classinput_hsize">
					<option value="0" <?php if ($DEFAUT_GESTION_SN == 0) {echo 'selected="selected"';} ?>>Aucun</option>
					<option value="1" <?php if ($DEFAUT_GESTION_SN == 1) {echo 'selected="selected"';} ?>>Numéro de s&eacute;rie</option>
					<option value="2" <?php if ($DEFAUT_GESTION_SN == 2) {echo 'selected="selected"';} ?>>Numéro de lot</option>
			</select>
		
		</td>
		<td class="infos_config">&agrave; la cr&eacute;ation de l'article, la gestion des num&eacute;ros de s&eacute;rie ou de numéros de lots est active ou non ? </td>
	</tr>
	<tr>
		<td colspan="3"> </td>
	</tr>
	<tr>
		<td class="lib_config">L'article g&egrave;re les lots </td>
		<td>
		<select name="defaut_lot" id="defaut_lot" class="classinput_hsize">
			<option value="0" <?php if ($DEFAUT_LOT == 0) { ?> selected="selected"<?php } ?>>Article simple</option>
			<option value="1" <?php if ($DEFAUT_LOT == 1) { ?> selected="selected"<?php } ?>>Article à fabriquer</option>
			<option value="2" <?php if ($DEFAUT_LOT == 2) { ?> selected="selected"<?php } ?>>Composition Interne</option>
			<option value="3" <?php if ($DEFAUT_LOT == 3) { ?> selected="selected"<?php } ?>>Composition Fabriquant</option>
		</select>
		</td>
		<td class="infos_config">&agrave; la cr&eacute;ation de l'article, la gestion des lots est active ou non ? </td>
	</tr>
	<tr>
		<td colspan="3"> </td>
	</tr>
	<tr>
		<td class="lib_config">Taux de TVA par d&eacute;faut </td>
		<td>
		<?php if (!$ASSUJETTI_TVA) {?>
			TVA non applicable par defaut.
			<input name="defaut_id_tva" id="defaut_id_tva" type="hidden" value="0">
		<?php } else { ?>
		
			<select name="defaut_id_tva" id="defaut_id_tva"  class="classinput_hsize">
				<option value="0">T.V.A. non applicable</option>
				<?php
				//liste des TVA par pays
				foreach ($tvas  as $tva){
					?>
					<option value="<?php echo $tva['id_tva'];?>" <?php
							if ($DEFAUT_ID_TVA==$tva['id_tva']) {echo ' selected="selected"'; };
					?>>
					<?php echo htmlentities($tva['tva']);?>%</option>
					<?php 
				}
				?>
			</select>
		<?php }  ?>
		</td>
		<td class="infos_config">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="3"> </td>
	</tr>
	<tr>
		<td class="lib_config">Les articles sont &quot;nouveaux&quot; durant</td>
		<td>
		<input id="delai_article_is_new" name="delai_article_is_new" value="<?php echo  $DELAI_ARTICLE_IS_NEW/(24*3600); ?>" type="text" class="classinput_hsize" maxlength="70" /> 
		 jours
		 </td>
		<td class="infos_config">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="3"> </td>
	</tr>
	<tr>
		<td class="lib_config">Largeur maximale des miniatures d'images d'articles </td>
		<td>
		<input id="article_image_miniature_ratio" name="article_image_miniature_ratio" value="<?php echo  $ARTICLE_IMAGE_MINIATURE_RATIO; ?>" type="text" class="classinput_hsize" maxlength="70" /> 
		 pixels (points &eacute;cran)
		 </td>
		<td class="infos_config">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="3"> </td>
	</tr>
	<tr>
		<td class="lib_config">Comment nommer les variantes d'articles?</td>
		<td>
		<select name="article_variante_nom" id="article_variante_nom" class="classinput_xsize">
				<option value="1" <?php if ($ARTICLE_VARIANTE_NOM==1) {echo 'selected="selected"';} ?>>Valeurs des caractéristiques dans le libellé (Teeshirt Rouge 34)</option>
				<option value="2" <?php if ($ARTICLE_VARIANTE_NOM==2) {echo 'selected="selected"';} ?>>Caractéristique et valeurs dans le libellé (Teeshirt Couleur Rouge, Taille 34)</option>
				<option value="3" <?php if ($ARTICLE_VARIANTE_NOM==3) {echo 'selected="selected"';} ?>>Caractéristique et valeurs dans la description courte</option>
			</select>
		 </td>
		<td class="infos_config">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="3"> </td>
	</tr>
</table>
<p style="text-align:center">
	<input name="valider" id="valider" type="image" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-valider.gif" />
</p>
</form>

<table width="100%">
	<tr class="smallheight">
		<td style="width:35%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
		<td style="width:20%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
		<td style="width:35%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
	</tr>
	<tr>
		<td class="titre_config" colspan="3">Types de liaisons d'articles: </td>
	</tr>
	<tr>
		<td colspan="3"> </td>
	</tr>
</table>

<table class="minimizetable">
<tr>
<td >
			<div id="liaison" style="padding-left:10px; padding-right:10px;">
		
			<p>Liste des liaisons </p>
		
					<table>
				<tr>
					<td>
						<table>
							<tr class="smallheight">
								<td style="width:53%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
								<td style="width:35%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
								<td style="width:13%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
							</tr>	
							<tr>
								<td><span class="labelled">Libell&eacute;:</span>
								</td>
						
								<td><span class="labelled">Actif:</span>
								</td>
								<td>
								</td>
							</tr>
						</table>
					</td>
					<td style="width:12px">
						
					</td>
				</tr>
			</table>
			<?php 
			
			$fleches_ascenseur=0;
			foreach ($liaisons_liste as $liaison_liste) {
			?>
			<div class="caract_table" id="liaison_table_<?php echo $liaison_liste->id_liaison_type; ?>">
		
				<table>
				<tr>
					<td>
						<form action="catalogue_liaisons_mod.php" method="post" id="catalogue_liaisons_mod_<?php echo $liaison_liste->id_liaison_type; ?>" name="catalogue_liaisons_mod_<?php echo $liaison_liste->id_liaison_type; ?>" target="formFrame" >
						<table>
							<tr class="smallheight">
								<td style="width:55%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
								<td style="width:35%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
								<td style="width:10%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
							</tr>	
							<tr>
								<td><?php echo htmlentities($liaison_liste->lib_liaison_type); ?>
					<input name="id_liaison_type" id="id_liaison_type" type="hidden" value="<?php echo $liaison_liste->id_liaison_type; ?>" />
					<input name="systeme_<?php echo $liaison_liste->id_liaison_type; ?>" id="systeme_<?php echo $liaison_liste->id_liaison_type; ?>" type="hidden" value="<?php echo $liaison_liste->systeme; ?>" />
								</td>
								<td>
								<input id="actif_<?php echo $liaison_liste->id_liaison_type; ?>" name="actif_<?php echo $liaison_liste->id_liaison_type; ?>" value="<?php echo htmlentities($liaison_liste->actif); ?>" type="checkbox"  <?php if($liaison_liste->actif==1){echo 'checked="checked"';}?>  <?php if($liaison_liste->systeme==1){echo 'disabled="disabled"';}?>/>
								</td>
								<td>
									<p style="text-align:right">
										
									</p>
								</td>
							</tr>
						</table>
						</form>
					</td>
					<td style="width:12px">
						<table cellspacing="0">
							<tr>
								<td>
									<div id="up_arrow_<?php echo $liaison_liste->id_liaison_type; ?>">
									<?php
									if ($fleches_ascenseur!=0) {
									?>
									<form action="catalogue_liaisons_ordre.php" method="post" id="catalogue_liaisons_ordre_<?php echo $liaison_liste->id_liaison_type; ?>" name="catalogue_liaisons_ordre_<?php echo $liaison_liste->id_liaison_type; ?>" target="formFrame">
		
										<input name="ordre" id="ordre" type="hidden" value="<?php echo ($liaisons_liste[$fleches_ascenseur-1]->ordre)?>" />
										<input name="ordre_other" id="ordre_other" type="hidden" value="<?php echo ($liaison_liste->ordre)?>" />
										<input name="modifier_ordre_<?php echo $liaison_liste->id_liaison_type; ?>" id="modifier_ordre_<?php echo $liaison_liste->id_liaison_type; ?>" type="image" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/up.gif">
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
								<div id="down_arrow_<?php echo $liaison_liste->id_liaison_type; ?>">
									<?php
									if ($fleches_ascenseur!=count($liaisons_liste)-1) {
									?>
									<form action="catalogue_liaisons_ordre.php" method="post" id="catalogue_liaisons_ordre_<?php echo $liaison_liste->id_liaison_type; ?>" name="catalogue_liaisons_ordre_<?php echo $liaison_liste->id_liaison_type; ?>" target="formFrame">
		
										<input name="ordre" id="ordre" type="hidden" value="<?php echo ($liaisons_liste[$fleches_ascenseur+1]->ordre)?>" />
										<input name="ordre_other" id="ordre_other" type="hidden" value="<?php echo ($liaison_liste->ordre)?>" />								
										<input name="modifier_ordre_<?php echo $liaison_liste->id_liaison_type; ?>" id="modifier_ordre_<?php echo $liaison_liste->id_liaison_type; ?>" type="image" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/down.gif">
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
		</td>
		</tr>
		</table>

</div>
</div>
<SCRIPT type="text/javascript">

<?php 
	foreach ($liaisons_liste as $liaison_liste) {
?>
new Form.EventObserver('catalogue_liaisons_mod_<?php echo $liaison_liste->id_liaison_type; ?>', function(element, value){formChanged();});

new Event.observe("actif_<?php echo $liaison_liste->id_liaison_type; ?>", "click", function(evt){
	$("catalogue_liaisons_mod_<?php echo $liaison_liste->id_liaison_type; ?>").submit();
	}
);

<?php
	}
?>


new Event.observe("catalogue_recherche_showed_fiches", "blur", function(evt){nummask(evt, "<?php echo  $CATALOGUE_RECHERCHE_SHOWED_FICHES; ?>", "X"); }, false);
new Event.observe("stock_move_recherche_showed", "blur", function(evt){nummask(evt, "<?php echo  $STOCK_MOVE_RECHERCHE_SHOWED; ?>", "X"); }, false);
new Event.observe("defaut_garantie", "blur", function(evt){nummask(evt, "<?php echo  $DEFAUT_GARANTIE; ?>", "X"); }, false);
new Event.observe("defaut_article_lt", "blur", function(evt){nummask(evt, "<?php echo  $DEFAUT_ARTICLE_LT/(24*3600); ?>", "X"); }, false);
new Event.observe("defaut_indice_valorisation", "blur", function(evt){nummask(evt, "<?php echo  $DEFAUT_INDICE_VALORISATION; ?>", "X"); }, false);
new Event.observe("delai_article_is_new", "blur", function(evt){nummask(evt, "<?php echo  $DELAI_ARTICLE_IS_NEW/(24*3600); ?>", "X"); }, false);
new Event.observe("article_image_miniature_ratio", "blur", function(evt){nummask(evt, "<?php echo  $ARTICLE_IMAGE_MINIATURE_RATIO; ?>", "X"); }, false);
new Event.observe("article_qte_nb_dec", "blur", function(evt){nummask(evt, "<?php echo  $ARTICLE_QTE_NB_DEC; ?>", "X"); }, false);

//on masque le chargement
H_loading();
</SCRIPT>