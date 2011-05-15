<?php

// *************************************************************************************************************
// PAGE POUR CHOISIR LE TYPE ET LE MODELE PDF D'UN COURRIER 
// *************************************************************************************************************

// Variables nécessaires à l'affichage
$page_variables = array ();
check_page_variables ($page_variables);


//******************************************************************
// Variables communes d'affichage
//******************************************************************
$case_selected = "";


// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************
?>
<form action="courriers_choix_type_valid.php" method="post" id="form_courrier_choix_type" name="form_courrier_choix_type" target="formFrame" >
	<table width="100%" border="0">
		<tr>
			<td style="width:4%">
			<td style="width:20%">
			<td style="width:4%">
			<td style="width:20%">
			<td style="width:4%">
			<td style="width:20%">
			<td style="width:4%">
			<td style="width:20%">
			<td style="width:4%">
		</tr>
		<?php 
		$nb_modeles = count($modeles_pdf_du_type);
		$index_modele =0;
		
		//fait des lignes de 4 modelses.
		for($i=0; $i <floor($nb_modeles/4); $i++){	?> 
		<tr><?php 
		for($j = 1; $j<=4; $j++){ ?>
			<td></td>
			<td style="text-align:center;">
				<?php 
				$style_case_selected = "";
				if($id_pdf_modele_selected == $modeles_pdf_du_type[$index_modele]->id_pdf_modele){
					$style_case_selected =  "border:1px solid #809eb6;";
					$case_selected = "modele_".$index_modele;
				}else{
					$style_case_selected =  "border:0px solid #809eb6;";
				}
				?>
				<table border="0" width="100%">
					<tr>
						<td></td>
						<td id="modele_<?php echo $index_modele;?>" width="110px" style="text-align:center;<?php echo $style_case_selected; ?>" >
							<?php
							//@TODO COURRIER : modele pdf : une fois que les modeles seront définis et terminés, mettre une miniature du modele pdf ici en image
							?>
							<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/courrier_pdf.jpg" height="132" width="94" style="margin-top:8px;"/><br/>
							<div style="margin-bottom:5px; font-size:8pt; color:#671584;">
								<?php
								//On tronque lib_modele s'il est trop long
								$lib_modele = $modeles_pdf_du_type[$index_modele]->lib_modele;
								if(strlen($lib_modele)> 20)
									$lib_modele = substr($lib_modele, 0, 20)."...";
								echo $lib_modele;
								?>
							</div>
							
							<script type="text/javascript">
								Event.observe("modele_<?php echo $index_modele;?>", "click",  function(evt){
									Event.stop(evt);
									if($("case_selected").value != ""){
										$($("case_selected").value).style.borderWidth = "0px";
									}
									$('modele_<?php echo $index_modele;?>').style.borderWidth = "1px";
									$("case_selected").value = 'modele_<?php echo $index_modele;?>';
									$("id_pdf_modele").value = '<?php echo $modeles_pdf_du_type[$index_modele]->id_pdf_modele;?>';
								});
							</script>
						</td>
						<td></td>
					</tr>
				</table>
			</td>
			<?php 
				$index_modele++;
			} ?>
			<td></td>
		</tr>
		<?php
		}
		$nb_restant = $nb_modeles %4; //Si >0 alors, je fais une dernière ligne incomplete
		if ($nb_restant >0){ ?>
		<tr>
			<?php // des cellules avec un modele
				for($k=0; $k <$nb_restant; $k++){	?> 
			<td></td>
			<td style="text-align:center;">
				<?php 
				$style_case_selected = "";
				if($id_pdf_modele_selected == $modeles_pdf_du_type[$index_modele]->id_pdf_modele){
					$style_case_selected =  "border:1px solid #809eb6;";
					$case_selected = "modele_".$index_modele;
				}else{
					$style_case_selected =  "border:0px solid #809eb6;";
				}
				?>
				<table border="0" width="100%">
					<tr>
						<td></td>
						<td id="modele_<?php echo $index_modele;?>" width="110px" style="text-align:center;<?php echo $style_case_selected; ?>" >
							<?php
							//@TODO COURRIER : modele pdf : une fois que les modeles seront définis et terminés, mettre une miniature du modele pdf ici en image
							?>
							<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/courrier_pdf.jpg" height="132" width="94" style="margin-top:8px;"/><br/>
							<div style="margin-bottom: 5px;font-size:8pt; color:#671584;">
								<?php
								//On tronque lib_modele s'il est trop long
								$lib_modele = $modeles_pdf_du_type[$index_modele]->lib_modele;
								if(strlen($lib_modele)> 20)
									$lib_modele = substr($lib_modele, 0, 20)."...";
								echo $lib_modele;
								?>
							</div>
							
							<script type="text/javascript">
								Event.observe("modele_<?php echo $index_modele;?>", "click",  function(evt){
									Event.stop(evt);
									if($("case_selected").value != ""){
										$($("case_selected").value).style.borderWidth = "0px";
									}
									$('modele_<?php echo $index_modele;?>').style.borderWidth = "1px";
									$("case_selected").value = 'modele_<?php echo $index_modele;?>';
									$("id_pdf_modele").value = '<?php echo $modeles_pdf_du_type[$index_modele]->id_pdf_modele;?>';
								});
							</script>
						</td>
						<td></td>
					</tr>
				</table>
			</td>
			<?php
				$index_modele++;
	 			} // des cellules vides
				for($l=0; $l <4-$nb_restant; $l++){	?>
			<td></td>
			<td style="text-align:center;">
				&nbsp;	
			</td>
			<?php } ?>
			<td></td>
		</tr>
		<?php } ?>
		
		<tr>
			<td >
			<td >
			<td >
			<td >
			<td >
			<td >
			<td >
			<td >
			<td >
		</tr>
	</table>
	
	<!-- Pour définir le type de mail et le modele PDF -->
	<input type="hidden" id="id_type_courrier" name="id_type_courrier" value="<?php echo $id_type_courrier_selected; ?>" />
	<input type="hidden" id="id_pdf_modele" name="id_pdf_modele" value="<?php echo $id_pdf_modele_selected; ?>" />
	
	<!-- input pour mémoriser la case cochée -->
	<input type="hidden" id="case_selected" name="case_selected" value="<?php echo $case_selected; ?>" />
	
	<!-- Page source et Page cible -->
	<input type="hidden" id="page_source" name="page_source" value="<?php echo $page_source; ?>" />
	<input type="hidden" id="page_cible" name="page_cible" value="<?php echo $page_cible; ?>" />
	<input type="hidden" id="cible" name="cible" value="<?php echo $cible; ?>" />
	
	<input type="hidden" id="id_courrier" name="id_courrier" <?php if(isset($id_courrier)){echo 'value="'.$id_courrier.'"';}?> />
	<input type="hidden" id="ref_destinataire" name="ref_destinataire" value="<?php echo $ref_destinataire; ?>" />
</form>

<br/>
<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-valider.gif" id="valider_courrier_choix_type" style="cursor:pointer; float:right; padding-right: 20px" alt="Valider" title="Valider" />
<SCRIPT type="text/javascript">
	Event.observe("valider_courrier_choix_type", "click", function(evt){
		Event.stop(evt);
		$("form_courrier_choix_type").submit();
		}, false);
</SCRIPT>
<br/>


<SCRIPT type="text/javascript">
//on masque le chargement
H_loading();
</SCRIPT>