<?php

// *************************************************************************************************************
// controle de caisse
// *************************************************************************************************************

// Variables nécessaires à l"affichage
$page_variables = array ();
check_page_variables ($page_variables);

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

?>
<script type="text/javascript">

array_menu_v_controle	=	new Array();
array_menu_v_controle[0] 	=	new Array('controle_especes', 'chemin_etape_0');
array_menu_v_controle[1] 	=	new Array('controle_cheques', 'chemin_etape_1');
array_menu_v_controle[3] 	=	new Array('controle_cb', 'chemin_etape_2');
array_menu_v_controle[4] 	=	new Array('controle_validation', 'chemin_etape_3');


	
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
<div class="titre" style="width:60%; padding-left:140px">Contrôle <?php echo htmlentities($compte_caisse->getLib_caisse()); ?>
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
		
	<form action="compta_controle_caisse_create.php" target="formFrame" method="post" name="controle_caisse_create" id="controle_caisse_create">
	<div >
		<input id="id_compte_caisse" name="id_compte_caisse"  value="<?php echo $compte_caisse->getId_compte_caisse(); ?>"  type="hidden">
		
		<table class="chemin_table" border="0"  cellspacing="0">
			<tr>
				<td style="width:6%">&nbsp;</td>
				<td class="chemin_numero_choisi" style="width:2%" id="chemin_etape_0_2">1</td>
				<td style="width:6%" class="chemin_fleche_grisse">&nbsp;</td>
				<td style="width:6%" class="chemin_fleche_grisse">&nbsp;</td>
				<td class="chemin_numero_gris" style="width:2%" id="chemin_etape_1_2">2</td>
				<td style="width:6%"  class="chemin_fleche_grisse">&nbsp;</td>
				<td style="width:6%" class="chemin_fleche_grisse" >&nbsp;</td>
				<td class="chemin_numero_gris<?php if (!$compte_caisse->getId_compte_tpe ()) { ?>se<?php } ?>" style="width:2%" id="chemin_etape_2_2">3</td>
				<td style="width:6%" class="chemin_fleche_grisse" >&nbsp;</td>
				<td style="width:6%" class="chemin_fleche_grisse" >&nbsp;</td>
				<td class="chemin_numero_gris" style="width:2%" id="chemin_etape_3_2">4</td>
				<td style="width:6%"  >&nbsp;</td>
				<td style="width:2%">&nbsp;</td>
			</tr>
			<tr>
				<td colspan="3" class="chemin_texte_choisi" style="width:14%" id="chemin_etape_0_3">Espèces</td>
				<td colspan="3" class="chemin_texte_gris" style="width:14%" id="chemin_etape_1_3">Chèques</td>
				<td colspan="3" class="chemin_texte_gris<?php if (!$compte_caisse->getId_compte_tpe ()) { ?>se<?php } ?>" style="width:14%" id="chemin_etape_2_3">CB</td>
				<td colspan="3" class="chemin_texte_gris" style="width:14%" id="chemin_etape_3_3">Validation</td>
				<td style="width:2%"></td>
				</tr>
		</table>
		<br />
	</div>
	
	
	<div id="controle_especes">
		<table width="100%" cellpadding="0" cellspacing="0" border="0">
		<tr>
			<td style=" font-weight:bolder; color:#97bf0d;"><input type="checkbox" name="pass_esp" id="pass_esp" value="1" /> 
			Ignorer cette étape
			</td>
			<td style="text-align:right">
			
			<div id="bt_etape_0" style=" cursor:pointer; font-weight:bolder; color:#97bf0d;" >
				<span style="padding-right:80px">&gt;&gt;&gt; Etape suivante</span> 
			</div>
			</td>
		</tr>
		<tr>
			<td><br />
