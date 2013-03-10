<?php
// *************************************************************************************************************
// AFFICHAGE DU TABLEAU DE BORD DES VENTES
// *************************************************************************************************************

// Variables nécessaires à l"affichage
$page_variables = array ();
check_page_variables ($page_variables);

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

?>
<script type="text/javascript">

	
</script><br />

<div  id="corps_tb22">
<div >
<div style="border-bottom:2px solid #999999" class="titre_ter_stat">
<?php 
switch($type_data) {
	case "magasins":
		?>Détail par Magasins
		<?php 
	break; 
	case "categ_client":
		?>Détail par Catégorie de Client
		<?php 
	break; 
	case "categ_comm":
		?>Détail par Catégorie de Commerciaux
		<?php 
	break; 
	case "art_categ":
		?>Détail par Catégorie d'articles
		<?php 
	break; 
}?>
</div>
<table style="width:100%; " cellpadding="0" cellspacing="0">
	<tr>
		<td style="text-align:left; padding-bottom:10px; padding-top:10px;">
		<?php 
		switch($type_data) {
			case "magasins":
				foreach ($liste_magasins as $mag) {
					?>
					<div  class="list_stat_link">
					<span style="float:right"><?php echo price_format($mag->CA)." ".$MONNAIE[1];?></span>
					<?php echo $mag->getLib_magasin();
					?><br />
					</div>
					<?php 
				}
			break; 
			case "categ_client":
				foreach ($liste_categories_client as $client) {
					?>
					<div  class="list_stat_link">
					<span style="float:right"><?php echo price_format($client->CA)." ".$MONNAIE[1];?></span>
					<?php echo $client->lib_client_categ;
					?><br />
					</div>
					<?php 
				}
			break; 
			case "categ_comm":
				foreach ($liste_categories_commercial as $comm) {
					?>
					<div  class="list_stat_link">
					<span style="float:right"><?php echo price_format($comm->CA)." ".$MONNAIE[1];?></span>
					<?php echo $comm->lib_commercial_categ;
					?><br />
					</div>
					<?php 
				}
			break; 
			case "art_categ":
			?>
				
				<div>
								<?php
								reset($list_art_categ);
								$tmplist_art_categ = $list_art_categ;
								while ($art_categ = current($list_art_categ) ){
									next($list_art_categ);
									?>
									
									<?php if ($art_categ->indentation == 0) { ?><br /><?php } ?>
									<table cellpadding="0" cellspacing="0"  id="<?php echo ($art_categ->ref_art_categ)?>" style="width:96%">
									<tr id="tr_<?php echo ($art_categ->ref_art_categ)?>" <?php if ($art_categ->indentation > 0) { ?> class="list_stock_art_categs_un"<?php } else { ?> class="list_stock_art_categs"<?php } ?>><td width="5px">
										<table cellpadding="0" cellspacing="0" width="5px"><tr><td>
										<?php 
										for ($i=0; $i<=$art_categ->indentation; $i++) {
											
											?>
											<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/inarbo.gif" width="18px"/></td><td>
											<?php 
											
										}
										?></td>
										</tr>
										</table>
										</td><td>
										<span>
										<div style=" width:85px; text-align:right; float:right">
											<?php
											$CA = $art_categ->CA;
											$pass_ref_art_categ = "";
											
											foreach ($tmplist_art_categ as $tmp_art_categ) {
												if ($tmp_art_categ->ref_art_categ == $art_categ->ref_art_categ) {$pass_ref_art_categ = $art_categ->ref_art_categ; continue;}
												if (!$pass_ref_art_categ) {continue;}
												if ($art_categ->indentation >= $tmp_art_categ->indentation) {$pass_ref_art_categ = ""; break;}
												$CA += $tmp_art_categ->CA;
											}
											
											 echo number_format($CA, $TARIFS_NB_DECIMALES, ".", ""	)."&nbsp;".$MONNAIE[1];
											 ?>
											 </div>
											<?php echo htmlentities($art_categ->lib_art_categ); if (!$art_categ->lib_art_categ) { echo "Pas de libellé";}?> 
											</span>
											</td>
										</tr>
									</table>
									<?php 
									if (key($list_art_categ)!="") {
										if ($art_categ->indentation < current($list_art_categ)->indentation) {
											echo '<div id="div_'.$art_categ->ref_art_categ.'" style="display: none">';
										}
										
										
										if ($art_categ->indentation > current($list_art_categ)->indentation) {
														for ($a=$art_categ->indentation; $a>current($list_art_categ)->indentation ; $a--) {
														echo '</div>';
													}
										}
									}
									
									}
									?>
								
								
	
<SCRIPT type="text/javascript">
<?php
reset ($list_art_categ);
$i=0;
foreach ($list_art_categ  as $art_categ){
	?>
	Event.observe('tr_<?php echo ($art_categ->ref_art_categ)?>', 'mouseover',  function(){changeclassname ('tr_<?php echo ($art_categ->ref_art_categ)?>', '<?php if ($art_categ->indentation > 0) { ?>list_stock_art_categs_un_hover<?php } else { ?> list_stock_art_categs_hover<?php } ?>');}, false);
	
	Event.observe('tr_<?php echo ($art_categ->ref_art_categ)?>', 'mouseout',  function(){changeclassname ('tr_<?php echo ($art_categ->ref_art_categ)?>', '<?php if ($art_categ->indentation > 0) { ?>list_stock_art_categs_un<?php } else { ?> list_stock_art_categs<?php } ?>');}, false);
	
	Event.observe('tr_<?php echo ($art_categ->ref_art_categ)?>', 'click',  function(evt){Event.stop(evt);
	if ($("div_<?php echo $art_categ->ref_art_categ?>")) {
		Element.toggle('div_<?php echo $art_categ->ref_art_categ?>') ; 
	}
	}, false);
	
	<?php 
	$i++;
}
?>
</SCRIPT>
				<?php 
			break; 
		}
		if ($CA_global) {
			?><br />

					<div  class="list_stat_link">
					<span style="float:right"><?php echo price_format($CA_global)." ".$MONNAIE[1];?></span>
					Non attribué<br />
					</div>
			<?php 
		}
		?>
		</td>
		<td style="text-align:center; padding-bottom:10px; padding-top:10px;">
				<script type="text/javascript">
				swfobject.embedSWF("open-flash-chart.swf", "my_chart_3", "250", "200", "9.0.0", "expressInstall.swf", {"data-file":"<?php echo urlencode("tableau_bord_ventes_tb2_3_data.php?type_data=".$type_data."&date_debut=".$date_debut."&date_fin=".$date_fin);?>", loading : "Chargement.." },{wmode: "transparent", quality: "high"}, {});
				</script>
 

				<div id="my_chart_3">
				</div>
		</td>
	</tr>
</table>
</div>


</div>
</div>

<SCRIPT type="text/javascript">
//on masque le chargement
H_loading();
</SCRIPT>