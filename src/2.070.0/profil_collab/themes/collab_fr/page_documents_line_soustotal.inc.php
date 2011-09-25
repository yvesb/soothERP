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
		<td style="width:28px;">
			<div style="width:28px;">
			<input id="check_<?php echo $indentation_contenu?>" name="check_<?php echo $indentation_contenu?>" type="checkbox" value="check_line" />
			</div>
		</td>
		<td style="width:110px" class="document_border_right">
			<div style="width:107px;" class="doc_bold">Sous-total
			<input value="<?php echo $contenu->ref_doc_line;?>" id="ref_doc_line_<?php echo $indentation_contenu?>" name="ref_doc_line_<?php echo $indentation_contenu?>" type="hidden"/>
			<input value="<?php echo $contenu->ref_article;?>" id="ref_article_<?php echo $indentation_contenu?>" name="ref_article_<?php echo $indentation_contenu?>" type="hidden"/>
			<input value="<?php echo $contenu->ordre;?>" id="ordre_<?php echo $indentation_contenu?>" name="ordre_<?php echo $indentation_contenu?>" type="hidden"/>
			<input value="<?php echo $contenu->ref_doc_line_parent;?>" id="ref_doc_line_parent_<?php echo $indentation_contenu?>" name="ref_doc_line_parent_<?php echo $indentation_contenu?>" type="hidden"/>
			</div>
		</td>
		<td style="width:285px; padding-left:3px">
			<div style="width:285px;">
			<?php 
			if (substr_count($contenu->lib_article, "<br />") || substr_count($contenu->lib_article, "\n")) {
				?>
				<textarea id="lib_article_<?php echo $indentation_contenu?>" rows="1" name="lib_article_<?php echo $indentation_contenu?>" type="text" class="classinput_xsize"><?php 
				if (isset($line_insert)) {
					echo (str_replace("<br />","\n",$contenu->lib_article));
				} else {
					echo htmlentities(str_replace("<br />","\n",$contenu->lib_article));
				}
				?></textarea>
				<div id="lib_article_old_<?php echo $indentation_contenu?>" style="display:none"><?php echo htmlentities(str_replace("<br />","\n",$contenu->lib_article));?></div>
				<?php 
				} else { 
				?>
				<input id="lib_article_<?php echo $indentation_contenu?>" name="lib_article_<?php echo $indentation_contenu?>" type="text" class="classinput_xsize" value="<?php
				if (isset($line_insert)) {
					echo ($contenu->lib_article);
				} else {
					echo htmlentities($contenu->lib_article);
				}
				?>" />
				<div id="lib_article_old_<?php echo $indentation_contenu?>" style="display:none"><?php echo htmlentities($contenu->lib_article);?></div>
				<?php
			}
			?>
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
		<?php if ($id_type_doc == $COMMANDE_CLIENT_ID_TYPE_DOC || ($id_type_doc == $DEVIS_CLIENT_ID_TYPE_DOC && !empty($USE_PA_HT_FORCED))) {?>
		<td style="width:50px; text-align:center;" class="document_border_right">
			<div style="width:50px;">
			</div>
		</td>
		<?php } ?>
		<?php if ($id_type_doc == $COMMANDE_FOURNISSEUR_ID_TYPE_DOC) {?>	
		<td style="width:50px; text-align:center;" class="document_border_right">
			<div style="width:50px;">
			</div>
		</td>
		<?php } ?>
		<td style="width:70px; text-align:center" class="document_border_right">
			<div style="width:70px;"></div>
		</td>
		<?php if ($AFF_REMISES) {
                            if($id_type_doc == $COMMANDE_FOURNISSEUR_ID_TYPE_DOC || $id_type_doc == $COMMANDE_CLIENT_ID_TYPE_DOC){?>
                            <td style="width:65px; text-align:center" class="document_border_right">
                            <div style="width:65px;">
                            </div>
                            </td>
                            <?php }  else {?>
                            <td style="width:70px; text-align:center" class="document_border_right">
                            <div style="width:70px;">
                            </div>
                            </td>
                            <?php }
                        }  else {?>

			<td style="width:0px; text-align:center">
			</td>
		<?php } ?>
		<td style="width:70px; text-align:center" class="document_border_right">
			<div style="width:70px;">
			</div>
		</td>
		<td style="width:70px; text-align:right" class="document_border_right">
			<div style="width:70px;">
			<div id="ss_toto_<?php echo $indentation_contenu?>" class="doc_bold" style=" padding-right:8px;"></div>
			
			<input value="<?php echo number_format($contenu->pu_ht, $CALCUL_TARIFS_NB_DECIMALS, ".", ""	);?>" id="pu_ht_<?php echo $indentation_contenu?>" name="pu_ht_<?php echo $indentation_contenu?>" type="hidden"/>
			<input value="<?php echo number_format($contenu->pu_ht, $CALCUL_TARIFS_NB_DECIMALS, ".", ""	);?>" id="pu_ht_old_<?php echo $indentation_contenu?>" name="pu_ht_old_<?php echo $indentation_contenu?>" type="hidden"/>
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
				<td style="text-align:right;">
					<div style="width:25px;text-align:right" class="documents_li_handle" >
						<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/main.gif" id="move_doc_line_<?php echo $indentation_contenu?>"/>
					</div>
				</td>
				<td style="text-align:right;">
					<div style="width:25px;">
					</div>
				</td>
				<td style="text-align:right;">
					<div style="width:25px;">
					<a href="#" id="sup_<?php echo $indentation_contenu?>"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/supprime.gif" border="0">		
					</a>
					</div>
				</td>
			</tr>
		</table>
		</div>
		</td>
	</tr>
</table>
<script type="text/javascript">
pre_start_sstotal_line ("<?php echo htmlentities($contenu->ref_article)?>", "<?php echo $contenu->ref_doc_line?>", "<?php echo $indentation_contenu?>");
</script>