<br />

			<div style="width:320px;">
			Le <?php 
					setlocale(LC_TIME, $INFO_LOCALE);
					echo lmb_strftime("%d %B %Y", $INFO_LOCALE, strtotime(date("d M Y")))." ".date("h:i") ;
					?><br />
			<br />
			<br />
				<div>
					<span style="width:120px; float:left">Solde Théorique</span>
					<span style="width:40px; float:left ">&gt;&gt;&gt;</span> 
					<span id="toto_esp_theorique2" style="text-align:right; width:65px; float:left">
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
						echo "&nbsp;".$MONNAIE[1];
					?>
				</div><br />
	
				<div>
					<span style="width:120px; float:left">Solde Réél</span>
					<span style="width:40px; float:left ">&gt;&gt;&gt;</span> 
					<span id="toto_esp_saisie2" style="text-align:right; width:65px; float:left ">0.00</span><?php echo "&nbsp;".$MONNAIE[1];?>
				</div><br />
	
				<div style=" font-weight:bolder;">
					<span style="width:120px; float:left">Différentiel</span>
					<span style="width:40px; float:left ">&gt;&gt;&gt;</span> 
					<span id="diff_esp2" style="text-align:right; width:65px; float:left" >0.00</span><?php echo "&nbsp;".$MONNAIE[1];?>
				</div>
			<br />
			<br />
			<div  id="view_ope_spe" style="display:none">
			<table><tr><td style="width:85px">
			Ajout/Retrait
			</td><td style="width:115px">
			Montant
			</td><td>&nbsp;
			</td><td>Description
			</td></tr></table>
			</div>
			<div style="height:5px"></div>
			<div id="liste_ope_spe">
			</div>
			
			<input name="indentation_controle_ope_spe" type="hidden" id="indentation_controle_ope_spe" value="0"/>
			<input name="real_esp_theorique" type="hidden" id="real_esp_theorique" value="<?php echo number_format($totaux_theoriques[$ESP_E_ID_REGMT_MODE], $TARIFS_NB_DECIMALES, ".", ""	);?>"/>
				
			<div style="text-align:right; cursor:pointer; text-decoration:underline; width:190px;" id="add_line_ope">Ajouter une opération diverse</div>
			<br />
			<br />
	
			Les opérations diverses sont ajoutées pour corriger des oublis de mouvement de caisse en espèces avant la validation du contrôle.
			<script type="text/javascript">
				Event.observe($("add_line_ope"), "click", function(evt){
					$("view_ope_spe").show();
					insert_new_line_ope_spe ();
				}
				);
			</script>
			</div>
			</td>
			<td align="left">
			
		<div style="width:280px;"><br />
		
			<span class="controle_sub_title">ESPECES</span><br /><br />
			
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
				<tr>
				</tr>
			</table>
		</div>
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
					<td align="right" colspan="4" style="font-weight:bolder; ">
					<div style="height:25px; line-height:25px; " class="controle_color_toto">
					Montant total: 
					</div>
					</td>
					<td align="right" class="controle_color_toto"><span id="TT_ESP" style=" height:25px; line-height:25px;">0.00</span> <?php echo "&nbsp;".$MONNAIE[1];?></td>
					<td class="controle_color_toto">
					<div style="width:10px"></div>
					</td>
				</tr>
			</table>

		</td>
		</tr>
		</table>
		<div style="height:25px">
		</div><br />
		<br />
		<br />
	
	
	</div>
	
	
	
	
	
	<div  id="controle_cheques"  style="width:100%; display:none ">
		<table width="100%" cellpadding="0" cellspacing="0" border="0">
		<tr>
			<td style=" font-weight:bolder; color:#97bf0d;"><input type="checkbox" name="pass_chq" id="pass_chq" value="1" /> 
			Ignorer cette étape
			</td>
			<td style="text-align:right">
			
			<div id="bt_etape_1" style=" cursor:pointer; font-weight:bolder; color:#97bf0d;" >
				<span style="padding-right:80px">&gt;&gt;&gt; Etape suivante</span> 
			</div>
			</td>
		</tr>
		<tr>
			<td><br />
			<br />
			
			<div style="width:350px;">
			Le <?php 
					setlocale(LC_TIME, $INFO_LOCALE);
					echo lmb_strftime("%d %B %Y", $INFO_LOCALE, strtotime(date("d M Y")))." ".date("h:i");
					?><br />
			<br />
			<br /><br /><br />
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
						echo "&nbsp;".$MONNAIE[1];
					?> <span style="padding-left:10px">(<?php
					if (isset($count_chq_theoriques)) {
						echo count($count_chq_theoriques);
					} 
					?> chèque(s))</span>
				</div><br />
	
				<div>
					<span style="width:120px; float:left">Solde Réél</span>
					<span style="width:40px; float:left ">&gt;&gt;&gt;</span> 
					<span id="toto_chq_saisie2" style="text-align:right; width:65px; float:left ">0.00</span><?php echo "&nbsp;".$MONNAIE[1];?> <span style="padding-left:10px">(<span id="saisie_op_cheques2"></span> chèque(s))</span>
				</div><br />
	
				<div style=" font-weight:bolder;">
					<span style="width:120px; float:left">Différentiel</span>
					<span style="width:40px; float:left ">&gt;&gt;&gt;</span> 
					<span id="diff_chq2" style="text-align:right; width:65px; float:left" >0.00</span><?php echo "&nbsp;".$MONNAIE[1];?>
				</div>
			
			</div>
		
		
		</td>
		<td style="text-align:left">
		<div style="190px">
		<span class="controle_sub_title">CHEQUES</span><br /><br />
		<?php
		for ($j = 0 ; $j <count($count_chq_theoriques) ; $j++ ) {
			?>
			<div class="ligne_chq" id="ligne_exist_chq_<?php echo $j;?>">
				<div class="inner_ligne_chq"><?php echo $j+1;?>:</div>
				<input name="EXIST_CHQ_<?php echo $j;?>" type="hidden" id="EXIST_CHQ_<?php echo $j;?>" value="<?php echo $count_chq_theoriques[$j]->montant_contenu;?>;<?php echo $count_chq_theoriques[$j]->infos_supp;?>" />
				<span id="view_info_reg_<?php echo $count_chq_theoriques[$j]->infos_supp;?>" <?php if (trim($count_chq_theoriques[$j]->infos_supp)) {?> style="cursor:pointer"<?php }?>><?php echo number_format($count_chq_theoriques[$j]->montant_contenu, $TARIFS_NB_DECIMALES, ".", ""	)?> </span>
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
				<?php echo "&nbsp;".$MONNAIE[1];?> 
				<input name="CHK_EXIST_CHQ_<?php echo $j;?>" type="checkbox" id="CHK_EXIST_CHQ_<?php echo $j;?>" value="<?php echo $count_chq_theoriques[$j]->montant_contenu;?>" <?php if ($count_chq_theoriques[$j]->controle) {?> checked="checked"<?php }?> />
				<script type="text/javascript">
					Event.observe($("CHK_EXIST_CHQ_<?php echo $j;?>"), "click", function(evt){
						calcul_controle_caisse_chq ();
						calcul_controle_caisse ();
					}
					);
				</script>
				<div style="height:5px"></div>
			</div>
			<?php
		}
		?>
		
		<span style="float:right">
			<a href="#" id="all_coche_chq" class="doc_link_simple">Cocher</a> / 
			<a href="#" id="all_decoche_chq" class="doc_link_simple">D&eacute;cocher</a> / 
			<a href="#" id="all_inv_coche_chq" class="doc_link_simple">Inverser</a>
			</span><br />

			<script type="text/javascript">
			
			Event.observe("all_coche_chq", "click", function(evt){
				Event.stop(evt); 
				coche_line_gest_caisse ("coche", "CHQ", parseFloat($("indentation_exist_cheques").value));
				calcul_controle_caisse_chq ();
				calcul_controle_caisse ();
			});
			Event.observe("all_decoche_chq", "click", function(evt){
				Event.stop(evt); 
				coche_line_gest_caisse ("decoche", "CHQ", parseFloat($("indentation_exist_cheques").value));
				calcul_controle_caisse_chq ();
				calcul_controle_caisse ();
			});
			Event.observe("all_inv_coche_chq", "click", function(evt){
				Event.stop(evt); 
				coche_line_gest_caisse ("inv_coche", "CHQ", parseFloat($("indentation_exist_cheques").value));
				calcul_controle_caisse_chq ();
				calcul_controle_caisse ();
			});
			</script>
		<?php
		$indentation_controle_cheques = 0; 
		for ($i=0; $i<=$indentation_controle_cheques ; $i++) {
			?>
			<div class="ligne_chq" id="ligne_chq_<?php echo $i;?>">
			<div class="inner_ligne_chq" style="width:55px">&nbsp;</div>
			<input name="CHQ_<?php echo $i;?>" type="text" class="classinput_nsize" id="CHQ_<?php echo $i;?>" size="15" style="text-align:right"/> <?php echo "&nbsp;".$MONNAIE[1];?>
			<script type="text/javascript">
				Event.observe($("CHQ_<?php echo $i;?>"), "blur", function(evt){
					nummask(evt, 0, "X.X");
					Event.stop(evt); 
					calcul_controle_caisse_chq ();
					calcul_controle_caisse ();
				}
				);
			</script>
			<div style="height:5px"></div>
			</div>
			<?php
			
		}
		?>
		<div style="text-align:right; cursor:pointer; width:190px;" id="add_line_chq">Ajouter un chèque</div>
		
			<script type="text/javascript">
				Event.observe($("add_line_chq"), "click", function(evt){
					insert_new_line_chq ();
				}
				);
			</script>
			
		<input name="indentation_exist_cheques" type="hidden" id="indentation_exist_cheques" value="<?php echo (count($count_chq_theoriques) - 1);?>"/>
		<input name="indentation_controle_cheques" type="hidden" id="indentation_controle_cheques" value="<?php echo $indentation_controle_cheques;?>"/>
			<div style="width:190px; ">
				<div style="width:40px; float:left; height:25px; line-height:25px; padding-left:5px; font-weight:bolder" class="controle_color_toto">Total: </div>
			<div style="width:190px; text-align:right; height:25px; line-height:25px; padding-right:10px" class="controle_color_toto"><span id="TT_CHQ">0.00</span> <?php echo "&nbsp;".$MONNAIE[1];?></div>
			</div>
			
			<div style="height:25px">
			</div>
		</div>	
		</td>
		</tr>
		</table>
	</div>
	
	
	<div id="controle_cb"  style=" width:100%; display:none  ">
	
	
		<table width="100%" cellpadding="0" cellspacing="0" border="0">
		<tr>
			<td style=" font-weight:bolder; color:#97bf0d;"><input type="checkbox" name="pass_cb" id="pass_cb" value="1"
