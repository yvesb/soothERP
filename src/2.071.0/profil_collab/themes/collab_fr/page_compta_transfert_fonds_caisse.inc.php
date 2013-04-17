<?php

// *************************************************************************************************************
// Transfert de fonds
// *************************************************************************************************************

// Variables nécessaires à l"affichage
$page_variables = array ();
check_page_variables ($page_variables);

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

?>
<script type="text/javascript">

array_menu_v_transfert	=	new Array();
array_menu_v_transfert[0] 	=	new Array('transfert_caisse', 'chemin_etape_0');
array_menu_v_transfert[1] 	=	new Array('transfert_especes', 'chemin_etape_1');
array_menu_v_transfert[2] 	=	new Array('transfert_cheques', 'chemin_etape_2');
array_menu_v_transfert[3] 	=	new Array('transfert_validation', 'chemin_etape_3');


	
</script>
<div class="emarge"><br />

<iframe frameborder="0" scrolling="no" src="about:_blank" id="edition_reglement_iframe" class="edition_reglement_iframe" style="display:none"></iframe>
<div id="edition_reglement" class="edition_reglement" style="display:none">
</div>
<span style="float:right"><br />
<a  href="#" id="link_retour_caisse" style="float:right" class="common_link">retour au tableau de bord</a>
</span>
<script type="text/javascript">
Event.observe("link_retour_caisse", "click",  function(evt){Event.stop(evt); page.verify('compta_gestion2_caisse','compta_gestion2_caisse.php?id_caisse=<?php echo $_REQUEST["id_caisse"];?>','true','sub_content');}, false);
</script>
<div class="titre" style="width:60%; padding-left:140px">Transfert de fonds depuis <?php echo htmlentities($compte_caisse->getLib_caisse()); ?>
</div>


