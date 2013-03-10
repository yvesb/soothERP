<?php 
// *************************************************************************************************************
// VISUALISATION DES COTATIONS D'UN CONTACT
// *************************************************************************************************************

// Variables nécessaires à l'affichage
$page_variables = array ();
check_page_variables ($page_variables);

if (count($liste_cotations_contact)>0){
	?>
	<div>
	<BR>
<div  class="articletview_corps" style="width: 1022px;">
	
	<table cellspacing="0" cellpadding="0" border="0" width="100%">
<tbody>
<tr>
<td style="width: 35px;">
<div style="border-bottom: 1px solid rgb(0, 51, 108); height: 9px;"> </div>
</td>
<td style="width: 85px; font-weight: bolder; color: rgb(0, 51, 108); font-size: 14px; padding-left: 3px; padding-right: 3px;">COTATIONS</td>
<td>
<div style="border-bottom: 1px solid rgb(0, 51, 108); height: 9px;"> </div>
</td>
</tr>
</tbody>
</table>
	
	
	<table width="100%">
	<tr>
		<td colspan="5"><B> Client <?php echo $contact->getRef_contact()?> - <?php echo $contact->getNom() ?></B></td>
	</tr>
		<tr>
		<td colspan="5"></td>
	</tr>
	<tr>
		<td style="text-align: left; padding-left: 5px; font-weight: bolder;">Date</td>
		<td style="text-align: left; padding-left: 5px; font-weight: bolder;">Article</td>
		<td style="text-align: left; padding-left: 5px; text-align: center; font-weight: bolder;">Quantité</td>
		<td style="text-align: left; padding-left: 5px; text-align: center; font-weight: bolder;">Expiration</td>
		<td style="text-align: left; padding-left: 5px; font-weight: bolder;">Action</td>
	</tr>
	<?php 
	$indentation = 0;
		foreach ($liste_cotations_contact as $cotation){
			$article = new article($cotation->ref_article);
	?>
	<tr>
		<td><?php echo htmlentities(date_Us_to_Fr($cotation->date_creation_doc));?></td>
		<td><A href="#" class="common_link" id="link_article_<?php echo $indentation?>"><?php echo $cotation->ref_article?> - <?php echo $article->getLib_article()?></A></td>
		<script type="text/javascript">
		Event.observe("link_article_<?php echo $indentation?>", "click",  function(evt){Event.stop(evt);page.verify('affaires_affiche_fiche','index.php#catalogue_articles_view.php?ref_article=<?php echo ($cotation->ref_article)?>','true','_blank');}, false);
		</script>
		<td style="text-align: center;"><?php echo $cotation->qte?></td>
		<td style="text-align: center;"><?php echo htmlentities(date_Us_to_Fr($cotation->date_echeance));?></td>
		<td><a href="#"  class="common_link" id="open_cot_<?php echo $indentation?>">Modifier</a></td>
		<SCRIPT type="text/javascript">
		Event.observe("open_cot_<?php echo $indentation?>", "click",  function(evt){Event.stop(evt); page.verify('documents_edition','<?php echo $DIR.$_SESSION['profils'][3]->getDir_profil ();?>index.php#'+escape('documents_edition.php?ref_doc=<?php echo htmlentities($cotation->ref_doc)?>'),'true','_blank');}, false);
		</script>
	</tr>
	<?php 
		$indentation++;
		}
		?>
	</table>	
	<BR>
	</div>
	<div>
<?php 
}
?>