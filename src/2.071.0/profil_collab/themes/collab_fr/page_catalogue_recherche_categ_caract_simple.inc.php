<div style="border-bottom:1px solid #809eb6; height:9px;"></div>
<table style="width:100%">
<tr><td style="width:25%">
<span  class="labelled_text" style="font-weight:bolder">Caract&eacute;ristiques : </span>
</td>
<td>
</td></tr></table>
<div id="caract_recherche" class="caract_simple">
<?php 
$serialisation_carac = 0;
foreach ($caracs as $carac) {
	?>
	<div id="caract_<?php echo $serialisation_carac; ?>">
		<table>
		<tr>
		<td style="width:135px">
		<span class="search_lib_carac">
		<?php echo htmlentities($carac->lib_carac); ?>:
		</span>
		</td>
		<td style="width:135px">
		<?php 
		if ($carac->allowed_values!="" && count(explode(";", $carac->allowed_values))>0) {
			?>
			<select name="carac<?php echo $carac->ref_carac; ?>" id="carac<?php echo $carac->ref_carac; ?>"  class="classinput_xsize">
			<?php
				$allowed_values= explode(";", $carac->allowed_values);
				foreach ($allowed_values as $allowed_value){
					?>
					<option value="<?php echo htmlentities($allowed_value)?>" <?php 
					if ($allowed_value==$carac->default_value) {echo 'selected="selected"';} ?>><?php echo htmlentities($allowed_value)?></option>
					<?php 
				}
				?>
				</select>
				<?php
			} else{
				?>
				<input name="carac<?php echo $carac->ref_carac; ?>" id="carac<?php echo $carac->ref_carac; ?>" type="text" value="<?php echo htmlentities($carac->default_value); ?>" class="classinput_xsize" />
				<?php
			}
			?>
		</td>
		<td style="width:25px; text-align:left;">
		<span  class="labelled_text"><?php echo htmlentities($carac->unite); ?></span>
		</td></tr></table>
	</div>
	<?php 
	$serialisation_carac++;
}
?>
</div>


<table style="width:100%" id="plus_de_carac_table">
<tr><td style="width:25%">
<a href="#" id="plus_de_carac" style="display:block" class="carac_plus_moins"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/ajouter.gif" /> Plus de caract&eacute;ristiques</a>
</td>
<td><div style=" height:18px;"></div>
</td></tr></table>

<table style="width:100%;display:none" id="moins_de_carac_table">
<tr><td style="width:25%">
<a href="#" id="moins_de_carac" class="carac_plus_moins"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/moins.gif" />&nbsp;Moins&nbsp;de&nbsp;caract&eacute;ristiques</a>
</td>
<td></td></tr></table>
<div id="caract_avancee" class="caract_recherche"></div>

<table style="width:100%;">
	<tr>
		<td style="width:2%;">&nbsp;</td>
		<td style="width:25%;">&nbsp;</td>
		<td style="text-align:right; width:25%"><span style="text-align:right">
			<input name="submit2" type="image" onclick="$('page_to_show').value=1;" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-rechercher.gif"  style="float:left" />
			<input type="image" name="annuler_recherche2" id="annuler_recherche2" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-annuler.gif"/>
		</span></td>
		<td style="padding-left:35px"></td>
		<td></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
</table>
<script type="text/javascript">
Event.observe('annuler_recherche2', "click", function(evt){Event.stop(evt); reset_moteur_a ('form_recherche_a', 'ref_art_categ');	});

	Event.observe('plus_de_carac', 'click',  function(evt){Event.stop(evt);  Element.toggle('plus_de_carac_table');  Element.toggle('moins_de_carac_table'); charger_carac_avancee("<?php echo $_REQUEST['ref_art_categ']?>", "caract_avancee");}, false);
	Event.observe('moins_de_carac', 'click',  function(evt){Event.stop(evt);  Element.toggle('plus_de_carac_table');  Element.toggle('moins_de_carac_table'); $("caract_avancee").update("");}, false);
</script>
