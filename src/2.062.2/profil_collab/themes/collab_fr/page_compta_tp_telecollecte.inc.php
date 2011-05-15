<?php

// *************************************************************************************************************
// telecollecte de tp
// *************************************************************************************************************

// Variables nécessaires à l"affichage
$page_variables = array ();
check_page_variables ($page_variables);

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

?>
<script type="text/javascript">

array_menu_v_telecollecte	=	new Array();
array_menu_v_telecollecte[0] 	=	new Array('telecollecte_date', 'chemin_etape_0');
array_menu_v_telecollecte[3] 	=	new Array('telecollecte_cb', 'chemin_etape_1');
array_menu_v_telecollecte[4] 	=	new Array('telecollecte_validation', 'chemin_etape_2');


	
</script>
<div class="emarge"><br />

<iframe frameborder="0" scrolling="no" src="about:_blank" id="edition_reglement_iframe" class="edition_reglement_iframe" style="display:none"></iframe>
<div id="edition_reglement" class="edition_reglement" style="display:none">
</div>
<span style="float:right"><br />
<a  href="#" id="link_retour_tp" style="float:right" class="common_link">retour au tableau de bord</a>
</span>
<script type="text/javascript">
Event.observe("link_retour_tp", "click",  function(evt){Event.stop(evt); page.verify('compta_gestion2_terminaux','compta_gestion2_terminaux.php?<?php echo $retour_var;?>','true','sub_content');}, false);
</script>
<div class="titre" style="width:60%; padding-left:140px">Télécollecte <?php echo $compte_tp->getLib_tp(); ?>
</div>


<div class="emarge" style="text-align:right" >
<div  id="corps_gestion_tps">
<table width="950px" height="350px" border="0" align="right" cellpadding="0" cellspacing="0" >
	<tr>
	<td rowspan="2" style="width:50px; height:50px; background-color:#FFFFFF">
		<div style="position:relative; top:-35px; left:-35px; width:105px; border:1px solid #999999; background-color:#FFFFFF; text-align:center">
		<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/ico_carte.gif" />				</div>
		<span style="width:35px">
		<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="50px" height="20px" id="imgsizeform"/>				</span>			
	</td>
	<td colspan="2" style="width:85%; background-color:#FFFFFF" >
	
	<br />
	<br />
	<br />
		
	<form action="compta_tp_telecollecte_create.php" target="formFrame" method="post" name="tp_telecollecte_create" id="tp_telecollecte_create">
	<div >
		<input id="id_compte_tp" name="id_compte_tp"  value="<?php echo $compte_tp->getId_compte_tp(); ?>"  type="hidden">
		<input id="tp_type" name="tp_type"  value="<?php echo $compte_tp->getTp_type(); ?>"  type="hidden">
		<input id="com_ope" name="com_ope"  value="<?php echo $compte_tp->getcom_ope(); ?>"  type="hidden">
		<input id="com_var" name="com_var"  value="<?php echo $compte_tp->getcom_var(); ?>"  type="hidden">
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
				<td style="width:6%"  >&nbsp;</td>
				<td style="width:2%">&nbsp;</td>
			</tr>
			<tr>
				<td colspan="3" class="chemin_texte_choisi" style="width:14%" id="chemin_etape_0_3">Date</td>
				<td colspan="3" class="chemin_texte_gris" style="width:14%" id="chemin_etape_1_3">CB</td>
				<td colspan="3" class="chemin_texte_gris" style="width:14%" id="chemin_etape_2_3">Validation</td>
				<td style="width:2%"></td>
				</tr>
		</table>
		<br />
	</div>
	
	
	<div id="telecollecte_date">
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
			<td><br />