<?php if (!$compte_caisse->getId_compte_tpe ()) { ?> checked="checked"<?php } ?> /> 
			Ignorer cette étape
			</td>
			<td style="text-align:right">
			
			<div id="bt_etape_2" style=" cursor:pointer; font-weight:bolder; color:#97bf0d;" >
				<span style="padding-right:80px">&gt;&gt;&gt; Etape suivante</span> 
			</div>
			</td>
		</tr>
		<tr>
			<td><br />
			<br />
			
			<div style="width:350px;">
			Le <?php 
					setlocale(LC_TIME, $INFO_LOCALE);
					echo lmb_strftime("%d %B %Y", $INFO_LOCALE, strtotime(date("d M Y")))." ".date("h:i") ;
					?><br />
			<br />
					
			<br /><br /><br />
				<div>
					<span style="width:120px; float:left">Solde Théorique</span>
					<span style="width:40px; float:left ">&gt;&gt;&gt;</span> 
					<span id="toto_cb_theorique2" style="text-align:right; width:65px; float:left">
					<?php
					$montant_especes = 0;
					if (isset($totaux_theoriques[$CB_E_ID_REGMT_MODE])) {
						echo number_format($totaux_theoriques[$CB_E_ID_REGMT_MODE], $TARIFS_NB_DECIMALES, ".", ""	);
					} else {
						echo "0.00";
					}
					?>
					</span> 
					<?php
						echo "&nbsp;".$MONNAIE[1];
					?>
					<span style="padding-left:10px">(<?php
					if (isset($count_cb_theoriques)) {
						echo count($count_cb_theoriques);
					} 
					?> CB)</span>
				</div><br />
	
				<div>
					<span style="width:120px; float:left">Solde Réél</span>
					<span style="width:40px; float:left ">&gt;&gt;&gt;</span> 
					<span id="toto_cb_saisie2" style="text-align:right; width:65px; float:left ">0.00</span><?php echo "&nbsp;". $MONNAIE[1];?> <span style="padding-left:10px">(<span id="saisie_op_cb2"></span> CB)</span>
				</div><br />
	
				<div style=" font-weight:bolder;">
					<span style="width:120px; float:left">Différentiel</span>
					<span style="width:40px; float:left ">&gt;&gt;&gt;</span> 
					<span id="diff_cb2" style="text-align:right; width:65px; float:left" >0.00</span><?php echo "&nbsp;". $MONNAIE[1];?>
				</div>
			
			</div>
		
		
		</td>
		<td style="text-align:left">
		<div style="190px">
		<span class="controle_sub_title">C.B.</span><br /><br />
	
		<?php
		for ($j = 0 ; $j <count($count_cb_theoriques) ; $j++ ) {
			?>
			<div class="ligne_cb" id="ligne_exist_cb_<?php echo $j;?>">
				<div class="inner_ligne_cb"><?php echo $j+1;?>:</div>
				<input name="EXIST_CB_<?php echo $j;?>" type="hidden" id="EXIST_CB_<?php echo $j;?>" value="<?php echo $count_cb_theoriques[$j]->montant_contenu;?>;<?php echo $count_cb_theoriques[$j]->infos_supp;?>" />
				<span id="view_info_reg_<?php echo $count_cb_theoriques[$j]->infos_supp;?>" <?php if (trim($count_cb_theoriques[$j]->infos_supp)) {?> style="cursor:pointer"<?php }?>><?php echo number_format($count_cb_theoriques[$j]->montant_contenu, $TARIFS_NB_DECIMALES, ".", ""	);?> </span>
				<script type="text/javascript">
					<?php if (trim($count_cb_theoriques[$j]->infos_supp)) {?>
						Event.observe("view_info_reg_<?php echo $count_cb_theoriques[$j]->infos_supp;?>", "click",  function(evt){Event.stop(evt);
							page.traitecontent('compta_reglements_edition','compta_reglements_edition.php?ref_reglement=<?php echo $count_cb_theoriques[$j]->infos_supp;?>','true','edition_reglement');
							$("edition_reglement").show();
							$("edition_reglement_iframe").show();
						}, false);
						<?php
					}
					?>
				</script>
				<?php echo "&nbsp;". $MONNAIE[1];?> 
				<input name="CHK_EXIST_CB_<?php echo $j;?>" type="checkbox" id="CHK_EXIST_CB_<?php echo $j;?>" value="<?php echo $count_cb_theoriques[$j]->montant_contenu;?>" <?php if ($count_cb_theoriques[$j]->controle) {?> checked="checked"<?php }?> />
				<script type="text/javascript">
					Event.observe($("CHK_EXIST_CB_<?php echo $j;?>"), "click", function(evt){
						calcul_controle_caisse_cb ();
						calcul_controle_caisse ();
					}
					);
				</script>
				<div style="height:5px"></div>
			</div>
			<?php
		}
		?>
	
		<span style="float:right">
			<a href="#" id="all_coche_cb" class="doc_link_simple">Cocher</a> / 
			<a href="#" id="all_decoche_cb" class="doc_link_simple">D&eacute;cocher</a> / 
			<a href="#" id="all_inv_coche_cb" class="doc_link_simple">Inverser</a>
			</span><br />

			<script type="text/javascript">
			
			Event.observe("all_coche_cb", "click", function(evt){
				Event.stop(evt); 
				coche_line_gest_caisse ("coche", "CB", parseFloat($("indentation_exist_cb").value));
				calcul_controle_caisse_cb ();
				calcul_controle_caisse ();
			});
			Event.observe("all_decoche_cb", "click", function(evt){
				Event.stop(evt); 
				coche_line_gest_caisse ("decoche", "CB", parseFloat($("indentation_exist_cb").value));
				calcul_controle_caisse_cb ();
				calcul_controle_caisse ();
			});
			Event.observe("all_inv_coche_cb", "click", function(evt){
				Event.stop(evt); 
				coche_line_gest_caisse ("inv_coche", "CB", parseFloat($("indentation_exist_cb").value));
				calcul_controle_caisse_cb ();
				calcul_controle_caisse ();
			});
			</script>
		<?php
		$indentation_controle_cb = 0; 
		for ($i=0; $i<=$indentation_controle_cb ; $i++) {
			?>
			<div class="ligne_cb" id="ligne_cb_<?php echo $i;?>"><div class="inner_ligne_cb" style="width:55px">&nbsp;</div><input name="CB_<?php echo $i;?>" type="text" class="classinput_nsize" id="CB_<?php echo $i;?>" size="15" style="text-align:right"/> <?php echo "&nbsp;". $MONNAIE[1];?>
			<script type="text/javascript">
				Event.observe($("CB_<?php echo $i;?>"), "blur", function(evt){
				nummask(evt, 0, "X.X");
					Event.stop(evt); 
					calcul_controle_caisse_cb ();
					calcul_controle_caisse ();
				}
				);
			</script>
			<div style="height:5px"></div>
			</div>
			<?php
		}
		?>
		<div style="text-align:right; cursor:pointer; width:190px;" id="add_line_cb">Ajouter une CB</div>
		
			<script type="text/javascript">
				Event.observe($("add_line_cb"), "click", function(evt){
					insert_new_line_cb ();
				}
				);
			</script>
			
		<input name="indentation_exist_cb" type="hidden" id="indentation_exist_cb" value="<?php echo (count($count_cb_theoriques) - 1);?>"/>
		<input name="indentation_controle_cb" type="hidden" id="indentation_controle_cb" value="<?php echo $indentation_controle_cb;?>"/>
		<div style="width:190px; ">
			<div style="width:80px; float:left; height:25px; line-height:25px; padding-left:5px; font-weight:bolder" class="controle_color_toto">Total: </div>
			<div style="width:190px; text-align:right; height:25px; line-height:25px; padding-right:10px" class="controle_color_toto"><span id="TT_CB">0.00</span> <?php echo "&nbsp;". $MONNAIE[1];?></div>
		</div>
	
		<div style="height:25px">
		</div>
		</div>
	
		</td>
		</tr>
		</table>
	</div>
	
	<div  id="controle_validation"  style="width:100%; display:none  ">
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
			<span class="controle_sub_title">
			Validation
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
					<td colspan="2" align="center" valign="middle" class="line_compta_bottom_rigth">
					<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-carte_bancaire.gif"/>		</td>
					<td valign="middle" class="line_compta_bottom" align="center">
					<div style="width:75px; height:35px; line-height:35px; font-weight:bolder;">TOTAL</div>
					</td>
				</tr>
				<tr>
					<td height="35" valign="middle" class="line_compta_bottom_rigth">
					<div style="width:135px; height:35px; line-height:35px;">Total th&eacute;orique</div>		</td>
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
					<td height="35" align="right" valign="middle" class="line_compta_bottom">
					<div style="width:75px; height:35px; line-height:35px;">
					<span id="toto_cb_theorique"><?php
					if (isset($totaux_theoriques[$CB_E_ID_REGMT_MODE]) && $totaux_theoriques[$CB_E_ID_REGMT_MODE]) {
						echo number_format($totaux_theoriques[$CB_E_ID_REGMT_MODE], $TARIFS_NB_DECIMALES, ".", ""	);
					} else {
						echo "0.00";
					}
					?></span><?php
						echo "&nbsp;". $MONNAIE[1];
					?>
					</div>		</td>
					<td height="35" valign="middle" class="line_compta_bottom_rigth">
					<div style="width:35px; height:35px; line-height:35px;">
					<div style="padding-left:10px">
					(<?php
					if (isset($count_cb_theoriques)) {
						echo count($count_cb_theoriques);
					}
					?>)</div>
					</div>
					</td>
					<td valign="middle" class="line_compta_bottom" align="right">
					<div style="width:75px; height:35px; line-height:35px; padding-right:10px; font-weight:bolder;">
					<span id="toto_theo"></span><?php echo "&nbsp;". $MONNAIE[1];?>		</div>
					</td>
				</tr>
				<tr>
					<td height="35" valign="middle" class="line_compta_bottom_rigth">
					<div style="width:135px; height:35px; line-height:35px;">Total contrôle</div>		</td>
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
					<td height="35" align="right" valign="middle" class="line_compta_bottom">
					<div style="width:75px; height:35px; line-height:35px;">
					<span id="toto_cb_saisie"></span><?php echo "&nbsp;". $MONNAIE[1];?>		</div>		</td>
					<td height="35" valign="middle" class="line_compta_bottom_rigth">
					<div style="width:35px; height:35px; line-height:35px;">
					<span style="padding-left:10px">(<span id="saisie_op_cb"></span>)</span></div>		</td>
					<td valign="middle" class="line_compta_bottom" align="right">
					<div style="width:75px; height:35px; line-height:35px; padding-right:10px; font-weight:bolder;">
					<span id="toto_saisie"></span><?php echo "&nbsp;". $MONNAIE[1];?>		</div>
					
					</td>
				</tr>
				<tr>
					<td height="35" valign="middle" class="line_compta_right">
					<div style="width:75px; height:35px; line-height:35px; font-weight:bolder">Différence</div>		</td>
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
					<td height="35" valign="middle" align="right">
					<div style="width:75px; height:35px; line-height:35px; font-weight:bolder;">
					<span id="diff_cb"></span><?php echo "&nbsp;". $MONNAIE[1];?>		</div>		</td>
					<td height="35" valign="middle" class="line_compta_right"></td>
					<td valign="middle" align="right">
					<div style="width:75px; height:35px; line-height:35px; padding-right:10px; font-weight:bolder;">
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
			<input type="hidden" value="0" id="montant_erreur_esp" name="montant_erreur_esp" />
			<input type="hidden" value="0" id="montant_erreur_chq" name="montant_erreur_chq" />
			<input type="hidden" value="0" id="montant_erreur_cb" name="montant_erreur_cb" />
			<input type="hidden" value="0" id="montant_especes" name="montant_especes" />
			
			
			<input type="hidden" value="0" id="montant_controle_esp" name="montant_controle_esp" />
			<input type="hidden" value="0" id="montant_controle_chq" name="montant_controle_chq" />
			<input type="hidden" value="0" id="montant_controle_cb" name="montant_controle_cb" />
			<input type="hidden" value="0" id="montant_theorique" name="montant_theorique" />
			<input type="hidden" value="0" id="montant_controle" name="montant_controle" />
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