<div class="emarge" style="text-align:right" >
<div  id="corps_gestion_caisses">
<table width="950px" height="350px" border="0" align="right" cellpadding="0" cellspacing="0" >
	<tr>
	<td rowspan="2" style="width:50px; height:50px; background-color:#FFFFFF">
		<div style="position:relative; top:-35px; left:-35px; width:105px; border:1px solid #999999; background-color:#FFFFFF; text-align:center">
		<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/ico_caisse.jpg" />				</div>
		<span style="width:35px">
		<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="50px" height="20px" id="imgsizeform"/>				</span>			
	</td>
	<td colspan="2" style="width:85%; background-color:#FFFFFF" >
	
	<br />
	<br />
	<br />
		
	<form action="compta_transfert_fonds_caisse_create.php" target="formFrame" method="post" name="transfert_caisse_create" id="transfert_caisse_create">
	<div >
		<input id="id_compte_caisse" name="id_compte_caisse"  value="<?php echo $compte_caisse->getId_compte_caisse(); ?>"  type="hidden">
		
		<table class="chemin_table" border="0"  cellspacing="0">
			<tr>
				<td style="width:6%">&nbsp;</td>
				<td class="chemin_numero_choisi" style="width:2%" id="chemin_etape_0_2">1</td>
				<td style="width:6%" class="chemin_fleche_grisse">&nbsp;</td>
				<td style="width:6%" class="chemin_fleche_grisse">&nbsp;</td>
				<td class="chemin_numero_gris" style="width:2%" id="chemin_etape_1_2">2</td>
				<td style="width:6%" class="chemin_fleche_grisse" >&nbsp;</td>
				<td style="width:6%" class="chemin_fleche_grisse" >&nbsp;</td>
				<td class="chemin_numero_gris" style="width:2%" id="chemin_etape_2_2">3</td>
				<td style="width:6%" class="chemin_fleche_grisse" >&nbsp;</td>
				<td style="width:6%" class="chemin_fleche_grisse" >&nbsp;</td>
				<td class="chemin_numero_gris" style="width:2%" id="chemin_etape_3_2">4</td>
				<td style="width:6%"  >&nbsp;</td>
				<td style="width:2%">&nbsp;</td>
			</tr>
			<tr>
				<td colspan="3" class="chemin_texte_choisi" style="width:14%" id="chemin_etape_0_3">Caisse</td>
				<td colspan="3" class="chemin_texte_gris" style="width:14%" id="chemin_etape_1_3">Espèces</td>
				<td colspan="3" class="chemin_texte_gris" style="width:14%" id="chemin_etape_2_3">Chèques</td>
				<td colspan="3" class="chemin_texte_gris" style="width:14%" id="chemin_etape_3_3">Validation</td>
				<td style="width:2%"></td>
				</tr>
		</table>
		<br />
	</div>
	
	
	<div id="transfert_especes"  style="width:100%; display:none "  >
		<table width="100%" cellpadding="0" cellspacing="0" border="0">
		<tr>
			<td style=" font-weight:bolder; color:#97bf0d;">
			</td>
			<td style="text-align:right">
			
			<div id="bt_etape_1" style=" cursor:pointer; font-weight:bolder; color:#97bf0d;" >
				<span style="padding-right:80px">&gt;&gt;&gt; Etape suivante</span> 
			</div>
			</td>
		</tr>
		<tr>
			<td colspan="2">
			<br />
			<span class="controle_sub_title">ESPECES</span><br /><br />
			<div style="width:95%;">
			Le <?php 
					setlocale(LC_TIME, $INFO_LOCALE);
					echo lmb_strftime("%d %B %Y", $INFO_LOCALE, strtotime(date("d M Y")))." ".date("h:i") ;
					?><br />
			<br />
			<div  class="line_caisse_bottom"></div>
	
	
			
			</div>
			</td>
		</tr>
		<tr>
			<td>
			<div style="width:100%" ><br />
			
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				
				<tr>
					<td align="right" colspan="4" style="font-weight:bolder; ">
					<span style="width:40px; float:right ">&gt;&gt;&gt;</span> 
					<span style=" ">Solde disponible</span>
					</td>
					<td align="right" >
					<span id="toto_esp_theorique2" style="text-align:right;">
					<?php
					$montant_especes = 0;
					if (isset($totaux_theoriques[$ESP_E_ID_REGMT_MODE])) {
						echo number_format($totaux_theoriques[$ESP_E_ID_REGMT_MODE], $TARIFS_NB_DECIMALES, ".", ""	);
					} else {
						echo "0.00";
					}
					?>
					</span> 
					<?php
						echo "&nbsp;". $MONNAIE[1];
					?>
					</td>
					<td >
					<div style="width:10px"></div>
					</td>
				</tr>
			</table>
			</div>
			</td>
			<td>
			<table width="310" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td align="right" style="width:85px;">&nbsp;</td>
					<td style="width:10px">&nbsp;</td>
					<td align="center" style="font-weight:bolder; width:85px;">Qté</td>
					<td style="width:10px">&nbsp;</td>
					<td align="right" style="font-weight:bolder; width:160px;">Total</td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td colspan="5">
					<div style="height:5px"></div>
					</td>
					<td></td>
				</tr>
				<?php 
				foreach ($MONNAIE[5] as $espece) {
				
					?>
					<tr>
						<td align="right"><?php echo $espece."&nbsp;".$MONNAIE[1];?></td>
						<td>&nbsp;</td>
						<td align="center"><input type="text" class="classinput_nsize" size="5" name="ESP_<?php echo str_replace(".", "", $espece);?>" id="ESP_<?php echo str_replace(".", "", $espece);?>"/></td>
						<td>&nbsp;</td>
						<td align="right"><span id="T_ESP_<?php echo str_replace(".", "", $espece);?>"></span> <?php echo "&nbsp;".$MONNAIE[1];?></td>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td colspan="5">
						<div style="height:5px"></div>
						</td>
						<td></td>
					</tr>
					<?php
				}
				?>
				</table>
			</td>
			</tr>
			<tr class="controle_color_toto">
			<td>
			</td>
			<td>
			<table width="310" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td align="right" style="width:85px; height:1px; line-height:1px">&nbsp;</td>
					<td style="width:10px; height:1px; line-height:1px">&nbsp;</td>
					<td align="center" style="font-weight:bolder; width:85px; height:1px; line-height:1px;">&nbsp;</td>
					<td style="width:10px; height:1px; line-height:1px">&nbsp;</td>
					<td align="right" style="font-weight:bolder; width:160px; height:1px; line-height:1px;">&nbsp;</td>
					<td style="height:1px; line-height:1px">&nbsp;</td>
				</tr>
				<tr>
					<td align="right" colspan="4" style="font-weight:bolder; ">
					<div style="height:25px; line-height:25px; " class="controle_color_toto">
					Montant&nbsp;transféré: 
					</div>
					</td>
					<td align="right" class="controle_color_toto">
					<span id="TT_ESP" name="TT_ESP">0.00</span><?php echo "&nbsp;". $MONNAIE[1];?>
					</td>
					<td class="controle_color_toto">
					<div style="width:10px"></div>
					</td>
				</tr>
				<tr>
					<td align="right" colspan="4" style="font-weight:bolder; ">
					<div style="height:25px; line-height:25px; " class="controle_color_toto">
					Fond de caisse restant: 
					</div>
					</td>
					<td align="right" class="controle_color_toto">
					<span id="RT_ESP" name="RT_ESP"><?php
					$montant_especes = 0;
					if (isset($totaux_theoriques[$ESP_E_ID_REGMT_MODE])) {
						echo number_format($totaux_theoriques[$ESP_E_ID_REGMT_MODE], $TARIFS_NB_DECIMALES, ".", ""	);
					} else {
						echo "0.00";
					}
					?></span> <?php echo "&nbsp;". $MONNAIE[1];?></td>
					<td class="controle_color_toto">
					<div style="width:10px"></div>
					</td>
				</tr>
			</table>
			</td>
			</tr>
		</table>
		<div style="height:25px">
		</div>
		<br />
	</div>
	
	
	
	
	
	<div  id="transfert_cheques"  style="width:100%; display:none ">
		<table width="100%" cellpadding="0" cellspacing="0" border="0">
		<tr>
			<td style=" font-weight:bolder; color:#97bf0d;">
			</td>
			<td style="text-align:right">
			
			<div id="bt_etape_2" style=" cursor:pointer; font-weight:bolder; color:#97bf0d;" >
				<span style="padding-right:80px">&gt;&gt;&gt; Etape suivante</span> 
			</div>
			</td>
		</tr>
		<tr>
			<td  colspan="2"><br />
			<span class="controle_sub_title">CHEQUES </span><br /><br />
			<div style="width:95%;">
			Le <?php 
					setlocale(LC_TIME, $INFO_LOCALE);
					echo lmb_strftime("%d %B %Y", $INFO_LOCALE, strtotime(date("d M Y")))." ".date("h:i") ;
					?><br />
			<br />
			<div  class="line_caisse_bottom"></div>
	
	
			
			</div>
			</td>
		</tr>
		<tr>
			<td><br />

			
			<div style="width:350px;">
				<div>
					<span style="width:120px; float:left">Solde Théorique</span>
					<span style="width:40px; float:left ">&gt;&gt;&gt;</span> 
					<span id="toto_chq_theorique2" style="text-align:right; width:65px; float:left">
					<?php
					$montant_especes = 0;
					if (isset($totaux_theoriques[$CHQ_E_ID_REGMT_MODE])) {
						echo number_format($totaux_theoriques[$CHQ_E_ID_REGMT_MODE], $TARIFS_NB_DECIMALES, ".", ""	);
					} else {
						echo "0.00";
					}
					?>
					</span> 
					<?php
						echo "&nbsp;". $MONNAIE[1];
					?> <span style="padding-left:10px">(<?php
					if (isset($count_chq_theoriques)) {
						echo count($count_chq_theoriques);
					} 
					?> chèque(s))</span>
				</div><br />
	
			
			</div>
		
		
		</td>
		<td style="text-align:left">
		<div style=" width:190px;"><br />
		<?php
		for ($j = 0 ; $j <count($count_chq_theoriques) ; $j++ ) {
			?>
			<div class="ligne_chq" id="ligne_exist_chq_<?php echo $j;?>">
				<div class="inner_ligne_chq"><?php echo $j+1;?>:</div>
				<input name="EXIST_CHQ_<?php echo $j;?>" type="hidden" id="EXIST_CHQ_<?php echo $j;?>" value="<?php echo $count_chq_theoriques[$j]->montant_contenu;?>;<?php echo $count_chq_theoriques[$j]->infos_supp;?>" />
				<span id="view_info_reg_<?php echo $count_chq_theoriques[$j]->infos_supp;?>" <?php if (trim($count_chq_theoriques[$j]->infos_supp)) {?> style="cursor:pointer"<?php }?>><?php echo number_format($count_chq_theoriques[$j]->montant_contenu, $TARIFS_NB_DECIMALES, ".", ""	);?> </span>
				<script type="text/javascript">
					<?php if (trim($count_chq_theoriques[$j]->infos_supp)) {?>
						Event.observe("view_info_reg_<?php echo $count_chq_theoriques[$j]->infos_supp;?>", "click",  function(evt){Event.stop(evt);
							page.traitecontent('compta_reglements_edition','compta_reglements_edition.php?ref_reglement=<?php echo $count_chq_theoriques[$j]->infos_supp;?>','true','edition_reglement');
							$("edition_reglement").show();
							$("edition_reglement_iframe").show();
						}, false);
						<?php
					}
					?>
				</script>
				<?php echo "&nbsp;". $MONNAIE[1];?> 
				<input name="CHK_EXIST_CHQ_<?php echo $j;?>" type="checkbox" id="CHK_EXIST_CHQ_<?php echo $j;?>" value="<?php echo $count_chq_theoriques[$j]->montant_contenu;?>" />
				<script type="text/javascript">
					Event.observe($("CHK_EXIST_CHQ_<?php echo $j;?>"), "click", function(evt){
						calcul_transfert_caisse ();
						 calcul_transfert_caisse_chq ();
					}
					);
				</script>
				<div style="height:5px"></div>
			</div>
			<?php
		}
		?>
		<?php
		$indentation_controle_cheques = 0; 
		for ($i=0; $i<=$indentation_controle_cheques ; $i++) {
			?>
			<div class="ligne_chq" id="ligne_chq_<?php echo $i;?>">
			<div class="inner_ligne_chq" style="width:55px">&nbsp;</div>
			<input name="CHQ_<?php echo $i;?>" type="text" class="classinput_nsize" id="CHQ_<?php echo $i;?>" size="15" style="text-align:right"/> <?php echo "&nbsp;". $MONNAIE[1];?>
			<script type="text/javascript">
				Event.observe($("CHQ_<?php echo $i;?>"), "blur", function(evt){
					nummask(evt, 0, "X.X");
					Event.stop(evt); 
					calcul_transfert_caisse ();
					calcul_transfert_caisse_chq ();
				}
				);
			</script>
			<div style="height:5px"></div>
			</div>
			<?php
			
		}
		?>
		<div style="text-align:right; cursor:pointer; width:190px; " id="add_line_chq">Ajouter un chèque</div>
		
			<script type="text/javascript">
				Event.observe($("add_line_chq"), "click", function(evt){
					insert_new_transfert_line_chq ();
				}
				);
			</script>
		
			
		<input name="indentation_exist_cheques" type="hidden" id="indentation_exist_cheques" value="<?php echo (count($count_chq_theoriques) - 1);?>"/>
		<input name="indentation_controle_cheques" type="hidden" id="indentation_controle_cheques" value="<?php echo $indentation_controle_cheques;?>"/>
		
			<div style="width:190px;text-align:right; " class="controle_color_toto">
				<div style="width:40px; float:left; height:25px; line-height:25px; padding-left:5px; font-weight:bolder">Total: </div>
			<div style="width:190px;  height:25px; line-height:25px; padding-right:10px" class="controle_color_toto"><span id="TT_CHQ">0.00</span> <?php echo "&nbsp;". $MONNAIE[1];?></div>
			</div>
			
			<div style="height:25px">
			</div>
		</div>	
		</td>
		</tr>
		</table>
	</div>
	
	
	<div id="transfert_caisse"  style=" width:100%;">
	
	
		<table width="100%" cellpadding="0" cellspacing="0" border="0">
		<tr>
			<td style=" font-weight:bolder; color:#97bf0d;">
			</td>
			<td style="text-align:right">
			
			<div id="bt_etape_0" style=" cursor:pointer; font-weight:bolder; color:#97bf0d;" >
				<span style="padding-right:80px">&gt;&gt;&gt; Etape suivante</span> 
			</div>
			</td>
		</tr>
		<tr>
			<td colspan="2">
			<br />
			<span class="controle_sub_title">CAISSE </span><br /><br />
			<div style="width:95%;">
			Le <?php 
					setlocale(LC_TIME, $INFO_LOCALE);
					echo lmb_strftime("%d %B %Y", $INFO_LOCALE, strtotime(date("d M Y")))." ".date("h:i") ;
					?><br />
			<br />
			<div  class="line_caisse_bottom"></div>
	
	
			
			</div>
			<br /><br />

			Choix de la caisse de destination:
			<select id="id_compte_caisse_destination" name="id_compte_caisse_destination">
			<?php 
			foreach ($comptes_caisses as $compte_c) {
				if ($_REQUEST["id_caisse"] == $compte_c->id_compte_caisse) {continue;}
				?>
				<option value="<?php echo $compte_c->id_compte_caisse;?>"><?php echo $compte_c->lib_caisse;?></option>
				<?php
			}
			?>
			</select>
			</div>
		
		
		</td>
		
		</tr>
		</table>
	</div>
	
	<div  id="transfert_validation"  style="width:100%; display:none  ">
	<table width="100%" cellpadding="0" cellspacing="0" border="0">
		<tr>
			<td style=" font-weight:bolder; color:#97bf0d;">
			</td>
			<td style="text-align:right">
			
			</td>
		</tr>
		<tr>
			<td colspan="2">
		<div class="emarge"><br />
			<span class="controle_sub_title">Validation </span><br /><br />
			<div style="width:95%;">
			Le <?php 
					setlocale(LC_TIME, $INFO_LOCALE);
					echo lmb_strftime("%d %B %Y", $INFO_LOCALE, strtotime(date("d M Y")))." ".date("h:i") ;
					?><br />
			<br />
			<div  class="line_caisse_bottom"></div>
	
	
			
			</div>
			<br />
			Transfert de fonds : <?php echo htmlentities($compte_caisse->getLib_caisse()); ?>  à destination de <span id="selected_caisse_dest">
			</span>
			<br />
			<br />
			<table width="780" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td style="width:135px" class="line_compta_bottom_rigth"><div style="width:135px; height:50px"></div></td>
					<td colspan="2" align="center" valign="middle" class="line_compta_bottom">
					<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-espece.gif"/>		</td>
					<td align="center" valign="middle" class="line_compta_bottom_rigth">&nbsp;</td>
					<td colspan="2" align="center" valign="middle" class="line_compta_bottom">
					<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-cheque.gif"/>		</td>
					<td align="center" valign="middle" class="line_compta_bottom_rigth">&nbsp;</td>
					<td valign="middle" class="line_compta_bottom" align="center">
					<div style="width:75px; height:35px; line-height:35px;">TOTAL</div>
					</td>
				</tr>
				<tr>
					<td height="35" valign="middle" class="line_compta_bottom_rigth">
					<div style="width:135px; height:35px; line-height:35px;">Solde disponible</div>		</td>
					<td height="35" align="right" valign="middle" class="line_compta_bottom">
					<div style="width:75px; height:35px; line-height:35px;">
					<span id="toto_esp_theorique"><?php
					$montant_especes = 0;
					if (isset($totaux_theoriques[$ESP_E_ID_REGMT_MODE]) && $totaux_theoriques[$ESP_E_ID_REGMT_MODE]) {
						$montant_especes += $totaux_theoriques[$ESP_E_ID_REGMT_MODE];
					}
						echo number_format($montant_especes, $TARIFS_NB_DECIMALES, ".", ""	);
					?></span><?php
						echo "&nbsp;". $MONNAIE[1];
					?>
					</div>		</td>
					<td height="35" valign="middle" class="line_compta_bottom">&nbsp;</td>
					<td height="35" valign="middle" class="line_compta_bottom_rigth">&nbsp;</td>
					<td height="35" align="right" valign="middle" class="line_compta_bottom">
					<div style="width:75px; height:35px; line-height:35px;">
					<span id="toto_chq_theorique"><?php
					if (isset($totaux_theoriques[$CHQ_E_ID_REGMT_MODE]) && $totaux_theoriques[$CHQ_E_ID_REGMT_MODE]) {
						echo number_format($totaux_theoriques[$CHQ_E_ID_REGMT_MODE], $TARIFS_NB_DECIMALES, ".", ""	);
					} else {
						echo "0.00";
					}
					?></span><?php
						echo "&nbsp;". $MONNAIE[1];
					?>
					</div>		</td>
					<td height="35" valign="middle" class="line_compta_bottom">
					<div style="width:35px; height:35px; line-height:35px;">
					<div style="padding-left:10px">
					(<?php
					if (isset($count_chq_theoriques)) {
						echo count($count_chq_theoriques);
					}
					?>)</div>	
					</div>
					</td>
					<td height="35" valign="middle" class="line_compta_bottom_rigth">&nbsp;</td>
					<td valign="middle" class="line_compta_bottom" align="right">
					<div style="width:75px; height:35px; line-height:35px; padding-right:10px">
					<span id="toto_theo"></span><?php echo "&nbsp;". $MONNAIE[1];?>		</div>
					</td>
				</tr>
				<tr>
					<td height="35" valign="middle" class="line_compta_bottom_rigth">
					<div style="width:135px; height:35px; line-height:35px;">Solde transféré</div>		</td>
					<td height="35" align="right" valign="middle" class="line_compta_bottom">
					<div style="width:75px; height:35px; line-height:35px;">
					<span id="toto_esp_saisie"></span><?php echo "&nbsp;". $MONNAIE[1];?>		</div>		</td>
					<td height="35" valign="middle" class="line_compta_bottom"><div style="width:35px;"></div></td>
					<td height="35" valign="middle" class="line_compta_bottom_rigth">&nbsp;</td>
					<td height="35" align="right" valign="middle" class="line_compta_bottom">
					<div style="width:75px; height:35px; line-height:35px;">
					<span id="toto_chq_saisie"></span><?php echo "&nbsp;". $MONNAIE[1];?>		</div>		</td>
					<td height="35" valign="middle" class="line_compta_bottom">
					<div style="width:35px; height:35px; line-height:35px;">
					<span style="padding-left:10px">(<span id="saisie_op_cheques"></span>)</span></div>		</td>
					<td height="35" valign="middle" class="line_compta_bottom_rigth">&nbsp;</td>
					<td valign="middle" class="line_compta_bottom" align="right">
					<div style="width:75px; height:35px; line-height:35px; padding-right:10px">
					<span id="toto_saisie"></span><?php echo "&nbsp;". $MONNAIE[1];?>		</div>
					
					</td>
				</tr>
				<tr>
					<td height="35" valign="middle" class="line_compta_right">
					<div style="width:135px; height:35px; line-height:35px; font-weight:bolder">Solde restant</div>		</td>
					<td height="35" valign="middle" align="right">
					<div style="width:75px; height:35px; line-height:35px; font-weight:bolder;">
					<span id="diff_esp"></span><?php echo "&nbsp;". $MONNAIE[1];?>		</div>		</td>
					<td height="35" valign="middle">&nbsp;</td>
					<td height="35" valign="middle" class="line_compta_right">&nbsp;</td>
					<td height="35" valign="middle" align="right">
					<div style="width:75px; height:35px; line-height:35px; font-weight:bolder;">
					<span id="diff_chq"></span><?php echo "&nbsp;". $MONNAIE[1];?>		</div>		</td>
					<td height="35" valign="middle">&nbsp;</td>
					<td height="35" valign="middle" class="line_compta_right">&nbsp;</td>
					<td valign="middle" align="right">
					<div style="width:75px; height:35px; line-height:35px; padding-right:10px">
					<span id="toto_diff"></span><?php echo "&nbsp;". $MONNAIE[1];?>		</div></td>
				</tr>
			</table>
			<br />
			
			<br />
			<br />
			<span style="font-weight:bolder">Informations:</span>   <span id="commentaire_add" style="color:#FF0000"></span><br />
			
			<textarea name="commentaire" rows="6" class="classinput_xsize" id="commentaire" style=" width:800px"></textarea>

			<div style="text-align:right">
			<img id="bt_etape_3" style=" cursor:pointer; font-weight:bolder; color:#97bf0d; " src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-valider.gif" />
			</div>
			</div>
			<br />
			<br />
			
			<input type="hidden" value="0" id="montant_transfert_esp" name="montant_transfert_esp" />
			<input type="hidden" value="0" id="montant_transfert_chq" name="montant_transfert_chq" />
			<input type="hidden" value="0" id="montant_theorique" name="montant_theorique" />
			<input type="hidden" value="0" id="montant_transfert" name="montant_transfert" />
		</td>
		</tr>
		</table>
	</div>