<br />

			<div style="width:590px;">
			
			<br />
			<br />
				<div>
					<span style="width:180px; float:left; font-weight:bolder">Date de la télécollecte</span>
					<span style="width:40px; float:left ">&gt;&gt;&gt;</span> 
					<input type="text" id="date_telecollecte" name="date_telecollecte" value="<?php 
					echo date("d-m-Y")." ".date("H:i") ;
					?>" /> <span>(format jj-mm-AAAA HH:mm)</span>
				</div><br />
	
			<br />
			</div>
			</td>
			<td align="left">
			</td>
		</tr>
		</table>
	
	
	</div>
	
	
	
	
	
	
	
	<div id="telecollecte_cb"  style=" width:100%; display:none  ">
	
	
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
			<td><br />
			<br />
			
			<div style="width:350px;">
			<br /><br /><br />
				<div>
					<span style="width:120px; float:left">Solde Théorique</span>
					<span style="width:40px; float:left ">&gt;&gt;&gt;</span> 
					<span id="toto_cb_theorique2" style="text-align:right; width:65px; float:left">
					<?php
					if (isset($totaux_theoriques)) {
						echo number_format($totaux_theoriques, $TARIFS_NB_DECIMALES, ".", ""	);
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
					<span style="width:120px; float:left">Solde télécollecté</span>
					<span style="width:40px; float:left ">&gt;&gt;&gt;</span> 
					<span id="toto_cb_saisie2" style="text-align:right; width:65px; float:left ">0.00</span><?php echo "&nbsp;". $MONNAIE[1];?> <span style="padding-left:10px">(<span id="saisie_op_cb2"></span> CB)</span>
				</div><br />
	
			
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
				<input name="EXIST_CB_<?php echo $j;?>" type="hidden" id="EXIST_CB_<?php echo $j;?>" value="<?php echo $count_cb_theoriques[$j]->montant_contenu;?>;<?php echo $count_cb_theoriques[$j]->infos_supp;?>;<?php echo $count_cb_theoriques[$j]->date_reglement;?>" />
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
				<input name="CHK_EXIST_CB_<?php echo $j;?>" type="checkbox" id="CHK_EXIST_CB_<?php echo $j;?>" value="<?php echo $count_cb_theoriques[$j]->montant_contenu;?>" <?php if (strtotime($count_cb_theoriques[$j]->date_reglement) <= time()) {?> checked="checked"<?php }?> />
				<script type="text/javascript">
					Event.observe($("CHK_EXIST_CB_<?php echo $j;?>"), "click", function(evt){
						calcul_telecollecte_tp_cb ();
						calcul_telecollecte_tp ();
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
				coche_line_gest_tp ("coche", "CB", parseFloat($("indentation_exist_cb").value));
				calcul_telecollecte_tp_cb ();
				calcul_telecollecte_tp ();
			});
			Event.observe("all_decoche_cb", "click", function(evt){
				Event.stop(evt); 
				coche_line_gest_tp ("decoche", "CB", parseFloat($("indentation_exist_cb").value));
				calcul_telecollecte_tp_cb ();
				calcul_telecollecte_tp ();
			});
			Event.observe("all_inv_coche_cb", "click", function(evt){
				Event.stop(evt); 
				coche_line_gest_tp ("inv_coche", "CB", parseFloat($("indentation_exist_cb").value));
				calcul_telecollecte_tp_cb ();
				calcul_telecollecte_tp ();
			});
			</script>
		<?php
		$indentation_telecollecte_cb = 0; 
		for ($i=0; $i<=$indentation_telecollecte_cb ; $i++) {
			?>
			<div class="ligne_cb" id="ligne_cb_<?php echo $i;?>"><div class="inner_ligne_cb" style="width:55px">&nbsp;</div><input name="CB_<?php echo $i;?>" type="text" class="classinput_nsize" id="CB_<?php echo $i;?>" size="15" style="text-align:right"/> <?php echo "&nbsp;". $MONNAIE[1];?>
			<script type="text/javascript">
				Event.observe($("CB_<?php echo $i;?>"), "blur", function(evt){
				nummask(evt, 0, "X.X");
					Event.stop(evt); 
					calcul_telecollecte_tp_cb ();
					calcul_telecollecte_tp ();
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
					insert_new_line_tp_cb ();
				}
				);
			</script>
			
		<input name="indentation_exist_cb" type="hidden" id="indentation_exist_cb" value="<?php echo (count($count_cb_theoriques) - 1);?>"/>
		<input name="indentation_telecollecte_cb" type="hidden" id="indentation_telecollecte_cb" value="<?php echo $indentation_telecollecte_cb;?>"/>
		<div style="width:190px; ">
			<div style="width:80px; float:left; height:25px; line-height:25px; padding-left:5px; font-weight:bolder" class="telecollecte_color_toto">Total: </div>
			<div style="width:190px; text-align:right; height:25px; line-height:25px; padding-right:10px" class="telecollecte_color_toto"><span id="TT_CB">0.00</span> <?php echo "&nbsp;". $MONNAIE[1];?></div>
		</div>
	
		<div style="height:25px">
		</div>
		</div>
	
		</td>
		</tr>
		</table>
	</div>
	
	<div  id="telecollecte_validation"  style="width:100%; display:none  ">
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
			<div style="text-align:right; width:380px"><span id="aff_date_telecollecte" style="width:180px; float:right; text-align:right"></span>
			<span style="width:190px; float:left; text-align:left; font-weight:bolder">Date: </span> <br />
			<span style="width:290px; float:left; text-align:left; font-weight:bolder">Nombre d'opérations: </span> <span id="aff_nombre_ope" style="width:80px; text-align:right"></span><br />
			<span style="width:290px; float:left; text-align:left; font-weight:bolder">Montant total: </span> <span id="aff_montant_total" style="width:80px; text-align:right"></span><?php echo "&nbsp;".$MONNAIE[1];?><br />
			<span style="width:290px; float:left; text-align:left; font-weight:bolder">Montant de la commission bancaire: </span> <span id="aff_montant_commission" style="width:80px; text-align:right"></span><?php echo "&nbsp;".$MONNAIE[1];?><br />
			<span style="width:290px; float:left; text-align:left; font-weight:bolder">Montant tranféré sur le compte bancaire: </span> <span id="aff_montant_transfere" style="width:80px; text-align:right"></span><?php echo "&nbsp;".$MONNAIE[1];?><br />
			<br />
			</div>
			<br />
			<span style="font-weight:bolder">Informations:</span>   <span id="commentaire_add" style="color:#FF0000"></span><br />
			
			<textarea name="commentaire" rows="6" class="classinput_xsize" id="commentaire" style=" width:800px"></textarea>

			<div style="text-align:right">
			<img id="bt_etape_2" style=" cursor:pointer; font-weight:bolder; color:#97bf0d; " src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-valider.gif" />
			</div>
			</div>
			<br />
			<br />
			<input type="hidden" value="0" id="montant_total" name="montant_total" />
			<input type="hidden" value="0" id="montant_commission" name="montant_commission" />
			<input type="hidden" value="0" id="montant_transfere" name="montant_transfere" />
			<input type="hidden" value="0" id="nombre_ope" name="nombre_ope" />
			
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




Event.observe($("chemin_etape_0_2"), "click", function(evt){Event.stop(evt); step_menu_telecollecte ('telecollecte_date', 'chemin_etape_0', array_menu_v_telecollecte);});
Event.observe($("chemin_etape_0_3"), "click", function(evt){Event.stop(evt);  step_menu_telecollecte ('telecollecte_date', 'chemin_etape_0', array_menu_v_telecollecte);});

Event.observe($("bt_etape_0"), "click", function(evt){Event.stop(evt);  step_menu_telecollecte ('telecollecte_cb', 'chemin_etape_1', array_menu_v_telecollecte);});

Event.observe($("chemin_etape_1_2"), "click", function(evt){Event.stop(evt);  step_menu_telecollecte ('telecollecte_cb', 'chemin_etape_1', array_menu_v_telecollecte);});
Event.observe($("chemin_etape_1_3"), "click", function(evt){Event.stop(evt); step_menu_telecollecte ('telecollecte_cb', 'chemin_etape_1', array_menu_v_telecollecte);});

Event.observe($("bt_etape_1"), "click", function(evt){ Event.stop(evt);step_menu_telecollecte ('telecollecte_validation', 'chemin_etape_2', array_menu_v_telecollecte);
});

Event.observe($("chemin_etape_2_2"), "click", function(evt){Event.stop(evt); step_menu_telecollecte ('telecollecte_validation', 'chemin_etape_2', array_menu_v_telecollecte);});
Event.observe($("chemin_etape_2_3"), "click", function(evt){Event.stop(evt); step_menu_telecollecte ('telecollecte_validation', 'chemin_etape_2', array_menu_v_telecollecte);});


Event.observe($("bt_etape_2"), "click", function(evt){Event.stop(evt); $("tp_telecollecte_create").submit();});


calcul_telecollecte_tp_cb ();
step_menu_telecollecte ('telecollecte_date', 'chemin_etape_0', array_menu_v_telecollecte);

centrage_element("edition_reglement");
centrage_element("edition_reglement_iframe");

Event.observe(window, "resize", function(evt){
centrage_element("edition_reglement");
centrage_element("edition_reglement_iframe");
});
//on masque le chargement
H_loading();
</SCRIPT>