<?php

// *************************************************************************************************************
// STTATS D'UN ARTICLE 
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
<div style=" text-align:left; padding:20px">

<table style="width:100%">
	<tr>
		<td style="width:48%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
		<td style="width:4%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
		<td style="width:48%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
	</tr>
	<tr>
		<td>
			<table border="0" cellspacing="0" cellpadding="0" class="main_aff_ca">
				<tr>
					<td style="padding:10px">
					<table border="0" cellspacing="0" cellpadding="0" style="width:100%;">
						<tr style="">
							<td class="aff_an_article">&nbsp;</td>
							<td class="aff_an_article"><?php
							//setlocale(LC_TIME, $INFO_LOCALE);
							echo lmb_strftime("%B", $INFO_LOCALE, mktime(0, 0, 0, date("m"), 1, date("Y")));
							?></td>
							<td class="aff_an_article"><?php
							echo lmb_strftime("%B", $INFO_LOCALE, mktime(0, 0, 0, date("m")-1, 1, date("Y")));
							?></td>
							<td class="aff_an_article"><?php
							echo lmb_strftime("%B", $INFO_LOCALE, mktime(0, 0, 0, date("m")-2, 1, date("Y")));
							?></td>
						</tr>
						<tr>
							<td class="aff_tit_article">Chiffre d'affaires généré</td>
							<td class="aff_ca_article">
							<?php if (isset($article_CA["ventes_tri"][0])) {?>
							<?php echo price_format($article_CA["ventes_tri"][0])."&nbsp;".$MONNAIE[1];?>
							<?php } ?>
							</td>
							<td class="aff_ca_article">
							<?php if (isset($article_CA["ventes_tri"][1])) {?>
							<?php echo price_format($article_CA["ventes_tri"][1])."&nbsp;".$MONNAIE[1];?>
							<?php } ?>
							</td>
							<td class="aff_ca_article">
							<?php if (isset($article_CA["ventes_tri"][2])) {?>
							<?php echo price_format($article_CA["ventes_tri"][2])."&nbsp;".$MONNAIE[1];?>
							<?php } ?>
							</td>
						</tr>
						<tr>
							<td class="aff_tit_article">Volume d'achats</td>
							<td class="aff_ca_article">
							<?php if (isset($article_CA["achats_tri"][0])) {?>
							<?php echo price_format($article_CA["achats_tri"][0])."&nbsp;".$MONNAIE[1];?>
							<?php } ?>
							</td>
							<td class="aff_ca_article">
							<?php if (isset($article_CA["achats_tri"][1])) {?>
							<?php echo price_format($article_CA["achats_tri"][1])."&nbsp;".$MONNAIE[1];?>
							<?php } ?>
							</td>
							<td class="aff_ca_article">
							<?php if (isset($article_CA["achats_tri"][2])) {?>
							<?php echo price_format($article_CA["achats_tri"][2])."&nbsp;".$MONNAIE[1];?>
							<?php } ?>
							</td>
						</tr>
					</table>
					</td>
				</tr>
			</table>
		<br />
		<br />
			<table border="0" cellspacing="0" cellpadding="0" class="main_aff_ca">
				<tr>
					<td style="padding:10px">
					<span style=" font-weight:bolder; color:#999999">Chiffre d'affaires généré sur les 30 derniers jours</span><br />
						<table border="0" cellpadding="0" cellspacing="0">
							<tr>
								<td>
								</td>
								<td>
								</td>
								<td style="height:5px">
								</td>
								<td valign="bottom" style="vertical-align:bottom; width:75px;border-left:1px solid #999999; color:#999999;" rowspan="3">
								<table border="0" cellpadding="0" cellspacing="0" height="54px">
								<tr><td style="font-size:8px">-</td><td style="font-size:8px; padding-left:1px;"><?php echo round($max_solde_30,0);?></td></tr>
								<tr><td style="font-size:8px">-</td><td style="font-size:8px; padding-left:1px;"><?php echo round($max_solde_30/2,0);?></td></tr>
								<tr><td style="font-size:8px">-</td><td style="font-size:8px; padding-left:1px;">0</td></tr>
								</table>
								</td>
							</tr>
							<tr>
								<td style="width:25px;">
								
									<div  class="blank_histo" style="height:40px" >&nbsp;</div>
								</td>
								<td valign="bottom" style="vertical-align:bottom">
								<table border="0" cellpadding="0" cellspacing="0">
								<tr>
								<?php
								$o = 0;
								foreach ($solde_30 as $s_30) { ?>
								<td style="padding-right:2px; vertical-align: bottom; color:#999999;" valign="bottom">
								<div id="s3p_hist_<?php echo $o;?>" <?php 
								if ($s_30 > 0) {
									?>	class="green_histo" style="background-color:<?php
								if (isset($degrader_30_pos[$o])) { echo $degrader_30_pos[$o]; }?>; height:0px" title="<?php echo number_format(($s_30), $TARIFS_NB_DECIMALES, ".", ""	)." ".$MONNAIE[1];?>" <?php 
									}
									else {
									?>	class="blank_histo" <?php }
									?> >&nbsp;</div>
									<?php if ($s_30 > 0) {?>
									<script>rise_height("s3p_hist_<?php echo $o;?>", <?php echo $s_30 * 40 /$max_solde_30;?>);</script>
									<?php }?>
									</td>
									<?php
									$o++;
								}
								?>
								</tr>
								</table>
								</td>
								<td style="width:25px;">
								</td>
							</tr>
							<tr>
								<td style="border-top:1px solid #999999;">
								</td>
								<td style="border-top:1px solid #999999;">
								<table border="0" cellpadding="0" cellspacing="0">
								<tr>
								<?php 
								$liste_abs = array(30,25,20,15,10,5,1);
								for ($j = 29; $j >=0 ; $j--) {
								
									?>
									<td style="padding:1px; vertical-align: top; font-size:8px; color:#999999;" valign="bottom">
									<div  class="blank_histo" ><?php if (in_array($j+1, $liste_abs)) {  echo $j+1;}?></div>
									</td>
									<?php
								}
								?>
								</tr>
								</table>
								</td>
								<td  style="border-top:1px solid #999999;">
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
			<br />
			<br />
			<?php if ($article->getModele () == "materiel" && $article->getVariante() != 2 && $GESTION_STOCK) {?>
			
			<table border="0" cellspacing="0" cellpadding="0" class="main_aff_ca">
				<tr>
					<td style="padding:10px">
					<table border="0" cellspacing="0" cellpadding="0" style="width:100%;">
						<tr style="">
							<td class="aff_an_article" style="width:60%; text-align:left" colspan="2">Rotation du stock</td>
							<td class="aff_an_article"></td>
							<td class="aff_an_article" style="width:35%"></td>
						</tr>
						<tr>
							<td style=" font-weight:bolder; height:24px; line-height:24px" >Sur 30 jours</td>
							<td style="color:#999999; text-align:right; font-weight:bolder; width:30%; height:24px; line-height:24px">
							<?php if (isset($article_CA["rotation_stock_30"])) {?>
							<?php echo price_format($article_CA["rotation_stock_30"])."&nbsp;";?>unités*
							<?php } ?>
							</td>
							<td>
							</td>
							<td>
							</td>
						</tr>
						<tr>
							<td style=" font-weight:bolder; height:24px; line-height:24px" >Sur 1 an</td>
							<td style="color:#999999; text-align:right; font-weight:bolder; height:24px; line-height:24px;" >
							<?php if (isset($article_CA["rotation_stock_12"])) {?>
							<?php echo price_format($article_CA["rotation_stock_12"])."&nbsp;";?>unités*
							<?php } ?>
							</td>
							<td >
							</td>
							<td style=" font:10px italic Arial, Helvetica, sans-serif; height:24px; line-height:24px ">(* Hors transferts)
							</td>
						</tr>
						<tr>
							<td colspan="4" >La durée de vie prévisionnelle du stock est de <span style="color:#97bf0d; font-weight:bolder"> <?php if ($article_CA["rotation_stock_30"] != 0){echo  round($article_CA["stock_total"]  / $article_CA["rotation_stock_30"]*30, 0);} else { echo "0";} ?> jours</span></td>
						</tr>
					</table>
					</td>
				</tr>
			</table>
			
			<?php } ?>
		</td>
		<td>
		


		</td>
		<td>
			<table border="0" cellspacing="0" cellpadding="0" class="main_aff_ca">
				<tr>
					<td style="padding:10px">
					<table border="0" cellspacing="0" cellpadding="0" style="width:100%;">
						<tr style="">
							<td class="aff_an_article">&nbsp;</td>
							<td class="aff_an_article">Année N</td>
							<td class="aff_an_article">Année N-1</td>
							<td class="aff_an_article">Année N-2</td>
						</tr>
						<tr>
							<td class="aff_tit_article">Chiffre d'affaires généré</td>
							<td class="aff_ca_article">
							<?php if (isset($article_CA["ventes"][0])) {?>
							<?php echo price_format($article_CA["ventes"][0])."&nbsp;".$MONNAIE[1];?>
							<?php } ?>
							</td>
							<td class="aff_ca_article">
							<?php if (isset($article_CA["ventes"][1])) {?>
							<?php echo price_format($article_CA["ventes"][1])."&nbsp;".$MONNAIE[1];?>
							<?php } ?>
							</td>
							<td class="aff_ca_article">
							<?php if (isset($article_CA["ventes"][2])) {?>
							<?php echo price_format($article_CA["ventes"][2])."&nbsp;".$MONNAIE[1];?>
							<?php } ?>
							</td>
						</tr>
						<tr>
							<td class="aff_tit_article">Volume d'achats</td>
							<td class="aff_ca_article">
							<?php if (isset($article_CA["achats"][0])) {?>
							<?php echo price_format($article_CA["achats"][0])."&nbsp;".$MONNAIE[1];?>
							<?php } ?>
							</td>
							<td class="aff_ca_article">
							<?php if (isset($article_CA["achats"][1])) {?>
							<?php echo price_format($article_CA["achats"][1])."&nbsp;".$MONNAIE[1];?>
							<?php } ?>
							</td>
							<td class="aff_ca_article">
							<?php if (isset($article_CA["achats"][2])) {?>
							<?php echo price_format($article_CA["achats"][2])."&nbsp;".$MONNAIE[1];?>
							<?php } ?>
							</td>
						</tr>
					</table>
					</td>
				</tr>
			</table>
		<br />
		<br />
			<table border="0" cellspacing="0" cellpadding="0" class="main_aff_ca">
				<tr>
					<td style="padding:10px"><span style=" font-weight:bolder; color:#999999">Chiffre d'affaires généré sur les 12 derniers mois</span><br />
								<table border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td>
										</td>
										<td>
										</td>
										<td style="height:5px">
										</td>
										<td valign="bottom" style="vertical-align:bottom; width:75px;border-left:1px solid #999999; color:#999999;" rowspan="3">
										<table border="0" cellpadding="0" cellspacing="0" height="54px">
										<tr><td style="font-size:8px">-</td><td style="font-size:8px; padding-left:1px;"><?php echo round($max_solde_12,0);?></td></tr>
										<tr><td style="font-size:8px">-</td><td style="font-size:8px; padding-left:1px;"><?php echo round($max_solde_12/2,0);?></td></tr>
										<tr><td style="font-size:8px">-</td><td style="font-size:8px; padding-left:1px;">0</td></tr>
										</table>
										</td>
									</tr>
									<tr>
										<td style="width:25px;">
										<div style="height:40px">&nbsp;</div>
										</td>
										<td valign="bottom" style="vertical-align:bottom">
										<table border="0" cellpadding="0" cellspacing="0">
										<tr>
										<?php 
										$o = 0;
										foreach ($solde_12 as $s_12) { ?>
										<td style="padding-right:23px; vertical-align: bottom;" valign="bottom">
										<div id="s1p_histo_<?php echo $o;?>" <?php
										if ($s_12 > 0) {
											?> style=" width:10px; background-color:<?php
										if (isset($degrader_12_pos[$o])) { echo $degrader_12_pos[$o]; }?>;height:0px" title="<?php echo number_format(($s_12), $TARIFS_NB_DECIMALES, ".", ""	)." ".$MONNAIE[1];?>" <?php }
											else {
											?>	style=" width:10px" <?php }
											?> >&nbsp;</div>
											<?php if ($s_12 > 0 && $max_solde_12>0) {?>
											<script>rise_height("s1p_histo_<?php echo $o;?>", <?php echo ($s_12* 40) /$max_solde_12;?>);</script>
											<?php }?>
											</td>
											<?php
											$o++;
										}
										?>
										</tr>
										</table>
										</td>
										<td style="width:25px;">
										</td>
									</tr>
									<tr>
										<td style="border-top:1px solid #999999;">
										</td>
										<td style="border-top:1px solid #999999;">
										<table border="0" cellpadding="0" cellspacing="0">
										<tr>
										<?php 
										
										//setlocale(LC_TIME, $INFO_LOCALE);
										for ($j = 11; $j >=0 ; $j--) {
											?>
											<td style="padding:1px; vertical-align: top; font-size:8px; color:#999999 " valign="bottom">
											<div style="width:31px;" ><span style="width:10px; text-align:center"><?php  echo date("M y", mktime(0, 0, 0, date("m" ,time())-$j , 1, date ("Y", time()) ) );?></span></div>
											</td>
											<?php
										}
										?>
										</tr>
										</table>
										</td>
										<td  style="border-top:1px solid #999999;">
										</td>
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
//on masque le chargement
H_loading();
</SCRIPT>