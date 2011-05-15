<?php

// *************************************************************************************************************
// AFFICHAGE DU TABLEAU DE BORD D'UN Terminal de paiement
// *************************************************************************************************************

// Variables nécessaires à l"affichage
$page_variables = array ();
check_page_variables ($page_variables);

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

$solde = $totaux_theoriques;
?>
<script type="text/javascript">

	
</script>
<div class="emarge"><br />

<div class="titre" style="width:60%; padding-left:140px"><?php echo htmlentities($compte_tp->getLib_tp()); ?> -  Tableau de bord
</div>
<div class="emarge" style="text-align:right" >
<div  id="corps_gestion_tps">

	<table width="950px" height="350px" border="0" align="right" cellpadding="0" cellspacing="0" >
		<tr>
			<td rowspan="2" style="width:50px; height:50px; background-color:#FFFFFF">
				<div style="position:relative; top:-35px; left:-35px; width:105px; border:1px solid #999999; background-color:#FFFFFF; text-align:center">
				<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/ico_carte.gif" />				</div>
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
								<td><div class="bold_caisse" style="font-size:16px">Solde Théorique &gt;&gt;</div></td>
								<td align="right"><div class="bold_caisse" style="font-size:16px"><?php echo number_format($solde, $TARIFS_NB_DECIMALES, ".", ""	)." ".$MONNAIE[1];?></div></td>
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
								<td colspan="2">
								<br />
								<?php if ($last_date_telecollecte) {?>
								<div style="float:left; color:#999999">Derniere télécollecte: <?php echo date_Us_to_Fr($last_date_telecollecte)." ".getTime_from_date ($last_date_telecollecte);?></div>
								<?php } ?>
								<span style="color:#97bf0d; float:right">
								<span id="telecollecte_tp_<?php echo $compte_tp->getId_compte_tp(); ?>"  class="green_underlined"  ><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_telecollecte.gif" />
								</span>
								</span>
								</td>
								<td>&nbsp;</td>
							</tr>
						</table><br />

								<br />
						<br />

						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td><div class="bold_caisse" style="font-size:16px">10 dernières opérations</div></td>
								<td align="right"></td>
								<td style="width:20%">&nbsp;</td>
							</tr>
							<tr>
								<td colspan="2" class="line_caisse_bottom">&nbsp;</td>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td colspan="2">

							<div style="height:5px"></div>
							<table width="100%"  border="0" cellspacing="0" cellpadding="0" id="tableresult">
								<tr class="colorise1">
									<td style="width:30%; text-align: left; font-weight:bolder ">
										Date
									</td>
									<td style="font-weight:bolder">
										Référence
									</td>
									<td style="width:15%; text-align:right; font-weight:bolder">Montant</td>
								</tr>
							<?php 
							$solde_page = 0;
							$colorise=0;
							foreach ($fiches as $fiche) {
							$colorise++;
							?>
							<tr class="colorise1">
								<td style="text-align: left">
									<?php	if (isset($fiche->date_reglement)) { echo date_Us_to_Fr($fiche->date_reglement)." ".getTime_from_date($fiche->date_reglement); } ?>
								</td>
								<td>
									<a  href="#" id="link_reg_ref_<?php echo htmlentities($fiche->ref_reglement)?>" style="display:block; width:100%">
									<span style="font-weight:bolder"></span> 
									<?php	if (isset($fiche->ref_reglement)) {?>
									<?php echo nl2br(($fiche->ref_reglement))?>
									<?php }	?>
									</a>
									<script type="text/javascript">
									Event.observe("link_reg_ref_<?php echo htmlentities($fiche->ref_reglement)?>", "click",  function(evt){
										Event.stop(evt);
										page.traitecontent('compta_reglements_edition','compta_reglements_edition.php?ref_reglement=<?php echo $fiche->ref_reglement;?>','true','edition_reglement');
										$("edition_reglement").show();
										$("edition_reglement_iframe").show();
											
										}, false);
									</script>
								</td>
								<?php
								$solde_page += number_format($fiche->montant_reglement, $TARIFS_NB_DECIMALES, ".", ""	);
								?>
								<td style="text-align:right">
									<?php	if (isset($fiche->montant_reglement)) { 
									echo number_format($fiche->montant_reglement, $TARIFS_NB_DECIMALES, ".", ""	)." ".$MONNAIE[1]; }
									?>
								</td>
								</tr>
								
							<?php
							}
							?>
							</table>

							<iframe frameborder="0" scrolling="no" src="about:_blank" id="edition_reglement_iframe" class="edition_reglement_iframe" style="display:none"></iframe>
							<div id="edition_reglement" class="edition_reglement" style="display:none">
							</div>
							<SCRIPT type="text/javascript">
							//centrage de l'editeur
							centrage_element("edition_reglement");
							centrage_element("edition_reglement_iframe");
							
							Event.observe(window, "resize", function(evt){
							centrage_element("edition_reglement");
							centrage_element("edition_reglement_iframe");
							});
							</SCRIPT>
								</td>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td colspan="2" class="line_caisse_bottom">&nbsp;</td>
								<td>&nbsp;</td>
							</tr>
						</table><br />
						<span id="historique_mouvement_tp_<?php echo $compte_tp->getId_compte_tp(); ?>" style="cursor:pointer; color:#999999; text-decoration:underline">
						Consulter l'historique des op&eacute;rations
						</span>	
					</div>
					</td>
					<td style="width:8px;">
					<div style="height:100%; "></div>
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

						<span id="telecollecte_tp_historique_<?php echo $compte_tp->getId_compte_tp(); ?>" class="grey_caisse" ><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/puce_bleue.gif"  style="padding-right:10px; float:left" vspace="3" />  Historique des télécollectes
						</span><br /><br />
						
					<!--<span id="compta_tp_stat" class="grey_caisse" ><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/puce_bleue.gif"  style="padding-right:10px; float:left" vspace="3" /> Statistiques</span><br /><br />-->