Event.observe($("chemin_etape_0_2"), "click", function(evt){Event.stop(evt); step_menu_controle ('controle_especes', 'chemin_etape_0', array_menu_v_controle);});
Event.observe($("chemin_etape_0_3"), "click", function(evt){Event.stop(evt);  step_menu_controle ('controle_especes', 'chemin_etape_0', array_menu_v_controle);});

Event.observe($("bt_etape_0"), "click", function(evt){Event.stop(evt);  step_menu_controle ('controle_cheques', 'chemin_etape_1', array_menu_v_controle);});

Event.observe($("chemin_etape_1_2"), "click", function(evt){Event.stop(evt);  step_menu_controle ('controle_cheques', 'chemin_etape_1', array_menu_v_controle);});
Event.observe($("chemin_etape_1_3"), "click", function(evt){Event.stop(evt); step_menu_controle ('controle_cheques', 'chemin_etape_1', array_menu_v_controle);});

Event.observe($("bt_etape_1"), "click", function(evt){ Event.stop(evt);

<?php if ($compte_caisse->getId_compte_tpe ()) { ?> 
step_menu_controle ('controle_cb', 'chemin_etape_2', array_menu_v_controle);
<?php } else {?>
step_menu_controle ('controle_validation', 'chemin_etape_3', array_menu_v_controle);
<?php } ?>

});

