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

<form action="documents_gestion_type_param_pdf_mod.php" method="post" id="documents_gestion_type_param_pdf_mod" name="documents_gestion_type_param_pdf_mod" target="formFrame" >
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
	$idx_option = -1;
	$op_suiv_is_show = true;
	$ref_option = array();
	foreach ($config_files as $config_line) {
		if (substr_count($config_line, "// PARAMETRES MODIFIABLES")) { $meet_edit_param = 1; continue;}
		if (substr_count($config_line, "// FIN PARAMETRES MODIFIABLES")) { $meet_edit_param = 0; continue;}
		if (!$meet_edit_param) { continue;}

		++$idx_option;
		$op_is_show = $op_suiv_is_show;
		$op_suiv_is_show = true;
		$tmp_infos = explode("//", str_replace("/n", "", $config_line));
		?>
					
		<?php if (substr($tmp_infos[1], 0, 4) == "TXTE") { ?>
		<tr id="option<?php echo $idx_option; ?>" <?php if (!$op_is_show){ echo 'style="display:none"'; }?>>
			<td><?php if (isset($tmp_infos[2])) {echo $tmp_infos[2];}?>&nbsp;</td>
			<td style="text-align:left">
				<input type="text" name="<?php echo urlencode(substr($tmp_infos[0], 0, strpos($tmp_infos[0], "=")));?>" value="<?php echo stripcslashes(str_replace("\"", "", substr($tmp_infos[0], strpos($tmp_infos[0], "=")+1, strlen($tmp_infos[0])-strpos($tmp_infos[0], "=")-2)));?>" class="classinput_xsize"/>
			<td style="text-align:left"><?php if (isset($tmp_infos[3])) {echo $tmp_infos[3];}?>&nbsp;</td>
		</tr>
		<?php }	?>
		
		<?php if (substr($tmp_infos[1], 0, 4) == "TXTA") { ?>
		<tr id="option<?php echo $idx_option; ?>" <?php if (!$op_is_show){ echo 'style="display:none"'; }?>>
			<td ><?php if (isset($tmp_infos[2])) {echo $tmp_infos[2];}?>&nbsp;</td>
			<td style="text-align:left">
				<textarea name="<?php echo urlencode(substr($tmp_infos[0], 0, strpos($tmp_infos[0], "=")));?>" class="classinput_xsize"><?php echo stripcslashes(str_replace("\"", "", substr($tmp_infos[0], strpos($tmp_infos[0], "=")+1, strlen($tmp_infos[0])-strpos($tmp_infos[0], "=")-2)));?></textarea>
			<td style="text-align:left"><?php if (isset($tmp_infos[3])) {echo $tmp_infos[3];}?>&nbsp;</td>
		</tr>
		<?php }	?>
		
		<?php if (substr($tmp_infos[1], 0, 4) == "TXTP") { ?>
		<tr id="option<?php echo $idx_option; ?>" <?php if (!$op_is_show){ echo 'style="display:none"'; }?> >
			<td colspan="3" ><?php if (isset($tmp_infos[2])) {echo $tmp_infos[2];}?>
				<br/>
				<textarea name="<?php echo urlencode(substr($tmp_infos[0], 0, strpos($tmp_infos[0], "=")));?>" class="classinput_psize"><?php echo stripcslashes(str_replace("\"", "", substr($tmp_infos[0], strpos($tmp_infos[0], "=")+1, strlen($tmp_infos[0])-strpos($tmp_infos[0], "=")-2)));?></textarea>
				<br/>
				<div style="text-align:right"><?php if (isset($tmp_infos[3])) {echo $tmp_infos[3];}?></div>
			</td>
		</tr>
		<?php }	?>
		
		<?php if (substr($tmp_infos[1], 0, 4) == "CBOX") { ?>
		<tr id="option<?php echo $idx_option; ?>" <?php if (!$op_is_show){ echo 'style="display:none"'; }?>>
			<td><?php if (isset($tmp_infos[2])) {echo $tmp_infos[2];}?>&nbsp;</td>
			<td style="text-align:left">
				<input type="checkbox" name="<?php echo urlencode(substr($tmp_infos[0], 0, strpos($tmp_infos[0], "=")));?>" value=true <?php if (stripcslashes(str_replace("\"", "", substr($tmp_infos[0], strpos($tmp_infos[0], "=")+1, strlen($tmp_infos[0])-strpos($tmp_infos[0], "=")-2)))=="true" ){ echo 'checked="checked"';}?>/>
			<td style="text-align:left"><?php if (isset($tmp_infos[3])) {echo $tmp_infos[3];}?>&nbsp;</td>
		</tr>
		<?php }	?>
		
		<?php 
		if (substr($tmp_infos[1], 0, 4) == "SLCT") { ?>
		<tr id="option<?php echo $idx_option; ?>" <?php if (!$op_is_show){ echo 'style="display:none"'; }?>>
			<td><?php if (isset($tmp_infos[2])) {echo $tmp_infos[2];}?></td>
			<td style="text-align:left">
				<?php 
				$valeur = explode("@", str_replace("/n", "", $tmp_infos[4]));		
				
				echo '<select name="'.urlencode(substr($tmp_infos[0], 0, strpos($tmp_infos[0], "="))).'">';
				foreach ($valeur AS $val){
					$val = str_replace("%0A", "",str_replace("%0D", "", urlencode($val)));
	  		  		echo '<option value="'.$val.'"'; 
					if (stripcslashes(str_replace("\"", "", substr($tmp_infos[0], strpos($tmp_infos[0], "=")+1, strlen($tmp_infos[0])-strpos($tmp_infos[0], "=")-2)))==$val ){ echo ' selected="selected"';}
					echo ' >'.$val.'</option>';
	   		 	}	
		   		echo '</select>';
		   		?>
		   	</td>
	   		<td style="text-align:left"><?php if (isset($tmp_infos[3])) {echo $tmp_infos[3];}?></td>
		</tr>
		<?php 
		}
		?>
		
		<?php if (substr($tmp_infos[1], 0, 4) == "CBOP") { ?>
		<tr id="option<?php echo $idx_option; ?>" <?php if (!$op_is_show){ echo 'style="display:none"'; }?> >
			<td ><?php if (isset($tmp_infos[2])) {echo $tmp_infos[2];}?>&nbsp;</td>
			<td style="text-align:left">
			<?php 
			$ref_option[] = $idx_option;
			$var = urlencode(substr($tmp_infos[0], 0, strpos($tmp_infos[0], "=")));?>
			<input type="checkbox" id ="check_option_<?php echo $idx_option;?>" name="<?php  echo $var ?>" value=true <?php if (stripcslashes(str_replace("\"", "", substr($tmp_infos[0], strpos($tmp_infos[0], "=")+1, strlen($tmp_infos[0])-strpos($tmp_infos[0], "=")-2)))=="true" ){ echo 'checked="checked"';}?>/>
			<?php if (stripcslashes(str_replace("\"", "", substr($tmp_infos[0], strpos($tmp_infos[0], "=")+1, strlen($tmp_infos[0])-strpos($tmp_infos[0], "=")-2)))!="true" ){
				$op_suiv_is_show = false;
			} ?>
			<td style="text-align:left"><?php if (isset($tmp_infos[3])) {echo $tmp_infos[3];}?>&nbsp;</td>
		</tr>
		<?php }	
				
	 } 
	?>
</table><br />

		<input name="modifier" type="image" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-valider.gif" />
</form><br />
<br />

Le paramétrage d'un modèle d'impression est une opération parfois complexe qui nécessite une connaissance approfondie du fonctionnement du logiciel.<br />
<br />

<?php foreach($ref_option AS $id){?>
	<script type="text/javascript">
	
		Event.observe('check_option_<?php echo $id;?>', "click" , function(evt){
			if($("check_option_<?php echo $id;?>").checked){
				$("option<?php echo ($id+1); ?>").show();
			}else{
				$("option<?php echo ($id+1); ?>").hide();
			}
			
	 } , false);
	</script>
<?php } ?>       