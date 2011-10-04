<?php

// *************************************************************************************************************
// Tableau de BORD stock
// *************************************************************************************************************

// Variables nécessaires à l"affichage
$page_variables = array ();
check_page_variables ($page_variables);

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

?>
<script type="text/javascript">

	
</script>
<div class="emarge">

<table style="width:100%">
<tr>
	<td>
		<div class="titre" style=" padding-left:140px;"><?php echo $stock->getLib_stock (); ?> -  Tableau de bord</div>
	</td>
	<td style="width:20%; vertical-align: bottom;"></td>
</tr>
</table>

<div class="emarge" style="text-align:right" >
<div  id="corps_gestion_stock">

	<table width="950px" height="350px" border="0" align="right" cellpadding="0" cellspacing="0" >
		<tr>
			<td rowspan="2" style="width:50px; height:50px; background-color:#FFFFFF">
				<div style="position:relative; top:-35px; left:-35px; width:105px; border:1px solid #999999; background-color:#FFFFFF; text-align:center">
				<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/ico_stock.jpg" />				</div>
				<span style="width:35px">
				<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="50px" height="20px" id="imgsizeform"/>				</span>			</td>
			<td colspan="2" style="width:60%; background-color:#FFFFFF" >
			<br />
			<br />
			<br />

			<div>
			<table border="0" cellspacing="0" cellpadding="0" style="width:100%; height:100%">
				<tr>
					<td></td>
					<td>
					<div>
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td colspan="2" class="line_caisse_bottom">&nbsp;</td>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td><div class="bold_caisse" style="font-size:16px">Valorisation &gt;&gt;</div></td>
								<td align="right"><div class="bold_caisse" style="font-size:16px"><?php
														if($_SESSION['user']-> check_permission("6")){ 
															echo number_format($stock->valeur_stock (), $TARIFS_NB_DECIMALES, ".", ""	)." ".$MONNAIE[1];
														}else{
															echo "ND";
														}	?></div></td>
								<td style="width:20%">&nbsp;</td>
							</tr>
							<tr>
								<td colspan="2" class="line_caisse_top">&nbsp;</td>
								<td>&nbsp;</td>
							</tr>
							
							<tr>
								<td colspan="2" class="line_caisse_bottom">&nbsp;</td>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td colspan="2" >
								<div id="liste_de_categorie" style="OVERFLOW-Y: auto; OVERFLOW-X: auto; ">
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
										<div style=" width:55px; text-align:right; float:right">
											<?php
											$valeur_stock = $art_categ->valeur_stock;
											$pass_ref_art_categ = "";
											
											foreach ($tmplist_art_categ as $tmp_art_categ) {
												if ($tmp_art_categ->ref_art_categ == $art_categ->ref_art_categ) {$pass_ref_art_categ = $art_categ->ref_art_categ; continue;}
												if (!$pass_ref_art_categ) {continue;}
												if ($art_categ->indentation >= $tmp_art_categ->indentation) {$pass_ref_art_categ = ""; break;}
												$valeur_stock += $tmp_art_categ->valeur_stock;
											}
											if($_SESSION['user']-> check_permission("6")){
											 echo number_format($valeur_stock, $TARIFS_NB_DECIMALES, ".", ""	)."&nbsp;".$MONNAIE[1];
											}else{
												echo "ND";
												}	
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
								
								
								
								</td>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td colspan="2" >&nbsp;</td>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td colspan="2" >
								<div style="float:left; color:#999999">Dernier inventaire: <?php echo date_Us_to_Fr($stock->last_inventaire_stock ())." ".getTime_from_date ($stock->last_inventaire_stock ());?></div>
								
								<span style="color:#97bf0d; float:right">
								<span id="inventorier_<?php echo $stock->getId_stock(); ?>"  class="green_underlined"  ><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_inventorier.gif" />
								</span>
								</span>
								</td>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td colspan="2" >&nbsp;</td>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td colspan="2" >&nbsp;</td>
								<td>&nbsp;</td>
							</tr>
							
							<?php if (count($erreurs_stock)) {?>
							<tr>
								<td colspan="2">
								
								<div style="float:left; color:#000000; font-weight:bolder">Erreurs de stock détectées &gt;&gt;</div>
								
								<span style="float:right; font-weight:bolder">
								<span style="color:#FF0000;" >
								<?php echo count($erreurs_stock);?></span> erreurs
								</span>
								</td>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td colspan="2" class="line_caisse_top">
								
								<div style="float:left; color:#999999; text-decoration:underline; cursor:pointer" id="inventory_stock_erreurs">Faire l'inventaire</div>
								
								<span style="float:right">
								<span style="color:#999999; text-decoration:underline; cursor:pointer" id="viewstock_articles_error">Voir</span>
								</span>
								<script type="text/javascript">
								
								Event.observe("inventory_stock_erreurs", "click", function(evt){
									Event.stop(evt);
									page.verify("documents_nouveau_inventaire", "documents_nouveau_inventaire.php?id_stock=<?php echo $stock->getId_stock(); ?>&id_type_doc=<?php echo $INVENTAIRE_ID_TYPE_DOC;?>&stock_error=1", "true", "sub_content");
								}, false);
								Event.observe("viewstock_articles_error", "click", function(evt){
									Event.stop(evt);
									page.verify("stocks_etat_imprimer", "stocks_etat_imprimer.php?ref_art_categ=&ref_constructeur=&aff_pa=0&orderby=lib_article&orderorder=ASC&id_stocks=<?php echo $stock->getId_stock(); ?>&in_stock=1", "true", "_blank");
								}, false);


								</script>
								</td>
								<td>&nbsp;</td>
							</tr>
							<?php } else { ?>
							<tr>
								<td colspan="2">
								<div style="float:left; color:#000000; font-weight:bolder">Aucune erreur de stock détectée </div>
								</td>
								<td>&nbsp;</td>
							</tr>
							<?php } ?>
						</table>
						<br />
						
						
					</td>
					<td></td>
				</tr>
			</table>
			</div>
			
			</td>
			<td style="width:8px">
			</td>
			<td style="background-color:#FFFFFF" >
			<br />
			<br />
			<br />
					<div style="padding: 15px 25px;">
					<div class="line_caisse_bottom"></div>
					<div class="bold_caisse" style="font-size:16px">Opérations de gestion</div> 
					<div class="line_caisse_top"></div>
					<br />
					<br />
					<span id="etat_stock" class="grey_caisse"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/puce_bleue.gif"  style="padding-right:10px; float:left" vspace="3" /> Etat de stock</span><br /><br />

					<span id="renouveler_stock" class="grey_caisse"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/puce_bleue.gif"  style="padding-right:10px; float:left" vspace="3" /> Stock à renouveler</span><br /><br />

					<?php 
					if (count($_SESSION['stocks']) >1) {?>
					<span id="stocks_transferer" class="grey_caisse"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/puce_bleue.gif"  style="padding-right:10px; float:left" vspace="3" /> Stock à Transférer</span><br /><br />
					<?php } ?>
						
					<span id="moves_stock" class="grey_caisse"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/puce_bleue.gif"  style="padding-right:10px; float:left" vspace="3" /> Historique par mouvement</span><br /><br />

						<br />
					<span id="docs_stock" class="grey_caisse" ><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/puce_bleue.gif"  style="padding-right:10px; float:left" vspace="3" /> Historique par document</span><br /><br />

