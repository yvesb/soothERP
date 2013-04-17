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
			</div>
		</td>
		<td style="width:110px" class="document_border_right">
			<div style="width:107px;">
			<a href="catalogue_article_view.php?ref_article=<?php echo $contenu->ref_article;?>&" style="text-decoration:none; color:#000000; font-size:9px" id="link_to_art_<?php echo $indentation_contenu?>">
			<?php if ($contenu->ref_interne != "") { echo $contenu->ref_interne;} else { echo $contenu->ref_article;} ?></a>
			<br />
			<?php echo $contenu->ref_oem;?>
			<input value="<?php echo $contenu->ref_doc_line;?>" id="ref_doc_line_<?php echo $indentation_contenu?>" name="ref_doc_line_<?php echo $indentation_contenu?>" type="hidden"/>
			<input value="<?php echo $contenu->ref_article;?>" id="ref_article_<?php echo $indentation_contenu?>" name="ref_article_<?php echo $indentation_contenu?>" type="hidden"/>
			</div>
		</td>
		<td style=" width:250px; padding-left:3px">
			<div style="width:250px;">
			<?php 
			if (substr_count($contenu->lib_article, "<br />") || substr_count($contenu->lib_article, "\n")) {
					echo str_replace("&curren;", "&euro;",(str_replace("<br />","\n",$contenu->lib_article)));
				?>
				</div>
				<?php 
				} else { 
						echo str_replace("&curren;", "&euro;",($contenu->lib_article));
			}
			?>
			
			<div id="div_desc_article_<?php echo $indentation_contenu?>" style="display:<?php if ($contenu->desc_article == "") { echo"none";} else {echo "block";}?>">
			<div style="height:3px; line-height:3px;"></div>
			<?php
				if (isset($line_insert)) {
					echo (str_replace("<br />","\n",$contenu->desc_article));
				} else {
					echo str_replace("&curren;", "&euro;",(str_replace("<br />","\n",$contenu->desc_article)));
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
		<td style="width:70px; text-align:center" class="document_border_right">
			<div style="width:70px;">
			<?php // echo number_format($contenu->pu_ht, $CALCUL_TARIFS_NB_DECIMALS, ".", ""	);?>
			</div>
		</td>
		<td style="" class="document_border_right">
			<div style="width:25px;">
			</div>
		</td>
	</tr>
</table>
<script type="text/javascript">
</script>