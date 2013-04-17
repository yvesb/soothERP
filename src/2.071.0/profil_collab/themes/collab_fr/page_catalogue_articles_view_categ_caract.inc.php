
<form action="catalogue_articles_view_valide.php?step=1" target="formFrame" method="post" name="article_view_1" id="article_view_1">
<?php 
// apply_change : Variable permettant de savoir ce qu'on modifie :
//		1: 'Uniquement l'article courant'
//		2: 'Toutes les variantes'
?>
<input type="hidden" name="apply_change" id="apply_change" value="1" />
<?php
if ($article->getVariante() == 1 && is_object($article_master)) {
	$article_fils = 1;
	?>
<input type="hidden" name="ref_article"  value="<?php echo $article_master->getRef_article ();?>" />
<input type="hidden" name="ref_article_origine" value="<?php echo $article->getRef_article ();?>" />
	<?php
} else {
	$article_fils = 0;
?>
<input type="hidden" name="ref_article" value="<?php echo $article->getRef_article ();?>" />
	
	<?php
}
?>
	<table style="width:100%;">
	<!-- 
	<tr class="row_color">
	<td colspan="5">
	Caract&eacute;ristiques
	</td>
	</tr>
	-->
	<tr>
	<td colspan="5">&nbsp;
	
	</td>
	</tr>
	<?php 
		$ref_carac_groupe=NULL;
		$ligne_general	=	1;
		$serialisation_carac	=	0;
		$variante_carac	=	0;
		$tab_stock = array ();
		foreach ($article->getCaracs() as $carac) {
			if ($ref_carac_groupe!=$carac->ref_carac_groupe) {
				$ligne_general	=	0;
				$ref_carac_groupe	=	$carac->ref_carac_groupe;
				?>
	</table>
	<table style="width:100%;">
	<tr class="row_color_0">
	<td colspan="5">
	<?php echo htmlentities($carac->lib_carac_groupe); ?>
	</td>
	</tr>
	</table>
	<table style="width:100%; background-color:#FFFFFF">
				<?php
			} else if ($ligne_general) {
						$ligne_general	=	0;
				?>
	</table>
	<table style="width:100%;">	
	<tr class="row_color_0">
	<td colspan="5">
	G&eacute;n&eacute;ral
	</td>
	</tr>
	</table>
	<table style="width:100%; background-color:#FFFFFF">
				<?php
			}
		?>
	<tr>
	<td style="width:20%;" class="col_color_1">
	<?php echo htmlentities($carac->lib_carac); ?>
	</td>
	
			<td style="width:30%;" class="col_color_2">
			<input name="ref_carac_<?php echo $serialisation_carac; ?>" id="ref_carac_<?php echo $serialisation_carac; ?>" type="hidden" 
					value="<?php echo $carac->ref_carac; ?>" class="classinput_xsize" />
			<?php 
			// Si pas variante
			if ($carac->variante == 0) {
				?>
				<input type="hidden" name="old_caract_value_<?php echo $serialisation_carac; ?>" id="old_caract_value_<?php echo $serialisation_carac; ?>" 
					value="<?php echo htmlentities($carac->valeur); ?>" />
				<?php if(count(explode(";", $carac->allowed_values)) > 1){ ?>
				<select name="caract_value_<?php echo $serialisation_carac; ?>" id="caract_value_<?php echo $serialisation_carac; ?>"  class="classinput_xsize">
				<?php
				$allowed_values= explode(";", $carac->allowed_values);
				foreach ($allowed_values as $allowed_value){
					?>
					<option value="<?php echo htmlentities($allowed_value)?>" <?php if ($allowed_value==$carac->valeur){echo 'selected="selected"';} ?>>
					<?php echo htmlentities($allowed_value)?></option>
					<?php 
				}
				?>
				</select>
				<?php 
				}else{
					?>
					<input name="caract_value_<?php echo $serialisation_carac; ?>" id="caract_value_<?php echo $serialisation_carac; ?>" 
					 	type="text" value="<?php echo htmlentities($carac->valeur); ?>" class="classinput_xsize" />
					<?php 
				}
			// Si variante
			} else {
				?>
				<input 
					<?php if(!$article_fils){ ?>name="caract_value_<?php echo $serialisation_carac; ?>" id="caract_value_<?php echo $serialisation_carac; ?>" 
					<?php } ?> type="text" value="<?php 
				foreach ($art_caracs as $art_carac) { 
					if ($art_carac->ref_carac==$carac->ref_carac){echo htmlentities($art_carac->valeur);}
				}
				?>" class="classinput_xsize" <?php if($article_fils) {?>readonly="readonly" style="background-color: #DDD;" <?php }?>/>
				<?php if($article_fils){ ?>
				<input type="hidden" name="caract_value_<?php echo $serialisation_carac; ?>" id="caract_value_<?php echo $serialisation_carac; ?>" value="<?php 
				foreach ($article->getCaracs() as $art_carac) { 
					if ($art_carac->ref_carac==$carac->ref_carac){echo htmlentities($art_carac->valeur);}
				}
				?>" />
				<input name="old_caract_value_<?php echo $serialisation_carac; ?>" id="old_caract_value_<?php echo $serialisation_carac; ?>" type="hidden" value="<?php 
				foreach ($article->getCaracs() as $art_carac) { 
					if ($art_carac->ref_carac==$carac->ref_carac){echo htmlentities($art_carac->valeur);}
				}
				?>" class="classinput_xsize" />
				<?php } else { ?>
				<input name="old_caract_value_<?php echo $serialisation_carac; ?>" id="old_caract_value_<?php echo $serialisation_carac; ?>" type="hidden" value="<?php 
				foreach ($art_caracs as $art_carac) { 
					if ($art_carac->ref_carac==$carac->ref_carac){echo htmlentities($art_carac->valeur);}
				}
				?>" class="classinput_xsize" />
				<?php }
			}
			?>
			</td>

			<td style="" class="col_color_2"><?php echo htmlentities($carac->unite); ?></td>
			<td style="width:55px; text-align:center"  class="col_color_2">
			<span class="variante_info">
				<input name="variante_<?php echo $serialisation_carac; ?>" id="variante_<?php echo $serialisation_carac; ?>" type="hidden" value="<?php echo htmlentities($carac->variante); ?>" />
		
				<?php if ($article->getVariante() != 0 && $carac->variante == 1){
					$variante_carac	++;
				?>Variante
		
				<script type="text/javascript">
				Event.observe($("caract_value_<?php echo $serialisation_carac; ?>"), "blur", function(evt){
					
					Event.stop(evt); 
					//si on supprime toutes les valeur d'un carac variante, c'est impossible en mode édition donc on interdit
					if ($("caract_value_<?php echo $serialisation_carac; ?>").value == "" && $("old_caract_value_<?php echo $serialisation_carac; ?>").value != "" || $("caract_value_<?php echo $serialisation_carac; ?>").value != "" && $("old_caract_value_<?php echo $serialisation_carac; ?>").value == "" ) {
						$("caract_value_<?php echo $serialisation_carac; ?>").value = $("old_caract_value_<?php echo $serialisation_carac; ?>").value ;
							alerte.alerte_erreur ('Erreur de saisie', "Vous ne pouvez pas rajouter de variante depuis une caractéristique vide <br/>  ou rajouter des variantes si aucune valeur n'a été définie à la création",'<input type="submit" id="bouton0" name="bouton0" value="Ok" />');
					} else {
						if ($("caract_value_<?php echo $serialisation_carac; ?>").value.substr(0,$("old_caract_value_<?php echo $serialisation_carac; ?>").value.length) != $("old_caract_value_<?php echo $serialisation_carac; ?>").value || ( $("caract_value_<?php echo $serialisation_carac; ?>").value.split(";").length < $("old_caract_value_<?php echo $serialisation_carac; ?>").value.split(";").length)) {
							$("caract_value_<?php echo $serialisation_carac; ?>").value = $("old_caract_value_<?php echo $serialisation_carac; ?>").value ;
							alerte.alerte_erreur ('Erreur de saisie', "Vous ne pouvez pas supprimer des valeurs de variantes existantes.",'<input type="submit" id="bouton0" name="bouton0" value="Ok" />');
						} else {
							//$("old_caract_value_<?php echo $serialisation_carac; ?>").value = $("caract_value_<?php echo $serialisation_carac; ?>").value;
							charger_edition_variations_possibles("<?php echo $article->getRef_art_categ();?>", "<?php echo $article->getRef_article();?>");
						}
					}
				});
				</script>
				<?php }?>
			</span>
			</td>
			<td style="width:15px; text-align:center"  class="col_color_2">
			<?php if ($carac->moteur_recherche==1){?>
			RS
			<?php } else if ($carac->moteur_recherche==2){?>
			RA
			<?php }?>
			</td>
			<td style="width:15px; text-align:center"  class="col_color_2">
			<?php if ($carac->affichage==1){?>
			N
			<?php } else if ($carac->affichage==2){?>
			P
			<?php }?>
			</td>
		</tr>
		<?php
		$serialisation_carac++;
		}
		?>
	</table>
	
	<table style="width:100%">
		<tr class="smallheight">
			<td style="width:95%"></td>
			<td style="width:5%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
		</tr>
		<tr>
			<td style="text-align:right">
			<a href="#" id="bt_etape_1"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-valider.gif" /></a>
			</td>
			<td></td>
		</tr>
	</table>
	
			<input name="serialisation_carac" id="serialisation_carac" type="hidden" value="<?php echo $serialisation_carac; ?>" />
	<br />
	<span class="bolder">RS</span>=Crit&egrave;re de Recherche Simple - <span class="bolder">RA</span>=Crit&egrave;re de Recherche Avanc&eacute;e - <span class="bolder">N</span>=Affichage Normal - <span class="bolder">P</span>=Affichage Prioritaire<br />