</form>


			</td>
		</tr>
</table>
</div>
</div>
</div>
<SCRIPT type="text/javascript">




Event.observe($("chemin_etape_0_2"), "click", function(evt){Event.stop(evt); step_menu_transfert ('transfert_caisse', 'chemin_etape_0', array_menu_v_transfert);});
Event.observe($("chemin_etape_0_3"), "click", function(evt){Event.stop(evt); step_menu_transfert ('transfert_caisse', 'chemin_etape_0', array_menu_v_transfert);});

Event.observe($("bt_etape_0"), "click", function(evt){Event.stop(evt); step_menu_transfert ('transfert_especes', 'chemin_etape_1', array_menu_v_transfert);});

Event.observe($("chemin_etape_1_2"), "click", function(evt){Event.stop(evt); step_menu_transfert ('transfert_especes', 'chemin_etape_1', array_menu_v_transfert);});
Event.observe($("chemin_etape_1_3"), "click", function(evt){Event.stop(evt);  step_menu_transfert ('transfert_especes', 'chemin_etape_1', array_menu_v_transfert);});

Event.observe($("bt_etape_1"), "click", function(evt){Event.stop(evt);  step_menu_transfert ('transfert_cheques', 'chemin_etape_2', array_menu_v_transfert);});

Event.observe($("chemin_etape_2_2"), "click", function(evt){Event.stop(evt);  step_menu_transfert ('transfert_cheques', 'chemin_etape_2', array_menu_v_transfert);});
Event.observe($("chemin_etape_2_3"), "click", function(evt){Event.stop(evt); step_menu_transfert ('transfert_cheques', 'chemin_etape_2', array_menu_v_transfert);});

