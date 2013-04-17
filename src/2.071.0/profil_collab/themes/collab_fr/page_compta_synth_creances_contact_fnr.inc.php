<?php

// *************************************************************************************************************
// AFFICHAGE DES FACTURES CLIENTS NON REGLEES
// *************************************************************************************************************

// Variables nécessaires à l'affichage
$page_variables = array ();
check_page_variables ($page_variables);


//******************************************************************
// Variables communes d'affichage
//******************************************************************


$factures_total = 0;

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

?>
<script type="text/javascript">
dir_profil_fac_np = "<?php echo $_ENV['CHEMIN_ABSOLU'].$_SESSION['profils'][$_SESSION['user']->getId_profil ()]->getDir_profil();?>"

infos_niveau_relance = new Array();

<?php 
foreach ($liste_niveaux_relance as $niveau_relance) {
	?>
infos_niveau_relance[<?php echo $niveau_relance->id_niveau_relance;?>] = "<?php echo htmlentities($niveau_relance->lib_niveau_relance);?>";
	<?php 
}
?>
</script>
<div style="width:99%;">
	<div style="padding:10px">
	
		<table width="100%" border="0" cellspacing="0" cellpadding="0" class="document_box_head">
			<tr>
				<td style="width:25px; height:24px; line-height:24px;" valign="middle">
					<div style="width:25px;">
					
					</div>
				</td>
				<td style="font-weight:bolder; width:118px">
				R&eacute;f&eacute;rence
				</td>
				<td style="font-weight:bolder;text-align:left;">
				Client
				
				</td>
				<td style="font-weight:bolder; text-align:center; width:90px;">
				Cr&eacute;ation
				</td>
				<td style="font-weight:bolder; text-align:center; width:90px;">
				Ech&eacute;ance
				</td>
				<td style="font-weight:bolder; text-align:center; width:170px;">
				Niveau relance<br />
				Date de relance
				</td>
				<td style="font-weight:bolder; width:100px; text-align:right">
				Montant<br />restant dû
				</td>
				<td style="font-weight:bolder; width:70px; text-align:right;">
				<div style="padding-right:1px">
				Magasin
				</div>
				</td>
				<td class="document_border_right" style="width:95px; text-align:right">&nbsp;
				
				</td>
			</tr>
		</table><br />
	<?php if (count($factures)) {?>
		<ul id ="factures_<?php echo $factures[0]->id_niveau_relance?>" style="width:100%">
	<?php
	$indentation = 0;
	$groupe_by_relance = $factures[0]->id_niveau_relance;
	foreach ($factures as $facture) {
		if ($groupe_by_relance != $facture->id_niveau_relance && $indentation != 0) {
		
			?>
			<table width="100%" border="0" cellspacing="0" cellpadding="0" class="">
				<tr>
					<td rowspan="2" style="width:33px">
						<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/arrow_ltr.png" />
					</td>
					<td style="height:4px; line-height:4px">
					<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="4px" width="100%"/>
					</td>
					<td style="height:4px; line-height:4px">
					<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="4px" width="100%"/>
					</td>
				</tr>
				<tr>
					<td style="width:325px;">
						<a href="#" id="all_coche_<?php echo $groupe_by_relance?>" class="doc_link_simple">Tout cocher</a> / <a href="#" id="all_decoche_<?php echo $groupe_by_relance?>" class="doc_link_simple">Tout d&eacute;cocher</a> / <a href="#" id="all_inv_coche_<?php echo $groupe_by_relance?>" class="doc_link_simple">Inverser la s&eacute;lection</a> 
					</td>
					<td style="" >
						<select id="coche_action_<?php echo $groupe_by_relance?>" name="coche_action_<?php echo $groupe_by_relance?>" class="classinput_nsize">
							<option value="">Pour la s&eacute;lection</option>
							<option value="0">Non transmise</option>
							<?php 
							foreach ($liste_niveaux_relance as $niveau_relance) {
								?>
								<option value="<?php echo $niveau_relance->id_niveau_relance;?>"><?php echo htmlentities($niveau_relance->lib_niveau_relance);?></option>
								<?php
							}
							?>
							<OPTGROUP disabled="disabled" label="_____________________________" ></OPTGROUP>
							<option value="print">Imprimer</option>
						</select>
					</td>
				</tr>
			</table><br />
			<script type="text/javascript">
			prestart_coche_liste_fac_np("<?php echo $groupe_by_relance?>");			
			
Event.observe("coche_action_<?php echo $groupe_by_relance?>", "change", function(evt){
	if ($("coche_action_<?php echo $groupe_by_relance?>").value != "") {
		action_FAC_np($("coche_action_<?php echo $groupe_by_relance?>").value, "" , "factures_");
	}
});
			</script>
			</ul>
			<?php
			$groupe_by_relance = $facture->id_niveau_relance;
			?>
			<ul id ="factures_<?php echo $groupe_by_relance?>" style="width:100%">
			<?php
		}
		?>
		<li id="lifactures_<?php echo $indentation;?>" class="" style="height:34px; line-height:34px; width:100%">
		<table width="100%" border="0" cellspacing="0" cellpadding="0" class="document_box_head">
			<tr>
				<td style="width:25px; height:24px; line-height:24px;" valign="middle">
					<div style="width:25px;">
						<input id="check_<?php echo $indentation;?>" name="check_<?php echo $indentation;?>" type="checkbox" value="check_line"/>
						<input id="refdoc_<?php echo $indentation;?>" name="refdoc_<?php echo $indentation;?>" type="hidden" value="<?php echo htmlentities($facture->ref_doc);?>"/>
					</div>				</td>
				<td style="width:118px">
				<a href="#" id ="<?php echo htmlentities($facture->ref_doc);?>" style="text-decoration:none; color:#000000; font-size:10px">
				<?php echo htmlentities($facture->ref_doc);?><br />
				<span <?php if ($facture->id_etat_doc == 16) {?>style="color:#FF0000"<?php } ?>>
				<?php echo htmlentities(($facture->lib_etat_doc));?>				</span>				</a>
				</td>
				<td style="text-align:left; ">
				<a href="#" id ="<?php echo htmlentities($facture->ref_doc);?>ctc" style="text-decoration:none; color:#000000"><?php  echo htmlentities(substr($facture->nom_contact, 0 , 42));?>...
				</a>&nbsp;
				</td>
				<td style=" text-align:center; width:90px;">
				<?php echo htmlentities(date_Us_to_Fr($facture->date_creation));?>
				</td>
				<td style=" text-align:center; width:90px;">
				<span style="<?php
														if (round(strtotime($facture->date_echeance)-strtotime(date("c")))<0) {?> color:#FF0000;<?php }
														 ?>">
				<?php echo htmlentities(date_Us_to_Fr($facture->date_echeance));?>				</span>				</td>
				<td style=" text-align:center; width:170px;">
				<div id="niveau_relance_<?php echo $indentation;?>" style="cursor:pointer">
				<?php 
				if ($facture->id_niveau_relance != NULL) {
					?>
				<?php echo htmlentities(($facture->lib_niveau_relance));?>
					<?php } else { ?>
					Non transmise
					<?php 
				}
				?>
				</div>
				<div style="position:relative;top:0px; left:0px; width:100%;">
				<div id="choix_niveau_relance_<?php echo $indentation;?>" style="display:none; text-align: left; border:1px solid #000000; background-color:#FFFFFF; position: absolute; left:0px; width:180px">
				<a class="choix_etat" id="choix_niveau_relance_0_<?php echo $indentation;?>">Non transmise</a>
					
				<?php 
				foreach ($liste_niveaux_relance as $niveau_relance) {
					?>
					<a class="choix_etat" id="choix_niveau_relance_<?php echo $niveau_relance->id_niveau_relance;?>_<?php echo $indentation;?>"><?php echo htmlentities($niveau_relance->lib_niveau_relance);?></a>
					<?php
				}
				?>
				<script type="text/javascript">
				<?php 
				foreach ($liste_niveaux_relance as $niveau_relance) {
					?>
					prestart_choix_niveau_relance ("<?php echo $niveau_relance->id_niveau_relance;?>", "<?php echo $indentation;?>", "<?php echo htmlentities($facture->ref_doc)?>", infos_niveau_relance[<?php echo $niveau_relance->id_niveau_relance;?>]);
					<?php
				}
				?>
				</script>
				</div>
				</div>
				<script type="text/javascript">
					prestart_ligne_fac_np (dir_profil_fac_np+"#","<?php echo htmlentities($facture->ref_doc);?>",  "<?php echo htmlentities($facture->ref_contact)?>", "<?php echo $indentation;?>");
				</script>
				<?php echo htmlentities(date_Us_to_Fr($facture->date_next_relance));?></td>
				<td style="font-weight:bolder;width:100px; text-align:right">&nbsp;
				
				<?php 
				echo (number_format($facture->montant_ttc, $TARIFS_NB_DECIMALES, ".", ""	)." ".$MONNAIE[1]);
				$factures_total += $facture->montant_ttc;
				?>
				</td>
				<td style="width:70px; text-align:right; padding-right:10px">&nbsp;
				
				<?php echo  htmlentities(($facture->abrev_magasin));?>				</td>
				<td class="document_border_right" style="width:95px; text-align:right">
					 <a href="#" id="mail_doc_<?php echo $facture->ref_doc?>" ><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-email-doc.gif"/></a> 
					 <a href="documents_editing.php?ref_doc=<?php echo $facture->ref_doc?>" target="_blank" ><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-pdf.gif"/></a> 
					<a href="documents_editing.php?ref_doc=<?php echo $facture->ref_doc?>&print=1" target="_blank" ><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/icone_imprime.gif" alt="Imprimer" title="Imprimer"/></a>
				
					<script type="text/javascript">
					Event.observe("mail_doc_<?php echo $facture->ref_doc?>", "click", function(evt){
					Event.stop(evt);
					var top=(screen.height-350)/2;
					var left=(screen.width-500)/2;
 					window.open("documents_editing_email.php?ref_doc=<?php echo $facture->ref_doc?>&mode_edition=2","","top="+top+",left="+left+",width=500,height=350,menubar=no,statusbar=no,scrollbars=yes,resizable=yes");
					});		
					</script>
				</td>
			</tr>
		</table>
		<br />
		</li>
		<?php 
	$indentation++;
	}
		?>
			<table width="100%" border="0" cellspacing="0" cellpadding="0" class="">
				<tr>
					<td rowspan="2" style="width:33px">
						<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/arrow_ltr.png" />
					</td>
					<td style="height:4px; line-height:4px">
					<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="4px" width="100%"/>
					</td>
					<td style="height:4px; line-height:4px">
					<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="4px" width="100%"/>
					</td>
				</tr>
				<tr>
					<td style="width:325px;">
						<a href="#" id="all_coche_<?php echo $facture->id_niveau_relance?>" class="doc_link_simple">Tout cocher</a> / <a href="#" id="all_decoche_<?php echo $facture->id_niveau_relance?>" class="doc_link_simple">Tout d&eacute;cocher</a> / <a href="#" id="all_inv_coche_<?php echo $facture->id_niveau_relance?>" class="doc_link_simple">Inverser la s&eacute;lection</a> 
					</td>
					<td style="" >
						<select id="coche_action_<?php echo $facture->id_niveau_relance?>" name="coche_action_<?php echo $groupe_by_relance?>" class="classinput_nsize">
							<option value="">Pour la s&eacute;lection</option>
							<option value="0">Non transmise</option>
							<?php 
							foreach ($liste_niveaux_relance as $niveau_relance) {
								?>
								<option value="<?php echo $niveau_relance->id_niveau_relance;?>"><?php echo htmlentities($niveau_relance->lib_niveau_relance);?></option>
								<?php
							}
							?>
							<OPTGROUP disabled="disabled" label="_____________________________" ></OPTGROUP>
							<option value="print">Imprimer</option>
						</select>
					</td>
				</tr>
			</table><br />
			<script type="text/javascript">
			prestart_coche_liste_fac_np("<?php echo $facture->id_niveau_relance?>");	
Event.observe("coche_action_<?php echo $groupe_by_relance?>", "change", function(evt){
	if ($("coche_action_<?php echo $groupe_by_relance?>").value != "") {
		action_FAC_np($("coche_action_<?php echo $groupe_by_relance?>").value, "" , "factures_<?php echo $groupe_by_relance?>");
	}
});		
			</script>
	</ul>
		<?php
		}
	?>

		<table width="100%" border="0" cellspacing="0" cellpadding="0" class="document_box_head">
			<tr>
				<td style="width:25px; height:24px; line-height:24px;" valign="middle">
					<div style="width:25px;">
					
					</div>
				</td>
				<td style="font-weight:bolder; width:118px">&nbsp;
				</td>
				<td style="font-weight:bolder;text-align:left;">&nbsp;
				</td>
				<td style="font-weight:bolder; text-align:center; width:90px;">&nbsp;
				</td>
				<td style="font-weight:bolder; text-align:right; width:240px;">&nbsp;
				Montant Total dû: 
				</td>
				<td style="font-weight:bolder; width:100px; text-align:right">
				<?php echo(number_format($factures_total, $TARIFS_NB_DECIMALES, ".", ""	)." ".$MONNAIE[1]);?>
				</td>
				<td style="font-weight:bolder; width:70px; text-align:right;">&nbsp;
				</td>
				<td class="document_border_right" style="width:95px; text-align:right">&nbsp;
				
				</td>
			</tr>
		</table>
	</div>
</div>
<script type="text/javascript">
//on masque le chargement
H_loading();
</script>