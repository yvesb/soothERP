<?php

// *************************************************************************************************************
// RESUME DES STOCK D'UN ARTICLE (affichage dans les moteurs de recherche article)
// *************************************************************************************************************

// Variables nécessaires à l"affichage
$page_variables = array ();
check_page_variables ($page_variables);

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

$article_sns = $article->getStocks_arti_sn ();
?>
<div style="">
<table style="cursor:pointer;" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td>
		
				<table style="width:100%;" cellpadding="0" cellspacing="0" border="0">
				<tr style="" id="tab_stocks">
					<td style="text-align:left;" class="resume_stock_border_right">&nbsp;</td>
					<?php
					if ($article->getLot() != 2) {
						?>
						<td style="text-align:center" class="resume_stock_border_right">En stock </td>
						<?php
					} else {
						?>
						<td style="text-align:center" class="resume_stock_border_right">Constituable</td>
						<?php
					}
					?>
					<td style="text-align:center" class="resume_stock_border_right">R&eacute;serv&eacute;</td>
					<?php
					if ($article->getLot() == 1) {
						?>
						<td style="text-align:center" >Fabricable</td>
						<?php
					} else {
						if ($article->getLot() != 2) {
						?>
						<td style="text-align:center">R&eacute;appro.</td>
						<?php
						}
					}
					?>
					<td style="text-align:center" class="resume_stock_border_right"></td>
			
					
				</tr>
				<?php
				//liste des stocks
				$first_stock = 0;
				
				$tot_const = 0;
				$tot_res = 0;
				$tot_reap = 0;
				
				foreach ($stocks_liste as $stock_liste) {
					?>
					<tr>
						<td style="text-align:left; padding-right:5px; " class="resume_stock_border_topright">
						<?php echo htmlentities($stock_liste->getLib_stock()); ?>				</td>
						<td style="text-align:center; width:80px;" class="resume_stock_border_topright">
							<div style="text-align:center; display:block; position:relative; cursor:pointer" id="info_stock_qte_<?php echo $stock_liste->getId_stock ();?>"><?php	if ($article->getLot() == 2) {
							$max_tofab = 0;
							$countcompo = 0;
							foreach ($art_composants as $composant) {
							
								if (isset($art_stocks_tofab[$stock_liste->getId_stock()][$composant->ref_lot_contenu]->qte_stock) && $art_stocks_tofab[$stock_liste->getId_stock()][$composant->ref_lot_contenu]->qte_stock > 0) {
								
									if (floor($art_stocks_tofab[$stock_liste->getId_stock()][$composant->ref_lot_contenu]->qte_stock/$composant->qte) > 0) {
										if ($max_tofab == 0 && $countcompo == 0) {
											$max_tofab = floor($art_stocks_tofab[$stock_liste->getId_stock()][$composant->ref_lot_contenu]->qte_stock/$composant->qte);
											$countcompo = 1;
										}
									}
									if (floor($art_stocks_tofab[$stock_liste->getId_stock()][$composant->ref_lot_contenu]->qte_stock/$composant->qte) <= $max_tofab) {
											$max_tofab = floor($art_stocks_tofab[$stock_liste->getId_stock()][$composant->ref_lot_contenu]->qte_stock/$composant->qte);
											$countcompo = 1;
									}
									if (floor($art_stocks_tofab[$stock_liste->getId_stock()][$composant->ref_lot_contenu]->qte_stock/$composant->qte) == 0) {
										$max_tofab = 0;
										$countcompo = 1;
									}
								} else {
										$max_tofab = 0;
										$countcompo = 1;
								}
							}
							echo $max_tofab ;
							$tot_const += $max_tofab;
						}	else {
							if (isset($art_stocks[$stock_liste->getId_stock ()]->qte)) {
								echo $art_stocks[$stock_liste->getId_stock ()]->qte ;
							$tot_const += $art_stocks[$stock_liste->getId_stock ()]->qte ;
							} else {
								echo "0";
							}
							
							if ($article->getGestion_sn() == 1) {
								if (isset($article_sns[$stock_liste->getId_stock ()])) {
								$liste_sn = $article_sns[$stock_liste->getId_stock()]->sn;
								?>
								
							<div style="position:absolute; top:18x; left:50px; background-color:#FFFFFF; border:1px solid #CCCCCC; width:380px; height:185px; overflow:auto; display:none; -moz-border-radius:5px; border-radius:5px;" id="aff_sn_<?php echo $stock_liste->getId_stock ();?>">
							<?php
							
								
								
									?>
									<div style="text-align:left">
									Détails des numéros de série en stock pour <?php echo $article->getLib_article();?><br />
									<?php echo htmlentities($stock_liste->getLib_stock()); ?>: Quantité en stock: <?php if (isset($art_stocks[$stock_liste->getId_stock ()]->qte)) {
										echo $art_stocks[$stock_liste->getId_stock ()]->qte ;
										
									} else {
										echo "0";
									}?> dont <?php echo count($liste_sn );?> possédant un numéro de série.<br />
									</div>
									<table width="100%" style="text-align:left">
									<tr>
									<td style="font-weight:bolder">
									Numéro de série
									</td>
									<td>
									
									</td>
									</tr>
								</table>
									<table width="100%" style="text-align:left">
										<tr>
											<td >
									<?php 
								foreach ($liste_sn as $key_sn=>$nb_sn) {
									?>
									
											<span  style="text-align:left; padding-right:15px">
											<?php echo " ".$key_sn;?>
											</span>
									
									<?php
								}
								?>
											</td>
										</tr>
									</table>
								<script type="text/javascript" >
								
										Event.observe("info_stock_qte_<?php echo $stock_liste->getId_stock ();?>", "click", function(evt){
											$("aff_sn_<?php echo $stock_liste->getId_stock ();?>").toggle();
											}, false );
										
								</script>
								</div>
									<?php
								}
							}
							if ($article->getGestion_sn() == 2) {
								if (isset($article_sns[$stock_liste->getId_stock ()])) {
								$liste_sn = $article_sns[$stock_liste->getId_stock()]->sn;
								?>
								
							<div style="position:absolute; top:18x; left:50px; background-color:#FFFFFF; border:1px solid #CCCCCC; width:390px; height:185px; overflow:auto; display:none; -moz-border-radius:5px; border-radius:5px;" id="aff_sn_<?php echo $stock_liste->getId_stock ();?>">
							<?php
							
								
								
									?>
									<div style="text-align:left">
									Détails des numéros de lots en stock pour <?php echo $article->getLib_article();?><br />
									<?php echo htmlentities($stock_liste->getLib_stock()); ?>: Quantité en stock: <?php if (isset($art_stocks[$stock_liste->getId_stock ()]->qte)) {
								echo $art_stocks[$stock_liste->getId_stock ()]->qte ;
								
							} else {
								echo "0";
							}?> dont 
									<?php 
								$combien = 0;
								foreach ($liste_sn as $key_sn=>$nb_sn) {
									$combien += $nb_sn;
								}
								echo $combien;
								
									?> possédant un numéro de lot
									</div>
									<table width="100%" style="text-align:left">
									<tr>
									<td style="font-weight:bolder">
									Numéro de lot
									</td>
									<td style="font-weight:bolder">
									Quantité
									</td>
									</tr>
									<?php 
								foreach ($liste_sn as $key_sn=>$nb_sn) {
									?>
									
									<tr>
									<td  style="text-align:left">
									<?php echo "Lot ".$key_sn;?>
									</td>
									<td>
									<?php echo $nb_sn;?>
									</td>
									</tr>
									<?php
								}
								?>
								</table>
								<script type="text/javascript" >
								
										Event.observe("info_stock_qte_<?php echo $stock_liste->getId_stock ();?>", "click", function(evt){
											$("aff_sn_<?php echo $stock_liste->getId_stock ();?>").toggle();
											}, false );
											
								</script>
								</div>
									<?php
								}
							}
						}
						?></div>
						</td>
						<td style="text-align:center; width:80px;" class="resume_stock_border_topright">
							<?php	
							if (isset($art_stocks_rsv[$stock_liste->getId_stock ()])) {
							
								if (!isset($art_stocks_rsv[$stock_liste->getId_stock ()]->qte_livree)) {$art_stocks_rsv[$stock_liste->getId_stock ()]->qte_livree = 0 ;}
								if (!isset($art_stocks_rsv[$stock_liste->getId_stock ()]->qte)) {$art_stocks_rsv[$stock_liste->getId_stock ()]->qte = 0 ;}
								echo $art_stocks_rsv[$stock_liste->getId_stock ()]->qte - $art_stocks_rsv[$stock_liste->getId_stock ()]->qte_livree ;
								
								$tot_res += $art_stocks_rsv[$stock_liste->getId_stock ()]->qte - $art_stocks_rsv[$stock_liste->getId_stock ()]->qte_livree ;
							} else {
								echo "0";
							}
							?>
						</td>
						<?php
							if ($article->getLot() == 1) {
						?>
						<td style="text-align:center; width:80px " class="resume_stock_border_top">
						<div style="text-align:center; display:block">
							<?php	
							$max_tofab = 0;
							//print_r ($art_stocks_tofab);
							$countcompo = 0;
							foreach ($art_composants as $composant) {
							
								if (isset($art_stocks_tofab[$stock_liste->getId_stock()][$composant->ref_lot_contenu]->qte_stock) && $art_stocks_tofab[$stock_liste->getId_stock()][$composant->ref_lot_contenu]->qte_stock > 0) {
								
									if (floor($art_stocks_tofab[$stock_liste->getId_stock()][$composant->ref_lot_contenu]->qte_stock/$composant->qte) > 0) {
										if ($max_tofab == 0 && $countcompo == 0) {
											$max_tofab = floor($art_stocks_tofab[$stock_liste->getId_stock()][$composant->ref_lot_contenu]->qte_stock/$composant->qte);
											$countcompo = 1;
										}
									}
									if (floor($art_stocks_tofab[$stock_liste->getId_stock()][$composant->ref_lot_contenu]->qte_stock/$composant->qte) <= $max_tofab) {
											$max_tofab = floor($art_stocks_tofab[$stock_liste->getId_stock()][$composant->ref_lot_contenu]->qte_stock/$composant->qte);
											$countcompo = 1;
									}
									if (floor($art_stocks_tofab[$stock_liste->getId_stock()][$composant->ref_lot_contenu]->qte_stock/$composant->qte) == 0) {
										$max_tofab = 0;
										$countcompo = 1;
									}
								} else {
										$max_tofab = 0;
										$countcompo = 1;
								}
							}
							echo $max_tofab ;
							
							$tot_reap += $max_tofab;
							?>
						</td>
						<?php
						} else {
						
						if ($article->getLot() != 2) {
						?>
						<td style="text-align:center; width:80px " class="resume_stock_border_top">
							<?php	
							if (isset($art_stocks_cdf[$stock_liste->getId_stock ()])) {
								if (!isset($art_stocks_cdf[$stock_liste->getId_stock ()]->qte_recue)) { $art_stocks_cdf[$stock_liste->getId_stock ()]->qte_recue = 0 ;}
								if (!isset($art_stocks_cdf[$stock_liste->getId_stock ()]->qte)) { $art_stocks_cdf[$stock_liste->getId_stock ()]->qte = 0 ;}
								?>
								<?php 
								echo $art_stocks_cdf[$stock_liste->getId_stock ()]->qte - $art_stocks_cdf[$stock_liste->getId_stock ()]->qte_recue ;?>
							$tot_reap += $art_stocks_cdf[$stock_liste->getId_stock ()]->qte - $art_stocks_cdf[$stock_liste->getId_stock ()]->qte_recue ;?>
								<?php
							} else {
								echo "0";
							}
							?>
						</td>
						<?php
						}
					}
					?>
						<td style="text-align:center; width:80px " class="resume_stock_border_topright">
							<?php	
							if (isset($art_stocks_cdf[$stock_liste->getId_stock ()])) {
								if (isset($art_stocks_cdf[$stock_liste->getId_stock ()]->date_livraison) && $art_stocks_cdf[$stock_liste->getId_stock ()]->date_livraison != "0000-00-00") {
								 echo "&nbsp;(".date_Us_to_Fr($art_stocks_cdf[$stock_liste->getId_stock ()]->date_livraison).")" ;
								}
							}
							?>
							
							</td>
							
					</tr>
					<?php 
				}
				?><tr style="">
					<td style="text-align:left;" class="resume_stock_border_topright">TOTAL:</td>
		
						<td style="text-align:center" class="resume_stock_border_topright"><?php echo $tot_const;?></td>
						
					<td style="text-align:center" class="resume_stock_border_topright"><?php echo $tot_res;?></td>
					
						<td style="text-align:center" class="resume_stock_border_top"><?php echo $tot_reap;?></td>
						
					<td style="text-align:center" class="resume_stock_border_topright"></td>
				
				</tr>
				</table>
				</td>
			</tr>
		</table>
		</td>
	</tr>
</table>
</div>
<SCRIPT type="text/javascript">

Event.observe('tab_stocks', "click", function(evt){
	close_resume_stock();
});



//on masque le chargement
H_loading();
</SCRIPT>