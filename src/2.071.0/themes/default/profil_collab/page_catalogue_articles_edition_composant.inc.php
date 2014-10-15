<li id="composant_li_<?php echo $_REQUEST['serie_composant']?>">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td style="width:5%">&nbsp;</td>
			<td colspan="2" style="width:90%">
				<div class="composant_type_title">
					Niveau <?php echo $_REQUEST['niveau']?>
				</div>
				<input id="composant_niveau_<?php echo $_REQUEST['serie_composant']?>" name="composant_niveau_<?php echo $_REQUEST['serie_composant']?>" value="<?php echo $_REQUEST['niveau']?>" type="hidden"/>
			</td>
			<td style="width:5%">&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td style="width:70%">			
			</td>
			<td style="width:20%" class="composant_add_art" >
			<a href="#" id="link_art_edition_composant_<?php echo $_REQUEST['niveau']?>_<?php echo $_REQUEST['serie_composant']?>">Ajouter un composant</a>
				<script type="text/javascript">
				Event.observe("link_art_edition_composant_<?php echo $_REQUEST['niveau']?>_<?php echo $_REQUEST['serie_composant']?>", "click",  function(evt){Event.stop(evt); show_mini_moteur_articles ('art_edition_add_composant', '<?php echo $_REQUEST['niveau']?>, <?php echo $_REQUEST['serie_composant']?>');}, false);
				</script>
			</td>
			<td><span class="composant_li_lib_handle"></span>&nbsp;</td>
		</tr>			
	</table>
</li>