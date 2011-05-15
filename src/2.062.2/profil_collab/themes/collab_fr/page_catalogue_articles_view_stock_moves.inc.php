<?php

// *************************************************************************************************************
// AFFICHAGE DES MOUVEMENTS DE STOCK
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
<script type="text/javascript">
</script>
<div >
<table width="100%" border="0" cellspacing="0" cellpadding="0">

<?php 
$colorise=0;
foreach ($art_stocks_moves as $art_stock_move) {
		$id_type_groupe = document::Id_type_groupe($art_stock_move->id_type_doc);
		if ( ($_SESSION['user']->check_permission ("25", $art_stock_move->id_type_doc) && $id_type_groupe==1) || ($_SESSION['user']->check_permission ("28", $art_stock_move->id_type_doc) && $id_type_groupe==2) || ($_SESSION['user']->check_permission ("31", $art_stock_move->id_type_doc) && $id_type_groupe==3)){
	
$colorise++;
$class_colorise= ($colorise % 2)? 'colorise1' : 'colorise2';
	?>
	
	<tr class="<?php  echo  $class_colorise?>">
		<td style="font-size:10px; text-align:left; width:100px;">
		<div style="text-align:left; width:100px;margin-left:10px;">
		<?php echo date_Us_to_Fr($art_stock_move->date);?> <?php echo getTime_from_date($art_stock_move->date);?>
		</div>
		</td>
		<td style="text-align:left;  width:120px;">
		<div style="text-align:left; width:120px;">
		<a href="#" id="doc_stock_move_<?php echo htmlentities($art_stock_move->ref_stock_move);?>" style="color:#000000; text-decoration:none"><?php echo htmlentities($art_stock_move->ref_doc);?></a>
		</div>
		<script type="text/javascript">
		Event.observe("doc_stock_move_<?php echo htmlentities($art_stock_move->ref_stock_move);?>", "click",  function(evt){
			Event.stop(evt); 
			page.verify('documents_edition','index.php#'+escape('documents_edition.php?ref_doc=<?php echo htmlentities($art_stock_move->ref_doc)?>'),'true','_blank');
		}, false);
		</script>
		</td>
		<td style="text-align:left;">
		<div style="text-align:left;">
		<?php echo htmlentities($art_stock_move->lib_etat_doc);?>
		</div>
		</td>
		<td style="font-size:10px; padding-left:10px; text-align:left; width:170px;">
		<div style="text-align:left; width:170px;">			
		<?php if (isset($art_stock_move->nom_contact_doc)) { 
			?>
			<div style="width:170px">
			<a href="#" id="contact_doc_stock_move_<?php echo htmlentities($art_stock_move->ref_stock_move);?>" style="color:#000000; text-decoration:none">
				<?php echo htmlentities($art_stock_move->nom_contact_doc); ?></a>
			</div>
			<script type="text/javascript">
			Event.observe("contact_doc_stock_move_<?php echo htmlentities($art_stock_move->ref_stock_move);?>", "click",  function(evt){
				Event.stop(evt); 
				page.verify('annuaire_view_fiche','index.php#'+escape('annuaire_view_fiche.php?ref_contact=<?php echo htmlentities($art_stock_move->ref_contact_doc)?>'),'true','_blank');
			}, false);
			</script>
			<?php
		}
		?>
		</div>
		</td>
		<td style="font-size:10px; padding-left:10px; text-align:left; width:150px;">
		<div style="text-align:left; width:150px;">			
		<?php if (isset($art_stock_move->nom)) { 
			?>
			<div style="width:170px">
			<a href="#" id="contact_stock_move_<?php echo htmlentities($art_stock_move->ref_stock_move);?>" style="color:#000000; text-decoration:none">
				<?php echo htmlentities($art_stock_move->nom); ?></a>
			</div>
			<script type="text/javascript">
			Event.observe("contact_stock_move_<?php echo htmlentities($art_stock_move->ref_stock_move);?>", "click",  function(evt){
				Event.stop(evt); 
				page.verify('annuaire_view_fiche','index.php#'+escape('annuaire_view_fiche.php?ref_contact=<?php echo htmlentities($art_stock_move->ref_contact)?>'),'true','_blank');
			}, false);
			</script>
			<?php
		}
		?>
		</div>
		</td>
		<td style="font-size:10px; padding-right:60px; text-align:right; width:80px;">
		<div style="text-align:right; width:80px;">
			<?php echo htmlentities($art_stock_move->qte);?>
		</div>
		</td>
		<td style="font-size:10px; text-align:right; width:120px;">
		<div style="text-align:left; width:120px;">
			<?php
			if ($art_stock_move->abrev_stock) {
			echo htmlentities($art_stock_move->abrev_stock);
			} else {
			echo htmlentities($art_stock_move->lib_stock);
			}
			?>
		</div>
		</td>
	</tr>
	<?php
	}
}
?>
</table>
<div style="text-align:left; cursor:pointer; text-decoration:underline" id="view_all_moves">
Voir tous les mouvements de l'article
</div>
</div>
<script type="text/javascript">
Event.observe('view_all_moves', "click", function(evt){
	page.verify('mouvements_de_stock_article','catalogue_articles_stocks_mouvements.php?ref_article=<?php echo $article->getRef_article()?>','true','sub_content');
	Event.stop(evt);
});
</script>