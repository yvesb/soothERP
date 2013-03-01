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
<table style="cursor:pointer;" cellpadding="0" cellspacing="0" border="0" id="tab_stocks">
	<tr>
		<td>
		<table style="width:100%;" cellpadding="0" cellspacing="0" border="0">
		<tr style="">
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
			<td style="text-align:center" ></td>
			<td style="text-align:center" class="resume_stock_border_left">Minima</td>
			<td style="text-align:center" class="resume_stock_border_left">A Commander</td>
		</tr>
		<?php
		//liste des stocks
		$first_stock = 0;
		foreach ($stocks_liste as $stock_liste) {
			?>
			<tr>
				<td style="text-align:left; padding-right:5px; " class="resume_stock_border_topright">
				<?php echo htmlentities($stock_liste->getLib_stock()); ?>				</td>
				<td style="text-align:center; width:80px;" class="resume_stock_border_topright">
					<div style="text-align:center; display:block">
					<?php	
					$qte_en_stock = 0;
					if ($article->getLot() == 2) {
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
							$qte_en_stock += $max_tofab ;
						}	else {
							if (isset($art_stocks[$stock_liste->getId_stock ()]->qte)) {
								$qte_en_stock += $art_stocks[$stock_liste->getId_stock ()]->qte ;
							} 
							
						}
						echo $qte_en_stock ;
				
					?>
					</div>
				</td>
				<td style="text-align:center; width:80px;" class="resume_stock_border_topright">
					<?php	
					if (isset($art_stocks_rsv[$stock_liste->getId_stock ()])) {
					
						if (!isset($art_stocks_rsv[$stock_liste->getId_stock ()]->qte_livree)) {$art_stocks_rsv[$stock_liste->getId_stock ()]->qte_livree = 0 ;}
						if (!isset($art_stocks_rsv[$stock_liste->getId_stock ()]->qte)) {$art_stocks_rsv[$stock_liste->getId_stock ()]->qte = 0 ;}
						echo $art_stocks_rsv[$stock_liste->getId_stock ()]->qte - $art_stocks_rsv[$stock_liste->getId_stock ()]->qte_livree ;
						
					} else {
						echo "0";
					}
					?>
				</td><?php
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
				<td style="text-align:center; width:80px " class="resume_stock_border_top">
					<?php	
					if (isset($art_stocks_cdf[$stock_liste->getId_stock ()])) {
						if (isset($art_stocks_cdf[$stock_liste->getId_stock ()]->date_livraison) && $art_stocks_cdf[$stock_liste->getId_stock ()]->date_livraison != "0000-00-00") {
						 echo "&nbsp;(".date_Us_to_Fr($art_stocks_cdf[$stock_liste->getId_stock ()]->date_livraison).")" ;
						}
					}
					?>
				</td>
				
				<td style="text-align:center; width:80px " class="resume_stock_border_topleft">
					<?php	
					$stock_seuil_alerte = 0;
					foreach ($art_stock_alerte as $stock_alerte) {
						if ($stock_alerte->id_stock == $stock_liste->getId_stock ()) {
						 $stock_seuil_alerte = $stock_alerte->seuil_alerte ;
						}
					}
					echo $stock_seuil_alerte ;
					?>
				</td>
				
					<td style="text-align:center; font-weight:bolder" class="resume_stock_border_topleft">
					<?php
					if ($qte_en_stock < 0) {$qte_en_stock = 0;}
					if ($stock_seuil_alerte > $qte_en_stock) {
					 echo $stock_seuil_alerte - $qte_en_stock ;
					} else {
						echo "0";
					}
					 ?>
					</td>
			</tr>
			<?php 
		}
		?>
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