<br />

					<span id="compta_tp_raz" class="grey_caisse" ><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/puce_bleue.gif"  style="padding-right:10px; float:left" vspace="3" /> Remise à zéro</span><br /><br />
					</div>
						<script type="text/javascript">
						
											
						Event.observe("telecollecte_tp_historique_<?php echo $compte_tp->getId_compte_tp(); ?>", "click", function(evt){
							Event.stop(evt);
							page.verify("compta_tp_telecollecte_historique", "compta_tp_telecollecte_historique.php?id_tp=<?php echo $compte_tp->getId_compte_tp(); ?>&tp_type=<?php echo $compte_tp->getTp_type(); ?>", "true", "sub_content");
						}, false);
						
						//Event.observe("compta_tp_stat", "click", function(evt){
						//	Event.stop(evt);
						//	page.verify("compta_tp_stat", "compta_tp_stat.php?id_tp=<?php echo $compte_tp->getId_compte_tp(); ?>&tp_type=<?php echo $compte_tp->getTp_type(); ?>", "true", "sub_content");
						//}, false);
						
						Event.observe("compta_tp_raz", "click", function(evt){
							Event.stop(evt);
							page.verify("compta_tp_raz", "compta_tp_raz.php?id_tp=<?php echo $compte_tp->getId_compte_tp(); ?>&tp_type=<?php echo $compte_tp->getTp_type(); ?>", "true", "sub_content");
						}, false);
						</script>
			</td>
		</tr>
</table>
</div>
</div>

</div>

<SCRIPT type="text/javascript">

function setheight_gestion_tp(){
set_tomax_height("corps_gestion_tps" , -32);
}
Event.observe(window, "resize", setheight_gestion_tp, false);
setheight_gestion_tp();


	Event.observe("telecollecte_tp_<?php echo $compte_tp->getId_compte_tp(); ?>", "click", function(evt){
		Event.stop(evt);
		page.verify("compta_tp_telecollecte", "compta_tp_telecollecte.php?id_tp=<?php echo $compte_tp->getId_compte_tp(); ?>&tp_type=<?php echo $compte_tp->getTp_type(); ?>", "true", "sub_content");
	}, false);

	Event.observe("historique_mouvement_tp_<?php echo $compte_tp->getId_compte_tp(); ?>", "click", function(evt){
		Event.stop(evt);
		page.verify("compta_tp_mouvement", "compta_tp_mouvement.php?id_tp=<?php echo $compte_tp->getId_compte_tp(); ?>&tp_type=<?php echo $compte_tp->getTp_type(); ?>", "true", "sub_content");
	}, false);

	
//on masque le chargement
H_loading();
</SCRIPT>