Event.observe($("bt_etape_2"), "click", function(evt){ Event.stop(evt); step_menu_transfert ('transfert_validation', 'chemin_etape_3', array_menu_v_transfert);});

Event.observe($("chemin_etape_3_2"), "click", function(evt){Event.stop(evt); step_menu_transfert ('transfert_validation', 'chemin_etape_3', array_menu_v_transfert);});
Event.observe($("chemin_etape_3_3"), "click", function(evt){Event.stop(evt); step_menu_transfert ('transfert_validation', 'chemin_etape_3', array_menu_v_transfert);});

Event.observe($("bt_etape_3"), "click", function(evt){Event.stop(evt); $("transfert_caisse_create").submit();});


function next_if_Key_RETURN (event) {

	var key = event.which || event.keyCode; 
	switch (key) {   
	case Event.KEY_RETURN:  
		fi_id = false;
		for (i=0; i<array_especes.length; i++) {
			if (fi_id && $("ESP_"+array_especes[i].replace(".", ""))) { $("ESP_"+array_especes[i].replace(".", "")).focus(); break;}
			if (Event.element(event) == $("ESP_"+array_especes[i].replace(".", ""))) {
				fi_id = true;
			}
		}
		Event.stop(event);
	break;   
	}
}
// controle de changement dans les especes 

