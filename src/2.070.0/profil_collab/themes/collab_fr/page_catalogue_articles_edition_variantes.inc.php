<?php
// *************************************************************************************************************
// AFFICHAGE DES DIFFERENTES POSSIBILITES DE VARIANTES
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
// Si on est sur un fils
if($article->getVariante_master() != NULL){
	?>
	<p>&nbsp;</p>
	<div class="link_to_master" id="goto_parent" style="width: 95%;">Accéder à l'article parent à l'origine de cette variante</div>
	<script type="text/javascript">
		Event.observe("goto_parent", "click", function(evt){
			parent.page.verify("goto_parent","catalogue_articles_view.php?ref_article=<?php echo $article->getVariante_master(); ?>", "true", "sub_content");
		});
	</script>
	<?php
	exit;
}
if (!isset($resultat_var[0]) || !count($resultat_var[0])){exit;}
?>
<table style="width:100%;" cellpadding="0" cellspacing="0" border="0">
	<tr class="row_color_0">
		<td colspan="5">
		Variantes
		</td>
	</tr>
</table>
<div id="liste_variantes_article">
<table style="width:100%" cellpadding="0" cellspacing="0" border="0">
	<tr class="smallheight">
		<td style="width:65%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
		<td style="width:5%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
		<td style="width:15%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
		<td style="width:15%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
	</tr>
<?php 
$indentations_variantes = 0;
foreach ($resultat_var as $variante) {
	$correspondant_ref_article = "";
	if (!count($variante)) {continue;}
	?>
	
	<tr class="smallheight">
		<td style="width:50%">
			<table style="width:100%; background-color:#FFFFFF">
				<tr>
				<td style="width:70%;" class="col_color_1">
				 <?php
				 $liste_var_lib="";
				 	foreach ($variante as  $clef=>$detail){
							if ($liste_var_lib) { $liste_var_lib .= " - ";}
							$liste_var_lib .= $detail;
							?>
					<input name="variante_carac_<?php echo $clef; ?>_<?php echo $indentations_variantes; ?>" id="variante_carac_<?php echo $clef; ?>_<?php echo $indentations_variantes; ?>" type="hidden" value="<?php echo $detail; ?>"  class="classinput_xsize" />
							<?php
					}
					if (isset($liste_slaves)) {
						foreach ($liste_slaves as $slave) {
							if (count(array_intersect_assoc($variante,$slave->caracs)) == count($variante)) {
								$correspondant_ref_article = $slave->ref_article_lie;
								break;
							}
						}
					}
					echo $liste_var_lib;
				 ?>
				</td>
				<td style="width:30%;" class="col_color_1">
					<input name="variante_codebarre_<?php echo $indentations_variantes; ?>" id="variante_codebarre_<?php echo $indentations_variantes; ?>" type="text" value="Code barre"  class="classinput_xsize"  <?php if ($correspondant_ref_article) {?>disabled="disabled" <?php }?> />
					<script type="text/javascript">
					Event.observe("variante_codebarre_<?php echo $indentations_variantes; ?>", "focus", function(evt){
						Event.stop(evt); 
						$("variante_codebarre_<?php echo $indentations_variantes; ?>").value = "";
					});
					Event.observe("variante_codebarre_<?php echo $indentations_variantes; ?>", "blur", function(evt){
						Event.stop(evt);
						if($("variante_codebarre_<?php echo $indentations_variantes; ?>").value == ""){
							$("variante_codebarre_<?php echo $indentations_variantes; ?>").value = "Code Barre";
						}
					});
					</script>
				</td>
				</tr>
			</table>
		</td>
		<td style="width:5%">
			<input name="variante_valide_<?php echo $indentations_variantes; ?>" id="variante_valide_<?php echo $indentations_variantes; ?>" type="checkbox" value="<?php if ($correspondant_ref_article) { echo $correspondant_ref_article;}?>" <?php if ($correspondant_ref_article) {?> checked="checked" disabled="disabled" <?php }?>/>
		</td>
		<td style="width:15%; text-align:right">
			<?php if ($correspondant_ref_article) {?><span class="common_link" id="aff_resume_stock_<?php echo $correspondant_ref_article?>">+ d'infos stock</span>
			
			<script type="text/javascript">
			Event.observe("aff_resume_stock_<?php echo $correspondant_ref_article?>", "click", function(evt){show_resume_stock("<?php echo $correspondant_ref_article?>", evt); Event.stop(evt);}, false);
			</script>
			<?php }?>
		</td>
		<td style="width:30%; text-align:right">
			<?php if ($correspondant_ref_article) {?><span class="common_link" id="link_article_variante_<?php echo $correspondant_ref_article?>">Voir la fiche article</span>
			
				<script type="text/javascript">
				Event.observe("link_article_variante_<?php echo $correspondant_ref_article?>", "click",  function(evt){Event.stop(evt); page.verify('catalogue_articles_view','index.php#'+escape('catalogue_articles_view.php?ref_article=<?php echo $correspondant_ref_article?>'),'true','_blank');}, false);
				</script>
			<?php }?>
		</td>
	</tr>
	<?php
	$indentations_variantes++;
}
?>

	<tr class="smallheight">
		<td >
			<span style="float:right">
			<a href="#" id="all_coche_variantes" class="doc_link_simple">Cocher</a> / 
			<a href="#" id="all_decoche_variantes" class="doc_link_simple">D&eacute;cocher</a> / 
			<a href="#" id="all_inv_coche_variantes" class="doc_link_simple">Inverser</a>
			</span><br />

			<script type="text/javascript">
			
			Event.observe("all_coche_variantes", "click", function(evt){
				Event.stop(evt); 
				coche_line_variantes ("coche", "variante_valide", parseFloat($("indentations_variantes").value));
			});
			Event.observe("all_decoche_variantes", "click", function(evt){
				Event.stop(evt); 
				coche_line_variantes ("decoche", "variante_valide", parseFloat($("indentations_variantes").value));
			});
			Event.observe("all_inv_coche_variantes", "click", function(evt){
				Event.stop(evt); 
				coche_line_variantes ("inv_coche", "variante_valide", parseFloat($("indentations_variantes").value));
			});
			</script>
		</td>
		<td style="width:5%"></td>
		<td style="width:15%"></td>
		<td style="width:15%"></td>
	</tr>
</table>

<iframe frameborder="0" scrolling="no" src="about:_blank" id="resume_stock_iframe" class="resume_stock_iframe"></iframe>
<div id="resume_stock" class="resume_stock_blanc">
</div>
	<input name="indentations_variantes" id="indentations_variantes" type="hidden" value="<?php echo $indentations_variantes; ?>" />
</div>