<span class="bolder">Variantes</span>= Veuillez préciser les différentes valeurs par des points virgules. <span style="font-style:italic"> Exemple:</span>  Bleu; Rouge; Vert ...
<script type="text/javascript">
Event.observe($("bt_etape_1"), "click", function(evt){
	Event.stop(evt);
	<?php if($article->getVariante()) { ?>
		$("titre_alert").innerHTML = "Confirmation";
		<?php if($article_fils) { ?>
		$("texte_alert").innerHTML = "Voulez-vous appliquer cette modification uniquement à l'article en cours ou à toutes les variantes ?";
		$("bouton_alert").innerHTML = '<input type="submit" id="bouton0" name="bouton0" value="Article en cours" /> ';
		$("bouton_alert").innerHTML += '<input type="submit" name="bouton1" id="bouton1" value="Tous" /> ';
		<?php } else { ?>
		$("texte_alert").innerHTML = "Voulez-vous appliquer cette modification uniquement à l'article parent ou à toutes les variantes ?";
		$("bouton_alert").innerHTML = '<input type="submit" id="bouton0" name="bouton0" value="Article parent" /> ';
		$("bouton_alert").innerHTML += '<input type="submit" name="bouton1" id="bouton1" value="Tous" /> ';
		<?php } ?>
		$("bouton_alert").innerHTML += '<input type="submit" id="bouton2" name="bouton2" value="Annuler" />';
	
		$("alert_pop_up_tab").style.display = "block";
		$("framealert").style.display = "block";
		$("alert_pop_up").style.display = "block";
		
		$("bouton0").onclick= function () {
			$('apply_change').value = '1';
			$("framealert").style.display = "none";
			$("alert_pop_up").style.display = "none";
			$("alert_pop_up_tab").style.display = "none";
			submitform ("article_view_1");
		}
		$("bouton1").onclick= function () {
			$('apply_change').value = '2';
			$("framealert").style.display = "none";
			$("alert_pop_up").style.display = "none";
			$("alert_pop_up_tab").style.display = "none";
			submitform ("article_view_1");
		}
		$("bouton2").onclick= function () {
			$("framealert").style.display = "none";
			$("alert_pop_up").style.display = "none";
			$("alert_pop_up_tab").style.display = "none";
		}
	<?php } else { ?>
		submitform ("article_view_1");
	<?php } ?>
});
</script>

<div id="variantes_info_under">
</div>
<script type="text/javascript">
<?php
if ($article->getVariante() != 0 && $variante_carac) {
	?>
	charger_edition_variations_possibles("<?php echo $article->getRef_art_categ();?>", "<?php echo $article->getRef_article();?>");
	<?php
}
?>
</script>
</form>