array_especes = Array(<?php echo '"'.implode("\",\"", $MONNAIE[5]).'"';?>);
	for (i=0; i<array_especes.length; i++) {
		Event.observe($("ESP_"+array_especes[i].replace(".", "")), "blur", function(evt){
			nummask(evt, 0, "X");
			Event.stop(evt); 
			
			calcul_transfert_caisse_esp (array_especes);
			step_menu_transfert ('transfert_especes', 'chemin_etape_1', array_menu_v_transfert);
		}
		);
		Event.observe($("ESP_"+array_especes[i].replace(".", "")), "keypress", function(evt){
			nummask(evt, 0, "X");
			
			next_if_Key_RETURN (evt);
			calcul_transfert_caisse_esp (array_especes);
			step_menu_transfert ('transfert_especes', 'chemin_etape_1', array_menu_v_transfert);
		}
		);
	}



Event.observe($("id_compte_caisse_destination"), "change", function(evt){
	calcul_transfert_caisse ();
});


$("selected_caisse_dest").innerHTML = $("id_compte_caisse_destination").options[$("id_compte_caisse_destination").selectedIndex].text;

// controle de changement dans les especes 

centrage_element("edition_reglement");
centrage_element("edition_reglement_iframe");

Event.observe(window, "resize", function(evt){
centrage_element("edition_reglement");
centrage_element("edition_reglement_iframe");
});
//on masque le chargement
H_loading();
</SCRIPT>