<?php if ($compte_caisse->getId_compte_tpe ()) { ?>
Event.observe($("chemin_etape_2_2"), "click", function(evt){Event.stop(evt); step_menu_controle ('controle_cb', 'chemin_etape_2', array_menu_v_controle);});
Event.observe($("chemin_etape_2_3"), "click", function(evt){Event.stop(evt); step_menu_controle ('controle_cb', 'chemin_etape_2', array_menu_v_controle);});

Event.observe($("bt_etape_2"), "click", function(evt){Event.stop(evt); step_menu_controle ('controle_validation', 'chemin_etape_3', array_menu_v_controle);});
<?php } ?>
Event.observe($("chemin_etape_3_2"), "click", function(evt){Event.stop(evt); step_menu_controle ('controle_validation', 'chemin_etape_3', array_menu_v_controle);});
Event.observe($("chemin_etape_3_3"), "click", function(evt){Event.stop(evt); step_menu_controle ('controle_validation', 'chemin_etape_3', array_menu_v_controle);});

Event.observe($("bt_etape_3"), "click", function(evt){Event.stop(evt); $("controle_caisse_create").submit();});


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
			
			calcul_controle_caisse_esp (array_especes);
			step_menu_controle ('controle_especes', 'chemin_etape_0', array_menu_v_controle);
		}
		);
		Event.observe($("ESP_"+array_especes[i].replace(".", "")), "keypress", function(evt){
			nummask(evt, 0, "X");
			
			next_if_Key_RETURN (evt);
			calcul_controle_caisse_esp (array_especes);
			step_menu_controle ('controle_especes', 'chemin_etape_0', array_menu_v_controle);
		}
		);
	}


Event.observe($("pass_esp"), "click", function(evt){
		calcul_controle_caisse_esp (array_especes);
		step_menu_controle ('controle_especes', 'chemin_etape_0', array_menu_v_controle);
}
);

Event.observe($("pass_chq"), "click", function(evt){
		calcul_controle_caisse_chq ();
		step_menu_controle ('controle_cheques', 'chemin_etape_1', array_menu_v_controle);
}
);

Event.observe($("pass_cb"), "click", function(evt){
		calcul_controle_caisse_cb ();
		step_menu_controle ('controle_cb', 'chemin_etape_2', array_menu_v_controle);
}
);


calcul_controle_caisse_esp (array_especes);
calcul_controle_caisse_chq ();
calcul_controle_caisse_cb ();
step_menu_controle ('controle_especes', 'chemin_etape_0', array_menu_v_controle);

centrage_element("edition_reglement");
centrage_element("edition_reglement_iframe");

Event.observe(window, "resize", function(evt){
centrage_element("edition_reglement");
centrage_element("edition_reglement_iframe");
});
//on masque le chargement
H_loading();
</SCRIPT>