<?php

// *************************************************************************************************************
// AFFICHAGE DES DIFF2RENTES POSSIBILITES DE VARIANTES
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

if (!isset($resultat_var[0]) || !count($resultat_var[0])){
	?>
	<script type="text/javascript">
	$("liste_codes_barres").style.display ="";
	$("art_lib_code_barre").style.display ="";
	$("a_code_barre").style.display ="";
	</script>
	<?php
	exit;
}
?>
	<script type="text/javascript">
	$("liste_codes_barres").style.display ="none";
	$("art_lib_code_barre").style.display ="none";
	$("a_code_barre").style.display ="none";
	</script>
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
						//foreach ($var_detail as $clef=>$detail){
							if ($liste_var_lib) { $liste_var_lib .= " - ";}
							$liste_var_lib .= $detail;
							?>
					<input name="variante_carac_<?php echo $clef; ?>_<?php echo $indentations_variantes; ?>" id="variante_carac_<?php echo $clef; ?>_<?php echo $indentations_variantes; ?>" type="hidden" value="<?php echo $detail; ?>"  class="classinput_xsize" />
							<?php
						//}
					}
					echo $liste_var_lib;
				 ?>
				</td>
				<td style="width:30%;" class="col_color_1">
					<input name="variante_codebarre_<?php echo $indentations_variantes; ?>" id="variante_codebarre_<?php echo $indentations_variantes; ?>" type="text" value="Code barre"  class="classinput_xsize" />
					<script type="text/javascript">
					Event.observe("variante_codebarre_<?php echo $indentations_variantes; ?>", "focus", function(evt){
						Event.stop(evt); 
						$("variante_codebarre_<?php echo $indentations_variantes; ?>").value = "";
					});
					</script>
				</td>
				</tr>
			</table>
		</td>
		<td style="width:5%">
			<input name="variante_valide_<?php echo $indentations_variantes; ?>" id="variante_valide_<?php echo $indentations_variantes; ?>" type="checkbox" value="" />
		</td>
		<td style="width:20%"></td>
		<td style="width:25%"></td>
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

	<input name="indentations_variantes" id="indentations_variantes" type="hidden" value="<?php echo $indentations_variantes; ?>" />
</div>
	<table style="width:100%">
		<tr class="smallheight">
			<td style="width:95%"></td>
			<td style="width:5%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
		</tr>
		<tr>
			<td style="text-align:right">
			<a href="#" id="bt_etape_1b"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-continuer.gif" /></a>
			</td>
			<td></td>
		</tr>
	</table>
<script type="text/javascript">
//fonction de validation de l'étape 2
Event.observe($("bt_etape_1b"), "click", function(evt){Event.stop(evt); goto_etape (2);});
</script>