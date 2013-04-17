<?php

// *************************************************************************************************************
// CONTROLE DU THEME
// *************************************************************************************************************

// Variables nécessaires à l'affichage
$page_variables = array ("_ALERTES");
check_page_variables ($page_variables);


//******************************************************************
// Variables communes d'affichage
//******************************************************************




// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************
?>

<form action="courriers_gestion_type_param_pdf_mod.php" method="post" id="courriers_gestion_type_param_pdf_mod" name="courriers_gestion_type_param_pdf_mod" target="formFrame" >
<input name="id_pdf_modele" type="hidden" value="<?php echo $modele_pdf->id_pdf_modele; ?>" />
<table  style="width:100%" border="0">
  <tr>
    <td colspan="3" style="font-weight:bolder">Modèle <?php echo $modele_pdf->lib_modele;?></td>
  </tr>
  <tr>
    <td colspan="3"><?php echo $modele_pdf->desc_modele;?><br />
<br />

	<?php 
	if (isset($_REQUEST["id_type_doc"]) && isset($_REQUEST["act"])) {
		?>
		<input name="id_type_doc" type="hidden" value="<?php echo $_REQUEST["id_type_doc"];?>" />
		<input name="act" type="hidden" value="<?php echo $_REQUEST["act"];?>" />
		<?php
	}
	?>
</td>
  </tr>
	<?php
	$meet_edit_param = 0;
	foreach ($config_files as $config_line) {
		if (substr_count($config_line, "// PARAMETRES MODIFIABLES")) { $meet_edit_param = 1; continue;}
		if (substr_count($config_line, "// FIN PARAMETRES MODIFIABLES")) { $meet_edit_param = 0; continue;}
		if (!$meet_edit_param) { continue;}
		
		$tmp_infos = explode("//", str_replace("/n", "", $config_line));
		?>
		<tr>
			<td><?php if (isset($tmp_infos[2])) {echo $tmp_infos[2];}?>&nbsp;</td>
			<td style="text-align:center">
			<?php if (substr($tmp_infos[1], 0, 4) == "TXTE") { ?>
			<input type="text" name="<?php echo urlencode(substr($tmp_infos[0], 0, strpos($tmp_infos[0], "=")));?>" value="<?php echo str_replace("\"", "", substr($tmp_infos[0], strpos($tmp_infos[0], "=")+1, strpos($tmp_infos[0], ";")-strpos($tmp_infos[0], "=")-1));?>" class="class_input_xsize"/>
			<?php }	?>
			
			<?php if (substr($tmp_infos[1], 0, 4) == "TXTA") { ?>
			<textarea type="text" name="<?php echo urlencode(substr($tmp_infos[0], 0, strpos($tmp_infos[0], "=")));?>" class="class_input_nsize"><?php echo stripcslashes(str_replace("\"", "", substr($tmp_infos[0], strpos($tmp_infos[0], "=")+1, strpos($tmp_infos[0], ";")-strpos($tmp_infos[0], "=")-1)));?></textarea>
			<?php }	?>
			
			</td>
			<td style="text-align:left"><?php if (isset($tmp_infos[3])) {echo $tmp_infos[3];}?>&nbsp;</td>
		</tr>
		<?php 
	}
	?>
</table><br />

		<input name="modifier" type="image" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-valider.gif" />
</form>
<br />
<br />

Le paramétrage d'un modèle d'impression est une opération parfois complexe qui nécessite une connaissance approfondie du fonctionnement du logiciel.<br />
<br />

<script type="text/javascript">
 
</script>
         