<br />

					<span id="raz_stock" class="grey_caisse" ><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/puce_bleue.gif"  style="padding-right:10px; float:left" vspace="3" />Réinitialiser le stock</span><br /><br />
					</div>
						<script type="text/javascript">
						
						Event.observe("etat_stock", "click",  function(evt){
							Event.stop(evt);
							page.verify('stocks_etat_recherche','stocks_etat_recherche.php?id_stock=<?php echo $stock->getId_stock ();?>','true','sub_content');
						}, false);
						
						Event.observe("renouveler_stock", "click",  function(evt){
							Event.stop(evt);
							page.verify('stocks_a_renouveller','stocks_a_renouveller.php?id_stock=<?php echo $stock->getId_stock()?>','true','sub_content');
						}, false);
						
						<?php 
						if (count($_SESSION['stocks']) >1) {?>
						Event.observe("stocks_transferer", "click",  function(evt){
							Event.stop(evt);
							page.verify('stocks_a_transferer','stocks_a_transferer.php?id_stock=<?php echo $stock->getId_stock()?>','true','sub_content');
						}, false);
						<?php } ?>

						Event.observe('moves_stock', 'click',  function(evt){
						Event.stop(evt); 
						page.verify('stocks_mouvements','stocks_mouvements.php?id_stock=<?php echo $stock->getId_stock()?>','true','sub_content');
						}, false);

						Event.observe("docs_stock", "click",  function(evt){
							Event.stop(evt);
							page.verify('stocks_docs','stocks_docs.php?id_stock=<?php echo $stock->getId_stock()?>','true','sub_content');
						}, false);
						
						
						
						Event.observe("raz_stock", "click", function(evt){
							Event.stop(evt);
							page.verify("stocks_raz", "stocks_raz.php?id_stock=<?php echo $stock->getId_stock(); ?>", "true", "sub_content");
						}, false);
						</script>
			</td>
		</tr>
</table>
</div>
</div>

</div>

<SCRIPT type="text/javascript">

function setheight_gestion_caisse(){
set_tomax_height("corps_gestion_caisses" , -32);
}
Event.observe(window, "resize", setheight_gestion_caisse, false);
setheight_gestion_caisse();


Event.observe("inventorier_<?php echo $stock->getId_stock(); ?>", "click", function(evt){
	Event.stop(evt);
	page.verify("documents_nouveau_inventaire", "documents_nouveau_inventaire.php?id_stock=<?php echo $stock->getId_stock(); ?>&id_type_doc=<?php echo $INVENTAIRE_ID_TYPE_DOC;?>", "true", "sub_content");
}, false);



	
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


//on masque le chargement
H_loading();
</SCRIPT>