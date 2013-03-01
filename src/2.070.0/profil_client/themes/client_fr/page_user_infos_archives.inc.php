<?php

// *************************************************************************************************************
// CONTROLE DU THEME
// *************************************************************************************************************

// Variables nécessaires à l'affichage
$page_variables = array ();
check_page_variables ($page_variables);



// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************
?>
<?php if (count($docs_archives)) { ?>
<br />
<table border="0" cellspacing="0" cellpadding="0" style="  width:100%; height:18px">
  <tr>
  	<td class="doc_img_cadre1"></td>
  	<td style="background-color:#636363;"></td>
  	<td class="doc_img_cadre2"></td>
  </tr>
  <tr>
  	<td style="background-color:#636363;"></td>
  	<td style="background-color:#636363; padding:5px" >
  	
  	<table width="100%" border="0" cellspacing="0" cellpadding="0">
  		<?php 
  		foreach ($docs_archives as $doc_archive) {
  		?>
  		<tr>
  			<td class="doc_infos_colors" ><?php echo date_Us_to_Fr($doc_archive->getDate_creation());?></td>
  			<td class="doc_infos_colors"><?php echo $doc_archive->getRef_doc();?></td>
  			<td class="doc_infos_colors" style="text-align:right; padding-right:15px"><?php echo number_format($doc_archive->getMontant_ttc(), $TARIFS_NB_DECIMALES, ".", ""	)." ".$MONNAIE[1]; ?></td>
  			<td class="doc_infos_colors">&nbsp;</td>
  			<td class="doc_infos_colors"><a href="documents_editing_print.php?ref_doc=<?php echo $doc_archive->getRef_doc();?>&code_pdf_modele=<?php echo $CODE_PDF_MODELE_DEV;?>" target="_blank" ><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-pdf.gif"/></a> </td>
  		</tr>
  		<?php 
  		}
  		?>
  	</table>
  
  	
  	</td>
  	<td style="background-color:#636363;"></td>
  </tr>
  <tr>
  	<td class="doc_img_cadre3"></td>
  	<td style="background-color:#636363;"></td>
  	<td class="doc_img_cadre4"></td>
  </tr>
</table>

<?php 
}
?>