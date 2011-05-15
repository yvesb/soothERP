<div id="caract_info_under" style="padding-left:2%; padding-right:3%">
<form action="catalogue_articles_edition_valide.php?step=1" target="formFrame" method="post" name="article_edit_1" id="article_edit_1">
<input type="hidden" name="ref_article" id="ref_article" value="<?php echo $article->getRef_article ();?>" />
	
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
		foreach ($caracs as $carac) {
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
	<td colspan="6">
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
			<input name="ref_carac_<?php echo $serialisation_carac; ?>" id="ref_carac_<?php echo $serialisation_carac; ?>" type="hidden" value="<?php echo $carac->ref_carac; ?>" class="classinput_xsize" />
			<?php 
			if ($carac->allowed_values!="" && count(explode(";", $carac->allowed_values))>0 && $carac->variante < 1) {
				?>
				<select name="caract_value_<?php echo $serialisation_carac; ?>" id="caract_value_<?php echo $serialisation_carac; ?>"  class="classinput_xsize">
				<?php
				$allowed_values= explode(";", $carac->allowed_values);
				foreach ($allowed_values as $allowed_value){
					?>
					<option value="<?php echo htmlentities($allowed_value)?>" <?php 
					 foreach ($art_caracs as $art_carac) { 
						 if ($art_carac->valeur==$carac->default_value){echo 'selected="selected"';} 
					 }
					 ?>><?php echo htmlentities($allowed_value)?></option>
					<?php 
				}
				?>
				</select>
				<?php
			} else{
				?>
				<input name="caract_value_<?php echo $serialisation_carac; ?>" id="caract_value_<?php echo $serialisation_carac; ?>" type="text" value="<?php 
				foreach ($art_caracs as $art_carac) { 
					if ($art_carac->ref_carac==$carac->ref_carac){echo htmlentities($art_carac->valeur);}
				}
				?>" class="classinput_xsize" />
				<?php
			}
			?>
			</td>

			<td style="" class="col_color_2"><?php echo htmlentities($carac->unite); ?></td>
			<td style="width:55px; text-align:center"  class="col_color_2">
			<span class="variante_info">
				<input name="variante_<?php echo $serialisation_carac; ?>" id="variante_<?php echo $serialisation_carac; ?>" type="hidden" value="<?php echo htmlentities($carac->variante); ?>" />
				<?php if (isset ($carac->variante) && $carac->variante == 1){?>Variante<?php }?>
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
		$serialisation_carac	+=	1;
		}
		?>
	</table>
	
	<table style="width:100%">
		<tr class="smallheight">
			<td style="width:20%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
			<td style="width:25%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
			<td style="width:5%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
			<td style="width:20%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
			<td style="width:25%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
			<td style="width:5%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
		</tr>
		<tr>
			<td colspan="5" style="text-align:right">
				<a href="#" id="bt_etape_1"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-valider.gif" /></a>
			</td>
			<td></td>
		</tr>
	</table>
	
			<input name="serialisation_carac" id="serialisation_carac" type="hidden" value="<?php echo $serialisation_carac; ?>" />
	<br />
	<span class="bolder">RS</span>=Crit&egrave;re de Recherche Simple - <span class="bolder">RA</span>=Crit&egrave;re de Recherche Avanc&eacute;s - <span class="bolder">N</span>=Affichage Normal - <span class="bolder">P</span>=Affichage Prioritaire<br />

<span class="bolder">Variantes</span>= Veuillez préciser les différentes valeurs par des points virgules. <span style="font-style:italic"> Exemple:</span>  Bleu; Rouge; Vert ...
</form>
</div>