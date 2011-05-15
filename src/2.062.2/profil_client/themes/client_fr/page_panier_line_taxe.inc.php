<?php

// *************************************************************************************************************
// CONTROLE DU THEME
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

?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="document_line">
	<tr>
		<td style="width:28px">
			<div style="width:28px;">
			</div>
		</td>
		<td style="width:110px" class="document_border_right">
			<div style="width:107px;">
			<input value="<?php echo $contenu->ref_doc_line;?>" id="ref_doc_line_<?php echo $indentation_contenu?>" name="ref_doc_line_<?php echo $indentation_contenu?>" type="hidden"/>
			<input value="<?php echo $contenu->ref_article;?>" id="ref_article_<?php echo $indentation_contenu?>" name="ref_article_<?php echo $indentation_contenu?>" type="hidden"/>
			<input value="<?php echo $contenu->ref_oem;?>" id="ref_oem_<?php echo $indentation_contenu?>" name="ref_oem_<?php echo $indentation_contenu?>" type="hidden"/>
			<input value="<?php echo $contenu->ref_interne;?>" id="ref_interne_<?php echo $indentation_contenu?>" name="ref_interne_<?php echo $indentation_contenu?>" type="hidden"/>
			<input value="<?php echo $contenu->valo_indice;?>" id="valo_indice_<?php echo $indentation_contenu?>" name="valo_indice_<?php echo $indentation_contenu?>" type="hidden"/>
			<input value="<?php echo $contenu->gestion_sn;?>" id="gestion_sn_<?php echo $indentation_contenu?>" name="gestion_sn_<?php echo $indentation_contenu?>" type="hidden"/>
			<input value="<?php echo $contenu->lot;?>" id="lot_<?php echo $indentation_contenu?>" name="lot_<?php echo $indentation_contenu?>" type="hidden"/>
			<input value="<?php echo $contenu->ordre;?>" id="ordre_<?php echo $indentation_contenu?>" name="ordre_<?php echo $indentation_contenu?>" type="hidden"/>
			<input value="<?php echo $contenu->ref_doc_line_parent;?>" id="ref_doc_line_parent_<?php echo $indentation_contenu?>" name="ref_doc_line_parent_<?php echo $indentation_contenu?>" type="hidden"/>
			</div>
		</td>
		<td style="width:280px; padding-left:3px">
			<div style="width:277px;" class="doc_small_ita">
			dont Taxes <?php echo htmlentities($contenu->lib_article);?>
			</div>
		</td>
		<td style="width:27px" class="document_border_right">
			<div style="width:27px;">
			</div>
		</td>
		<td style="width:70px; text-align:center;" class="document_border_right">
			<div style="width:70px;">
			</div>			
		</td>
		<?php if ($id_type_doc == $COMMANDE_CLIENT_ID_TYPE_DOC) {?>	
		<td style="width:70px; text-align:center;" class="document_border_right">
			<div style="width:70px;">
			</div>
		</td>
		<?php } ?>
		<?php if ($id_type_doc == $COMMANDE_FOURNISSEUR_ID_TYPE_DOC) {?>	
		<td style="width:70px; text-align:center;" class="document_border_right">
			<div style="width:70px;">
			</div>
		</td>
		<?php } ?>
		<td style="width:70px; text-align:right;" class="document_border_right">
			<div style="width:70px;">
			<span style=" padding-right:8px;" class="doc_small_ita">
			<?php echo  number_format($contenu->pu_ht,$TARIFS_NB_DECIMALES, ".", "");?>
			</span>
			</div>
		</td>
		<?php if ($AFF_REMISES) {?>
			<td style="width:70px" class="document_border_right">
			<div style="width:70px;">
			</div>
			</td>
			<?php }  else {?>
			<td style="width:0px; text-align:center">
			</td>
		<?php } ?>
		<td style="width:70px; text-align:center;" class="document_border_right">
			<div style="width:70px;">
			</div>
		</td>
		<td style="width:70px; text-align:center;" class="document_border_right">
			<div style="width:70px;">
			</div>
		</td>
		<td>
		<div style="text-align:center">
		<table cellpadding="0" cellspacing="0" border="0" style="width:100%;">
			<tr>
				<td>
					<div style="width:25px; text-align:right;">
					<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/visible.gif" id="visible_<?php echo $indentation_contenu?>" style=" cursor:pointer; float:right; display: <?php if ( $contenu->visible) {echo "block";} else { echo "none";}?>" alt="Visible"/>
					<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/unvisible.gif" id="unvisible_<?php echo $indentation_contenu?>" style="cursor:pointer; float:right; display: <?php if (!$contenu->visible) {echo "block";} else { echo "none";}?>" alt="Invisible"/>
					</div>
				</td>
				<td  style="text-align:right";>
					<div style="width:25px;">
					</div>
				</td>
				<td  style="text-align:right";>
					<div style="width:25px;">
					</div>
				</td>
			</tr>
		</table>
		</div>
		</td>
	</tr>
</table>
<script type="text/javascript">
pre_start_taxes_line ("<?php echo htmlentities($contenu->ref_article)?>", "<?php echo $contenu->ref_doc_line?>", "<?php echo $indentation_contenu?>");
</script>