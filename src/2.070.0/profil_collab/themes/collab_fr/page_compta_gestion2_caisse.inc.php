<?php

// *************************************************************************************************************
// AFFICHAGE DU TABLEAU DE BORD D'UNE CAISSE
// *************************************************************************************************************

// Variables nécessaires à l"affichage
$page_variables = array ();
check_page_variables ($page_variables);

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

$solde = 0;
foreach ($totaux_theoriques as $s_total) {
	$solde += $s_total;
}
?>
<script type="text/javascript">

	
</script>
<div class="emarge"><br />

<div class="titre" style="width:60%; padding-left:140px"><?php echo htmlentities($compte_caisse->getLib_caisse()); ?> -  Tableau de bord
</div>
<div class="emarge" style="text-align:right" >
<div  id="corps_gestion_caisses">

	<table width="950px" height="350px" border="0" align="right" cellpadding="0" cellspacing="0" >
		<tr>
			<td rowspan="2" style="width:50px; height:50px; background-color:#FFFFFF">
				<div style="position:relative; top:-35px; left:-35px; width:105px; border:1px solid #999999; background-color:#FFFFFF; text-align:center">
				<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/ico_caisse.jpg" />				</div>
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
								<td class="caisse_text_2">Esp&egrave;ces</td>
								<td align="right" class="caisse_text_1">
								<?php
								$montant_especes = 0;
								if ((isset($totaux_theoriques[$ESP_E_ID_REGMT_MODE]) && $totaux_theoriques[$ESP_E_ID_REGMT_MODE])) {
									$montant_especes = $montant_especes + $totaux_theoriques[$ESP_E_ID_REGMT_MODE];
								}
									echo number_format($montant_especes, $TARIFS_NB_DECIMALES, ".", ""	)." ".$MONNAIE[1];
								?>
								</td>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td class="caisse_text_2">Ch&egrave;ques</td>
								<td align="right" class="caisse_text_1">
								<?php
								if (isset($totaux_theoriques[$CHQ_E_ID_REGMT_MODE]) ) {
									echo number_format($totaux_theoriques[$CHQ_E_ID_REGMT_MODE], $TARIFS_NB_DECIMALES, ".", ""	)." ".$MONNAIE[1];
								}
								?>					</td>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td class="caisse_text_2">CB</td>
								<td align="right" class="caisse_text_1">
								<?php
								if (isset($totaux_theoriques[$CB_E_ID_REGMT_MODE]) ) {
									echo number_format($totaux_theoriques[$CB_E_ID_REGMT_MODE], $TARIFS_NB_DECIMALES, ".", ""	)." ".$MONNAIE[1];
								}
								?>					</td>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td colspan="2" class="line_caisse_bottom">&nbsp;</td>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td colspan="2">
								<br />
								<?php if ($last_date_controle) {?>
								<div style="float:left; color:#999999">Dernier contrôle: <?php echo date_Us_to_Fr($last_date_controle)." ".getTime_from_date ($last_date_controle);?></div>
								<?php } ?>
								<span style="color:#97bf0d; float:right">
								<span id="controle_caisse_<?php echo $compte_caisse->getId_compte_caisse(); ?>"  class="green_underlined"  ><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_controler.gif" />
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
										Type
									</td>
									<td style="width:15%; text-align:right; font-weight:bolder">Débit</td>
									<td style="width:15%; text-align:right; font-weight:bolder">Crédit</td>
								</tr>
							<?php 
							$solde_page = 0;
							$colorise=0;
							foreach ($fiches as $fiche) {
							$colorise++;
							?>
							<tr class="colorise1">
								<td style="text-align: left">
								<?php	if (isset($fiche->date_move)) { echo date_Us_to_Fr($fiche->date_move)." ".getTime_from_date($fiche->date_move); } ?>
								</td>
								<td>
								<a  href="#" id="link_reg_ref_<?php echo htmlentities($fiche->id_compte_caisse_move)?>" style="display:block; width:100%">
								<span style="font-weight:bolder"><?php	 echo htmlentities($fiche->lib_move_type);?></span> 
								<?php	
								if (isset($fiche->lib_reglement_mode)) {
									echo nl2br(htmlentities($fiche->lib_reglement_mode));
								}	
								?>
								</a>
								<?php 
								if (isset($fiche->id_move_type) && $fiche->id_move_type == "7") {
								?>
								<div id="info_7_<?php echo htmlentities($fiche->id_compte_caisse_move)?>" style="display:none">
								</div>
								<?php
								}
								?>
								<script type="text/javascript">
								<!--
								Event.observe("link_reg_ref_<?php echo htmlentities($fiche->id_compte_caisse_move) ?>", "click", function(evt){ 
									Event.stop(evt);
									<?php 
									if (isset($fiche->id_reglement_mode) && ($fiche->id_reglement_mode == 1 || $fiche->id_reglement_mode == 7 || $fiche->id_reglement_mode == 2 || $fiche->id_reglement_mode == 3)) {
									?>
									page.traitecontent('compta_reglements_edition','compta_reglements_edition.php?ref_reglement=<?php echo $fiche->Info_supp;?>','true','edition_reglement');
									$("edition_reglement").show();
									$("edition_reglement_iframe").show();
									<?php
									} 
									if (isset($fiche->id_move_type) && $fiche->id_move_type == "6") {
									?>
										page.verify("compta_controle_caisse_imprimer", "compta_controle_caisse_imprimer.php?id_caisse=<?php echo $compte_caisse->getId_compte_caisse();?>&id_compte_caisse_controle=<?php echo $fiche->Info_supp; ?>", "true", "_blank");
									<?php
									} 
									if (isset($fiche->id_move_type) && $fiche->id_move_type == "2") {
									?>
										page.verify("compta_transfert_caisse_imprimer", "compta_transfert_caisse_imprimer.php?id_caisse=<?php echo $compte_caisse->getId_compte_caisse();?>&id_compte_caisse_transfert=<?php echo $fiche->Info_supp; ?>", "true", "_blank");
									<?php
									} 
									if (isset($fiche->id_move_type) && $fiche->id_move_type == "4") {
									?>
										page.verify("compta_depot_caisse_imprimer", "compta_depot_caisse_imprimer.php?id_caisse=<?php echo $compte_caisse->getId_compte_caisse();?>&id_compte_caisse_depot=<?php echo $fiche->Info_supp; ?>", "true", "_blank");
									<?php 
									}
									if (isset($fiche->id_move_type) && $fiche->id_move_type == "3") { 
									?>
										page.verify("compta_retrait_bancaire_caisse_imprimer", "compta_retrait_bancaire_caisse_imprimer.php?id_caisse=<?php echo $compte_caisse->getId_compte_caisse();?>&id_compte_caisse_retrait=<?php echo $fiche->Info_supp; ?>", "true", "_blank");
									<?php 
									}
									if (isset($fiche->id_move_type) && $fiche->id_move_type == "7") { 
									?>
										$("info_7_<?php echo ($fiche->id_compte_caisse_move)?>").show();
										if ($("info_7_<?php echo ($fiche->id_compte_caisse_move)?>").innerHTML == "") {
											page.verify("compta_ar_fonds_caisse_affiche", "compta_ar_fonds_caisse_affiche.php?id_compte_caisse=<?php echo $compte_caisse->getId_compte_caisse();?>&id_compte_caisse_ar=<?php echo $fiche->Info_supp; ?>", "true", "info_7_<?php echo ($fiche->id_compte_caisse_move)?>");
										}
									<?php
									}
									?>
								}, false);
								-->
								</script>
								</td>
								<?php
								$solde_page += number_format($fiche->montant_move, $TARIFS_NB_DECIMALES, ".", ""	);
								?>
								<td style="text-align:right">
								<?php if ($fiche->montant_move < 0 ) {?>
									<span style="color:#FF0000">
									<?php	if (isset($fiche->montant_move)) { 
									echo number_format($fiche->montant_move, $TARIFS_NB_DECIMALES, ".", ""	)." ".$MONNAIE[1]; }
									?>
									</span>
								<?php } ?>
								</td>
								<td style="text-align:right">
								<?php if ($fiche->montant_move >= 0 ) {?>
									<span>
									<?php	if (isset($fiche->montant_move)) { 
									echo number_format($fiche->montant_move, $TARIFS_NB_DECIMALES, ".", ""	)." ".$MONNAIE[1]; }
									?>
									</span>
								<?php } ?>
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
						<span id="historique_mouvement_caisse_<?php echo $compte_caisse->getId_compte_caisse(); ?>" style="cursor:pointer; color:#999999; text-decoration:underline">
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
					<?php $comptes_caisses	= compte_caisse::charger_comptes_caisses("", "1");
					$nbrecaisses = sizeof($comptes_caisses);
					if ($nbrecaisses > 1) {?>
					<span id="transfert_fonds" class="grey_caisse"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/puce_bleue.gif"  style="padding-right:10px; float:left" vspace="3" /> Transfert entre caisses</span><br /><br />
					<?php } ?>
					<span id="remise_bancaire" class="grey_caisse"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/puce_bleue.gif"  style="padding-right:10px; float:left" vspace="3" /> Remise en banque</span><br /><br />

					<span id="retrait_bancaire" class="grey_caisse"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/puce_bleue.gif"  style="padding-right:10px; float:left" vspace="3" /> Retrait bancaire</span><br /><br />

						<br />
					<span id="ajout_retrait_fonds" class="grey_caisse" ><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/puce_bleue.gif"  style="padding-right:10px; float:left" vspace="3" /> Enregistrer une opération</span><br /><br />

						<span id="controle_caisse_historique_<?php echo $compte_caisse->getId_compte_caisse(); ?>" class="grey_caisse" ><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/puce_bleue.gif"  style="padding-right:10px; float:left" vspace="3" />  Historique des op&eacute;rations de gestion
						</span>
					<br />
					<br />
					<br />

					</div>
						<script type="text/javascript">
						<?php
						if ($nbrecaisses > 1) {
						?>
						Event.observe("transfert_fonds", "click", function(evt){
							Event.stop(evt);
							page.verify("compta_transfert_fonds_caisse", "compta_transfert_fonds_caisse.php?id_caisse=<?php echo $compte_caisse->getId_compte_caisse(); ?>", "true", "sub_content");
						}, false);
						<?php 
						}
						?>
						//remise (ou dépot bancaire)
						Event.observe("remise_bancaire", "click", function(evt){
							Event.stop(evt);
							page.verify("compta_remise_bancaire_caisse", "compta_remise_bancaire_caisse.php?id_caisse=<?php echo $compte_caisse->getId_compte_caisse(); ?>", "true", "sub_content");
						}, false);
						Event.observe("retrait_bancaire", "click", function(evt){
							Event.stop(evt);
							page.verify("compta_retrait_bancaire_caisse", "compta_retrait_bancaire_caisse.php?id_caisse=<?php echo $compte_caisse->getId_compte_caisse(); ?>", "true", "sub_content");
						}, false);
						Event.observe("ajout_retrait_fonds", "click", function(evt){
							Event.stop(evt);
							page.verify("compta_ar_fonds_caisse", "compta_ar_fonds_caisse.php?id_caisse=<?php echo $compte_caisse->getId_compte_caisse(); ?>", "true", "sub_content");
						}, false);
						
						//Event.observe("raz_caisse", "click", function(evt){
						//	Event.stop(evt);
						//	page.verify("compta_raz_caisse", "compta_raz_caisse.php?id_caisse=<?php echo $compte_caisse->getId_compte_caisse(); ?>", "true", "sub_content");
						//}, false);
						</script>
			</td>
		</tr>
</table>
</div>
</div>
<br />
<br />
<br />
</div>

<SCRIPT type="text/javascript">
function setheight_gestion_caisse(){
	set_tomax_height("corps_gestion_caisses" , -32);
}

Event.observe(window, "resize", setheight_gestion_caisse, false);
setheight_gestion_caisse();

Event.observe("controle_caisse_<?php echo $compte_caisse->getId_compte_caisse(); ?>", "click", 
	function(evt){
		Event.stop(evt);
		page.verify("compta_controle_caisse", "compta_controle_caisse.php?id_caisse=<?php echo $compte_caisse->getId_compte_caisse(); ?>", "true", "sub_content");
	}, false);
Event.observe("controle_caisse_historique_<?php echo $compte_caisse->getId_compte_caisse(); ?>", "click", 
	function(evt){
		Event.stop(evt);
		page.verify("compta_controle_caisse_historique", "compta_controle_caisse_historique.php?id_caisse=<?php echo $compte_caisse->getId_compte_caisse(); ?>", "true", "sub_content");
	}, false);

Event.observe("historique_mouvement_caisse_<?php echo $compte_caisse->getId_compte_caisse(); ?>", "click", 
	function(evt){
		Event.stop(evt);
		page.verify("compta_mouvement_caisse", "compta_mouvement_caisse.php?id_caisse=<?php echo $compte_caisse->getId_compte_caisse(); ?>", "true", "sub_content");
	}, false);
//on masque le chargement
H_loading();
</SCRIPT>